<?php

use App\Http\Middleware\AuthMiddleware;
use App\Http\Middleware\PermissaoMiddleware;
use App\Http\Middleware\InjectUserView;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Session\Middleware\StartSession;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        api: __DIR__ . '/../routes/api.php',
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {

        // Middleware necessários para flash messages
        $middleware->prepend(EncryptCookies::class);
        $middleware->prepend(AddQueuedCookiesToResponse::class);
        $middleware->prepend(StartSession::class);

        // Alias dos seus middlewares
        $middleware->alias([
            'auth.jwt' => AuthMiddleware::class,
            'permissao' => PermissaoMiddleware::class,
            'inject.user' => InjectUserView::class
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })
    ->create();
