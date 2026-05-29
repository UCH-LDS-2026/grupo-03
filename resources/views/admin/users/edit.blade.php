@extends('layouts.app')

@section('title', 'Editar usuario - Sistema Tickets')

@section('content')
    <section class="page-header">
        <div>
            <h1>Editar usuario</h1>
            <p class="muted">{{ $user->email }}</p>
        </div>
        <a href="{{ route('admin.users.index') }}">Volver</a>
    </section>

    <form class="panel form" method="POST" action="{{ route('admin.users.update', $user) }}">
        @csrf
        @method('PUT')

        <div class="grid">
            <div class="field">
                <label for="name">Nombre</label>
                <input id="name" name="name" value="{{ old('name', $user->name) }}" required>
                @error('name') <span class="error">{{ $message }}</span> @enderror
            </div>

            <div class="field">
                <label for="email">Email</label>
                <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required>
                @error('email') <span class="error">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="grid">
            <div class="field">
                <label for="password">Nuevo password</label>
                <input id="password" name="password" type="password">
                @error('password') <span class="error">{{ $message }}</span> @enderror
            </div>

            <div class="field">
                <label for="role">Rol</label>
                <select id="role" name="role" required>
                    <option value="user" @selected(old('role', $user->role) === 'user')>Usuario comun</option>
                    <option value="technician" @selected(old('role', $user->role) === 'technician')>Tecnico</option>
                    <option value="admin" @selected(old('role', $user->role) === 'admin')>Administrador</option>
                </select>
                @error('role') <span class="error">{{ $message }}</span> @enderror
            </div>
        </div>

        <button class="button" type="submit">Guardar cambios</button>
    </form>
@endsection
