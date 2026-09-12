@extends('adminlte::page')

@section('title', __('adminlte.edit_user'))

@section('content_header')
    <div class="row">
        <div class="col-sm-6">
            <h1 class="m-0">{{ __('adminlte.edit_user') }}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-end">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">{{ __('adminlte.home') }}</a></li>
                <li class="breadcrumb-item">{{ __('adminlte.administration') }}</li>
                <li class="breadcrumb-item"><a href="{{ route('adminlte.users.index') }}">{{ __('adminlte.users') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ __('adminlte.edit') }}</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    <x-adminlte-card icon="bi bi-person-gear" title="{{ __('adminlte.edit_user') }}">
        <form method="POST" action="{{ route('adminlte.users.update', $user) }}">
            @csrf
            @method('PUT')

            <div class="row g-3">
                <div class="col-md-6">
                    <x-adminlte-input name="first_name" label="Nombres" :value="$user->first_name" required />
                </div>
                <div class="col-md-6">
                    <x-adminlte-input name="last_name" label="Apellidos" :value="$user->last_name" required />
                </div>
                <div class="col-md-6">
                    <x-adminlte-input name="username" label="Usuario" :value="$user->username" required />
                </div>
                <div class="col-md-6">
                    <x-adminlte-input name="email" type="email" label="Correo electrónico" :value="$user->email" required />
                </div>
                <div class="col-md-6">
                    <x-adminlte-input name="password" type="password" label="Nueva contraseña" />
                </div>
                <div class="col-md-6">
                    <x-adminlte-input name="password_confirmation" type="password" label="Confirmar nueva contraseña" />
                </div>
                <div class="col-md-6">
                    <x-adminlte-input name="phone" label="Teléfono" :value="$user->phone" />
                </div>
                <div class="col-md-6">
                    <label class="form-label">Estado</label>
                    <div class="form-check form-switch mt-2">
                        <input class="form-check-input" type="checkbox" name="is_active" value="1" id="is_active" @checked(old('is_active', $user->is_active))>
                        <label class="form-check-label" for="is_active">Usuario activo</label>
                    </div>
                </div>
                <div class="col-12">
                    <label for="biography" class="form-label">Biografía</label>
                    <textarea name="biography" id="biography" class="form-control" rows="3">{{ old('biography', $user->biography) }}</textarea>
                </div>
            </div>

            <div class="mb-3 mt-4">
                <label class="form-label">{{ __('adminlte.roles') }}</label>
                @error('roles')
                    <div class="text-danger small mb-1">{{ $message }}</div>
                @enderror
                <div class="row">
                    @forelse ($roles as $role)
                        <div class="col-md-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="roles[]"
                                       value="{{ $role->id }}" id="role-{{ $role->id }}"
                                       @checked(in_array($role->id, old('roles', $user->roles->pluck('id')->all())))>
                                <label class="form-check-label" for="role-{{ $role->id }}">
                                    {{ $role->label ?? $role->name }}
                                </label>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted">{{ __('adminlte.no_roles') }}</p>
                    @endforelse
                </div>
            </div>

            <div class="d-flex gap-2">
                <a href="{{ route('adminlte.users.index') }}" class="btn btn-outline-secondary">{{ __('adminlte.cancel') }}</a>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-lg me-1" aria-hidden="true"></i> {{ __('adminlte.save') }}
                </button>
            </div>
        </form>
    </x-adminlte-card>
@stop
