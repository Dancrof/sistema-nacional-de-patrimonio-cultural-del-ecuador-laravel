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
        <form method="POST" action="{{ route('adminlte.artworks.update', $artwork) }}">
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
                    <label class="form-label" for="category_id">Categoría</label>
                    <select name="category_id" id="category_id" class="form-select" required>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" @selected(old('category_id', $artwork->category_id) == $category->id)>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label" for="artwork_type_id">Tipo de obra</label>
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
                    <label class="form-label" for="province_id">Provincia</label>
                    <select name="province_id" id="province_id" class="form-select" required>
                        @foreach ($provinces as $province)
                            <option value="{{ $province->id }}" @selected(old('province_id', $artwork->province_id) == $province->id)>{{ $province->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label" for="canton_id">Cantón</label>
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
                    <label class="form-label" for="status">Estado</label>
                    <select name="status" id="status" class="form-select">
                        @foreach (['borrador', 'pendiente', 'publicado', 'archivado'] as $state)
                            <option value="{{ $state }}" @selected(old('status', $artwork->status) === $state)>{{ ucfirst($state) }}</option>
                        @endforeach
                    </select>
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
                    <label for="description" class="form-label">Descripción</label>
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
