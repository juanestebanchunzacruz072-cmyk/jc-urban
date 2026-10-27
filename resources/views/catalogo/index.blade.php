@extends('layouts.app')

@section('title', 'Inicio - Lujo & Exclusividad')
@section('meta_description', 'Descubre lo mejor en relojes de lujo, perfumes exclusivos y accesorios de diseñador en JC URBAN.')

@section('content')
<!-- ═══════════════════════════════════════════════════════════
     CATEGORÍAS (EXACTO AL SCREENSHOT DEL USUARIO)
═══════════════════════════════════════════════════════════ -->
<section class="cat-showcase-section">
    <div class="container">
        <h1 class="cat-showcase-heading">Categorías</h1>

        <div class="row g-4 justify-content-center">
            <!-- 1. Relojes -->
            <div class="col-md-4">
                <a href="{{ route('catalogo.categoria', 1) }}" class="cat-showcase-card">
                    <div class="cat-showcase-img-box">
                        <img src="{{ asset('img/categorias/relojes.jpg') }}"
                             alt="Relojes"
                             class="cat-showcase-img">
                    </div>
                    <h2 class="cat-showcase-name">Relojes</h2>
                </a>
            </div>

            <!-- 2. Perfumes -->
            <div class="col-md-4">
                <a href="{{ route('catalogo.categoria', 2) }}" class="cat-showcase-card">
                    <div class="cat-showcase-img-box">
                        <img src="{{ asset('img/categorias/perfumes.jpg') }}"
                             alt="Perfumes"
                             class="cat-showcase-img">
                    </div>
                    <h2 class="cat-showcase-name">Perfumes</h2>
                </a>
            </div>

            <!-- 3. Accesorios (con aura dorada en hover exacto al screenshot) -->
            <div class="col-md-4">
                <a href="{{ route('catalogo.categoria', 3) }}" class="cat-showcase-card">
                    <div class="cat-showcase-img-box">
                        <img src="{{ asset('img/categorias/accesorios.jpg') }}"
                             alt="Accesorios"
                             class="cat-showcase-img">
                    </div>
                    <h2 class="cat-showcase-name">Accesorios</h2>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════════
     HERO BANNER CON VIDEO OFICIAL DE RELOJES
═══════════════════════════════════════════════════════════ -->
<section class="hero-section position-relative py-5 overflow-hidden" style="background: radial-gradient(circle at 50% 30%, #1c2026 0%, #0c0d0e 85%); border-top: 1px solid #e2e8f0; border-bottom: 1px solid var(--jc-border);">
    <div class="container py-md-5">
        <div class="row align-items-center g-5">
            <div class="col-lg-6 text-center text-lg-start">
                <span class="badge badge-jc-gold text-uppercase letter-spacing-2 mb-3">
                    <i class="bi bi-gem me-1"></i>JC URBAN EXCLUSIVE
                </span>
                <h2 class="display-4 fw-bolder text-white mb-3" style="letter-spacing: -1px; line-height: 1.15;">
                    Estilo sin <span class="logo-jc">Límites</span>
                </h2>
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
