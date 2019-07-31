<?php

namespace BlaudCMS\Http\Controllers\Backend\Parametrization\Catalogues;

use Illuminate\Http\Request;
use BlaudCMS\Http\Controllers\Controller;
use BlaudCMS\Http\Traits\BackendAuthorizable;

use BlaudCMS\Configuration;
use BlaudCMS\Catalogue;
use BlaudCMS\User;

use BlaudCMS\Http\Requests\Parametrization\Catalogues\PublicOfficialCreateRequest;
use BlaudCMS\Http\Requests\Parametrization\Catalogues\PublicOfficialUpdateRequest;

use Storage;

use Auth;

/**
* Clase para administracion de funcionarios públicos
* @Autor Raúl Chauvin
* @FechaCreacion  2019/03/04
* @Parametrization
*/

class OfficialsController extends Controller
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
     * Metodo para mostrar la lista de funcionarios
     * @Autor Raúl Chauvin
     * @FechaCreacion  2019/03/04
     *
     * @route /backend/parametrization/catalogues/public-officials/list
     * @method GET
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $publicOfficialsList = Catalogue::searchCatalogs($request->sStringSearch, 'Funcionarios', null, $iPaginate = 20);
        $data = [
            // Datos generales para todas las vistas
            'activeMenu' => $this->activeMenu,
            'oConfiguration' => $this->oConfiguration,

            // Datos especificos para utilizar en la vista
            'oStorage' => $this->oStorage,
            'publicOfficialsList' => $publicOfficialsList,
        ];
        $view = view('backend.parametrization.catalogues.public-officials.publicOfficialsList', $data);
        
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
     * Metodo para mostrar el formulario de creacion de nuevos funcionarios
     * @Autor Raúl Chauvin
     * @FechaCreacion  2019/03/03
     *
     * @route /backend/parametrization/catalogues/public-officials/add
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
            'oPublicOfficial' => null,
        ];

        $view = view('backend.parametrization.catalogues.public-officials.addEditPublicOfficial', $data);
        
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
     * Metodo para guardar en la base de datos los nuevos funcionarios ingresados desde el formulario
     * @Autor Raúl Chauvin
     * @FechaCreacion  2019/03/03
     *
     * @route /backend/parametrization/catalogues/public-officials/add
     * @method POST
     * @param  \BlaudCMS\Http\Requests\Parametrization\Catalogues\PublicOfficialCreateRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PublicOfficialCreateRequest $request)
    {

        if( ! $request->ajax() ){
            $request->session()->flash('errorMsg', 'Unicamente se aceptan peticiones Ajax');
            return back();
        }

        $oPublicOfficial = new Catalogue;
        $oPublicOfficial->context = 'Funcionarios';
        $oPublicOfficial->description = $request->description;

        if($oPublicOfficial->save()){
            return response()->json(['status' => true , 'message' => 'El funcionario '.$oPublicOfficial->description.' ha sido agregado exisotamente.',], 200);
        }else{
            return response()->json(['status' => false , 'message' => 'El funcionario '.$oPublicOfficial->description.' no pudo ser agregado. Por favor intentelo nuevamente luego de unos minutos',], 200);
        }
    }

    /**
     * Metodo para mostrar el formulario de edicion de un funcionario seleccionada previamente por su ID
     * @Autor Raúl Chauvin
     * @FechaCreacion  2019/03/03
     *
     * @route /backend/parametrization/catalogues/public-officials/edit
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
                    'title' => 'Funcionarios', 
                    'message' => 'Por favor seleccione un funcionario para poder editarlo.', 
                    'class' => 'error',
                ];
                return response()->json($aResponseData, 200);
            }
            $request->session()->flash('errorMsg', 'Por favor seleccione un funcionario para poder editarlo.');
            return back();
        }
        
        $oPublicOfficial = Catalogue::find($sId);

        if( ! is_object($oPublicOfficial)){
            if($request->ajax()){
                $aResponseData = [
                    'type' => 'alert', 
                    'title' => 'Instituciones', 
                    'message' => 'La institución seleccionada no existe. Por favor seleccione otra.', 
                    'class' => 'error',
                ];
                return response()->json($aResponseData, 200);
            }
            $request->session()->flash('errorMsg', 'La institución seleccionada no existe. Por favor seleccione otra.');
            return back();   
        }

        $data = [
            // Datos generales para todas las vistas
            'activeMenu' => $this->activeMenu,
            'oConfiguration' => $this->oConfiguration,

            // Datos especificos para utilizar en la vista
            'oStorage' => $this->oStorage,
            'oPublicOfficial' => $oPublicOfficial,
        ];

        $view = view('backend.parametrization.catalogues.public-officials.addEditPublicOfficial', $data);

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
     * Metodo para guardar en la base de datos los cambios realizados a un funcionario previamente seleccionado por su ID desde el formulario
     * @Autor Raúl Chauvin
     * @FechaCreacion  2019/03/03
     *
     * @route /backend/parametrization/catalogues/public-officials/edit
     * @method PUT/PATCH
     *
     * @param  \BlaudCMS\Http\Requests\Parametrization\Catalogues\PublicOfficialUpdateRequest  $request
     * @param  string $sId
     * @return \Illuminate\Http\Response
     */
    public function update(PublicOfficialUpdateRequest $request, $sId = '')
    {
        if( ! $request->ajax() ){
            $request->session()->flash('errorMsg', 'Unicamente se aceptan peticiones Ajax');
            return back();
        }

        if( ! $sId){
            return response()->json(['status' => false , 'message' => 'Por favor seleccione un funcionario para poder editarlo.',], 200);
        }

        $oPublicOfficial = Catalogue::find($sId);
        
        if( ! is_object($oPublicOfficial)){
            return response()->json(['status' => false , 'message' => 'El funcionario seleccionado no existe. Por favor seleccione otro.',], 200);
        }

        $oPublicOfficial->context = 'Funcionarios';
        $oPublicOfficial->description = $request->description;

        if($oPublicOfficial->save()){
            return response()->json(['status' => true , 'message' => 'El funcionario '.$oPublicOfficial->description.' ha sido actualizado exisotamente.',], 200);
        }else{
            return response()->json(['status' => false , 'message' => 'El funcionario '.$oPublicOfficial->description.' no pudo ser actualizado. Por favor intentelo nuevamente luego de unos minutos',], 200);
        }
    }


    /**
     * Metodo para eliminar un funcionario seleccionado previamente por su ID
     * @Autor Raúl Chauvin
     * @FechaCreacion  2019/03/03
     *
     * @route /backend/parametrization/catalogues/public-officials/delete
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
            return response()->json(['status' => false , 'message' => 'Por favor seleccione un funcionario para poder eliminarlo.',], 200);
        }

        $oPublicOfficial = Catalogue::find($sId);
        
        if( ! is_object($oPublicOfficial)){
            return response()->json(['status' => false , 'message' => 'El funcionario seleccionado no existe. Por favor seleccione otro.',], 200);
        }

        if($oPublicOfficial->delete()){
            return response()->json(['status' => true , 'message' => 'El funcionario '.$oPublicOfficial->description.' ha sido eliminado exitosamente.',], 200);
        }else{
            return response()->json(['status' => false , 'message' => 'El funcionario '.$oPublicOfficial->description.' no pudo ser eliminado. Por favor intentelo nuevamente luego de unos minutos.',], 200);
        }
    }
}
