<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Permitir acesso somente para tipo_usuario 1 e 2.
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        if (in_array($user->tipo_usuario, [1, 2])) {
            return $next($request);
        }

        abort(403, 'Acesso negado.');
    }
}
