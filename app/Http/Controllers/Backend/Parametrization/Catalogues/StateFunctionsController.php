<?php

namespace BlaudCMS\Http\Controllers\Backend\Parametrization\Catalogues;

use Illuminate\Http\Request;
use BlaudCMS\Http\Controllers\Controller;
use BlaudCMS\Http\Traits\BackendAuthorizable;

use BlaudCMS\Configuration;
use BlaudCMS\Catalogue;
use BlaudCMS\User;

use BlaudCMS\Http\Requests\Parametrization\Catalogues\StateFunctionCreateRequest;
use BlaudCMS\Http\Requests\Parametrization\Catalogues\StateFunctionUpdateRequest;

use Storage;

use Auth;

/**
* Clase para administracion de funciones del estado
* @Autor Raúl Chauvin
* @FechaCreacion  2019/03/04
* @Parametrization
*/

class StateFunctionsController extends Controller
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
        $this->activeMenu = 'Catalogues';
    }


    /**
     * Metodo para mostrar la lista de funciones del estado
     * @Autor Raúl Chauvin
     * @FechaCreacion  2019/03/04
     *
     * @route /backend/parametrization/catalogues/state-functions/list
     * @method GET
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $stateFunctionsList = Catalogue::byContext('Función del Estado')->orderBy('description', 'asc')->paginate(20);
        $data = [
            // Datos generales para todas las vistas
            'activeMenu' => $this->activeMenu,
            'oConfiguration' => $this->oConfiguration,

            // Datos especificos para utilizar en la vista
            'oStorage' => $this->oStorage,
            'stateFunctionsList' => $stateFunctionsList,
        ];
        $view = view('backend.parametrization.catalogues.state-functions.stateFunctionsList', $data);
        
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
     * Metodo para mostrar el formulario de creacion de nuevas funciones del estado
     * @Autor Raúl Chauvin
     * @FechaCreacion  2019/03/03
     *
     * @route /backend/parametrization/catalogues/state-functions/add
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
            'oStateFunction' => null,
        ];

        $view = view('backend.parametrization.catalogues.state-functions.addEditStateFunction', $data);
        
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
     * Metodo para guardar en la base de datos las nuevas funciones del estado ingresadas desde el formulario
     * @Autor Raúl Chauvin
     * @FechaCreacion  2019/03/03
     *
     * @route /backend/parametrization/catalogues/state-functions/add
     * @method POST
     * @param  \BlaudCMS\Http\Requests\Parametrization\Catalogues\StateFunctionCreateRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StateFunctionCreateRequest $request)
    {

        if( ! $request->ajax() ){
            $request->session()->flash('errorMsg', 'Unicamente se aceptan peticiones Ajax');
            return back();
        }

        $oStateFunction = new Catalogue;
        $oStateFunction->context = 'Función del Estado';
        $oStateFunction->description = $request->description;

        if($oStateFunction->save()){
            return response()->json(['status' => true , 'message' => 'La función del estado '.$oStateFunction->description.' ha sido agregada exisotamente.',], 200);
        }else{
            return response()->json(['status' => false , 'message' => 'La función del estado '.$oStateFunction->description.' no pudo ser agregada. Por favor intentelo nuevamente luego de unos minutos',], 200);
        }
    }

    /**
     * Metodo para mostrar el formulario de edicion de una funcion del estado seleccionada previamente por su ID
     * @Autor Raúl Chauvin
     * @FechaCreacion  2019/03/03
     *
     * @route /backend/parametrization/catalogues/state-function/edit
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
                    'title' => 'Función del Estado', 
                    'message' => 'Por favor seleccione una funcion del estado para poder editarla.', 
                    'class' => 'error',
                ];
                return response()->json($aResponseData, 200);
            }
            $request->session()->flash('errorMsg', 'Por favor seleccione una funcion del estado para poder editarla.');
            return back();
        }
        
        $oStateFunction = Catalogue::find($sId);

        if( ! is_object($oStateFunction)){
            if($request->ajax()){
                $aResponseData = [
                    'type' => 'alert', 
                    'title' => 'Función del Estado', 
                    'message' => 'La función del estado seleccionada no existe. Por favor seleccione otra.', 
                    'class' => 'error',
                ];
                return response()->json($aResponseData, 200);
            }
            $request->session()->flash('errorMsg', 'La función del estado seleccionada no existe. Por favor seleccione otra.');
            return back();   
        }

        $data = [
            // Datos generales para todas las vistas
            'activeMenu' => $this->activeMenu,
            'oConfiguration' => $this->oConfiguration,

            // Datos especificos para utilizar en la vista
            'oStorage' => $this->oStorage,
            'oStateFunction' => $oStateFunction,
        ];

        $view = view('backend.parametrization.catalogues.state-functions.addEditStateFunction', $data);

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
     * Metodo para guardar en la base de datos los cambios realizados a una funcion del estado previamente seleccionada por su ID desde el formulario
     * @Autor Raúl Chauvin
     * @FechaCreacion  2019/03/03
     *
     * @route /backend/parametrization/catalogues/state-functions/edit
     * @method PUT/PATCH
     *
     * @param  \BlaudCMS\Http\Requests\Parametrization\Catalogues\StateFunctionUpdateRequest  $request
     * @param  string $sId
     * @return \Illuminate\Http\Response
     */
    public function update(StateFunctionUpdateRequest $request, $sId = '')
    {
        if( ! $request->ajax() ){
            $request->session()->flash('errorMsg', 'Unicamente se aceptan peticiones Ajax');
            return back();
        }

        if( ! $sId){
            return response()->json(['status' => false , 'message' => 'Por favor seleccione una función del estado para poder editarla.',], 200);
        }

        $oStateFunction = Catalogue::find($sId);
        
        if( ! is_object($oStateFunction)){
            return response()->json(['status' => false , 'message' => 'La función del estado seleccionada no existe. Por favor seleccione otra.',], 200);
        }

        $oStateFunction->context = 'Función del Estado';
        $oStateFunction->description = $request->description;

        if($oStateFunction->save()){
            return response()->json(['status' => true , 'message' => 'La función del estado '.$oStateFunction->description.' ha sido actualizada exisotamente.',], 200);
        }else{
            return response()->json(['status' => false , 'message' => 'La función del estado '.$oStateFunction->description.' no pudo ser actualizada. Por favor intentelo nuevamente luego de unos minutos',], 200);
        }
    }


    /**
     * Metodo para eliminar una funcion del estado seleccionada previamente por su ID
     * @Autor Raúl Chauvin
     * @FechaCreacion  2019/03/03
     *
     * @route /backend/parametrization/catalogues/state-functions/delete
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
            return response()->json(['status' => false , 'message' => 'Por favor seleccione una función del estado para poder eliminarla.',], 200);
        }

        $oStateFunction = Catalogue::find($sId);
        
        if( ! is_object($oStateFunction)){
            return response()->json(['status' => false , 'message' => 'La función del estado seleccionada no existe. Por favor seleccione otra.',], 200);
        }

        if($oStateFunction->delete()){
            return response()->json(['status' => true , 'message' => 'La función del estado '.$oStateFunction->description.' ha sido eliminada exitosamente.',], 200);
        }else{
            return response()->json(['status' => false , 'message' => 'La función del estado '.$oStateFunction->description.' no pudo ser eliminada. Por favor intentelo nuevamente luego de unos minutos.',], 200);
        }
    }
}
