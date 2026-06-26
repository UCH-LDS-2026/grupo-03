@extends('layouts.app')

@section('title', 'Editar ticket - Sistema Tickets')

@section('content')
    <section class="page-header">
        <div>
            <h1>Editar ticket</h1>
            <p class="muted">Ticket #{{ $ticket->id }}</p>
        </div>
        <a href="{{ route('tickets.show', $ticket) }}">Volver al detalle</a>
    </section>

    <form class="panel form" method="POST" action="{{ route('tickets.update', $ticket) }}">
        @csrf
        @method('PUT')

        <div class="field">
            <label for="title">Título</label>
            <input id="title" name="title" value="{{ old('title', $ticket->title) }}" required>
            @error('title') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div class="field">
            <label for="description">Descripción</label>
            <textarea id="description" name="description" required>{{ old('description', $ticket->description) }}</textarea>
            @error('description') <span class="error">{{ $message }}</span> @enderror
        </div>

        @if ($canEditAll)
            <div class="grid">
                <div class="field">
                    <label for="area_id">Área</label>
                    <select id="area_id" name="area_id" required>
                        @foreach ($areas as $area)
                            <option value="{{ $area->id }}" @selected(old('area_id', $ticket->area_id) == $area->id)>{{ $area->name }}</option>
                        @endforeach
                    </select>
                    @error('area_id') <span class="error">{{ $message }}</span> @enderror
                </div>

                <div class="field">
                    <label for="ticket_category_id">Categoría</label>
                    <select id="ticket_category_id" name="ticket_category_id" required>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" @selected(old('ticket_category_id', $ticket->ticket_category_id) == $category->id)>{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('ticket_category_id') <span class="error">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="grid">
                <div class="field">
                    <label for="requester_id">Solicitante</label>
                    <select id="requester_id" name="requester_id" required>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}" @selected(old('requester_id', $ticket->requester_id) == $user->id)>{{ $user->name }}</option>
                        @endforeach
                    </select>
                    @error('requester_id') <span class="error">{{ $message }}</span> @enderror
                </div>

                <div class="field">
                    <label for="assigned_user_id">Asignado</label>
                    <select id="assigned_user_id" name="assigned_user_id">
                        <option value="">Sin asignar</option>
                        @foreach ($users as $user)
                            @if ($user->isStaff())
                                <option value="{{ $user->id }}" @selected(old('assigned_user_id', $ticket->assigned_user_id) == $user->id)>{{ $user->name }}</option>
                            @endif
                        @endforeach
                    </select>
                    @error('assigned_user_id') <span class="error">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="grid">
                <div class="field">
                    <label for="status">Estado</label>
                    <select id="status" name="status" required>
                        <option value="pending" @selected(old('status', $ticket->status) === 'pending')>Pendiente</option>
                        <option value="in_progress" @selected(old('status', $ticket->status) === 'in_progress')>En proceso</option>
                        <option value="resolved" @selected(old('status', $ticket->status) === 'resolved')>Resuelto</option>
                        <option value="closed" @selected(old('status', $ticket->status) === 'closed')>Cerrado</option>
                    </select>
                    @error('status') <span class="error">{{ $message }}</span> @enderror
                </div>

                <div class="field">
                    <label for="priority">Prioridad</label>
                    <select id="priority" name="priority" required>
                        <option value="low" @selected(old('priority', $ticket->priority) === 'low')>Baja</option>
                        <option value="medium" @selected(old('priority', $ticket->priority) === 'medium')>Media</option>
                        <option value="high" @selected(old('priority', $ticket->priority) === 'high')>Alta</option>
                        <option value="urgent" @selected(old('priority', $ticket->priority) === 'urgent')>Urgente</option>
                    </select>
                    @error('priority') <span class="error">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="field">
                <label for="comment_body">Nuevo comentario</label>
                <textarea id="comment_body" name="comment_body">{{ old('comment_body') }}</textarea>
                @error('comment_body') <span class="error">{{ $message }}</span> @enderror
            </div>

            <label class="check">
                <input type="checkbox" name="comment_is_internal" value="1" @checked(old('comment_is_internal'))>
                Comentario interno
            </label>

            <div class="grid">
                <div class="field">
                    <label for="solution_summary">Resumen de solución</label>
                    <input id="solution_summary" name="solution_summary" value="{{ old('solution_summary', $ticket->solution?->summary) }}">
                    @error('solution_summary') <span class="error">{{ $message }}</span> @enderror
                </div>

                <div class="field">
                    <label for="solution_details">Detalle de solución</label>
                    <textarea id="solution_details" name="solution_details">{{ old('solution_details', $ticket->solution?->details) }}</textarea>
                    @error('solution_details') <span class="error">{{ $message }}</span> @enderror
                </div>
            </div>
        @endif

        <button class="button" type="submit">Guardar cambios</button>
    </form>
@endsection
