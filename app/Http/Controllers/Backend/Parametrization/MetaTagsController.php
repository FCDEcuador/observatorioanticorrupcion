<?php

namespace BlaudCMS\Http\Controllers\Backend\Parametrization;

use Illuminate\Http\Request;
use BlaudCMS\Http\Controllers\Controller;
use BlaudCMS\Http\Traits\BackendAuthorizable;

use BlaudCMS\Configuration;
use BlaudCMS\MetaTag;
use BlaudCMS\User;

use BlaudCMS\Http\Requests\Parametrization\MetaTagCreateRequest;
use BlaudCMS\Http\Requests\Parametrization\MetaTagUpdateRequest;

use Storage;

use Auth;

/**
* Clase para manejo de meta tags del portal web
* @Autor Raúl Chauvin
* @FechaCreacion  2018/08/30
* @Parametrization
*/

class MetaTagsController extends Controller
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

        $this->sStorageDisk = 'public';
        $this->oStorage = Storage::disk($this->sStorageDisk);

        // Colocamos el valor en la variable $this->activeMenu 
        // para saber que item del menu de navegacion debe pintarse
        $this->activeMenu = '';
    }


    /**
     * Metodo para mostrar la lista de meta tags para el frontend del sistema
     * @Autor Raúl Chauvin
     * @FechaCreacion  2018/08/30
     *
     * @route /backend/parametrization/meta-tags/list
     * @method GET
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $metaTagsList = MetaTag::paginate(20);
        $data = [
            // Datos generales para todas las vistas
            'activeMenu' => $this->activeMenu,
            'oConfiguration' => $this->oConfiguration,

            // Datos especificos para utilizar en la vista
            'oStorage' => $this->oStorage,
            'metaTagsList' => $metaTagsList,
        ];
        $view = view('backend.parametrization.metatags.metaTagsList', $data);
        
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
     * Metodo para mostrar el formulario de creacion de nuevos meta tags en el sistema
     * @Autor Raúl Chauvin
     * @FechaCreacion  2018/08/30
     *
     * @route /backend/parametrization/meta-tags/add
     * @method GET
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $data = [
            // Datos generales para todas las vistas
            'activeMenu' => $this->activeMenu,
            'oConfiguration' => $this->oConfiguration,

            // Datos especificos para utilizar en la vista
            'oStorage' => $this->oStorage,
            'oMetaTag' => null,
        ];

        $view = view('backend.parametrization.metatags.addEditMetaTag', $data);
        
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
     * Metodo para guardar en la base de datos los nuevos meta tags ingresados desde el formulario
     * @Autor Raúl Chauvin
     * @FechaCreacion  2018/08/30
     *
     * @route /backend/parametrization/meta-tags/add
     * @method POST
     * @param  \BlaudCMS\Http\Requests\Parametrization\MetaTagCreateRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MetaTagCreateRequest $request)
    {

        if( ! $request->ajax() ){
            $request->session()->flash('errorMsg', 'Unicamente se aceptan peticiones Ajax');
            return back();
        }

        $oMetaTag = new MetaTag;
        $oMetaTag->name = $request->name;
        $oMetaTag->type = $request->type;
        $oMetaTag->value = $request->value;
        $oMetaTag->extra_attributes = $request->extra_attributes;

        if($oMetaTag->save()){
            return response()->json(['status' => true , 'message' => 'El meta tag '.$oMetaTag->name.' ha sido agregado exisotamente.',], 200);
        }else{
            return response()->json(['status' => false , 'message' => 'El meta tag '.$oMetaTag->name.' no pudo ser agregado. Por favor intentelo nuevamente luego de unos minutos',], 200);
        }
    }

    /**
     * Metodo para mostrar el formulario de edicion de un meta tag seleccionado previamente por su ID
     * @Autor Raúl Chauvin
     * @FechaCreacion  2018/08/30
     *
     * @route /backend/parametrization/meta-tags/edit
     * @method GET
     * @param  string $sId
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $sId = '')
    {
        if( ! $sId){
            if($request->ajax()){
                $aResponseData = [
                    'type' => 'alert', 
                    'title' => 'Meta Tags', 
                    'message' => 'Por favor seleccione un Meta Tag para poder editarlo.', 
                    'class' => 'error',
                ];
                return response()->json($aResponseData, 200);
            }
            $request->session()->flash('errorMsg', 'Por favor seleccione un Meta Tag para poder editarlo.');
            return back();
        }
        
        $oMetaTag = MetaTag::find($sId);

        if( ! is_object($oMetaTag)){
            if($request->ajax()){
                $aResponseData = [
                    'type' => 'alert', 
                    'title' => 'Meta Tags', 
                    'message' => 'El Meta Tag seleccionado no existe. Por favor seleccione otro.', 
                    'class' => 'error',
                ];
                return response()->json($aResponseData, 200);
            }
            $request->session()->flash('errorMsg', 'El Meta Tag seleccionado no existe. Por favor seleccione otro.');
            return back();   
        }

        $data = [
            // Datos generales para todas las vistas
            'activeMenu' => $this->activeMenu,
            'oConfiguration' => $this->oConfiguration,

            // Datos especificos para utilizar en la vista
            'oStorage' => $this->oStorage,
            'oMetaTag' => $oMetaTag,
        ];

        $view = view('backend.parametrization.metatags.addEditMetaTag', $data);

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
     * Metodo para guardar en la base de datos los cambios realizados a un meta tag previamente seleccionado por su ID desde el formulario
     * @Autor Raúl Chauvin
     * @FechaCreacion  2018/08/30
     *
     * @route /backend/parametrization/meta-tags/edit
     * @method PUT/PATCH
     *
     * @param  \BlaudCMS\Http\Requests\Parametrization\MetaTagUpdateRequest  $request
     * @param  string $sId
     * @return \Illuminate\Http\Response
     */
    public function update(MetaTagUpdateRequest $request, $sId = '')
    {
        if( ! $request->ajax() ){
            $request->session()->flash('errorMsg', 'Unicamente se aceptan peticiones Ajax');
            return back();
        }

        if( ! $sId){
            return response()->json(['status' => false , 'message' => 'Por favor seleccione un meta tag para poder editarlo.',], 200);
        }

        $oMetaTag = MetaTag::find($sId);
        
        if( ! is_object($oMetaTag)){
            return response()->json(['status' => false , 'message' => 'El meta tag seleccionado no existe. Por favor seleccione otro.',], 200);
        }

        $oMetaTag->name = $request->name;
        $oMetaTag->type = $request->type;
        $oMetaTag->value = $request->value;
        $oMetaTag->extra_attributes = $request->extra_attributes;

        if($oMetaTag->save()){
            return response()->json(['status' => true , 'message' => 'El meta tag '.$oMetaTag->name.' ha sido actualizado exisotamente.',], 200);
        }else{                    
            return response()->json(['status' => false , 'message' => 'El meta tag '.$oMetaTag->name.' no pudo ser actualizado. Por favor intentelo nuevamente luego de unos minutos',], 200);
        }
    }


    /**
     * Metodo para eliminar un meta tag seleccionado previamente por su ID
     * @Autor Raúl Chauvin
     * @FechaCreacion  2018/08/30
     *
     * @route /backend/parametrization/meta-tags/delete
     * @method DELETE
     * @param  \Illuminate\Http\Request  $request
     * @param  string $sId
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $sId = '')
    {
        if( ! $request->ajax() ){
            $request->session()->flash('errorMsg', 'Unicamente se aceptan peticiones Ajax');
            return back();
        }

        if( ! $sId){
            return response()->json(['status' => false , 'message' => 'Por favor seleccione un meta tag para poder eliminarlo.',], 200);
        }

        $oMetaTag = MetaTag::find($sId);
        
        if( ! is_object($oMetaTag)){
            return response()->json(['status' => false , 'message' => 'El meta tag seleccionado no existe. Por favor seleccione otro.',], 200);
        }

        if($oMetaTag->delete()){
            return response()->json(['status' => true , 'message' => 'El meta tag '.$oMetaTag->name.' ha sido eliminado exitosamente.',], 200);
        }else{
            return response()->json(['status' => false , 'message' => 'El meta tag '.$oMetaTag->name.' no pudo ser eliminado. Por favor intentelo nuevamente luego de unos minutos.',], 200);
        }
    }
}
