@extends('layouts.app')

@section('title', 'Inicio - Lujo & Exclusividad')
@section('meta_description', 'Descubre lo mejor en relojes de lujo, perfumes exclusivos y accesorios de diseñador en JC URBAN.')

@section('content')
<!-- ═══════════════════════════════════════════════════════════
     HERO BANNER CON VIDEO OFICIAL
═══════════════════════════════════════════════════════════ -->
<section class="hero-section position-relative py-5 overflow-hidden" style="background: radial-gradient(circle at 50% 30%, #1c2026 0%, #0c0d0e 85%); border-bottom: 1px solid var(--jc-border);">
    <div class="container py-md-5">
        <div class="row align-items-center g-5">
            <div class="col-lg-6 text-center text-lg-start">
                <span class="badge badge-jc-gold text-uppercase letter-spacing-2 mb-3">
                    <i class="bi bi-gem me-1"></i>JC URBAN EXCLUSIVE
                </span>
                <h1 class="display-3 fw-bolder text-white mb-3" style="letter-spacing: -1px; line-height: 1.15;">
                    Estilo sin <span class="logo-jc">Límites</span>
                </h1>
                <p class="lead text-muted mb-4" style="font-size: 1.15rem; max-width: 580px;">
                    Descubre nuestro catálogo de puro lujo y exclusividad. Relojería suiza de alta precisión, perfumería de autor y accesorios de diseñador con garantía total.
                </p>
                <div class="d-flex flex-wrap gap-3 justify-content-center justify-content-lg-start">
                    <a href="{{ route('catalogo.categoria', 1) }}" class="btn-jc-gold py-3 px-4">
                        <i class="bi bi-bag-check me-2"></i>Explorar Catálogo
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

            <!-- Video Oficial Reproduciéndose en Bucle -->
            <div class="col-lg-6 text-center">
                <div class="position-relative d-inline-block w-100">
                    <div style="position: absolute; inset: -15px; background: radial-gradient(circle, rgba(212,175,55,0.35) 0%, transparent 70%); filter: blur(25px); z-index: 1;"></div>
                    <div class="rounded-4 overflow-hidden shadow-lg position-relative" style="z-index: 2; border: 2px solid var(--jc-border-gold); background: #000; box-shadow: 0 15px 45px rgba(0,0,0,0.8);">
                        <video autoplay loop muted playsinline class="w-100 d-block" style="max-height: 460px; object-fit: cover;">
                            <source src="{{ asset('videos/relojes_hero.mp4') }}" type="video/mp4">
                            <source src="{{ asset('videos/video%20de%20relojes.mp4') }}" type="video/mp4">
                            Tu navegador no soporta la reproducción de video HTML5.
                        </video>
                    </div>
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
