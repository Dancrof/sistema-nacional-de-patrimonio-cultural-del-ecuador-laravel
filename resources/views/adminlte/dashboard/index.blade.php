@extends('adminlte::page')

@section('title', __('adminlte.dashboard'))

@section('content_header')
    <h1 class="m-0">{{ __('adminlte.dashboard') }}</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-3 col-6">
            <x-adminlte-small-box title="{{ $stats['artworks'] ?? 0 }}" text="Obras"
                theme="primary" icon="bi bi-palette2"
                :url="\Illuminate\Support\Facades\Route::has('adminlte.artworks.index') ? route('adminlte.artworks.index') : null" />
        </div>

        <div class="col-lg-3 col-6">
            <x-adminlte-small-box title="{{ $stats['artists'] ?? 0 }}" text="Artistas"
                theme="success" icon="bi bi-person-badge"
                :url="\Illuminate\Support\Facades\Route::has('adminlte.artists.index') ? route('adminlte.artists.index') : null" />
        </div>

        <div class="col-lg-3 col-6">
            <x-adminlte-small-box title="{{ $stats['categories'] ?? 0 }}" text="Categorías"
                theme="warning" icon="bi bi-tags"
                :url="\Illuminate\Support\Facades\Route::has('adminlte.categories.index') ? route('adminlte.categories.index') : null" />
        </div>

        <div class="col-lg-3 col-6">
            <x-adminlte-small-box title="{{ $stats['provinces'] ?? 0 }}" text="Provincias"
                theme="info" icon="bi bi-map"
                :url="\Illuminate\Support\Facades\Route::has('adminlte.provinces.index') ? route('adminlte.provinces.index') : null" />
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <x-adminlte-card icon="bi bi-bar-chart" title="Obras por estado">
                @forelse ($projectsByStatus as $status => $total)
                    @php($pct = ($stats['artworks'] ?? 0) > 0 ? round($total / ($stats['artworks'] ?? 1) * 100) : 0)
                    <div class="mb-3">
                        <div class="d-flex justify-content-between">
                            <span>{{ ucfirst(str_replace('-', ' ', $status)) }}</span>
                            <span class="text-secondary">{{ $total }}</span>
                        </div>
                        <div class="progress" role="progressbar" aria-valuenow="{{ $pct }}" aria-valuemin="0" aria-valuemax="100">
                            <div class="progress-bar text-bg-primary" style="width: {{ $pct }}%"></div>
                        </div>
                    </div>
                @empty
                    <p class="text-secondary mb-0">Aún no hay obras registradas.</p>
                @endforelse
            </x-adminlte-card>
        </div>

        <div class="col-md-6">
            <x-adminlte-card icon="bi bi-clock-history" title="Actividad reciente" bodyClass="p-0">
                <div class="list-group list-group-flush">
                    @forelse ($recentActivity as $entry)
                        <div class="list-group-item">
                            <div class="d-flex justify-content-between gap-3">
                                <span><span class="badge text-bg-secondary me-2">{{ $entry->event }}</span>{{ $entry->description }}</span>
                                <small class="text-secondary text-nowrap">{{ \Illuminate\Support\Carbon::parse($entry->created_at)->diffForHumans() }}</small>
                            </div>
                            <small class="text-secondary">{{ $entry->user_name ?? 'Sistema' }}</small>
                        </div>
                    @empty
                        <div class="list-group-item text-secondary">No hay actividad reciente.</div>
                    @endforelse
                </div>
            </x-adminlte-card>
        </div>
    </div>
@stop
