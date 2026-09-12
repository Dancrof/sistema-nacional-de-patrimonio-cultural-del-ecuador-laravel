@extends('adminlte::page')

@section('title', 'Tipos de obra')

@section('content_header')
    <div class="row">
        <div class="col-sm-6">
            <h1 class="m-0">Tipos de obra</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-end">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Inicio</a></li>
                <li class="breadcrumb-item">Administración</li>
                <li class="breadcrumb-item active" aria-current="page">Tipos de obra</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    @if (session('status'))
        <x-adminlte-alert theme="success" dismissible>{{ session('status') }}</x-adminlte-alert>
    @endif

    <x-adminlte-card icon="bi bi-palette" title="Tipos de obra" bodyClass="p-0">
        <x-slot name="tools">
            <a href="{{ route('adminlte.artwork-types.create') }}" class="btn btn-sm btn-primary">
                <i class="bi bi-plus-lg me-1" aria-hidden="true"></i> Nuevo tipo
            </a>
        </x-slot>

        <div class="table-responsive">
            <table class="table table-striped align-middle m-0">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($artworkTypes as $artworkType)
                        <tr>
                            <td><strong>{{ $artworkType->name }}</strong></td>
                            <td class="text-muted">{{ $artworkType->description ?? '—' }}</td>
                            <td class="text-end">
                                <a href="{{ route('adminlte.artwork-types.edit', $artworkType) }}" class="btn btn-sm btn-outline-secondary" aria-label="Editar">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form method="POST" action="{{ route('adminlte.artwork-types.destroy', $artworkType) }}" onsubmit="return confirm('¿Desea eliminar este tipo?');" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger" aria-label="Eliminar">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="3" class="text-center text-muted py-4">No hay tipos de obra registrados.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <x-slot name="footer">
            {{ $artworkTypes->links() }}
        </x-slot>
    </x-adminlte-card>
@stop
