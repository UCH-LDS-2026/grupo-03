@extends('layouts.app')

@section('title', 'Inicio - Sistema Tickets')

@section('content')
    <section class="page-header dashboard-header">
        <div>
            <h1>Dashboard</h1>
            <p class="muted">{{ $isStaff ? 'Resumen general del sistema.' : 'Resumen de tus tickets.' }}</p>
        </div>
    </section>

    <section class="metric-grid" aria-label="Métricas de tickets">
        <article class="metric-card metric-card-primary">
            <span>Total</span>
            <strong>{{ $stats['total'] }}</strong>
            <small>{{ $isStaff ? 'Tickets registrados' : 'Tickets creados por vos' }}</small>
        </article>
        <article class="metric-card metric-card-warning">
            <span>Pendientes</span>
            <strong>{{ $stats['pending'] }}</strong>
            <small>Esperando atención</small>
        </article>
        <article class="metric-card metric-card-info">
            <span>En proceso</span>
            <strong>{{ $stats['in_progress'] }}</strong>
            <small>Con seguimiento activo</small>
        </article>
        <article class="metric-card metric-card-success">
            <span>Resueltos</span>
            <strong>{{ $stats['resolved'] + $stats['closed'] }}</strong>
            <small>Resueltos o cerrados</small>
        </article>
    </section>

    <section class="dashboard-grid">
        <article class="panel chart-panel">
            <div>
                <h2>Distribución por estado</h2>
                <p class="muted">{{ $statusChart['total'] }} tickets contemplados</p>
            </div>

            <div class="pie-wrap">
                <div class="pie-chart" style="background: conic-gradient({{ $statusChart['gradient'] }});">
                    <span>{{ $statusChart['total'] }}</span>
                </div>

                <div class="legend">
                    @foreach ($statusChart['items'] as $item)
                        <div class="legend-row">
                            <span class="legend-color" style="background: {{ $item['color'] }}"></span>
                            <span>{{ $item['label'] }}</span>
                            <strong>{{ $item['value'] }}</strong>
                        </div>
                    @endforeach
                </div>
            </div>
        </article>

        @if ($isStaff)
            <article class="panel dashboard-summary">
                <h2>Seguimiento</h2>
                <div class="summary-list">
                    <div>
                        <span class="muted">Sin asignar</span>
                        <strong>{{ $solutionStats['unassigned'] }}</strong>
                    </div>
                    <div>
                        <span class="muted">Con solución documentada</span>
                        <strong>{{ $solutionStats['documented'] }}</strong>
                    </div>
                    <div>
                        <span class="muted">Resueltos sin documentación</span>
                        <strong>{{ $solutionStats['pending'] }}</strong>
                    </div>
                </div>
            </article>
        @else
            <article class="panel dashboard-summary">
                <h2>Tu avance</h2>
                <div class="summary-list">
                    <div>
                        <span class="muted">Abiertos</span>
                        <strong>{{ $stats['pending'] + $stats['in_progress'] }}</strong>
                    </div>
                    <div>
                        <span class="muted">Finalizados</span>
                        <strong>{{ $stats['resolved'] + $stats['closed'] }}</strong>
                    </div>
                    <div>
                        <span class="muted">Total personal</span>
                        <strong>{{ $stats['total'] }}</strong>
                    </div>
                </div>
            </article>
        @endif
    </section>

    @if ($isStaff)
        <section class="dashboard-grid dashboard-grid-wide">
            <article class="panel ranking-panel">
                <h2>Áreas con más problemas</h2>
                @include('partials.dashboard-ranking', ['items' => $areaStats])
            </article>

            <article class="panel ranking-panel">
                <h2>Categorías más frecuentes</h2>
                @include('partials.dashboard-ranking', ['items' => $categoryStats])
            </article>

            <article class="panel ranking-panel">
                <h2>Usuarios que más solicitan</h2>
                @include('partials.dashboard-ranking', ['items' => $requesterStats])
            </article>

            <article class="panel ranking-panel">
                <h2>Usuarios con más asignaciones</h2>
                @include('partials.dashboard-ranking', ['items' => $assignedStats])
            </article>
        </section>
    @endif
@endsection
