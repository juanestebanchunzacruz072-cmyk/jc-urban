@extends('layouts.app')

@section('title', 'Crea tu Cuenta')
@section('meta_description', 'Crea una cuenta en JC URBAN para disfrutar de compras exclusivas, envíos garantizados y seguimiento de pedidos.')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-xl-7">
            <div class="jc-card p-4 p-md-5 shadow-lg">
                <div class="text-center mb-4">
                    <img src="{{ asset('img/logo.png') }}" alt="JC URBAN" style="height: 68px; width: 68px; object-fit: contain; border-radius: 8px;" class="mb-2 shadow">
                    <div class="jc-logo mb-2">
                        <span class="logo-jc">JC</span><span class="logo-urban text-dark" style="color: #000000 !important;">URBAN</span>
                    </div>
                    <h3 class="fw-bold mb-1" style="color: #0f172a;">Crea tu Cuenta</h3>
                    <p class="text-muted small">Únete al club exclusivo de JC URBAN y accede a lo mejor en relojería y perfumes</p>
                </div>

                @if($errors->any())
                    <div class="alert alert-danger bg-opacity-10 border-danger text-danger mb-4" role="alert">
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <i class="bi bi-exclamation-triangle-fill"></i>
                            <strong>Por favor corrige los siguientes errores:</strong>
                        </div>
                        <ul class="mb-0 ps-3 small">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('register.post') }}" method="POST" id="formRegistro">
                    @csrf

                    <!-- Sección: Datos Personales -->
                    <h6 class="text-uppercase fw-bold letter-spacing-1 mb-3" style="color: #cca028;">
                        <i class="bi bi-person-badge me-2"></i>1. Datos Personales
                    </h6>
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label for="name" class="form-label">Nombre <span class="text-danger">*</span></label>
                            <input type="text"
                                   class="form-control @error('name') is-invalid @enderror"
                                   id="name"
                                   name="name"
                                   value="{{ old('name') }}"
                                   placeholder="Juan"
                                   required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="apellido" class="form-label">Apellido <span class="text-danger">*</span></label>
                            <input type="text"
                                   class="form-control @error('apellido') is-invalid @enderror"
                                   id="apellido"
                                   name="apellido"
                                   value="{{ old('apellido') }}"
                                   placeholder="Pérez"
                                   required>
                            @error('apellido')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="cedula" class="form-label">Cédula de Ciudadanía <span class="text-danger">*</span></label>
                            <input type="text"
                                   class="form-control @error('cedula') is-invalid @enderror"
                                   id="cedula"
                                   name="cedula"
                                   value="{{ old('cedula') }}"
                                   placeholder="1234567890"
                                   required>
                            @error('cedula')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="telefono" class="form-label">Teléfono Móvil <span class="text-danger">*</span></label>
                            <input type="tel"
                                   class="form-control @error('telefono') is-invalid @enderror"
                                   id="telefono"
                                   name="telefono"
                                   value="{{ old('telefono') }}"
                                   placeholder="300 123 4567"
                                   required>
                            @error('telefono')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12">
                            <label for="email" class="form-label">Correo Electrónico <span class="text-danger">*</span></label>
                            <input type="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   id="email"
                                   name="email"
                                   value="{{ old('email') }}"
                                   placeholder="juan.perez@correo.com"
                                   required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Sección: Ubicación y Entrega -->
                    <h6 class="text-uppercase fw-bold letter-spacing-1 mb-3 pt-3 border-top" style="color: #cca028; border-color: #e2e8f0 !important;">
                        <i class="bi bi-geo-alt me-2"></i>2. Dirección de Envío
                    </h6>
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label for="ciudad" class="form-label">Ciudad <span class="text-danger">*</span></label>
                            <input type="text"
                                   class="form-control @error('ciudad') is-invalid @enderror"
                                   id="ciudad"
                                   name="ciudad"
                                   value="{{ old('ciudad', 'Bogotá') }}"
                                   placeholder="Bogotá, Medellín, Cali..."
                                   required>
                            @error('ciudad')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="barrio" class="form-label">Barrio <span class="text-danger">*</span></label>
                            <input type="text"
                                   class="form-control @error('barrio') is-invalid @enderror"
                                   id="barrio"
                                   name="barrio"
                                   value="{{ old('barrio') }}"
                                   placeholder="Chicó, El Poblado..."
                                   required>
                            @error('barrio')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12">
                            <label for="direccion" class="form-label">Dirección Exacta <span class="text-danger">*</span></label>
                            <input type="text"
                                   class="form-control @error('direccion') is-invalid @enderror"
                                   id="direccion"
                                   name="direccion"
                                   value="{{ old('direccion') }}"
                                   placeholder="Calle 93 # 14 - 20 Apto 402"
                                   required>
                            @error('direccion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Sección: Seguridad -->
                    <h6 class="text-uppercase fw-bold letter-spacing-1 mb-3 pt-3 border-top" style="color: #cca028; border-color: #e2e8f0 !important;">
                        <i class="bi bi-shield-lock me-2"></i>3. Seguridad
                    </h6>
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label for="password" class="form-label">Contraseña <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="password"
                                       class="form-control @error('password') is-invalid @enderror"
                                       id="password"
                                       name="password"
                                       placeholder="Mínimo 8 caracteres"
                                       required>
                                <button class="btn btn-outline-secondary input-group-text"
                                        type="button"
                                        id="togglePassword"
                                        title="Mostrar/Ocultar">
                                    <i class="bi bi-eye" id="eyeIcon"></i>
                                </button>
                            </div>
                            @error('password')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="password_confirmation" class="form-label">Confirmar Contraseña <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="password"
                                       class="form-control"
                                       id="password_confirmation"
                                       name="password_confirmation"
                                       placeholder="Repite la contraseña"
                                       required>
                                <button class="btn btn-outline-secondary input-group-text"
                                        type="button"
                                        id="toggleConfirmPassword"
                                        title="Mostrar/Ocultar">
                                    <i class="bi bi-eye" id="eyeConfirmIcon"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Botón Registrarse -->
                    <button type="submit" class="btn-jc-gold w-100 py-3 mb-3">
                        <i class="bi bi-person-check me-2"></i>Registrarme y Crear Cuenta
                    </button>

                    <div class="text-center">
                        <span class="text-muted small">¿Ya tienes una cuenta registrada? </span>
                        <a href="{{ route('login') }}" class="text-warning fw-bold text-decoration-none">
                            Iniciar Sesión
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
    // Toggle Password Visibility
    function setupToggle(buttonId, inputId, iconId) {
        const btn = document.getElementById(buttonId);
        const input = document.getElementById(inputId);
        const icon = document.getElementById(iconId);
        if (btn && input && icon) {
            btn.addEventListener('click', () => {
                const isPass = input.getAttribute('type') === 'password';
                input.setAttribute('type', isPass ? 'text' : 'password');
                icon.classList.toggle('bi-eye', !isPass);
                icon.classList.toggle('bi-eye-slash', isPass);
            });
        }
    }

    setupToggle('togglePassword', 'password', 'eyeIcon');
    setupToggle('toggleConfirmPassword', 'password_confirmation', 'eyeConfirmIcon');
</script>
@endsection
