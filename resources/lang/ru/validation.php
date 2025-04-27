<?php

return [
    'required' => 'Поле :attribute обязательно для заполнения.',
    'email' => 'Поле :attribute должно содержать валидный email-адрес.',
    'unique' => 'Такое значение поля :attribute уже существует.',
    'min' => [
        'string' => 'Поле :attribute должно содержать не менее :min символов.',
    ],
    'confirmed' => 'Подтверждение поля :attribute не совпадает.',
    'date' => 'Поле :attribute не является корректной датой.',
    'after_or_equal' => 'Поле :attribute должно содержать дату после или равную :date.',
    'date_format' => 'Поле :attribute не соответствует формату :format.',
    'exists' => 'Выбранное значение для :attribute некорректно.',
    'integer' => 'Поле :attribute должно быть целым числом.',
    'image' => 'Поле :attribute должно быть изображением.',
    'mimes' => 'Поле :attribute должно быть файлом одного из следующих типов: :values.',
    'max' => [
        'file' => 'Размер файла в поле :attribute не должен превышать :max Кб.',
        'string' => 'Поле :attribute не может содержать более :max символов.',
    ],

    'attributes' => [
        'email' => 'Email',
        'password' => 'Пароль',
        'fullName' => 'ФИО',
        'login' => 'Email',
        'appointment_date' => 'Дата приёма',
        'appointment_time' => 'Время приёма',
        'doctor_id' => 'Врач',
        'speciality' => 'Специальность',
        'profilePicture' => 'Изображение профиля',
    ],
]; 