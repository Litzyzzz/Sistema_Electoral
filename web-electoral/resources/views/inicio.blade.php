@extends('layouts.app')

@section('contenido')

    <div class="container">
        <h1>Bienvenido al Sistema de<br>Votación Presidencial 2026</h1>

        <a href="{{ route('identificacion') }}" class="btn-primary">
            Comenzar
        </a>
    </div>
@endsection