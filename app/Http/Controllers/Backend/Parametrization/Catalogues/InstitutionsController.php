<?php

namespace BlaudCMS\Http\Controllers\Backend\Parametrization\Catalogues;

use Illuminate\Http\Request;
use BlaudCMS\Http\Controllers\Controller;
use BlaudCMS\Http\Traits\BackendAuthorizable;

use BlaudCMS\Configuration;
use BlaudCMS\Catalogue;
use BlaudCMS\User;

use BlaudCMS\Http\Requests\Parametrization\Catalogues\InstitutionCreateRequest;
use BlaudCMS\Http\Requests\Parametrization\Catalogues\InstitutionUpdateRequest;

use Storage;

use Auth;

/**
* Clase para administracion de funciones del estado
* @Autor Raúl Chauvin
* @FechaCreacion  2019/03/04
* @Parametrization
*/

class InstitutionsController extends Controller
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
     * Metodo para mostrar la lista de instituciones
     * @Autor Raúl Chauvin
     * @FechaCreacion  2019/03/04
     *
     * @route /backend/parametrization/catalogues/institutions/list
     * @method GET
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $institutionsList = Catalogue::searchCatalogs($request->sStringSearch, 'Instituciones', null, $iPaginate = 20);
        $data = [
            // Datos generales para todas las vistas
            'activeMenu' => $this->activeMenu,
            'oConfiguration' => $this->oConfiguration,

            // Datos especificos para utilizar en la vista
            'oStorage' => $this->oStorage,
            'institutionsList' => $institutionsList,
        ];
        $view = view('backend.parametrization.catalogues.institutions.institutionsList', $data);
        
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
     * Metodo para mostrar el formulario de creacion de nuevas instituciones
     * @Autor Raúl Chauvin
     * @FechaCreacion  2019/03/03
     *
     * @route /backend/parametrization/catalogues/institutions/add
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
            'oInstitution' => null,
        ];

        $view = view('backend.parametrization.catalogues.institutions.addEditInstitution', $data);
        
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
     * Metodo para guardar en la base de datos las nuevas instituciones ingresadas desde el formulario
     * @Autor Raúl Chauvin
     * @FechaCreacion  2019/03/03
     *
     * @route /backend/parametrization/catalogues/institutions/add
     * @method POST
     * @param  \BlaudCMS\Http\Requests\Parametrization\Catalogues\InstitutionCreateRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(InstitutionCreateRequest $request)
    {

        if( ! $request->ajax() ){
            $request->session()->flash('errorMsg', 'Unicamente se aceptan peticiones Ajax');
            return back();
        }

        $oInstitution = new Catalogue;
        $oInstitution->context = 'Instituciones';
        $oInstitution->description = $request->description;

        if($oInstitution->save()){
            return response()->json(['status' => true , 'message' => 'La institución '.$oInstitution->description.' ha sido agregada exisotamente.',], 200);
        }else{
            return response()->json(['status' => false , 'message' => 'La institución '.$oInstitution->description.' no pudo ser agregada. Por favor intentelo nuevamente luego de unos minutos',], 200);
        }
    }

    /**
     * Metodo para mostrar el formulario de edicion de una institucion seleccionada previamente por su ID
     * @Autor Raúl Chauvin
     * @FechaCreacion  2019/03/03
     *
     * @route /backend/parametrization/catalogues/institutions/edit
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
                    'title' => 'Instituciones', 
                    'message' => 'Por favor seleccione una institución para poder editarla.', 
                    'class' => 'error',
                ];
                return response()->json($aResponseData, 200);
            }
            $request->session()->flash('errorMsg', 'Por favor seleccione una institución para poder editarla.');
            return back();
        }
        
        $oInstitution = Catalogue::find($sId);

        if( ! is_object($oInstitution)){
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
            'oInstitution' => $oInstitution,
        ];

        $view = view('backend.parametrization.catalogues.institutions.addEditInstitution', $data);

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
     * Metodo para guardar en la base de datos los cambios realizados a una institucion previamente seleccionada por su ID desde el formulario
     * @Autor Raúl Chauvin
     * @FechaCreacion  2019/03/03
     *
     * @route /backend/parametrization/catalogues/institutions/edit
     * @method PUT/PATCH
     *
     * @param  \BlaudCMS\Http\Requests\Parametrization\Catalogues\InstitutionUpdateRequest  $request
     * @param  string $sId
     * @return \Illuminate\Http\Response
     */
    public function update(InstitutionUpdateRequest $request, $sId = '')
    {
        if( ! $request->ajax() ){
            $request->session()->flash('errorMsg', 'Unicamente se aceptan peticiones Ajax');
            return back();
        }

        if( ! $sId){
            return response()->json(['status' => false , 'message' => 'Por favor seleccione una institución para poder editarla.',], 200);
        }

        $oInstitution = Catalogue::find($sId);
        
        if( ! is_object($oInstitution)){
            return response()->json(['status' => false , 'message' => 'La institución seleccionada no existe. Por favor seleccione otra.',], 200);
        }

        $oInstitution->context = 'Instituciones';
        $oInstitution->description = $request->description;

        if($oInstitution->save()){
            return response()->json(['status' => true , 'message' => 'La institución '.$oInstitution->description.' ha sido actualizada exisotamente.',], 200);
        }else{
            return response()->json(['status' => false , 'message' => 'La institución '.$oInstitution->description.' no pudo ser actualizada. Por favor intentelo nuevamente luego de unos minutos',], 200);
        }
    }


    /**
     * Metodo para eliminar una institución seleccionada previamente por su ID
     * @Autor Raúl Chauvin
     * @FechaCreacion  2019/03/03
     *
     * @route /backend/parametrization/catalogues/institutions/delete
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
            return response()->json(['status' => false , 'message' => 'Por favor seleccione una institución para poder eliminarla.',], 200);
        }

        $oInstitution = Catalogue::find($sId);
        
        if( ! is_object($oInstitution)){
            return response()->json(['status' => false , 'message' => 'La institución seleccionada no existe. Por favor seleccione otra.',], 200);
        }

        if($oInstitution->delete()){
            return response()->json(['status' => true , 'message' => 'La institución '.$oInstitution->description.' ha sido eliminada exitosamente.',], 200);
        }else{
            return response()->json(['status' => false , 'message' => 'La institución '.$oInstitution->description.' no pudo ser eliminada. Por favor intentelo nuevamente luego de unos minutos.',], 200);
        }
    }
}
