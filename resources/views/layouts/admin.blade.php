<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') | JC URBAN Panel</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- App CSS -->
    <link rel="stylesheet" href="{{ asset('css/variables.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    @yield('styles')
</head>
<body>

<div class="admin-wrapper">
    <!-- ═══════════════════════════════════════════════════════════
         SIDEBAR
    ═══════════════════════════════════════════════════════════ -->
    <aside class="admin-sidebar">
        <div class="admin-sidebar-header">
            <a href="{{ route('admin.dashboard') }}" class="jc-logo">
                <span class="logo-jc">JC</span><span class="logo-urban">URBAN</span>
            </a>
            <span class="badge badge-jc-gold mt-2 d-inline-block">ADMINISTRADOR</span>
        </div>

        <ul class="admin-nav">
            <li class="admin-nav-item">
                <a href="{{ route('admin.dashboard') }}" class="admin-nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="admin-nav-item">
                <a href="{{ route('admin.productos.index') }}" class="admin-nav-link {{ request()->routeIs('admin.productos.*') ? 'active' : '' }}">
                    <i class="bi bi-box-seam"></i>
                    <span>Productos</span>
                </a>
            </li>
            <li class="admin-nav-item">
                <a href="{{ route('admin.categorias.index') }}" class="admin-nav-link {{ request()->routeIs('admin.categorias.*') ? 'active' : '' }}">
                    <i class="bi bi-folder2"></i>
                    <span>Categorías</span>
                </a>
            </li>
            <li class="admin-nav-item">
                <a href="{{ route('admin.subcategorias.index') }}" class="admin-nav-link {{ request()->routeIs('admin.subcategorias.*') ? 'active' : '' }}">
                    <i class="bi bi-diagram-3"></i>
                    <span>Subcategorías</span>
                </a>
            </li>
            <li class="admin-nav-item">
                <a href="{{ route('admin.marcas.index') }}" class="admin-nav-link {{ request()->routeIs('admin.marcas.*') ? 'active' : '' }}">
                    <i class="bi bi-tag"></i>
                    <span>Marcas</span>
                </a>
            </li>
            <li class="admin-nav-item">
                <a href="{{ route('admin.pedidos.index') }}" class="admin-nav-link {{ request()->routeIs('admin.pedidos.*') ? 'active' : '' }}">
                    <i class="bi bi-receipt-cutoff"></i>
                    <span>Pedidos</span>
                </a>
            </li>
            <li class="admin-nav-item">
                <a href="{{ route('admin.usuarios.index') }}" class="admin-nav-link {{ request()->routeIs('admin.usuarios.*') ? 'active' : '' }}">
                    <i class="bi bi-people"></i>
                    <span>Clientes</span>
                </a>
            </li>

            <li class="mt-4 pt-3 border-top border-secondary">
                <a href="{{ route('catalogo.index') }}" class="admin-nav-link text-info">
                    <i class="bi bi-shop"></i>
                    <span>Ir a la Tienda</span>
                </a>
            </li>
            <li class="admin-nav-item mt-1">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="admin-nav-link text-danger border-0 bg-transparent w-100 text-start">
                        <i class="bi bi-box-arrow-left"></i>
                        <span>Cerrar Sesión</span>
                    </button>
                </form>
            </li>
        </ul>
    </aside>

    <!-- ═══════════════════════════════════════════════════════════
         MAIN CONTENT AREA
    ═══════════════════════════════════════════════════════════ -->
    <main class="admin-content">
        <div class="admin-topbar">
            <div>
                <h4 class="mb-0 text-white fw-bold">@yield('page_title', 'Panel de Administración')</h4>
                <small class="text-muted">Control & Gestión de Tienda JC URBAN</small>
            </div>
            <div class="d-flex align-items-center gap-3">
                <div class="text-end d-none d-md-block">
                    <div class="text-white fw-bold">{{ auth()->user()->name }} {{ auth()->user()->apellido }}</div>
                    <small class="text-warning">Administrador</small>
                </div>
                <div class="btn-user">
                    <i class="bi bi-shield-lock-fill text-warning"></i>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success bg-opacity-10 border-success text-success d-flex align-items-center gap-2 mb-4" role="alert">
                <i class="bi bi-check-circle-fill fs-5"></i>
                <div>{{ session('success') }}</div>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger bg-opacity-10 border-danger text-danger d-flex align-items-center gap-2 mb-4" role="alert">
                <i class="bi bi-exclamation-triangle-fill fs-5"></i>
                <div>{{ session('error') }}</div>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger bg-opacity-10 border-danger text-danger mb-4" role="alert">
                <ul class="mb-0 ps-3">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </main>
</div>

<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    const JcSwal = Swal.mixin({
        background: '#1b1e22',
        color: '#f0f2f5',
        confirmButtonColor: '#D4AF37',
        cancelButtonColor: '#333942',
    });

    @if(session('swal_success'))
        JcSwal.fire({
            icon: 'success',
            title: '¡Éxito!',
            text: "{{ session('swal_success') }}",
            timer: 2500,
            showConfirmButton: false
        });
    @endif

    @if(session('swal_error'))
        JcSwal.fire({
            icon: 'error',
            title: 'Atención',
            text: "{{ session('swal_error') }}",
        });
    @endif
</script>

@yield('scripts')
</body>
</html>
