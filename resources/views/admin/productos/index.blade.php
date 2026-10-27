@extends('layouts.admin')

@@section('title', 'Inventario de Productos')
@section('page_title', 'INVENTARIO DE PRODUCTOS')

@section('header_action_button')
    <a href="{{ route('catalogo.index') }}" class="btn-white-action">
        <i class="bi bi-shop"></i>
        <span>VER TIENDA</span>
    </a>
@endsection

@section('content')
<!-- Tarjeta Filtros de Búsqueda (Exacto al Screenshot 2) -->
<div class="white-box-card mb-4 mt-0">
    <div class="filter-card-title">
        <i class="bi bi-funnel"></i> FILTROS DE BÚSQUEDA
    </div>
    <form action="{{ route('admin.productos.index') }}" method="GET">
        <div class="row g-3">
            <div class="col-md-3">
                <label class="form-label-jc">BUSCAR PRODUCTO</label>
                <input type="text"
                       name="buscar"
                       value="{{ request('buscar') }}"
                       class="form-control-jc"
                       placeholder="Nombre o referencia...">
            </div>
            <div class="col-md-3">
                <label class="form-label-jc">CATEGORÍA</label>
                <select name="categoria" class="form-select-jc">
                    <option value="">Todas las categorías</option>
                    @foreach($categorias as $cat)
                        <option value="{{ $cat->id }}" {{ request('categoria') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label-jc">SUBCATEGORÍA</label>
                <select name="subcategoria" class="form-select-jc">
                    <option value="">Todas las subcategorías</option>
                    @foreach($subcategorias as $subcat)
                        <option value="{{ $subcat->id }}" {{ request('subcategoria') == $subcat->id ? 'selected' : '' }}>
                            {{ $subcat->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label-jc">MARCA</label>
                <select name="marca" class="form-select-jc">
                    <option value="">Todas las marcas</option>
                    @foreach($marcas as $m)
                        <option value="{{ $m->id }}" {{ request('marca') == $m->id ? 'selected' : '' }}>
                            {{ $m->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6 d-flex gap-2">
                <button type="submit" class="btn-gold-action w-100 justify-content-center">
                    <i class="bi bi-search"></i> FILTRAR
                </button>
                <a href="{{ route('admin.productos.index') }}" class="btn-white-action w-100 justify-content-center">
                    <i class="bi bi-x-circle"></i> LIMPIAR
                </a>
            </div>
        </div>
    </form>
</div>

<!-- Listado Completo de Productos -->
<div class="d-flex justify-content-between align-items-center mb-3">
    <div class="box-card-title" style="color: #64748b; font-size: 0.95rem;">
        LISTADO COMPLETO
    </div>
    <button type="button" class="btn-gold-action" data-bs-toggle="modal" data-bs-target="#modalAgregarProducto">
        <i class="bi bi-plus-lg"></i> AGREGAR PRODUCTO
    </button>
</div>

<div class="white-box-card mt-0">
    <div class="table-responsive">
        <table class="jc-admin-table">
            <thead>
                <tr>
                    <th style="width: 70px;">ID</th>
                    <th style="width: 75px;">IMAGEN</th>
                    <th>NOMBRE / REFERENCIA</th>
                    <th>CATEGORÍA</th>
                    <th>PRECIO</th>
                    <th>STOCK</th>
                    <th>ESTADO</th>
                    <th class="text-end" style="width: 140px;">ACCIONES</th>
                </tr>
            </thead>
            <tbody>
                @forelse($productos as $prod)
                    @php
                        $imgObj = $prod->imagenPrincipal();
                        $imgUrl = 'https://images.unsplash.com/photo-1522335789203-aabd1fc54bc9?auto=format&fit=crop&w=150&q=80';
                        if ($imgObj) {
                            $imgUrl = str_starts_with($imgObj->url_imagen, 'http')
                                ? $imgObj->url_imagen
                                : asset('storage/' . $imgObj->url_imagen);
                        }
                    @endphp
                    <tr>
                        <td class="fw-bold text-muted">
                            #{{ $prod->id }}
                        </td>
                        <td>
                            <img src="{{ $imgUrl }}"
                                 alt="{{ $prod->nombre }}"
                                 class="rounded"
                                 style="width: 44px; height: 44px; object-fit: cover; background: #f1f5f9;">
                        </td>
                        <td>
                            <div class="fw-bold text-dark fs-6">{{ $prod->nombre }}</div>
                            <div class="text-muted small" style="font-size: 0.78rem;">Ref: {{ $prod->sku ?? $prod->id }}</div>
                        </td>
                        <td>
                            <div class="text-dark small fw-semibold">
                                {{ $prod->categoria?->nombre }} &gt; {{ $prod->subcategoria?->nombre ?? 'General' }}
                                @if($prod->genero)
                                    ({{ $prod->genero }})
                                @endif
                            </div>
                            <div class="text-muted small" style="font-size: 0.76rem;">{{ $prod->marca?->nombre ?? 'Sin marca' }}</div>
                        </td>
                        <td class="fw-bold text-dark">
                            $ {{ number_format($prod->precio, 0, ',', '.') }}
                        </td>
                        <td class="fw-bold text-dark">
                            {{ $prod->stock }}
                        </td>
                        <td>
                            <form action="{{ route('admin.productos.toggle', $prod->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="border-0 bg-transparent p-0">
                                    <span class="pill-status {{ $prod->activo ? 'pill-status-active' : 'pill-status-inactive' }}" style="cursor: pointer;">
                                        {{ $prod->activo ? 'ACTIVO' : 'INACTIVO' }}
                                    </span>
                                </button>
                            </form>
                        </td>
                        <td class="text-end">
                            <div class="d-inline-flex gap-2">
                                <button type="button"
                                        class="btn-sq btn-sq-gold"
                                        data-bs-toggle="modal"
                                        data-bs-target="#modalEditarProducto{{ $prod->id }}"
                                        title="Editar">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                                <form action="{{ route('admin.productos.toggle', $prod->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn-sq {{ $prod->activo ? 'btn-sq-slate' : 'btn-sq-gold' }}" title="{{ $prod->activo ? 'Desactivar' : 'Activar' }}">
                                        <i class="bi {{ $prod->activo ? 'bi-eye' : 'bi-eye-slash' }}"></i>
                                    </button>
                                </form>
                                <form action="{{ route('admin.productos.eliminar', $prod->id) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Seguro que deseas eliminar este producto?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-sq btn-sq-red" title="Eliminar">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>

                    <!-- ═══════════════════════════════════════════════════════════
                         MODAL EDITAR PRODUCTO (EXACTO AL SCREENSHOT 4)
                    ═══════════════════════════════════════════════════════════ -->
                    <div class="modal fade" id="modalEditarProducto{{ $prod->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered">
                            <div class="modal-content modal-content-jc">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h3 class="modal-title-jc">EDITAR PRODUCTO</h3>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="{{ route('admin.productos.actualizar', $prod->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')

                                    <div class="mb-3">
                                        <label class="form-label-jc">Nombre del Producto *</label>
                                        <input type="text" name="nombre" class="form-control-jc" value="{{ $prod->nombre }}" required>
                                    </div>

                                    <div class="row g-3 mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label-jc">Referencia / SKU *</label>
                                            <input type="text" name="sku" class="form-control-jc" value="{{ $prod->sku ?? 'REF-'.$prod->id }}" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label-jc">Precio (COP) *</label>
                                            <input type="number" name="precio" class="form-control-jc" value="{{ $prod->precio }}" required>
                                        </div>
                                    </div>

                                    <div class="row g-3 mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label-jc">Categoría *</label>
                                            <select name="id_categoria" class="form-select-jc" required>
                                                @foreach($categorias as $cat)
                                                    <option value="{{ $cat->id }}" {{ $prod->id_categoria == $cat->id ? 'selected' : '' }}>
                                                        {{ $cat->nombre }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label-jc">Subcategoría</label>
                                            <select name="id_subcategoria" class="form-select-jc">
                                                <option value="">Selecciona subcategoría...</option>
                                                @foreach(\App\Models\Subcategoria::where('activo', true)->get() as $sub)
                                                    <option value="{{ $sub->id }}" {{ $prod->id_subcategoria == $sub->id ? 'selected' : '' }}>
                                                        {{ $sub->nombre }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row g-3 mb-3">
                                        <div class="col-md-6">
                                            <div class="d-flex justify-content-between">
                                                <label class="form-label-jc">Marca *</label>
                                                <span class="small text-muted"><input type="checkbox" checked disabled> Mostrar todas</span>
                                            </div>
                                            <select name="id_marca" class="form-select-jc">
                                                <option value="">Seleccione una marca</option>
                                                @foreach(\App\Models\Marca::where('activo', true)->get() as $m)
                                                    <option value="{{ $m->id }}" {{ $prod->id_marca == $m->id ? 'selected' : '' }}>
                                                        {{ $m->nombre }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label-jc">Género *</label>
                                            <select name="genero" class="form-select-jc">
                                                <option value="Hombre" {{ $prod->genero == 'Hombre' ? 'selected' : '' }}>Hombre</option>
                                                <option value="Mujer" {{ $prod->genero == 'Mujer' ? 'selected' : '' }}>Mujer</option>
                                                <option value="Unisex (Ambos)" {{ $prod->genero == 'Unisex (Ambos)' ? 'selected' : '' }}>Unisex (Ambos)</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label-jc">Stock *</label>
                                        <input type="number" name="stock" class="form-control-jc" value="{{ $prod->stock }}" min="0" required>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label-jc">Descripción</label>
                                        <textarea name="descripcion" class="form-control-jc" rows="4">{{ $prod->descripcion }}</textarea>
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label-jc">Imagen Principal (Dejar vacío para no cambiar)</label>
                                        <input type="file" name="imagen_principal" class="form-control-jc" accept="image/*">
                                    </div>

                                    <button type="submit" class="btn-modal-submit">
                                        <i class="bi bi-box-arrow-down fs-5"></i> ACTUALIZAR PRODUCTO
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <tr>
                        <td colspan="9" class="text-center py-4 text-muted">
                            No se encontraron productos registrados.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $productos->links() }}
    </div>
</div>

<!-- ═══════════════════════════════════════════════════════════
     MODAL AGREGAR PRODUCTO (EXACTO AL SCREENSHOT 3)
═══════════════════════════════════════════════════════════ -->
<div class="modal fade" id="modalAgregarProducto" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content modal-content-jc">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h3 class="modal-title-jc">AGREGAR PRODUCTO</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.productos.guardar') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label class="form-label-jc">Nombre del Producto *</label>
                    <input type="text" name="nombre" class="form-control-jc" placeholder="Ej: Rolex Submariner Date" required>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label-jc">Referencia / SKU *</label>
                        <input type="text" name="sku" class="form-control-jc" placeholder="Ej: REF-12345" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label-jc">Precio (COP) *</label>
                        <input type="number" name="precio" class="form-control-jc" placeholder="Ej: 1200000" required>
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label-jc">Categoría *</label>
                        <select name="id_categoria" class="form-select-jc" required>
                            @foreach($categorias as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label-jc">Subcategoría</label>
                        <select name="id_subcategoria" class="form-select-jc">
                            <option value="">Selecciona subcategoría...</option>
                            @foreach(\App\Models\Subcategoria::where('activo', true)->get() as $sub)
                                <option value="{{ $sub->id }}">{{ $sub->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <div class="d-flex justify-content-between">
                            <label class="form-label-jc">Marca *</label>
                            <label class="small text-muted"><input type="checkbox" checked disabled> Mostrar todas</label>
                        </div>
                        <select name="id_marca" class="form-select-jc">
                            <option value="">Seleccione una marca</option>
                            @foreach(\App\Models\Marca::where('activo', true)->get() as $m)
                                <option value="{{ $m->id }}">{{ $m->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label-jc">Género *</label>
                        <select name="genero" class="form-select-jc">
                            <option value="Unisex (Ambos)">Unisex (Ambos)</option>
                            <option value="Hombre">Hombre</option>
                            <option value="Mujer">Mujer</option>
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label-jc">Stock *</label>
                    <input type="number" name="stock" class="form-control-jc" placeholder="Ej: 5" min="0" required>
                </div>

                <div class="mb-3">
                    <label class="form-label-jc">Descripción</label>
                    <textarea name="descripcion" class="form-control-jc" rows="3" placeholder="Escribe los detalles del producto..."></textarea>
                </div>

                <div class="mb-4">
                    <label class="form-label-jc">Imagen Principal *</label>
                    <input type="file" name="imagen_principal" class="form-control-jc" accept="image/*">
                </div>

                <button type="submit" class="btn-modal-submit">
                    <i class="bi bi-box-arrow-down fs-5"></i> GUARDAR PRODUCTO
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
