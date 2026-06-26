@extends('layouts.app')

@section('title', $ticket->title.' - Sistema Tickets')

@section('content')
    <section class="page-header">
        <div>
            <h1>{{ $ticket->title }}</h1>
            <p class="muted">Ticket #{{ $ticket->id }}</p>
        </div>
        <div class="actions">
            @if (auth()->user()->isStaff() || (auth()->id() === $ticket->requester_id && $ticket->status === 'pending'))
                <a class="button" href="{{ route('tickets.edit', $ticket) }}">Editar</a>
            @endif
            <a href="{{ route('tickets.index') }}">Volver al listado</a>
        </div>
    </section>

    <section class="panel">
        <p>{{ $ticket->description }}</p>

        <div class="grid">
            <div>
                <strong>Estado</strong>
                <p><span class="badge status-{{ $ticket->status }}">{{ \App\Support\TicketLabels::status($ticket->status) }}</span></p>
            </div>
            <div>
                <strong>Prioridad</strong>
                <p><span class="badge priority-{{ $ticket->priority }}">{{ \App\Support\TicketLabels::priority($ticket->priority) }}</span></p>
            </div>
            <div>
                <strong>Área</strong>
                <p>{{ $ticket->area->name }}</p>
            </div>
            <div>
                <strong>Categoría</strong>
                <p>{{ $ticket->category->name }}</p>
            </div>
            <div>
                <strong>Solicitante</strong>
                <p>{{ $ticket->requester->name }}</p>
            </div>
            <div>
                <strong>Asignado</strong>
                <p>{{ $ticket->assignedUser?->name ?? 'Sin asignar' }}</p>
            </div>
        </div>
    </section>

    <section style="margin-top: 24px;">
        <h2>Comentarios</h2>
        <div class="grid">
            @forelse ($ticket->comments as $comment)
                <article class="panel">
                    <strong>{{ $comment->user->name }}</strong>
                    <p>{{ $comment->body }}</p>
                    @if ($comment->is_internal)
                        <span class="badge">Interno</span>
                    @endif
                </article>
            @empty
                <p class="muted">Todavía no hay comentarios.</p>
            @endforelse
        </div>
    </section>

    <section style="margin-top: 24px;">
        <h2>Solución</h2>
        @if ($ticket->solution)
            @if (auth()->user()->isStaff())
                <article class="panel">
                    <strong>{{ $ticket->solution->summary }}</strong>
                    <p>{{ $ticket->solution->details }}</p>
                </article>
            @else
                <p class="muted">Este ticket ya tiene una solución registrada.</p>
            @endif
        @else
            <p class="muted">Este ticket todavía no tiene solución documentada.</p>
        @endif
    </section>
@endsection
