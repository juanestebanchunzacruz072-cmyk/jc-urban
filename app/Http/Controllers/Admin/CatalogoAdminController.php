<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use App\Models\Marca;
use App\Models\Subcategoria;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CatalogoAdminController extends Controller
{
    // ─── CATEGORÍAS ───────────────────────────────────────────────

    /** Lista las categorías (HU-20). */
    public function categoriasIndex(): View
    {
        $categorias = Categoria::withCount('productos')->orderBy('nombre')->get();

        return view('admin.catalogo.categorias', compact('categorias'));
    }

    /** Crea una nueva categoría (HU-20). */
    public function categoriaGuardar(Request $request): RedirectResponse
    {
        $request->validate([
            'nombre' => 'required|string|max:100|unique:categorias,nombre',
            'descripcion' => 'nullable|string|max:255',
        ], ['nombre.unique' => 'Ya existe una categoría con ese nombre.']);

        Categoria::create($request->only(['nombre', 'descripcion']));

        return back()->with('success', 'Categoría creada exitosamente.');
    }

    /** Actualiza una categoría (HU-20). */
    public function categoriaActualizar(Request $request, int $id): RedirectResponse
    {
        $categoria = Categoria::findOrFail($id);
        $request->validate([
            'nombre' => 'required|string|max:100|unique:categorias,nombre,'.$id,
        ], ['nombre.unique' => 'Ya existe una categoría con ese nombre.']);

        $categoria->update($request->only(['nombre', 'descripcion', 'activo']));

        return back()->with('success', 'Categoría actualizada correctamente.');
    }

    /** Activa/desactiva una categoría (HU-20). */
    public function categoriaToggle(int $id): RedirectResponse
    {
        $categoria = Categoria::findOrFail($id);
        $categoria->update(['activo' => ! $categoria->activo]);

        return back()->with('success', 'Estado de la categoría actualizado.');
    }

    // ─── SUBCATEGORÍAS ──────────────────────────────────────────────

    /** Lista las subcategorías (HU-20). */
    public function subcategoriasIndex(): View
    {
        $subcategorias = Subcategoria::with('categoria')->orderBy('nombre')->get();
        $categorias = Categoria::where('activo', true)->orderBy('nombre')->get();

        return view('admin.catalogo.subcategorias', compact('subcategorias', 'categorias'));
    }

    /** Crea una nueva subcategoría (HU-20). */
    public function subcategoriaGuardar(Request $request): RedirectResponse
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'id_categoria' => 'required|exists:categorias,id',
        ]);

        Subcategoria::create($request->only(['nombre', 'id_categoria']));

        return back()->with('success', 'Subcategoría creada exitosamente.');
    }

    /** Activa/desactiva una subcategoría (HU-20). */
    public function subcategoriaToggle(int $id): RedirectResponse
    {
        $subcategoria = Subcategoria::findOrFail($id);
        $subcategoria->update(['activo' => ! $subcategoria->activo]);

        return back()->with('success', 'Estado de la subcategoría actualizado.');
    }

    // ─── MARCAS ────────────────────────────────────────────────────

    /** Lista las marcas (HU-20). */
    public function marcasIndex(): View
    {
        $marcas = Marca::withCount('productos')->orderBy('nombre')->get();

        return view('admin.catalogo.marcas', compact('marcas'));
    }

    /** Crea una nueva marca (HU-20). */
    public function marcaGuardar(Request $request): RedirectResponse
    {
        $request->validate([
            'nombre' => 'required|string|max:100|unique:marcas,nombre',
        ], ['nombre.unique' => 'Ya existe una marca con ese nombre.']);

        Marca::create($request->only(['nombre']));

        return back()->with('success', 'Marca creada exitosamente.');
    }

    /** Actualiza una marca (HU-20). */
    public function marcaActualizar(Request $request, int $id): RedirectResponse
    {
        $marca = Marca::findOrFail($id);
        $request->validate([
            'nombre' => 'required|string|max:100|unique:marcas,nombre,'.$id,
        ], ['nombre.unique' => 'Ya existe una marca con ese nombre.']);

        $marca->update($request->only(['nombre']));

        return back()->with('success', 'Marca actualizada correctamente.');
    }

    /** Activa/desactiva una marca (HU-20). */
    public function marcaToggle(int $id): RedirectResponse
    {
        $marca = Marca::findOrFail($id);
        $marca->update(['activo' => ! $marca->activo]);

        return back()->with('success', 'Estado de la marca actualizado.');
    }
}
