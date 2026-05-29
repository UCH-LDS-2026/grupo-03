@extends('layouts.app')

@section('title', 'Areas - Sistema Tickets')

@section('content')
    <section class="page-header">
        <div>
            <h1>Areas</h1>
            <p class="muted">Sectores disponibles en la creacion de tickets.</p>
        </div>
    </section>

    <form class="panel form" method="POST" action="{{ route('admin.areas.store') }}">
        @csrf
        <div class="grid">
            <div class="field">
                <label for="name">Nombre</label>
                <input id="name" name="name" value="{{ old('name') }}" required>
                @error('name') <span class="error">{{ $message }}</span> @enderror
            </div>

            <div class="field">
                <label for="description">Descripcion</label>
                <input id="description" name="description" value="{{ old('description') }}">
                @error('description') <span class="error">{{ $message }}</span> @enderror
            </div>
        </div>
        <button class="button" type="submit">Agregar area</button>
    </form>

    <table class="table spaced">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Descripcion</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($areas as $area)
                <tr>
                    <td>{{ $area->name }}</td>
                    <td>{{ $area->description }}</td>
                    <td><a href="{{ route('admin.areas.edit', $area) }}">Editar</a></td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div style="margin-top: 16px;">
        {{ $areas->links('vendor.pagination.default') }}
    </div>
@endsection
