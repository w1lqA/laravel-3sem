<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController as ApiAuthController;
use App\Http\Controllers\Api\ArticleController as ApiArticleController;
use App\Http\Controllers\Api\CommentController as ApiCommentController;

// API Аутентификация
Route::post('/register', [ApiAuthController::class, 'register']);
Route::post('/login', [ApiAuthController::class, 'login']);

// Защищенные API маршруты - используем 'auth:sanctum' для токенов
Route::middleware('auth:sanctum')->group(function () {
    // Пользователь
    Route::get('/user', function () {
        return response()->json(auth()->user());
    });
    
    Route::post('/logout', [ApiAuthController::class, 'logout']);
    
    // Статьи API
    Route::get('/articles', [ApiArticleController::class, 'index']);
    Route::post('/articles', [ApiArticleController::class, 'store']);
    Route::get('/articles/{article}', [ApiArticleController::class, 'show']);
    Route::put('/articles/{article}', [ApiArticleController::class, 'update']);
    Route::delete('/articles/{article}', [ApiArticleController::class, 'destroy']);
    
    // Комментарии API  
    Route::get('/comments', [ApiCommentController::class, 'index']);
    Route::post('/comments', [ApiCommentController::class, 'store']);
    Route::get('/comments/{comment}', [ApiCommentController::class, 'show']);
    Route::put('/comments/{comment}', [ApiCommentController::class, 'update']);
    Route::delete('/comments/{comment}', [ApiCommentController::class, 'destroy']);
});