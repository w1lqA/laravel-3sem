<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckNotModerator
{
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && auth()->user()->isModerator()) {
            return response()->json(['message' => 'Модераторы не получают уведомления'], 403);
        }
        
        return $next($request);
    }
}