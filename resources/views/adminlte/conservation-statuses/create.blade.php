@extends('adminlte::page')

@section('title', 'Nuevo estado de conservación')

@section('content_header')
    <div class="row">
        <div class="col-sm-6">
            <h1 class="m-0">Nuevo estado de conservación</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-end">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Inicio</a></li>
                <li class="breadcrumb-item">Administración</li>
                <li class="breadcrumb-item"><a href="{{ route('adminlte.conservation-statuses.index') }}">Estados</a></li>
                <li class="breadcrumb-item active" aria-current="page">Crear</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    <x-adminlte-card icon="bi bi-heart-pulse-fill" title="Nuevo estado de conservación">
        <form method="POST" action="{{ route('adminlte.conservation-statuses.store') }}">
            @csrf

            <div class="row g-3">
                <div class="col-md-6">
                    <x-adminlte-input name="name" label="Nombre" value="{{ old('name') }}" required />
                </div>
                <div class="col-md-6">
                    <x-adminlte-input name="description" label="Descripción" value="{{ old('description') }}" />
                </div>
            </div>

            <div class="d-flex gap-2 mt-4">
                <a href="{{ route('adminlte.conservation-statuses.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-lg me-1" aria-hidden="true"></i> Guardar
                </button>
            </div>
        </form>
    </x-adminlte-card>
@stop
