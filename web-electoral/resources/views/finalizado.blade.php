@extends('layouts.app')

@section('contenido')
<div class="container">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <div class="row justify-content-center">
        <div class="col-md-8">
                <div class="card-body text-center py-5">
                    <div style="font-size: 5rem; color: #28a745; margin-bottom: 20px;">
                        <i class="bi bi-check2-circle" style="font-size: 10rem; color:#0C0076; margin-bottom:20px; display:block;"></i>
                    </div>
                    <h2 style="color: #000000; font-weight: 700; margin-bottom: 15px;">
                        ¡Voto Registrado!
                    </h2>
                    <p style="font-size: 1rem; color: #000000; max-width: 500px; margin: 0 auto 30px;">
                        Su voto ha sido emitido y registrado de forma segura en el sistema electoral.
                    </p>
                        <a href="{{ route('inicio') }}" class="btn-primary">
                            terminar
                        </a>
                </div>
           
        </div>
    </div>
</div>
@endsection