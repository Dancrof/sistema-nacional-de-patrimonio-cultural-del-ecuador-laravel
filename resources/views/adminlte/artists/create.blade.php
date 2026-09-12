@extends('adminlte::page')

@section('title', 'Nuevo artista')

@section('content_header')
    <div class="row">
        <div class="col-sm-6">
            <h1 class="m-0">Nuevo artista</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-end">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Inicio</a></li>
                <li class="breadcrumb-item">Administración</li>
                <li class="breadcrumb-item"><a href="{{ route('adminlte.artists.index') }}">Artistas</a></li>
                <li class="breadcrumb-item active" aria-current="page">Crear</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    <x-adminlte-card icon="bi bi-person-plus" title="Nuevo artista">
        <form method="POST" action="{{ route('adminlte.artists.store') }}">
            @csrf

            <div class="row g-3">
                <div class="col-md-6">
                    <x-adminlte-input name="first_name" label="Nombres" value="{{ old('first_name') }}" required />
                </div>
                <div class="col-md-6">
                    <x-adminlte-input name="last_name" label="Apellidos" value="{{ old('last_name') }}" />
                </div>
                <div class="col-md-6">
                    <x-adminlte-input name="birth_date" type="date" label="Fecha de nacimiento" value="{{ old('birth_date') }}" />
                </div>
                <div class="col-md-6">
                    <x-adminlte-input name="death_date" type="date" label="Fecha de fallecimiento" value="{{ old('death_date') }}" />
                </div>
                <div class="col-md-6">
                    <x-adminlte-input name="birth_place" label="Lugar de nacimiento" value="{{ old('birth_place') }}" />
                </div>
                <div class="col-md-6">
                    <x-adminlte-input name="nationality" label="Nacionalidad" value="{{ old('nationality') }}" />
                </div>
                <div class="col-md-6">
                    <x-adminlte-input name="website" type="url" label="Sitio web" value="{{ old('website') }}" />
                </div>
                <div class="col-md-6">
                    <label class="form-label">Estado</label>
                    <div class="form-check form-switch mt-2">
                        <input class="form-check-input" type="checkbox" name="is_deceased" value="1" id="is_deceased" @checked(old('is_deceased', false))>
                        <label class="form-check-label" for="is_deceased">Fallecido</label>
                    </div>
                </div>
                <div class="col-12">
                    <label for="biography" class="form-label">Biografía</label>
                    <textarea name="biography" id="biography" class="form-control" rows="5">{{ old('biography') }}</textarea>
                </div>
            </div>

            <div class="d-flex gap-2 mt-4">
                <a href="{{ route('adminlte.artists.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-lg me-1" aria-hidden="true"></i> Guardar
                </button>
            </div>
        </form>
    </x-adminlte-card>
@stop
