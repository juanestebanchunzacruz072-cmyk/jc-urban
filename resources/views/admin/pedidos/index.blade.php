@extends('layouts.admin')

@section('title', 'Gestión de Pedidos')
@section('page_title', 'GESTIÓN DE PEDIDOS')

@section('header_action_button')
    <a href="{{ route('admin.dashboard') }}" class="btn-white-action">
        <i class="bi bi-arrow-left"></i>
        <span>VOLVER</span>
    </a>
@endsection

@section('content')
<!-- Subtítulo -->
<div class="box-card-title mb-3" style="color: #64748b;">
    HISTORIAL DE PEDIDOS
</div>

<!-- Tarjeta Blanca de Pedidos (Exacto al Screenshot 5) -->
<div class="white-box-card mt-0">
    <div class="table-responsive">
        <table class="jc-admin-table">
            <thead>
                <tr>
                    <th style="width: 120px;">ID PEDIDO</th>
                    <th style="width: 220px;">CLIENTE</th>
                    <th style="width: 140px;">FECHA</th>
                    <th>DIRECCIÓN ENTREGA</th>
                    <th style="width: 140px;">TOTAL</th>
                    <th style="width: 150px;">ESTADO ACTUAL</th>
                    <th style="width: 180px;">CAMBIAR ESTADO</th>
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
                        <td class="text-dark">
                            <span class="text-capitalize">{{ strtolower($pedido->usuario->name . ' ' . $pedido->usuario->apellido) }}</span>
                        </td>

                        <!-- FECHA (Fecha arriba, Hora abajo) -->
                        <td>
                            <div class="fw-bold text-dark small">{{ $pedido->created_at->format('d/m/Y') }}</div>
                            <div class="text-muted small" style="font-size: 0.78rem;">{{ $pedido->created_at->format('H:i') }}</div>
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

                        <!-- CAMBIAR ESTADO (Select + Botón amarillo con check ✓) -->
                        <td>
                            <form action="{{ route('admin.pedidos.estado', $pedido->id) }}" method="POST" class="d-flex flex-column gap-1">
                                @csrf
                                @method('PATCH')
                                <select name="id_estado" class="form-select-jc" style="padding: 0.35rem 0.6rem; font-size: 0.82rem; font-weight: 600;">
                                    @foreach($estados as $est)
                                        <option value="{{ $est->id }}" {{ $pedido->id_estado == $est->id ? 'selected' : '' }}>
                                            {{ $est->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                                <button type="submit"
                                        class="btn-sq btn-sq-gold mt-1"
                                        style="width: 34px; height: 30px; border-radius: 4px;"
                                        title="Confirmar cambio de estado">
                                    <i class="bi bi-check2 fs-5 text-dark fw-bold"></i>
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
