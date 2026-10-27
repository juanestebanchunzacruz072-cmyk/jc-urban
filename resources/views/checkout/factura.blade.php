@extends('layouts.app')

@section('title', 'Factura Pedido #' . str_pad($pedido->id, 5, '0', STR_PAD_LEFT) . ' - JC URBAN')

@section('styles')
<style>
    @media print {
        body {
            background-color: #fff !important;
            color: #000 !important;
        }
        .jc-navbar, .jc-footer, .no-print, .btn-close-offcanvas {
            display: none !important;
        }
        .jc-card {
            background: #fff !important;
            color: #000 !important;
            border: 1px solid #ddd !important;
            box-shadow: none !important;
        }
        .table-dark {
            background-color: #fff !important;
            color: #000 !important;
        }
        .text-white {
            color: #000 !important;
        }
        .text-warning {
            color: #b5952f !important;
        }
        .text-muted {
            color: #666 !important;
        }
    }
</style>
@endsection

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-9">
            <!-- Barra de Acciones Superior (No se imprime) -->
            <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 no-print gap-3">
                <a href="{{ route('perfil.index') }}" class="btn-jc-outline btn-sm">
                    <i class="bi bi-arrow-left me-1"></i>Mis Pedidos
                </a>
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-secondary btn-sm" onclick="window.print()">
                        <i class="bi bi-printer me-1"></i>Imprimir Factura
                    </button>
                    <a href="{{ route('catalogo.index') }}" class="btn-jc-gold btn-sm">
                        <i class="bi bi-shop me-1"></i>Seguir Comprando
                    </a>
                </div>
            </div>

            <!-- Contenedor Factura Digital (HU-16) -->
            <div class="jc-card p-4 p-md-5">
                <!-- Encabezado de Factura -->
                <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-start border-bottom border-secondary pb-4 mb-4 gap-3">
                    <div class="d-flex align-items-center gap-3">
                        <img src="{{ asset('img/logo.png') }}" alt="JC URBAN" style="height: 52px; width: 52px; object-fit: contain; border-radius: 6px;">
                        <div>
                            <div class="jc-logo mb-1">
                                <span class="logo-jc fs-4">JC</span><span class="logo-urban fs-4 text-dark" style="color: #000000 !important;">URBAN</span>
                            </div>
                            <p class="text-muted small mb-0">NIT: 901.458.789-1</p>
                            <p class="text-muted small mb-0">Tienda de Alta Relojería y Perfumería de Lujo</p>
                        </div>
                    </div>
                    <div class="text-sm-end">
                        <span class="badge badge-jc-gold fs-6 mb-2">
                            FACTURA #PED-{{ str_pad($pedido->id, 5, '0', STR_PAD_LEFT) }}
                        </span>
                        <p class="text-muted small mb-1">
                            <strong>Fecha:</strong> {{ $pedido->created_at->format('d/m/Y h:i A') }}
                        </p>
                        <p class="mb-0">
                            <strong>Estado:</strong>
                            <span class="badge bg-warning text-dark">{{ $pedido->estado?->nombre ?? 'Pendiente' }}</span>
                        </p>
                    </div>
                </div>

                <!-- Datos del Cliente y Envío -->
                <div class="row g-4 mb-4 pb-4 border-bottom border-secondary">
                    <div class="col-sm-6">
                        <h6 class="text-warning text-uppercase small fw-bold mb-2">Facturado a:</h6>
                        <h6 class="text-white fw-bold mb-1">{{ $pedido->usuario->name }} {{ $pedido->usuario->apellido }}</h6>
                        <p class="text-muted small mb-1">C.C. {{ $pedido->usuario->cedula }}</p>
                        <p class="text-muted small mb-1">{{ $pedido->usuario->email }}</p>
                        <p class="text-muted small mb-0">Tel: {{ $pedido->usuario->telefono }}</p>
                    </div>
                    <div class="col-sm-6 text-sm-end">
                        <h6 class="text-warning text-uppercase small fw-bold mb-2">Dirección de Entrega:</h6>
                        <p class="text-white small mb-1 fw-bold">{{ $pedido->usuario->direccion }}</p>
                        <p class="text-muted small mb-1">Barrio: {{ $pedido->usuario->barrio }}</p>
                        <p class="text-muted small mb-0">Ciudad: {{ $pedido->usuario->ciudad }}</p>
                    </div>
                </div>

                <!-- Detalle de Productos Facturados -->
                <div class="table-responsive mb-4">
                    <table class="table table-dark table-borderless align-middle mb-0">
                        <thead>
                            <tr class="text-muted small border-bottom border-secondary">
                                <th>#</th>
                                <th>Descripción del Artículo</th>
                                <th class="text-center">Cant.</th>
                                <th class="text-end">Precio Unitario</th>
                                <th class="text-end">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pedido->detalles as $index => $detalle)
                                <tr class="border-bottom border-secondary border-opacity-25">
                                    <td class="text-muted small">{{ $index + 1 }}</td>
                                    <td>
                                        <div class="text-white fw-bold small">{{ $detalle->producto?->nombre ?? 'Producto Eliminado' }}</div>
                                        <small class="text-muted">{{ $detalle->producto?->marca?->nombre }}</small>
                                    </td>
                                    <td class="text-center fw-bold text-white">{{ $detalle->cantidad }}</td>
                                    <td class="text-end text-muted small">${{ number_format($detalle->precio_unitario, 0, ',', '.') }}</td>
                                    <td class="text-end text-white fw-bold">${{ number_format($detalle->cantidad * $detalle->precio_unitario, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Resumen de Totales -->
                <div class="row justify-content-end mb-4">
                    <div class="col-md-5">
                        <div class="p-3 rounded-3" style="background: var(--jc-black-soft); border: 1px solid var(--jc-border);">
                            <div class="d-flex justify-content-between text-muted small mb-2">
                                <span>Subtotal:</span>
                                <span>${{ number_format($pedido->total, 0, ',', '.') }} COP</span>
                            </div>
                            <div class="d-flex justify-content-between text-muted small mb-2">
                                <span>Envío Asegurado:</span>
                                <span class="text-success">Gratis</span>
                            </div>
                            <hr class="border-secondary my-2">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="fw-bold text-white fs-6">Total Pagado:</span>
                                <span class="fw-bolder text-warning fs-4">${{ number_format($pedido->total, 0, ',', '.') }} <small class="fs-6 text-muted">COP</small></span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Notas y Garantía -->
                <div class="border-top border-secondary pt-3 text-muted small">
                    <p class="mb-1"><strong>Términos & Garantía:</strong> Esta factura constituye comprobante de compra oficial de JC URBAN. Los relojes cuentan con 6 meses de garantía sobre la maquinaria. Perfumería y accesorios garantizados en autenticidad.</p>
                    <p class="mb-0 text-center text-secondary mt-3">¡Gracias por confiar en JC URBAN!</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
