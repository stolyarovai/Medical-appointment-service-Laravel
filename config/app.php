<?php

return [
    'name' => env('APP_NAME', 'Будь здоров!'),

    'env' => env('APP_ENV', 'production'),

    'debug' => (bool) env('APP_DEBUG', false),

    'url' => env('APP_URL', 'http://localhost'),

    'timezone' => 'Europe/Moscow',

    'locale' => 'ru',

    'fallback_locale' => 'en',

    'faker_locale' => 'ru_RU',

    'cipher' => 'AES-256-CBC',

    'key' => env('APP_KEY'),

    'previous_keys' => [
        ...array_filter(
            explode(',', env('APP_PREVIOUS_KEYS', ''))
        ),
    ],

    'maintenance' => [
        'driver' => 'file',
        'store' => env('APP_MAINTENANCE_STORE', 'database'),
    ],
];
