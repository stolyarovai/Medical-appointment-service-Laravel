<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('css/' . View::getSection('style') . '.css') }}">
    <title>@yield('title')</title>
</head>
<body data-logged-in="{{ auth()->check() ? 'true' : 'false' }}">
    <header class="shadow-sm">
        <div class="header-left">
            <a href="{{ route('home') }}" class="brand">Будь здоров!</a>
            @auth
                <span id="userName">{{ auth()->user()->role === 'admin' ? 'Администратор' : auth()->user()->full_name }}</span>
            @else
                <span id="userName">Гость</span>
            @endauth
        </div>

        <div class="header-right">
            @guest
                <a href="{{ route('doctors.index') }}" class="nav-link">Запись на приём</a>
                <a href="{{ route('help') }}" class="nav-link">Помощь</a>
                <a href="{{ route('register') }}" class="nav-link">Регистрация</a>
                <a href="{{ route('login') }}" class="nav-link">Вход</a>
            @else
                @if(auth()->user()->role === 'admin')
                    <a href="{{ route('doctors.index') }}" class="nav-link">Специалисты</a>
                    <a href="{{ route('users.index') }}" class="nav-link">Пользователи</a>
                    <a href="{{ route('appointments.index') }}" class="nav-link">Назначения</a>
                @else
                    <a href="{{ route('doctors.index') }}" class="nav-link">Запись на приём</a>
                    <a href="{{ route('dashboard') }}" class="nav-link">Личный кабинет</a>
                    <a href="{{ route('help') }}" class="nav-link">Помощь</a>
                @endif
                <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-outline-light">Выход</button>
                </form>
            @endguest
        </div>
    </header>

    <main class="container py-4">
        @yield('content')
    </main>

    <footer class="mt-auto">
        <p><b>&copy; 2025 Будь здоров!</b></p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/' . View::getSection('script') . '.js') }}"></script>
</body>
</html>
