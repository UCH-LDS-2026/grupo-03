@extends('layouts.app')

@section('title', 'Tickets - Sistema Tickets')

@section('content')
    <section class="page-header">
        <div>
            <h1>Tickets</h1>
            <p class="muted">{{ auth()->user()->isStaff() ? 'Listado de problemas registrados.' : 'Tus tickets registrados.' }}</p>
        </div>
        <a class="button" href="{{ route('tickets.create') }}">Crear ticket</a>
    </section>

    @if ($canSearch)
        <form class="panel form filters" method="GET" action="{{ route('tickets.index') }}">
            <div class="field">
                <label for="q">Buscar</label>
                <input id="q" name="q" value="{{ request('q') }}" placeholder="Titulo o descripcion">
            </div>
            <div class="field">
                <label for="status">Estado</label>
                <select id="status" name="status">
                    <option value="">Todos</option>
                    <option value="pending" @selected(request('status') === 'pending')>Pendiente</option>
                    <option value="in_progress" @selected(request('status') === 'in_progress')>En proceso</option>
                    <option value="resolved" @selected(request('status') === 'resolved')>Resuelto</option>
                    <option value="closed" @selected(request('status') === 'closed')>Cerrado</option>
                </select>
            </div>
            <div class="field">
                <label for="priority">Prioridad</label>
                <select id="priority" name="priority">
                    <option value="">Todas</option>
                    <option value="low" @selected(request('priority') === 'low')>Baja</option>
                    <option value="medium" @selected(request('priority') === 'medium')>Media</option>
                    <option value="high" @selected(request('priority') === 'high')>Alta</option>
                    <option value="urgent" @selected(request('priority') === 'urgent')>Urgente</option>
                </select>
            </div>
            <button class="button" type="submit">Buscar</button>
        </form>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Titulo</th>
                <th>Area</th>
                <th>Categoria</th>
                <th>Solicitante</th>
                <th>Estado</th>
                <th>Prioridad</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($tickets as $ticket)
                <tr>
                    <td>#{{ $ticket->id }}</td>
                    <td><a href="{{ route('tickets.show', $ticket) }}">{{ $ticket->title }}</a></td>
                    <td>{{ $ticket->area->name }}</td>
                    <td>{{ $ticket->category->name }}</td>
                    <td>{{ $ticket->requester->name }}</td>
                    <td><span class="badge">{{ $ticket->status }}</span></td>
                    <td>{{ $ticket->priority }}</td>
                    <td>
                        @if (auth()->user()->isStaff() || (auth()->id() === $ticket->requester_id && $ticket->status === 'pending'))
                            <a href="{{ route('tickets.edit', $ticket) }}">Editar</a>
                        @else
                            <span class="muted">Solo lectura</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8">Todavia no hay tickets cargados.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div style="margin-top: 16px;">
        {{ $tickets->links('vendor.pagination.default') }}
    </div>
@endsection
