@extends('adminlte::page')

@section('title', 'Parroquias')

@section('content_header')
    <div class="row">
        <div class="col-sm-6">
            <h1 class="m-0">Parroquias</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-end">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Inicio</a></li>
                <li class="breadcrumb-item">Administración</li>
                <li class="breadcrumb-item active" aria-current="page">Parroquias</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    @if (session('status'))
        <x-adminlte-alert theme="success" dismissible>{{ session('status') }}</x-adminlte-alert>
    @endif

    <x-adminlte-card icon="bi bi-geo-alt" title="Parroquias" bodyClass="p-0">
        <x-slot name="tools">
            <a href="{{ route('adminlte.parishes.create') }}" class="btn btn-sm btn-primary">
                <i class="bi bi-plus-lg me-1" aria-hidden="true"></i> Nueva parroquia
            </a>
        </x-slot>

        <div class="table-responsive">
            <table class="table table-striped align-middle m-0">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Cantón</th>
                        <th>Provincia</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($parishes as $parish)
                        <tr>
                            <td><strong>{{ $parish->name }}</strong></td>
                            <td>{{ $parish->canton?->name ?? 'Sin cantón' }}</td>
                            <td>{{ $parish->canton?->province?->name ?? 'Sin provincia' }}</td>
                            <td class="text-end">
                                <a href="{{ route('adminlte.parishes.edit', $parish) }}"
                                   class="btn btn-sm btn-outline-secondary" aria-label="Editar">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form method="POST" action="{{ route('adminlte.parishes.destroy', $parish) }}"
                                      onsubmit="return confirm('¿Desea eliminar esta parroquia?');" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger" aria-label="Eliminar">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="text-center text-muted py-4">No hay parroquias registradas.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <x-slot name="footer">
            {{ $parishes->links() }}
        </x-slot>
    </x-adminlte-card>
@stop
