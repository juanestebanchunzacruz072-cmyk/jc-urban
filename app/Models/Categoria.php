<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Categoria extends Model
{
    protected $table = 'categorias';

    protected $fillable = ['nombre', 'descripcion', 'imagen', 'activo'];

    protected function casts(): array
    {
        return ['activo' => 'boolean'];
    }

    /** Subcategorías de esta categoría. */
    public function subcategorias(): HasMany
    {
        return $this->hasMany(Subcategoria::class, 'id_categoria');
    }

    /** Productos de esta categoría. */
    public function productos(): HasMany
    {
        return $this->hasMany(Producto::class, 'id_categoria');
    }
}
