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

use BlaudCMS\Http\Requests\Auth\RoleCreateRequest;
use BlaudCMS\Http\Requests\Auth\RoleUpdateRequest;

use Storage;
use Auth;

/**
* Clase para manejo de meta tags del portal web
* @Autor Raúl Chauvin
* @FechaCreacion  2018/08/30
* @Parametrization
*/

class RolesController extends Controller
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
     * Metodo para mostrar la lista de roles del sistema
     * @Autor Raúl Chauvin
     * @FechaCreacion  2018/11/21
     *
     * @route /backend/auth/roles/list
     * @method GET
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $rolesList = Role::paginate(20);
        $data = [
            'activeMenu' => $this->activeMenu,
            'oConfiguration' => $this->oConfiguration,

            // Datos especificos para utilizar en la vista
            'oStorage' => $this->oStorage,
            'env' => config('app.env'),
            'rolesList' => $rolesList,
        ];
        $view = view('backend.auth.roles.rolesList', $data);
        
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
     * Metodo para mostrar el formulario de creacion de nuevos roles en el sistema
     * @Autor Raúl Chauvin
     * @FechaCreacion  2018/12/27
     *
     * @route /backend/auth/roles/add
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

        $data = [
            'activeMenu' => $this->activeMenu,
            'oConfiguration' => $this->oConfiguration,

            // Datos especificos para utilizar en la vista
            'oStorage' => $this->oStorage,
            'env' => config('app.env'),
            'oRole' => null,
            'permissionsList' => $aPermissions,
        ];
        
        $view = view('backend.auth.roles.addEditRole', $data);
        
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
     * Metodo para guardar en la BD los datos del Rol ingresados desde el formulario
     * @Autor Raúl Chauvin
     * @FechaCreacion  2018/12/27
     *
     * @route /backend/auth/roles/add
     * @method POST
     * @param  \BlaudCMS\Http\Requests\Auth\RoleCreateRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoleCreateRequest $request)
    {
        if( ! $request->ajax() ){
            $request->session()->flash('errorMsg', 'Unicamente se aceptan peticiones Ajax');
            return back();
        }

        $oRole = new Role;
        $oRole->name = $request->name;
        if($oRole->save()){
            if($oRole->name == 'Super Administrator'){
                $oRole->syncPermissions(Permission::all());
            }else{
                $oRole->syncPermissions($request->permissions);
            }
            return response()->json(['status' => true , 'message' => 'El Rol '.$oRole->name.' ha sido agregado exisotamente.',], 200);
        }else{
            return response()->json(['status' => false , 'message' => 'El Rol '.$oRole->name.' no pudo ser agregado. Por favor intentelo nuevamente luego de unos minutos',], 200);
        }
    }

    /**
     * Metodo para mostrar el formulario de edicion de un Rol de acuerdo a su ID
     * @Autor Raúl Chauvin
     * @FechaCreacion  2018/12/27
     *
     * @route /backend/auth/roles/edit
     * @method GET
     * @param  int  $iRoleId
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $iRoleId)
    {
        if( ! $iRoleId){
            if($request->ajax()){
                $aResponseData = [
                    'type' => 'alert', 
                    'title' => 'Roles', 
                    'message' => 'Por favor seleccione un Rol para poder editarlo.', 
                    'class' => 'error',
                ];
                return response()->json($aResponseData, 200);
            }
            $request->session()->flash('errorMsg', 'Por favor seleccione un Rol para poder editarlo.');
            return back();
        }

        $oRole = Role::find($iRoleId);

        if( ! is_object($oRole)){
            if($request->ajax()){
                $aResponseData = [
                    'type' => 'alert', 
                    'title' => 'Roles', 
                    'message' => 'El Rol que usted a seleccionado no existe, por favor seleccione otro.', 
                    'class' => 'error',
                ];
                return response()->json($aResponseData, 200);
            }
            $request->session()->flash('errorMsg', 'El Rol que usted a seleccionado no existe, por favor seleccione otro.');
            return back();    
        }

        if($oRole->name == 'Super Administrator'){
            if($request->ajax()){
                $aResponseData = [
                    'type' => 'alert', 
                    'title' => 'Roles', 
                    'message' => 'El Rol que usted a seleccionado es el Super Administrador y este Rol no puede ser Editado.', 
                    'class' => 'error',
                ];
                return response()->json($aResponseData, 200);
            }
            $request->session()->flash('errorMsg', 'El Rol que usted a seleccionado es el Super Administrador y este Rol no puede ser Editado.');
            return back();
        }

        $aPermissions = [];
        $permissionsList = Permission::get();
        if($permissionsList->isNotEmpty()){
            foreach ($permissionsList as $permission) {
                $aAuxPerm = explode('_', $permission->name);
                $aPermissions[$aAuxPerm[2]][$permission->name] = $aAuxPerm[1].' '.$aAuxPerm[2];
            }
        }

        $data = [
            'activeMenu' => $this->activeMenu,
            'oConfiguration' => $this->oConfiguration,

            // Datos especificos para utilizar en la vista
            'oStorage' => $this->oStorage,
            'env' => config('app.env'),
            'oRole' => $oRole,
            'permissionsList' => $aPermissions,
        ];
        
        $view = view('backend.auth.roles.addEditRole', $data);
        
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
     * Metodo para actualizar en la BD los datos del Rol de acuerdo a su ID ingresados desde el formulario de edicion
     * @Autor Raúl Chauvin
     * @FechaCreacion  2018/12/27
     *
     * @route /backend/auth/roles/edit
     * @method PUT / PATCH
     * @param  int  $iRoleId
     * @param  \BlaudCMS\Http\Requests\Auth\RoleUpdateRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function update(RoleUpdateRequest $request, $iRoleId)
    {
        if( ! $request->ajax() ){
            $request->session()->flash('errorMsg', 'Unicamente se aceptan peticiones Ajax');
            return back();
        }

        if( ! $iRoleId){
            return response()->json(['status' => false , 'message' => 'Por favor seleccione un Rol para poder editarlo.',], 200);
        }

        $oRole = Role::find($iRoleId);
        
        if( ! is_object($oRole)){
            return response()->json(['status' => false , 'message' => 'El Rol que usted a seleccionado no existe, por favor seleccione otro.',], 200);    
        }

        if($oRole->name == 'Super Administrator'){
            return response()->json(['status' => false , 'message' => 'El Rol que usted a seleccionado es el Super Administrador y este Rol no puede ser Editado.',], 200);    
        }

        $oRole->name = $request->name;
        if($oRole->save()){
            if($oRole->name == 'Super Administrator'){
                $oRole->syncPermissions(Permission::all());
            }else{
                $oRole->syncPermissions($request->permissions);
            }
            return response()->json(['status' => true , 'message' => 'El Rol '.$oRole->name.' ha sido actualizado exisotamente.',], 200);
        }else{
            return response()->json(['status' => false , 'message' => 'El Rol '.$oRole->name.' no pudo ser actualizado. Por favor intentelo nuevamente luego de unos minutos',], 200);
        }
    }

    /**
     * Metodo para eliminar un Rol del sistema de acuerdo a su ID
     * @Autor Raúl Chauvin
     * @FechaCreacion  2018/12/27
     *
     * @route /backend/auth/roles/delete
     * @method DELETE
     * @param  int  $iRoleId
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $iRoleId)
    {
        if( ! $request->ajax() ){
            $request->session()->flash('errorMsg', 'Unicamente se aceptan peticiones Ajax');
            return back();
        }

        if( ! $iRoleId){
            return response()->json(['status' => false , 'message' => 'Por favor seleccione un Rol para poder eliminarlo.',], 200);
        }

        $oRole = Role::find($iRoleId);
        
        if( ! is_object($oRole)){
            return response()->json(['status' => false , 'message' => 'El Rol que usted a seleccionado no existe, por favor seleccione otro.',], 200);    
        }

        if($oRole->name == 'Super Administrador' || $oRole->name == 'Administrador' || $oRole->name == 'Supervisor' || $oRole->name == 'Manejador' || $oRole->name == 'Vendedor'){
            return response()->json(['status' => false , 'message' => 'No se pueden eliminar los Roles por defecto del sistema.',], 200);    
        }

        $oldRole = $oRole;
        $oRole->permissions()->detach();
        $oRole->users()->detach();
        
        if($oRole->delete()){
            return response()->json(['status' => true , 'message' => 'El Rol '.$oldRole->name.' ha sido eliminado exisotamente.',], 200);
        }else{
            return response()->json(['status' => false , 'message' => 'El Rol '.$oldRole->name.' no pudo ser eliminado. Por favor intentelo nuevamente luego de unos minutos',], 200);
        }
    }
}
