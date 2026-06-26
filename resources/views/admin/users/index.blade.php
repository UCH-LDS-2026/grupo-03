@extends('layouts.app')

@section('title', 'Usuarios - Sistema Tickets')

@section('content')
    <section class="page-header">
        <div>
            <h1>Usuarios</h1>
            <p class="muted">Gestión de usuarios y roles.</p>
        </div>
        <a class="button" href="{{ route('admin.users.create') }}">Crear usuario</a>
    </section>

    <table class="table">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Correo electrónico</th>
                <th>Rol</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td><span class="badge">{{ \App\Support\TicketLabels::role($user->role) }}</span></td>
                    <td>
                        <div class="actions">
                            <a href="{{ route('admin.users.edit', $user) }}">Editar</a>
                            <form method="POST" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('¿Eliminar este usuario?');">
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
        {{ $users->links('vendor.pagination.default') }}
    </div>
@endsection
