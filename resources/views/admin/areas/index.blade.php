@extends('layouts.app')

@section('title', 'Áreas - Sistema Tickets')

@section('content')
    <section class="page-header">
        <div>
            <h1>Áreas</h1>
            <p class="muted">Sectores disponibles en la creación de tickets.</p>
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
                <label for="description">Descripción</label>
                <input id="description" name="description" value="{{ old('description') }}">
                @error('description') <span class="error">{{ $message }}</span> @enderror
            </div>
        </div>
        <button class="button" type="submit">Agregar área</button>
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
            @foreach ($areas as $area)
                <tr>
                    <td>{{ $area->name }}</td>
                    <td>{{ $area->description }}</td>
                    <td>
                        <div class="actions">
                            <a href="{{ route('admin.areas.edit', $area) }}">Editar</a>
                            <form method="POST" action="{{ route('admin.areas.destroy', $area) }}" onsubmit="return confirm('¿Eliminar esta área?');">
                                @csrf
                                @method('DELETE')
                                <button class="link-button danger-link" type="submit">Eliminar</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div style="margin-top: 16px;">
        {{ $areas->links('vendor.pagination.default') }}
    </div>
@endsection
