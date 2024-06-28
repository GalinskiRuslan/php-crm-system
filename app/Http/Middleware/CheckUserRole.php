<?php

namespace App\Http\Middleware;
use Closure;
use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

class CheckUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        try {
            // Проверка аутентификации пользователя через JWT
            $user = JWTAuth::parseToken()->authenticate();
            // Проверка роли пользователя
            if ($user->role !== $role) {
                return response()->json('Forbidden', 403);
            }
        } catch (Exception $e) {
            return response()->json('Unauthorized', 401);
        }

        return $next($request);
    }
}
