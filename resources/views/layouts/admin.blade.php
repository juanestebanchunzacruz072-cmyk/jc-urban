<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') | JC URBAN</title>

    <!-- Google Fonts: Montserrat -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        :root {
            --jc-gold: #cca028;
            --jc-gold-hover: #b58e22;
            --jc-sidebar-bg: #000000;
            --jc-body-bg: #f8f9fa;
            --jc-text-dark: #111827;
            --jc-text-muted: #64748b;
            --jc-border-light: #eef2f6;
            --jc-card-bg: #ffffff;
        }

        body {
            background-color: var(--jc-body-bg);
            color: var(--jc-text-dark);
            font-family: 'Montserrat', sans-serif;
            min-height: 100vh;
            margin: 0;
            padding: 0;
        }

        /* ═══════════════════════════════════════════════════════════
           SIDEBAR EXACTO A LAS IMÁGENES
        ═══════════════════════════════════════════════════════════ */
        .admin-sidebar {
            width: 250px;
            background-color: var(--jc-sidebar-bg);
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 1040;
            display: flex;
            flex-direction: column;
            border-right: 1px solid #1a1a1a;
        }

        .sidebar-brand {
            padding: 1.8rem 1.5rem 1rem;
        }
        .sidebar-brand-title {
            color: var(--jc-gold);
            font-size: 1.35rem;
            font-weight: 900;
            letter-spacing: 1px;
            margin: 0;
            text-transform: uppercase;
            text-decoration: none;
            display: block;
        }
        .sidebar-brand-sub {
            color: #71717a;
            font-size: 0.65rem;
            font-weight: 700;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            margin-top: 4px;
        }

        .sidebar-section-title {
            color: #52525b;
            font-size: 0.7rem;
            font-weight: 800;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            padding: 1.2rem 1.5rem 0.5rem;
        }

        .sidebar-menu {
            list-style: none;
            padding: 0;
            margin: 0;
            flex: 1;
            overflow-y: auto;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 0.85rem;
            padding: 0.7rem 1.5rem;
            color: #a1a1aa;
            text-decoration: none;
            font-size: 0.82rem;
            font-weight: 700;
            letter-spacing: 0.8px;
            text-transform: uppercase;
            transition: all 0.2s ease;
        }
        .sidebar-link i {
            font-size: 1.15rem;
            width: 20px;
            text-align: center;
        }
        .sidebar-link:hover {
            color: #ffffff;
        }
        .sidebar-link.active {
            color: var(--jc-gold);
        }
        .sidebar-link.active i {
            color: var(--jc-gold);
        }

        .sidebar-user {
            padding: 1.25rem 1.5rem;
            border-top: 1px solid #18181b;
            background: #09090b;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .user-avatar-circle {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background-color: var(--jc-gold);
            color: #000000;
            font-weight: 900;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.95rem;
        }
        .user-info-name {
            color: #ffffff;
            font-weight: 700;
            font-size: 0.82rem;
            line-height: 1.2;
        }
        .user-info-email {
            color: #71717a;
            font-size: 0.72rem;
        }
        .btn-logout-sidebar {
            background: transparent;
            border: none;
            color: #71717a;
            font-size: 1.1rem;
            cursor: pointer;
            padding: 4px;
            transition: color 0.2s ease;
        }
        .btn-logout-sidebar:hover {
            color: #ef4444;
        }

        /* ═══════════════════════════════════════════════════════════
           MAIN CONTENT AREA
        ═══════════════════════════════════════════════════════════ */
        .admin-main {
            margin-left: 250px;
            padding: 2rem 2.5rem;
            min-height: 100vh;
        }

        /* Top bar */
        .admin-header-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.75rem;
        }
        .admin-page-title {
            font-size: 1.5rem;
            font-weight: 900;
            color: #0f172a;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin: 0;
        }
        .admin-header-actions {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        .badge-online {
            color: #64748b;
            font-size: 0.85rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .badge-online::before {
            content: '';
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background-color: #22c55e;
            display: inline-block;
        }
        .btn-white-action {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            color: #1e293b;
            padding: 0.45rem 1rem;
            border-radius: 6px;
            font-size: 0.82rem;
            font-weight: 700;
            text-transform: uppercase;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all 0.2s ease;
        }
        .btn-white-action:hover {
            background: #f8fafc;
            border-color: #cbd5e1;
            color: #000;
        }

        /* Subheader */
        .admin-welcome-title {
            color: var(--jc-gold);
            font-size: 1.15rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 0.2rem;
        }
        .admin-welcome-sub {
            color: #64748b;
            font-size: 0.88rem;
            margin-bottom: 1.75rem;
        }

        /* Metric Cards */
        .metric-card-white {
            background: #ffffff;
            border: 1px solid #f1f5f9;
            border-radius: 12px;
            padding: 1.25rem 1.5rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.03);
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .metric-icon-box {
            width: 42px;
            height: 42px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            margin-bottom: 1rem;
        }
        .icon-box-yellow {
            background-color: #fef9c3;
            color: #ca8a04;
        }
        .icon-box-blue {
            background-color: #e0f2fe;
            color: #0284c7;
        }
        .icon-box-green {
            background-color: #dcfce7;
            color: #16a34a;
        }
        .icon-box-red {
            background-color: #ffe4e6;
            color: #e11d48;
        }
        .metric-val {
            font-size: 1.75rem;
            font-weight: 900;
            line-height: 1.2;
            color: #0f172a;
        }
        .metric-val.val-gold {
            color: var(--jc-gold);
        }
        .metric-lbl {
            color: #64748b;
            font-size: 0.72rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            margin-top: 4px;
        }

        /* White Content Card */
        .white-box-card {
            background: #ffffff;
            border: 1px solid #f1f5f9;
            border-radius: 14px;
            padding: 1.5rem;
            box-shadow: 0 1px 4px rgba(0,0,0,0.03);
            margin-top: 1.5rem;
        }
        .box-card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.25rem;
        }
        .box-card-title {
            color: #475569;
            font-size: 0.95rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin: 0;
        }

        /* Buttons */
        .btn-gold-action {
            background-color: var(--jc-gold);
            color: #000000 !important;
            font-weight: 800;
            font-size: 0.78rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 0.55rem 1.25rem;
            border-radius: 6px;
            border: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            text-decoration: none;
            cursor: pointer;
            transition: background 0.2s ease;
        }
        .btn-gold-action:hover {
            background-color: var(--jc-gold-hover);
        }

        /* Square action icons (Edit, View, Delete) */
        .btn-sq {
            width: 32px;
            height: 32px;
            border-radius: 6px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: none;
            color: #ffffff;
            font-size: 0.85rem;
            cursor: pointer;
            transition: opacity 0.2s ease;
            text-decoration: none;
        }
        .btn-sq:hover {
            opacity: 0.85;
            color: #fff;
        }
        .btn-sq-gold {
            background-color: var(--jc-gold);
        }
        .btn-sq-slate {
            background-color: #64748b;
        }
        .btn-sq-red {
            background-color: #dc2626;
        }

        /* Tables matching screenshots */
        .jc-admin-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }
        .jc-admin-table th {
            color: #64748b;
            font-size: 0.72rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            padding: 0.85rem 1rem;
            border-bottom: 1px solid #f1f5f9;
            background: #ffffff;
        }
        .jc-admin-table td {
            padding: 1rem;
            vertical-align: middle;
            border-bottom: 1px solid #f8fafc;
            color: #1e293b;
            font-size: 0.88rem;
        }
        .jc-admin-table tbody tr:hover td {
            background-color: #fafbfc;
        }

        /* Status Pills */
        .pill-status {
            display: inline-block;
            font-size: 0.72rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 0.35rem 0.85rem;
            border-radius: 20px;
        }
        .pill-status-active, .pill-status-entregado {
            background-color: #dcfce7;
            color: #15803d;
        }
        .pill-status-inactive {
            background-color: #fee2e2;
            color: #b91c1c;
        }
        .pill-status-recibido {
            background-color: #e0f2fe;
            color: #0284c7;
        }
        .pill-status-enviado {
            background-color: #ede9fe;
            color: #7c3aed;
        }
        .pill-status-empacado {
            background-color: #ffedd5;
            color: #ea580c;
        }
        .pill-status-pendiente {
            background-color: #fef9c3;
            color: #ca8a04;
        }

        /* Modal styling matching user screenshot */
        .modal-content-jc {
            background: #ffffff;
            border-radius: 12px;
            border: none;
            padding: 1.5rem;
            box-shadow: 0 20px 45px rgba(0,0,0,0.15);
        }
        .modal-title-jc {
            color: #0f172a;
            font-size: 1.25rem;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin: 0;
        }
        .form-label-jc {
            color: #0f172a;
            font-weight: 800;
            font-size: 0.85rem;
            margin-bottom: 0.35rem;
        }
        .form-control-jc, .form-select-jc {
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 0.65rem 0.9rem;
            font-size: 0.9rem;
            color: #1e293b;
            background: #ffffff;
            width: 100%;
        }
        .form-control-jc:focus, .form-select-jc:focus {
            border-color: var(--jc-gold);
            outline: none;
            box-shadow: 0 0 0 3px rgba(204, 160, 40, 0.15);
        }
        .btn-modal-submit {
            background-color: var(--jc-gold);
            color: #000000;
            font-weight: 900;
            font-size: 0.88rem;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            padding: 0.85rem;
            border-radius: 8px;
            border: none;
            width: 100%;
            cursor: pointer;
            margin-top: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: background 0.2s ease;
        }
        .btn-modal-submit:hover {
            background-color: var(--jc-gold-hover);
        }
    </style>

    @yield('styles')
</head>
<body>

<div class="admin-wrapper">
    <!-- ═══════════════════════════════════════════════════════════
         SIDEBAR EXACTO A LAS IMÁGENES
    ═══════════════════════════════════════════════════════════ -->
    <aside class="admin-sidebar">
        <!-- Logo -->
        <div class="sidebar-brand">
            <a href="{{ route('admin.dashboard') }}" class="sidebar-brand-title">JC URBAN</a>
            <div class="sidebar-brand-sub">PANEL DE ADMINISTRACIÓN</div>
        </div>

        <ul class="sidebar-menu">
            <!-- Sección PRINCIPAL -->
            <li class="sidebar-section-title">PRINCIPAL</li>
            <li>
                <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-grid-fill"></i>
                    <span>DASHBOARD</span>
                </a>
            </li>

            <!-- Sección CATÁLOGO -->
            <li class="sidebar-section-title">CATÁLOGO</li>
            <li>
                <a href="{{ route('admin.productos.index') }}" class="sidebar-link {{ request()->routeIs('admin.productos.*') ? 'active' : '' }}">
                    <i class="bi bi-box-seam"></i>
                    <span>PRODUCTOS</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.marcas.index') }}" class="sidebar-link {{ request()->routeIs('admin.marcas.*') ? 'active' : '' }}">
                    <i class="bi bi-tag"></i>
                    <span>MARCAS</span>
                </a>
            </li>

            <!-- Sección GESTIÓN -->
            <li class="sidebar-section-title">GESTIÓN</li>
            <li>
                <a href="{{ route('admin.usuarios.index') }}" class="sidebar-link {{ request()->routeIs('admin.usuarios.*') ? 'active' : '' }}">
                    <i class="bi bi-people"></i>
                    <span>USUARIOS</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.pedidos.index') }}" class="sidebar-link {{ request()->routeIs('admin.pedidos.*') ? 'active' : '' }}">
                    <i class="bi bi-bag-check"></i>
                    <span>PEDIDOS</span>
                </a>
            </li>
        </ul>

        <!-- Perfil abajo del Sidebar -->
        <div class="sidebar-user">
            <div class="d-flex align-items-center gap-2">
                <div class="user-avatar-circle">
                    {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                </div>
                <div>
                    <div class="user-info-name">{{ auth()->user()->name ?? 'Administrador' }}</div>
                    <div class="user-info-email">{{ auth()->user()->email ?? 'admin@jcurban.com' }}</div>
                </div>
            </div>
            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn-logout-sidebar" title="Cerrar sesión">
                    <i class="bi bi-box-arrow-right"></i>
                </button>
            </form>
        </div>
    </aside>

    <!-- ═══════════════════════════════════════════════════════════
         ÁREA PRINCIPAL
    ═══════════════════════════════════════════════════════════ -->
    <main class="admin-main">
        <!-- Top bar -->
        <div class="admin-header-row">
            <h1 class="admin-page-title">@yield('page_title', 'DASHBOARD')</h1>
            <div class="admin-header-actions">
                <span class="badge-online">En línea</span>
                @yield('header_action_button')
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success border-0 shadow-sm d-flex align-items-center gap-2 mb-4" role="alert">
                <i class="bi bi-check-circle-fill fs-5"></i>
                <div>{{ session('success') }}</div>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger border-0 shadow-sm d-flex align-items-center gap-2 mb-4" role="alert">
                <i class="bi bi-exclamation-triangle-fill fs-5"></i>
                <div>{{ session('error') }}</div>
            </div>
        @endif

        @yield('content')
    </main>
</div>

<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@yield('scripts')
</body>
</html>
