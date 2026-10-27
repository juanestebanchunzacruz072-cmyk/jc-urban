<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="@yield('meta_description', 'JC URBAN - Tienda de relojes, perfumes y accesorios de lujo. Las mejores marcas: Rolex, Richard Mille, Lattafa y más.')">
    <title>@yield('title', 'JC URBAN') | Lujo & Exclusividad</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('img/logo.png') }}">

    <!-- Google Fonts: Montserrat -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- CSS Variables & Base -->
    <link rel="stylesheet" href="{{ asset('css/variables.css') }}">
    <!-- App CSS -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    @yield('styles')
</head>
<body>

<!-- ═══════════════════════════════════════════════════════════
     HEADER / NAVBAR
═══════════════════════════════════════════════════════════ -->
<nav class="navbar navbar-expand-lg jc-navbar sticky-top" id="mainNavbar">
    <div class="container">
        <!-- Logo -->
        <a class="navbar-brand jc-logo d-flex align-items-center gap-2" href="{{ route('catalogo.index') }}">
            <img src="{{ asset('img/logo.png') }}" alt="JC URBAN" style="height: 38px; width: 38px; object-fit: contain; border-radius: 6px;">
            <span><span class="logo-jc">JC</span><span class="logo-urban">URBAN</span></span>
        </a>

        <!-- Toggler + Carrito para móvil -->
        <div class="d-flex align-items-center gap-2 d-lg-none">
            <button class="btn-cart-mobile position-relative" type="button" data-bs-toggle="offcanvas" data-bs-target="#carritoOffcanvas" aria-label="Carrito">
                <i class="bi bi-bag-heart"></i>
                <span class="cart-badge" id="cartBadgeMobile">0</span>
            </button>
            <button class="navbar-toggler jc-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain" aria-label="Menú">
                <i class="bi bi-list"></i>
            </button>
        </div>

        <!-- Nav Links -->
        <div class="collapse navbar-collapse" id="navbarMain">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-3">
                <li class="nav-item">
                    <a class="nav-link jc-nav-link text-white" href="{{ route('catalogo.index') }}">
                        Inicio
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link jc-nav-link text-white dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Categorías
                    </a>
                    <ul class="dropdown-menu jc-dropdown shadow-lg">
                        <li><a class="dropdown-item jc-dropdown-item" href="{{ route('catalogo.categoria', 1) }}"><i class="bi bi-watch me-2 text-warning"></i>Relojes</a></li>
                        <li><a class="dropdown-item jc-dropdown-item" href="{{ route('catalogo.categoria', 2) }}"><i class="bi bi-droplet me-2 text-warning"></i>Perfumes</a></li>
                        <li><a class="dropdown-item jc-dropdown-item" href="{{ route('catalogo.categoria', 3) }}"><i class="bi bi-bag me-2 text-warning"></i>Accesorios</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link jc-nav-link text-white" href="#contacto">
                        Contacto
                    </a>
                </li>
            </ul>

            <!-- Acciones de usuario -->
            <div class="d-flex align-items-center gap-3">
                <!-- Carrito -->
                <button class="btn-cart-desktop position-relative d-none d-lg-flex" type="button" data-bs-toggle="offcanvas" data-bs-target="#carritoOffcanvas" aria-label="Ver carrito">
                    <i class="bi bi-cart3 fs-5"></i>
                    <span class="cart-badge" id="cartBadgeDesktop">0</span>
                </button>

                @auth
                    <div class="dropdown">
                        <button class="btn-user dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-circle me-1"></i>
                            <span class="d-none d-lg-inline">{{ auth()->user()->name }}</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end jc-dropdown">
                            @if(auth()->user()->id_rol === 1)
                                <li>
                                    <a class="dropdown-item jc-dropdown-item" href="{{ route('admin.dashboard') }}">
                                        <i class="bi bi-speedometer2 me-2"></i>Panel Admin
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider jc-divider"></li>
                            @endif
                            <li>
                                <a class="dropdown-item jc-dropdown-item" href="{{ route('perfil.index') }}">
                                    <i class="bi bi-person me-2"></i>Mi Perfil
                                </a>
                            </li>
                            <li><hr class="dropdown-divider jc-divider"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="dropdown-item jc-dropdown-item text-danger">
                                        <i class="bi bi-box-arrow-right me-2"></i>Cerrar Sesión
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="btn-jc-outline px-3 py-2 fw-bold">
                        Iniciar Sesión
                    </a>
                @endauth
            </div>
        </div>
    </div>
</nav>

<!-- ═══════════════════════════════════════════════════════════
     CARRITO OFFCANVAS (HU-10 a HU-14)
═══════════════════════════════════════════════════════════ -->
<div class="offcanvas offcanvas-end jc-offcanvas" tabindex="-1" id="carritoOffcanvas" aria-labelledby="carritoOffcanvasLabel">
    <div class="offcanvas-header jc-offcanvas-header">
        <h5 class="offcanvas-title jc-offcanvas-title" id="carritoOffcanvasLabel">
            <i class="bi bi-bag-heart-fill me-2"></i>Mi Carrito
        </h5>
        <button type="button" class="btn-close-offcanvas" data-bs-dismiss="offcanvas" aria-label="Cerrar">
            <i class="bi bi-x-lg"></i>
        </button>
    </div>
    <div class="offcanvas-body jc-offcanvas-body">
        <!-- Lista de items del carrito -->
        <div id="cartItemsList">
            <!-- Items se insertan dinámicamente con JS -->
            <div class="cart-empty-state" id="cartEmptyState">
                <i class="bi bi-bag-x display-4 text-muted"></i>
                <p class="mt-3">Tu carrito está vacío</p>
                <small>Explora nuestro catálogo de lujo</small>
            </div>
        </div>

        <!-- Total -->
        <div class="cart-footer" id="cartFooter" style="display:none;">
            <div class="cart-total-row">
                <span class="cart-total-label">Subtotal</span>
                <span class="cart-total-amount" id="cart-total-final">$0</span>
            </div>
            <small class="cart-shipping-note">
                <i class="bi bi-shield-check me-1"></i>
                Garantía JC URBAN en todos los productos
            </small>

            <!-- Botón Comprar -->
            <button type="button" class="btn-jc-gold w-100 mt-3" id="btnComprar" onclick="procesarCompra()">
                <i class="bi bi-lock-fill me-2"></i>Proceder al Pago
            </button>
            <button type="button" class="btn-jc-outline w-100 mt-2" onclick="vaciarCarrito()">
                <i class="bi bi-trash me-2"></i>Vaciar Carrito
            </button>
        </div>

        <!-- También te puede gustar (HU-09) -->
        <div class="also-like-section mt-4" id="alsoLikeSection">
            <h6 class="also-like-title">
                <i class="bi bi-stars me-2"></i>También te puede gustar
            </h6>
            <div id="alsoLikeProducts" class="also-like-grid">
                <!-- Cargado dinámicamente -->
            </div>
        </div>
    </div>
</div>

<!-- ═══════════════════════════════════════════════════════════
     CONTENIDO PRINCIPAL
═══════════════════════════════════════════════════════════ -->
<main>
    @yield('content')
</main>

<!-- ═══════════════════════════════════════════════════════════
     FOOTER
═══════════════════════════════════════════════════════════ -->
<footer class="jc-footer">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-4 col-md-6">
                <div class="footer-brand d-flex align-items-center gap-2 mb-2">
                    <img src="{{ asset('img/logo.png') }}" alt="JC URBAN" style="height: 42px; width: 42px; object-fit: contain; border-radius: 6px;">
                    <span><span class="logo-jc">JC</span><span class="logo-urban">URBAN</span></span>
                </div>
                <p class="footer-tagline">Lujo. Exclusividad. Estilo.</p>
                <p class="footer-desc">
                    Tu destino de confianza para relojes, perfumes y accesorios de alta gama.
                    Con garantía de autenticidad en cada compra.
                </p>
            </div>
            <div class="col-lg-2 col-md-6">
                <h6 class="footer-heading">Catálogo</h6>
                <ul class="footer-links">
                    <li><a href="{{ route('catalogo.categoria', 1) }}">Relojes</a></li>
                    <li><a href="{{ route('catalogo.categoria', 2) }}">Perfumes</a></li>
                    <li><a href="{{ route('catalogo.categoria', 3) }}">Accesorios</a></li>
                </ul>
            </div>
            <div class="col-lg-3 col-md-6">
                <h6 class="footer-heading">Mi Cuenta</h6>
                <ul class="footer-links">
                    @auth
                        <li><a href="{{ route('perfil.index') }}">Mi Perfil</a></li>
                        <li><a href="{{ route('perfil.index') }}">Mis Pedidos</a></li>
                    @else
                        <li><a href="{{ route('login') }}">Iniciar Sesión</a></li>
                        <li><a href="{{ route('register') }}">Registrarse</a></li>
                    @endauth
                </ul>
            </div>
            <div class="col-lg-3 col-md-6">
                <h6 class="footer-heading">Garantía JC URBAN</h6>
                <div class="guarantee-box">
                    <i class="bi bi-patch-check-fill guarantee-icon"></i>
                    <p class="guarantee-text">6 meses en relojes por maquinaria.<br>Originalidad garantizada en perfumes y accesorios.</p>
                </div>
            </div>
        </div>
        <hr class="footer-divider">
        <div class="footer-bottom">
            <p>&copy; {{ date('Y') }} JC URBAN. Todos los derechos reservados.</p>
            <div class="footer-social">
                <a href="#" aria-label="WhatsApp"><i class="bi bi-whatsapp"></i></a>
                <a href="#" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
                <a href="#" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
            </div>
        </div>
    </div>
</footer>

<!-- ═══════════════════════════════════════════════════════════
     SCRIPTS
═══════════════════════════════════════════════════════════ -->
<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- SweetAlert2 (HU-24) -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- SweetAlert2 Config Global -->
<script>
    const JcSwal = Swal.mixin({
        background: '#0a0a0a',
        color: '#ffffff',
        confirmButtonColor: '#D4AF37',
        cancelButtonColor: '#333',
        customClass: {
            popup: 'jc-swal-popup',
            confirmButton: 'jc-swal-confirm',
            cancelButton: 'jc-swal-cancel',
        }
    });

    // Mostrar alertas Flash de Laravel con SweetAlert2
    @if(session('success'))
        JcSwal.fire({
            icon: 'success',
            title: '¡Éxito!',
            text: @json(session('success')),
            timer: 3000,
            timerProgressBar: true,
            showConfirmButton: false,
        });
    @endif

    @if(session('error'))
        JcSwal.fire({
            icon: 'error',
            title: 'Error',
            text: @json(session('error')),
        });
    @endif

    @if(session('info'))
        JcSwal.fire({
            icon: 'info',
            title: 'Información',
            text: @json(session('info')),
        });
    @endif

    @if($errors->any())
        JcSwal.fire({
            icon: 'warning',
            title: 'Por favor corrige los errores',
            html: `<ul class="text-start">{!! implode('', array_map(fn($e) => "<li>$e</li>", $errors->all())) !!}</ul>`,
        });
    @endif
</script>

<!-- Carrito JS (HU-10 a HU-14) -->
<script>
    // ─── ESTADO DEL CARRITO ────────────────────────────────────────────────────
    let carrito = JSON.parse(localStorage.getItem('jc_carrito') || '{}');

    /** Guarda el carrito en LocalStorage y actualiza badges */
    function persistirCarrito() {
        localStorage.setItem('jc_carrito', JSON.stringify(carrito));
        actualizarBadges();
        renderizarCarrito();
    }

    /** Actualiza los contadores del carrito en el header */
    function actualizarBadges() {
        const total = Object.values(carrito).reduce((sum, item) => sum + item.cantidad, 0);
        document.querySelectorAll('#cartBadgeMobile, #cartBadgeDesktop').forEach(badge => {
            badge.textContent = total;
            badge.style.display = total > 0 ? 'flex' : 'none';
        });
    }

    /** Agrega un producto al carrito (HU-10) */
    function agregarAlCarrito(id, nombre, precio, imagen, stock) {
        if (carrito[id]) {
            if (carrito[id].cantidad >= stock) {
                JcSwal.fire({
                    icon: 'warning',
                    title: 'Stock máximo',
                    text: `Solo hay ${stock} unidades disponibles de este producto.`,
                    timer: 2500,
                    showConfirmButton: false,
                });
                return;
            }
            carrito[id].cantidad++;
        } else {
            carrito[id] = { id, nombre, precio: parseFloat(precio), imagen, stock: parseInt(stock), cantidad: 1 };
        }
        persistirCarrito();
        // Abre el offcanvas
        const offcanvasEl = document.getElementById('carritoOffcanvas');
        const offcanvas = bootstrap.Offcanvas.getOrCreateInstance(offcanvasEl);
        offcanvas.show();

        JcSwal.fire({
            icon: 'success',
            title: '¡Añadido!',
            text: `"${nombre}" fue agregado a tu carrito.`,
            timer: 1500,
            showConfirmButton: false,
            toast: true,
            position: 'top-end',
        });
    }

    /** Modifica la cantidad de un item (HU-12) */
    function cambiarCantidad(id, delta) {
        if (!carrito[id]) return;
        const nuevaCantidad = carrito[id].cantidad + delta;
        if (nuevaCantidad < 1) {
            eliminarDelCarrito(id);
            return;
        }
        if (nuevaCantidad > carrito[id].stock) {
            JcSwal.fire({
                icon: 'warning',
                title: 'Stock máximo',
                text: `Solo hay ${carrito[id].stock} unidades disponibles.`,
                timer: 2000,
                showConfirmButton: false,
            });
            return;
        }
        carrito[id].cantidad = nuevaCantidad;
        persistirCarrito();
    }

    /** Elimina un producto del carrito (HU-13) */
    function eliminarDelCarrito(id) {
        if (!carrito[id]) return;
        const nombre = carrito[id].nombre;
        delete carrito[id];
        persistirCarrito();
        JcSwal.fire({
            icon: 'info',
            title: 'Producto eliminado',
            text: `"${nombre}" fue removido del carrito.`,
            timer: 1500,
            showConfirmButton: false,
            toast: true,
            position: 'top-end',
        });
    }

    /** Vacía el carrito completamente */
    function vaciarCarrito() {
        JcSwal.fire({
            icon: 'question',
            title: '¿Vaciar carrito?',
            text: 'Se eliminarán todos los productos seleccionados.',
            showCancelButton: true,
            confirmButtonText: 'Sí, vaciar',
            cancelButtonText: 'Cancelar',
        }).then(result => {
            if (result.isConfirmed) {
                carrito = {};
                persistirCarrito();
            }
        });
    }

    /** Calcula el total del carrito (HU-14) */
    function calcularTotal() {
        return Object.values(carrito).reduce((sum, item) => sum + (item.precio * item.cantidad), 0);
    }

    /** Formatea precio en pesos colombianos */
    function formatPrecio(precio) {
        return new Intl.NumberFormat('es-CO', { style: 'currency', currency: 'COP', minimumFractionDigits: 0 }).format(precio);
    }

    /** Renderiza los items del carrito en el offcanvas */
    function renderizarCarrito() {
        const lista = document.getElementById('cartItemsList');
        const emptyState = document.getElementById('cartEmptyState');
        const footer = document.getElementById('cartFooter');
        const totalEl = document.getElementById('cart-total-final');

        const items = Object.values(carrito);

        if (items.length === 0) {
            lista.innerHTML = '';
            lista.appendChild(emptyState);
            emptyState.style.display = 'block';
            footer.style.display = 'none';
            return;
        }

        emptyState.style.display = 'none';
        footer.style.display = 'block';

        lista.innerHTML = items.map(item => `
            <div class="cart-item" data-id="${item.id}">
                <div class="cart-item-img">
                    <img src="${item.imagen || '/images/no-image.jpg'}" alt="${item.nombre}" loading="lazy">
                </div>
                <div class="cart-item-info">
                    <p class="cart-item-name">${item.nombre}</p>
                    <p class="cart-item-price">${formatPrecio(item.precio)}</p>
                    <div class="cart-item-qty">
                        <button class="qty-btn" onclick="cambiarCantidad(${item.id}, -1)">
                            <i class="bi bi-dash"></i>
                        </button>
                        <span class="qty-value">${item.cantidad}</span>
                        <button class="qty-btn" onclick="cambiarCantidad(${item.id}, 1)">
                            <i class="bi bi-plus"></i>
                        </button>
                    </div>
                </div>
                <div class="cart-item-actions">
                    <p class="cart-item-subtotal">${formatPrecio(item.precio * item.cantidad)}</p>
                    <button class="cart-item-delete" onclick="eliminarDelCarrito(${item.id})" title="Eliminar">
                        <i class="bi bi-trash3"></i>
                    </button>
                </div>
            </div>
        `).join('');

        totalEl.textContent = formatPrecio(calcularTotal());
    }

    /** Procesa la compra: guarda carrito y redirige (HU-15) */
    async function procesarCompra() {
        const items = Object.values(carrito);
        if (items.length === 0) {
            JcSwal.fire({ icon: 'warning', title: 'Carrito vacío', text: 'Agrega productos antes de proceder al pago.' });
            return;
        }

        // Sincroniza con el servidor
        try {
            const response = await fetch('{{ route("carrito.guardar") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                },
                body: JSON.stringify({ items: carrito }),
            });

            if (response.ok) {
                window.location.href = '{{ route("checkout.detalle") }}';
            } else if (response.status === 401) {
                // No autenticado: guardar intención y redirigir al login
                JcSwal.fire({
                    icon: 'info',
                    title: 'Inicia sesión',
                    text: 'Debes iniciar sesión para realizar tu compra. Tu carrito se conservará.',
                    confirmButtonText: 'Iniciar Sesión',
                    showCancelButton: true,
                    cancelButtonText: 'Continuar comprando',
                }).then(result => {
                    if (result.isConfirmed) {
                        window.location.href = '{{ route("login") }}';
                    }
                });
            }
        } catch (error) {
            JcSwal.fire({ icon: 'error', title: 'Error', text: 'Ocurrió un error al procesar tu solicitud.' });
        }
    }

    // Inicializa el carrito al cargar la página
    document.addEventListener('DOMContentLoaded', () => {
        actualizarBadges();
        renderizarCarrito();

        // Navbar scroll effect
        const navbar = document.getElementById('mainNavbar');
        window.addEventListener('scroll', () => {
            navbar.classList.toggle('scrolled', window.scrollY > 50);
        });
    });
</script>

@yield('scripts')
</body>
</html>
