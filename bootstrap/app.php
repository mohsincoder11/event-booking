<?php

use App\Http\Middleware\PreventDoubleBooking;
use App\Http\Middleware\RoleMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Auth\AuthenticationException;


return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Define middleware aliases
        $middleware->alias([
            'role' => RoleMiddleware::class,
            'preventBooking' => PreventDoubleBooking::class,
        ]);

        $middleware->redirectGuestsTo(fn(Request $request) => null);
    })
    ->withExceptions(function ($exceptions) {
        $exceptions->render(function (AuthenticationException $e, Request $request) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized. Please provide a valid API token.'
            ], 401);
        });
    })
    ->create();
