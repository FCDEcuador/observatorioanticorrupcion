<?php

namespace BlaudCMS\Http\Controllers\Backend\Parametrization;

use Illuminate\Http\Request;
use BlaudCMS\Http\Controllers\Controller;
use BlaudCMS\Http\Traits\BackendAuthorizable;

use BlaudCMS\Configuration;
use BlaudCMS\User;

use BlaudCMS\Http\Requests\Parametrization\ConfigUpdateRequest;

use Storage;

use Flashy;
use Auth;

/**
* Clase para manejo de configuracion del portal
* @Autor Raúl Chauvin
* @FechaCreacion  2018/08/30
* @Parametrization
*/

class ConfigurationsController extends Controller
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
     * Metodo para mostrar el formulario de edicion de parametros de configuracion del sistema
     * @Autor Raúl Chauvin
     * @FechaCreacion  2018/01/26
     *
     * @route /backend/parametrization/configuration
     * @method GET
     * @param  \Illuminate\Http\Request  $request
     * @param  string $sId
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $data = [
            // Datos generales para todas las vistas
            'activeMenu' => $this->activeMenu,

            // Datos especificos para utilizar en la vista
            'oStorage' => $this->oStorage,
            'oConfiguration' => $this->oConfiguration,
        ];

        $view = view('backend.parametrization.configuration', $data);

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
     * @route /backend/parametrization/configuration
     * @method PUT / PATCH
     * @param  \BlaudCMS\Http\Requests\Parametrization\ConfigUpdateRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function update(ConfigUpdateRequest $request)
    {

        if( ! $request->ajax() ){
            $request->session()->flash('errorMsg', 'Unicamente se aceptan peticiones Ajax');
            return back();
        }
        
        $this->oConfiguration->title_website = $request->title_website;
        $this->oConfiguration->facebook_account = $request->facebook_account;
        $this->oConfiguration->twitter_account = $request->twitter_account;
        $this->oConfiguration->instagram_account = $request->instagram_account;
        $this->oConfiguration->googleplus_account = $request->googleplus_account;
        $this->oConfiguration->pinterest_account = $request->pinterest_account;
        $this->oConfiguration->linkedin_account = $request->linkedin_account;
        $this->oConfiguration->youtube_account = $request->youtube_account;
        $this->oConfiguration->vimeo_account = $request->vimeo_account;
        $this->oConfiguration->google_analytics_script = $request->google_analytics_script;
        $this->oConfiguration->another_mark_top_script = $request->another_mark_top_script;
        $this->oConfiguration->another_mark_bottom_script = $request->another_mark_bottom_script;
        $this->oConfiguration->advertising_top_script = $request->advertising_top_script;
        $this->oConfiguration->advertising_positions = $request->advertising_positions;
        $this->oConfiguration->advertising_bottom_script = $request->advertising_bottom_script;
        $this->oConfiguration->add_this_script = $request->add_this_script;
        $this->oConfiguration->disqus_script = $request->disqus_script;
        $this->oConfiguration->contact_emails = $request->contact_emails;
        $this->oConfiguration->sales_emails = $request->sales_emails;
        $this->oConfiguration->admin_email = $request->admin_email;

        $oldBackendLogo = $this->oConfiguration->backend_logo;
        if($request->hasFile('backend_logo')){
            $mainImage = $request->file('backend_logo');
            $name = $mainImage->getClientOriginalName();
            $path = $mainImage->storePubliclyAs('config',$name, ['disk' => $this->sStorageDisk]);
            $this->oConfiguration->backend_logo = $path;
        }

        $oldFrontendLogo = $this->oConfiguration->frontend_logo;
        if($request->hasFile('frontend_logo')){
            $mainImage = $request->file('frontend_logo');
            $name = $mainImage->getClientOriginalName();
            $path = $mainImage->storePubliclyAs('config',$name, ['disk' => $this->sStorageDisk]);
            $this->oConfiguration->frontend_logo = $path;
        }

        if($this->oConfiguration->save()){
            if($oldBackendLogo != $this->oConfiguration->backend_logo && $oldBackendLogo != ''){
                $this->oStorage->delete($oldBackendLogo);
            }
            if($oldFrontendLogo != $this->oConfiguration->frontend_logo && $oldFrontendLogo != ''){
                $this->oStorage->delete($oldFrontendLogo);
            }
            return response()->json(['status' => true , 'message' => 'Los parametros han sido actualizados exitosamente.',], 200);
        }else{
            return response()->json(['status' => false , 'message' => 'Los parametros no pudieron ser actualizados. Por favor intentelo nuevamente luego de unos minutos.',], 200);
        }
    }
}
