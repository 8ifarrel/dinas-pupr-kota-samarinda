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
use App\Http\Middleware\AllowCertainIpOnly;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        /**
         * visitor_id sengaja tidak dienkripsi.
         *
         * RecordStatistikPengunjung dipasang sebagai middleware global,
         * sehingga berjalan SEBELUM EncryptCookies sempat mendekripsi apa pun.
         * Selama cookie ini ikut dienkripsi, yang terbaca di sana hanyalah teks
         * sandi sepanjang ratusan karakter - lolos pemeriksaan strlen > 64 -
         * sehingga UUID pengunjung dibuat ulang pada setiap permintaan dan satu
         * orang terhitung sebagai pengunjung baru berkali-kali.
         *
         * Isinya hanya UUID acak tanpa makna dan bukan token keamanan, jadi
         * tidak ada yang bocor bila dibiarkan terbaca.
         */
        $middleware->encryptCookies(except: [
            'visitor_id',
        ]);

        $middleware->prepend(RecordStatistikPengunjung::class);
        $middleware->alias([
            'auth.apikey' => VerifyApiKey::class,
            'validate.signed.access' => ValidateSignedAccess::class,
            'auth.kelurahan' => AuthenticateKelurahan::class,
            'guest.kelurahan' => RedirectIfAuthenticatedKelurahan::class,
            'allow.certain.ip' => AllowCertainIpOnly::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
