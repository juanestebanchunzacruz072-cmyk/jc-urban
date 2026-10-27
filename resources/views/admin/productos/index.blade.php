@extends('layouts.admin')

@section('title', 'Gestión de Productos')
@section('page_title', 'Catálogo de Productos')

@section('content')
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
    <!-- Formulario de Búsqueda y Filtro (HU-19) -->
    <form action="{{ route('admin.productos.index') }}" method="GET" class="d-flex flex-wrap gap-2 flex-grow-1" style="max-width: 600px;">
        <div class="input-group">
            <span class="input-group-text bg-dark border-secondary text-muted"><i class="bi bi-search"></i></span>
            <input type="text"
                   name="buscar"
                   value="{{ request('buscar') }}"
                   class="form-control"
                   placeholder="Buscar por nombre...">
        </div>
        <select name="categoria" class="form-select" style="max-width: 200px;" onchange="this.form.submit()">
            <option value="">Todas las Categorías</option>
            @foreach($categorias as $cat)
                <option value="{{ $cat->id }}" {{ request('categoria') == $cat->id ? 'selected' : '' }}>
                    {{ $cat->nombre }}
                </option>
            @endforeach
        </select>
        <button type="submit" class="btn btn-secondary btn-sm">Filtrar</button>
        @if(request()->hasAny(['buscar', 'categoria']))
            <a href="{{ route('admin.productos.index') }}" class="btn btn-outline-secondary btn-sm">Limpiar</a>
        @endif
    </form>

    <a href="{{ route('admin.productos.crear') }}" class="btn-jc-gold">
        <i class="bi bi-plus-lg me-1"></i>Nuevo Producto
    </a>
</div>

<!-- Tabla de Productos -->
<div class="jc-card p-4">
    @if($productos->isEmpty())
        <div class="text-center py-5">
            <i class="bi bi-box2 display-4 text-muted"></i>
            <h6 class="text-white mt-3">No se encontraron productos</h6>
            <p class="text-muted small">Crea un nuevo producto o ajusta los criterios de búsqueda.</p>
        </div>
    @else
        <div class="table-responsive">
            <table class="jc-table">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Marca</th>
                        <th>Categoría</th>
                        <th>Precio</th>
                        <th>Stock</th>
                        <th>Estado</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($productos as $prod)
                        @php
                            $imgObj = $prod->imagenPrincipal();
                            $imgUrl = 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?auto=format&fit=crop&w=150&q=80';
                            if ($imgObj) {
                                $imgUrl = str_starts_with($imgObj->url_imagen, 'http')
                                    ? $imgObj->url_imagen
                                    : asset('storage/' . $imgObj->url_imagen);
                            }
                        @endphp
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <img src="{{ $imgUrl }}"
                                         alt="{{ $prod->nombre }}"
                                         class="rounded"
                                         style="width: 50px; height: 50px; object-fit: cover;">
                                    <div>
                                        <div class="text-white fw-bold small">{{ $prod->nombre }}</div>
                                        <small class="text-muted">ID: #{{ $prod->id }}</small>
                                    </div>
                                </div>
                            </td>
                            <td class="text-warning small fw-semibold">
                                {{ $prod->marca?->nombre ?? 'N/A' }}
                            </td>
                            <td>
                                <div class="text-white small">{{ $prod->categoria?->nombre }}</div>
                                <small class="text-muted">{{ $prod->subcategoria?->nombre ?? '-' }}</small>
                            </td>
                            <td class="fw-bold text-white">
                                ${{ number_format($prod->precio, 0, ',', '.') }}
                            </td>
                            <td>
                                @if($prod->stock > 5)
                                    <span class="badge bg-success bg-opacity-25 text-success border border-success">{{ $prod->stock }} uds</span>
                                @elseif($prod->stock > 0)
                                    <span class="badge bg-warning bg-opacity-25 text-warning border border-warning">{{ $prod->stock }} uds</span>
                                @else
                                    <span class="badge bg-danger bg-opacity-25 text-danger border border-danger">Agotado</span>
                                @endif
                            </td>
                            <td>
                                <!-- Toggle Activo / Inactivo (HU-19) -->
                                <form action="{{ route('admin.productos.toggle', $prod->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit"
                                            class="badge {{ $prod->activo ? 'badge-jc-success' : 'badge-jc-danger' }} border-0 cursor-pointer"
                                            title="Click para cambiar estado">
                                        {{ $prod->activo ? 'Activo' : 'Inactivo' }}
                                    </button>
                                </form>
                            </td>
                            <td class="text-end">
                                <div class="d-inline-flex gap-2">
                                    <a href="{{ route('admin.productos.editar', $prod->id) }}" class="btn btn-outline-info btn-sm py-1 px-2" title="Editar">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <form action="{{ route('admin.productos.eliminar', $prod->id) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Seguro que deseas eliminar este producto permanentemente?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm py-1 px-2" title="Eliminar">
                                            <i class="bi bi-trash3"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $productos->links() }}
        </div>
    @endif
</div>
@endsection
