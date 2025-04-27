<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>{{ $title }}</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('css/form.css') }}">
        <meta name="csrf-token" content="{{ csrf_token() }}">
    </head>
    
    <body>
        <div class="container form-container">
            <h1 class="text-center mb-4"><a href="{{ route('home') }}" class="brand-link">Будь здоров!</a></h1>

            <div class="form-wrapper">
                <form action="{{ $action }}" method="POST" id="{{ $id }}" class="shadow-sm">
                    @csrf
                    <h2 class="form-title">{{ $title }}</h2>
                    @yield('content')
                </form>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
        <script src="{{ asset('js/' . $script . '.js') }}"></script>
    </body>
</html>
