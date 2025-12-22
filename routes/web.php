<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CommentController;

// ========== ГЛАВНЫЕ МАРШРУТЫ ==========
Route::get('/', [MainController::class, 'index'])->name('home');

Route::get('/about', function () { 
    return view('about'); 
})->name('about');

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

Route::get('/gallery/{imageName}', [MainController::class, 'gallery'])->name('gallery');

// ========== АУТЕНТИФИКАЦИЯ ==========
Route::controller(AuthController::class)->group(function () {
    Route::get('/signin', 'create')->name('auth.signin');
    Route::post('/signin', 'registration')->name('auth.register');
    Route::get('/login', 'showLoginForm')->name('login');
    Route::post('/login', 'login')->name('auth.login');
    Route::post('/logout', 'logout')->name('auth.logout');
});

// ========== СТАТЬИ ==========
// Публичные маршруты
Route::get('/articles', [ArticleController::class, 'index'])->name('articles.index');

// ЗАЩИЩЕННЫЕ маршруты для статей - только для модераторов (ДОЛЖНЫ БЫТЬ ПЕРЕД show!)
Route::middleware(['auth', 'moderator'])->group(function () {
    // Создание статьи - ЭТО ВАЖНО! ДОЛЖНО БЫТЬ ПЕРЕД articles/{slug}!
    Route::get('/articles/create', [ArticleController::class, 'create'])->name('articles.create');
    Route::post('/articles', [ArticleController::class, 'store'])->name('articles.store');
    
    // Редактирование/удаление статьи
    Route::get('/articles/{article:slug}/edit', [ArticleController::class, 'edit'])->name('articles.edit');
    Route::put('/articles/{article:slug}', [ArticleController::class, 'update'])->name('articles.update');
    Route::delete('/articles/{article:slug}', [ArticleController::class, 'destroy'])->name('articles.destroy');
});

// Показ статьи - ПОСЛЕ create!
Route::get('/articles/{article:slug}', [ArticleController::class, 'show'])
    ->name('articles.show')
    ->middleware('track.article.view');

// ========== КОММЕНТАРИИ ==========
// Публичные маршруты комментариев
Route::get('/comments/create', [CommentController::class, 'create'])->name('comments.create');
Route::get('/comments/{comment}', [CommentController::class, 'show'])->name('comments.show');

// ЗАЩИЩЕННЫЕ маршруты комментариев
Route::middleware('auth')->group(function () {    
    // Создание комментария (доступно всем авторизованным)
    Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');
    
    // Редактирование/удаление своих комментариев
    Route::get('/comments/{comment}/edit', [CommentController::class, 'edit'])->name('comments.edit');
    Route::put('/comments/{comment}', [CommentController::class, 'update'])->name('comments.update');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
});

// Модерация комментариев - ТОЛЬКО для модераторов
Route::middleware(['auth', 'moderator'])->group(function () {
    // Просмотр списка комментариев для модерации
    Route::get('/comments', [CommentController::class, 'index'])->name('comments.index');
    
    // Одобрение/отклонение комментариев
    Route::post('/comments/{comment}/approve', [CommentController::class, 'approve'])->name('comments.approve');
    Route::post('/comments/{comment}/reject', [CommentController::class, 'reject'])->name('comments.reject');
});


// ========== УВЕДОМЛЕНИЯ (ЛР12) ==========
Route::middleware('auth')->group(function () {
    // Просмотр уведомления + переход к статье + пометка как прочитанное
    Route::get('/notifications/{notification}/read', function ($notificationId) {
        $notification = auth()->user()->notifications()->findOrFail($notificationId);
        
        // Помечаем как прочитанное
        $notification->markAsRead();
        
        // Перенаправляем на статью
        return redirect()->route('articles.show', $notification->data['article_slug']);
    })->name('notifications.read');
    
    // Страница со всеми уведомлениями
    Route::get('/notifications', function () {
        $notifications = auth()->user()->notifications()->paginate(20);
        return view('notifications.index', compact('notifications'));
    })->name('notifications.index');
    
    // Пометить все как прочитанные
    Route::post('/notifications/mark-all-read', function () {
        auth()->user()->unreadNotifications->markAsRead();
        return back()->with('success', 'Все уведомления помечены как прочитанные');
    })->name('notifications.mark-all-read');
});


// ========== ТЕСТОВЫЕ МАРШРУТЫ ==========
Route::get('/check-session', function() {
    dd([
        'auth_check' => auth()->check(),
        'user' => auth()->user(),
        'session_id' => session()->getId(),
        'session_all' => session()->all(),
        'cookies' => request()->cookies->all()
    ]);
});

Route::get('/check-auth', function() {
    return response()->json([
        'authenticated' => auth()->check(),
        'user' => auth()->user() ? [
            'id' => auth()->user()->id,
            'name' => auth()->user()->name,
            'email' => auth()->user()->email,
        ] : null,
        'session_id' => session()->getId(),
    ]);
});