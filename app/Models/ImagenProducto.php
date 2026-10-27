<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ImagenProducto extends Model
{
    protected $table = 'imagen_producto';

    protected $fillable = ['id_producto', 'url_imagen', 'principal'];

    protected function casts(): array
    {
        return ['principal' => 'boolean'];
    }

    /** Producto al que pertenece la imagen. */
    public function producto(): BelongsTo
    {
        return $this->belongsTo(Producto::class, 'id_producto');
    }
}
