<?php

namespace BlaudCMS;

use Illuminate\Database\Eloquent\Model;
use Alsofronie\Uuid\UuidModelTrait;

/**
* Clase para administración de parametros de usuarios del sistema
* @Autor Raúl Chauvin
* @FechaCreacion  2018/08/30
* @Authentication/Authorization
*/

class ParamUser extends Model
{
    use UuidModelTrait;

    /**
     * Tabla de la Base de Datos usada por el modelo.
     *
     * @var string
     */
    protected $table = 'param_users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'context', 
        'code', 
        'description', 
        'user_id',
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
    FechaCreacion  2018/08/30
    Metodos para construir relaciones en ORM
    ******************************************************************/

    // ParamUser __belongs_to__ User
    public function user() {
        return $this->belongsTo('BlaudCMS\User','user_id', 'id');
    }

    /*************************************************************************************************
        Metodos scope para utilizar en el controlador
        Autor Raúl Chauvin
        FechaCreacion  2018/08/30
        EJ:
        $aParamsByContext = ParamUser::byContext('datos personales')->get();
    **************************************************************************************************/

    public function scopeByContext($sQuery, $sContext){
        return $sQuery->where('context', $sContext);
    }

    public function scopeByCode($sQuery, $sCode){
        return $sQuery->where('code', $sCode);
    }
}
