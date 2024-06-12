<?php

namespace App\Http\Middleware;


use Closure;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckIsAdmin
{
    public function handle($request, Closure $next, $role)
    {
        if (!Auth::check() || Auth::user()->role !== $role) {
            dd($role, Auth::user()->role);
            // Если пользователь не аутентифицирован или его роль не соответствует
            return redirect('/')->withErrors(['accessError' => 'You do not have access to this page.']);
        }

        return $next($request);
    }
}
