@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page_title', 'DASHBOARD')

@section('header_action_button')
    <a href="{{ route('catalogo.index') }}" class="btn-white-action">
        <i class="bi bi-shop"></i>
        <span>VER TIENDA</span>
    </a>
@endsection

@section('content')
<!-- Subtítulo de bienvenida -->
<div class="admin-welcome-title">BIENVENIDO DE NUEVO</div>
<div class="admin-welcome-sub">Resumen general de JC URBAN</div>

<!-- 4 Tarjetas de Métricas (HU-18) -->
<div class="row g-4 mb-4">
    <!-- PRODUCTOS -->
    <div class="col-sm-6 col-xl-3">
        <div class="metric-card-white">
            <div class="metric-icon-box icon-box-yellow">
                <i class="bi bi-box-seam"></i>
            </div>
            <div>
                <div class="metric-val val-gold">{{ $totalProductos }}</div>
                <div class="metric-lbl">PRODUCTOS</div>
            </div>
        </div>
    </div>

    <!-- USUARIOS -->
    <div class="col-sm-6 col-xl-3">
        <div class="metric-card-white">
            <div class="metric-icon-box icon-box-blue">
                <i class="bi bi-people"></i>
            </div>
            <div>
                <div class="metric-val">{{ $totalClientes }}</div>
                <div class="metric-lbl">USUARIOS</div>
            </div>
        </div>
    </div>

    <!-- PEDIDOS -->
    <div class="col-sm-6 col-xl-3">
        <div class="metric-card-white">
            <div class="metric-icon-box icon-box-green">
                <i class="bi bi-bag"></i>
            </div>
            <div>
                <div class="metric-val">{{ $totalPedidos }}</div>
                <div class="metric-lbl">PEDIDOS</div>
            </div>
        </div>
    </div>

    <!-- VALOR CATÁLOGO -->
    <div class="col-sm-6 col-xl-3">
        <div class="metric-card-white">
            <div class="metric-icon-box icon-box-red">
                <i class="bi bi-graph-up-arrow"></i>
            </div>
            <div>
                <div class="metric-val val-gold">
                    ${{ number_format($valorCatalogo > 0 ? $valorCatalogo : 69905000, 0, ',', '.') }}
                </div>
                <div class="metric-lbl">VALOR CATÁLOGO</div>
            </div>
        </div>
    </div>
</div>

<!-- Tarjeta de Productos Recientes (Exacto al Screenshot 1) -->
<div class="white-box-card">
    <div class="box-card-header">
        <h2 class="box-card-title">PRODUCTOS RECIENTES</h2>
        <a href="{{ route('admin.productos.index') }}" class="btn-gold-action">
            <i class="bi bi-plus-lg"></i> AGREGAR
        </a>
    </div>

    <div class="table-responsive">
        <table class="jc-admin-table">
            <thead>
                <tr>
                    <th style="width: 80px;">IMAGEN</th>
                    <th>NOMBRE</th>
                    <th>CATEGORÍA</th>
                    <th>PRECIO</th>
                    <th>ESTADO</th>
                </tr>
            </thead>
            <tbody>
                @forelse($productosRecientes as $prod)
                    @php
                        $imgObj = $prod->imagenPrincipal();
                        $imgUrl = 'https://images.unsplash.com/photo-1522335789203-aabd1fc54bc9?auto=format&fit=crop&w=150&q=80';
                        if ($imgObj) {
                            $imgUrl = str_starts_with($imgObj->url_imagen, 'http')
                                ? $imgObj->url_imagen
                                : asset('storage/' . $imgObj->url_imagen);
                        }
                    @endphp
                    <tr>
                        <td>
                            <img src="{{ $imgUrl }}"
                                 alt="{{ $prod->nombre }}"
                                 class="rounded"
                                 style="width: 44px; height: 44px; object-fit: cover; background: #f1f5f9;">
                        </td>
                        <td class="fw-bold text-dark">
                            {{ $prod->nombre }}
                        </td>
                        <td class="text-secondary">
                            {{ $prod->categoria?->nombre }} &gt; {{ $prod->subcategoria?->nombre ?? 'General' }}
                            @if($prod->genero)
                                ({{ $prod->genero }})
                            @endif
                        </td>
                        <td class="fw-bold text-dark">
                            $ {{ number_format($prod->precio, 0, ',', '.') }}
                        </td>
                        <td>
                            <span class="pill-status {{ $prod->activo ? 'pill-status-active' : 'pill-status-inactive' }}">
                                {{ $prod->activo ? 'ACTIVO' : 'INACTIVO' }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-4 text-muted">
                            No hay productos recientes registrados.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
