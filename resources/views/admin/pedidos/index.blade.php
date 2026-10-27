@extends('layouts.admin')

@section('title', 'Gestión de Pedidos')
@section('page_title', 'GESTIÓN DE PEDIDOS')

@section('header_action_button')
    <form action="{{ route('admin.pedidos.index') }}" method="GET" class="d-flex align-items-center gap-2">
        <input type="text"
               name="buscar_id"
               value="{{ request('buscar_id') }}"
               class="form-control-jc"
               style="width: 140px; padding: 0.45rem 0.8rem; font-size: 0.82rem; background: #fff;"
               placeholder="Cod. Pedido">
        <input type="date"
               name="fecha"
               value="{{ request('fecha') }}"
               class="form-control-jc"
               style="width: 150px; padding: 0.45rem 0.8rem; font-size: 0.82rem; background: #fff;">
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
<!-- Subtítulo -->
<div class="box-card-title mb-3" style="color: #64748b; font-size: 0.95rem;">
    HISTORIAL DE PEDIDOS
</div>

<!-- Tarjeta Blanca de Pedidos (Exacto al Screenshot 5) -->
<div class="white-box-card mt-0">
    <div class="table-responsive">
        <table class="jc-admin-table">
            <thead>
                <tr>
                    <th style="width: 110px;">ID PEDIDO</th>
                    <th style="width: 200px;">CLIENTE</th>
                    <th style="width: 140px;">FECHA</th>
                    <th>DIRECCIÓN ENTREGA</th>
                    <th style="width: 130px;">TOTAL</th>
                    <th style="width: 140px;">ESTADO ACTUAL</th>
                    <th style="width: 240px;">CAMBIAR ESTADO</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pedidos as $pedido)
                    <tr>
                        <!-- ID PEDIDO (#00008) -->
                        <td class="fw-bold text-dark fs-6">
                            #{{ str_pad($pedido->id, 5, '0', STR_PAD_LEFT) }}
                        </td>

                        <!-- CLIENTE -->
                        <td class="text-dark fw-semibold">
                            <span class="text-capitalize">{{ strtolower($pedido->usuario->name . ' ' . $pedido->usuario->apellido) }}</span>
                        </td>

                        <!-- FECHA -->
                        <td>
                            <div class="text-dark small">{{ $pedido->created_at->format('d/m/Y H:i') }}</div>
                        </td>

                        <!-- DIRECCIÓN ENTREGA -->
                        <td class="text-secondary small">
                            {{ $pedido->usuario->direccion ?: 'Pendiente' }}
                        </td>

                        <!-- TOTAL -->
                        <td class="fw-bold text-dark">
                            $ {{ number_format($pedido->total, 0, ',', '.') }}
                        </td>

                        <!-- ESTADO ACTUAL (Pill de color exacto al screenshot 5) -->
                        <td>
                            @php
                                $estadoNombre = strtoupper($pedido->estado?->nombre ?? 'PENDIENTE');
                                $pillClass = match($estadoNombre) {
                                    'RECIBIDO' => 'pill-status-recibido',
                                    'ENVIADO'  => 'pill-status-enviado',
                                    'EMPACADO' => 'pill-status-empacado',
                                    'ENTREGADO'=> 'pill-status-entregado',
                                    default    => 'pill-status-pendiente',
                                };
                            @endphp
                            <span class="pill-status {{ $pillClass }}">
                                {{ $estadoNombre }}
                            </span>
                        </td>

                        <!-- CAMBIAR ESTADO (Select + Botón amarillo check + Botón ojo negro + Botón eliminar rojo) -->
                        <td>
                            <form action="{{ route('admin.pedidos.estado', $pedido->id) }}" method="POST" class="d-flex align-items-center gap-1">
                                @csrf
                                @method('PATCH')
                                <select name="id_estado" class="form-select-jc" style="width: 110px; padding: 0.35rem 0.5rem; font-size: 0.8rem; font-weight: 500;">
                                    @foreach($estados as $est)
                                        <option value="{{ $est->id }}" {{ $pedido->id_estado == $est->id ? 'selected' : '' }}>
                                            {{ $est->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                                <button type="submit"
                                        class="btn-sq btn-sq-gold"
                                        style="width: 32px; height: 32px; border-radius: 4px;"
                                        title="Confirmar cambio de estado">
                                    <i class="bi bi-check2 fs-6 text-dark fw-bold"></i>
                                </button>
                                <a href="{{ route('admin.pedidos.show', $pedido->id) }}"
                                   class="btn-sq"
                                   style="width: 32px; height: 32px; border-radius: 4px; background: #000; color: #fff;"
                                   title="Ver Detalle">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <button type="button"
                                        class="btn-sq btn-sq-red"
                                        style="width: 32px; height: 32px; border-radius: 4px;"
                                        title="Eliminar pedido">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-4 text-muted">
                            No hay pedidos registrados en el historial.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $pedidos->links() }}
    </div>
</div>
@endsection
