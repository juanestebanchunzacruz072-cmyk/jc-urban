@extends('layouts.app')

@section('title', 'Mi Perfil - JC URBAN')

@section('content')
<div class="container py-5">
    <div class="mb-4">
        <h2 class="fw-bold text-white mb-1">Mi Cuenta</h2>
        <p class="text-muted">Gestiona tus datos de entrega y consulta el historial de tus compras</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success bg-opacity-10 border-success text-success d-flex align-items-center gap-2 mb-4" role="alert">
            <i class="bi bi-check-circle-fill fs-5"></i>
            <div>{{ session('success') }}</div>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger bg-opacity-10 border-danger text-danger mb-4" role="alert">
            <ul class="mb-0 ps-3 small">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row g-4">
        <!-- Columna Izquierda: Información Personal y Formulario de Entrega (HU-05) -->
        <div class="col-lg-5">
            <!-- Datos de Cuenta (Lectura) -->
            <div class="jc-card p-4 mb-4">
                <div class="d-flex align-items-center gap-3 mb-3 border-bottom border-secondary pb-3">
                    <div class="btn-user fs-4 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                        <i class="bi bi-person-fill text-warning"></i>
                    </div>
                    <div>
                        <h5 class="text-white fw-bold mb-0">{{ $usuario->name }} {{ $usuario->apellido }}</h5>
                        <small class="text-muted">{{ $usuario->email }}</small>
                    </div>
                </div>

                <div class="row g-2 text-white small">
                    <div class="col-6 text-muted">Cédula:</div>
                    <div class="col-6 fw-bold text-end">{{ $usuario->cedula }}</div>

                    <div class="col-6 text-muted">Teléfono:</div>
                    <div class="col-6 fw-bold text-end">{{ $usuario->telefono }}</div>

                    <div class="col-6 text-muted">Tipo de Cuenta:</div>
                    <div class="col-6 text-end">
                        <span class="badge badge-jc-gold">{{ $usuario->rol?->nombre ?? 'Cliente' }}</span>
                    </div>
                </div>
            </div>

            <!-- Formulario de Actualización de Dirección (HU-05) -->
            <div class="jc-card p-4">
                <h5 class="text-warning fw-bold mb-3 border-bottom border-secondary pb-2">
                    <i class="bi bi-geo-alt me-2"></i>Dirección de Entrega
                </h5>
                <p class="text-muted small mb-3">
                    Mantén actualizada tu ubicación para garantizar la entrega puntual de tus pedidos.
                </p>

                <form action="{{ route('perfil.actualizar') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="ciudad" class="form-label">Ciudad</label>
                        <input type="text"
                               class="form-control @error('ciudad') is-invalid @enderror"
                               id="ciudad"
                               name="ciudad"
                               value="{{ old('ciudad', $usuario->ciudad) }}"
                               required>
                        @error('ciudad')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="barrio" class="form-label">Barrio</label>
                        <input type="text"
                               class="form-control @error('barrio') is-invalid @enderror"
                               id="barrio"
                               name="barrio"
                               value="{{ old('barrio', $usuario->barrio) }}"
                               required>
                        @error('barrio')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="direccion" class="form-label">Dirección Exacta</label>
                        <input type="text"
                               class="form-control @error('direccion') is-invalid @enderror"
                               id="direccion"
                               name="direccion"
                               value="{{ old('direccion', $usuario->direccion) }}"
                               required>
                        @error('direccion')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn-jc-gold w-100 py-2">
                        <i class="bi bi-check2-circle me-1"></i>Guardar Cambios
                    </button>
                </form>
            </div>
        </div>

        <!-- Columna Derecha: Historial de Pedidos (HU-17) -->
        <div class="col-lg-7">
            <div class="jc-card p-4">
                <div class="d-flex justify-content-between align-items-center mb-3 border-bottom border-secondary pb-2">
                    <h5 class="text-warning fw-bold mb-0">
                        <i class="bi bi-clock-history me-2"></i>Historial de Pedidos
                    </h5>
                    <span class="badge badge-jc-gold">{{ $pedidos->count() }} órdenes</span>
                </div>

                @if($pedidos->isEmpty())
                    <div class="text-center py-5">
                        <i class="bi bi-bag-x display-4 text-muted"></i>
                        <h6 class="text-white mt-3">Aún no has realizado pedidos</h6>
                        <p class="text-muted small">Descubre nuestras colecciones de lujo y estrena hoy mismo.</p>
                        <a href="{{ route('catalogo.index') }}" class="btn-jc-gold btn-sm mt-2">
                            Explorar Catálogo
                        </a>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-dark table-borderless align-middle mb-0">
                            <thead>
                                <tr class="text-muted small border-bottom border-secondary">
                                    <th>Pedido</th>
                                    <th>Fecha</th>
                                    <th>Artículos</th>
                                    <th>Total</th>
                                    <th>Estado</th>
                                    <th class="text-end">Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pedidos as $pedido)
                                    <tr class="border-bottom border-secondary border-opacity-25">
                                        <td>
                                            <span class="fw-bold text-white">#PED-{{ str_pad($pedido->id, 5, '0', STR_PAD_LEFT) }}</span>
                                        </td>
                                        <td class="text-muted small">
                                            {{ $pedido->created_at->format('d/m/Y') }}
                                        </td>
                                        <td class="text-white small">
                                            {{ $pedido->detalles->sum('cantidad') }} uds
                                        </td>
                                        <td class="text-warning fw-bold small">
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
                                            <a href="{{ route('checkout.factura', $pedido->id) }}"
                                               class="btn-jc-outline btn-sm py-1 px-2"
                                               style="font-size: 0.75rem;"
                                               title="Ver Factura">
                                                <i class="bi bi-file-earmark-text me-1"></i>Factura
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
    </div>
</div>
@endsection
