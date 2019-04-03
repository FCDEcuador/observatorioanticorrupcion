<?php

namespace BlaudCMS\Http\Controllers\Backend\Parametrization;

use Illuminate\Http\Request;
use BlaudCMS\Http\Controllers\Controller;
use BlaudCMS\Http\Traits\BackendAuthorizable;

use BlaudCMS\Configuration;
use BlaudCMS\User;
use BlaudCMS\HomeField;

use BlaudCMS\Http\Requests\Parametrization\HomeFieldsUpdateRequest;

use Storage;

use Flashy;
use Auth;

/**
* Clase para manejo de elementos del home del web site
* @Autor Raúl Chauvin
* @FechaCreacion  2019/04/02
* @Parametrization
*/

class HomeFieldsController extends Controller
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
     * @var oConfiguration
     */
    private $oConfiguration;

    /**
     * Instancia del modelo.
     *
     * @var oHomeField
     */
    private $oHomeField;

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

        // Instanciamos el objeto de homefield para obtener su data, si no existe creamos un nuevo objeto
        $oHomeField = HomeField::find(1);
        if( ! is_object($oHomeField)){
            $oHomeField = new HomeField;
            $oHomeField->id = 1;
            $oHomeField->save();
        }
        $this->oHomeField = $oHomeField;

        $this->sStorageDisk = 'public';
        $this->oStorage = Storage::disk($this->sStorageDisk);

        // Colocamos el valor en la variable $this->activeMenu 
        // para saber que item del menu de navegacion debe pintarse
        $this->activeMenu = '';
    }


    /**
     * Metodo para mostrar el formulario de edicion del elementos del home
     * @Autor Raúl Chauvin
     * @FechaCreacion  2018/01/26
     *
     * @route /backend/parametrization/home-fields
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
            'oHomeField' => $this->oHomeField,
        ];

        $view = view('backend.parametrization.home-field', $data);

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
     * Metodo para guardar en la base de datos los cambios realizados a los elementos del home
     * @Autor Raúl Chauvin
     * @FechaCreacion  2019/04/02
     *
     * @route /backend/parametrization/home-fields
     * @method PUT / PATCH
     * @param  \BlaudCMS\Http\Requests\Parametrization\HomeFieldsUpdateRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function update(HomeFieldsUpdateRequest $request)
    {

        if( ! $request->ajax() ){
            $request->session()->flash('errorMsg', 'Unicamente se aceptan peticiones Ajax');
            return back();
        }
        
        $this->oHomeField->legal_library_text = $request->legal_library_text;
        $this->oHomeField->success_stories_title = $request->success_stories_title;
        $this->oHomeField->success_stories_text = $request->success_stories_text;

        $oldLegalLibraryImage = $this->oHomeField->legal_library_image;
        if($request->hasFile('legal_library_image')){
            $legalLibraryImage = $request->file('legal_library_image');
            $name = $legalLibraryImage->getClientOriginalName();
            $path = $legalLibraryImage->storePubliclyAs('homefields',$name, ['disk' => $this->sStorageDisk]);
            $this->oHomeField->legal_library_image = $path;
        }

        if($this->oHomeField->save()){
            if($oldLegalLibraryImage != $this->oHomeField->legal_library_image && $oldLegalLibraryImage != ''){
                $this->oStorage->delete($oldLegalLibraryImage);
            }
            return response()->json(['status' => true , 'message' => 'Los parametros han sido actualizados exitosamente.',], 200);
        }else{
            return response()->json(['status' => false , 'message' => 'Los parametros no pudieron ser actualizados. Por favor intentelo nuevamente luego de unos minutos.',], 200);
        }
    }
}
