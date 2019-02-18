<?php

namespace BlaudCMS;

use Illuminate\Database\Eloquent\Model;
use Alsofronie\Uuid\UuidModelTrait;

/**
* Clase para administración de mensajes generados desde el portal web
* @Autor Raúl Chauvin
* @FechaCreacion  2018/08/30
* @Configuration
*/

class Message extends Model
{
    use UuidModelTrait;

    /**
     * Tabla de la Base de Datos usada por el modelo.
     *
     * @var string
     */
    protected $table = 'messages';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'type', // Co -> Consult, Or -> Order, Su -> Suggestion, Cm -> Comment
        'subject',
        'message',
        'status', // 0 (Unread), 1 (Read)
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
        FechaCreacion  2018/08/30
        EJ:
        $aUnreadMessages = Message::unread()->get();
        $aUnreadConsultMessages = Message::unread()->consults()->get();
    **************************************************************************************************/

    public function scopeRead($sQuery){
        return $sQuery->whereStatus(1);
    }

    public function scopeUnread($sQuery){
        return $sQuery->whereStatus(0);
    }

    public function scopeConsults($sQuery){
        return $sQuery->whereType('Co');
    }

    public function scopeOrders($sQuery){
        return $sQuery->whereType('Or');
    }

    public function scopeSuggestions($sQuery){
        return $sQuery->whereType('Su');
    }

    public function scopeComments($sQuery){
        return $sQuery->whereType('Cm');
    }
}
