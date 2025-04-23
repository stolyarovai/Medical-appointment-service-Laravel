<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>{{ $title }}</title>
        <link rel="stylesheet" href="/servis/styles/form.css">
    </head>
    <body>
        <h1><a href="/servis/pages/index.php">Будь здоров!</a></h1>

        <form action="/servis/actions/{{ $action }}" method="POST" id="{{ $id }}">
            <h2>{{ $title }}</h2>
            {!! $content !!}
        </form>

        <script src="/servis/javascript/{{ $script }}.js"></script>
    </body>
</html>
