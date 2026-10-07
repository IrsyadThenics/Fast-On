<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Session\TokenMismatchException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'permission' => \App\Http\Middleware\CheckPermission::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->renderable(function (TokenMismatchException $exception, $request) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Sesi telah kedaluwarsa. Silakan muat ulang halaman dan coba lagi.',
                ], 419);
            }

            return redirect()->back()
                ->withInput()
                ->with('error', 'Sesi telah kedaluwarsa. Halaman sudah disegarkan, silakan coba lagi.');
        });
    })->create();
