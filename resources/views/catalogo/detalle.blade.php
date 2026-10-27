@extends('layouts.app')

@section('title', $producto->nombre . ' - JC URBAN')
@section('meta_description', Str::limit(strip_tags($producto->descripcion), 150))

@section('content')
<div class="container py-5">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('catalogo.index') }}" class="text-warning text-decoration-none">Inicio</a></li>
            <li class="breadcrumb-item">
                <a href="{{ route('catalogo.categoria', $producto->id_categoria) }}" class="text-warning text-decoration-none">
                    {{ $producto->categoria?->nombre }}
                </a>
            </li>
            <li class="breadcrumb-item active text-white" aria-current="page">{{ $producto->nombre }}</li>
        </ol>
    </nav>

    <div class="row g-5">
        <!-- Columna de Imágenes -->
        <div class="col-lg-6">
            <div class="position-sticky" style="top: 100px;">
                @php
                    $imagenPrincipal = $producto->imagenPrincipal()?->url_imagen
                        ?? 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?auto=format&fit=crop&w=700&q=80';
                @endphp
                <div class="jc-card p-3 mb-3 text-center" style="background: #111315;">
                    <img id="mainProductImage"
                         src="{{ $imagenPrincipal }}"
                         alt="{{ $producto->nombre }}"
                         class="img-fluid rounded-3"
                         style="max-height: 480px; width: 100%; object-fit: contain; transition: all 0.3s ease;">
                </div>

                <!-- Miniaturas si tiene múltiples imágenes -->
                @if($producto->imagenes->count() > 1)
                    <div class="d-flex gap-2 overflow-x-auto pb-2">
                        @foreach($producto->imagenes as $img)
                            <img src="{{ $img->url_imagen }}"
                                 alt="Miniatura"
                                 class="rounded border border-secondary p-1 thumbnail-selector"
                                 style="width: 75px; height: 75px; object-fit: cover; cursor: pointer;"
                                 onclick="cambiarImagenPrincipal('{{ $img->url_imagen }}', this)">
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        <!-- Columna de Información del Producto (HU-08) -->
        <div class="col-lg-6">
            @if($producto->marca)
                <span class="badge badge-jc-gold text-uppercase letter-spacing-1 mb-2">
                    {{ $producto->marca->nombre }}
                </span>
            @endif

            <h1 class="display-6 fw-bold text-white mb-2">{{ $producto->nombre }}</h1>
            <p class="text-muted small mb-3">
                Categoría: <span class="text-white">{{ $producto->categoria?->nombre }}</span> |
                Subcategoría: <span class="text-white">{{ $producto->subcategoria?->nombre ?? 'General' }}</span>
            </p>

            <!-- Precio -->
            <div class="d-flex align-items-baseline gap-3 mb-4 p-3 rounded-3" style="background: var(--jc-black-card); border-left: 4px solid var(--jc-gold);">
                <span class="fs-2 fw-bolder text-warning">
                    ${{ number_format($producto->precio, 0, ',', '.') }}
                </span>
                <span class="text-muted small">COP (IVA Incluido)</span>
            </div>

            <!-- Estado de Stock -->
            <div class="mb-4">
                @if($producto->stock > 0)
                    <div class="d-flex align-items-center gap-2 text-success">
                        <i class="bi bi-check-circle-fill"></i>
                        <span class="fw-semibold">En Stock: {{ $producto->stock }} unidades disponibles</span>
                    </div>
                @else
                    <div class="d-flex align-items-center gap-2 text-danger">
                        <i class="bi bi-x-circle-fill"></i>
                        <span class="fw-semibold">Actualmente Agotado</span>
                    </div>
                @endif
            </div>

            <!-- Selector de Cantidad y Botón Comprar -->
            @if($producto->stock > 0)
                <div class="mb-4">
                    <label class="form-label text-muted small">Cantidad a comprar:</label>
                    <div class="d-flex align-items-center gap-3">
                        <div class="cart-item-qty" style="padding: 4px 8px; border-radius: 8px;">
                            <button type="button" class="qty-btn" onclick="ajustarCantidadDetalle(-1)">
                                <i class="bi bi-dash fs-5"></i>
                            </button>
                            <span class="qty-value px-3 fs-5" id="cantidadDetalle">1</span>
                            <button type="button" class="qty-btn" onclick="ajustarCantidadDetalle(1, {{ $producto->stock }})">
                                <i class="bi bi-plus fs-5"></i>
                            </button>
                        </div>

                        <button type="button"
                                class="btn-jc-gold flex-grow-1 py-3"
                                onclick="agregarAlCarritoConCantidad({{ $producto->id }}, '{{ addslashes($producto->nombre) }}', {{ $producto->precio }}, '{{ $imagenPrincipal }}', {{ $producto->stock }})">
                            <i class="bi bi-bag-plus-fill me-2 fs-5"></i>Agregar al Carrito
                        </button>
                    </div>
                </div>
            @endif

            <!-- Descripción Detallada -->
            <div class="jc-card p-4 mb-4">
                <h5 class="text-white fw-bold mb-3 border-bottom border-secondary pb-2">
                    <i class="bi bi-info-circle me-2 text-warning"></i>Descripción del Producto
                </h5>
                <div class="text-muted" style="line-height: 1.7;">
                    {!! nl2br(e($producto->descripcion)) !!}
                </div>
            </div>

            <!-- Garantía y Entrega JC URBAN -->
            <div class="row g-3">
                <div class="col-sm-6">
                    <div class="jc-card p-3 h-100 d-flex gap-3 align-items-center">
                        <i class="bi bi-shield-check fs-2 text-warning"></i>
                        <div>
                            <h6 class="text-white fw-bold mb-0">Garantía JC URBAN</h6>
                            <small class="text-muted">6 meses maquinaria</small>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="jc-card p-3 h-100 d-flex gap-3 align-items-center">
                        <i class="bi bi-truck fs-2 text-warning"></i>
                        <div>
                            <h6 class="text-white fw-bold mb-0">Envío Asegurado</h6>
                            <small class="text-muted">Entrega 2-4 días hábiles</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ═══════════════════════════════════════════════════════════
         TAMBIÉN TE PUEDE GUSTAR (HU-09)
    ═══════════════════════════════════════════════════════════ -->
    @if($productosRelacionados->isNotEmpty())
        <div class="mt-5 pt-5 border-top border-secondary">
            <div class="mb-4">
                <span class="badge badge-jc-gold mb-1"><i class="bi bi-stars me-1"></i>Recomendados</span>
                <h3 class="fw-bold text-white mb-0">También te puede gustar</h3>
            </div>

            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-4">
                @foreach($productosRelacionados as $rel)
                    @php
                        $relImg = $rel->imagenPrincipal()?->url_imagen
                            ?? 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?auto=format&fit=crop&w=400&q=80';
                    @endphp
                    <div class="col">
                        <div class="jc-card product-card">
                            <div class="product-img-wrapper">
                                <a href="{{ route('catalogo.detalle', $rel->id) }}">
                                    <img src="{{ $relImg }}"
                                         alt="{{ $rel->nombre }}"
                                         class="product-img">
                                </a>
                                @if($rel->marca)
                                    <span class="product-badge-brand">{{ $rel->marca->nombre }}</span>
                                @endif
                            </div>
                            <div class="product-body">
                                <a href="{{ route('catalogo.detalle', $rel->id) }}" class="product-title">
                                    {{ $rel->nombre }}
                                </a>
                                <div class="d-flex justify-content-between align-items-center mt-3 pt-2 border-top border-secondary">
                                    <div class="product-price">${{ number_format($rel->precio, 0, ',', '.') }}</div>
                                    <button type="button"
                                            class="btn-jc-gold btn-sm"
                                            onclick="agregarAlCarrito({{ $rel->id }}, '{{ addslashes($rel->nombre) }}', {{ $rel->precio }}, '{{ $relImg }}', {{ $rel->stock }})">
                                        <i class="bi bi-bag-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection

@section('scripts')
<script>
    let cantidadSeleccionada = 1;

    function ajustarCantidadDetalle(delta, maxStock = 999) {
        const span = document.getElementById('cantidadDetalle');
        let nuevaCantidad = cantidadSeleccionada + delta;
        if (nuevaCantidad < 1) nuevaCantidad = 1;
        if (nuevaCantidad > maxStock) {
            nuevaCantidad = maxStock;
            JcSwal.fire({
                icon: 'warning',
                title: 'Límite de stock',
                text: `Solo hay ${maxStock} unidades disponibles en inventario.`
            });
        }
        cantidadSeleccionada = nuevaCantidad;
        span.textContent = cantidadSeleccionada;
    }

    function agregarAlCarritoConCantidad(id, nombre, precio, imagen, maxStock) {
        for (let i = 0; i < cantidadSeleccionada; i++) {
            agregarAlCarrito(id, nombre, precio, imagen, maxStock);
        }
    }

    function cambiarImagenPrincipal(url, el) {
        document.getElementById('mainProductImage').src = url;
        document.querySelectorAll('.thumbnail-selector').forEach(thumb => {
            thumb.classList.remove('border-warning');
            thumb.classList.add('border-secondary');
        });
        el.classList.remove('border-secondary');
        el.classList.add('border-warning');
    }
</script>
@endsection
