@extends('layouts.app')

@section('title', $categoria->nombre . ' - JC URBAN')
@section('meta_description', 'Explora nuestra colección de ' . $categoria->nombre . ' en JC URBAN.')

@section('content')
<div class="container py-5">
    <!-- Breadcrumb & Header -->
    <div class="mb-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('catalogo.index') }}" class="text-warning text-decoration-none">Inicio</a></li>
                <li class="breadcrumb-item active text-white" aria-current="page">{{ $categoria->nombre }}</li>
            </ol>
        </nav>
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end gap-3 pb-3 border-bottom border-secondary">
            <div>
                <span class="badge badge-jc-gold text-uppercase mb-2">Colección Oficial</span>
                <h1 class="fw-bold text-white mb-1">{{ $categoria->nombre }}</h1>
                <p class="text-muted mb-0">{{ $categoria->descripcion }}</p>
            </div>
            <div class="text-muted small">
                Mostrando <strong class="text-white">{{ $productos->count() }}</strong> productos disponibles
            </div>
        </div>
    </div>

    <!-- Filtros por Subcategoría (HU-07) -->
    <div class="d-flex flex-wrap gap-2 mb-4 align-items-center">
        <span class="text-muted small me-2"><i class="bi bi-funnel me-1"></i>Filtrar por:</span>
        <a href="{{ route('catalogo.categoria', $categoria->id) }}"
           class="pill-filter {{ !request('subcategoria') ? 'active' : '' }}">
            Todos
        </a>
        @foreach($subcategorias as $subcat)
            <a href="{{ route('catalogo.categoria', ['id' => $categoria->id, 'subcategoria' => $subcat->id]) }}"
               class="pill-filter {{ request('subcategoria') == $subcat->id ? 'active' : '' }}">
                {{ $subcat->nombre }}
            </a>
        @endforeach
    </div>

    <!-- Grid de Productos -->
    @if($productos->isEmpty())
        <div class="text-center py-5 jc-card my-4">
            <i class="bi bi-box2 display-3 text-muted"></i>
            <h5 class="text-white mt-3">No hay productos en esta categoría por el momento</h5>
            <p class="text-muted small">Intenta seleccionando otra subcategoría o vuelve más tarde.</p>
            <a href="{{ route('catalogo.categoria', $categoria->id) }}" class="btn-jc-outline mt-2">
                Ver todos los {{ $categoria->nombre }}
            </a>
        </div>
    @else
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4 mb-5">
            @foreach($productos as $producto)
                @php
                    $img = $producto->imagenPrincipal()?->url_imagen
                        ?? 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?auto=format&fit=crop&w=500&q=80';
                @endphp
                <div class="col">
                    <div class="jc-card product-card">
                        <div class="product-img-wrapper">
                            <a href="{{ route('catalogo.detalle', $producto->id) }}">
                                <img src="{{ $img }}"
                                     alt="{{ $producto->nombre }}"
                                     class="product-img"
                                     loading="lazy">
                            </a>
                            @if($producto->marca)
                                <span class="product-badge-brand">{{ $producto->marca->nombre }}</span>
                            @endif
                        </div>
                        <div class="product-body">
                            <span class="product-category">
                                {{ $producto->subcategoria?->nombre ?? $categoria->nombre }}
                            </span>
                            <a href="{{ route('catalogo.detalle', $producto->id) }}" class="product-title">
                                {{ $producto->nombre }}
                            </a>
                            <div class="d-flex justify-content-between align-items-center mt-3 pt-2 border-top border-secondary">
                                <div>
                                    <span class="text-muted small d-block">Precio</span>
                                    <div class="product-price">${{ number_format($producto->precio, 0, ',', '.') }}</div>
                                </div>
                                @if($producto->stock > 0)
                                    <button type="button"
                                            class="btn-jc-gold btn-sm"
                                            onclick="agregarAlCarrito({{ $producto->id }}, '{{ addslashes($producto->nombre) }}', {{ $producto->precio }}, '{{ $img }}', {{ $producto->stock }})"
                                            title="Agregar al Carrito">
                                        <i class="bi bi-bag-plus"></i>
                                    </button>
                                @else
                                    <span class="badge bg-danger small">Agotado</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <!-- ═══════════════════════════════════════════════════════════
         TAMBIÉN TE PUEDE GUSTAR (HU-09)
    ═══════════════════════════════════════════════════════════ -->
    @if($productosRelacionados->isNotEmpty())
        <div class="mt-5 pt-4 border-top border-secondary">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <span class="badge badge-jc-gold mb-1"><i class="bi bi-stars me-1"></i>Recomendados</span>
                    <h3 class="fw-bold text-white mb-0">También te puede gustar</h3>
                </div>
            </div>

            <div class="row row-cols-2 row-cols-md-3 row-cols-lg-6 g-3">
                @foreach($productosRelacionados as $rel)
                    @php
                        $relImg = $rel->imagenPrincipal()?->url_imagen
                            ?? 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?auto=format&fit=crop&w=300&q=80';
                    @endphp
                    <div class="col">
                        <div class="jc-card h-100 p-2 text-center">
                            <a href="{{ route('catalogo.detalle', $rel->id) }}" class="text-decoration-none">
                                <img src="{{ $relImg }}"
                                     alt="{{ $rel->nombre }}"
                                     class="img-fluid rounded-2 mb-2"
                                     style="height: 120px; width: 100%; object-fit: cover;">
                                <h6 class="text-white small fw-bold text-truncate mb-1" title="{{ $rel->nombre }}">
                                    {{ $rel->nombre }}
                                </h6>
                                <p class="text-warning fw-bold small mb-2">
                                    ${{ number_format($rel->precio, 0, ',', '.') }}
                                </p>
                            </a>
                            <button type="button"
                                    class="btn-jc-outline btn-sm w-100 py-1"
                                    style="font-size: 0.75rem;"
                                    onclick="agregarAlCarrito({{ $rel->id }}, '{{ addslashes($rel->nombre) }}', {{ $rel->precio }}, '{{ $relImg }}', {{ $rel->stock }})">
                                <i class="bi bi-cart-plus me-1"></i>Agregar
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection
