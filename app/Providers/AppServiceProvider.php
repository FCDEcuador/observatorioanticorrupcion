<?php

namespace BlaudCMS\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

use Illuminate\Support\Facades\Validator;

use BlaudCMS\Helpers\IdValidation;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        /*
            @Autor Raúl Chauvin
            @FechaCreacion 2018/05/02

            CORRIGIENDO EL ERROR:
                [Illuminate\Database\QueryException]
                SQLSTATE[42000]: Syntax error or access violation: 1071 Specified key was too long; max key length is 767 bytes (SQL: alter table `password_resets` add index `password_resets_email_index`(`email`))
        */
        \Schema::defaultStringLength(191);


        /*
            @Autor Raúl Chauvin
            @FechaCreacion 2018/05/02
            Creando reglas de validación para RUC y CI
        */
        Validator::extend('person_id_ruc', function ($attribute, $value, $parameters, $validator) {
            $oIdValidation = new IdValidation($value);
            if(! $oIdValidation->validateID() && ! $oIdValidation->validateRucNaturalPerson() && ! $oIdValidation->validateRucPrivateSociety() && ! $oIdValidation->validateRucPublicSociety()){
                return false;
            }
            return true;
        });

        Validator::extend('person_id', function ($attribute, $value, $parameters, $validator) {
            $oIdValidation = new IdValidation($value);
            if(! $oIdValidation->validateID() ){
                return false;
            }
            return true;
        });

        Validator::extend('ruc_natural_person', function ($attribute, $value, $parameters, $validator) {
            $oIdValidation = new IdValidation($value);
            if(! $oIdValidation->validateRucNaturalPerson() ){
                return false;
            }
            return true;
        });

        Validator::extend('ruc_legal_person', function ($attribute, $value, $parameters, $validator) {
            $oIdValidation = new IdValidation($value);
            if(! $oIdValidation->validateRucPrivateSociety() ){
                return false;
            }
            return true;
        });

        Validator::extend('ruc_public_society', function ($attribute, $value, $parameters, $validator) {
            $oIdValidation = new IdValidation($value);
            if(! $oIdValidation->validateRucPublicSociety() ){
                return false;
            }
            return true;
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
