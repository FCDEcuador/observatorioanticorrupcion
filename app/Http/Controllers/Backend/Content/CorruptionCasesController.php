<?php

namespace BlaudCMS\Http\Controllers\Backend\Content;

use Illuminate\Http\Request;
use BlaudCMS\Http\Controllers\Controller;
use BlaudCMS\Http\Traits\BackendAuthorizable;

use BlaudCMS\Helpers\TimeFormat;

use BlaudCMS\Configuration;
use BlaudCMS\Role;
use BlaudCMS\Permission;
use BlaudCMS\User;
use BlaudCMS\Catalogue;
use BlaudCMS\CorruptionCase;
use BlaudCMS\WhatHappened;

use Cocur\Slugify\Slugify;

use BlaudCMS\Http\Requests\Content\CorruptionCaseCreateRequest;
use BlaudCMS\Http\Requests\Content\CorruptionCaseUpdateRequest;

use Storage;
use Auth;

/**
* Clase para manejo de casos de corrupcion del portal web
* @Autor Raúl Chauvin
* @FechaCreacion  2018/08/30
* @Parametrization
*/

class CorruptionCasesController extends Controller
{
    use BackendAuthorizable;

    /**
     * Variable para manejo de slugs al momento de guardar informacion.
     *
     * @var oSlugify
     */
    private $oSlugify;

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

        $this->oSlugify = new Slugify();

        $this->sStorageDisk = config('app.env') == 'production' ? 's3' : 'local';
        $this->oStorage = config('app.env') == 'production' ? Storage::disk('s3') : Storage::disk('local');

        // Colocamos el valor en la variable $this->activeMenu 
        // para saber que item del menu de navegacion debe pintarse
        $this->activeMenu = 'Content';
    }

    /**
     * Metodo para mostrar la lista de casos de corrupcion del sistema
     * @Autor Raúl Chauvin
     * @FechaCreacion  2018/11/21
     *
     * @route /backend/content/corruption-cases/list
     * @method GET / POST
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $corruptionCasesList = CorruptionCase::searchCorruptionCasess(
													$request->sStringSearch, 
													$request->sCaseStage, 
													$request->sCaseStageDetail, 
													$request->sProvince, 
													$request->sStateFunctionrequest, 
													20
												);
        $data = [
            'activeMenu' => $this->activeMenu,
            'oConfiguration' => $this->oConfiguration,

            // Datos especificos para utilizar en la vista
            'oStorage' => $this->oStorage,
            'corruptionCasesList' => $corruptionCasesList,
        ];
        $view = view('backend.content.corruption-cases.corruptionCasesList', $data);
        
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
     * Metodo para mostrar el formulario de creacion de nuevos casos de corrupcion en el sistema
     * @Autor Raúl Chauvin
     * @FechaCreacion  2018/12/27
     *
     * @route /backend/content/corruption-cases/add
     * @method GET
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $aCaseStages = Catalogue::byContext('Etapa Actual del Caso')->get();
        $aProvinces = Catalogue::byContext('Provincias')->get();
        $aStateFunctions = Catalogue::byContext('Función del Estado')->get();
        $aInstitutions = Catalogue::byContext('Instituciones')->get();
        $aOfficials = Catalogue::byContext('Funcionarios')->get();
        
        $data = [
            'activeMenu' => $this->activeMenu,
            'oConfiguration' => $this->oConfiguration,

            // Datos especificos para utilizar en la vista
            'oStorage' => $this->oStorage,
            'env' => config('app.env'),
            'oCorruptionCase' => null,
            'aCaseStages' => $aCaseStages,
            'aProvinces' => $aProvinces,
            'aStateFunctions' => $aStateFunctions,
            'aInstitutions' => $aInstitutions,
            'aOfficials' => $aOfficials,
        ];
        
        $view = view('backend.content.corruption-cases.addEditCorruptionCase', $data);
        
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
     * @route /backend/content/corruption-cases/case-stage-details
     * @method GET
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string $sCaseStageDescription
     * @return \Illuminate\Http\Response
     */
    public function caseStageDetails(Request $request, $sCaseStageDescription = ''){
        if($request->ajax()){
            $aCaseStageDetails = [];
            if($sCaseStageDescription){
                $oCaseStage = Catalogue::byContext('Etapa Actual del Caso')->where('description', $sCaseStageDescription)->first();
                if(is_object($oCaseStage)){
                	$aCaseStageDetails = $oCaseStage->childrenCatalogs;
                }
            }
            return response()->json($aCaseStageDetails, 200);
        }
        return response()->json(['Ups! Unicamente se aceptan peticiones ajax.'], 201);
    }


    /**
     * Metodo para guardar en la BD los datos del Caso de Corrupción ingresados desde el formulario
     * @Autor Raúl Chauvin
     * @FechaCreacion  2019/01/02
     *
     * @route /backend/content/corruption-cases/add
     * @method POST
     * @param  \Illuminate\Http\Requests\CorruptionCaseCreateRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CorruptionCaseCreateRequest $request)
    {
        if( ! $request->ajax() ){
            $request->session()->flash('errorMsg', 'Unicamente se aceptan peticiones Ajax');
            return back();
        }

        $oCorruptionCase = new CorruptionCase;
        $oCorruptionCase->case_stage = $request->case_stage;
        $oCorruptionCase->case_stage_detail = $request->case_stage_detail;
        $oCorruptionCase->province = $request->province;
        $oCorruptionCase->state_function = $request->state_function;
        $oCorruptionCase->tags = explode(',', $request->tags);
        $oCorruptionCase->involved_number = $request->involved_number;
        $oCorruptionCase->linked_institutions = $request->linked_institutions;
        $oCorruptionCase->public_officials_involved = $request->public_officials_involved;
        $oCorruptionCase->title = $request->title;
        $oCorruptionCase->slug = $this->oSlugify->slugify($request->title);
        $oCorruptionCase->summary = $request->summary;
        $oCorruptionCase->history = $request->history;
        $oCorruptionCase->legal_causes = $request->legal_causes;
        $oCorruptionCase->political_causes = $request->political_causes;
        $oCorruptionCase->consequences_introduction = $request->consequences_introduction;
        $oCorruptionCase->consequences_title = $request->consequences_title;
        //$oCorruptionCase->consequences_description = $request->consequences_description;
        $oCorruptionCase->economic_consequences = $request->economic_consequences;
        $oCorruptionCase->social_consequences = $request->social_consequences;
        $oCorruptionCase->sources = $request->sources;
        
        if($request->hasFile('main_multimedia')){
            $main_multimedia = $request->file('main_multimedia');
            $name = $main_multimedia->getClientOriginalName();
            $path = $main_multimedia->storePubliclyAs('corruption-cases/main',$name, ['disk' => $this->sStorageDisk]);
            $oCorruptionCase->main_multimedia = $path;
        }

        if($request->hasFile('home_image')){
            $home_image = $request->file('home_image');
            $name = $home_image->getClientOriginalName();
            $path = $home_image->storePubliclyAs('corruption-cases/home',$name, ['disk' => $this->sStorageDisk]);
            $oCorruptionCase->home_image = $path;
        }

        if($request->hasFile('history_image')){
            $history_image = $request->file('history_image');
            $name = $history_image->getClientOriginalName();
            $path = $history_image->storePubliclyAs('corruption-cases/history',$name, ['disk' => $this->sStorageDisk]);
            $oCorruptionCase->history_image = $path;
        }
        
        if($request->hasFile('consequences_image')){
            $consequences_image = $request->file('consequences_image');
            $name = $consequences_image->getClientOriginalName();
            $path = $consequences_image->storePubliclyAs('corruption-cases/consequences',$name, ['disk' => $this->sStorageDisk]);
            $oCorruptionCase->consequences_image = $path;
        }

        if($oCorruptionCase->save()){
            if(count($request->description)){
            	foreach($request->year as $key => $value){
            		$order = $key+1;
            		$oWhatHappened = new WhatHappened;
            		$oWhatHappened->year = $request->year[$key];
			        $oWhatHappened->month = $request->month[$key];
			        $oWhatHappened->day = $request->day[$key];
			        $oWhatHappened->description = $request->description[$key];
			        $oWhatHappened->order = $order;
			        $oWhatHappened->corruption_case_id = $oCorruptionCase->id;
			        $oWhatHappened->save();
            	}
            }
            return response()->json(['status' => true , 'message' => 'El Caso de Corrupción '.$oCorruptionCase->title.' ha sido agregado exisotamente.',], 200);
        }else{
            return response()->json(['status' => false , 'message' => 'El Caso de Corrupción '.$oCorruptionCase->title.' no pudo ser agregado. Por favor intentelo nuevamente luego de unos minutos',], 200);
        }
    }

    /**
     * Metodo para mostrar el formulario de edicion de un Caso de Corrupcion de acuerdo a su ID
     * @Autor Raúl Chauvin
     * @FechaCreacion  2019/01/02
     *
     * @route /backend/content/corruption-cases/edit
     * @method GET
     * @param  string  $sCorruptionCaseId
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $sCorruptionCaseId = '')
    {
        if( ! $sCorruptionCaseId){
            if($request->ajax()){
                $aResponseData = [
                    'type' => 'alert', 
                    'title' => 'Casos de Corrupción', 
                    'message' => 'Por favor seleccione un Caso de Corrupción para poder editarlo.', 
                    'class' => 'error',
                ];
                return response()->json($aResponseData, 200);
            }
            $request->session()->flash('errorMsg', 'Por favor seleccione un Caso de Corrupción para poder editarlo.');
            return back();
        }

        $oCorruptionCase = CorruptionCase::find($sCorruptionCaseId);
        
        if( ! is_object($oCorruptionCase)){
            if($request->ajax()){
                $aResponseData = [
                    'type' => 'alert', 
                    'title' => 'Usuarios', 
                    'message' => 'El Caso de Corrupción que usted a seleccionado no existe, por favor seleccione otro.', 
                    'class' => 'error',
                ];
                return response()->json($aResponseData, 200);
            }
            $request->session()->flash('errorMsg', 'El Caso de Corrupción que usted a seleccionado no existe, por favor seleccione otro.');
            return back();    
        }

        $aCaseStages = Catalogue::byContext('Etapa Actual del Caso')->get();
        $aProvinces = Catalogue::byContext('Provincias')->get();
        $aStateFunctions = Catalogue::byContext('Función del Estado')->get();
        $aInstitutions = Catalogue::byContext('Instituciones')->get();
        $aOfficials = Catalogue::byContext('Funcionarios')->get();
        
        $data = [
            'activeMenu' => $this->activeMenu,
            'oConfiguration' => $this->oConfiguration,

            // Datos especificos para utilizar en la vista
            'oStorage' => $this->oStorage,
            'env' => config('app.env'),
            'oCorruptionCase' => $oCorruptionCase,
            'aCaseStages' => $aCaseStages,
            'aProvinces' => $aProvinces,
            'aStateFunctions' => $aStateFunctions,
            'aInstitutions' => $aInstitutions,
            'aOfficials' => $aOfficials,
        ];
        
        $view = view('backend.content.corruption-cases.addEditCorruptionCase', $data);
        
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
     * Metodo para actualizar en la BD los datos del Caso de Corrupción de acuerdo a su ID ingresados desde el formulario de edicion
     * @Autor Raúl Chauvin
     * @FechaCreacion  2019/01/02
     *
     * @route /backend/content/corruption-cases/edit
     * @method PUT / PATCH
     * @param  string  $sCorruptionCaseId
     * @param  \Illuminate\Http\Requests\CorruptionCaseUpdateRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function update(CorruptionCaseUpdateRequest $request, $sCorruptionCaseId = '')
    {
        if( ! $request->ajax() ){
            $request->session()->flash('errorMsg', 'Unicamente se aceptan peticiones Ajax');
            return back();
        }

        if( ! $sCorruptionCaseId){
            return response()->json(['status' => false , 'message' => 'Por favor seleccione un Caso de Corrupción para poder editarlo.',], 200);
        }

        $oCorruptionCase = CorruptionCase::find($sCorruptionCaseId);
        
        if( ! is_object($oCorruptionCase)){
            return response()->json(['status' => false , 'message' => 'El Caso de Corrupción que usted a seleccionado no existe, por favor seleccione otro.',], 200);    
        }

        $oCorruptionCase->case_stage = $request->case_stage;
        $oCorruptionCase->case_stage_detail = $request->case_stage_detail;
        $oCorruptionCase->province = $request->province;
        $oCorruptionCase->state_function = $request->state_function;
        $oCorruptionCase->tags = explode(',', $request->tags);
        $oCorruptionCase->involved_number = $request->involved_number;
        $oCorruptionCase->linked_institutions = $request->linked_institutions;
        $oCorruptionCase->public_officials_involved = $request->public_officials_involved;
        $oCorruptionCase->title = $request->title;
        $oCorruptionCase->slug = $this->oSlugify->slugify($request->title);
        $oCorruptionCase->summary = $request->summary;
        $oCorruptionCase->history = $request->history;
        $oCorruptionCase->legal_causes = $request->legal_causes;
        $oCorruptionCase->political_causes = $request->political_causes;
        $oCorruptionCase->consequences_introduction = $request->consequences_introduction;
        $oCorruptionCase->consequences_title = $request->consequences_title;
        //$oCorruptionCase->consequences_description = $request->consequences_description;
        $oCorruptionCase->economic_consequences = $request->economic_consequences;
        $oCorruptionCase->social_consequences = $request->social_consequences;
        $oCorruptionCase->sources = $request->sources;
        
        $oldMainMultimedia = $oCorruptionCase->main_multimedia;
        if($request->hasFile('main_multimedia')){
            $main_multimedia = $request->file('main_multimedia');
            $name = $main_multimedia->getClientOriginalName();
            $path = $main_multimedia->storePubliclyAs('corruption-cases/main',$name, ['disk' => $this->sStorageDisk]);
            $oCorruptionCase->main_multimedia = $path;
        }

        $oldHomeImage = $oCorruptionCase->home_image;
        if($request->hasFile('home_image')){
            $home_image = $request->file('home_image');
            $name = $home_image->getClientOriginalName();
            $path = $home_image->storePubliclyAs('corruption-cases/home',$name, ['disk' => $this->sStorageDisk]);
            $oCorruptionCase->home_image = $path;
        }

        $oldHistoryImage = $oCorruptionCase->history_image;
        if($request->hasFile('history_image')){
            $history_image = $request->file('history_image');
            $name = $history_image->getClientOriginalName();
            $path = $history_image->storePubliclyAs('corruption-cases/history',$name, ['disk' => $this->sStorageDisk]);
            $oCorruptionCase->history_image = $path;
        }
        
        $oldConsequencesImage = $oCorruptionCase->consequences_image;
        if($request->hasFile('consequences_image')){
            $consequences_image = $request->file('consequences_image');
            $name = $consequences_image->getClientOriginalName();
            $path = $consequences_image->storePubliclyAs('corruption-cases/consequences',$name, ['disk' => $this->sStorageDisk]);
            $oCorruptionCase->consequences_image = $path;
        }

        if($oCorruptionCase->save()){
            $oCorruptionCase->whatsHappeneds()->delete();
            if(count($request->description)){
            	foreach($request->year as $key => $value){
            		$order = $key+1;
            		$oWhatHappened = new WhatHappened;
            		$oWhatHappened->year = $request->year[$key];
			        $oWhatHappened->month = $request->month[$key];
			        $oWhatHappened->day = $request->day[$key];
			        $oWhatHappened->description = $request->description[$key];
			        $oWhatHappened->order = $order;
			        $oWhatHappened->corruption_case_id = $oCorruptionCase->id;
			        $oWhatHappened->save();
            	}
            }
            if($oldMainMultimedia != $oCorruptionCase->main_multimedia){
                $this->oStorage->delete($oldMainMultimedia);
            }
            if($oldHomeImage != $oCorruptionCase->home_image){
                $this->oStorage->delete($oldHomeImage);
            }
            if($oldHistoryImage != $oCorruptionCase->history_image){
                $this->oStorage->delete($oldHistoryImage);
            }
            if($oldConsequencesImage != $oCorruptionCase->consequences_image){
                $this->oStorage->delete($oldConsequencesImage);
            }
            return response()->json(['status' => true , 'message' => 'El Caso de Corrupción '.$oCorruptionCase->title.' ha sido actualizado exisotamente.',], 200);
        }else{
            return response()->json(['status' => false , 'message' => 'El Caso de Corrupción '.$oCorruptionCase->title.' no pudo ser actualizado. Por favor intentelo nuevamente luego de unos minutos',], 200);
        }

        
    }


    /**
     * Metodo para eliminar un Caso de Corrupcion del sistema de acuerdo a su ID
     * @Autor Raúl Chauvin
     * @FechaCreacion  2019/01/02
     *
     * @route /backend/content/corruption-cases/edit
     * @method DELETE
     * @param  string  $sCorruptionCaseId
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $sCorruptionCaseId = '')
    {
        if( ! $request->ajax() ){
            $request->session()->flash('errorMsg', 'Unicamente se aceptan peticiones Ajax');
            return back();
        }

        if( ! $sCorruptionCaseId){
            return response()->json(['status' => false , 'message' => 'Por favor seleccione un Caso de Corrupción para poder eliminarlo.',], 200);
        }

        $oCorruptionCase = CorruptionCase::find($sCorruptionCaseId);
        
        if( ! is_object($oCorruptionCase)){
            return response()->json(['status' => false , 'message' => 'El Caso de Corrupción que usted a seleccionado no existe, por favor seleccione otro.',], 200);    
        }

        $oldCorruptionCase = $oCorruptionCase;
        $oCorruptionCase->whatsHappeneds()->delete();
        
        if($oCorruptionCase->delete()){
            return response()->json(['status' => true , 'message' => 'El Caso de Corrupción '.$oldCorruptionCase->title.' ha sido eliminado exisotamente.',], 200);
        }else{
            return response()->json(['status' => false , 'message' => 'El Caso de Corrupción '.$oldCorruptionCase->title.' no pudo ser eliminado. Por favor intentelo nuevamente luego de unos minutos',], 200);
        }
    }

    /**
     * Metodo para eliminar un registro de WhatHappened del sistema de acuerdo a su ID
     * @Autor Raúl Chauvin
     * @FechaCreacion  2019/01/02
     *
     * @route /backend/content/corruption-cases/delete-what-happened
     * @method GET
     * @param  string  $sWhatHappenedId
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroyWH(Request $request, $sWhatHappenedId = '')
    {
    	if( ! $request->ajax() ){
            $request->session()->flash('errorMsg', 'Unicamente se aceptan peticiones Ajax');
            return back();
        }

        if( ! $sWhatHappenedId){
            return response()->json(['status' => false , 'message' => 'Por favor seleccione un Registro para poder eliminarlo.',], 200);
        }

        $oWhatHappened = WhatHappened::find($sWhatHappenedId);
        
        if( ! is_object($oWhatHappened)){
            return response()->json(['status' => false , 'message' => 'El Registro que usted a seleccionado no existe, por favor seleccione otro.',], 200);    
        }

        if($oWhatHappened->delete()){
            return response()->json(['status' => true , 'message' => 'El Registro ha sido eliminado exisotamente.',], 200);
        }else{
            return response()->json(['status' => false , 'message' => 'El Registro no pudo ser eliminado. Por favor intentelo nuevamente luego de unos minutos',], 200);
        }
    }

}
