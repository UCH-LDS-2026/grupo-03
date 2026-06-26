<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Sistema Tickets')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <div class="layout @guest guest-layout @endguest">
        @auth
            <aside class="sidebar">
                <a class="brand" href="{{ route('home') }}">Sistema Tickets</a>
                <nav class="nav" aria-label="Principal">
                    <a class="{{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Inicio</a>
                    <a class="{{ request()->routeIs('tickets.*') ? 'active' : '' }}" href="{{ route('tickets.index') }}">Tickets</a>
                    @if (auth()->user()->isStaff())
                        <a class="{{ request()->routeIs('solutions.*') ? 'active' : '' }}" href="{{ route('solutions.index') }}">Soluciones</a>
                    @endif
                    @if (auth()->user()->isAdmin())
                        <a class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">Usuarios</a>
                        <a class="{{ request()->routeIs('admin.areas.*') ? 'active' : '' }}" href="{{ route('admin.areas.index') }}">Áreas</a>
                        <a class="{{ request()->routeIs('admin.categories.*') ? 'active' : '' }}" href="{{ route('admin.categories.index') }}">Categorías</a>
                    @endif
                </nav>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="link-button" type="submit">Salir</button>
                </form>
            </aside>
        @endauth

        <main class="container @guest guest-container @endguest">
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

        document.querySelectorAll('[data-password-toggle]').forEach((button) => {
            const input = document.getElementById(button.dataset.passwordToggle);

            if (! input) {
                return;
            }

            button.addEventListener('click', () => {
                const isPassword = input.type === 'password';
                input.type = isPassword ? 'text' : 'password';
                button.textContent = isPassword ? 'Ocultar' : 'Ver';
            });
        });
    </script>
</body>
</html>
