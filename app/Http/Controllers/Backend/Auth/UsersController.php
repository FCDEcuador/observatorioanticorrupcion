<?php

namespace BlaudCMS\Http\Controllers\Backend\Auth;

use Illuminate\Http\Request;
use BlaudCMS\Http\Controllers\Controller;
use BlaudCMS\Http\Traits\BackendAuthorizable;

use BlaudCMS\Helpers\TimeFormat;

use BlaudCMS\Configuration;
use BlaudCMS\Role;
use BlaudCMS\Permission;
use BlaudCMS\User;

use BlaudCMS\Http\Requests\Auth\UserCreateRequest;
use BlaudCMS\Http\Requests\Auth\UserUpdateRequest;

use Storage;
use Auth;

/**
* Clase para manejo de meta tags del portal web
* @Autor Raúl Chauvin
* @FechaCreacion  2018/08/30
* @Parametrization
*/

class UsersController extends Controller
{

    use BackendAuthorizable;

    /**
     * Disco de storage.
     *
     * @var sStorageDisk
     */
    protected $sStorageDisk;

    /**
     * Instancia de storage.
     *
     * @var oStorage
     */
    protected $oStorage;

    /**
     * Instancia del modelo.
     *
     * @var Configuration
     */
    private $oConfiguration;

    /**
     * Variable para verificar cual menu debe estar activo.
     *
     * @var activeMenu
     */
    private $activeMenu;

    /**
     * Variable para almacenar la lista de mensajes no leidos.
     *
     * @var unreadMessages
     */
    private $unreadMessages;

    /**
     * Variable para almacenar la cantidad de mensajes no leidos.
     *
     * @var cantUnreadMessages
     */
    private $cantUnreadMessages;

    /**
     * Constructor del Controller, iniciamos los middlewares para validar que el usuario tenga los permisos correctos
     * @Autor Raúl Chauvin
     * @FechaCreacion  2018/08/30
     */
    public function __construct(){
        
        // Agregando restriccion para usuarios logueados y que sean de backend
        $this->middleware('auth');

        // Instanciamos el objeto de configuracion para obtener su data, si no existe creamos un nuevo objeto
        $oConfiguration = Configuration::find(1);
        if( ! is_object($oConfiguration)){
            $oConfiguration = new Configuration;
            $oConfiguration->id = 1;
            $oConfiguration->save();
        }
        $this->oConfiguration = $oConfiguration;

        $this->sStorageDisk = config('app.env') == 'production' ? 'public' : 'public';
        $this->oStorage = config('app.env') == 'production' ? Storage::disk('public') : Storage::disk('public');

        // Colocamos el valor en la variable $this->activeMenu 
        // para saber que item del menu de navegacion debe pintarse
        $this->activeMenu = 'Auth';
    }

    /**
     * Metodo para mostrar la lista de usuarios del sistema
     * @Autor Raúl Chauvin
     * @FechaCreacion  2018/11/21
     *
     * @route /backend/auth/users/list
     * @method GET / POST
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $usersList = User::searchUser($request->sStringSearch, 'backend', 20);
        $data = [
            'activeMenu' => $this->activeMenu,
            'oConfiguration' => $this->oConfiguration,

            // Datos especificos para utilizar en la vista
            'oStorage' => $this->oStorage,
            'env' => config('app.env'),
            'usersList' => $usersList,
        ];
        $view = view('backend.auth.users.usersList', $data);
        
        if($request->ajax()){
            $sections = $view->renderSections();
            $aSections = [
                'type' => 'html',
                'mainContent' => $sections['main-content'], 
                'scripts' => $sections['custom-js']
            ];
            return response()->json($aSections, 200);
        }
        
        return $view;
    }

    /**
     * Metodo para mostrar el formulario de creacion de nuevos usuarios en el sistema
     * @Autor Raúl Chauvin
     * @FechaCreacion  2018/12/27
     *
     * @route /backend/auth/users/add
     * @method GET
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $aPermissions = [];
        $permissionsList = Permission::get();
        if($permissionsList->isNotEmpty()){
            foreach ($permissionsList as $permission) {
                $aAuxPerm = explode('_', $permission->name);
                $aPermissions[$aAuxPerm[2]][$permission->name] = $aAuxPerm[1].' '.$aAuxPerm[2];
            }
        }

        $aRoles = Role::all();
        
        $data = [
            'activeMenu' => $this->activeMenu,
            'oConfiguration' => $this->oConfiguration,

            // Datos especificos para utilizar en la vista
            'oStorage' => $this->oStorage,
            'env' => config('app.env'),
            'oUser' => null,
            'rolesList' => $aRoles,
            'permissionsList' => $aPermissions,
        ];
        
        $view = view('backend.auth.users.addEditUser', $data);
        
        if($request->ajax()){
            $sections = $view->renderSections();
            $aSections = [
                'type' => 'html',
                'mainContent' => $sections['main-content'], 
                'scripts' => $sections['custom-js']
            ];
            return response()->json($aSections, 200);
        }
        
        return $view;
    }

    /**
     * Metodo para validar si una direccion de email ya esta tomada por un usuario
     * @Autor Raúl Chauvin
     * @FechaCreacion  2019/01/08
     *
     * @route /backend/auth/users/validate
     * @method GET / POST
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string $sId
     * @return \Illuminate\Http\Response
     */
    public function validateUser(Request $request, $sId = ''){
        if($request->ajax()){
            if( ! $request->email){
                return response()->json(['No se ha seleccionado ningun email para validar.'], 201);
            }
            if($sId){
                $oUser = User::find($sId);
                if(is_object($oUser)){
                    $validate = User::where('email', $request->email)->where('id','<>',$oUser->id)->count();
                }else{
                    $validate = User::where('email', $request->email)->count();
                }
            }else{
                $validate = User::where('email', $request->email)->count();
            }
            if($validate){
                return response()->json(['Ya existe un usuario con esa direccion de email'], 201);
            }else{
                return response()->json('true', 200);
            }
        }
        return response()->json(['Ups! Unicamente se aceptan peticiones ajax.'], 201);
    }

    /**
     * Metodo para guardar en la BD los datos del Usuario ingresados desde el formulario
     * @Autor Raúl Chauvin
     * @FechaCreacion  2019/01/02
     *
     * @route /backend/auth/users/add
     * @method POST
     * @param  \Illuminate\Http\Requests\UserCreateRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserCreateRequest $request)
    {
        if( ! $request->ajax() ){
            $request->session()->flash('errorMsg', 'Unicamente se aceptan peticiones Ajax');
            return back();
        }

        $oUser = new User;
        $oUser->name = $request->name;
        $oUser->lastname = $request->lastname;
        $oUser->email = $request->email;
        $oUser->password = $request->password;
        $oUser->temporary_password = $request->password;
        $oUser->type = $request->type;
        $oUser->status = $request->status;
        
        if($request->hasFile('avatar')){
            $avatar = $request->file('avatar');
            $name = $avatar->getClientOriginalName();
            $path = $avatar->storePubliclyAs('avatars',$name, ['disk' => $this->sStorageDisk]);
            $oUser->avatar = $path;
        }

        if($oUser->save()){
            // Asignando Roles
            $oUser->syncRoles($request->roles);
            // Asignando Permisos
            if($request->permissions){
                $oUser->syncPermissions($request->permissions);
            }else{
                $oUser->syncPermissions([]);
            }
            return response()->json(['status' => true , 'message' => 'El Usuario '.$oUser->full_name.' ha sido agregado exisotamente.',], 200);
        }else{
            return response()->json(['status' => false , 'message' => 'El Usuario '.$oUser->full_name.' no pudo ser agregado. Por favor intentelo nuevamente luego de unos minutos',], 200);
        }
    }

    /**
     * Metodo para mostrar el formulario de edicion de un Usuario de acuerdo a su ID
     * @Autor Raúl Chauvin
     * @FechaCreacion  2019/01/02
     *
     * @route /backend/auth/users/edit
     * @method GET
     * @param  string  $sUserId
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $sUserId = '')
    {
        if( ! $sUserId){
            if($request->ajax()){
                $aResponseData = [
                    'type' => 'alert', 
                    'title' => 'Usuarios', 
                    'message' => 'Por favor seleccione un Usuario para poder editarlo.', 
                    'class' => 'error',
                ];
                return response()->json($aResponseData, 200);
            }
            $request->session()->flash('errorMsg', 'Por favor seleccione un Usuario para poder editarlo.');
            return back();
        }

        $oUser = User::find($sUserId);
        
        if( ! is_object($oUser)){
            if($request->ajax()){
                $aResponseData = [
                    'type' => 'alert', 
                    'title' => 'Usuarios', 
                    'message' => 'El Usuario que usted a seleccionado no existe, por favor seleccione otro.', 
                    'class' => 'error',
                ];
                return response()->json($aResponseData, 200);
            }
            $request->session()->flash('errorMsg', 'El Usuario que usted a seleccionado no existe, por favor seleccione otro.');
            return back();    
        }

        $aPermissions = [];
        $permissionsList = Permission::get();
        if($permissionsList->isNotEmpty()){
            foreach ($permissionsList as $permission) {
                $aAuxPerm = explode('_', $permission->name);
                $aPermissions[$aAuxPerm[1]][$permission->name] = $aAuxPerm[0].' '.$aAuxPerm[1];
            }
        }

        $aRoles = Role::all();

        $aPermissions = [];
        $permissionsList = Permission::get();
        if($permissionsList->isNotEmpty()){
            foreach ($permissionsList as $permission) {
                $aAuxPerm = explode('_', $permission->name);
                $aPermissions[$aAuxPerm[2]][$permission->name] = $aAuxPerm[1].' '.$aAuxPerm[2];
            }
        }

        $aRoles = Role::all();
        
        $data = [
            'activeMenu' => $this->activeMenu,
            'oConfiguration' => $this->oConfiguration,

            // Datos especificos para utilizar en la vista
            'oStorage' => $this->oStorage,
            'env' => config('app.env'),
            'oUser' => $oUser,
            'rolesList' => $aRoles,
            'permissionsList' => $aPermissions,
        ];
        
        $view = view('backend.auth.users.addEditUser', $data);
        
        if($request->ajax()){
            $sections = $view->renderSections();
            $aSections = [
                'type' => 'html',
                'mainContent' => $sections['main-content'], 
                'scripts' => $sections['custom-js']
            ];
            return response()->json($aSections, 200);
        }
        
        return $view;


    }

    /**
     * Metodo para actualizar en la BD los datos del Usuario de acuerdo a su ID ingresados desde el formulario de edicion
     * @Autor Raúl Chauvin
     * @FechaCreacion  2019/01/02
     *
     * @route /auth/users/edit
     * @method PUT / PATCH
     * @param  string  $sUserId
     * @param  \Illuminate\Http\Requests\UserUpdateRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdateRequest $request, $sUserId = '')
    {
        if( ! $request->ajax() ){
            $request->session()->flash('errorMsg', 'Unicamente se aceptan peticiones Ajax');
            return back();
        }

        if( ! $sUserId){
            return response()->json(['status' => false , 'message' => 'Por favor seleccione un Usuario para poder editarlo.',], 200);
        }

        $oUser = User::find($sUserId);
        
        if( ! is_object($oUser)){
            return response()->json(['status' => false , 'message' => 'El Usuario que usted a seleccionado no existe, por favor seleccione otro.',], 200);    
        }

        $oUser->name = $request->name;
        $oUser->lastname = $request->lastname;
        if($oUser->email != 'admin@blaudcms.com'){
            $oUser->email = $request->email;
        }
        if($request->password){
            $oUser->password = $request->password;
            $oUser->temporary_password = '';
        }
        if($oUser->email == 'admin@blaudcms.com'){
            $oUser->status = 1;
        }else{
            $oUser->status = $request->status;
        }
        $oUser->type = $request->type;
        
        $oldAvatar = $oUser->avatar;
        if($request->hasFile('avatar')){
            $avatar = $request->file('avatar');
            $name = $avatar->getClientOriginalName();
            $path = $avatar->storePubliclyAs('avatars',$name, ['disk' => $this->sStorageDisk]);
            $oUser->avatar = $path;
        }

        if($oUser->save()){
            if($oUser->email != 'admin@blaudcms.com'){
                // Asignando Roles
                $oUser->syncRoles($request->roles);
                // Asignando Permisos
                if($request->permissions){
                    $oUser->syncPermissions($request->permissions);
                }else{
                    $oUser->syncPermissions([]);
                }
            }
            if($oldAvatar != $oUser->avatar){
                $this->oStorage->delete($oldAvatar);
            }
            return response()->json(['status' => true , 'message' => 'El Usuario '.$oUser->full_name.' ha sido agregado exisotamente.',], 200);
        }else{
            return response()->json(['status' => false , 'message' => 'El Usuario '.$oUser->full_name.' no pudo ser agregado. Por favor intentelo nuevamente luego de unos minutos',], 200);
        }
    }


    /**
     * Metodo para actualizar en la BD el estado del Usuario de acuerdo a su ID
     * @Autor Raúl Chauvin
     * @FechaCreacion  2019/01/02
     *
     * @route /backend/auth/users/change-status
     * @method GET
     * @param  string  $sUserId
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function changeStatus(Request $request, $sUserId = '')
    {
        if( ! $request->ajax() ){
            $request->session()->flash('errorMsg', 'Unicamente se aceptan peticiones Ajax');
            return back();
        }

        if( ! $sUserId){
            return response()->json(['status' => false , 'message' => 'Por favor seleccione un Usuario para poder editarlo.',], 200);
        }

        $oUser = User::find($sUserId);

        if( ! is_object($oUser)){
            return response()->json(['status' => false , 'message' => 'El Usuario que usted a seleccionado no existe, por favor seleccione otro.',], 200);
        }

        if($oUser->email == 'admin@blaudcms.com'){
            return response()->json(['status' => false , 'message' => 'No se puede cambiar de estado al usuario Super Administrador.',], 200);
        }

        $newStatus = $oUser->status == 1 ? 0 : 1;
        $status = $newStatus == 1 ? 'activado' : 'desactivado';

        $oUser->status = $newStatus;
        if($oUser->save()){
            return response()->json(['status' => true , 'message' => 'El Usuario '.$oUser->full_name.' ha sido '.$status.' exisotamente.',], 200);
        }else{
            return response()->json(['status' => false , 'message' => 'El Usuario '.$oUser->full_name.' no pudo ser '.$status.'. Por favor intentelo nuevamente luego de unos minutos',], 200);
        }
    }

    /**
     * Metodo para eliminar un Usuario del sistema de acuerdo a su ID
     * @Autor Raúl Chauvin
     * @FechaCreacion  2019/01/02
     *
     * @route /backend/auth/users/delete
     * @method DELETE
     * @param  string  $sUserId
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $sUserId = '')
    {
        if( ! $request->ajax() ){
            $request->session()->flash('errorMsg', 'Unicamente se aceptan peticiones Ajax');
            return back();
        }

        if( ! $sUserId){
            return response()->json(['status' => false , 'message' => 'Por favor seleccione un Usuario para poder eliminarlo.',], 200);
        }

        $oUser = User::find($sUserId);
        
        if( ! is_object($oUser)){
            return response()->json(['status' => false , 'message' => 'El Usuario que usted a seleccionado no existe, por favor seleccione otro.',], 200);    
        }

        if($oUser->email == 'admin@blaudcms.com'){
            return response()->json(['status' => false , 'message' => 'No se puede eliminar al usuario Super Administrador.',], 200);    
        }

        $oldUser = $oUser;

        $oUser->permissions()->detach();
        $oUser->roles()->detach();
        $oUser->paramUsers()->delete();
        
        if($oUser->delete()){
            return response()->json(['status' => true , 'message' => 'El Usuario '.$oldUser->full_name.' ha sido eliminado exisotamente.',], 200);
        }else{
            return response()->json(['status' => false , 'message' => 'El Usuario '.$oldUser->full_name.' no pudo ser eliminado. Por favor intentelo nuevamente luego de unos minutos',], 200);
        }
    }
}
