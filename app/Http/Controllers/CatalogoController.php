<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CatalogoController extends Controller
{
    /** Página principal del catálogo con las 3 categorías (HU-06). */
    public function index(): View
    {
        $categorias = Categoria::where('activo', true)->get();

        return view('catalogo.index', compact('categorias'));
    }

    /** Lista productos por categoría con sus subcategorías (HU-07). */
    public function categoria(Request $request, int $id): View
    {
        $categoria = Categoria::with('subcategorias')->findOrFail($id);
        $subcategorias = $categoria->subcategorias()->where('activo', true)->get();

        $productosQuery = Producto::with(['imagenes', 'marca', 'subcategoria'])
            ->where('id_categoria', $id)
            ->where('activo', true);

        // Filtro por subcategoría si se proporciona
        if ($request->filled('subcategoria')) {
            $productosQuery->where('id_subcategoria', $request->subcategoria);
        }

        $productos = $productosQuery->orderBy('nombre')->get();

        // Productos sugeridos para "También te puede gustar" (HU-09)
        $productosRelacionados = Producto::with(['imagenes', 'marca'])
            ->where('id_categoria', $id)
            ->where('activo', true)
            ->where('stock', '>', 0)
            ->inRandomOrder()
            ->limit(6)
            ->get();

        return view('catalogo.productos', compact('categoria', 'subcategorias', 'productos', 'productosRelacionados'));
    }

    /** Ficha técnica de un producto (HU-08). */
    public function detalle(int $id): View
    {
        $producto = Producto::with(['imagenes', 'marca', 'categoria', 'subcategoria'])
            ->findOrFail($id);

        // Productos relacionados para "También te puede gustar" (HU-09)
        $productosRelacionados = Producto::with(['imagenes', 'marca'])
            ->where('id_categoria', $producto->id_categoria)
            ->where('id', '!=', $producto->id)
            ->where('activo', true)
            ->where('stock', '>', 0)
            ->inRandomOrder()
            ->limit(4)
            ->get();

        return view('catalogo.detalle', compact('producto', 'productosRelacionados'));
    }
}
