@extends('layouts.app')

@section('title', 'Inicio - Sistema Tickets')

@section('content')
    <section class="page-header">
        <div>
            <h1>Panel inicial</h1>
            <p class="muted">Resumen básico para registrar, cuantificar y gestionar problemas.</p>
        </div>
        <a class="button" href="{{ route('tickets.create') }}">Crear ticket</a>
    </section>

    <section class="grid" aria-label="Métricas de tickets">
        <div class="panel stat">
            <span class="muted">Total</span>
            <strong>{{ $stats['total'] }}</strong>
        </div>
        <div class="panel stat">
            <span class="muted">Pendientes</span>
            <strong>{{ $stats['pending'] }}</strong>
        </div>
        <div class="panel stat">
            <span class="muted">En proceso</span>
            <strong>{{ $stats['in_progress'] }}</strong>
        </div>
        <div class="panel stat">
            <span class="muted">Resueltos</span>
            <strong>{{ $stats['resolved'] }}</strong>
        </div>
    </section>

    <section style="margin-top: 24px;">
        <div class="page-header">
            <div>
                <h2>Tickets recientes</h2>
                <p class="muted">Últimos registros cargados en el sistema.</p>
            </div>
            <a href="{{ route('tickets.index') }}">Ver todos</a>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th>Título</th>
                    <th>Área</th>
                    <th>Categoría</th>
                    <th>Estado</th>
                    <th>Prioridad</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($latestTickets as $ticket)
                    <tr>
                        <td><a href="{{ route('tickets.show', $ticket) }}">{{ $ticket->title }}</a></td>
                        <td>{{ $ticket->area->name }}</td>
                        <td>{{ $ticket->category->name }}</td>
                        <td><span class="badge">{{ \App\Support\TicketLabels::status($ticket->status) }}</span></td>
                        <td>{{ \App\Support\TicketLabels::priority($ticket->priority) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">Todavía no hay tickets cargados.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </section>
@endsection
