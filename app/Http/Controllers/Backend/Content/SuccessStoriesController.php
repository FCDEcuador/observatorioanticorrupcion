<?php

namespace BlaudCMS\Http\Controllers\Backend\Content;

use Illuminate\Http\Request;
use BlaudCMS\Http\Controllers\Controller;
use BlaudCMS\Http\Traits\BackendAuthorizable;

use BlaudCMS\Configuration;
use BlaudCMS\SuccessStory;
use BlaudCMS\User;

use BlaudCMS\Http\Requests\Content\SuccessStoryCreateRequest;
use BlaudCMS\Http\Requests\Content\SuccessStoryUpdateRequest;

use Storage;

use Flashy;
use Auth;

/**
* Clase para manejo de historias de extio del portal web
* @Autor Raúl Chauvin
* @FechaCreacion  2019/03/03
* @Content
*/

class SuccessStoriesController extends Controller
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
        $this->activeMenu = 'content';
    }


    /**
     * Metodo para mostrar la lista de historias de exito
     * @Autor Raúl Chauvin
     * @FechaCreacion  2019/03/03
     *
     * @route /backend/content/success-stories/list
     * @method GET
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $successStoriesList = SuccessStory::paginate(20);
        $data = [
            // Datos generales para todas las vistas
            'activeMenu' => $this->activeMenu,
            'oConfiguration' => $this->oConfiguration,

            // Datos especificos para utilizar en la vista
            'oStorage' => $this->oStorage,
            'successStoriesList' => $successStoriesList,
        ];
        $view = view('backend.content.success-stories.successStoriesList', $data);
        
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
     * Metodo para mostrar el formulario de creacion de nuevas historias de exito en el sistema
     * @Autor Raúl Chauvin
     * @FechaCreacion  2019/03/03
     *
     * @route /backend/content/success-stories/add
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
            'oSuccessStory' => null,
        ];

        $view = view('backend.content.success-stories.addEditSuccessStory', $data);
        
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
     * Metodo para guardar en la base de datos las nuevas historias de exito ingresadas desde el formulario
     * @Autor Raúl Chauvin
     * @FechaCreacion  2019/03/03
     *
     * @route /backend/content/success-stories/add
     * @method POST
     * @param  \BlaudCMS\Http\Requests\Content\SuccessStoryCreateRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SuccessStoryCreateRequest $request)
    {

    	if( ! $request->ajax() ){
            $request->session()->flash('errorMsg', 'Unicamente se aceptan peticiones Ajax');
            return back();
        }

        $oSuccessStory = new SuccessStory;
        $oSuccessStory->name = $request->name;
        $oSuccessStory->title = $request->title;
        $oSuccessStory->subtitle = $request->subtitle;
        $oSuccessStory->description = $request->description;
        $oSuccessStory->url = $request->url;

        
        if($request->hasFile('image')){
            $image = $request->file('image');
            $name = $image->getClientOriginalName();
            $path = $image->storePubliclyAs('success-stories',$name, ['disk' => $this->sStorageDisk]);
            $oSuccessStory->image = $path;
        }
        

        if($oSuccessStory->save()){
            return response()->json(['status' => true , 'message' => 'La historia de éxito '.$oSuccessStory->name.' ha sido agregada exisotamente.',], 200);
        }else{
            return response()->json(['status' => false , 'message' => 'La historia de éxito '.$oSuccessStory->name.' no pudo ser agregada. Por favor intentelo nuevamente luego de unos minutos',], 200);
        }
    }

    /**
     * Metodo para mostrar el formulario de edicion de una historia de exito seleccionada previamente por su ID
     * @Autor Raúl Chauvin
     * @FechaCreacion  2019/03/03
     *
     * @route /backend/content/success-stories/edit
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
                    'title' => 'Historias de Exito', 
                    'message' => 'Por favor seleccione una Historia de Exito para poder editarla.', 
                    'class' => 'error',
                ];
                return response()->json($aResponseData, 200);
            }
            $request->session()->flash('errorMsg', 'Por favor seleccione una Historia de Exito para poder editarla.');
            return back();
        }
        
        $oSuccessStory = SuccessStory::find($sId);

        if( ! is_object($oSuccessStory)){
            if($request->ajax()){
                $aResponseData = [
                    'type' => 'alert', 
                    'title' => 'Historias de Exito', 
                    'message' => 'La historia de exito seleccionada no existe. Por favor seleccione otra.', 
                    'class' => 'error',
                ];
                return response()->json($aResponseData, 200);
            }
            $request->session()->flash('errorMsg', 'La historia de exito seleccionada no existe. Por favor seleccione otra.');
            return back();   
        }

        $data = [
            // Datos generales para todas las vistas
            'activeMenu' => $this->activeMenu,
            'oConfiguration' => $this->oConfiguration,

            // Datos especificos para utilizar en la vista
            'oStorage' => $this->oStorage,
            'oSuccessStory' => $oSuccessStory,
        ];

        $view = view('backend.content.success-stories.addEditSuccessStory', $data);

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
     * Metodo para guardar en la base de datos los cambios realizados a una historia de exito previamente seleccionada por su ID desde el formulario
     * @Autor Raúl Chauvin
     * @FechaCreacion  2019/03/03
     *
     * @route /backend/content/success-histories/edit
     * @method PUT/PATCH
     *
     * @param  \BlaudCMS\Http\Requests\Content\SuccessStoryUpdateRequest  $request
     * @param  string $sId
     * @return \Illuminate\Http\Response
     */
    public function update(SuccessStoryUpdateRequest $request, $sId = '')
    {
        if( ! $request->ajax() ){
            $request->session()->flash('errorMsg', 'Unicamente se aceptan peticiones Ajax');
            return back();
        }

        if( ! $sId){
            return response()->json(['status' => false , 'message' => 'Por favor seleccione una historia de éxito para poder editarla.',], 200);
        }

        $oSuccessStory = SuccessStory::find($sId);
        
        if( ! is_object($oSuccessStory)){
            return response()->json(['status' => false , 'message' => 'La historia de éxito seleccionada no existe. Por favor seleccione otra.',], 200);
        }

        $oSuccessStory->name = $request->name;
        $oSuccessStory->title = $request->title;
        $oSuccessStory->subtitle = $request->subtitle;
        $oSuccessStory->description = $request->description;
        $oSuccessStory->url = $request->url;

        $oldImage = $oSuccessStory->image;

        
        if($request->hasFile('image')){
            $image = $request->file('image');
            $name = $image->getClientOriginalName();
            $path = $image->storePubliclyAs('success-stories',$name, ['disk' => $this->sStorageDisk]);
            $oSuccessStory->image = $path;
        }

        if($oSuccessStory->save()){
        	if($oldImage != $oSuccessStory->image && $oldImage != ''){
                $this->oStorage->delete($oldImage);
            }
            return response()->json(['status' => true , 'message' => 'La historia de éxito '.$oSuccessStory->name.' ha sido actualizada exisotamente.',], 200);
        }else{                    
            return response()->json(['status' => false , 'message' => 'La historia de éxito '.$oSuccessStory->name.' no pudo ser actualizada. Por favor intentelo nuevamente luego de unos minutos',], 200);
        }
    }


    /**
     * Metodo para eliminar una historia de exito seleccionada previamente por su ID
     * @Autor Raúl Chauvin
     * @FechaCreacion  2019/03/03
     *
     * @route /backend/content/success-stories/delete
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
            return response()->json(['status' => false , 'message' => 'Por favor seleccione una historia de éxito para poder eliminarla.',], 200);
        }

        $oSuccessStory = SuccessStory::find($sId);
        
        if( ! is_object($oSuccessStory)){
            return response()->json(['status' => false , 'message' => 'La historia de éxito seleccionada no existe. Por favor seleccione otra.',], 200);
        }

        $oldImage = $oSuccessStory->image;
        $name = $oSuccessStory->name;

        if($oSuccessStory->delete()){
        	if($oldImage != $oSuccessStory->image && $oldImage != ''){
                $this->oStorage->delete($oldImage);
            }
            return response()->json(['status' => true , 'message' => 'La historia de éxito '.$name.' ha sido eliminada exitosamente.',], 200);
        }else{
            return response()->json(['status' => false , 'message' => 'La historia de éxito '.$name.' no pudo ser eliminada. Por favor intentelo nuevamente luego de unos minutos.',], 200);
        }
    }
}
