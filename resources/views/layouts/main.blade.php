<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('styles/' . View::getSection('style') . '.css') }}">
    <title>@yield('title')</title>
</head>
<body data-logged-in="{{ auth()->check() ? 'true' : 'false' }}">
    <header>
        <div class="header-left">
            <a href="{{ route('dashboard') }}">Будь здоров!</a>
            @auth
                <span id="userName">{{ auth()->user()->role === 'admin' ? 'Администратор' : auth()->user()->full_name }}</span>
            @else
                <span id="userName">Гость</span>
            @endauth
        </div>

        <div class="header-right">
            @guest
                <a href="{{ route('doctors.index') }}">Запись на приём</a>
                <a href="{{ route('help') }}">Помощь</a>
                <a href="{{ route('register') }}">Регистрация</a>
                <a href="{{ route('login') }}">Вход</a>
            @else
                @if(auth()->user()->role === 'admin')
                    <a href="{{ route('doctors.index') }}">Специалисты</a>
                    <a href="{{ route('users.index') }}">Пользователи</a>
                    <a href="{{ route('appointments.index') }}">Назначения</a>
                @else
                    <a href="{{ route('doctors.index') }}">Запись на приём</a>
                    <a href="{{ route('dashboard') }}">Личный кабинет</a>
                    <a href="{{ route('help') }}">Помощь</a>
                @endif
                <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit">Выход</button>
                </form>
            @endguest
        </div>
    </header>

    <main>
        @yield('content')
    </main>

    <footer>
        <p><b>&copy; 2025 Будь здоров!</b></p>
    </footer>

    <script src="{{ asset('javascript/' . View::getSection('script') . '.js') }}"></script>
</body>
</html>
