@extends('adminlte::page')

@section('title', 'Nueva provincia')

@section('content_header')
    <div class="row">
        <div class="col-sm-6">
            <h1 class="m-0">Nueva provincia</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-end">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Inicio</a></li>
                <li class="breadcrumb-item">Administración</li>
                <li class="breadcrumb-item"><a href="{{ route('adminlte.provinces.index') }}">Provincias</a></li>
                <li class="breadcrumb-item active" aria-current="page">Crear</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    <x-adminlte-card icon="bi bi-map" title="Nueva provincia">
        <form method="POST" action="{{ route('adminlte.provinces.store') }}">
            @csrf

            <div class="row g-3">
                <div class="col-md-6">
                    <x-adminlte-input name="name" label="Nombre" value="{{ old('name') }}" required />
                </div>
                <div class="col-md-6">
                    <label class="form-label required" for="region">Región <span class="required-indicator" aria-label="Campo obligatorio">*</span></label>
                    <select name="region" id="region" class="form-select" required>
                        <option value="">Seleccione una región</option>
                        <option value="Costa" @selected(old('region') === 'Costa')>Costa</option>
                        <option value="Sierra" @selected(old('region') === 'Sierra')>Sierra</option>
                        <option value="Amazonia" @selected(old('region') === 'Amazonia')>Amazonia</option>
                        <option value="Insular" @selected(old('region') === 'Insular')>Insular</option>
                    </select>
                </div>
                <div class="col-12">
                    <label for="description" class="form-label">Descripción</label>
                    <textarea name="description" id="description" class="form-control" rows="3">{{ old('description') }}</textarea>
                </div>
                <div class="col-md-6">
                    <x-adminlte-input name="latitude" label="Latitud" type="number" step="0.000001" value="{{ old('latitude') }}" />
                </div>
                <div class="col-md-6">
                    <x-adminlte-input name="longitude" label="Longitud" type="number" step="0.000001" value="{{ old('longitude') }}" />
                </div>
            </div>

            <div class="d-flex gap-2 mt-4">
                <a href="{{ route('adminlte.provinces.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-lg me-1" aria-hidden="true"></i> Guardar
                </button>
            </div>
        </form>
    </x-adminlte-card>
@stop
