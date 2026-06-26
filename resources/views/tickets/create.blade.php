@extends('layouts.app')

@section('title', 'Crear ticket - Sistema Tickets')

@section('content')
    <section class="page-header">
        <div>
            <h1>Crear ticket</h1>
            <p class="muted">Formulario mínimo para registrar un problema.</p>
        </div>
    </section>

    <form class="panel form" method="POST" action="{{ route('tickets.store') }}">
        @csrf

        <div class="field">
            <label for="title">Título</label>
            <input id="title" name="title" value="{{ old('title') }}" required>
            @error('title') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div class="field">
            <label for="description">Descripción</label>
            <textarea id="description" name="description" required>{{ old('description') }}</textarea>
            @error('description') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div class="grid">
            <div class="field">
                <label for="area_id">Área</label>
                <select id="area_id" name="area_id" required>
                    @foreach ($areas as $area)
                        <option value="{{ $area->id }}" @selected(old('area_id') == $area->id)>{{ $area->name }}</option>
                    @endforeach
                </select>
                @error('area_id') <span class="error">{{ $message }}</span> @enderror
            </div>

            <div class="field">
                <label for="ticket_category_id">Categoría</label>
                <select id="ticket_category_id" name="ticket_category_id" required>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @selected(old('ticket_category_id') == $category->id)>{{ $category->name }}</option>
                    @endforeach
                </select>
                @error('ticket_category_id') <span class="error">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="grid">
            @if ($canChooseRequester)
                <div class="field">
                    <label for="requester_id">Solicitante</label>
                    <select id="requester_id" name="requester_id" required>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}" @selected(old('requester_id') == $user->id)>{{ $user->name }}</option>
                        @endforeach
                    </select>
                    @error('requester_id') <span class="error">{{ $message }}</span> @enderror
                </div>
            @endif

            <div class="field">
                <label for="priority">Prioridad</label>
                <select id="priority" name="priority" required>
                    <option value="low" @selected(old('priority') === 'low')>Baja</option>
                    <option value="medium" @selected(old('priority', 'medium') === 'medium')>Media</option>
                    <option value="high" @selected(old('priority') === 'high')>Alta</option>
                    <option value="urgent" @selected(old('priority') === 'urgent')>Urgente</option>
                </select>
                @error('priority') <span class="error">{{ $message }}</span> @enderror
            </div>
        </div>

        <div>
            <button class="button" type="submit">Guardar ticket</button>
        </div>
    </form>
@endsection
