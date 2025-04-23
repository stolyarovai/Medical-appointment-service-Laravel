<?php
use Throwable;
use Illuminate\Http\Request;
use Illuminate\Http\Exceptions\HttpResponseException;

class Handler extends ExceptionHandler
{
    // …

    public function register(): void
    {
        $this->renderable(function (Throwable $e, Request $request) {
            $status = $this->isHttpException($e)
                ? $e->getStatusCode()
                : 500;

            $messages = [
                403 => 'Отсутствуют права на просмотр страницы',
                404 => 'Страница не найдена',
                500 => 'Внутренняя ошибка сервера',
            ];

            $message = $messages[$status] ?? 'Непредвиденная ошибка.';

            return response()
                ->view('errors.error', [
                    'error_code'    => $status,
                    'error_message' => $message,
                ], $status);
        });
    }
}
