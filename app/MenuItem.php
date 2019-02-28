<?php

namespace BlaudCMS;

use Illuminate\Database\Eloquent\Model;
use Alsofronie\Uuid\UuidModelTrait;

/**
* Clase para administración de items de menu del portal
* @Autor Raúl Chauvin
* @FechaCreacion  2017/07/04
* @Content
*/

class MenuItem extends Model
{
    use UuidModelTrait;

    /**
     * Tabla de la Base de Datos usada por el modelo.
     *
     * @var string
     */
    protected $table = 'menu_items';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'title',
        'summary',
        'image',
        'icon',
        'link',
        'type', // I (Interno), E (Externo)
        'target', // _self, _blank
        'level',
        'order',
        'active', // 1 (Activo), 0 (Inactivo)
        'menu_item_id',
        'menu_id',
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

    // MenuItem __belongs_to__ Menu
    public function menu() {
        return $this->belongsTo('BlaudCMS\Menu','menu_id', 'id');
    }

    // MenuItem __belongs_to__ MenuItem
    public function superMenuItem() {
        return $this->belongsTo('BlaudCMS\MenuItem','menu_item_id', 'id');
    }

    // MenuItem __has_many__ MenuItem
    public function menuItems() {
        return $this->hasMany('BlaudCMS\MenuItem','menu_item_id', 'id');
    }


    /*************************************************************************************************
        Metodos scope para utilizar en el controlador
        Autor Raúl Chauvin
        FechaCreacion  2017/07/05
        EJ:
        $aActiveInternMenuItems = MenuItem::active()->intern()->byOrder()->get();
    **************************************************************************************************/

    public function scopeActive($sQuery){
        return $sQuery->whereActive(1);
    }

    public function scopeInactive($sQuery){
        return $sQuery->whereActive(0);
    }

    public function scopeIntern($sQuery){
        return $sQuery->whereType('I');
    }

    public function scopeExtern($sQuery){
        return $sQuery->whereType('E');
    }

    public function scopeByOrder($sQuery){
        return $sQuery->orderBy('order', 'asc');
    }

    public function scopeByLevel($sQuery, $iLevel = 0){
        return $sQuery->whereLevel($iLevel);
    }

    public function scopeFirstLevel($sQuery){
        return $sQuery->byLevel(0)->whereNull('menu_item_id');
    }
}
