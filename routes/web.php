<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ArticleController;  

// Главная страница
Route::get('/', [MainController::class, 'index'])->name('home');

// О нас
Route::get('/about', function () {
    return view('about');
})->name('about');

// Контакты
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

// Галерея
Route::get('/gallery/{imageName}', [MainController::class, 'gallery'])->name('gallery');

// ========== ЛР №3: Регистрация ==========
// Показ формы регистрации (GET)
Route::get('/signin', [AuthController::class, 'create'])->name('auth.signin');

// Обработка формы регистрации (POST)
Route::post('/signin', [AuthController::class, 'registration'])->name('auth.register');

// Маршруты для статей (ЛР №4)
Route::resource('articles', ArticleController::class)->only(['index', 'show']);