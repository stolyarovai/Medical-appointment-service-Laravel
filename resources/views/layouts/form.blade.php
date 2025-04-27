<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>{{ $title }}</title>
        <link rel="stylesheet" href="{{ asset('css/form.css') }}">
        <meta name="csrf-token" content="{{ csrf_token() }}">
    </head>
    <body>
        <h1><a href="{{ route('home') }}">Будь здоров!</a></h1>

        <form action="{{ $action }}" method="POST" id="{{ $id }}">
            @csrf
            <h2>{{ $title }}</h2>
            {!! $content !!}
        </form>

        <script src="{{ asset('js/' . $script . '.js') }}"></script>
    </body>
</html>
