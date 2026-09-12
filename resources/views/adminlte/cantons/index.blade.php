@extends('adminlte::page')

@section('title', 'Cantones')

@section('content_header')
    <div class="row">
        <div class="col-sm-6">
            <h1 class="m-0">Cantones</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-end">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Inicio</a></li>
                <li class="breadcrumb-item">Administración</li>
                <li class="breadcrumb-item active" aria-current="page">Cantones</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    @if (session('status'))
        <x-adminlte-alert theme="success" dismissible>{{ session('status') }}</x-adminlte-alert>
    @endif

    <x-adminlte-card icon="bi bi-pin-map" title="Cantones" bodyClass="p-0">
        <x-slot name="tools">
            <a href="{{ route('adminlte.cantons.create') }}" class="btn btn-sm btn-primary">
                <i class="bi bi-plus-lg me-1" aria-hidden="true"></i> Nuevo cantón
            </a>
        </x-slot>

        <div class="table-responsive">
            <table class="table table-striped align-middle m-0">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Provincia</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($cantons as $canton)
                        <tr>
                            <td><strong>{{ $canton->name }}</strong></td>
                            <td>{{ $canton->province?->name ?? 'Sin provincia' }}</td>
                            <td class="text-end">
                                <a href="{{ route('adminlte.cantons.edit', $canton) }}"
                                   class="btn btn-sm btn-outline-secondary" aria-label="Editar">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form method="POST" action="{{ route('adminlte.cantons.destroy', $canton) }}"
                                      onsubmit="return confirm('¿Desea eliminar este cantón?');" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger" aria-label="Eliminar">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="3" class="text-center text-muted py-4">No hay cantones registrados.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <x-slot name="footer">
            @if ($cantons->hasPages())
                <div class="d-flex justify-content-end py-2 px-3">
                    {{ $cantons->onEachSide(1)->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </x-slot>
    </x-adminlte-card>
@stop
