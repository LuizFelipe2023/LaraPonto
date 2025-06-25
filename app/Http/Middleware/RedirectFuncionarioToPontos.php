<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectFuncionarioToPontos
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();

            if ($user->funcionario) {
                return redirect()->route('pontos.funcionario', ['id' => $user->funcionario->id]);
            }
        }

        return $next($request);
    }
}
