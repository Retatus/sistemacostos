<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ForcePasswordChange
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if (!$user) {
            return $next($request);
        }

        // Rutas permitidas aun cuando debe cambiar contraseña
        $allowedRoutes = [
            'password.change',
            'password.update',
            'logout',
        ];

        if (in_array($request->route()?->getName(), $allowedRoutes)) {
            return $next($request);
        }

        // Forzar cambio
        if ($user->must_change_password) {
            return redirect()->route('password.change');
        }

        return $next($request);
    }
}
