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
                <p><span class="badge">{{ $ticket->status }}</span></p>
            </div>
            <div>
                <strong>Prioridad</strong>
                <p>{{ $ticket->priority }}</p>
            </div>
            <div>
                <strong>Area</strong>
                <p>{{ $ticket->area->name }}</p>
            </div>
            <div>
                <strong>Categoria</strong>
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
                <p class="muted">Todavia no hay comentarios.</p>
            @endforelse
        </div>
    </section>

    <section style="margin-top: 24px;">
        <h2>Solucion</h2>
        @if ($ticket->solution)
            <article class="panel">
                <strong>{{ $ticket->solution->summary }}</strong>
                <p>{{ $ticket->solution->details }}</p>
            </article>
        @else
            <p class="muted">Este ticket todavia no tiene solucion documentada.</p>
        @endif
    </section>
@endsection
