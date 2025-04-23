<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Ошибка {{ $error_code }}</title>
        <link rel="stylesheet" href="/servis/styles/error.css">
    </head>
    <body>
        <h1><a href="/servis/pages/index.php">Будь здоров!</a></h1>

        <h2 class="error-message">Что-то пошло не так...</h2>

        <p>Код ошибки: {{ $error_code }}</p>

        <p>{{ $error_message }}</p>
    </body>
</html>
