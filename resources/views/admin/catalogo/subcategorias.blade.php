@extends('layouts.admin')

@section('title', 'Gestión de Subcategorías')
@section('page_title', 'Subcategorías del Catálogo')

@section('content')
<div class="row g-4">
    <!-- Formulario Nueva Subcategoría (HU-20) -->
    <div class="col-lg-4">
        <div class="jc-card p-4">
            <h5 class="text-white fw-bold mb-3 border-bottom border-secondary pb-2">
                <i class="bi bi-diagram-3 me-2 text-warning"></i>Nueva Subcategoría
            </h5>
            <form action="{{ route('admin.subcategorias.guardar') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="id_categoria" class="form-label">Categoría Padre <span class="text-danger">*</span></label>
                    <select class="form-select" id="id_categoria" name="id_categoria" required>
                        <option value="">Selecciona categoría...</option>
                        @foreach($categorias as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre de Subcategoría <span class="text-danger">*</span></label>
                    <input type="text"
                           class="form-control"
                           id="nombre"
                           name="nombre"
                           placeholder="Ej. Alta gama, Réplicas, 1.1..."
                           required>
                </div>
                <button type="submit" class="btn-jc-gold w-100 py-2">
                    <i class="bi bi-save me-1"></i>Guardar Subcategoría
                </button>
            </form>
        </div>
    </div>

    <!-- Lista de Subcategorías -->
    <div class="col-lg-8">
        <div class="jc-card p-4">
            <div class="d-flex justify-content-between align-items-center mb-3 border-bottom border-secondary pb-2">
                <h5 class="text-white fw-bold mb-0">Subcategorías Existentes</h5>
                <span class="badge badge-jc-gold">{{ $subcategorias->count() }} subcategorías</span>
            </div>

            <div class="table-responsive">
                <table class="jc-table">
                    <thead>
                        <tr>
                            <th>Subcategoría</th>
                            <th>Categoría Padre</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($subcategorias as $sub)
                            <tr>
                                <td class="fw-bold text-white">{{ $sub->nombre }}</td>
                                <td>
                                    <span class="badge badge-jc-gold">{{ $sub->categoria?->nombre }}</span>
                                </td>
                                <td>
                                    <form action="{{ route('admin.subcategorias.toggle', $sub->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="badge {{ $sub->activo ? 'badge-jc-success' : 'badge-jc-danger' }} border-0 cursor-pointer" title="Click para alternar">
                                            {{ $sub->activo ? 'Activo' : 'Inactivo' }}
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
