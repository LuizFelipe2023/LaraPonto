<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check() || Auth::user()->tipo_usuario != 1) {
            return redirect()->route('home')->with('error', 'Acesso negado. Área restrita para administradores.');
        }

        return $next($request);
    }
}
