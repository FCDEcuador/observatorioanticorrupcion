<?php

namespace BlaudCMS\Http\Controllers\Backend\Auth;

use Illuminate\Http\Request;
use BlaudCMS\Http\Controllers\Controller;

use BlaudCMS\Configuration;
use BlaudCMS\User;

use BlaudCMS\Http\Requests\Auth\ProfileUpdateRequest;

use Storage;

use Flashy;
use Auth;

/**
* Clase para manejo de dashboard del CMS
* @Autor Raúl Chauvin
* @FechaCreacion  2018/08/30
* @Parametrization
*/

class ProfileController extends Controller
{

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
     * @FechaCreacion  2017/05/15
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
        $this->activeMenu = '';
    }


    /**
     * Metodo para mostrar el formulario de edicion del perfil de usuario
     * @Autor Raúl Chauvin
     * @FechaCreacion  2018/01/26
     *
     * @route /backend/my-profile
     * @method GET
     * @param  string $sId
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function profile(Request $request)
    {
        $data = [
            'activeMenu' => $this->activeMenu,

            // Datos especificos para utilizar en la vista
            'oStorage' => $this->oStorage,
            'env' => config('app.env'),
            'oConfiguration' => $this->oConfiguration,
            'oUser' => Auth::user(),
        ];

        $view = view('backend.auth.users.profile', $data);

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
     * Metodo para guardar en la base de datos los cambios realizados al perfil del usuario que se encuentra navegando en el sistema
     * @Autor Raúl Chauvin
     * @FechaCreacion  2018/01/26
     *
     * @route /backend/my-profile
     * @method GET
     * @param  \BlaudCMS\Http\Requests\Auth\ProfileUpdateRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function saveProfile(ProfileUpdateRequest $request){
        
        $oldAvatar = Auth::user()->avatar;
        Auth::user()->name = $request->name;
        Auth::user()->lastname = $request->lastname;
        Auth::user()->email = $request->email;
        if($request->password){
            Auth::user()->password = $request->password;
            Auth::user()->temporary_password = null;
        }

        if($request->hasFile('avatar')){
            $avatar = $request->file('avatar');
            $name = $avatar->getClientOriginalName();
            $path = $avatar->storePubliclyAs('public/backend/users',$name, ['disk' => $this->sStorageDisk]);
            Auth::user()->avatar = $path;
        }

        if(Auth::user()->save()){
            if($oldAvatar != '' && $oldAvatar != Auth::user()->avatar){
                $this->oStorage->delete($oldAvatar);
            }
            $request->session()->flash('successMsg', 'Estimado '.Auth::user()->name.' '.Auth::user()->lastname.' sus datos han sido actualizados exitosamente.');
            if($request->ajax()){
                return response()->json(['status' => true , 'message' => 'Estimado '.Auth::user()->name.' '.Auth::user()->lastname.', sus datos han sido actualizados exitosamente',], 200);
            }
        }else{
            if($request->ajax()){
                return response()->json(['status' => false , 'message' => 'Estimado '.Auth::user()->name.' '.Auth::user()->lastname.', lo sentimos mucho, sus datos no pudieron ser actualizados. Por favor intentelo nuevamente luego de unos minutos.',], 200);
            }
            $request->session()->flash('errorMsg', 'Estimado '.Auth::user()->name.' '.Auth::user()->lastname.', lo sentimos mucho, sus datos no pudieron ser actualizados. Por favor intentelo nuevamente luego de unos minutos.');
        }

        return redirect()->route('backend.profile');
    }
}
