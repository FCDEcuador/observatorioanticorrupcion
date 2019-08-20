<?php

namespace BlaudCMS;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Alsofronie\Uuid\UuidModelTrait;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
* Clase para administración de usuarios del sistema
* @Autor Raúl Chauvin
* @FechaCreacion  2018/08/30
* @Authentication/Authorization
*/

class User extends Authenticatable
{
    use Notifiable;
    use HasRoles;
    use UuidModelTrait;
    use SoftDeletes;

    /**
     * Tabla de la Base de Datos usada por el modelo.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * Atributos personalizados agregados al modelo.
     *
     * @var string
     */
    protected $appends = ['full_name'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'lastname',
        'email',
        'password',
        'temporary_password',
        'avatar',
        'type',
            /*
                S -> Superadministrator
                A -> Administrator
                B -> BackOffice
                R -> Reporter
                U -> Standard User
            */
        'status',
            /*
                1 -> Active
                0 -> Inactive
            */
        'remember_token',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 
        'remember_token',
        'deleted_at', 
    ];

    /**
     * Atributos generados automáticamente por el modelo.
     *
     * @var array
     */
    protected $guarded = [
        'created_at', 
        'updated_at', 
        'deleted_at', 
        'id',
    ];

    /**
     * Atributos generados automáticamente por el modelo.
     *
     * @var array
     */

    protected $dates = ['deleted_at'];

    /**
     * Método que genera el hash de las claves antes de guardarlas en la BD.
     * @Autor Raúl Chauvin
     * @FechaCreacion  2018/08/30
     *
     * @param string password
     *
     */
    public function setPasswordAttribute($password){
        $this->attributes['password'] = \Hash::make($password);
    }


    /**
     * Método que devuelve el nombre completo del usuario en el atributo full_name
     * @Autor Raúl Chauvin
     * @FechaCreacion  2019/01/29
     *
     * @param string fullName
     *
     */
    public function getFullNameAttribute(){
        return  $this->name." ".$this->lastname;
    }

    /*************************************************************************************************
        Metodos scope para utilizar en el controlador
        Autor Raúl Chauvin
        FechaCreacion  2018/08/30
        EJ:
        $aActiveAdminUsers = User::active()->superadmin()->get();
    **************************************************************************************************/

    public function scopeActive($sQuery){
        return $sQuery->whereStatus(1);
    }

    public function scopeInactive($sQuery){
        return $sQuery->whereStatus(0);
    }

    public function scopeSuperadmins($sQuery){
        return $sQuery->whereType('S');
    }

    public function scopeAdmins($sQuery){
        return $sQuery->whereType('A');
    }

    public function scopeBackOffices($sQuery){
        return $sQuery->whereType('B');
    }

    public function scopeReporters($sQuery){
        return $sQuery->whereType('R');
    }

    public function scopeStandards($sQuery){
        return $sQuery->whereType('U');
    }

    public function scopeBackendUsers($sQuery){
        return $sQuery->where(function($sQuery){
                                $sQuery->where('type', 'S')
                                       ->orWhere('type', 'A')
                                       ->orWhere('type', 'B')
                                       ->orWhere('type', 'R');
                            });
    }


    /**
     * Metodo que verifica si un usuario es superadmin.
     * @Autor Raúl Chauvin
     * @FechaCreacion  2018/08/30
     *
     * @param string sId?
     * @return bool
     */
    public static function isSuperadmin($sId = ''){
        $sId = !$sId ? \Auth::user()->id : $sId;
        return User::find($sId)->type == 'S' ? TRUE : FALSE;
    }

    /**
     * Metodo que verifica si un usuario es admin.
     * @Autor Raúl Chauvin
     * @FechaCreacion  2018/08/30
     *
     * @param string sId?
     * @return bool
     */
    public static function isAdmin($sId = ''){
        $sId = !$sId ? \Auth::user()->id : $sId;
        return User::find($sId)->type == 'A' ? TRUE : FALSE;
    }

    /**
     * Metodo que verifica si un usuario es BackOffice.
     * @Autor Raúl Chauvin
     * @FechaCreacion  2018/08/30
     *
     * @param string sId?
     * @return bool
     */
    public static function isBackOffice($sId = ''){
        $sId = !$sId ? \Auth::user()->id : $sId;
        return User::find($sId)->type == 'B' ? TRUE : FALSE;
    }

    /**
     * Metodo que verifica si un usuario es Reporter.
     * @Autor Raúl Chauvin
     * @FechaCreacion  2018/08/30
     *
     * @param string sId?
     * @return bool
     */
    public static function isReporter($sId = ''){
        $sId = !$sId ? \Auth::user()->id : $sId;
        return User::find($sId)->type == 'R' ? TRUE : FALSE;
    }

    /**
     * Metodo que verifica si un usuario es Estandar.
     * @Autor Raúl Chauvin
     * @FechaCreacion  2018/08/30
     *
     * @param string sId?
     * @return bool
     */
    public static function isStandard($sId = ''){
        $sId = !$sId ? \Auth::user()->id : $sId;
        return User::find($sId)->type == 'U' ? TRUE : FALSE;
    }

    

    /**
     * Metodo que verifica si un usuario está o no activo.
     * @Autor Raúl Chauvin
     * @FechaCreacion  2018/08/30
     *
     * @param string sId?
     * @return bool
     */
    public static function isActive($sId = ''){
        $sId = !$sId ? \Auth::user()->id : $sId;
        return User::find($sId)->status == 1 ? TRUE : FALSE;
    }


    /**
    * Metodo que devuelve un modelo User encontrado por email o falso en caso de no encontrarlo
    * @Autor Raúl Chauvin
    * @FechaCreacion  2018/08/30
    *
    * @param string sEmail?
    * @return User
    */
    public static function byEmail($sEmail = ''){
        if($sEmail){
            return User::whereEmail($sEmail)->first();
        }else{
            return FALSE;
        }
    }


    /**
    * Metodo que busca usuarios de acuerdo a una cadena buscada
    * @Autor Raúl Chauvin
    * @FechaCreacion  2018/08/30
    *
    * @param string sStringSearch?
    * @param string sType?
    * @param int iPaginate?
    * @return User[] 
    */
    public static function searchUser($sStringSearch = '', $sType = null, $iPaginate = 20){
        $aListUsers = null;
        if($sType){
            if( ! $sType || $sType == 'all'){
                $aListUsers = User::where(function($sQuery){
                                $sQuery->where('type', 'S')
                                       ->orWhere('type', 'A')
                                       ->orWhere('type', 'B')
                                       ->orWhere('type', 'R')
                                       ->orWhere('type', 'U');
                            });
            }elseif(strtolower($sType) == 'backend' || strtolower($sType) == 'back'){
                $aListUsers = User::where(function($sQuery){
                                $sQuery->where('type', 'S')
                                       ->orWhere('type', 'A')
                                       ->orWhere('type', 'B')
                                       ->orWhere('type', 'R');
                            });
            }elseif(strtolower($sType) == 'frontend' || strtolower($sType) == 'front' || strtolower($sType) == 'f'){
                $aListUsers = User::where('type', 'U');
            }else{
                $aListUsers = User::where('type', $sType);
            }
            
        }
        if($sStringSearch){
            if($aListUsers){
                $aListUsers = $aListUsers->where(function($sQuery) use($sStringSearch){
                                $sQuery->where('id','like','%'.$sStringSearch.'%')
                                      ->orWhere('name','like','%'.$sStringSearch.'%')
                                      ->orWhere('lastname','like','%'.$sStringSearch.'%')
                                      ->orWhere('email','like','%'.$sStringSearch.'%');
                            });
            }else{
                $aListUsers = User::where(function($sQuery) use($sStringSearch){
                                $sQuery->where('id','like','%'.$sStringSearch.'%')
                                      ->orWhere('name','like','%'.$sStringSearch.'%')
                                      ->orWhere('lastname','like','%'.$sStringSearch.'%')
                                      ->orWhere('email','like','%'.$sStringSearch.'%');
                            });
            }
        }
        if($aListUsers){
            $aListUsers = $aListUsers->orderBy('created_at', 'desc');
            $aListUsers = $aListUsers->paginate($iPaginate);    
        }else{
            $aListUsers = User::orderBy('created_at', 'desc')->paginate($iPaginate);
        }
        
        return $aListUsers;
    }
}
