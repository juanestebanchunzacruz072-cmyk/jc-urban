@extends('layouts.app')

@section('title', 'Iniciar Sesión')
@section('meta_description', 'Inicia sesión en JC URBAN para acceder a tus pedidos y catálogo exclusivo.')

@section('content')
<div class="container py-5 my-md-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5 col-xl-4">
            <div class="jc-card p-4 p-md-5 shadow-lg">
                <div class="text-center mb-4">
                    <div class="jc-logo mb-2">
                        <span class="logo-jc">JC</span><span class="logo-urban">URBAN</span>
                    </div>
                    <h4 class="fw-bold text-white mb-1">Bienvenido de Vuelta</h4>
                    <p class="text-muted small">Ingresa tus credenciales para acceder</p>
                </div>

                @if(session('error'))
                    <div class="alert alert-danger bg-opacity-10 border-danger text-danger d-flex align-items-center gap-2 mb-4" role="alert">
                        <i class="bi bi-exclamation-triangle-fill"></i>
                        <div>{{ session('error') }}</div>
                    </div>
                @endif

                @if(session('success'))
                    <div class="alert alert-success bg-opacity-10 border-success text-success d-flex align-items-center gap-2 mb-4" role="alert">
                        <i class="bi bi-check-circle-fill"></i>
                        <div>{{ session('success') }}</div>
                    </div>
                @endif

                <form action="{{ route('login.post') }}" method="POST" id="formLogin">
                    @csrf

                    <!-- Correo Electrónico -->
                    <div class="mb-3">
                        <label for="email" class="form-label">
                            <i class="bi bi-envelope me-1 text-warning"></i>Correo Electrónico
                        </label>
                        <input type="email"
                               class="form-control @error('email') is-invalid @enderror"
                               id="email"
                               name="email"
                               value="{{ old('email') }}"
                               placeholder="ejemplo@correo.com"
                               required
                               autocomplete="email"
                               autofocus>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Contraseña con Mostrar / Ocultar (HU-02) -->
                    <div class="mb-3">
                        <label for="password" class="form-label">
                            <i class="bi bi-lock me-1 text-warning"></i>Contraseña
                        </label>
                        <div class="input-group">
                            <input type="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   id="password"
                                   name="password"
                                   placeholder="••••••••"
                                   required
                                   autocomplete="current-password">
                            <button class="btn btn-outline-secondary input-group-text"
                                    type="button"
                                    id="togglePassword"
                                    title="Mostrar u ocultar contraseña">
                                <i class="bi bi-eye" id="eyeIcon"></i>
                            </button>
                        </div>
                        @error('password')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Recordarme -->
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="form-check">
                            <input class="form-check-input bg-dark border-secondary" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label text-muted small" for="remember">
                                Recordarme
                            </label>
                        </div>
                    </div>

                    <!-- Botón Enviar -->
                    <button type="submit" class="btn-jc-gold w-100 py-3 mb-4">
                        <i class="bi bi-box-arrow-in-right me-2"></i>Iniciar Sesión
                    </button>

                    <div class="text-center border-top border-secondary pt-3">
                        <p class="text-muted small mb-0">¿Aún no tienes una cuenta?</p>
                        <a href="{{ route('register') }}" class="text-warning fw-bold text-decoration-none">
                            Regístrate aquí <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Toggle Password Visibility (HU-02)
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');
    const eyeIcon = document.getElementById('eyeIcon');

    if (togglePassword && passwordInput && eyeIcon) {
        togglePassword.addEventListener('click', function () {
            const isPassword = passwordInput.getAttribute('type') === 'password';
            passwordInput.setAttribute('type', isPassword ? 'text' : 'password');
            eyeIcon.classList.toggle('bi-eye', !isPassword);
            eyeIcon.classList.toggle('bi-eye-slash', isPassword);
        });
    }

    // Alerta SweetAlert si hay error de credenciales (HU-02)
    @if(session('error'))
        if (typeof JcSwal !== 'undefined') {
            JcSwal.fire({
                icon: 'error',
                title: 'Credenciales Incorrectas',
                text: '{{ session('error') }}',
                confirmButtonText: 'Reintentar'
            });
        }
    @endif
</script>
@endsection
