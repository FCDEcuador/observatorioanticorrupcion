<?php

namespace BlaudCMS;

use Illuminate\Database\Eloquent\Model;
use Alsofronie\Uuid\UuidModelTrait;

/**
* Clase para administración de enlaces externos
* @Autor Raúl Chauvin
* @FechaCreacion  2017/07/05
* @Content
*/

class SuccessStory extends Model
{
    use UuidModelTrait;

    /**
     * Tabla de la Base de Datos usada por el modelo.
     *
     * @var string
     */
    protected $table = 'success_stories';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'title',
        'subtitle',
        'description',
        'image',
        'icon',
        'url',
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


    /**
    * Metodo que devuelve un modelo SuccessStory encontrado por nombre o falso en caso de no encontrarlo
    * @Autor Raúl Chauvin
    * @FechaCreacion  2017/07/05
    *
    * @param string sName
    * @return SuccessStory
    */
    public static function byName($sName = ''){
        return $sName ? SuccessStory::whereName($sName)->first() : FALSE;
    }
}
