<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UsuarioAdminController extends Controller
{
    /** Lista todos los clientes registrados (HU-23). */
    public function index(Request $request): View
    {
        $usuariosQuery = User::where('id_rol', 2)
            ->orderBy('name');

        // Búsqueda por nombre con LIKE
        if ($request->filled('buscar')) {
            $termino = '%'.$request->buscar.'%';
            $usuariosQuery->where(function ($q) use ($termino) {
                $q->where('name', 'LIKE', $termino)
                    ->orWhere('apellido', 'LIKE', $termino)
                    ->orWhere('email', 'LIKE', $termino);
            });
        }

        $usuarios = $usuariosQuery->paginate(20)->withQueryString();

        return view('admin.usuarios.index', compact('usuarios'));
    }
}
