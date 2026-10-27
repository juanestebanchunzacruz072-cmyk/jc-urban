@extends('layouts.admin')

@section('title', 'Gestión de Marcas')
@section('page_title', 'Marcas de Lujo')

@section('content')
<div class="row g-4">
    <!-- Formulario Nueva Marca (HU-20) -->
    <div class="col-lg-4">
        <div class="jc-card p-4">
            <h5 class="text-white fw-bold mb-3 border-bottom border-secondary pb-2">
                <i class="bi bi-tag me-2 text-warning"></i>Nueva Marca
            </h5>
            <form action="{{ route('admin.marcas.guardar') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre de Marca <span class="text-danger">*</span></label>
                    <input type="text"
                           class="form-control"
                           id="nombre"
                           name="nombre"
                           placeholder="Ej. Rolex, Richard Mille, Dior..."
                           required>
                </div>
                <button type="submit" class="btn-jc-gold w-100 py-2">
                    <i class="bi bi-save me-1"></i>Guardar Marca
                </button>
            </form>
        </div>
    </div>

    <!-- Lista de Marcas -->
    <div class="col-lg-8">
        <div class="jc-card p-4">
            <div class="d-flex justify-content-between align-items-center mb-3 border-bottom border-secondary pb-2">
                <h5 class="text-white fw-bold mb-0">Marcas Registradas</h5>
                <span class="badge badge-jc-gold">{{ $marcas->count() }} marcas</span>
            </div>

            <div class="table-responsive">
                <table class="jc-table">
                    <thead>
                        <tr>
                            <th>Marca</th>
                            <th>Productos Asociados</th>
                            <th>Estado</th>
                            <th class="text-end">Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($marcas as $marca)
                            <tr>
                                <td class="fw-bold text-white fs-6">
                                    <i class="bi bi-award text-warning me-1"></i>{{ $marca->nombre }}
                                </td>
                                <td>
                                    <span class="badge bg-dark border border-secondary text-white">{{ $marca->productos_count }} productos</span>
                                </td>
                                <td>
                                    <form action="{{ route('admin.marcas.toggle', $marca->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="badge {{ $marca->activo ? 'badge-jc-success' : 'badge-jc-danger' }} border-0 cursor-pointer" title="Click para alternar">
                                            {{ $marca->activo ? 'Activo' : 'Inactivo' }}
                                        </button>
                                    </form>
                                </td>
                                <td class="text-end">
                                    <button type="button"
                                            class="btn btn-outline-info btn-sm py-1 px-2"
                                            data-bs-toggle="modal"
                                            data-bs-target="#editMarcaModal{{ $marca->id }}"
                                            title="Editar">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                </td>
                            </tr>

                            <!-- Modal Editar Marca -->
                            <div class="modal fade" id="editMarcaModal{{ $marca->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content jc-card border border-warning">
                                        <div class="modal-header border-secondary">
                                            <h5 class="modal-title text-white">Editar Marca: {{ $marca->nombre }}</h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                        </div>
                                        <form action="{{ route('admin.marcas.actualizar', $marca->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label class="form-label">Nombre</label>
                                                    <input type="text" name="nombre" class="form-control" value="{{ $marca->nombre }}" required>
                                                </div>
                                            </div>
                                            <div class="modal-footer border-secondary">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                <button type="submit" class="btn-jc-gold">Actualizar</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
