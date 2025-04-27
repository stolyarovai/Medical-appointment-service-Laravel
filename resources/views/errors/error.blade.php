<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Ошибка {{ $error_code }}</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('css/error.css') }}">
    </head>
    <body>
        <h1><a href="{{ route('home') }}">Будь здоров!</a></h1>

        <div class="error-container">
            <div class="error-code">{{ $error_code }}</div>
            <div class="error-message">Что-то пошло не так...</div>
            <div class="error-description">{{ $error_message }}</div>
            <a href="{{ route('home') }}" class="back-home">На главную</a>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
