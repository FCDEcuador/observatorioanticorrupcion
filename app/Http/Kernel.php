<?php

namespace BlaudCMS\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [
        \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \BlaudCMS\Http\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
        \BlaudCMS\Http\Middleware\TrustProxies::class,
        \BlaudCMS\Http\Middleware\ForceHttpsMiddleware::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            \BlaudCMS\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            // \Illuminate\Session\Middleware\AuthenticateSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \BlaudCMS\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],

        'api' => [
            'throttle:60,1',
            'bindings',
            \Barryvdh\Cors\HandleCors::class,
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => \Illuminate\Auth\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'bindings' => \Illuminate\Routing\Middleware\SubstituteBindings::class,
        'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'guest' => \BlaudCMS\Http\Middleware\RedirectIfAuthenticated::class,
        'signed' => \Illuminate\Routing\Middleware\ValidateSignature::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        
        /*
         *   Middlewares para validacion de tipos de usuario
         *   Autor: Raul Chauvin
         *   30 - Julio - 2018
         */
            // BACKEND USERS
                'superadmin' => \BlaudCMS\Http\Middleware\SuperadminMiddleware::class,
                'admin' => \BlaudCMS\Http\Middleware\AdminMiddleware::class,
                'backoffice' => \BlaudCMS\Http\Middleware\BackOfficeMiddleware::class,
                'reporter' => \BlaudCMS\Http\Middleware\ReporterMiddleware::class,

            // FRONTEND USERS
                'commerce' => \BlaudCMS\Http\Middleware\CommerceMiddleware::class,
                'standardUser' => \BlaudCMS\Http\Middleware\StandardUserMiddleware::class,
    ];
}
