<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EstadoPedido extends Model
{
    protected $table = 'estado_pedido';

    protected $fillable = ['nombre'];

    /** Pedidos con este estado. */
    public function pedidos(): HasMany
    {
        return $this->hasMany(Pedido::class, 'id_estado');
    }
}
