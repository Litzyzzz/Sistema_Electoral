@extends('layouts.resultados')

@section('contenido')
<div class="auth-screen">
    <div class="auth-modal">
        <a href="{{ route('inicio') }}" class="auth-close" aria-label="Cerrar">&times;</a>

        <div class="auth-head">
            <div class="auth-icon">
                <i class="bi bi-lock-fill"></i>
            </div>
            <h1 class="auth-title">Acceso a Resultados</h1>
            <p class="auth-subtitle">Ingrese sus credenciales para ver las estadísticas de la elección.</p>
        </div>

        <form method="POST" action="{{ route('resultados.authenticate') }}">
            @csrf

            <div class="auth-field">
                <label for="codigo_estudiante">Código de estudiante</label>
                <input
                    id="codigo_estudiante"
                    name="codigo_estudiante"
                    type="text"
                    value="{{ old('codigo_estudiante') }}"
                    maxlength="20"
                    placeholder="Ej. SMSS000000"
                    required
                >
                @error('codigo_estudiante')
                    <div class="input-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="auth-field">
                <label for="nombres">Nombre</label>
                <input
                    id="nombres"
                    name="nombres"
                    type="text"
                    value="{{ old('nombres') }}"
                    maxlength="50"
                    placeholder="Ej. Ramon Antonio"
                    required
                >
                @error('nombres')
                    <div class="input-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="auth-field">
                <label for="apellidos">Apellido</label>
                <input
                    id="apellidos"
                    name="apellidos"
                    type="text"
                    value="{{ old('apellidos') }}"
                    maxlength="50"
                    placeholder="Ej. Bukele Maduro"
                    required
                >
                @error('apellidos')
                    <div class="input-error">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="auth-submit">
                <i class="bi bi-arrow-right"></i>
                Ingresar
            </button>
        </form>

        @if(session('error'))
            <div class="alert-auth">{{ session('error') }}</div>
        @endif
    </div>
</div>
@endsection
