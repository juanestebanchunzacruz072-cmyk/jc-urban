<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EstadoPedido;
use App\Models\Pedido;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PedidoAdminController extends Controller
{
    /** Lista todos los pedidos con búsqueda y filtros (HU-21). */
    public function index(Request $request): View
    {
        $pedidosQuery = Pedido::with(['usuario', 'estado'])
            ->orderBy('created_at', 'desc');

        // Búsqueda por ID de pedido
        if ($request->filled('buscar')) {
            $pedidosQuery->where('id', $request->buscar);
        }

        // Filtro por fecha de inicio
        if ($request->filled('fecha_inicio')) {
            $pedidosQuery->whereDate('created_at', '>=', $request->fecha_inicio);
        }

        // Filtro por fecha de fin
        if ($request->filled('fecha_fin')) {
            $pedidosQuery->whereDate('created_at', '<=', $request->fecha_fin);
        }

        // Filtro por estado
        if ($request->filled('estado')) {
            $pedidosQuery->where('id_estado', $request->estado);
        }

        $pedidos = $pedidosQuery->paginate(20)->withQueryString();
        $estados = EstadoPedido::all();

        return view('admin.pedidos.index', compact('pedidos', 'estados'));
    }

    /** Muestra el detalle completo de un pedido (HU-21). */
    public function detalle(int $id): View
    {
        $pedido = Pedido::with(['usuario', 'estado', 'detalles.producto.imagenes', 'detalles.producto.marca'])
            ->findOrFail($id);
        $estados = EstadoPedido::all();

        return view('admin.pedidos.detalle', compact('pedido', 'estados'));
    }

    /** Actualiza el estado de un pedido (HU-22). */
    public function cambiarEstado(Request $request, int $id): RedirectResponse
    {
        $request->validate([
            'id_estado' => 'required|exists:estado_pedido,id',
        ]);

        $pedido = Pedido::findOrFail($id);
        $pedido->update(['id_estado' => $request->id_estado]);

        return back()->with('success', 'Estado del pedido #'.$pedido->id.' actualizado correctamente.');
    }
}
