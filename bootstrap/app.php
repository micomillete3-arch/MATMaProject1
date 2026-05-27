<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->redirectGuestsTo(fn () => route('student.login'));
        $middleware->redirectUsersTo(function () {
            $user = auth()->user();

            return $user ? route($user->dashboardRoute()) : route('student.login');
        });

        $middleware->alias([
            'maintenance' => \App\Http\Middleware\DownForMaintenanceMw::class,
            'role' => \App\Http\Middleware\RoleMiddleware::class,
            'no.cache' => \App\Http\Middleware\NoCacheMiddleware::class,
            'force.password.change' => \App\Http\Middleware\ForcePasswordChangeMiddleware::class,
        ]);

        $middleware->appendToGroup('web', [
            \App\Http\Middleware\ForcePasswordChangeMiddleware::class,
        ]);

        $middleware->appendToGroup('groupMiddleware', [
            \App\Http\Middleware\MiddlewareOne::class,
            \App\Http\Middleware\MiddlewareTwo::class,
            \App\Http\Middleware\DownForMaintenanceMw::class
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })
    ->create();
