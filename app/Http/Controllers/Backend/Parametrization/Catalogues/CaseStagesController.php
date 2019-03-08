<?php

namespace BlaudCMS\Http\Controllers\Backend\Parametrization\Catalogues;

use Illuminate\Http\Request;
use BlaudCMS\Http\Controllers\Controller;
use BlaudCMS\Http\Traits\BackendAuthorizable;

use BlaudCMS\Configuration;
use BlaudCMS\Catalogue;
use BlaudCMS\User;

use BlaudCMS\Http\Requests\Parametrization\Catalogues\CaseStageCreateRequest;
use BlaudCMS\Http\Requests\Parametrization\Catalogues\CaseStageUpdateRequest;

use Storage;

use Auth;

/**
* Clase para administracion de etapas del caso
* @Autor Raúl Chauvin
* @FechaCreacion  2019/03/04
* @Parametrization
*/

class CaseStagesController extends Controller
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
     * Metodo para mostrar la lista de provincias
     * @Autor Raúl Chauvin
     * @FechaCreacion  2019/03/04
     *
     * @route /backend/parametrization/catalogues/case-stages/list
     * @method GET
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $caseStagesList = Catalogue::byContext('Etapa Actual del Caso')->orderBy('description', 'asc')->paginate(20);
        $data = [
            // Datos generales para todas las vistas
            'activeMenu' => $this->activeMenu,
            'oConfiguration' => $this->oConfiguration,

            // Datos especificos para utilizar en la vista
            'oStorage' => $this->oStorage,
            'caseStagesList' => $caseStagesList,
        ];
        $view = view('backend.parametrization.catalogues.case-stages.caseStagesList', $data);
        
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
     * Metodo para mostrar el formulario de creacion de nuevas etapas del caso
     * @Autor Raúl Chauvin
     * @FechaCreacion  2019/03/03
     *
     * @route /backend/parametrization/catalogues/case-stages/add
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
            'oCaseStage' => null,
        ];

        $view = view('backend.parametrization.catalogues.case-stages.addEditCaseStage', $data);
        
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
     * Metodo para guardar en la base de datos las nuevas etapas del caso ingresadas desde el formulario
     * @Autor Raúl Chauvin
     * @FechaCreacion  2019/03/03
     *
     * @route /backend/parametrization/catalogues/case-stages/add
     * @method POST
     * @param  \BlaudCMS\Http\Requests\Parametrization\Catalogues\CaseStageCreateRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CaseStageCreateRequest $request)
    {

        if( ! $request->ajax() ){
            $request->session()->flash('errorMsg', 'Unicamente se aceptan peticiones Ajax');
            return back();
        }

        $oCaseStage = new Catalogue;
        $oCaseStage->context = 'Etapa Actual del Caso';
        $oCaseStage->description = $request->description;

        if($oCaseStage->save()){
            return response()->json(['status' => true , 'message' => 'La etapa del caso '.$oCaseStage->description.' ha sido agregada exisotamente.',], 200);
        }else{
            return response()->json(['status' => false , 'message' => 'La etapa del caso '.$oCaseStage->description.' no pudo ser agregada. Por favor intentelo nuevamente luego de unos minutos',], 200);
        }
    }

    /**
     * Metodo para mostrar el formulario de edicion de una etapa del caso seleccionada previamente por su ID
     * @Autor Raúl Chauvin
     * @FechaCreacion  2019/03/03
     *
     * @route /backend/parametrization/catalogues/case-stages/edit
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
                    'title' => 'Etapas del Caso', 
                    'message' => 'Por favor seleccione una etapa del caso para poder editarla.', 
                    'class' => 'error',
                ];
                return response()->json($aResponseData, 200);
            }
            $request->session()->flash('errorMsg', 'Por favor seleccione una etapa del caso para poder editarla.');
            return back();
        }
        
        $oCaseStage = Catalogue::find($sId);

        if( ! is_object($oCaseStage)){
            if($request->ajax()){
                $aResponseData = [
                    'type' => 'alert', 
                    'title' => 'Etapas del Caso', 
                    'message' => 'La Etapa del caso seleccionada no existe. Por favor seleccione otra.', 
                    'class' => 'error',
                ];
                return response()->json($aResponseData, 200);
            }
            $request->session()->flash('errorMsg', 'La Etapa del caso seleccionada no existe. Por favor seleccione otra.');
            return back();   
        }

        $data = [
            // Datos generales para todas las vistas
            'activeMenu' => $this->activeMenu,
            'oConfiguration' => $this->oConfiguration,

            // Datos especificos para utilizar en la vista
            'oStorage' => $this->oStorage,
            'oCaseStage' => $oCaseStage,
        ];

        $view = view('backend.parametrization.catalogues.case-stages.addEditCaseStage', $data);

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
     * Metodo para guardar en la base de datos los cambios realizados a una etapa del caso previamente seleccionada por su ID desde el formulario
     * @Autor Raúl Chauvin
     * @FechaCreacion  2019/03/03
     *
     * @route /backend/parametrization/catalogues/case-stages/edit
     * @method PUT/PATCH
     *
     * @param  \BlaudCMS\Http\Requests\Parametrization\Catalogues\CaseStageUpdateRequest  $request
     * @param  string $sId
     * @return \Illuminate\Http\Response
     */
    public function update(CaseStageUpdateRequest $request, $sId = '')
    {
        if( ! $request->ajax() ){
            $request->session()->flash('errorMsg', 'Unicamente se aceptan peticiones Ajax');
            return back();
        }

        if( ! $sId){
            return response()->json(['status' => false , 'message' => 'Por favor seleccione una etapa del caso para poder editarla.',], 200);
        }

        $oCaseStage = Catalogue::find($sId);
        
        if( ! is_object($oCaseStage)){
            return response()->json(['status' => false , 'message' => 'La etapa del caso seleccionada no existe. Por favor seleccione otra.',], 200);
        }

        $oCaseStage->context = 'Etapa Actual del Caso';
        $oCaseStage->description = $request->description;

        if($oCaseStage->save()){
            return response()->json(['status' => true , 'message' => 'La etapa del caso '.$oCaseStage->description.' ha sido actualizada exisotamente.',], 200);
        }else{
            return response()->json(['status' => false , 'message' => 'La etapa del caso '.$oCaseStage->description.' no pudo ser actualizada. Por favor intentelo nuevamente luego de unos minutos',], 200);
        }
    }


    /**
     * Metodo para eliminar una etapa del caso seleccionada previamente por su ID
     * @Autor Raúl Chauvin
     * @FechaCreacion  2019/03/03
     *
     * @route /backend/parametrization/catalogues/case-stages/delete
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
            return response()->json(['status' => false , 'message' => 'Por favor seleccione una etapa del caso para poder eliminarla.',], 200);
        }

        $oCaseStage = Catalogue::find($sId);
        
        if( ! is_object($oCaseStage)){
            return response()->json(['status' => false , 'message' => 'La etapa del caso seleccionada no existe. Por favor seleccione otra.',], 200);
        }

        $hasCaseStageDetails = $oCaseStage->childrenCatalogs;

        if($hasCaseStageDetails->isNotEmpty()){
        	return response()->json(['status' => false , 'message' => 'La etapa del caso '.$oCaseStage->description.' no pudo ser eliminada debido a que tiene detalles de etapa asignados a la misma.',], 200);
        }

        if($oCaseStage->delete()){
            return response()->json(['status' => true , 'message' => 'La etapa del caso '.$oCaseStage->description.' ha sido eliminada exitosamente.',], 200);
        }else{
            return response()->json(['status' => false , 'message' => 'La etapa del caso '.$oCaseStage->description.' no pudo ser eliminada. Por favor intentelo nuevamente luego de unos minutos.',], 200);
        }
    }
}
