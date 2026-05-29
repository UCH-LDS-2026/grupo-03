<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Sistema Tickets')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <div class="layout">
        <header class="topbar">
            <div class="topbar-inner">
                <a class="brand" href="{{ auth()->check() ? route('home') : route('login') }}">Sistema Tickets</a>
                @auth
                    <nav class="nav" aria-label="Principal">
                        <a href="{{ route('home') }}">Inicio</a>
                        <a href="{{ route('tickets.index') }}">Tickets</a>
                        <a href="{{ route('tickets.create') }}">Nuevo ticket</a>
                        @if (auth()->user()->isAdmin())
                            <a href="{{ route('admin.users.index') }}">Usuarios</a>
                            <a href="{{ route('admin.areas.index') }}">Areas</a>
                            <a href="{{ route('admin.categories.index') }}">Categorias</a>
                        @endif
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="link-button" type="submit">Salir</button>
                        </form>
                    </nav>
                @endauth
            </div>
        </header>

        <main class="container">
            @if (session('status'))
                <div class="panel" role="status">
                    {{ session('status') }}
                </div>
            @endif

            @yield('content')
        </main>
    </div>
</body>
</html>
