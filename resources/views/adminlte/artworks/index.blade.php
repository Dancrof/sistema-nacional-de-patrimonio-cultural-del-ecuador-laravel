@extends('adminlte::page')

@section('title', 'Obras')

@section('content_header')
    <div class="row">
        <div class="col-sm-6">
            <h1 class="m-0">Obras</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-end">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Inicio</a></li>
                <li class="breadcrumb-item">Administración</li>
                <li class="breadcrumb-item active" aria-current="page">Obras</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    @if (session('status'))
        <x-adminlte-alert theme="success" dismissible>{{ session('status') }}</x-adminlte-alert>
    @endif

    <x-adminlte-card icon="bi bi-palette2" title="Obras" bodyClass="p-0">
        <x-slot name="tools">
            <a href="{{ route('adminlte.artworks.create') }}" class="btn btn-sm btn-primary">
                <i class="bi bi-plus-lg me-1" aria-hidden="true"></i> Nueva obra
            </a>
        </x-slot>

        <div class="table-responsive">
            <table class="table table-striped align-middle m-0">
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Título</th>
                        <th>Categoria</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($artworks as $artwork)
                        <tr>
                            <td><strong>{{ $artwork->code }}</strong></td>
                            <td>{{ $artwork->title }}</td>
                            <td>{{ $artwork->category?->name ?? '—' }}</td>
                            <td class="text-end">
                                <a href="{{ route('adminlte.artworks.edit', $artwork) }}" class="btn btn-sm btn-outline-secondary" aria-label="Editar">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form method="POST" action="{{ route('adminlte.artworks.destroy', $artwork) }}" onsubmit="return confirm('¿Desea eliminar esta obra?');" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger" aria-label="Eliminar">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="text-center text-muted py-4">No hay obras registradas.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <x-slot name="footer">
            {{ $artworks->links() }}
        </x-slot>
    </x-adminlte-card>
@stop
