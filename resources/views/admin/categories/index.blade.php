@extends('layouts.app')

@section('title', 'Categorías - Sistema Tickets')

@section('content')
    <section class="page-header">
        <div>
            <h1>Categorías</h1>
            <p class="muted">Tipos de problema disponibles en la creación de tickets.</p>
        </div>
    </section>

    <form class="panel form" method="POST" action="{{ route('admin.categories.store') }}">
        @csrf
        <div class="grid">
            <div class="field">
                <label for="name">Nombre</label>
                <input id="name" name="name" value="{{ old('name') }}" required>
                @error('name') <span class="error">{{ $message }}</span> @enderror
            </div>

            <div class="field">
                <label for="description">Descripción</label>
                <input id="description" name="description" value="{{ old('description') }}">
                @error('description') <span class="error">{{ $message }}</span> @enderror
            </div>
        </div>
        <button class="button" type="submit">Agregar categoría</button>
    </form>

    <table class="table spaced">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($categories as $category)
                <tr>
                    <td>{{ $category->name }}</td>
                    <td>{{ $category->description }}</td>
                    <td><a href="{{ route('admin.categories.edit', $category) }}">Editar</a></td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div style="margin-top: 16px;">
        {{ $categories->links('vendor.pagination.default') }}
    </div>
@endsection
