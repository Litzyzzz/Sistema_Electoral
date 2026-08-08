@extends('layouts.resultados')
@section('contenido')
<div class="resultados-page">
    <section class="panel-shell">
        <div class="panel-main">
            <aside class="panel-sidebar">
                <div class="panel-brand">
                    <h2 class="panel-brand-title">TSE</h2>
                    <span class="panel-brand-subtitle">ELECCIONES 2026</span>
                </div>

                <nav class="panel-nav">
                    <a class="panel-nav-link active" href="{{ route('admin.control') }}">
                        <i class="bi bi-speedometer2"></i>
                        Control
                    </a>
                </nav>
                <div class="panel-logout">
            <form
                method="POST"
                action="{{ route('admin.logout') }}">
                @csrf
                <button type="submit">
                    <i class="bi bi-box-arrow-left"></i>
                    Cerrar sesión
                </button>
            </form>

        </div>
            </aside>
    <div class="panel-content">
        <header class="panel-topbar">
            <h1 class="panel-title">
                Dashboard de Control
            </h1>
            @if($authVotante)
                <div class="panel-user">
                    <i class="bi bi-person"></i>
                    <div>
                        <p class="panel-user-name">
                            {{ $authVotante->nombres }}
                            {{ $authVotante->apellidos }}
                        </p>
                        <p class="panel-user-code">
                            {{ $authVotante->codigo_estudiante }}
                        </p>
                    </div>
                </div>
            @endif
        </header>
            <main class="panel-body">
                    @if($eleccion && $eleccion->estado === 'activa')
                <section
                    class="kpi-grid"
                    style="
                        display: flex;
                        justify-content: center;" >
                    <article class="kpi-card">
                        <span class="kpi-icon green">
                            <i class="bi bi-check-circle-fill"></i>
                        </span>
                        <div>
                            <p class="kpi-label">
                                Estado de las elecciones
                            </p>
                            <p class="kpi-value">
                                Activas
                            </p>
                        </div>
                    </article>
                </section>
                <section
                    class="panel-card"
                    style="
                        max-width: 700px;
                        margin: 25px auto;
                        text-align: center;" >
                    <h2 class="card-title">
                        Elecciones activas
                    </h2>
                    <p class="card-subtitle">
                        Las elecciones están actualmente activas y los
                        votantes pueden emitir nuevos votos.
                    </p>
                    <div style="margin-top: 25px;">
                        <form
                            action="{{ route('admin.elecciones.cerrar', $eleccion) }}"
                            method="POST"
                            onsubmit="return confirm('¿Está seguro de cerrar las elecciones? Esta acción no se puede deshacer');" >
                            @csrf
                            <button
                                type="submit"
                                class="btn-primary btn-lg">
                            
                                <i class="bi bi-lock-fill"></i>
                                Cerrar elecciones
                            </button>
                        </form>
                    </div>
                </section>
            @elseif($eleccion && $eleccion->estado === 'cerrada')
                <section
                    class="kpi-grid"
                    style="
                        display: flex;
                        justify-content: center;">
                    <article class="kpi-card">
                        <span class="kpi-icon orange">
                            <i class="bi bi-lock-fill"></i>
                        </span>
                        <div>
                            <p class="kpi-label">
                                Estado de las elecciones
                            </p>
                            <p class="kpi-value">
                                Cerradas
                            </p>
                        </div>
                    </article>
                </section>
                <section
                    class="panel-card"
                    style="
                        max-width: 700px;
                        margin: 25px auto;
                        text-align: center;">
                    <h2 class="card-title">
                        <i class="bi bi-lock-fill"></i>
                        Elecciones cerradas
                    </h2>
                    <p class="card-subtitle">
                        Las elecciones han finalizado y los votantes
                        ya no pueden emitir nuevos votos.
                    </p>
                    <div style="margin-top: 25px;">
                        <a
                            href="{{ route('resultados.dashboard') }}"
                            class="btn btn-primary btn-lg">
                            <i class="bi bi-bar-chart-fill"></i>
                            Ver resultados
                        </a>
                    </div>
                </section>
            @else
                <section
                    class="panel-card"
                    style="
                        max-width: 700px;
                        margin: 25px auto;
                        text-align: center;">
                    
                    <h2 class="card-title">
                        <i class="bi bi-exclamation-triangle-fill"></i>
                        Elección no configurada
                    </h2>

                    <p class="card-subtitle">
                        No hay una elección configurada actualmente.
                    </p>

                </section>

            @endif
                </main>
            </div>
        </div>
    </section>
</div>