<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsurePasswordChange {
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next) {
        $user = $request->user();

        if (is_null($user) || !$user->force_password_change) {
            return $next($request);
        }

        $routeName = optional($request->route())->getName();

        $allowedRoutes = [
            'security.edit',
            'logout',
            'password.confirm',
            'password.update',
            'password.request',
            'password.email',
            'password.reset',
        ];

        if (in_array($routeName, $allowedRoutes, true)) {
            return $next($request);
        }

        return redirect()->route('security.edit');
    }
}
