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

class ExternalLink extends Model
{
    use UuidModelTrait;

    /**
     * Tabla de la Base de Datos usada por el modelo.
     *
     * @var string
     */
    protected $table = 'external_links';

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
        'active', // 1 (Activo), 0 (Inactivo)
        'target', // _self, _blank
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


    /*************************************************************************************************
        Metodos scope para utilizar en el controlador
        Autor Raúl Chauvin
        FechaCreacion  2017/06/07
        EJ:
        $aActiveLinks = ExternalLink::active()->get();
    **************************************************************************************************/

    public function scopeActive($sQuery){
        return $sQuery->whereActive(1);
    }

    public function scopeInactive($sQuery){
        return $sQuery->whereActive(0);
    }


    /**
    * Metodo que devuelve un modelo ExternalLink encontrado por nombre o falso en caso de no encontrarlo
    * @Autor Raúl Chauvin
    * @FechaCreacion  2017/07/05
    *
    * @param string sName
    * @return ExternalLink
    */
    public static function byName($sName = ''){
        return $sName ? ExternalLink::whereName($sName)->first() : FALSE;
    }
}
