@extends('layouts.app')

@section('contenido')

    <div class="container inicio-container">
        <h1>Bienvenido al Sistema de<br>Votación Presidencial 2026</h1>

        <a href="{{ route('identificacion') }}" class="btn-primary">
            Comenzar
        </a>

        <a href="{{ route('resultados.dashboard') }}" class="btn-resultados-acceso" aria-label="Ver resultados">
            Ver resultados
        </a>
    </div>
@endsection