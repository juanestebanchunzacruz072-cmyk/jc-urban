<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetallePedido extends Model
{
    protected $table = 'detalle_pedidos';

    protected $fillable = ['id_pedido', 'id_producto', 'cantidad', 'precio_unitario'];

    protected function casts(): array
    {
        return ['precio_unitario' => 'decimal:2'];
    }

    /** Pedido al que pertenece el detalle. */
    public function pedido(): BelongsTo
    {
        return $this->belongsTo(Pedido::class, 'id_pedido');
    }

    /** Producto del detalle. */
    public function producto(): BelongsTo
    {
        return $this->belongsTo(Producto::class, 'id_producto');
    }

    /** Subtotal de este ítem. */
    public function getSubtotalAttribute(): float
    {
        return $this->cantidad * $this->precio_unitario;
    }
}
