<?php

use Illuminate\Support\Facades\Route;

// Главная страница
Route::get('/', function () {
    return view('home');
})->name('home');

// О нас
Route::get('/about', function () {
    return view('about');
})->name('about');

// Контакты с динамическими данными
Route::get('/contacts', function () {
    $contacts = [
        'email' => 'contact@laravelblog.test',
        'телефон' => '+7 (999) 123-45-67',
        'адрес' => 'г. Москва, ул. Программистов, д. 42, офис 404',
        'telegram' => '@laravel_blog_support',
        'рабочие часы' => 'Пн–Пт: 10:00–19:00, Сб: 11:00–16:00',
        'ответственный' => 'Иванов Иван (студент группы ПИ-123)'
    ];
    
    return view('contacts', ['contacts' => $contacts]);
})->name('contacts');