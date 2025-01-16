<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\RedirectIfNotAdmin;
use App\Http\Middleware\RedirectIfNotFaculty;
use App\Http\Middleware\RedirectIfOffice;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Register Middleware
        $middleware->alias([
            'Admin' => RedirectIfNotAdmin::class,
            'Dean' => RedirectIfNotAdmin::class,
            'Program-Head' => RedirectIfNotAdmin::class,
            'Faculty' => RedirectIfNotFaculty::class,
            'Admin-Staff' => RedirectIfOffice::class,  
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
