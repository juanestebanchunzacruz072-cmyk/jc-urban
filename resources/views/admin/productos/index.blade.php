@extends('layouts.admin')

@section('title', 'Productos')
@section('page_title', 'PRODUCTOS')

@section('header_action_button')
    <button type="button" class="btn-gold-action" data-bs-toggle="modal" data-bs-target="#modalAgregarProducto">
        <i class="bi bi-plus-lg"></i> AGREGAR
    </button>
@endsection

@section('content')
<div class="white-box-card mt-0">
    <div class="box-card-header">
        <h2 class="box-card-title">LISTA DE PRODUCTOS</h2>
        <div class="d-flex gap-2">
            <!-- Buscador rápido -->
            <form action="{{ route('admin.productos.index') }}" method="GET" class="d-flex gap-2">
                <input type="text"
                       name="buscar"
                       value="{{ request('buscar') }}"
                       class="form-control-jc"
                       style="width: 240px; padding: 0.4rem 0.8rem; font-size: 0.82rem;"
                       placeholder="Buscar por nombre o ref...">
                <button type="submit" class="btn-white-action">
                    <i class="bi bi-search"></i>
                </button>
            </form>
        </div>
    </div>

    <div class="table-responsive">
        <table class="jc-admin-table">
            <thead>
                <tr>
                    <th style="width: 70px;">IMAGEN</th>
                    <th>NOMBRE</th>
                    <th>REF / SKU</th>
                    <th>CATEGORÍA</th>
                    <th>MARCA</th>
                    <th>PRECIO</th>
                    <th>STOCK</th>
                    <th>ESTADO</th>
                    <th class="text-end" style="width: 130px;">ACCIONES</th>
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
                        <td>
                            <img src="{{ $imgUrl }}"
                                 alt="{{ $prod->nombre }}"
                                 class="rounded"
                                 style="width: 44px; height: 44px; object-fit: cover; background: #f1f5f9;">
                        </td>
                        <td class="fw-bold text-dark">
                            {{ $prod->nombre }}
                        </td>
                        <td class="text-muted small">
                            {{ $prod->sku ?? '-' }}
                        </td>
                        <td class="text-secondary small">
                            {{ $prod->categoria?->nombre }} &gt; {{ $prod->subcategoria?->nombre ?? 'General' }}
                            @if($prod->genero)
                                ({{ $prod->genero }})
                            @endif
                        </td>
                        <td class="text-dark small fw-semibold">
                            {{ $prod->marca?->nombre ?? 'Sin marca' }}
                        </td>
                        <td class="fw-bold text-dark">
                            $ {{ number_format($prod->precio, 0, ',', '.') }}
                        </td>
                        <td>
                            <span class="badge bg-light text-dark border">
                                {{ $prod->stock }} uds
                            </span>
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
