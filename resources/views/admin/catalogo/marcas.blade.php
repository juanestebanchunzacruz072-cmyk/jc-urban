@extends('layouts.admin')

@section('title', 'Gestión de Marcas')
@section('page_title', 'GESTIÓN DE MARCAS')

@section('header_action_button')
    <button type="button" class="btn-gold-action" data-bs-toggle="modal" data-bs-target="#modalNuevaMarca">
        <i class="bi bi-plus-lg"></i> AGREGAR MARCA
    </button>
@endsection

@section('content')
<!-- Tarjeta Filtros de Búsqueda de Marcas (Exacto al Screenshot 3) -->
<div class="white-box-card mb-4 mt-0">
    <div class="filter-card-title">
        <i class="bi bi-funnel"></i> FILTRAR MARCAS
    </div>
    <form action="{{ route('admin.marcas.index') }}" method="GET">
        <div class="row g-3 align-items-end">
            <div class="col-md-5">
                <label class="form-label-jc">BUSCAR MARCA</label>
                <input type="text"
                       name="buscar"
                       value="{{ request('buscar') }}"
                       class="form-control-jc"
                       placeholder="Nombre de la marca...">
            </div>
            <div class="col-md-4">
                <label class="form-label-jc">POR CATEGORÍA</label>
                <select name="categoria" class="form-select-jc">
                    <option value="">Todas las categorías</option>
                    @foreach($categorias as $cat)
                        <option value="{{ $cat->id }}" {{ request('categoria') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3 d-flex gap-2">
                <button type="submit" class="btn-gold-action w-100 justify-content-center">
                    <i class="bi bi-search"></i> Filtrar
                </button>
                <a href="{{ route('admin.marcas.index') }}" class="btn-white-action justify-content-center" style="padding: 0.6rem 1rem;">
                    <i class="bi bi-x-circle"></i> Limpiar
                </a>
            </div>
        </div>
    </form>
</div>

<!-- Subtítulo -->
<div class="box-card-title mb-3" style="color: #64748b; font-size: 0.95rem;">
    LISTA DE MARCAS
</div>

<!-- Tarjeta Blanca Lista de Marcas (Exacto al Screenshot 3) -->
<div class="white-box-card mt-0">
    <div class="table-responsive">
        <table class="jc-admin-table">
            <thead>
                <tr>
                    <th style="width: 100px;">ID</th>
                    <th style="width: 260px;">NOMBRE DE MARCA</th>
                    <th>DESCRIPCIÓN</th>
                    <th class="text-end" style="width: 160px;">ACCIONES</th>
                </tr>
            </thead>
            <tbody>
                @foreach($marcas as $marca)
                    <tr>
                        <td class="fw-bold text-muted">
                            #{{ $marca->id }}
                        </td>
                        <td class="fw-bold text-dark fs-6">
                            {{ $marca->nombre }}
                        </td>
                        <td class="text-secondary">
                            {{ $marca->descripcion ?? 'Marca de relojes de lujo y prestigio mundial' }}
                        </td>
                        <td class="text-end">
                            <div class="d-inline-flex gap-2">
                                <!-- Botón Editar (Dorado) -->
                                <button type="button"
                                        class="btn-sq btn-sq-gold"
                                        data-bs-toggle="modal"
                                        data-bs-target="#editMarcaModal{{ $marca->id }}"
                                        title="Editar">
                                    <i class="bi bi-pencil-square"></i>
                                </button>

                                <!-- Botón Visibilidad / Toggle (Dorado si visible, Gris si oculto) -->
                                <form action="{{ route('admin.marcas.toggle', $marca->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit"
                                            class="btn-sq {{ $marca->activo ? 'btn-sq-gold' : 'btn-sq-slate' }}"
                                            title="{{ $marca->activo ? 'Ocultar marca' : 'Mostrar marca' }}">
                                        <i class="bi {{ $marca->activo ? 'bi-eye' : 'bi-eye-slash' }}"></i>
                                    </button>
                                </form>

                                <!-- Botón Eliminar (Rojo) -->
                                <form action="{{ route('admin.marcas.toggle', $marca->id) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Deseas cambiar el estado de esta marca?')">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn-sq btn-sq-red" title="Eliminar">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>

                    <!-- Modal Editar Marca -->
                    <div class="modal fade" id="editMarcaModal{{ $marca->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content modal-content-jc">
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <h4 class="modal-title-jc">EDITAR MARCA</h4>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="{{ route('admin.marcas.actualizar', $marca->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="mb-3">
                                        <label class="form-label-jc">Nombre de Marca *</label>
                                        <input type="text" name="nombre" class="form-control-jc" value="{{ $marca->nombre }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label-jc">Descripción</label>
                                        <textarea name="descripcion" class="form-control-jc" rows="3">{{ $marca->descripcion }}</textarea>
                                    </div>
                                    <button type="submit" class="btn-modal-submit">
                                        <i class="bi bi-box-arrow-down"></i> ACTUALIZAR MARCA
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Agregar Marca -->
<div class="modal fade" id="modalNuevaMarca" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-content-jc">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="modal-title-jc">AGREGAR MARCA</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.marcas.guardar') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label-jc">Nombre de la Marca *</label>
                    <input type="text" name="nombre" class="form-control-jc" placeholder="Ej: Richard Mille, Rolex..." required>
                </div>
                <div class="mb-3">
                    <label class="form-label-jc">Descripción</label>
                    <textarea name="descripcion" class="form-control-jc" rows="3" placeholder="Marca de relojes de alta gama y diseño técnico"></textarea>
                </div>
                <button type="submit" class="btn-modal-submit">
                    <i class="bi bi-box-arrow-down"></i> GUARDAR MARCA
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
