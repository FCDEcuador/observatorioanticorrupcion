<?php

namespace BlaudCMS;

use Illuminate\Database\Eloquent\Model;


/**
* Clase para administración de elementos del home del sitio
* @Autor Raúl Chauvin
* @FechaCreacion  2019/04/02
* @Configuration
*/

class HomeField extends Model
{
    /**
     * Tabla de la Base de Datos usada por el modelo.
     *
     * @var string
     */
    protected $table = 'home_fields';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'legal_library_text',
        'legal_library_image',
        'success_stories_title',
        'success_stories_text',
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
