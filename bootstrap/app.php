<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use App\Http\Middleware\OwnerMiddleware;
use App\Http\Middleware\CustomerMiddleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->group('api', [
           EnsureFrontendRequestsAreStateful::class, 
         // 'auth:sanctum',
            'throttle:60,1', // ✅ Correct way to set API rate limiting (60 requests per minute)
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ]);

        // Register role-based middleware aliases
        $middleware->alias([
            'owner' => OwnerMiddleware::class,
            'customer' => CustomerMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
