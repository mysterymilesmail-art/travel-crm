<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Foundation\Configuration\Exceptions;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )

    // ✅ EXCEPTION HANDLER (THIS WAS MISSING / BROKEN)
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })

    // ✅ MIDDLEWARE REGISTRATION
    ->withMiddleware(function (Middleware $middleware) {

        // ROLE MIDDLEWARE ALIAS
        $middleware->alias([
            'role' => \App\Http\Middleware\RoleMiddleware::class,
        ]);

    })

    ->create();