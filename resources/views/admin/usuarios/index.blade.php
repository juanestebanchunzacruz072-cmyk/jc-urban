@extends('layouts.admin')

@section('title', 'Listado de Clientes')
@section('page_title', 'LISTADO DE CLIENTES')

@section('header_action_button')
    <form action="{{ route('admin.usuarios.index') }}" method="GET" class="d-flex align-items-center gap-2">
        <input type="text"
               name="buscar"
               value="{{ request('buscar') }}"
               class="form-control-jc"
               style="width: 220px; padding: 0.45rem 0.8rem; font-size: 0.82rem; background: #fff;"
               placeholder="Buscar cliente...">
        <button type="submit" class="btn-sq btn-sq-gold" style="width: 38px; height: 38px; border-radius: 6px;">
            <i class="bi bi-search text-dark fw-bold"></i>
        </button>
        <a href="{{ route('admin.dashboard') }}" class="btn-white-action py-2">
            <i class="bi bi-arrow-left"></i>
            <span>VOLVER</span>
        </a>
    </form>
@endsection

@section('content')
<div class="box-card-title mb-3" style="color: #64748b; font-size: 0.95rem;">
    CLIENTES REGISTRADOS
</div>

<div class="white-box-card mt-0">
    <div class="table-responsive">
        <table class="jc-admin-table">
            <thead>
                <tr>
                    <th style="width: 80px;">PERFIL</th>
                    <th>NOMBRE COMPLETO</th>
                    <th>CORREO ELECTRÓNICO</th>
                    <th>TELÉFONO</th>
                    <th>UBICACIÓN</th>
                    <th style="width: 140px;">FECHA REGISTRO</th>
                </tr>
            </thead>
            <tbody>
                @forelse($usuarios as $usr)
                    @php
                        $inits = strtoupper(substr($usr->name, 0, 1) . substr($usr->apellido ?? '', 0, 1));
                    @endphp
                    <tr>
                        <td>
                            <div style="width: 36px; height: 36px; border-radius: 50%; background-color: var(--jc-gold); color: #000; font-weight: 800; font-size: 0.82rem; display: flex; align-items: center; justify-content: center;">
                                {{ $inits ?: 'CL' }}
                            </div>
                        </td>
                        <td class="fw-bold text-dark">
                            {{ $usr->name }} {{ $usr->apellido }}
                        </td>
                        <td class="text-dark small">
                            {{ $usr->email }}
                        </td>
                        <td class="text-dark small">
                            {{ $usr->telefono ?: 'Pendiente' }}
                        </td>
                        <td class="text-dark small">
                            {{ $usr->ciudad ?: 'Neiva' }}, {{ $usr->direccion ?: ($usr->barrio ?: 'Pendiente') }}
                        </td>
                        <td>
                            <span style="background: #18181b; color: #ffffff; padding: 0.35rem 0.85rem; border-radius: 20px; font-size: 0.76rem; font-weight: 700; display: inline-block;">
                                {{ $usr->created_at ? $usr->created_at->format('d/m/Y') : '23/10/2026' }}
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
