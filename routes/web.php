<?php

use App\Http\Controllers\Admin\CatalogoAdminController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PedidoAdminController;
use App\Http\Controllers\Admin\ProductoController as AdminProductoController;
use App\Http\Controllers\Admin\UsuarioAdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CatalogoController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\PerfilController;
use Illuminate\Support\Facades\Route;

// ─── PÁGINA PRINCIPAL ──────────────────────────────────────────────────────────
Route::get('/', [CatalogoController::class, 'index'])->name('catalogo.index');

// ─── AUTENTICACIÓN (HU-01, HU-02, HU-04) ──────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/registro', [AuthController::class, 'mostrarRegistro'])->name('register');
    Route::post('/registro', [AuthController::class, 'registrar'])->name('register.post');
    Route::get('/login', [AuthController::class, 'mostrarLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// ─── CATÁLOGO PÚBLICO (HU-06, HU-07, HU-08) ────────────────────────────────────
Route::get('/catalogo/{id}', [CatalogoController::class, 'categoria'])->name('catalogo.categoria');
Route::get('/producto/{id}', [CatalogoController::class, 'detalle'])->name('catalogo.detalle');

// ─── PERFIL DEL CLIENTE (HU-05, HU-17) ─────────────────────────────────────────
Route::middleware(['auth', 'check.cliente'])->group(function () {
    Route::get('/perfil', [PerfilController::class, 'index'])->name('perfil.index');
    Route::put('/perfil', [PerfilController::class, 'actualizar'])->name('perfil.actualizar');
});

// ─── CHECKOUT (HU-15, HU-16) ────────────────────────────────────────────────────
Route::middleware(['auth', 'check.cliente'])->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'detalle'])->name('checkout.detalle');
    Route::post('/checkout/confirmar', [CheckoutController::class, 'confirmar'])->name('checkout.confirmar');
    Route::get('/factura/{id}', [CheckoutController::class, 'factura'])->name('checkout.factura');
    Route::post('/carrito/guardar', [CheckoutController::class, 'guardarCarritoAjax'])->name('carrito.guardar');
});

// ─── PANEL DE ADMINISTRACIÓN (HU-18 a HU-23) ─────────────────────────────────
Route::middleware(['auth', 'check.admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Productos CRUD (HU-19)
    Route::get('/productos', [AdminProductoController::class, 'index'])->name('productos.index');
    Route::get('/productos/crear', [AdminProductoController::class, 'crear'])->name('productos.crear');
    Route::post('/productos', [AdminProductoController::class, 'guardar'])->name('productos.guardar');
    Route::get('/productos/{id}/editar', [AdminProductoController::class, 'editar'])->name('productos.editar');
    Route::put('/productos/{id}', [AdminProductoController::class, 'actualizar'])->name('productos.actualizar');
    Route::patch('/productos/{id}/toggle', [AdminProductoController::class, 'toggleActivo'])->name('productos.toggle');
    Route::delete('/productos/{id}', [AdminProductoController::class, 'eliminar'])->name('productos.eliminar');
    Route::delete('/imagenes/{id}', [AdminProductoController::class, 'eliminarImagen'])->name('imagenes.eliminar');

    // Catálogo: Categorías, Subcategorías, Marcas (HU-20)
    Route::get('/categorias', [CatalogoAdminController::class, 'categoriasIndex'])->name('categorias.index');
    Route::post('/categorias', [CatalogoAdminController::class, 'categoriaGuardar'])->name('categorias.guardar');
    Route::put('/categorias/{id}', [CatalogoAdminController::class, 'categoriaActualizar'])->name('categorias.actualizar');
    Route::patch('/categorias/{id}/toggle', [CatalogoAdminController::class, 'categoriaToggle'])->name('categorias.toggle');

    Route::get('/subcategorias', [CatalogoAdminController::class, 'subcategoriasIndex'])->name('subcategorias.index');
    Route::post('/subcategorias', [CatalogoAdminController::class, 'subcategoriaGuardar'])->name('subcategorias.guardar');
    Route::patch('/subcategorias/{id}/toggle', [CatalogoAdminController::class, 'subcategoriaToggle'])->name('subcategorias.toggle');

    Route::get('/marcas', [CatalogoAdminController::class, 'marcasIndex'])->name('marcas.index');
    Route::post('/marcas', [CatalogoAdminController::class, 'marcaGuardar'])->name('marcas.guardar');
    Route::put('/marcas/{id}', [CatalogoAdminController::class, 'marcaActualizar'])->name('marcas.actualizar');
    Route::patch('/marcas/{id}/toggle', [CatalogoAdminController::class, 'marcaToggle'])->name('marcas.toggle');

    // Pedidos (HU-21, HU-22)
    Route::get('/pedidos', [PedidoAdminController::class, 'index'])->name('pedidos.index');
    Route::get('/pedidos/{id}', [PedidoAdminController::class, 'detalle'])->name('pedidos.detalle');
    Route::patch('/pedidos/{id}/estado', [PedidoAdminController::class, 'cambiarEstado'])->name('pedidos.estado');

    // Usuarios/Clientes (HU-23)
    Route::get('/usuarios', [UsuarioAdminController::class, 'index'])->name('usuarios.index');
});
