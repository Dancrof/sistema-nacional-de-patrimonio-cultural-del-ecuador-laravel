@extends('adminlte::page')

@section('title', 'Nueva obra')

@section('content_header')
    <div class="row">
        <div class="col-sm-6">
            <h1 class="m-0">Nueva obra</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-end">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Inicio</a></li>
                <li class="breadcrumb-item">Administración</li>
                <li class="breadcrumb-item"><a href="{{ route('adminlte.artworks.index') }}">Obras</a></li>
                <li class="breadcrumb-item active" aria-current="page">Crear</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    <x-adminlte-card icon="bi bi-palette" title="Nueva obra">
        <form method="POST" action="{{ route('adminlte.artworks.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="row g-3">
                <div class="col-md-6">
                    <x-adminlte-input name="code" label="Código" value="{{ old('code') }}" required />
                </div>
                <div class="col-md-6">
                    <x-adminlte-input name="title" label="Título" value="{{ old('title') }}" required />
                </div>
                <div class="col-md-6">
                    <label class="form-label" for="category_id">Categoría</label>
                    <select name="category_id" id="category_id" class="form-select" required>
                        <option value="">Seleccione</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label" for="artwork_type_id">Tipo de obra</label>
                    <select name="artwork_type_id" id="artwork_type_id" class="form-select" required>
                        <option value="">Seleccione</option>
                        @foreach ($artworkTypes as $type)
                            <option value="{{ $type->id }}" @selected(old('artwork_type_id') == $type->id)>{{ $type->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label" for="conservation_status_id">Estado de conservación</label>
                    <select name="conservation_status_id" id="conservation_status_id" class="form-select">
                        <option value="">Seleccione</option>
                        @foreach ($statuses as $status)
                            <option value="{{ $status->id }}" @selected(old('conservation_status_id') == $status->id)>{{ $status->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label" for="province_id">Provincia</label>
                    <select name="province_id" id="province_id" class="form-select" required>
                        <option value="">Seleccione</option>
                        @foreach ($provinces as $province)
                            <option value="{{ $province->id }}" @selected(old('province_id') == $province->id)>{{ $province->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label" for="canton_id">Cantón</label>
                    <select name="canton_id" id="canton_id" class="form-select" required>
                        <option value="">Seleccione</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label" for="parish_id">Parroquia</label>
                    <select name="parish_id" id="parish_id" class="form-select">
                        <option value="">Seleccione</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <x-adminlte-input name="creation_year" type="number" min="1000" max="2100" label="Año de creación" value="{{ old('creation_year') }}" />
                </div>
                <div class="col-md-6">
                    <x-adminlte-input name="address" label="Dirección" value="{{ old('address') }}" />
                </div>
                <div class="col-md-6">
                    <label class="form-label" for="latitude">Latitud</label>
                    <input type="text" name="latitude" id="latitude" class="form-control" inputmode="decimal" pattern="^-?(?:90(?:\.0+)?|[0-8]?\d(?:\.\d+)?)$" value="{{ old('latitude') }}" data-coordinate-field>
                </div>
                <div class="col-md-6">
                    <label class="form-label" for="longitude">Longitud</label>
                    <input type="text" name="longitude" id="longitude" class="form-control" inputmode="decimal" pattern="^-?(?:180(?:\.0+)?|(?:1[0-7]\d|\d{1,2})(?:\.\d+)?)$" value="{{ old('longitude') }}" data-coordinate-field>
                </div>
                <div class="col-md-6">
                    <label class="form-label" for="status">Estado</label>
                    <select name="status" id="status" class="form-select">
                        <option value="borrador" @selected(old('status') === 'borrador')>Borrador</option>
                        <option value="pendiente" @selected(old('status') === 'pendiente')>Pendiente</option>
                        <option value="publicado" @selected(old('status', 'publicado') === 'publicado')>Publicado</option>
                        <option value="archivado" @selected(old('status') === 'archivado')>Archivado</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label" for="images">Imágenes</label>
                    <div class="border rounded p-3 bg-light">
                        <input type="file" name="images[]" id="images" class="form-control" multiple accept="image/*">
                        <small class="text-muted d-block mt-2">Puedes seleccionar varias imágenes a la vez.</small>
                        <div id="images-preview" class="d-flex flex-wrap gap-2 mt-3"></div>
                    </div>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Destacada</label>
                    <div class="form-check form-switch mt-2">
                        <input class="form-check-input" type="checkbox" name="is_featured" value="1" id="is_featured" @checked(old('is_featured', false))>
                        <label class="form-check-label" for="is_featured">Obra destacada</label>
                    </div>
                </div>
                <div class="col-12">
                    <label class="form-label">Artistas</label>
                    <div class="row">
                        @foreach ($artists as $artist)
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="artist_ids[]" value="{{ $artist->id }}" id="artist-{{ $artist->id }}" @checked(in_array($artist->id, old('artist_ids', [])))>
                                    <label class="form-check-label" for="artist-{{ $artist->id }}">{{ $artist->full_name }}</label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-12">
                    <label for="short_description" class="form-label">Resumen corto</label>
                    <textarea name="short_description" id="short_description" class="form-control" rows="2">{{ old('short_description') }}</textarea>
                </div>
                <div class="col-12">
                    <label for="description" class="form-label">Descripción</label>
                    <textarea name="description" id="description" class="form-control" rows="5" required>{{ old('description') }}</textarea>
                </div>
            </div>

            <div class="d-flex gap-2 mt-4">
                <a href="{{ route('adminlte.artworks.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-lg me-1" aria-hidden="true"></i> Guardar
                </button>
            </div>
        </form>
    </x-adminlte-card>
@stop

@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const provinceSelect = document.getElementById('province_id');
            const cantonSelect = document.getElementById('canton_id');
            const parishSelect = document.getElementById('parish_id');

            const fetchByFilter = (value, target, url, paramName, placeholder) => {
                if (!value) {
                    target.innerHTML = '<option value="">' + placeholder + '</option>';
                    return;
                }

                fetch(url + '?' + encodeURIComponent(paramName) + '=' + encodeURIComponent(value))
                    .then(response => response.json())
                    .then(data => {
                        target.innerHTML = '<option value="">' + placeholder + '</option>';
                        data.forEach(item => {
                            const option = document.createElement('option');
                            option.value = item.id;
                            option.textContent = item.name;
                            target.appendChild(option);
                        });
                    });
            };

            provinceSelect.addEventListener('change', function () {
                fetchByFilter(this.value, cantonSelect, '{{ route('adminlte.cantons.index') }}', 'province_id', 'Seleccione un cantón');
                parishSelect.innerHTML = '<option value="">Seleccione una parroquia</option>';
            });

            cantonSelect.addEventListener('change', function () {
                fetchByFilter(this.value, parishSelect, '{{ route('adminlte.parishes.index') }}', 'canton_id', 'Seleccione una parroquia');
            });

            document.querySelectorAll('[data-coordinate-field]').forEach(function (input) {
                const normalizeCoordinate = function () {
                    input.value = input.value.trim().replace(/,/g, '.');
                };

                input.addEventListener('blur', normalizeCoordinate);
                input.addEventListener('change', normalizeCoordinate);
            });

            const imageInput = document.getElementById('images');
            const imagePreview = document.getElementById('images-preview');

            if (imageInput && imagePreview) {
                const renderImagePreview = (files) => {
                    imagePreview.innerHTML = '';

                    if (!files.length) {
                        return;
                    }

                    Array.from(files).forEach(file => {
                        if (!file.type.startsWith('image/')) {
                            return;
                        }

                        const item = document.createElement('div');
                        item.className = 'border rounded bg-white px-2 py-1 text-xs text-secondary';
                        item.textContent = file.name;
                        imagePreview.appendChild(item);
                    });
                };

                imageInput.addEventListener('change', function (event) {
                    renderImagePreview(event.target.files);
                });
            }
        });
    </script>
@endpush
