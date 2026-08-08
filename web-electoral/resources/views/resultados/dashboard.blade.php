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
                    <a class="panel-nav-link active" href="{{ route('resultados.dashboard') }}">
                        <i class="bi bi-speedometer2"></i>
                        Resumen
                    </a>
                    <a class="panel-nav-link" href="{{ route('resultados.rostro') }}">
                        <i class="bi bi-person"></i>
                        Por rostro
                    </a>
                    <a class="panel-nav-link" href="{{ route('resultados.bandera') }}">
                        <i class="bi bi-flag"></i>
                        Por bandera
                    </a>
                </nav>
                <div class="panel-logout">
                    <a href="{{ route('inicio') }}"
                    class="btn btn-light btn-sm w-100 d-flex align-items-center justify-content-center gap-2 text-primary fw-semibold shadow-sm">
                        <i class="bi bi-house-fill"></i>
                        <span>Regresar</span>
                    </a>
                </div>
            </aside>


            <div class="panel-content">
                <header class="panel-topbar">
                    <h1 class="panel-title">Dashboard de Resultados</h1>
                </header>

                <main class="panel-body">
                    <section class="kpi-grid">
                        <article class="kpi-card">
                            <span class="kpi-icon blue"><i class="bi bi-people-fill"></i></span>
                            <div>
                                <p class="kpi-label">Votantes registrados</p>
                                <p class="kpi-value">{{ number_format($totalVotantes) }}</p>
                            </div>
                        </article>

                        <article class="kpi-card">
                            <span class="kpi-icon green"><i class="bi bi-check-circle-fill"></i></span>
                            <div>
                                <p class="kpi-label">Votos emitidos</p>
                                <p class="kpi-value">{{ number_format($totalVotos) }}</p>
                            </div>
                        </article>

                        <article class="kpi-card">
                            <span class="kpi-icon orange"><i class="bi bi-bar-chart-fill"></i></span>
                            <div>
                                <p class="kpi-label">Participación</p>
                                <p class="kpi-value">{{ number_format($participacion, 2) }}%</p>
                            </div>
                        </article>

                        <article class="kpi-card">
                            <span class="kpi-icon purple"><i class="bi bi-person-badge-fill"></i></span>
                            <div>
                                <p class="kpi-label">Candidatos</p>
                                <p class="kpi-value">{{ number_format($totalCandidatos) }}</p>
                            </div>
                        </article>
                    </section>

                    <section class="chart-grid">
                        <article class="panel-card">
                            <h2 class="card-title">Votos por candidato</h2>
                            <p class="card-subtitle">Ordenado de mayor a menor</p>
                            <div class="chart-wrap">
                                <canvas id="graficaBarras"></canvas>
                            </div>
                        </article>

                        <article class="panel-card">
                            <h2 class="card-title">Distribución de votos (%)</h2>
                            <p class="card-subtitle">Participación por candidato</p>
                            <div class="chart-wrap">
                                <canvas id="graficaCircular"></canvas>
                            </div>
                        </article>
                    </section>

                    @if($ganador)
                        <section class="winner-row">
                            <div>
                                <p class="card-subtitle">Candidato con más votos</p>
                                <h3 class="winner-name">{{ $ganador->nombre_candidato }}</h3>
                            </div>
                            <strong class="winner-votes">{{ number_format($ganador->total_votos) }} votos</strong>
                            <span class="winner-percent">{{ number_format($ganador->porcentaje, 2) }}%</span>
                        </section>
                    @endif
                </main>
            </div>
        </div>
    </section>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const chartLabels = @json($chartLabels);
    const chartData = @json($chartData);
    const chartPercentages = @json($chartPercentages);
    const colors = ['#2f63c1', '#38a159', '#e2493c', '#7a47d1', '#0ba6a6', '#f59f00'];

    const ctxBar = document.getElementById('graficaBarras');
    const ctxPie = document.getElementById('graficaCircular');

    new Chart(ctxBar, {
        type: 'bar',
        data: {
            labels: chartLabels,
            datasets: [{
                label: 'Votos obtenidos',
                data: chartData,
                borderRadius: 10,
                backgroundColor: chartLabels.map((_, i) => colors[i % colors.length]),
                borderColor: chartLabels.map((_, i) => colors[i % colors.length]),
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const index = context.dataIndex;
                            const votos = context.raw;
                            const porcentaje = chartPercentages[index] ?? 0;
                            return votos + ' votos (' + porcentaje + '%)';
                        }
                    }
                }
            }
        }
    });

    new Chart(ctxPie, {
        type: 'doughnut',
        data: {
            labels: chartLabels,
            datasets: [{
                data: chartData,
                backgroundColor: chartLabels.map((_, i) => colors[i % colors.length]),
                borderColor: '#ffffff',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '58%',
            plugins: {
                legend: {
                    position: 'right',
                    labels: {
                        boxWidth: 12,
                        boxHeight: 12
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const index = context.dataIndex;
                            const votos = context.raw;
                            const porcentaje = chartPercentages[index] ?? 0;
                            return votos + ' votos (' + porcentaje + '%)';
                        }
                    }
                }
            }
        }
    });
</script>
@endsection
