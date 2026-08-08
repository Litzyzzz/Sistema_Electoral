@extends('layouts.app')

@section('contenido')

<div class="container text-center mt-5">

    <div class="card shadow p-5">

        <h1 class="mb-3">
            Resultados no disponibles
        </h1>

        @if (!$eleccion)

            <p class="text-muted">
                No existe una elección configurada actualmente.
            </p>

        @elseif ($eleccion->estado === 'activa')

            <p class="text-muted">
                Las elecciones todavía están en curso
            </p>

            <p>
                Los resultados estarán disponibles
                cuando finalice el proceso electoral
            </p>

        @else

            <p class="text-muted">
                Los resultados todavía no están disponibles.
            </p>

        @endif

        <a href="{{ route('inicio') }}" class="btn btn-primary">
            Regresar
        </a>

    </div>

</div>
@endsection