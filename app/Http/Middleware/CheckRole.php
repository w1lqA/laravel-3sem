<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!auth()->check()) {
            return redirect()->route('auth.login');
        }

        $user = auth()->user();
        
        switch ($role) {
            case 'moderator':
                if (!$user->isModerator()) {
                    abort(403, 'Доступ только для модераторов');
                }
                break;
                
            case 'reader':
                if (!$user->isReader()) {
                    abort(403, 'Доступ только для читателей');
                }
                break;
        }

        return $next($request);
    }
}