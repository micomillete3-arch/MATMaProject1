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

            Illuminate\Support\Facades\Route::get('/account-check', function () {
                if (! Illuminate\Support\Facades\Schema::hasTable('user_accounts')) {
                    return response()->json([
                        'user_accounts_table_exists' => false,
                    ]);
                }

                $admin = App\Models\UserAccounts::where('username', 'admin01')->first();
                $passwordInfo = $admin ? password_get_info($admin->password) : null;

                return response()->json([
                    'user_accounts_table_exists' => true,
                    'user_accounts_count' => App\Models\UserAccounts::count(),
                    'admin01_exists' => (bool) $admin,
                    'admin01_active' => $admin?->is_active,
                    'admin01_role' => $admin?->role,
                    'admin01_must_change_password' => $admin?->must_change_password,
                    'admin01_hash_algo' => $passwordInfo['algoName'] ?? null,
                    'admin01_hash_length' => $admin ? strlen($admin->password) : null,
                    'admin01_default_password_matches' => $admin ? Illuminate\Support\Facades\Hash::check('Admin12345', $admin->password) : false,
                    'hash_driver' => config('hashing.driver'),
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
