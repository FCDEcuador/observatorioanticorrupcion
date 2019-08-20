<?php

namespace BlaudCMS;

use Illuminate\Database\Eloquent\Model;
use Alsofronie\Uuid\UuidModelTrait;

/**
* Clase para administración de menus del portal
* @Autor Raúl Chauvin
* @FechaCreacion  2017/07/04
* @Content
*/

class Menu extends Model
{
    use UuidModelTrait;

    /**
     * Tabla de la Base de Datos usada por el modelo.
     *
     * @var string
     */
    protected $table = 'menus';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'position',
        'active', // 1 (Activo), 0 (Inactivo)
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
    	FechaCreacion  2017/07/04
    	Metodos para construir relaciones en ORM
    ******************************************************************/

    // Menu __has_many__ MenuItem
    public function menuItems() {
        return $this->hasMany('BlaudCMS\MenuItem','menu_id', 'id');
    }


    /*************************************************************************************************
        Metodos scope para utilizar en el controlador
        Autor Raúl Chauvin
        FechaCreacion  2017/07/05
        EJ:
        $aActiveMenus = Menu::active()->get();
    **************************************************************************************************/

    public function scopeActive($sQuery){
        return $sQuery->whereActive(1);
    }

    public function scopeInactive($sQuery){
        return $sQuery->whereActive(0);
    }

    public function scopeByPosition($sQuery, $sPosition){
        return $sQuery->wherePosition($sPosition);
    }


    /**
    * Metodo que devuelve un modelo Menu encontrado por nombre o falso en caso de no encontrarlo
    * @Autor Raúl Chauvin
    * @FechaCreacion  2017/07/04
    *
    * @param string sName
    * @return Menu
    */
    public static function byName($sName = ''){
        return $sName ? Menu::whereName($sName)->first() : FALSE;
    }
}
