@extends('layouts.app')

@section('title', 'Crear usuario - Sistema Tickets')

@section('content')
    <section class="page-header">
        <div>
            <h1>Crear usuario</h1>
            <p class="muted">Alta de usuarios para el sistema.</p>
        </div>
        <a href="{{ route('admin.users.index') }}">Volver</a>
    </section>

    <form class="panel form" method="POST" action="{{ route('admin.users.store') }}">
        @csrf

        <div class="grid">
            <div class="field">
                <label for="name">Nombre</label>
                <input id="name" name="name" value="{{ old('name') }}" required>
                @error('name') <span class="error">{{ $message }}</span> @enderror
            </div>

            <div class="field">
                <label for="email">Correo electrónico</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" required>
                @error('email') <span class="error">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="grid">
            <div class="field">
                <label for="password">Contraseña</label>
                <input id="password" name="password" type="password" required>
                @error('password') <span class="error">{{ $message }}</span> @enderror
            </div>

            <div class="field">
                <label for="role">Rol</label>
                <select id="role" name="role" required>
                    <option value="user" @selected(old('role') === 'user')>Usuario común</option>
                    <option value="technician" @selected(old('role') === 'technician')>Técnico</option>
                    <option value="admin" @selected(old('role') === 'admin')>Administrador</option>
                </select>
                @error('role') <span class="error">{{ $message }}</span> @enderror
            </div>
        </div>

        <button class="button" type="submit">Crear usuario</button>
    </form>
@endsection
