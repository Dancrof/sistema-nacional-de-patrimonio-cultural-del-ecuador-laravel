@extends('adminlte::page')

@section('title', 'Editar tipo de obra')

@section('content_header')
    <div class="row">
        <div class="col-sm-6">
            <h1 class="m-0">Editar tipo de obra</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-end">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Inicio</a></li>
                <li class="breadcrumb-item">Administración</li>
                <li class="breadcrumb-item"><a href="{{ route('adminlte.artwork-types.index') }}">Tipos de obra</a></li>
                <li class="breadcrumb-item active" aria-current="page">Editar</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    <x-adminlte-card icon="bi bi-pencil-square" title="Editar tipo de obra">
        <form method="POST" action="{{ route('adminlte.artwork-types.update', $artworkType) }}">
            @csrf
            @method('PUT')

            <div class="row g-3">
                <div class="col-md-6">
                    <x-adminlte-input name="name" label="Nombre" :value="$artworkType->name" required />
                </div>
                <div class="col-md-6">
                    <x-adminlte-input name="description" label="Descripción" :value="$artworkType->description" />
                </div>
            </div>

            <div class="d-flex gap-2 mt-4">
                <a href="{{ route('adminlte.artwork-types.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-lg me-1" aria-hidden="true"></i> Guardar cambios
                </button>
            </div>
        </form>
    </x-adminlte-card>
@stop
