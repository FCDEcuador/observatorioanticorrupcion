<?php

namespace BlaudCMS\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'BlaudCMS\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        /** @var \Illuminate\Routing\UrlGenerator $url */
        $url = $this->app['url'];
        // Force the application URL
        $url->forceRootUrl(config('app.url'));
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();

        //
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        /*
        |--------------------------------------------------------------------------
        | Web Routes Frontend
        |--------------------------------------------------------------------------
        |
        | Raul Chauvin
        | 2018/07/30
        | Registrando archivo para manejo de rutas de frontend de la plataforma Web E-Commerce Cuponcity
        |
        */

        Route::middleware('web')
             ->namespace($this->namespace)
             ->group(base_path('routes/blaudcms_backend.php'));

        /*
        |--------------------------------------------------------------------------
        | Web Routes Backend
        |--------------------------------------------------------------------------
        |
        | Raul Chauvin
        | 2018/07/30
        | Registrando archivo para manejo de rutas de backend de la plataforma Web E-Commerce Cuponcity
        |
        */

        Route::middleware('web')
             ->namespace($this->namespace)
             ->group(base_path('routes/blaudcms_frontend.php'));

    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        /*
        |--------------------------------------------------------------------------
        | Web Routes Web API
        |--------------------------------------------------------------------------
        |
        | Raul Chauvin
        | 2018/01/03
        | Registrando archivo para manejo de rutas del API RESTful de la plataforma Web E-Commerce Cuponcity
        |
        */

        Route::prefix('api')
             ->middleware('api')
             ->namespace($this->namespace)
             ->group(base_path('routes/blaudcms_api.php'));
    }
}
