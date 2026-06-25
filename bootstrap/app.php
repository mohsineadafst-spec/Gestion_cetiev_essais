<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Middleware global
        $middleware->append(\App\Http\Middleware\LogActionMiddleware::class);

        // Ou middleware par groupe
        // $middleware->web([\App\Http\Middleware\LogActionMiddleware::class]);
        // $middleware->api([\App\Http\Middleware\LogActionMiddleware::class]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
