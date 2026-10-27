@extends('layouts.admin')

@section('title', 'Gestión de Pedidos')
@section('page_title', 'Control de Pedidos')

@section('content')
<!-- Filtros y Búsqueda (HU-21) -->
<div class="jc-card p-4 mb-4">
    <form action="{{ route('admin.pedidos.index') }}" method="GET" class="row g-3 align-items-end">
        <div class="col-md-3">
            <label class="form-label">Buscar # de Pedido</label>
            <input type="number"
                   name="buscar"
                   value="{{ request('buscar') }}"
                   class="form-control"
                   placeholder="Ej. 1, 2, 3...">
        </div>
        <div class="col-md-3">
            <label class="form-label">Desde</label>
            <input type="date"
                   name="fecha_inicio"
                   value="{{ request('fecha_inicio') }}"
                   class="form-control">
        </div>
        <div class="col-md-3">
            <label class="form-label">Hasta</label>
            <input type="date"
                   name="fecha_fin"
                   value="{{ request('fecha_fin') }}"
                   class="form-control">
        </div>
        <div class="col-md-3">
            <label class="form-label">Estado</label>
            <select name="estado" class="form-select">
                <option value="">Todos los Estados</option>
                @foreach($estados as $est)
                    <option value="{{ $est->id }}" {{ request('estado') == $est->id ? 'selected' : '' }}>
                        {{ $est->nombre }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-12 d-flex justify-content-end gap-2">
            @if(request()->hasAny(['buscar', 'fecha_inicio', 'fecha_fin', 'estado']))
                <a href="{{ route('admin.pedidos.index') }}" class="btn btn-outline-secondary btn-sm">Limpiar Filtros</a>
            @endif
            <button type="submit" class="btn-jc-gold btn-sm">
                <i class="bi bi-funnel me-1"></i>Aplicar Filtros
            </button>
        </div>
    </form>
</div>

<!-- Tabla de Pedidos -->
<div class="jc-card p-4">
    @if($pedidos->isEmpty())
        <div class="text-center py-5">
            <i class="bi bi-receipt-cutoff display-4 text-muted"></i>
            <h6 class="text-white mt-3">No se encontraron pedidos</h6>
            <p class="text-muted small">Ajusta los filtros o espera nuevas órdenes de clientes.</p>
        </div>
    @else
        <div class="table-responsive">
            <table class="jc-table">
                <thead>
                    <tr>
                        <th>N° Pedido</th>
                        <th>Cliente</th>
                        <th>Fecha & Hora</th>
                        <th>Total</th>
                        <th>Estado Actual</th>
                        <th class="text-end">Acción</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pedidos as $pedido)
                        <tr>
                            <td>
                                <strong class="text-warning fs-6">#PED-{{ str_pad($pedido->id, 5, '0', STR_PAD_LEFT) }}</strong>
                            </td>
                            <td>
                                <div class="text-white fw-bold small">{{ $pedido->usuario->name }} {{ $pedido->usuario->apellido }}</div>
                                <small class="text-muted">Tel: {{ $pedido->usuario->telefono }} | {{ $pedido->usuario->ciudad }}</small>
                            </td>
                            <td class="text-muted small">
                                {{ $pedido->created_at->format('d/m/Y h:i A') }}
                            </td>
                            <td class="fw-bold text-white">
                                ${{ number_format($pedido->total, 0, ',', '.') }}
                            </td>
                            <td>
                                @php
                                    $badgeClass = match($pedido->id_estado) {
                                        1 => 'badge-jc-warning',
                                        2 => 'badge-jc-info',
                                        3 => 'badge-jc-info',
                                        4 => 'badge-jc-primary',
                                        5, 6 => 'badge-jc-success',
                                        default => 'badge-secondary',
                                    };
                                @endphp
                                <span class="badge {{ $badgeClass }}">
                                    {{ $pedido->estado?->nombre ?? 'Pendiente' }}
                                </span>
                            </td>
                            <td class="text-end">
                                <a href="{{ route('admin.pedidos.detalle', $pedido->id) }}"
                                   class="btn-jc-outline btn-sm py-1 px-3"
                                   title="Ver Detalle y Cambiar Estado">
                                    <i class="bi bi-eye me-1"></i>Ver Detalle
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $pedidos->links() }}
        </div>
    @endif
</div>
@endsection
