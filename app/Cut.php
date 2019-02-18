<?php

namespace BlaudCMS;

use Illuminate\Database\Eloquent\Model;
use Alsofronie\Uuid\UuidModelTrait;

/**
* Clase para administración de recortes de imagenes
* @Autor Raúl Chauvin
* @FechaCreacion  2017/06/07
* @Content
*/

class Cut extends Model
{

	use UuidModelTrait;

    /**
     * Tabla de la Base de Datos usada por el modelo.
     *
     * @var string
     */
    protected $table = 'cuts';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'width',
        'height',
        'active',
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
        $aActiveCuts = Cut::active()->get();
    **************************************************************************************************/

    public function scopeActive($sQuery){
        return $sQuery->whereActive(1);
    }

    public function scopeInactive($sQuery){
        return $sQuery->whereActive(0);
    }


    /**
    * Metodo que devuelve un modelo Cut encontrado por name o falso en caso de no encontrarlo
    * @Autor Raúl Chauvin
    * @FechaCreacion  2018/08/30
    *
    * @param string sName?
    * @return User
    */
    public static function byName($sName = ''){
        if($sName){
            return Cut::whereName($sName)->first();
        }else{
            return FALSE;
        }
    }
}
