@extends('layouts.app')

@section('contenido')

<div class="container text-center mt-5">

    <div class="card shadow p-5">

        <h1 class="mb-3">
            Ya no se permiten votaciones
        </h1>

        @if (!$eleccion)

            <p class="text-muted">
                No existe una elección configurada actualmente.
            </p>

        @elseif ($eleccion->estado === 'activa')

            <p class="text-muted">
                Las elecciones ya finalizaron y no se permiten más votaciones
            </p>

            <p>
                Ve a la sección de resultados para ver los votos finales de las elecciones
            </p>

        @else

            <p class="text-muted">
                Elecciones cerradas. No se permiten más votaciones
            </p>

        @endif

        <a href="{{ route('inicio') }}" class="btn btn-primary">
            Regresar
        </a>

    </div>

</div>
@endsection