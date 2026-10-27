@extends('layouts.admin')

@section('title', 'Gestión de Categorías')
@section('page_title', 'Categorías del Catálogo')

@section('content')
<div class="row g-4">
    <!-- Columna Izquierda: Formulario Crear Categoría (HU-20) -->
    <div class="col-lg-4">
        <div class="jc-card p-4">
            <h5 class="text-white fw-bold mb-3 border-bottom border-secondary pb-2">
                <i class="bi bi-plus-circle me-2 text-warning"></i>Nueva Categoría
            </h5>
            <form action="{{ route('admin.categorias.guardar') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre de Categoría <span class="text-danger">*</span></label>
                    <input type="text"
                           class="form-control"
                           id="nombre"
                           name="nombre"
                           placeholder="Ej. Relojes, Perfumes..."
                           required>
                </div>
                <div class="mb-3">
                    <label for="descripcion" class="form-label">Descripción</label>
                    <textarea class="form-control"
                              id="descripcion"
                              name="descripcion"
                              rows="3"
                              placeholder="Breve detalle de la categoría..."></textarea>
                </div>
                <button type="submit" class="btn-jc-gold w-100 py-2">
                    <i class="bi bi-save me-1"></i>Guardar Categoría
                </button>
            </form>
        </div>
    </div>

    <!-- Columna Derecha: Lista de Categorías -->
    <div class="col-lg-8">
        <div class="jc-card p-4">
            <div class="d-flex justify-content-between align-items-center mb-3 border-bottom border-secondary pb-2">
                <h5 class="text-white fw-bold mb-0">Categorías Registradas</h5>
                <span class="badge badge-jc-gold">{{ $categorias->count() }} categorías</span>
            </div>

            <div class="table-responsive">
                <table class="jc-table">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Productos</th>
                            <th>Estado</th>
                            <th class="text-end">Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categorias as $cat)
                            <tr>
                                <td class="fw-bold text-white">{{ $cat->nombre }}</td>
                                <td class="text-muted small">{{ $cat->descripcion ?? '-' }}</td>
                                <td>
                                    <span class="badge bg-dark border border-secondary text-white">{{ $cat->productos_count }} items</span>
                                </td>
                                <td>
                                    <form action="{{ route('admin.categorias.toggle', $cat->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="badge {{ $cat->activo ? 'badge-jc-success' : 'badge-jc-danger' }} border-0 cursor-pointer" title="Click para alternar">
                                            {{ $cat->activo ? 'Activo' : 'Inactivo' }}
                                        </button>
                                    </form>
                                </td>
                                <td class="text-end">
                                    <button type="button"
                                            class="btn btn-outline-info btn-sm py-1 px-2"
                                            data-bs-toggle="modal"
                                            data-bs-target="#editCatModal{{ $cat->id }}"
                                            title="Editar">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                </td>
                            </tr>

                            <!-- Modal Editar Categoría -->
                            <div class="modal fade" id="editCatModal{{ $cat->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content jc-card border border-warning">
                                        <div class="modal-header border-secondary">
                                            <h5 class="modal-title text-white">Editar: {{ $cat->nombre }}</h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                        </div>
                                        <form action="{{ route('admin.categorias.actualizar', $cat->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label class="form-label">Nombre</label>
                                                    <input type="text" name="nombre" class="form-control" value="{{ $cat->nombre }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Descripción</label>
                                                    <textarea name="descripcion" class="form-control" rows="3">{{ $cat->descripcion }}</textarea>
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
