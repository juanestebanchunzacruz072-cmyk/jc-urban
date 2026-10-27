@extends('layouts.admin')

@section('title', 'Usuarios')
@section('page_title', 'USUARIOS')

@section('header_action_button')
    <a href="{{ route('admin.dashboard') }}" class="btn-white-action">
        <i class="bi bi-arrow-left"></i>
        <span>VOLVER</span>
    </a>
@endsection

@section('content')
<div class="box-card-title mb-3" style="color: #64748b;">
    DIRECTORIO DE CLIENTES
</div>

<div class="white-box-card mt-0">
    <div class="box-card-header">
        <h2 class="box-card-title">LISTA DE USUARIOS REGISTRADOS</h2>
        <form action="{{ route('admin.usuarios.index') }}" method="GET" class="d-flex gap-2">
            <input type="text"
                   name="buscar"
                   value="{{ request('buscar') }}"
                   class="form-control-jc"
                   style="width: 260px; padding: 0.4rem 0.8rem; font-size: 0.82rem;"
                   placeholder="Buscar por nombre o correo...">
            <button type="submit" class="btn-white-action">
                <i class="bi bi-search"></i>
            </button>
        </form>
    </div>

    <div class="table-responsive">
        <table class="jc-admin-table">
            <thead>
                <tr>
                    <th>USUARIO</th>
                    <th>CÉDULA</th>
                    <th>EMAIL</th>
                    <th>TELÉFONO</th>
                    <th>UBICACIÓN</th>
                    <th>ESTADO</th>
                </tr>
            </thead>
            <tbody>
                @forelse($usuarios as $usr)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div class="user-avatar-circle" style="width: 32px; height: 32px; font-size: 0.85rem;">
                                    {{ strtoupper(substr($usr->name, 0, 1)) }}
                                </div>
                                <div>
                                    <div class="fw-bold text-dark">{{ $usr->name }} {{ $usr->apellido }}</div>
                                    <small class="text-muted" style="font-size: 0.72rem;">Registrado: {{ $usr->created_at->format('d/m/Y') }}</small>
                                </div>
                            </div>
                        </td>
                        <td class="text-dark small fw-semibold">
                            {{ $usr->cedula ?: '-' }}
                        </td>
                        <td class="text-dark small">
                            {{ $usr->email }}
                        </td>
                        <td class="text-muted small">
                            {{ $usr->telefono ?: '-' }}
                        </td>
                        <td class="text-secondary small">
                            {{ $usr->ciudad ?: 'Medellín' }} ({{ $usr->barrio ?: 'El Poblado' }})
                            <div class="text-muted" style="font-size: 0.72rem;">{{ $usr->direccion }}</div>
                        </td>
                        <td>
                            <span class="pill-status {{ $usr->activo ? 'pill-status-active' : 'pill-status-inactive' }}">
                                {{ $usr->activo ? 'ACTIVO' : 'INACTIVO' }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">
                            No se encontraron clientes registrados.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $usuarios->links() }}
    </div>
</div>
@endsection
