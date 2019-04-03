<?php

namespace BlaudCMS;

use Illuminate\Database\Eloquent\Model;
use Alsofronie\Uuid\UuidModelTrait;

/**
* Clase para administración de imagenes del slider principal
* @Autor Raúl Chauvin
* @FechaCreacion  2019/04/02
* @Configuration
*/

class MainSlider extends Model
{
    use UuidModelTrait;
    
    /**
     * Tabla de la Base de Datos usada por el modelo.
     *
     * @var string
     */
    protected $table = 'main_sliders';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order',
        'image_path',
        'status'
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
        FechaCreacion  2019/04/02
    **************************************************************************************************/

    public function scopeActive($sQuery){
        return $sQuery->whereStatus(1);
    }

    public function scopeInactive($sQuery){
        return $sQuery->whereStatus(0);
    }
}
