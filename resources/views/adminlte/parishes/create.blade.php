@extends('adminlte::page')

@section('title', 'Nueva parroquia')

@section('content_header')
    <div class="row">
        <div class="col-sm-6">
            <h1 class="m-0">Nueva parroquia</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-end">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Inicio</a></li>
                <li class="breadcrumb-item">Administración</li>
                <li class="breadcrumb-item"><a href="{{ route('adminlte.parishes.index') }}">Parroquias</a></li>
                <li class="breadcrumb-item active" aria-current="page">Crear</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    <x-adminlte-card icon="bi bi-geo-alt-fill" title="Nueva parroquia">
        <form method="POST" action="{{ route('adminlte.parishes.store') }}">
            @csrf

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label required" for="canton_id">Cantón <span class="required-indicator" aria-label="Campo obligatorio">*</span></label>
                    <select name="canton_id" id="canton_id" class="form-select" required>
                        <option value="">Seleccione un cantón</option>
                        @foreach ($cantons as $canton)
                            <option value="{{ $canton->id }}" @selected(old('canton_id') == $canton->id)>{{ $canton->province?->name ?? 'Sin provincia' }} - {{ $canton->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <x-adminlte-input name="name" label="Nombre" value="{{ old('name') }}" required />
                </div>
            </div>

            <div class="d-flex gap-2 mt-4">
                <a href="{{ route('adminlte.parishes.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-lg me-1" aria-hidden="true"></i> Guardar
                </button>
            </div>
        </form>
    </x-adminlte-card>
@stop
