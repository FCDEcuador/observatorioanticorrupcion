<?php

namespace BlaudCMS\Http\Controllers\Backend\Parametrization;

use Illuminate\Http\Request;
use BlaudCMS\Http\Controllers\Controller;
use BlaudCMS\Http\Traits\BackendAuthorizable;

use BlaudCMS\Configuration;
use BlaudCMS\MainSlider;
use BlaudCMS\User;

use BlaudCMS\Http\Requests\Parametrization\MainSliderCreateRequest;
use BlaudCMS\Http\Requests\Parametrization\MainSliderUpdateRequest;

use Storage;

use Auth;

/**
* Clase para manejo de imagenes del slider principal del portal web
* @Autor Raúl Chauvin
* @FechaCreacion  2019/04/03
* @Parametrization
*/

class MainSlidersController extends Controller
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
     * Metodo para mostrar la lista de imagenes que se cargaran en el slider principal
     * @Autor Raúl Chauvin
     * @FechaCreacion  2019/04/03
     *
     * @route /backend/parametrization/main-sliders/list
     * @method GET
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $mainSlidersList = MainSlider::orderBy('order', 'asc')->paginate(20);
        $data = [
            // Datos generales para todas las vistas
            'activeMenu' => $this->activeMenu,
            'oConfiguration' => $this->oConfiguration,

            // Datos especificos para utilizar en la vista
            'oStorage' => $this->oStorage,
            'mainSlidersList' => $mainSlidersList,
        ];
        $view = view('backend.parametrization.main-sliders.mainSlidersList', $data);
        
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
     * Metodo para mostrar el formulario de creacion de nuevos slides
     * @Autor Raúl Chauvin
     * @FechaCreacion  2019/04/03
     *
     * @route /backend/parametrization/main-sliders/add
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
            'oMainSlider' => null,
        ];

        $view = view('backend.parametrization.main-sliders.addEditMainSlider', $data);
        
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
     * Metodo para guardar en la base de datos los slides generados desde el formulario
     * @Autor Raúl Chauvin
     * @FechaCreacion  2019/04/03
     *
     * @route /backend/parametrization/main-sliders/add
     * @method POST
     * @param  \BlaudCMS\Http\Requests\Parametrization\MainSliderCreateRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MainSliderCreateRequest $request)
    {

        if( ! $request->ajax() ){
            $request->session()->flash('errorMsg', 'Unicamente se aceptan peticiones Ajax');
            return back();
        }

        $oMainSlider = new MainSlider;
        $oMainSlider->order = $request->order;
        $oMainSlider->status = $request->status;

        if($request->hasFile('image_path')){
            $image = $request->file('image_path');
            $name = $image->getClientOriginalName();
            $path = $image->storePubliclyAs('mainslider',$name, ['disk' => $this->sStorageDisk]);
            $oMainSlider->image_path = $path;
        }

        if($oMainSlider->save()){
            return response()->json(['status' => true , 'message' => 'El slide ha sido agregado exisotamente.',], 200);
        }else{
            return response()->json(['status' => false , 'message' => 'El slide no pudo ser agregado. Por favor intentelo nuevamente luego de unos minutos',], 200);
        }
    }

    /**
     * Metodo para mostrar el formulario de edicion de un slide seleccionado previamente por su ID
     * @Autor Raúl Chauvin
     * @FechaCreacion  2019/04/03
     *
     * @route /backend/parametrization/main-sliders/edit
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
                    'title' => 'Slider', 
                    'message' => 'Por favor seleccione un Slide para poder editarlo.', 
                    'class' => 'error',
                ];
                return response()->json($aResponseData, 200);
            }
            $request->session()->flash('errorMsg', 'Por favor seleccione un Slide para poder editarlo.');
            return back();
        }
        
        $oMainSlider = MainSlider::find($sId);

        if( ! is_object($oMainSlider)){
            if($request->ajax()){
                $aResponseData = [
                    'type' => 'alert', 
                    'title' => 'Slider', 
                    'message' => 'El Slide seleccionado no existe. Por favor seleccione otro.', 
                    'class' => 'error',
                ];
                return response()->json($aResponseData, 200);
            }
            $request->session()->flash('errorMsg', 'El Slide seleccionado no existe. Por favor seleccione otro.');
            return back();   
        }

        $data = [
            // Datos generales para todas las vistas
            'activeMenu' => $this->activeMenu,
            'oConfiguration' => $this->oConfiguration,

            // Datos especificos para utilizar en la vista
            'oStorage' => $this->oStorage,
            'oMainSlider' => $oMainSlider,
        ];

        $view = view('backend.parametrization.main-sliders.addEditMainSlider', $data);

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
     * Metodo para guardar en la base de datos los cambios realizados a un slide previamente seleccionado por su ID desde el formulario
     * @Autor Raúl Chauvin
     * @FechaCreacion  2018/04/03
     *
     * @route /backend/parametrization/main-sliders/edit
     * @method PUT/PATCH
     *
     * @param  \BlaudCMS\Http\Requests\Parametrization\MainSliderUpdateRequest  $request
     * @param  string $sId
     * @return \Illuminate\Http\Response
     */
    public function update(MainSliderUpdateRequest $request, $sId = '')
    {
        if( ! $request->ajax() ){
            $request->session()->flash('errorMsg', 'Unicamente se aceptan peticiones Ajax');
            return back();
        }

        if( ! $sId){
            return response()->json(['status' => false , 'message' => 'Por favor seleccione un slide para poder editarlo.',], 200);
        }

        $oMainSlider = MainSlider::find($sId);
        
        if( ! is_object($oMainSlider)){
            return response()->json(['status' => false , 'message' => 'El slide seleccionado no existe. Por favor seleccione otro.',], 200);
        }

        $oldImage = $oMainSlider->image_path;
        $oMainSlider->order = $request->order;
        $oMainSlider->status = $request->status;

        if($request->hasFile('image_path')){
            $image = $request->file('image_path');
            $name = $image->getClientOriginalName();
            $path = $image->storePubliclyAs('mainslider',$name, ['disk' => $this->sStorageDisk]);
            $oMainSlider->image_path = $path;
        }

        if($oMainSlider->save()){
        	if($oldImage != $this->oMainSlider->image_path && $oldImage != ''){
                $this->oStorage->delete($oldImage);
            }
            return response()->json(['status' => true , 'message' => 'El slide ha sido actualizado exisotamente.',], 200);
        }else{                    
            return response()->json(['status' => false , 'message' => 'El slide no pudo ser actualizado. Por favor intentelo nuevamente luego de unos minutos',], 200);
        }
    }


    /**
     * Metodo para actualizar en la BD el estado del Slide de acuerdo a su ID
     * @Autor Raúl Chauvin
     * @FechaCreacion  2019/04/03
     *
     * @route /backend/parametrization/main-sliders/change-status
     * @method GET
     * @param  string  $sId
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function changeStatus(Request $request, $sId = '')
    {
        if( ! $request->ajax() ){
            $request->session()->flash('errorMsg', 'Unicamente se aceptan peticiones Ajax');
            return back();
        }

        if( ! $sId){
            return response()->json(['status' => false , 'message' => 'Por favor seleccione un slide para poder editarlo.',], 200);
        }

        $oMainSlider = MainSlider::find($sId);

        if( ! is_object($oMainSlider)){
            return response()->json(['status' => false , 'message' => 'El slide seleccionado no existe, por favor seleccione otro.',], 200);
        }

        $newStatus = $oMainSlider->status == 1 ? 0 : 1;
        $status = $newStatus == 1 ? 'activado' : 'desactivado';

        $oMainSlider->status = $newStatus;
        if($oMainSlider->save()){
            return response()->json(['status' => true , 'message' => 'El slide ha sido '.$status.' exisotamente.',], 200);
        }else{
            return response()->json(['status' => false , 'message' => 'El slide no pudo ser '.$status.'. Por favor intentelo nuevamente luego de unos minutos',], 200);
        }
    }


    /**
     * Metodo para eliminar un slide seleccionado previamente por su ID
     * @Autor Raúl Chauvin
     * @FechaCreacion  2019/04/03
     *
     * @route /backend/parametrization/main-sliders/delete
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
            return response()->json(['status' => false , 'message' => 'Por favor seleccione un slide para poder eliminarlo.',], 200);
        }

        $oMainSlider = MainSlider::find($sId);
        
        if( ! is_object($oMainSlider)){
            return response()->json(['status' => false , 'message' => 'El slide seleccionado no existe. Por favor seleccione otro.',], 200);
        }
        $oldImage = $oMainSlider->image_path;
        if($oMainSlider->delete()){
            if($oldImage != ''){
                $this->oStorage->delete($oldImage);
            }
            return response()->json(['status' => true , 'message' => 'El slide ha sido eliminado exitosamente.',], 200);
        }else{
            return response()->json(['status' => false , 'message' => 'El slide no pudo ser eliminado. Por favor intentelo nuevamente luego de unos minutos.',], 200);
        }
    }
}
