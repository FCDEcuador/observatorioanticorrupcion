<?php

namespace BlaudCMS;

use Illuminate\Database\Eloquent\Model;

/**
* Clase para administración de configuracion del frontend sistema
* @Autor Raúl Chauvin
* @FechaCreacion  2018/08/30
* @Configuration
*/

class Configuration extends Model
{
    /**
     * Tabla de la Base de Datos usada por el modelo.
     *
     * @var string
     */
    protected $table = 'configurations';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title_website',
        'facebook_account',
        'twitter_account',
        'instagram_account',
        'googleplus_account',
        'pinterest_account',
        'linkedin_account',
        'youtube_account',
        'vimeo_account',
        'google_analytics_script',
        'another_mark_top_script',
        'another_mark_bottom_script',
        'advertising_top_script',
        'advertising_positions',
        'advertising_bottom_script',
        'add_this_script',
        'disqus_script',
        'contact_map_coordinates',
        'contact_emails',
        'sales_emails',
        'admin_email',
        'backend_logo',
        'frontend_logo',
    ];

    /**
     * Atributos generados automáticamente por el modelo.
     *
     * @var array
     */
    protected $guarded = [
        'created_at', 
        'updated_at', 
        'id',
    ];
}
