<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;

// Заменяем старый роут на главной на вызов контроллера
Route::get('/', [MainController::class, 'index'])->name('home');

// О нас (оставляем как есть)
Route::get('/about', function () {
    return view('about');
})->name('about');

// Контакты (оставляем как есть)
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

// Новый роут для галереи
Route::get('/gallery/{imageName}', [MainController::class, 'gallery'])->name('gallery');