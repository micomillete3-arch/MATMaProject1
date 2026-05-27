<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ForcePasswordChangeMiddleware
{
    public function handle(Request $request, Closure $next): Response|RedirectResponse
    {
        if (! $request->session()->has('password_change_user_id')) {
            return $next($request);
        }

        if ($request->routeIs('student.password.change', 'student.password.update')) {
            return $next($request);
        }

        return redirect()->route('student.password.change');
    }
}
