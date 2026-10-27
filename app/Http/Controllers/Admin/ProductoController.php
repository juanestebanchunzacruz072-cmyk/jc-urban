<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use App\Models\ImagenProducto;
use App\Models\Marca;
use App\Models\Producto;
use App\Models\Subcategoria;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProductoController extends Controller
{
    /** Lista todos los productos (HU-19). */
    public function index(Request $request): View
    {
        $productosQuery = Producto::with(['marca', 'categoria', 'subcategoria', 'imagenes'])
            ->orderBy('nombre');

        // Búsqueda
        if ($request->filled('buscar')) {
            $productosQuery->where('nombre', 'LIKE', '%'.$request->buscar.'%');
        }

        // Filtro por categoría
        if ($request->filled('categoria')) {
            $productosQuery->where('id_categoria', $request->categoria);
        }

        $productos = $productosQuery->paginate(15)->withQueryString();
        $categorias = Categoria::where('activo', true)->get();

        return view('admin.productos.index', compact('productos', 'categorias'));
    }

    /** Formulario para crear un producto (HU-19). */
    public function crear(): View
    {
        $marcas = Marca::where('activo', true)->orderBy('nombre')->get();
        $categorias = Categoria::where('activo', true)->orderBy('nombre')->get();
        $subcategorias = Subcategoria::where('activo', true)->orderBy('nombre')->get();

        return view('admin.productos.crear', compact('marcas', 'categorias', 'subcategorias'));
    }

    /** Guarda un nuevo producto (HU-19). */
    public function guardar(Request $request): RedirectResponse
    {
        $request->validate([
            'nombre' => 'required|string|max:200',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'id_marca' => 'nullable|exists:marcas,id',
            'id_categoria' => 'required|exists:categorias,id',
            'id_subcategoria' => 'nullable|exists:subcategorias,id',
            'imagenes.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        $producto = Producto::create($request->only([
            'nombre', 'descripcion', 'precio', 'stock',
            'id_marca', 'id_categoria', 'id_subcategoria',
        ]));

        // Procesar imágenes subidas
        if ($request->hasFile('imagenes')) {
            $esPrimera = true;
            foreach ($request->file('imagenes') as $imagen) {
                $rutaImagen = $imagen->store('productos', 'public');
                ImagenProducto::create([
                    'id_producto' => $producto->id,
                    'url_imagen' => $rutaImagen,
                    'principal' => $esPrimera,
                ]);
                $esPrimera = false;
            }
        }

        return redirect()->route('admin.productos.index')
            ->with('success', "Producto '{$producto->nombre}' creado exitosamente.");
    }

    /** Formulario para editar un producto (HU-19). */
    public function editar(int $id): View
    {
        $producto = Producto::with('imagenes')->findOrFail($id);
        $marcas = Marca::where('activo', true)->orderBy('nombre')->get();
        $categorias = Categoria::where('activo', true)->orderBy('nombre')->get();
        $subcategorias = Subcategoria::where('activo', true)->orderBy('nombre')->get();

        return view('admin.productos.editar', compact('producto', 'marcas', 'categorias', 'subcategorias'));
    }

    /** Actualiza un producto existente (HU-19). */
    public function actualizar(Request $request, int $id): RedirectResponse
    {
        $producto = Producto::findOrFail($id);

        $request->validate([
            'nombre' => 'required|string|max:200',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'id_marca' => 'nullable|exists:marcas,id',
            'id_categoria' => 'required|exists:categorias,id',
            'id_subcategoria' => 'nullable|exists:subcategorias,id',
            'imagenes.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        $producto->update($request->only([
            'nombre', 'descripcion', 'precio', 'stock',
            'id_marca', 'id_categoria', 'id_subcategoria',
        ]));

        // Procesar nuevas imágenes
        if ($request->hasFile('imagenes')) {
            foreach ($request->file('imagenes') as $imagen) {
                $rutaImagen = $imagen->store('productos', 'public');
                ImagenProducto::create([
                    'id_producto' => $producto->id,
                    'url_imagen' => $rutaImagen,
                    'principal' => false,
                ]);
            }
        }

        return redirect()->route('admin.productos.index')
            ->with('success', "Producto '{$producto->nombre}' actualizado exitosamente.");
    }

    /** Activa o desactiva un producto (soft delete lógico) (HU-19). */
    public function toggleActivo(int $id): RedirectResponse
    {
        $producto = Producto::findOrFail($id);
        $producto->update(['activo' => ! $producto->activo]);

        $estado = $producto->activo ? 'activado' : 'desactivado';

        return back()->with('success', "Producto '{$producto->nombre}' {$estado} correctamente.");
    }

    /** Elimina un producto permanentemente (HU-19). */
    public function eliminar(int $id): RedirectResponse
    {
        $producto = Producto::findOrFail($id);
        $nombre = $producto->nombre;

        // Eliminar imágenes del storage
        foreach ($producto->imagenes as $imagen) {
            Storage::disk('public')->delete($imagen->url_imagen);
        }

        $producto->delete();

        return redirect()->route('admin.productos.index')
            ->with('success', "Producto '{$nombre}' eliminado permanentemente.");
    }

    /** Elimina una imagen individual del producto (HU-19). */
    public function eliminarImagen(int $idImagen): RedirectResponse
    {
        $imagen = ImagenProducto::findOrFail($idImagen);
        Storage::disk('public')->delete($imagen->url_imagen);
        $idProducto = $imagen->id_producto;
        $imagen->delete();

        return redirect()->route('admin.productos.editar', $idProducto)
            ->with('success', 'Imagen eliminada correctamente.');
    }
}
