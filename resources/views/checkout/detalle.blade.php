@extends('layouts.app')

@section('title', 'Confirmar Pedido - JC URBAN')

@section('content')
<div class="container py-5">
    <div class="mb-4">
        <h2 class="fw-bold text-white mb-1">Resumen & Confirmación de Pedido</h2>
        <p class="text-muted">Revisa tus productos y tus datos de entrega antes de finalizar la compra</p>
    </div>

    @if(session('error'))
        <div class="alert alert-danger bg-opacity-10 border-danger text-danger d-flex align-items-center gap-2 mb-4" role="alert">
            <i class="bi bi-exclamation-triangle-fill"></i>
            <div>{{ session('error') }}</div>
        </div>
    @endif

    <div class="row g-4">
        <!-- Columna Izquierda: Artículos del Pedido -->
        <div class="col-lg-7">
            <div class="jc-card p-4 mb-4">
                <h5 class="text-warning fw-bold mb-3 border-bottom border-secondary pb-2">
                    <i class="bi bi-bag-check me-2"></i>Artículos Seleccionados ({{ count($items) }})
                </h5>

                <div class="table-responsive">
                    <table class="table table-dark table-borderless align-middle mb-0">
                        <thead>
                            <tr class="text-muted small border-bottom border-secondary">
                                <th>Producto</th>
                                <th class="text-center">Cant.</th>
                                <th class="text-end">Precio</th>
                                <th class="text-end">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($items as $item)
                                @php
                                    $img = $item['producto']->imagenPrincipal()?->url_imagen
                                        ?? 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?auto=format&fit=crop&w=150&q=80';
                                @endphp
                                <tr class="border-bottom border-secondary border-opacity-25">
                                    <td>
                                        <div class="d-flex align-items-center gap-3">
                                            <img src="{{ $img }}"
                                                 alt="{{ $item['producto']->nombre }}"
                                                 class="rounded"
                                                 style="width: 55px; height: 55px; object-fit: cover;">
                                            <div>
                                                <div class="text-white fw-bold small">{{ $item['producto']->nombre }}</div>
                                                <small class="text-muted">{{ $item['producto']->marca?->nombre }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center fw-bold text-white">{{ $item['cantidad'] }}</td>
                                    <td class="text-end text-muted small">${{ number_format($item['producto']->precio, 0, ',', '.') }}</td>
                                    <td class="text-end text-warning fw-bold">${{ number_format($item['subtotal'], 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Políticas y Garantías -->
            <div class="jc-card p-4">
                <h6 class="text-white fw-bold mb-2"><i class="bi bi-shield-lock-fill text-warning me-2"></i>Compra Protegida con JC URBAN</h6>
                <p class="text-muted small mb-0">
                    Tu pedido incluye empaque de seguridad, certificado de garantía y seguimiento en tiempo real. Si tienes alguna inquietud con tu envío, nuestro equipo de soporte VIP está listo para ayudarte.
                </p>
            </div>
        </div>

        <!-- Columna Derecha: Datos de Envío y Botón de Pago -->
        <div class="col-lg-5">
            <!-- Datos de Envío (HU-15) -->
            <div class="jc-card p-4 mb-4">
                <div class="d-flex justify-content-between align-items-center mb-3 border-bottom border-secondary pb-2">
                    <h5 class="text-warning fw-bold mb-0">
                        <i class="bi bi-geo-alt-fill me-2"></i>Datos de Entrega
                    </h5>
                    <a href="{{ route('perfil.index') }}" class="text-warning small text-decoration-none">
                        <i class="bi bi-pencil-square me-1"></i>Cambiar
                    </a>
                </div>

                <div class="text-white small">
                    <p class="mb-1"><strong>Destinatario:</strong> {{ $usuario->name }} {{ $usuario->apellido }}</p>
                    <p class="mb-1"><strong>Cédula:</strong> {{ $usuario->cedula }}</p>
                    <p class="mb-1"><strong>Teléfono:</strong> {{ $usuario->telefono }}</p>
                    <p class="mb-1"><strong>Ciudad:</strong> {{ $usuario->ciudad }}</p>
                    <p class="mb-1"><strong>Barrio:</strong> {{ $usuario->barrio }}</p>
                    <p class="mb-0"><strong>Dirección:</strong> {{ $usuario->direccion }}</p>
                </div>
            </div>

            <!-- Resumen Total y Botón de Confirmación -->
            <div class="jc-card p-4">
                <h5 class="text-white fw-bold mb-3 border-bottom border-secondary pb-2">Resumen Financiero</h5>

                <div class="d-flex justify-content-between text-muted small mb-2">
                    <span>Subtotal de productos:</span>
                    <span>${{ number_format($total, 0, ',', '.') }} COP</span>
                </div>
                <div class="d-flex justify-content-between text-muted small mb-3">
                    <span>Costo de envío:</span>
                    <span class="text-success fw-bold">GRATIS</span>
                </div>

                <hr class="border-secondary my-3">

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <span class="fs-5 fw-bold text-white">Total a Pagar:</span>
                    <span class="fs-3 fw-bolder text-warning">${{ number_format($total, 0, ',', '.') }} <small class="fs-6 text-muted">COP</small></span>
                </div>

                <form action="{{ route('checkout.confirmar') }}" method="POST" id="formConfirmarPedido">
                    @csrf
                    <button type="submit" class="btn-jc-gold w-100 py-3 fw-bold fs-6" id="btnConfirmarPedido">
                        <i class="bi bi-lock-fill me-2"></i>Confirmar y Realizar Pedido
                    </button>
                </form>

                <div class="text-center mt-3">
                    <small class="text-muted"><i class="bi bi-shield-check me-1"></i>Transacción 100% Segura & Encriptada</small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.getElementById('formConfirmarPedido').addEventListener('submit', function() {
        // Limpia el carrito en el navegador al completar la compra
        localStorage.removeItem('jc_carrito');
    });
</script>
@endsection
