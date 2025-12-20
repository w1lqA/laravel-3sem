<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckModerator
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check() || !auth()->user()->isModerator()) {
            abort(403, 'Доступ запрещен. Только модераторы могут выполнять это действие.');
        }
        
        return $next($request);
    }
}