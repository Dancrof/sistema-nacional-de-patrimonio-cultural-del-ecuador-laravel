@extends('adminlte::page')

@section('title', 'Editar obra')

@section('content_header')
    <div class="row">
        <div class="col-sm-6">
            <h1 class="m-0">Editar obra</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-end">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Inicio</a></li>
                <li class="breadcrumb-item">Administración</li>
                <li class="breadcrumb-item"><a href="{{ route('adminlte.artworks.index') }}">Obras</a></li>
                <li class="breadcrumb-item active" aria-current="page">Editar</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    <x-adminlte-card icon="bi bi-pencil-square" title="Editar obra">
        <form method="POST" action="{{ route('adminlte.artworks.update', $artwork) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row g-3">
                <div class="col-md-6">
                    <x-adminlte-input name="code" label="Código" :value="$artwork->code" required />
                </div>
                <div class="col-md-6">
                    <x-adminlte-input name="title" label="Título" :value="$artwork->title" required />
                </div>
                <div class="col-md-6">
                    <label class="form-label required" for="category_id">Categoría <span class="required-indicator" aria-label="Campo obligatorio">*</span></label>
                    <select name="category_id" id="category_id" class="form-select" required>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" @selected(old('category_id', $artwork->category_id) == $category->id)>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label required" for="artwork_type_id">Tipo de obra <span class="required-indicator" aria-label="Campo obligatorio">*</span></label>
                    <select name="artwork_type_id" id="artwork_type_id" class="form-select" required>
                        @foreach ($artworkTypes as $type)
                            <option value="{{ $type->id }}" @selected(old('artwork_type_id', $artwork->artwork_type_id) == $type->id)>{{ $type->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label" for="conservation_status_id">Estado de conservación</label>
                    <select name="conservation_status_id" id="conservation_status_id" class="form-select">
                        <option value="">Seleccione</option>
                        @foreach ($statuses as $status)
                            <option value="{{ $status->id }}" @selected(old('conservation_status_id', $artwork->conservation_status_id) == $status->id)>{{ $status->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label required" for="province_id">Provincia <span class="required-indicator" aria-label="Campo obligatorio">*</span></label>
                    <select name="province_id" id="province_id" class="form-select" required>
                        @foreach ($provinces as $province)
                            <option value="{{ $province->id }}" @selected(old('province_id', $artwork->province_id) == $province->id)>{{ $province->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label required" for="canton_id">Cantón <span class="required-indicator" aria-label="Campo obligatorio">*</span></label>
                    <select name="canton_id" id="canton_id" class="form-select" required>
                        @foreach ($cantons as $canton)
                            <option value="{{ $canton->id }}" @selected(old('canton_id', $artwork->canton_id) == $canton->id)>{{ $canton->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label" for="parish_id">Parroquia</label>
                    <select name="parish_id" id="parish_id" class="form-select">
                        <option value="">Seleccione</option>
                        @if ($artwork->parish)
                            <option value="{{ $artwork->parish->id }}" selected>{{ $artwork->parish->name }}</option>
                        @endif
                    </select>
                </div>
                <div class="col-md-6">
                    <x-adminlte-input name="creation_year" type="number" min="1000" max="2100" label="Año de creación" :value="$artwork->creation_year" />
                </div>
                <div class="col-md-6">
                    <x-adminlte-input name="address" label="Dirección" :value="$artwork->address" />
                </div>
                <div class="col-md-6">
                    <label class="form-label" for="latitude">Latitud</label>
                    <input type="text" name="latitude" id="latitude" class="form-control" inputmode="decimal" pattern="^-?(?:90(?:\.0+)?|[0-8]?\d(?:\.\d+)?)$" value="{{ old('latitude', $artwork->latitude) }}" data-coordinate-field>
                </div>
                <div class="col-md-6">
                    <label class="form-label" for="longitude">Longitud</label>
                    <input type="text" name="longitude" id="longitude" class="form-control" inputmode="decimal" pattern="^-?(?:180(?:\.0+)?|(?:1[0-7]\d|\d{1,2})(?:\.\d+)?)$" value="{{ old('longitude', $artwork->longitude) }}" data-coordinate-field>
                </div>
                <div class="col-md-6">
                    <label class="form-label" for="status">Estado</label>
                    <select name="status" id="status" class="form-select">
                        @foreach (['borrador', 'pendiente', 'publicado', 'archivado'] as $state)
                            <option value="{{ $state }}" @selected(old('status', $artwork->status) === $state)>{{ ucfirst($state) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label" for="images">Imágenes</label>
                    <div class="border rounded p-3 bg-light">
                        <input type="file" name="images[]" id="images" class="form-control" multiple accept="image/*">
                        <small class="text-muted d-block mt-2">Si no agregas nuevas imágenes, se conserva la existente.</small>
                        <div id="images-preview" class="d-flex flex-wrap gap-2 mt-3"></div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="border rounded p-3 bg-light">
                        <div class="d-flex align-items-center justify-content-between gap-3 mb-3">
                            <label class="form-label mb-0">Videos de la obra</label>
                            <button type="button" id="add-video" class="btn btn-sm btn-outline-primary">Agregar video</button>
                        </div>

                        <div id="videos-container">
                            @forelse ($artwork->videos as $index => $video)
                                <div class="video-item border rounded p-3 bg-white @if (!$loop->first) mt-3 @endif">
                                    <div class="row g-3">
                                        <div class="col-md-4">
                                            <label class="form-label" for="videos-{{ $index }}-title">Título</label>
                                            <input type="text" name="videos[{{ $index }}][title]" id="videos-{{ $index }}-title" class="form-control" value="{{ old('videos.' . $index . '.title', $video->title) }}">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label" for="videos-{{ $index }}-video_url">URL del video</label>
                                            <input type="url" name="videos[{{ $index }}][video_url]" id="videos-{{ $index }}-video_url" class="form-control" value="{{ old('videos.' . $index . '.video_url', $video->video_url) }}">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label" for="videos-{{ $index }}-provider">Proveedor</label>
                                            <select name="videos[{{ $index }}][provider]" id="videos-{{ $index }}-provider" class="form-select">
                                                <option value="">Seleccione</option>
                                                <option value="youtube" @selected(old('videos.' . $index . '.provider', $video->provider) === 'youtube')>YouTube</option>
                                                <option value="vimeo" @selected(old('videos.' . $index . '.provider', $video->provider) === 'vimeo')>Vimeo</option>
                                                <option value="facebook" @selected(old('videos.' . $index . '.provider', $video->provider) === 'facebook')>Facebook</option>
                                                <option value="other" @selected(old('videos.' . $index . '.provider', $video->provider) === 'other')>Otro</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label" for="videos-{{ $index }}-thumbnail">Miniatura</label>
                                            <input type="url" name="videos[{{ $index }}][thumbnail]" id="videos-{{ $index }}-thumbnail" class="form-control" value="{{ old('videos.' . $index . '.thumbnail', $video->thumbnail) }}">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label" for="videos-{{ $index }}-duration">Duración</label>
                                            <input type="time" name="videos[{{ $index }}][duration]" id="videos-{{ $index }}-duration" class="form-control" step="1" value="{{ old('videos.' . $index . '.duration', $video->duration?->format('H:i:s')) }}">
                                        </div>
                                        <div class="col-md-4 d-flex align-items-end">
                                            <button type="button" class="btn btn-outline-danger w-100 remove-video">Quitar</button>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="video-item border rounded p-3 bg-white">
                                    <div class="row g-3">
                                        <div class="col-md-4">
                                            <label class="form-label" for="videos-0-title">Título</label>
                                            <input type="text" name="videos[0][title]" id="videos-0-title" class="form-control" placeholder="Ej. Video documental">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label" for="videos-0-video_url">URL del video</label>
                                            <input type="url" name="videos[0][video_url]" id="videos-0-video_url" class="form-control" placeholder="https://youtube.com/watch?v=...">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label" for="videos-0-provider">Proveedor</label>
                                            <select name="videos[0][provider]" id="videos-0-provider" class="form-select">
                                                <option value="">Seleccione</option>
                                                <option value="youtube">YouTube</option>
                                                <option value="vimeo">Vimeo</option>
                                                <option value="facebook">Facebook</option>
                                                <option value="other">Otro</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label" for="videos-0-thumbnail">Miniatura</label>
                                            <input type="url" name="videos[0][thumbnail]" id="videos-0-thumbnail" class="form-control" placeholder="https://...jpg">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label" for="videos-0-duration">Duración</label>
                                            <input type="time" name="videos[0][duration]" id="videos-0-duration" class="form-control" step="1">
                                        </div>
                                        <div class="col-md-4 d-flex align-items-end">
                                            <button type="button" class="btn btn-outline-danger w-100 remove-video">Quitar</button>
                                        </div>
                                    </div>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Destacada</label>
                    <div class="form-check form-switch mt-2">
                        <input class="form-check-input" type="checkbox" name="is_featured" value="1" id="is_featured" @checked(old('is_featured', $artwork->is_featured))>
                        <label class="form-check-label" for="is_featured">Obra destacada</label>
                    </div>
                </div>
                <div class="col-12">
                    <label class="form-label">Artistas</label>
                    <div class="row">
                        @foreach ($artists as $artist)
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="artist_ids[]" value="{{ $artist->id }}" id="artist-{{ $artist->id }}" @checked($artwork->artists->contains($artist->id))>
                                    <label class="form-check-label" for="artist-{{ $artist->id }}">{{ $artist->full_name }}</label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-12">
                    <label for="short_description" class="form-label">Resumen corto</label>
                    <textarea name="short_description" id="short_description" class="form-control" rows="2">{{ old('short_description', $artwork->short_description) }}</textarea>
                </div>
                <div class="col-12">
                    <label for="description" class="form-label required">Descripción <span class="required-indicator" aria-label="Campo obligatorio">*</span></label>
                    <textarea name="description" id="description" class="form-control" rows="5" required>{{ old('description', $artwork->description) }}</textarea>
                </div>
            </div>

            <div class="d-flex gap-2 mt-4">
                <a href="{{ route('adminlte.artworks.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-lg me-1" aria-hidden="true"></i> Guardar cambios
                </button>
            </div>
        </form>
    </x-adminlte-card>
@stop

@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const imageInput = document.getElementById('images');
            const imagePreview = document.getElementById('images-preview');
            const videosContainer = document.getElementById('videos-container');
            const addVideoButton = document.getElementById('add-video');

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

            if (videosContainer && addVideoButton) {
                const attachVideoEvents = (videoItem) => {
                    const urlInput = videoItem.querySelector('input[name*="[video_url]"]');
                    const providerInput = videoItem.querySelector('select[name*="[provider]"]');

                    if (urlInput && providerInput) {
                        urlInput.addEventListener('change', function () {
                            const value = this.value.toLowerCase();
                            if (!value) return;

                            if (value.includes('youtube.com') || value.includes('youtu.be')) {
                                providerInput.value = 'youtube';
                            } else if (value.includes('vimeo.com')) {
                                providerInput.value = 'vimeo';
                            } else if (value.includes('facebook.com')) {
                                providerInput.value = 'facebook';
                            }
                        });
                    }

                    const removeButton = videoItem.querySelector('.remove-video');
                    if (removeButton) {
                        removeButton.addEventListener('click', function () {
                            const items = videosContainer.querySelectorAll('.video-item');
                            if (items.length > 1) {
                                videoItem.remove();
                            }
                        });
                    }
                };

                const createVideoItem = (index) => {
                    const item = document.createElement('div');
                    item.className = 'video-item border rounded p-3 bg-white mt-3';
                    item.innerHTML = `
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label" for="videos-${index}-title">Título</label>
                                <input type="text" name="videos[${index}][title]" id="videos-${index}-title" class="form-control" placeholder="Ej. Video documental">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label" for="videos-${index}-video_url">URL del video</label>
                                <input type="url" name="videos[${index}][video_url]" id="videos-${index}-video_url" class="form-control" placeholder="https://youtube.com/watch?v=...">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label" for="videos-${index}-provider">Proveedor</label>
                                <select name="videos[${index}][provider]" id="videos-${index}-provider" class="form-select">
                                    <option value="">Seleccione</option>
                                    <option value="youtube">YouTube</option>
                                    <option value="vimeo">Vimeo</option>
                                    <option value="facebook">Facebook</option>
                                    <option value="other">Otro</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label" for="videos-${index}-thumbnail">Miniatura</label>
                                <input type="url" name="videos[${index}][thumbnail]" id="videos-${index}-thumbnail" class="form-control" placeholder="https://...jpg">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label" for="videos-${index}-duration">Duración</label>
                                <input type="time" name="videos[${index}][duration]" id="videos-${index}-duration" class="form-control" step="1">
                            </div>
                            <div class="col-md-4 d-flex align-items-end">
                                <button type="button" class="btn btn-outline-danger w-100 remove-video">Quitar</button>
                            </div>
                        </div>
                    `;

                    attachVideoEvents(item);
                    return item;
                };

                const initialItems = videosContainer.querySelectorAll('.video-item');
                initialItems.forEach(attachVideoEvents);

                addVideoButton.addEventListener('click', function () {
                    const index = videosContainer.querySelectorAll('.video-item').length;
                    videosContainer.appendChild(createVideoItem(index));
                });
            }
        });
    </script>
@endpush
