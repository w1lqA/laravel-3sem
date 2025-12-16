<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CommentController;

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

// ЛР №3: Регистрация
Route::get('/signin', [AuthController::class, 'create'])->name('auth.signin');
Route::post('/signin', [AuthController::class, 'registration'])->name('auth.register');

// ========== ЛР №5: CRUD для статей ==========
// ВРЕМЕННО УБИРАЕМ MIDDLEWARE!
Route::controller(ArticleController::class)->group(function () {
    Route::get('/articles', 'index')->name('articles.index');
    Route::get('/articles/create', 'create')->name('articles.create'); // <-- Доступ без авторизации
    Route::post('/articles', 'store')->name('articles.store');
    Route::get('/articles/{article:slug}', 'show')->name('articles.show');
    Route::get('/articles/{article:slug}/edit', 'edit')->name('articles.edit');
    Route::put('/articles/{article:slug}', 'update')->name('articles.update');
    Route::delete('/articles/{article:slug}', 'destroy')->name('articles.destroy');
});

// ========== ДЗ №3: CRUD для комментариев ==========
// ВРЕМЕННО УБИРАЕМ MIDDLEWARE!
Route::controller(CommentController::class)->group(function () {
    Route::get('/comments', 'index')->name('comments.index');
    Route::get('/comments/create', 'create')->name('comments.create'); // <-- Доступ без авторизации
    Route::post('/comments', 'store')->name('comments.store');
    Route::get('/comments/{comment}', 'show')->name('comments.show');
    Route::get('/comments/{comment}/edit', 'edit')->name('comments.edit');
    Route::put('/comments/{comment}', 'update')->name('comments.update');
    Route::delete('/comments/{comment}', 'destroy')->name('comments.destroy');
    
    // Модерация
    Route::post('/comments/{comment}/approve', 'approve')->name('comments.approve');
    Route::post('/comments/{comment}/reject', 'reject')->name('comments.reject');
});