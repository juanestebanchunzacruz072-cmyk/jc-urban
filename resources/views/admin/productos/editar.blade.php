@extends('layouts.admin')

@section('title', 'Editar Producto')
@section('page_title', 'Editar: ' . $producto->nombre)

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-9">
        <div class="jc-card p-4 p-md-5">
            <div class="d-flex justify-content-between align-items-center mb-4 border-bottom border-secondary pb-3">
                <div>
                    <h5 class="text-white fw-bold mb-0">Modificar Producto</h5>
                    <small class="text-muted">ID: #{{ $producto->id }}</small>
                </div>
                <a href="{{ route('admin.productos.index') }}" class="btn-jc-outline btn-sm">
                    <i class="bi bi-arrow-left me-1"></i>Volver
                </a>
            </div>

            <form action="{{ route('admin.productos.actualizar', $producto->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row g-3 mb-4">
                    <!-- Nombre -->
                    <div class="col-md-8">
                        <label for="nombre" class="form-label">Nombre del Producto <span class="text-danger">*</span></label>
                        <input type="text"
                               class="form-control @error('nombre') is-invalid @enderror"
                               id="nombre"
                               name="nombre"
                               value="{{ old('nombre', $producto->nombre) }}"
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
                                <option value="{{ $marca->id }}" {{ old('id_marca', $producto->id_marca) == $marca->id ? 'selected' : '' }}>
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
                                <option value="{{ $cat->id }}" {{ old('id_categoria', $producto->id_categoria) == $cat->id ? 'selected' : '' }}>
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
                                        {{ old('id_subcategoria', $producto->id_subcategoria) == $subcat->id ? 'selected' : '' }}>
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
                                   value="{{ old('precio', $producto->precio) }}"
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
                               value="{{ old('stock', $producto->stock) }}"
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
                                  rows="5">{{ old('descripcion', $producto->descripcion) }}</textarea>
                        @error('descripcion')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Galería de Imágenes Existentes -->
                    <div class="col-12">
                        <label class="form-label">Imágenes Actuales</label>
                        <div class="d-flex flex-wrap gap-3 p-3 rounded" style="background: var(--jc-black);">
                            @forelse($producto->imagenes as $img)
                                @php
                                    $imgSrc = str_starts_with($img->url_imagen, 'http')
                                        ? $img->url_imagen
                                        : asset('storage/' . $img->url_imagen);
                                @endphp
                                <div class="position-relative text-center p-1 rounded border border-secondary" style="width: 110px;">
                                    <img src="{{ $imgSrc }}"
                                         alt="Foto producto"
                                         class="rounded w-100"
                                         style="height: 90px; object-fit: cover;">
                                    @if($img->principal)
                                        <span class="badge bg-warning text-dark position-absolute top-0 start-0 m-1" style="font-size: 0.65rem;">Principal</span>
                                    @endif
                                    <button type="button"
                                            class="btn btn-danger btn-sm w-100 mt-1 py-0"
                                            style="font-size: 0.72rem;"
                                            onclick="eliminarImagen({{ $img->id }})">
                                        <i class="bi bi-trash"></i> Eliminar
                                    </button>
                                </div>
                            @empty
                                <p class="text-muted small mb-0">No hay imágenes cargadas para este producto.</p>
                            @endforelse
                        </div>
                    </div>

                    <!-- Subir Nuevas Imágenes -->
                    <div class="col-12">
                        <label for="imagenes" class="form-label">Agregar Más Imágenes</label>
                        <input type="file"
                               class="form-control @error('imagenes.*') is-invalid @enderror"
                               id="imagenes"
                               name="imagenes[]"
                               multiple
                               accept="image/png,image/jpeg,image/webp">
                        <small class="text-muted d-block mt-1">
                            Las nuevas imágenes se sumarán a la galería existente.
                        </small>
                        @error('imagenes.*')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-3 pt-3 border-top border-secondary">
                    <a href="{{ route('admin.productos.index') }}" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" class="btn-jc-gold">
                        <i class="bi bi-save me-1"></i>Actualizar Producto
                    </button>
                </div>
            </form>

            <!-- Form oculto para eliminar imagen -->
            <form id="formEliminarImagen" action="" method="POST" style="display: none;">
                @csrf
                @method('DELETE')
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Filtro dinámico de subcategorías
    const catSelect = document.getElementById('id_categoria');
    const subcatSelect = document.getElementById('id_subcategoria');

    function filtrarSubcategorias() {
        const catId = catSelect.value;
        const options = subcatSelect.querySelectorAll('option');

        options.forEach(opt => {
            if (!opt.value) return;
            const optCat = opt.getAttribute('data-categoria');
            if (!catId || optCat === catId) {
                opt.style.display = '';
            } else {
                opt.style.display = 'none';
            }
        });
    }

    catSelect.addEventListener('change', filtrarSubcategorias);
    filtrarSubcategorias();

    // Eliminar imagen con confirmación
    function eliminarImagen(id) {
        if (confirm('¿Eliminar esta imagen del producto?')) {
            const form = document.getElementById('formEliminarImagen');
            form.action = '{{ url("admin/imagenes") }}/' + id;
            form.submit();
        }
    }
</script>
@endsection
