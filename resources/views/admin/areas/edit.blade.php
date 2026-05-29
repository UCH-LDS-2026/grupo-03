@extends('layouts.app')

@section('title', 'Editar area - Sistema Tickets')

@section('content')
    <section class="page-header">
        <div>
            <h1>Editar area</h1>
            <p class="muted">{{ $area->name }}</p>
        </div>
        <a href="{{ route('admin.areas.index') }}">Volver</a>
    </section>

    <form class="panel form" method="POST" action="{{ route('admin.areas.update', $area) }}">
        @csrf
        @method('PUT')

        <div class="field">
            <label for="name">Nombre</label>
            <input id="name" name="name" value="{{ old('name', $area->name) }}" required>
            @error('name') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div class="field">
            <label for="description">Descripcion</label>
            <textarea id="description" name="description">{{ old('description', $area->description) }}</textarea>
            @error('description') <span class="error">{{ $message }}</span> @enderror
        </div>

        <button class="button" type="submit">Guardar cambios</button>
    </form>
@endsection
