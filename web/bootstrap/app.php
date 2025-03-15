<?php

use App\Http\Middleware\EnsureShopifyInstalled;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'shopify.auth' => \App\Http\Middleware\EnsureShopifySession::class,
            'shopify.installed' => \App\Http\Middleware\EnsureShopifyInstalled::class,
            'shopify.theme_api_request' => \App\Http\Middleware\ThemeExtensionApiValidation::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
