<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pedido;
use App\Models\Producto;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /** Muestra el panel de control administrativo (HU-18). */
    public function index(): View
    {
        $totalProductos = Producto::count();
        $totalClientes = User::where('id_rol', 2)->count();
        $totalPedidos = Pedido::count();
        $valorCatalogo = Producto::sum(DB::raw('precio * stock'));
        $ingresoTotal = Pedido::sum('total');

        $productosRecientes = Producto::with(['categoria', 'subcategoria', 'imagenes'])
            ->orderBy('id', 'asc')
            ->limit(10)
            ->get();

        $pedidosRecientes = Pedido::with(['usuario', 'estado'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        $productosAgotados = Producto::where('stock', 0)->where('activo', true)->count();

        return view('admin.dashboard', compact(
            'totalProductos',
            'totalClientes',
            'totalPedidos',
            'valorCatalogo',
            'ingresoTotal',
            'productosRecientes',
            'pedidosRecientes',
            'productosAgotados',
        ));
    }
}
