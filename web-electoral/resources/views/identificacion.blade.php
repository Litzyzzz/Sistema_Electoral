@extends('layouts.app')

@section('contenido')
<style>
    .alert-danger {
        background: #dc3545 !important;
        color: white !important;
        border: 1px solid #a71d2a !important;
        border-left: 5px solid #a71d2a !important;
    }
    
    .alert-success {
        background: #28a745 !important;
        color: white !important;
        border: 1px solid #1e7e34 !important;
        border-left: 5px solid #1e7e34 !important;
    }
</style>
<div class="container">
    <h1>Para poder votar ingrese los datos necesarios</h1>
    
    <!--mensajes de errores-->
    @if(session('error') || session('success'))
        <div id="alert-message" class="alert alert-{{ session('success') ? 'success' : 'danger' }} alert-dismissible fade show" 
            role="alert" 
            style="position: fixed; top: 20px; right: 20px; z-index: 9999; min-width: 300px; box-shadow: 0 4px 12px rgba(0,0,0,0.15);">
            <strong>{{ session('success') ? '¡Éxito!' : 'Error:' }}</strong> 
            {{ session('success') ?? session('error')  }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert" style="margin-bottom: 20px;">
            <strong>Error:</strong>
            <ul style="margin: 8px 0 0 20px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form class="formulario" method="POST" action="{{ route('verificar.dui.post') }}">
        @csrf
        
        <div class="campo">
            <label for="codigo_estudiante">Código de Estudiante</label>
            <input type="text" 
                   id="codigo_estudiante" 
                   name="codigo_estudiante" 
                   placeholder="Ej: EST-001"
                   value="{{ old('codigo_estudiante') }}"
                   maxlength="20"
                   required>
            @error('codigo_estudiante')
                <div class="text-danger" style="color: #6b6cad">{{ $message }}</div>
            @enderror
        </div>
   
        <div class="campo">
            <label for="nombres">Nombres</label>
            <input type="text" 
                   id="nombres" 
                   name="nombres" 
                   placeholder="Juan Antonio"
                   value="{{ old('nombres') }}"
                   required>
            @error('nombres')
                <div class="text-danger" style="color: white">{{ $message }}</div>
            @enderror
        </div>

        <div class="campo">
            <label for="apellidos">Apellidos</label>
            <input type="text" 
                   id="apellidos" 
                   name="apellidos" 
                   placeholder="Pérez Molina"
                   value="{{ old('apellidos') }}"
                   required>
            @error('apellidos')
                <div class="text-danger" style="color: white">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn-ingresar">Ingresar</button>
    </form>
</div>
@endsection
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const alert = document.getElementById('alert-message');
        if (alert) {
            //tiempo del mensaje
            setTimeout(() => {
                alert.style.transition = 'opacity 0.5s';
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 500);
            }, 2500);
        }
    });
</script>