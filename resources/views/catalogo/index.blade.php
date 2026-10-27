@extends('layouts.app')

@section('title', 'Inicio - Lujo & Exclusividad')
@section('meta_description', 'Descubre lo mejor en relojes de lujo, perfumes exclusivos y accesorios de diseñador en JC URBAN.')

@section('content')
<!-- ═══════════════════════════════════════════════════════════
     HERO BANNER
═══════════════════════════════════════════════════════════ -->
<section class="hero-section position-relative py-5 overflow-hidden" style="background: radial-gradient(circle at 50% 30%, #1c2026 0%, #0c0d0e 80%); border-bottom: 1px solid var(--jc-border);">
    <div class="container py-md-5">
        <div class="row align-items-center g-5">
            <div class="col-lg-7 text-center text-lg-start">
                <span class="badge badge-jc-gold text-uppercase letter-spacing-2 mb-3">
                    <i class="bi bi-gem me-1"></i>Colección Exclusiva 2025
                </span>
                <h1 class="display-3 fw-bolder text-white mb-3" style="letter-spacing: -1px; line-height: 1.15;">
                    Lujo, Precisión & <span class="logo-jc">Distinción</span>
                </h1>
                <p class="lead text-muted mb-4" style="font-size: 1.15rem; max-width: 580px;">
                    Encuentra piezas icónicas de alta relojería, fragancias de autor y accesorios selectos con garantía oficial y envíos nacionales asegurados.
                </p>
                <div class="d-flex flex-wrap gap-3 justify-content-center justify-content-lg-start">
                    <a href="{{ route('catalogo.categoria', 1) }}" class="btn-jc-gold py-3 px-4">
                        <i class="bi bi-watch me-2"></i>Explorar Relojes
                    </a>
                    <a href="{{ route('catalogo.categoria', 2) }}" class="btn-jc-outline py-3 px-4">
                        <i class="bi bi-droplet me-2"></i>Ver Perfumes
                    </a>
                </div>

                <!-- Trust Badges -->
                <div class="row g-4 mt-4 pt-3 border-top border-secondary">
                    <div class="col-sm-4 text-center text-sm-start">
                        <div class="text-warning fw-bold fs-5 mb-0"><i class="bi bi-shield-check me-1"></i>6 Meses</div>
                        <small class="text-muted">Garantía en maquinaria</small>
                    </div>
                    <div class="col-sm-4 text-center text-sm-start">
                        <div class="text-warning fw-bold fs-5 mb-0"><i class="bi bi-truck me-1"></i>Nacional</div>
                        <small class="text-muted">Envíos 100% asegurados</small>
                    </div>
                    <div class="col-sm-4 text-center text-sm-start">
                        <div class="text-warning fw-bold fs-5 mb-0"><i class="bi bi-stars me-1"></i>Exclusivo</div>
                        <small class="text-muted">Marcas de alta gama</small>
                    </div>
                </div>
            </div>

            <div class="col-lg-5 text-center">
                <div class="position-relative d-inline-block">
                    <div style="position: absolute; inset: -15px; background: radial-gradient(circle, rgba(212,175,55,0.25) 0%, transparent 70%); filter: blur(25px); z-index: 1;"></div>
                    <img src="https://images.unsplash.com/photo-1522335789203-aabd1fc54bc9?auto=format&fit=crop&w=700&q=80"
                         alt="JC URBAN Reloj de Lujo"
                         class="img-fluid rounded-4 shadow-lg position-relative"
                         style="z-index: 2; border: 1px solid var(--jc-border-gold); max-height: 480px; object-fit: cover;">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════════
     CATEGORÍAS DESTACADAS (HU-06)
═══════════════════════════════════════════════════════════ -->
<section class="py-5">
    <div class="container py-md-4">
        <div class="text-center mb-5">
            <span class="text-warning text-uppercase fw-bold letter-spacing-2 small">Nuestras Líneas</span>
            <h2 class="fw-bolder text-white mt-1">Explora por Categoría</h2>
            <div style="width: 60px; height: 3px; background: var(--jc-gold-gradient); margin: 12px auto;"></div>
        </div>

        <div class="row g-4">
            @php
                $catImages = [
                    1 => 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?auto=format&fit=crop&w=800&q=80',
                    2 => 'https://images.unsplash.com/photo-1592945403244-b3fbafd7f539?auto=format&fit=crop&w=800&q=80',
                    3 => 'https://images.unsplash.com/photo-1627123424574-724758594e93?auto=format&fit=crop&w=800&q=80',
                ];
            @endphp

            @forelse($categorias as $categoria)
                <div class="col-md-4">
                    <a href="{{ route('catalogo.categoria', $categoria->id) }}" class="cat-card">
                        <img src="{{ $catImages[$categoria->id] ?? 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?auto=format&fit=crop&w=800&q=80' }}"
                             alt="{{ $categoria->nombre }}"
                             class="cat-card-bg">
                        <div class="cat-card-overlay"></div>
                        <div class="cat-card-content">
                            <span class="badge badge-jc-gold mb-2">Colección</span>
                            <h3 class="cat-card-title">{{ $categoria->nombre }}</h3>
                            <p class="cat-card-desc">{{ $categoria->descripcion }}</p>
                            <span class="btn-jc-gold btn-sm">
                                Ver Colección <i class="bi bi-arrow-right ms-1"></i>
                            </span>
                        </div>
                    </a>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <p class="text-muted">No hay categorías disponibles en este momento.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════════
     BANNER DE GARANTÍA & COMPROMISO
═══════════════════════════════════════════════════════════ -->
<section class="py-5" style="background: var(--jc-black-card); border-top: 1px solid var(--jc-border); border-bottom: 1px solid var(--jc-border);">
    <div class="container">
        <div class="row align-items-center g-4 text-center text-md-start">
            <div class="col-md-3">
                <div class="d-flex flex-column flex-md-row align-items-center gap-3">
                    <i class="bi bi-patch-check-fill fs-1 text-warning"></i>
                    <div>
                        <h6 class="text-white fw-bold mb-1">Garantía JC URBAN</h6>
                        <small class="text-muted">6 meses en maquinaria de relojes</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="d-flex flex-column flex-md-row align-items-center gap-3">
                    <i class="bi bi-box-seam-fill fs-1 text-warning"></i>
                    <div>
                        <h6 class="text-white fw-bold mb-1">Empaque de Lujo</h6>
                        <small class="text-muted">Cajas y certificados originales</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="d-flex flex-column flex-md-row align-items-center gap-3">
                    <i class="bi bi-credit-card-2-front-fill fs-1 text-warning"></i>
                    <div>
                        <h6 class="text-white fw-bold mb-1">Pagos Seguros</h6>
                        <small class="text-muted">Transferencia o contraentrega</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="d-flex flex-column flex-md-row align-items-center gap-3">
                    <i class="bi bi-whatsapp fs-1 text-success"></i>
                    <div>
                        <h6 class="text-white fw-bold mb-1">Atención VIP</h6>
                        <small class="text-muted">Asesoría personalizada por chat</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
