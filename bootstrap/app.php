<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->trustProxies(at: '*');
        $middleware->redirectGuestsTo(function (Request $request){
            $route_name = Route::currentRouteName();
            $route_base_array = explode('.', $route_name, -1);
            $route_base = $route_base_array[0] ?? '';
            if($route_base == 'panel')
                return route('panel.auth');
            else
                return '/';
        });
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
