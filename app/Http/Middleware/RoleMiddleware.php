<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * @param  array<int, string>  $roles
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response|RedirectResponse
    {
        $user = $request->user();

        if (! $user) {
            return redirect()->route('student.login');
        }

        if ($roles === [] || in_array($user->role, $roles, true)) {
            return $next($request);
        }

        return redirect()
            ->route($user->dashboardRoute())
            ->with('error', 'You do not have permission to access that page.');
    }
}
