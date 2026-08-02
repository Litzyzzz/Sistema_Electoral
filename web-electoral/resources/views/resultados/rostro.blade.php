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
                    <a class="panel-nav-link" href="{{ route('resultados.dashboard') }}">
                        <i class="bi bi-speedometer2"></i>
                        Resumen
                    </a>
                    <a class="panel-nav-link active" href="{{ route('resultados.rostro') }}">
                        <i class="bi bi-person"></i>
                        Por rostro
                    </a>
                    <a class="panel-nav-link" href="{{ route('resultados.bandera') }}">
                        <i class="bi bi-flag"></i>
                        Por bandera
                    </a>
                </nav>

                <div class="panel-logout">
                    <form method="POST" action="{{ route('resultados.logout') }}">
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
                    <h1 class="panel-title">Resultados por rostro</h1>

                    @if($authVotante)
                        <div class="panel-user">
                            <i class="bi bi-person"></i>
                            <div>
                                <p class="panel-user-name">{{ $authVotante->nombres }} {{ $authVotante->apellidos }}</p>
                                <p class="panel-user-code">{{ $authVotante->codigo_estudiante }}</p>
                            </div>
                        </div>
                    @endif
                </header>

                <main class="panel-body">
                    <p class="card-subtitle">Ordenado de mayor a menor según la cantidad de votos</p>

                    <section class="results-grid">
                        @foreach($ranking as $index => $candidato)
                            <article class="result-card">
                                <div class="result-image-wrap">
                                    <img
                                        class="result-image"
                                        src="{{ asset('img/candidatos/' . $candidato->rostro_candidato) }}"
                                        alt="{{ $candidato->nombre_candidato }}"
                                    >
                                    <span class="result-rank rank-{{ min($index + 1, 3) }}">{{ $index + 1 }}</span>
                                </div>

                                <div class="result-info">
                                    <h2 class="result-name">{{ $candidato->nombre_candidato }}</h2>
                                    <p class="result-party">{{ $candidato->nombre_partido }}</p>
                                    <span class="result-votes">{{ number_format($candidato->total_votos) }} votos</span>
                                    <p class="result-percent">{{ number_format($candidato->porcentaje, 2) }}%</p>
                                </div>
                            </article>
                        @endforeach
                    </section>

                    <footer class="totals-footer">
                        <i class="bi bi-info-circle"></i>
                        Total de votos emitidos: {{ number_format($totalVotos) }}
                    </footer>
                </main>
            </div>
        </div>
    </section>
</div>
@endsection
