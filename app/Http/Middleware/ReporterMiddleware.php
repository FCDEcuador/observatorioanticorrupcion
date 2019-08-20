<?php

namespace BlaudCMS\Http\Middleware;
use Illuminate\Contracts\Auth\Guard;

use Closure;
use Flashy;

class ReporterMiddleware
{
    protected $auth;

    public function __construct(Guard $auth){
        // Almacenamos en nuestra variable el objeto del usuario logeado
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if( $this->auth->user()->type != 'S' && 
            $this->auth->user()->type != 'A' && 
            $this->auth->user()->type != 'B' && 
            $this->auth->user()->type != 'R'
        ){
            Flashy::error('Ups!!. Usted no tiene permisos para navegar en esta sección del sistema.');
            return back();
        }

        return $next($request);
    }
}
