@extends('layouts.admin')

@section('title', 'Detalle Pedido #' . $pedido->id)
@section('page_title', 'Detalle de Pedido #PED-' . str_pad($pedido->id, 5, '0', STR_PAD_LEFT))

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <a href="{{ route('admin.pedidos.index') }}" class="btn-jc-outline btn-sm">
        <i class="bi bi-arrow-left me-1"></i>Volver a Pedidos
    </a>
    <span class="badge badge-jc-gold fs-6">
        Fecha: {{ $pedido->created_at->format('d/m/Y h:i A') }}
    </span>
</div>

<div class="row g-4">
    <!-- Columna Izquierda: Artículos del Pedido -->
    <div class="col-lg-8">
        <div class="jc-card p-4 mb-4">
            <h5 class="text-white fw-bold mb-3 border-bottom border-secondary pb-3">
                <i class="bi bi-box-seam me-2 text-warning"></i>Productos del Pedido
            </h5>

            <div class="table-responsive">
                <table class="jc-table">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th class="text-center">Cantidad</th>
                            <th class="text-end">Precio Unit.</th>
                            <th class="text-end">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pedido->detalles as $detalle)
                            @php
                                $imgObj = $detalle->producto?->imagenPrincipal();
                                $imgUrl = 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?auto=format&fit=crop&w=150&q=80';
                                if ($imgObj) {
                                    $imgUrl = str_starts_with($imgObj->url_imagen, 'http')
                                        ? $imgObj->url_imagen
                                        : asset('storage/' . $imgObj->url_imagen);
                                }
                            @endphp
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        <img src="{{ $imgUrl }}"
                                             alt="{{ $detalle->producto?->nombre }}"
                                             class="rounded"
                                             style="width: 50px; height: 50px; object-fit: cover;">
                                        <div>
                                            <div class="text-white fw-bold small">{{ $detalle->producto?->nombre ?? 'Producto Eliminado' }}</div>
                                            <small class="text-warning">{{ $detalle->producto?->marca?->nombre ?? 'Sin marca' }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center fw-bold text-white fs-6">
                                    {{ $detalle->cantidad }}
                                </td>
                                <td class="text-end text-muted small">
                                    ${{ number_format($detalle->precio_unitario, 0, ',', '.') }}
                                </td>
                                <td class="text-end text-white fw-bold">
                                    ${{ number_format($detalle->cantidad * $detalle->precio_unitario, 0, ',', '.') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Total General -->
            <div class="d-flex justify-content-end mt-4 pt-3 border-top border-secondary">
                <div class="text-end">
                    <span class="text-muted small d-block">Total Facturado</span>
                    <span class="text-warning fw-bolder fs-3">${{ number_format($pedido->total, 0, ',', '.') }} COP</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Columna Derecha: Gestión de Estado y Datos del Cliente (HU-21, HU-22) -->
    <div class="col-lg-4">
        <!-- Formulario Cambiar Estado (HU-22) -->
        <div class="jc-card p-4 mb-4 border border-warning">
            <h5 class="text-warning fw-bold mb-3 border-bottom border-secondary pb-2">
                <i class="bi bi-arrow-repeat me-2"></i>Actualizar Estado (HU-22)
            </h5>
            <form action="{{ route('admin.pedidos.estado', $pedido->id) }}" method="POST">
                @csrf
                @method('PATCH')

                <div class="mb-3">
                    <label for="id_estado" class="form-label">Estado del Pedido</label>
                    <select name="id_estado" id="id_estado" class="form-select fs-6 fw-bold">
                        @foreach($estados as $est)
                            <option value="{{ $est->id }}" {{ $pedido->id_estado == $est->id ? 'selected' : '' }}>
                                {{ $est->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn-jc-gold w-100 py-2">
                    <i class="bi bi-check2-circle me-1"></i>Guardar Nuevo Estado
                </button>
            </form>
        </div>

        <!-- Información del Cliente (HU-21) -->
        <div class="jc-card p-4">
            <h5 class="text-white fw-bold mb-3 border-bottom border-secondary pb-2">
                <i class="bi bi-person-lines-fill me-2 text-warning"></i>Datos del Cliente
            </h5>
            <div class="text-white small">
                <p class="mb-2"><strong>Cliente:</strong> {{ $pedido->usuario->name }} {{ $pedido->usuario->apellido }}</p>
                <p class="mb-2"><strong>Cédula:</strong> {{ $pedido->usuario->cedula }}</p>
                <p class="mb-2"><strong>Email:</strong> {{ $pedido->usuario->email }}</p>
                <p class="mb-2"><strong>Teléfono:</strong> {{ $pedido->usuario->telefono }}</p>
                <hr class="border-secondary my-2">
                <h6 class="text-warning small fw-bold mb-2">Destino de Entrega:</h6>
                <p class="mb-1"><strong>Ciudad:</strong> {{ $pedido->usuario->ciudad }}</p>
                <p class="mb-1"><strong>Barrio:</strong> {{ $pedido->usuario->barrio }}</p>
                <p class="mb-0"><strong>Dirección:</strong> {{ $pedido->usuario->direccion }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
