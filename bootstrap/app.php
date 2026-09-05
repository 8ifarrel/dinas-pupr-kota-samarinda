<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

use App\Http\Middleware\RecordStatistikPengunjung;
use App\Http\Middleware\VerifyApiKey;
use App\Http\Middleware\ApiSuperAdminAuth;
use App\Http\Middleware\ValidateSignedAccess;
use App\Http\Middleware\AuthenticateKelurahan;
use App\Http\Middleware\RedirectIfAuthenticatedKelurahan;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->prepend(RecordStatistikPengunjung::class);
        $middleware->alias([
            'auth.apikey' => VerifyApiKey::class,
            'validate.signed.access' => ValidateSignedAccess::class,
            'auth.kelurahan' => AuthenticateKelurahan::class,
            'guest.kelurahan' => RedirectIfAuthenticatedKelurahan::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
