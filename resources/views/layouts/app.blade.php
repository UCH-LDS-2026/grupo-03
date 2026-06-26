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
                        @if (auth()->user()->isStaff())
                            <a href="{{ route('solutions.index') }}">Soluciones</a>
                        @endif
                        @if (auth()->user()->isAdmin())
                            <a href="{{ route('admin.users.index') }}">Usuarios</a>
                            <a href="{{ route('admin.areas.index') }}">Áreas</a>
                            <a href="{{ route('admin.categories.index') }}">Categorías</a>
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
    <script>
        document.querySelectorAll('[data-select-filter]').forEach((input) => {
            const select = document.getElementById(input.dataset.selectFilter);

            if (! select) {
                return;
            }

            input.addEventListener('input', () => {
                const search = input.value.trim().toLowerCase();

                Array.from(select.options).forEach((option) => {
                    if (option.value === '') {
                        option.hidden = false;
                        return;
                    }

                    option.hidden = search !== '' && ! option.textContent.toLowerCase().includes(search);
                });
            });
        });
    </script>
</body>
</html>
