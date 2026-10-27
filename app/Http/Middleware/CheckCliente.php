<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckCliente
{
    /**
     * Bloquea el acceso a rutas de cliente si el usuario no está autenticado.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! auth()->check()) {
            // Guarda la URL intentada para redirigir después del login
            session(['url_intended' => $request->fullUrl()]);

            return redirect()->route('login')
                ->with('info', 'Debes iniciar sesión para continuar.');
        }

        return $next($request);
    }
}
