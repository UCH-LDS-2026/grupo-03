@extends('layouts.app')

@section('title', 'Editar categoría - Sistema Tickets')

@section('content')
    <section class="page-header">
        <div>
            <h1>Editar categoría</h1>
            <p class="muted">{{ $category->name }}</p>
        </div>
        <a href="{{ route('admin.categories.index') }}">Volver</a>
    </section>

    <form class="panel form" method="POST" action="{{ route('admin.categories.update', $category) }}">
        @csrf
        @method('PUT')

        <div class="field">
            <label for="name">Nombre</label>
            <input id="name" name="name" value="{{ old('name', $category->name) }}" required>
            @error('name') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div class="field">
            <label for="description">Descripción</label>
            <textarea id="description" name="description">{{ old('description', $category->description) }}</textarea>
            @error('description') <span class="error">{{ $message }}</span> @enderror
        </div>

        <button class="button" type="submit">Guardar cambios</button>
    </form>
@endsection
