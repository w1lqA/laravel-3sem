<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController as ApiAuthController;
use App\Http\Controllers\Api\ArticleController as ApiArticleController;
use App\Http\Controllers\Api\CommentController as ApiCommentController;

// ========== API АУТЕНТИФИКАЦИЯ (публичные) ==========
Route::post('/register', [ApiAuthController::class, 'register']);
Route::post('/login', [ApiAuthController::class, 'login']);

// ========== API СТАТЬИ (публичные) ==========
Route::get('/articles', [ApiArticleController::class, 'index']);
Route::get('/articles/{article}', [ApiArticleController::class, 'show']);

// ========== API КОММЕНТАРИИ (публичные) ==========
Route::get('/comments/{comment}', [ApiCommentController::class, 'show']);

// ========== ЗАЩИЩЕННЫЕ API МАРШРУТЫ (требуют аутентификации) ==========
Route::middleware('auth:sanctum')->group(function () {
    // Пользователь
    Route::get('/user', function () {
        return response()->json(auth()->user());
    });
    
    Route::post('/logout', [ApiAuthController::class, 'logout']);
    
    // ========== API КОММЕНТАРИИ (для авторизованных) ==========
    // Создание комментария (доступно всем авторизованным)
    Route::post('/comments', [ApiCommentController::class, 'store']);
    
    // Редактирование/удаление своих комментариев
    Route::middleware('can:update,comment')->group(function () {
        Route::put('/comments/{comment}', [ApiCommentController::class, 'update']);
        Route::delete('/comments/{comment}', [ApiCommentController::class, 'destroy']);
    });
    
    // ========== API УВЕДОМЛЕНИЯ (только для читателей, не модераторов) ==========
    Route::middleware(['auth:sanctum', 'not.moderator'])->group(function () {
        Route::get('/notifications', function () {
            $notifications = auth()->user()->notifications()->paginate(20);
            return response()->json($notifications);
        });
        
        Route::get('/notifications/{notification}/read', function ($notificationId) {
            $notification = auth()->user()->notifications()->findOrFail($notificationId);
            $notification->markAsRead();
            
            return response()->json([
                'message' => 'Уведомление помечено как прочитанное',
                'article_slug' => $notification->data['article_slug']
            ]);
        });
        
        Route::post('/notifications/mark-all-read', function () {
            auth()->user()->unreadNotifications->markAsRead();
            return response()->json(['message' => 'Все уведомления помечены как прочитанные']);
        });
    });
});

// ========== API ДЛЯ МОДЕРАТОРОВ ==========
Route::middleware(['auth:sanctum', 'moderator'])->group(function () {
    // ========== API СТАТЬИ (только для модераторов) ==========
    // Создание, редактирование, удаление статей
    Route::post('/articles', [ApiArticleController::class, 'store']);
    Route::put('/articles/{article}', [ApiArticleController::class, 'update']);
    Route::delete('/articles/{article}', [ApiArticleController::class, 'destroy']);
    
    // ========== API МОДЕРАЦИЯ КОММЕНТАРИЕВ (только для модераторов) ==========
    // Просмотр списка комментариев для модерации
    Route::get('/comments', [ApiCommentController::class, 'index']);
    
    // Одобрение/отклонение комментариев
    Route::post('/comments/{comment}/approve', [ApiCommentController::class, 'approve']);
    Route::post('/comments/{comment}/reject', [ApiCommentController::class, 'reject']);
});