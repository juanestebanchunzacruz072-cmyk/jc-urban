@extends('layouts.admin')

@section('title', 'Nuevo Producto')
@section('page_title', 'Crear Nuevo Producto')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-9">
        <div class="jc-card p-4 p-md-5">
            <div class="d-flex justify-content-between align-items-center mb-4 border-bottom border-secondary pb-3">
                <h5 class="text-white fw-bold mb-0">Información del Producto</h5>
                <a href="{{ route('admin.productos.index') }}" class="btn-jc-outline btn-sm">
                    <i class="bi bi-arrow-left me-1"></i>Volver
                </a>
            </div>

            <form action="{{ route('admin.productos.guardar') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row g-3 mb-4">
                    <!-- Nombre -->
                    <div class="col-md-8">
                        <label for="nombre" class="form-label">Nombre del Producto <span class="text-danger">*</span></label>
                        <input type="text"
                               class="form-control @error('nombre') is-invalid @enderror"
                               id="nombre"
                               name="nombre"
                               value="{{ old('nombre') }}"
                               placeholder="Ej. Rolex Submariner Date Gold"
                               required>
                        @error('nombre')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Marca -->
                    <div class="col-md-4">
                        <label for="id_marca" class="form-label">Marca</label>
                        <select class="form-select @error('id_marca') is-invalid @enderror" id="id_marca" name="id_marca">
                            <option value="">Selecciona una marca...</option>
                            @foreach($marcas as $marca)
                                <option value="{{ $marca->id }}" {{ old('id_marca') == $marca->id ? 'selected' : '' }}>
                                    {{ $marca->nombre }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_marca')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Categoría -->
                    <div class="col-md-6">
                        <label for="id_categoria" class="form-label">Categoría Principal <span class="text-danger">*</span></label>
                        <select class="form-select @error('id_categoria') is-invalid @enderror" id="id_categoria" name="id_categoria" required>
                            <option value="">Selecciona categoría...</option>
                            @foreach($categorias as $cat)
                                <option value="{{ $cat->id }}" {{ old('id_categoria') == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->nombre }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_categoria')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Subcategoría -->
                    <div class="col-md-6">
                        <label for="id_subcategoria" class="form-label">Subcategoría</label>
                        <select class="form-select @error('id_subcategoria') is-invalid @enderror" id="id_subcategoria" name="id_subcategoria">
                            <option value="">Selecciona subcategoría...</option>
                            @foreach($subcategorias as $subcat)
                                <option value="{{ $subcat->id }}"
                                        data-categoria="{{ $subcat->id_categoria }}"
                                        {{ old('id_subcategoria') == $subcat->id ? 'selected' : '' }}>
                                    {{ $subcat->nombre }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_subcategoria')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Precio -->
                    <div class="col-md-6">
                        <label for="precio" class="form-label">Precio (COP) <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input type="number"
                                   step="100"
                                   class="form-control @error('precio') is-invalid @enderror"
                                   id="precio"
                                   name="precio"
                                   value="{{ old('precio') }}"
                                   placeholder="1500000"
                                   required>
                        </div>
                        @error('precio')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Stock -->
                    <div class="col-md-6">
                        <label for="stock" class="form-label">Cantidad en Stock <span class="text-danger">*</span></label>
                        <input type="number"
                               class="form-control @error('stock') is-invalid @enderror"
                               id="stock"
                               name="stock"
                               value="{{ old('stock', 1) }}"
                               min="0"
                               required>
                        @error('stock')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Descripción -->
                    <div class="col-12">
                        <label for="descripcion" class="form-label">Descripción & Ficha Técnica</label>
                        <textarea class="form-control @error('descripcion') is-invalid @enderror"
                                  id="descripcion"
                                  name="descripcion"
                                  rows="5"
                                  placeholder="Detalles sobre materiales, movimiento, notas olfativas, medidas, etc.">{{ old('descripcion') }}</textarea>
                        @error('descripcion')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Imágenes Múltiples (HU-19) -->
                    <div class="col-12">
                        <label for="imagenes" class="form-label">Imágenes del Producto</label>
                        <input type="file"
                               class="form-control @error('imagenes.*') is-invalid @enderror"
                               id="imagenes"
                               name="imagenes[]"
                               multiple
                               accept="image/png,image/jpeg,image/webp">
                        <small class="text-muted d-block mt-1">
                            Puedes seleccionar múltiples imágenes (JPG, PNG, WEBP máx 5MB). La primera será la portada principal.
                        </small>
                        @error('imagenes.*')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-3 pt-3 border-top border-secondary">
                    <a href="{{ route('admin.productos.index') }}" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" class="btn-jc-gold">
                        <i class="bi bi-save me-1"></i>Guardar Producto
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Filtro dinámico de subcategorías según la categoría seleccionada
    const catSelect = document.getElementById('id_categoria');
    const subcatSelect = document.getElementById('id_subcategoria');

    function filtrarSubcategorias() {
        const catId = catSelect.value;
        const options = subcatSelect.querySelectorAll('option');

        options.forEach(opt => {
            if (!opt.value) return; // Mantiene el placeholder
            const optCat = opt.getAttribute('data-categoria');
            if (!catId || optCat === catId) {
                opt.style.display = '';
            } else {
                opt.style.display = 'none';
                if (opt.selected) opt.selected = false;
            }
        });
    }

    catSelect.addEventListener('change', filtrarSubcategorias);
    filtrarSubcategorias();
</script>
@endsection
