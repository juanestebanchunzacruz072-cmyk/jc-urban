<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Subcategoria extends Model
{
    protected $table = 'subcategorias';

    protected $fillable = ['nombre', 'id_categoria', 'activo'];

    protected function casts(): array
    {
        return ['activo' => 'boolean'];
    }

    /** Categoría padre. */
    public function categoria(): BelongsTo
    {
        return $this->belongsTo(Categoria::class, 'id_categoria');
    }

    /** Productos de esta subcategoría. */
    public function productos(): HasMany
    {
        return $this->hasMany(Producto::class, 'id_subcategoria');
    }
}
