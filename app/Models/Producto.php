<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Producto extends Model
{
    protected $table = 'productos';

    protected $fillable = [
        'nombre',
        'sku',
        'genero',
        'descripcion',
        'precio',
        'stock',
        'id_marca',
        'id_categoria',
        'id_subcategoria',
        'activo',
    ];

    protected function casts(): array
    {
        return [
            'precio' => 'decimal:2',
            'activo' => 'boolean',
        ];
    }

    /** Marca del producto. */
    public function marca(): BelongsTo
    {
        return $this->belongsTo(Marca::class, 'id_marca');
    }

    /** Categoría del producto. */
    public function categoria(): BelongsTo
    {
        return $this->belongsTo(Categoria::class, 'id_categoria');
    }

    /** Subcategoría del producto. */
    public function subcategoria(): BelongsTo
    {
        return $this->belongsTo(Subcategoria::class, 'id_subcategoria');
    }

    /** Imágenes del producto. */
    public function imagenes(): HasMany
    {
        return $this->hasMany(ImagenProducto::class, 'id_producto');
    }

    /** Imagen principal del producto. */
    public function imagenPrincipal(): ?ImagenProducto
    {
        return $this->imagenes()->where('principal', true)->first()
            ?? $this->imagenes()->first();
    }

    /** Productos activos con stock disponible. */
    public function scopeActivo($query): mixed
    {
        return $query->where('activo', true);
    }

    /** Productos con stock disponible. */
    public function scopeConStock($query): mixed
    {
        return $query->where('stock', '>', 0);
    }
}
