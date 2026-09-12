@extends('adminlte::page')

@section('title', 'Artistas')

@section('content_header')
    <div class="row">
        <div class="col-sm-6">
            <h1 class="m-0">Artistas</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-end">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Inicio</a></li>
                <li class="breadcrumb-item">Administración</li>
                <li class="breadcrumb-item active" aria-current="page">Artistas</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    @if (session('status'))
        <x-adminlte-alert theme="success" dismissible>{{ session('status') }}</x-adminlte-alert>
    @endif

    <x-adminlte-card icon="bi bi-person-badge" title="Artistas" bodyClass="p-0">
        <x-slot name="tools">
            <a href="{{ route('adminlte.artists.create') }}" class="btn btn-sm btn-primary">
                <i class="bi bi-plus-lg me-1" aria-hidden="true"></i> Nuevo artista
            </a>
        </x-slot>

        <div class="table-responsive">
            <table class="table table-striped align-middle m-0">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Nacionalidad</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($artists as $artist)
                        <tr>
                            <td><strong>{{ $artist->full_name }}</strong></td>
                            <td>{{ $artist->nationality ?? '—' }}</td>
                            <td class="text-end">
                                <a href="{{ route('adminlte.artists.edit', $artist) }}" class="btn btn-sm btn-outline-secondary" aria-label="Editar">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form method="POST" action="{{ route('adminlte.artists.destroy', $artist) }}" onsubmit="return confirm('¿Desea eliminar este artista?');" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger" aria-label="Eliminar">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="3" class="text-center text-muted py-4">No hay artistas registrados.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <x-slot name="footer">
            {{ $artists->links() }}
        </x-slot>
    </x-adminlte-card>
@stop
