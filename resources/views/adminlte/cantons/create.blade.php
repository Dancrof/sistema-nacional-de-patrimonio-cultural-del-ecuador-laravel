@extends('adminlte::page')

@section('title', 'Nuevo cantón')

@section('content_header')
    <div class="row">
        <div class="col-sm-6">
            <h1 class="m-0">Nuevo cantón</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-end">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Inicio</a></li>
                <li class="breadcrumb-item">Administración</li>
                <li class="breadcrumb-item"><a href="{{ route('adminlte.cantons.index') }}">Cantones</a></li>
                <li class="breadcrumb-item active" aria-current="page">Crear</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    <x-adminlte-card icon="bi bi-pin-map-fill" title="Nuevo cantón">
        <form method="POST" action="{{ route('adminlte.cantons.store') }}">
            @csrf

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label required" for="province_id">Provincia <span class="required-indicator" aria-label="Campo obligatorio">*</span></label>
                    <select name="province_id" id="province_id" class="form-select" required>
                        <option value="">Seleccione una provincia</option>
                        @foreach ($provinces as $province)
                            <option value="{{ $province->id }}" @selected(old('province_id') == $province->id)>{{ $province->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <x-adminlte-input name="name" label="Nombre" value="{{ old('name') }}" required />
                </div>
            </div>

            <div class="d-flex gap-2 mt-4">
                <a href="{{ route('adminlte.cantons.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-lg me-1" aria-hidden="true"></i> Guardar
                </button>
            </div>
        </form>
    </x-adminlte-card>
@stop
