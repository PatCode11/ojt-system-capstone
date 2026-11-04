<?php

use App\Http\Middleware\EnsureRole;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(
    basePath: dirname(__DIR__)
)
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {

        /*
        |--------------------------------------------------------------------------
        | Custom Middleware Aliases
        |--------------------------------------------------------------------------
        */

        $middleware->alias([
            'role' => EnsureRole::class,
        ]);

        /*
        |--------------------------------------------------------------------------
        | Guest Redirect
        |--------------------------------------------------------------------------
        |
        | If somebody directly opens /admin/* without being logged in,
        | send them to the Admin login page.
        |
        | Other protected areas go to the OJT Portal login.
        |
        */

        $middleware->redirectGuestsTo(
            function (Request $request): string {
                if ($request->is('admin/*')) {
                    return route('admin.login');
                }

                return route('login');
            }
        );
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })
    ->create();