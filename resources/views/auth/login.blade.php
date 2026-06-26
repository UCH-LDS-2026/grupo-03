@extends('layouts.app')

@section('title', 'Ingresar - Sistema Tickets')

@section('content')
    <form class="panel form login-card" method="POST" action="{{ route('login.store') }}">
        @csrf

        <div class="login-header">
            <span>Sistema Tickets</span>
            <div>
                <h1>Ingresar</h1>
                <p class="muted">Acceso al sistema según el rol asignado.</p>
            </div>
        </div>

        <div class="field">
            <label for="email">Correo electrónico</label>
            <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus>
            @error('email') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div class="field">
            <label for="password">Contraseña</label>
            <div class="password-control">
                <input id="password" name="password" type="password" required>
                <button class="link-button password-toggle" type="button" data-password-toggle="password">Ver</button>
            </div>
            @error('password') <span class="error">{{ $message }}</span> @enderror
        </div>

        <button class="button" type="submit">Ingresar</button>

        <p class="login-footer">Sistema Tickets 2026</p>
    </form>
@endsection
