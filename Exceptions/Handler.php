<?php

namespace App\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    public function render($request, Throwable $exception)
    {
        // Кастомная обработка ошибок авторизации
        if ($exception instanceof AuthorizationException) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'У вас нет прав для выполнения этого действия.',
                    'error' => 'Forbidden'
                ], 403);
            }
            
            return redirect()->route('home')
                ->with('error', 'У вас нет прав для выполнения этого действия.');
        }
        
        return parent::render($request, $exception);
    }
}