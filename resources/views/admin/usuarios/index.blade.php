@extends('layouts.admin')

@section('title', 'Directorio de Clientes')
@section('page_title', 'Clientes Registrados')

@section('content')
<!-- Barra de Búsqueda de Clientes (HU-23) -->
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
    <form action="{{ route('admin.usuarios.index') }}" method="GET" class="d-flex gap-2 flex-grow-1" style="max-width: 500px;">
        <div class="input-group">
            <span class="input-group-text bg-dark border-secondary text-muted"><i class="bi bi-search"></i></span>
            <input type="text"
                   name="buscar"
                   value="{{ request('buscar') }}"
                   class="form-control"
                   placeholder="Buscar cliente por nombre o correo...">
        </div>
        <button type="submit" class="btn btn-secondary btn-sm">Buscar</button>
        @if(request()->filled('buscar'))
            <a href="{{ route('admin.usuarios.index') }}" class="btn btn-outline-secondary btn-sm">Limpiar</a>
        @endif
    </form>
</div>

<!-- Tabla de Clientes -->
<div class="jc-card p-4">
    <div class="d-flex justify-content-between align-items-center mb-3 border-bottom border-secondary pb-2">
        <h5 class="text-white fw-bold mb-0">Listado de Clientes</h5>
        <span class="badge badge-jc-gold">{{ $usuarios->total() }} clientes</span>
    </div>

    @if($usuarios->isEmpty())
        <div class="text-center py-5">
            <i class="bi bi-people display-4 text-muted"></i>
            <h6 class="text-white mt-3">No se encontraron clientes</h6>
            <p class="text-muted small">Intenta buscar con otros términos.</p>
        </div>
    @else
        <div class="table-responsive">
            <table class="jc-table">
                <thead>
                    <tr>
                        <th>Cliente</th>
                        <th>Cédula</th>
                        <th>Contacto</th>
                        <th>Ubicación / Entrega</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($usuarios as $usr)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <div class="btn-user d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                        <i class="bi bi-person-fill text-warning"></i>
                                    </div>
                                    <div>
                                        <div class="text-white fw-bold small">{{ $usr->name }} {{ $usr->apellido }}</div>
                                        <small class="text-muted">Registrado: {{ $usr->created_at->format('d/m/Y') }}</small>
                                    </div>
                                </div>
                            </td>
                            <td class="text-white small fw-semibold">
                                {{ $usr->cedula ?? '-' }}
                            </td>
                            <td>
                                <div class="text-white small">{{ $usr->email }}</div>
                                <small class="text-muted">Tel: {{ $usr->telefono ?? '-' }}</small>
                            </td>
                            <td>
                                <div class="text-white small">{{ $usr->ciudad ?? '-' }} ({{ $usr->barrio ?? '-' }})</div>
                                <small class="text-muted">{{ $usr->direccion ?? '-' }}</small>
                            </td>
                            <td>
                                <span class="badge {{ $usr->activo ? 'badge-jc-success' : 'badge-jc-danger' }}">
                                    {{ $usr->activo ? 'Activo' : 'Inactivo' }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $usuarios->links() }}
        </div>
    @endif
</div>
@endsection
