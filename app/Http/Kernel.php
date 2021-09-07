<?php

namespace hrmis\Http;

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
        \hrmis\Http\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
        \hrmis\Http\Middleware\TrustProxies::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            \hrmis\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            // \Illuminate\Session\Middleware\AuthenticateSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \hrmis\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],

        'api' => [
            'throttle:60,1',
            'bindings',
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
        'auth'              => \Illuminate\Auth\Middleware\Authenticate::class,
        'hr'                => \hrmis\Http\Middleware\Administrator::class,
        'su'                => \hrmis\Http\Middleware\Superuser::class,
        'auth.basic'        => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'bindings'          => \Illuminate\Routing\Middleware\SubstituteBindings::class,
        'can'               => \Illuminate\Auth\Middleware\Authorize::class,
        'guest'             => \hrmis\Http\Middleware\RedirectIfAuthenticated::class,
        'throttle'          => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'signatory'         => \hrmis\Http\Middleware\Signatory::class,
        'pds'               => \hrmis\Http\Middleware\PersonalDataSheet::class,
    ];
}
