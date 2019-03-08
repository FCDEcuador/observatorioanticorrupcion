<?php

namespace BlaudCMS\Http\Controllers\Backend\Parametrization\Catalogues;

use Illuminate\Http\Request;
use BlaudCMS\Http\Controllers\Controller;
use BlaudCMS\Http\Traits\BackendAuthorizable;

use BlaudCMS\Configuration;
use BlaudCMS\Catalogue;
use BlaudCMS\User;

use BlaudCMS\Http\Requests\Parametrization\Catalogues\CaseStageDetailCreateRequest;
use BlaudCMS\Http\Requests\Parametrization\Catalogues\CaseStageDetailUpdateRequest;

use Storage;

use Auth;

/**
* Clase para administracion de detalles de etapas del caso
* @Autor Raúl Chauvin
* @FechaCreacion  2019/03/04
* @Parametrization
*/

class CaseStagesDetailController extends Controller
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
        $caseStageDetailsList = Catalogue::byContext('Detalle sobre la Etapa')->orderBy('description', 'asc')->paginate(20);
        $data = [
            // Datos generales para todas las vistas
            'activeMenu' => $this->activeMenu,
            'oConfiguration' => $this->oConfiguration,

            // Datos especificos para utilizar en la vista
            'oStorage' => $this->oStorage,
            'caseStageDetailsList' => $caseStageDetailsList,
        ];
        $view = view('backend.parametrization.catalogues.case-stage-details.caseStageDetailsList', $data);
        
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
     * Metodo para mostrar el formulario de creacion de nuevos detalles de etapas del caso
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
            'aCaseStageList' => Catalogue::byContext('Etapa Actual del Caso')->orderBy('description', 'asc')->pluck('description', 'id'),
            'oCaseStageDetail' => null,
        ];

        $view = view('backend.parametrization.catalogues.case-stage-details.addEditCaseStageDetail', $data);
        
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
     * Metodo para guardar en la base de datos las nuevos detalles de  etapas del caso ingresadas desde el formulario
     * @Autor Raúl Chauvin
     * @FechaCreacion  2019/03/03
     *
     * @route /backend/parametrization/catalogues/case-stage-details/add
     * @method POST
     * @param  \BlaudCMS\Http\Requests\Parametrization\Catalogues\CaseStageDetailCreateRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CaseStageDetailCreateRequest $request)
    {

        if( ! $request->ajax() ){
            $request->session()->flash('errorMsg', 'Unicamente se aceptan peticiones Ajax');
            return back();
        }

        $oCaseStageDetail = new Catalogue;
        $oCaseStageDetail->context = 'Detalle sobre la Etapa';
        $oCaseStageDetail->description = $request->description;
        $oCaseStageDetail->catalogue_id = $request->catalogue_id;

        if($oCaseStageDetail->save()){
            return response()->json(['status' => true , 'message' => 'El detalle de la etapa del caso '.$oCaseStageDetail->description.' ha sido agregada exisotamente.',], 200);
        }else{
            return response()->json(['status' => false , 'message' => 'El detalle de la etapa del caso '.$oCaseStageDetail->description.' no pudo ser agregada. Por favor intentelo nuevamente luego de unos minutos',], 200);
        }
    }

    /**
     * Metodo para mostrar el formulario de edicion de un detalle de etapa del caso seleccionada previamente por su ID
     * @Autor Raúl Chauvin
     * @FechaCreacion  2019/03/03
     *
     * @route /backend/parametrization/catalogues/case-stage-details/edit
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
                    'title' => 'Detalle sobre la Etapa', 
                    'message' => 'Por favor seleccione un detalle de etapa del caso para poder editarlo.', 
                    'class' => 'error',
                ];
                return response()->json($aResponseData, 200);
            }
            $request->session()->flash('errorMsg', 'Por favor seleccione un detalle de etapa del caso para poder editarlo.');
            return back();
        }
        
        $oCaseStageDetail = Catalogue::find($sId);

        if( ! is_object($oCaseStageDetail)){
            if($request->ajax()){
                $aResponseData = [
                    'type' => 'alert', 
                    'title' => 'Detalle sobre la Etapa', 
                    'message' => 'El detalle de Etapa del caso seleccionado no existe. Por favor seleccione otro.', 
                    'class' => 'error',
                ];
                return response()->json($aResponseData, 200);
            }
            $request->session()->flash('errorMsg', 'El detalle de Etapa del caso seleccionada no existe. Por favor seleccione otro.');
            return back();   
        }

        $data = [
            // Datos generales para todas las vistas
            'activeMenu' => $this->activeMenu,
            'oConfiguration' => $this->oConfiguration,

            // Datos especificos para utilizar en la vista
            'oStorage' => $this->oStorage,
            'aCaseStageList' => Catalogue::byContext('Etapa Actual del Caso')->orderBy('description', 'asc')->pluck('description', 'id'),
            'oCaseStageDetail' => $oCaseStageDetail,
        ];

        $view = view('backend.parametrization.catalogues.case-stage-details.addEditCaseStageDetail', $data);

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
     * @route /backend/parametrization/catalogues/case-stage-details/edit
     * @method PUT/PATCH
     *
     * @param  \BlaudCMS\Http\Requests\Parametrization\Catalogues\CaseStageDetailUpdateRequest  $request
     * @param  string $sId
     * @return \Illuminate\Http\Response
     */
    public function update(CaseStageDetailUpdateRequest $request, $sId = '')
    {
        if( ! $request->ajax() ){
            $request->session()->flash('errorMsg', 'Unicamente se aceptan peticiones Ajax');
            return back();
        }

        if( ! $sId){
            return response()->json(['status' => false , 'message' => 'Por favor seleccione un detalle de etapa del caso para poder editarlo.',], 200);
        }

        $oCaseStageDetail = Catalogue::find($sId);
        
        if( ! is_object($oCaseStageDetail)){
            return response()->json(['status' => false , 'message' => 'El detalle de etapa del caso seleccionado no existe. Por favor seleccione otro.',], 200);
        }

        $oCaseStageDetail->context = 'Detalle sobre la Etapa';
        $oCaseStageDetail->description = $request->description;
        $oCaseStageDetail->catalogue_id = $request->catalogue_id;

        if($oCaseStageDetail->save()){
            return response()->json(['status' => true , 'message' => 'El detalle de etapa del caso '.$oCaseStageDetail->description.' ha sido actualizada exisotamente.',], 200);
        }else{
            return response()->json(['status' => false , 'message' => 'El detalle de etapa del caso '.$oCaseStageDetail->description.' no pudo ser actualizada. Por favor intentelo nuevamente luego de unos minutos',], 200);
        }
    }


    /**
     * Metodo para eliminar un detalle de etapa del caso seleccionada previamente por su ID
     * @Autor Raúl Chauvin
     * @FechaCreacion  2019/03/03
     *
     * @route /backend/parametrization/catalogues/case-stage-details/delete
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
            return response()->json(['status' => false , 'message' => 'Por favor seleccione un detalle de etapa del caso para poder eliminarlo.',], 200);
        }

        $oCaseStageDetail = Catalogue::find($sId);
        
        if( ! is_object($oCaseStageDetail)){
            return response()->json(['status' => false , 'message' => 'El detalle de etapa del caso seleccionada no existe. Por favor seleccione otra.',], 200);
        }

        if($oCaseStageDetail->delete()){
            return response()->json(['status' => true , 'message' => 'El detalle de etapa del caso '.$oCaseStageDetail->description.' ha sido eliminado exitosamente.',], 200);
        }else{
            return response()->json(['status' => false , 'message' => 'El detalle de etapa del caso '.$oCaseStageDetail->description.' no pudo ser eliminado. Por favor intentelo nuevamente luego de unos minutos.',], 200);
        }
    }
}
