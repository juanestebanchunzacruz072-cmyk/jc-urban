<?php

namespace App\Http\Controllers;

use App\Models\DetallePedido;
use App\Models\Pedido;
use App\Models\Producto;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    /**
     * Muestra el resumen del pedido antes de confirmar (HU-15).
     * Requiere autenticación.
     */
    public function detalle(Request $request): View|RedirectResponse
    {
        $carritoItems = session('carrito_temporal', []);

        if (empty($carritoItems)) {
            return redirect()->route('catalogo.index')
                ->with('error', 'Tu carrito está vacío. Agrega productos antes de proceder al pago.');
        }

        $productosIds = array_keys($carritoItems);
        $productos = Producto::with(['imagenes', 'marca'])
            ->whereIn('id', $productosIds)
            ->get()
            ->keyBy('id');

        $total = 0;
        $items = [];

        foreach ($carritoItems as $idProducto => $item) {
            if (isset($productos[$idProducto])) {
                $producto = $productos[$idProducto];
                $subtotal = $producto->precio * $item['cantidad'];
                $total += $subtotal;
                $items[] = [
                    'producto' => $producto,
                    'cantidad' => $item['cantidad'],
                    'subtotal' => $subtotal,
                ];
            }
        }

        $usuario = Auth::user();

        return view('checkout.detalle', compact('items', 'total', 'usuario'));
    }

    /**
     * Confirma y registra el pedido en la base de datos (HU-15, HU-16).
     */
    public function confirmar(Request $request): RedirectResponse
    {
        $carritoItems = session('carrito_temporal', []);

        if (empty($carritoItems)) {
            return redirect()->route('catalogo.index')
                ->with('error', 'Tu carrito está vacío.');
        }

        $usuario = Auth::user();

        try {
            DB::beginTransaction();

            // Calcular total y validar stock
            $total = 0;
            $detalles = [];

            foreach ($carritoItems as $idProducto => $item) {
                $producto = Producto::lockForUpdate()->find($idProducto);

                if (! $producto || ! $producto->activo) {
                    throw new \Exception("El producto '{$producto?->nombre}' ya no está disponible.");
                }

                if ($producto->stock < $item['cantidad']) {
                    throw new \Exception("Stock insuficiente para '{$producto->nombre}'. Solo quedan {$producto->stock} unidades.");
                }

                $subtotal = $producto->precio * $item['cantidad'];
                $total += $subtotal;
                $detalles[] = [
                    'producto' => $producto,
                    'cantidad' => $item['cantidad'],
                    'precio' => $producto->precio,
                ];
            }

            // Crear el pedido
            $pedido = Pedido::create([
                'id_usuario' => $usuario->id,
                'total' => $total,
                'id_estado' => 1, // Pendiente
            ]);

            // Crear detalles y reducir stock
            foreach ($detalles as $detalle) {
                DetallePedido::create([
                    'id_pedido' => $pedido->id,
                    'id_producto' => $detalle['producto']->id,
                    'cantidad' => $detalle['cantidad'],
                    'precio_unitario' => $detalle['precio'],
                ]);

                $detalle['producto']->decrement('stock', $detalle['cantidad']);
            }

            DB::commit();

            // Limpiar carrito temporal
            session()->forget('carrito_temporal');

            return redirect()->route('checkout.factura', $pedido->id)
                ->with('success', '¡Pago procesado exitosamente!');

        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Muestra la factura del pedido (HU-16).
     */
    public function factura(int $idPedido): View|RedirectResponse
    {
        $pedido = Pedido::with(['detalles.producto.imagenes', 'detalles.producto.marca', 'usuario', 'estado'])
            ->findOrFail($idPedido);

        // Solo el dueño del pedido puede ver la factura
        if ($pedido->id_usuario !== Auth::id()) {
            return redirect()->route('catalogo.index')
                ->with('error', 'No tienes permiso para ver esa factura.');
        }

        return view('checkout.factura', compact('pedido'));
    }

    /**
     * Guarda el carrito temporal desde AJAX (HU-11).
     */
    public function guardarCarritoAjax(Request $request): JsonResponse
    {
        $items = $request->input('items', []);
        session(['carrito_temporal' => $items]);

        return response()->json(['success' => true, 'message' => 'Carrito guardado.']);
    }
}
