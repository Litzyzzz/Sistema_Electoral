@extends('layouts.app')

@section('contenido')
<div class ="container">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <h1>Confirma tu voto</h1>
    <h3>Revisa tu voto antes de emitirlo</h3>

</div>
<div class="card mb-3"  style="max-width: 900px; margin: 0 auto; background-color: #0C0076; color: white; overflow: hidden;" >
    <div class="row g-0">
<div class="col-md-4">
    @if(isset($vista) && $vista === 'bandera')
        <!-- BANDERA -->
        <img src="{{ asset('img/partidos/' . $candidato->bandera) }}" 
             class="img-fluid rounded-start" 
             style="width: 100%; height: 100%; object-fit: cover; min-height: 250px;" 
             alt="Bandera {{ $candidato->nombre_partido }}">
    @else
        <!-- ROSTRO -->
        <img src="{{ asset('img/candidatos/' . $candidato->rostro_candidato) }}" 
             class="img-fluid rounded-start" 
             style="width: 100%; height: 100%; object-fit: cover; min-height: 250px;" 
             alt="{{ $candidato->nombre_candidato }}">
    @endif
</div>
        <div class="col-md-8">
            <div class="card-body">
                <h5 class="card-title">{{ $candidato->nombre_candidato }}</h5>
                <p class="card-text">{{ $candidato->nombre_partido }}</p>
                @if($candidato->descripcion)
                    <p class="card-text">{{ $candidato->descripcion }}</p>
                @endif
            </div>
        </div>
    </div>
    
</div>
<div style="background-color: #f8f9fa; padding: 12px 20px; border-radius: 5px; border-left: 4px; max-width: 700px; margin: 20px auto 0;">
    <p style="font-size: 0.85rem; color: #060606; margin: 0; text-align: center;">
        <i class="bi bi-exclamation-circle" style="color: #0C0076; margin-right: 5px;"></i>
        Al hacer clic en <strong>Emitir Voto Definitivamente</strong>, su sufragio será registrado de forma definitiva.
    </p>
</div>
<div style="display: flex; justify-content: center; gap: 15px; max-width: 700px; margin: 20px auto 0; flex-wrap: wrap;">
    <a href="{{ route('votacion') }}" class="btn btn-dark" style="border-radius: 25px; padding: 15px 40px;">
        <i class="bi bi-arrow-left"></i> Cambiar selección
    </a>
    
        <form action="{{ route('guardar.voto') }}" method="POST">
            @csrf
            <input type="hidden" name="id_partido" value="{{ $candidato->id_partido }}">
            <input type="hidden" name="tipo_vista" value="{{ $vista ?? 'rostro' }}">
            
            <button type="submit" class="btn btn-success btn-lg" 
                    style="background: #0C0076; color: white; font-weight: 700; border: none; border-radius: 25px; padding: 15px 40px;"
                    onclick="return confirm('¿Estás completamente seguro de tu voto por {{ $candidato->nombre_candidato }}?')">
                <i class="bi bi-check-circle-fill"></i> Emitir Voto Definitivamente
            </button>
        </form>
    </div>
</div>

@endsection