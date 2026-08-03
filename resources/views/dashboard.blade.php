{{-- resources/views/dashboard.blade.php --}}
@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h3 class="mb-0">Dashboard</h3>
@stop

@section('content')
    <x-adminlte-info-box title="Orders" text="150" icon="bi bi-bag" theme="primary" />
@stop