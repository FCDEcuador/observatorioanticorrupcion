<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Application Name
    |--------------------------------------------------------------------------
    |
    | This value is the name of your application. This value is used when the
    | framework needs to place the application's name in a notification or
    | any other location as required by the application or its packages.
    |
    */

    'name' => env('APP_NAME', 'BlaudCMS'),

    /*
    |--------------------------------------------------------------------------
    | Application Environment
    |--------------------------------------------------------------------------
    |
    | This value determines the "environment" your application is currently
    | running in. This may determine how you prefer to configure various
    | services your application utilizes. Set this in your ".env" file.
    |
    */

    'env' => env('APP_ENV', 'production'),

    /*
    |--------------------------------------------------------------------------
    | Application Debug Mode
    |--------------------------------------------------------------------------
    |
    | When your application is in debug mode, detailed error messages with
    | stack traces will be shown on every error that occurs within your
    | application. If disabled, a simple generic error page is shown.
    |
    */

    'debug' => env('APP_DEBUG', false),

    /*
    |--------------------------------------------------------------------------
    | Application URL
    |--------------------------------------------------------------------------
    |
    | This URL is used by the console to properly generate URLs when using
    | the Artisan command line tool. You should set this to the root of
    | your application so that it is used when running Artisan tasks.
    |
    */

    'url' => env('APP_URL', 'http://www.observatorio.com.develop'),

    /*
    |--------------------------------------------------------------------------
    | Application Timezone
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default timezone for your application, which
    | will be used by the PHP date and date-time functions. We have gone
    | ahead and set this to a sensible default for you out of the box.
    |
    */

    'timezone' => 'America/Guayaquil',

    /*
    |--------------------------------------------------------------------------
    | Application Locale Configuration
    |--------------------------------------------------------------------------
    |
    | The application locale determines the default locale that will be used
    | by the translation service provider. You are free to set this value
    | to any of the locales which will be supported by the application.
    |
    */

    'locale' => 'es',

    /*
    |--------------------------------------------------------------------------
    | Application Fallback Locale
    |--------------------------------------------------------------------------
    |
    | The fallback locale determines the locale to use when the current one
    | is not available. You may change the value to correspond to any of
    | the language folders that are provided through your application.
    |
    */

    'fallback_locale' => 'en',

    /*
    |--------------------------------------------------------------------------
    | Encryption Key
    |--------------------------------------------------------------------------
    |
    | This key is used by the Illuminate encrypter service and should be set
    | to a random, 32 character string, otherwise these encrypted strings
    | will not be safe. Please do this before deploying an application!
    |
    */

    'key' => env('APP_KEY'),

    'cipher' => 'AES-256-CBC',

    /*
    |--------------------------------------------------------------------------
    | Autoloaded Service Providers
    |--------------------------------------------------------------------------
    |
    | The service providers listed here will be automatically loaded on the
    | request to your application. Feel free to add your own services to
    | this array to grant expanded functionality to your applications.
    |
    */

    'providers' => [

        /*
         * Laravel Framework Service Providers...
         */
        Illuminate\Auth\AuthServiceProvider::class,
        Illuminate\Broadcasting\BroadcastServiceProvider::class,
        Illuminate\Bus\BusServiceProvider::class,
        Illuminate\Cache\CacheServiceProvider::class,
        Illuminate\Foundation\Providers\ConsoleSupportServiceProvider::class,
        Illuminate\Cookie\CookieServiceProvider::class,
        Illuminate\Database\DatabaseServiceProvider::class,
        Illuminate\Encryption\EncryptionServiceProvider::class,
        Illuminate\Filesystem\FilesystemServiceProvider::class,
        Illuminate\Foundation\Providers\FoundationServiceProvider::class,
        Illuminate\Hashing\HashServiceProvider::class,
        Illuminate\Mail\MailServiceProvider::class,
        Illuminate\Notifications\NotificationServiceProvider::class,
        Illuminate\Pagination\PaginationServiceProvider::class,
        Illuminate\Pipeline\PipelineServiceProvider::class,
        Illuminate\Queue\QueueServiceProvider::class,
        Illuminate\Redis\RedisServiceProvider::class,
        Illuminate\Auth\Passwords\PasswordResetServiceProvider::class,
        Illuminate\Session\SessionServiceProvider::class,
        Illuminate\Translation\TranslationServiceProvider::class,
        Illuminate\Validation\ValidationServiceProvider::class,
        Illuminate\View\ViewServiceProvider::class,

        /*
         * Package Service Providers...
         */

        /*
         * Application Service Providers...
         */
        BlaudCMS\Providers\AppServiceProvider::class,
        BlaudCMS\Providers\AuthServiceProvider::class,
        // BlaudCMS\Providers\BroadcastServiceProvider::class,
        BlaudCMS\Providers\EventServiceProvider::class,
        BlaudCMS\Providers\RouteServiceProvider::class,

        /*
         *  FORMS & HTML
         */
        Collective\Html\HtmlServiceProvider::class,

        /*
         *   NOTIFICACIONES PUSH CON FLASHY
         */
        MercurySeries\Flashy\FlashyServiceProvider::class,

        /*
         *   MANEJO DE PDFs
         */
        Barryvdh\DomPDF\ServiceProvider::class,

        /*
         *   MANEJO DE ARCHIVOS EXCEL
         */
        Maatwebsite\Excel\ExcelServiceProvider::class,

        /*
         *   MANEJO DE SOCIAL LOGIN
         */
        Laravel\Socialite\SocialiteServiceProvider::class,

        /*
         *   LARAVEL FACEBOOK SDK
         */
        SammyK\LaravelFacebookSdk\LaravelFacebookSdkServiceProvider::class,

        /*
         *   CURL
         */
        Ixudra\Curl\CurlServiceProvider::class,

        /*
         *   GOOGLE MAPS
         */
        Cornford\Googlmapper\MapperServiceProvider::class,

        /*
         *   HERRAMIENTA PARA GENERAR SLUGS
         *
         *  use Cocur\Slugify\Slugify;
         *  $slugify = new Slugify();
         *  echo $slugify->slugify('Hello World!'); // hello-world
         */
        Cocur\Slugify\Bridge\Laravel\SlugifyServiceProvider::class,

        /*
         *   SEO TOOLS
         */
        Artesaos\SEOTools\Providers\SEOToolsServiceProvider::class,

        /*
         *   API GOOGLE ANALYTICS
         */
        Ipunkt\LaravelAnalytics\AnalyticsServiceProvider::class,

        /*
         *   LARAVEL PERMISSION
         */
        Spatie\Permission\PermissionServiceProvider::class,

        /*
         *   LARAVEL CORS
         */
        Barryvdh\Cors\ServiceProvider::class,

        /*
         *   GOOGLE SITEMAP
         */
        Watson\Sitemap\SitemapServiceProvider::class,


        /*
         *   ADMINISTRACION DE CANALES RSS
         */
        willvincent\Feeds\FeedsServiceProvider::class,

        /*
         *  Clase para formatear fechas y horas
         *  Raúl Chauvin
         *  30 Julio 2018
         *
         */
        BlaudCMS\Providers\TimeFormatServiceProvider::class,

        /*
         *  Clase para formatear fechas y horas
         *  Raúl Chauvin
         *  30 Julio 2018
         *
         */
        BlaudCMS\Providers\JwtAuthServiceProvider::class,

        /*
         *  Clase para validacion de ruc y cedula
         *  Raúl Chauvin
         *  30 Julio 2018
         *
         */
        BlaudCMS\Providers\IdValidationServiceProvider::class,

        /*
         *  Clase utilitaria del sistema
         *  Raúl Chauvin
         *  30 Julio 2018
         *
         */
        BlaudCMS\Providers\UtilityServiceProvider::class,

        /*
         *  CKEditor con File Manager para Laravel
         *  Raúl Chauvin
         *  02 Marzo 2019
         *
         */
        Unisharp\Ckeditor\ServiceProvider::class,
        UniSharp\LaravelFilemanager\LaravelFilemanagerServiceProvider::class,
        Intervention\Image\ImageServiceProvider::class,

    ],

    /*
    |--------------------------------------------------------------------------
    | Class Aliases
    |--------------------------------------------------------------------------
    |
    | This array of class aliases will be registered when this application
    | is started. However, feel free to register as many as you wish as
    | the aliases are "lazy" loaded so they don't hinder performance.
    |
    */

    'aliases' => [

        'App' => Illuminate\Support\Facades\App::class,
        'Artisan' => Illuminate\Support\Facades\Artisan::class,
        'Auth' => Illuminate\Support\Facades\Auth::class,
        'Blade' => Illuminate\Support\Facades\Blade::class,
        'Broadcast' => Illuminate\Support\Facades\Broadcast::class,
        'Bus' => Illuminate\Support\Facades\Bus::class,
        'Cache' => Illuminate\Support\Facades\Cache::class,
        'Config' => Illuminate\Support\Facades\Config::class,
        'Cookie' => Illuminate\Support\Facades\Cookie::class,
        'Crypt' => Illuminate\Support\Facades\Crypt::class,
        'DB' => Illuminate\Support\Facades\DB::class,
        'Eloquent' => Illuminate\Database\Eloquent\Model::class,
        'Event' => Illuminate\Support\Facades\Event::class,
        'File' => Illuminate\Support\Facades\File::class,
        'Gate' => Illuminate\Support\Facades\Gate::class,
        'Hash' => Illuminate\Support\Facades\Hash::class,
        'Lang' => Illuminate\Support\Facades\Lang::class,
        'Log' => Illuminate\Support\Facades\Log::class,
        'Mail' => Illuminate\Support\Facades\Mail::class,
        'Notification' => Illuminate\Support\Facades\Notification::class,
        'Password' => Illuminate\Support\Facades\Password::class,
        'Queue' => Illuminate\Support\Facades\Queue::class,
        'Redirect' => Illuminate\Support\Facades\Redirect::class,
        'Redis' => Illuminate\Support\Facades\Redis::class,
        'Request' => Illuminate\Support\Facades\Request::class,
        'Response' => Illuminate\Support\Facades\Response::class,
        'Route' => Illuminate\Support\Facades\Route::class,
        'Schema' => Illuminate\Support\Facades\Schema::class,
        'Session' => Illuminate\Support\Facades\Session::class,
        'Storage' => Illuminate\Support\Facades\Storage::class,
        'URL' => Illuminate\Support\Facades\URL::class,
        'Validator' => Illuminate\Support\Facades\Validator::class,
        'View' => Illuminate\Support\Facades\View::class,

        /*
         *   FORMS & HTML
         */
        'Form'      => Collective\Html\FormFacade::class,
        'Html'      => Collective\Html\HtmlFacade::class,

        /*
         *   MANEJO DE PDFs
         */
        'PDF'       => Barryvdh\DomPDF\Facade::class,


        /*
         *   MANEJO DE ARCHIVOS EXCEL
         */
        'Excel'     => Maatwebsite\Excel\Facades\Excel::class,

        /*
         *   MANEJO DE SOCIAL LOGIN
         */
        'Socialite' => Laravel\Socialite\Facades\Socialite::class,

        /*
         *   LARAVEL FACEBOOK SDK
         */
        'Facebook' => SammyK\LaravelFacebookSdk\FacebookFacade::class,


        /*
         *   CURL
         */
        'Curl' => Ixudra\Curl\Facades\Curl::class,

        /*
         *   NOTIFICACIONES PUSH CON FLASHY
         */
        'Flashy' => MercurySeries\Flashy\Flashy::class,

        /*
         *   GOOGLE MAPS
         */
        'Mapper' => Cornford\Googlmapper\Facades\MapperFacade::class,

        /*
         *   HERRAMIENTA PARA GENERAR SLUGS
         *
         *  use Cocur\Slugify\Slugify;
         *  $slugify = new Slugify();
         *  echo $slugify->slugify('Hello World!'); // hello-world
         */
        "Slugify" => Cocur\Slugify\Bridge\Laravel\SlugifyFacade::class,


        /*
         *   SEO TOOLS
         *
         *       SEO::setTitle('Home');
         *       SEO::setDescription('This is my page description');
         *       SEO::opengraph()->setUrl('http://current.url.com');
         *       SEO::setCanonical('https://codecasts.com.br/lesson');
         *       SEO::opengraph()->addProperty('type', 'articles');
         *       SEO::twitter()->setSite('@LuizVinicius73');
         */
        'SEOMeta'   => Artesaos\SEOTools\Facades\SEOMeta::class,
        'OpenGraph' => Artesaos\SEOTools\Facades\OpenGraph::class,
        'Twitter'   => Artesaos\SEOTools\Facades\TwitterCard::class,
        'SEO' => Artesaos\SEOTools\Facades\SEOTools::class,

        /*
         *   API GOOGLE ANALYTICS
        */
        'Analytics' => Ipunkt\LaravelAnalytics\AnalyticsFacade::class,

        /*
         *   GOOGLE SITEMAP
        */
        'Sitemap' => Watson\Sitemap\Facades\Sitemap::class,

        /*
         *   ADMINISTRACION DE CANALES RSS
         */
        'Feeds'    => willvincent\Feeds\Facades\FeedsFacade::class,


        /*
         *  Clase para formatear fechas y horas
         *  Raúl Chauvin
         *  30 Julio 2018
         *
         */
        'TimeFormat' => BlaudCMS\Helpers\TimeFormat::class,

        /*
         *  Clase para formatear fechas y horas
         *  Raúl Chauvin
         *  30 Julio 2018
         *
         */
        'JwtAuth' => BlaudCMS\Helpers\JwtAuth::class,

        /*
         *  Clase para validacion de RUC y cedula
         *  Raúl Chauvin
         *  30 Julio 2018
         *
         */
        'IdValidation' => BlaudCMS\Helpers\IdValidation::class,

        /*
         *  Clase utilitaria del sistema
         *  Raúl Chauvin
         *  30 Julio 2018
         *
         */
        'Utility' => BlaudCMS\Helpers\Utility::class,


        'Image' => Intervention\Image\Facades\Image::class,

    ],

];
