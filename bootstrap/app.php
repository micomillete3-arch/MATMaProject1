<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
        then: function (): void {
            Illuminate\Support\Facades\Route::get('/render-check', function () {
                return response()->json([
                    'status' => 'LARAVEL OK',
                    'app_env' => config('app.env'),
                    'app_debug' => config('app.debug'),
                    'app_key_set' => filled(config('app.key')),
                    'app_url' => config('app.url'),
                    'db_connection' => config('database.default'),
                    'db_host_set' => filled(config('database.connections.mysql.host')),
                    'db_port_set' => filled(config('database.connections.mysql.port')),
                    'db_database_set' => filled(config('database.connections.mysql.database')),
                    'db_username_set' => filled(config('database.connections.mysql.username')),
                    'db_password_set' => filled(config('database.connections.mysql.password')),
                    'hash_driver' => config('hashing.driver'),
                    'session_driver' => config('session.driver'),
                    'cache_store' => config('cache.default'),
                    'queue_connection' => config('queue.default'),
                    'vite_manifest_exists' => file_exists(public_path('build/manifest.json')),
                    'php_version' => PHP_VERSION,
                ]);
            });
        },
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
