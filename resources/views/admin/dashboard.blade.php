@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page_title', 'Dashboard General')

@section('content')
<!-- Métricas Principales (HU-18) -->
<div class="row g-4 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-center">
                <span class="stat-label">Ingresos Totales</span>
                <i class="bi bi-currency-dollar stat-icon"></i>
            </div>
            <div class="stat-value text-warning">${{ number_format($ingresoTotal, 0, ',', '.') }}</div>
            <small class="text-muted">Ventas acumuladas</small>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-center">
                <span class="stat-label">Total Pedidos</span>
                <i class="bi bi-bag-check stat-icon"></i>
            </div>
            <div class="stat-value">{{ $totalPedidos }}</div>
            <small class="text-muted">Órdenes procesadas</small>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-center">
                <span class="stat-label">Catálogo Activo</span>
                <i class="bi bi-box-seam stat-icon"></i>
            </div>
            <div class="stat-value">{{ $totalProductos }}</div>
            <small class="text-muted">Productos registrados</small>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-center">
                <span class="stat-label">Clientes Registrados</span>
                <i class="bi bi-people stat-icon"></i>
            </div>
            <div class="stat-value">{{ $totalClientes }}</div>
            <small class="text-muted">Usuarios activos</small>
        </div>
    </div>
</div>

<!-- Alerta de Stock Agotado si aplica -->
@if($productosAgotados > 0)
    <div class="alert alert-warning bg-opacity-10 border-warning text-warning d-flex justify-content-between align-items-center mb-4">
        <div class="d-flex align-items-center gap-2">
            <i class="bi bi-exclamation-triangle-fill fs-5"></i>
            <div><strong>Atención de inventario:</strong> Tienes {{ $productosAgotados }} productos activos con stock en 0.</div>
        </div>
        <a href="{{ route('admin.productos.index') }}" class="btn btn-warning btn-sm fw-bold">Revisar Productos</a>
    </div>
@endif

<!-- Acciones Rápidas y Pedidos Recientes -->
<div class="row g-4">
    <div class="col-lg-8">
        <div class="jc-card p-4">
            <div class="d-flex justify-content-between align-items-center mb-3 border-bottom border-secondary pb-3">
                <h5 class="text-white fw-bold mb-0">
                    <i class="bi bi-clock-history me-2 text-warning"></i>Últimos Pedidos
                </h5>
                <a href="{{ route('admin.pedidos.index') }}" class="btn-jc-outline btn-sm">Ver Todos</a>
            </div>

            @if($pedidosRecientes->isEmpty())
                <div class="text-center py-5">
                    <i class="bi bi-inbox display-4 text-muted"></i>
                    <p class="text-muted mt-2">Aún no hay pedidos registrados.</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="jc-table">
                        <thead>
                            <tr>
                                <th>Pedido</th>
                                <th>Cliente</th>
                                <th>Fecha</th>
                                <th>Total</th>
                                <th>Estado</th>
                                <th class="text-end">Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pedidosRecientes as $pedido)
                                <tr>
                                    <td>
                                        <strong class="text-warning">#PED-{{ str_pad($pedido->id, 5, '0', STR_PAD_LEFT) }}</strong>
                                    </td>
                                    <td>
                                        <div class="text-white fw-semibold small">{{ $pedido->usuario->name }} {{ $pedido->usuario->apellido }}</div>
                                        <small class="text-muted">{{ $pedido->usuario->email }}</small>
                                    </td>
                                    <td class="text-muted small">
                                        {{ $pedido->created_at->format('d/m/Y H:i') }}
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
                                        <a href="{{ route('admin.pedidos.detalle', $pedido->id) }}" class="btn btn-outline-warning btn-sm py-1 px-2">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

    <!-- Panel de Accesos Rápidos -->
    <div class="col-lg-4">
        <div class="jc-card p-4 mb-4">
            <h5 class="text-white fw-bold mb-3 border-bottom border-secondary pb-3">Accesos Directos</h5>
            <div class="d-grid gap-2">
                <a href="{{ route('admin.productos.crear') }}" class="btn-jc-gold text-center py-2">
                    <i class="bi bi-plus-circle me-1"></i>Nuevo Producto
                </a>
                <a href="{{ route('admin.pedidos.index') }}" class="btn btn-dark border border-secondary text-white py-2 text-start">
                    <i class="bi bi-receipt me-2 text-warning"></i>Gestionar Pedidos
                </a>
                <a href="{{ route('admin.categorias.index') }}" class="btn btn-dark border border-secondary text-white py-2 text-start">
                    <i class="bi bi-folder me-2 text-warning"></i>Categorías & Marcas
                </a>
                <a href="{{ route('admin.usuarios.index') }}" class="btn btn-dark border border-secondary text-white py-2 text-start">
                    <i class="bi bi-people me-2 text-warning"></i>Lista de Clientes
                </a>
            </div>
        </div>

        <div class="jc-card p-4">
            <h6 class="text-white fw-bold mb-2"><i class="bi bi-shield-check text-warning me-2"></i>JC URBAN Admin</h6>
            <p class="text-muted small mb-0">
                Panel administrativo con control de accesos por rol (HU-03). Cambios en estados de pedido se sincronizan automáticamente con las facturas de los clientes.
            </p>
        </div>
    </div>
</div>
@endsection
