<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAdmin
{
    /**
     * Bloquea el acceso a rutas admin si el usuario no tiene rol de Administrador (id_rol = 1).
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! auth()->check() || auth()->user()->id_rol !== 1) {
            return redirect()->route('catalogo.index')
                ->with('error', 'No tienes permisos para acceder al panel de administración.');
        }

        return $next($request);
    }
}
