<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PerfilController extends Controller
{
    /** Muestra el perfil del cliente con su historial de pedidos (HU-05, HU-17). */
    public function index(): View
    {
        $usuario = Auth::user();
        $pedidos = Pedido::with(['estado', 'detalles.producto'])
            ->where('id_usuario', $usuario->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('perfil.index', compact('usuario', 'pedidos'));
    }

    /** Actualiza dirección, barrio y ciudad del cliente (HU-05). */
    public function actualizar(Request $request): RedirectResponse
    {
        $request->validate([
            'direccion' => 'required|string|max:255',
            'barrio' => 'required|string|max:100',
            'ciudad' => 'required|string|max:100',
        ], [
            'direccion.required' => 'La dirección es obligatoria.',
            'barrio.required' => 'El barrio es obligatorio.',
            'ciudad.required' => 'La ciudad es obligatoria.',
        ]);

        Auth::user()->update([
            'direccion' => $request->direccion,
            'barrio' => $request->barrio,
            'ciudad' => $request->ciudad,
        ]);

        return back()->with('success', 'Tu información de entrega ha sido actualizada correctamente.');
    }
}
