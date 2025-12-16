<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CommentController;

// ========== Публичные роуты ==========
Route::get('/', [MainController::class, 'index'])->name('home');
Route::get('/about', function () { return view('about'); })->name('about');
Route::get('/contacts', function () {
    return view('contacts', ['contacts' => [
        'email' => 'contact@laravelblog.test',
        'телефон' => '+7 (999) 123-45-67',
        'адрес' => 'г. Москва, ул. Лубянка, д. 42, офис 404',
        'telegram' => '@laravel_blog_support',
        'рабочие часы' => 'Пн–Пт: 10:00–19:00, Сб: 11:00–16:00',
        'ответственный' => 'Болохонцев Виктор (студент группы 241-321)'
    ]]);
})->name('contacts');
Route::get('/gallery/{imageName}', [MainController::class, 'gallery'])->name('gallery');

// ========== ЛР №6: Аутентификация ==========
// Гости
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('auth.register');
    Route::post('/register', [AuthController::class, 'register']);
    
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('auth.login');
    Route::post('/login', [AuthController::class, 'login']);
    
    // Старая форма ЛР №3
    Route::get('/signin', [AuthController::class, 'create'])->name('auth.signin');
    Route::post('/signin', [AuthController::class, 'registration']);
});

// Выход
Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');

// ========== Статьи ==========
// Публичные
Route::get('/articles', [ArticleController::class, 'index'])->name('articles.index');
Route::get('/articles/{article:slug}', [ArticleController::class, 'show'])->name('articles.show');

// Защищенные (используем просто 'auth' для веб-приложения)
Route::middleware('auth')->group(function () {
    Route::get('/articles/create', [ArticleController::class, 'create'])->name('articles.create');
    Route::post('/articles', [ArticleController::class, 'store'])->name('articles.store');
    Route::get('/articles/{article:slug}/edit', [ArticleController::class, 'edit'])->name('articles.edit');
    Route::put('/articles/{article:slug}', [ArticleController::class, 'update'])->name('articles.update');
    Route::delete('/articles/{article:slug}', [ArticleController::class, 'destroy'])->name('articles.destroy');
});

// ========== Комментарии ==========
// Публичные
Route::get('/comments', [CommentController::class, 'index'])->name('comments.index');
Route::get('/comments/{comment}', [CommentController::class, 'show'])->name('comments.show');

// Защищенные
Route::middleware('auth')->group(function () {
    Route::get('/comments/create', [CommentController::class, 'create'])->name('comments.create');
    Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::get('/comments/{comment}/edit', [CommentController::class, 'edit'])->name('comments.edit');
    Route::put('/comments/{comment}', [CommentController::class, 'update'])->name('comments.update');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
    
    // Модерация
    Route::post('/comments/{comment}/approve', [CommentController::class, 'approve'])
        ->name('comments.approve');
    Route::post('/comments/{comment}/reject', [CommentController::class, 'reject'])
        ->name('comments.reject');
});

// ========== Демо Sanctum токенов (отдельная группа) ==========
Route::middleware('auth:sanctum')->prefix('api')->group(function () {
    Route::get('/user', function () {
        return response()->json([
            'message' => 'Sanctum работает! (Токен в заголовке Authorization: Bearer)',
            'user' => auth()->user(),
            'token_info' => 'Этот роут требует Bearer токен в заголовке'
        ]);
    });
    
    Route::get('/articles', [ArticleController::class, 'apiIndex']);
});

// ========== Админка с проверкой роли ==========
Route::middleware(['auth', 'role:moderator'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard', [
            'user' => auth()->user()
        ]);
    })->name('admin.dashboard');
});