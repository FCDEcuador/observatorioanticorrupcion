<?php

namespace BlaudCMS;

use Illuminate\Database\Eloquent\Model;
use Alsofronie\Uuid\UuidModelTrait;

/**
* Clase para administración de lo que ocurrio de Casos de corrupcion
* @Autor Raúl Chauvin
* @FechaCreacion  2019/02/18
* @Content
*/

class WhatHappened extends Model
{
    use UuidModelTrait;


    /**
     * Tabla de la Base de Datos usada por el modelo.
     *
     * @var string
     */
    protected $table = 'what_happened';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'year',
        'month',
        'day',
        'description',
        'order',
        'corruption_case_id',
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

    /*****************************************************************
    	Autor Raúl Chauvin
    	FechaCreacion  2017/06/07
    	Metodos para construir relaciones en ORM
    ******************************************************************/

    // WhatHappened __belongs_to__  CorruptionCase
    public function corruptionCase() {
        return $this->belongsTo('BlaudCMS\CorruptionCase','corruption_case_id', 'id');
    }

    /*************************************************************************************************
        Metodos scope para utilizar en el controlador
        Autor Raúl Chauvin
        FechaCreacion  2017/06/09
    **************************************************************************************************/

    public function scopeByOrder($sQuery){
    	return $sQuery->orderBy('order', 'asc');
    }


    /**
    * Metodo que devuelveel siguiente numero para el ordenamiento de registro de la tabla what_happened
    * @Autor Raúl Chauvin
    * @FechaCreacion  2017/06/09
    *
    * @param string sCorruptionCaseId
    * @return int $newOrder
    */
    public static function newOrder($sCorruptionCaseId = ''){
        
        if( ! $sCorruptionCaseId){
        	return null;
        }
        
        $oCorruptionCase = CorruptionCase::find($sCorruptionCaseId);
        if( ! is_object($oCorruptionCase)){
        	return null;
        }
        
        $lastOrder = $oCorruptionCase->whatsHappeneds()->max('order');
        $newOrder = $lastOrder + 1;

        return $newOrder;
    }
}
