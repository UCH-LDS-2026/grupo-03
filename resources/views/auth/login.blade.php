@extends('layouts.app')

@section('title', 'Ingresar - Sistema Tickets')

@section('content')
    <section class="page-header">
        <div>
            <h1>Ingresar</h1>
            <p class="muted">Acceso al sistema segun el rol asignado.</p>
        </div>
    </section>

    <form class="panel form narrow" method="POST" action="{{ route('login.store') }}">
        @csrf

        <div class="field">
            <label for="email">Email</label>
            <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus>
            @error('email') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div class="field">
            <label for="password">Password</label>
            <input id="password" name="password" type="password" required>
            @error('password') <span class="error">{{ $message }}</span> @enderror
        </div>

        <button class="button" type="submit">Ingresar</button>
    </form>
@endsection
