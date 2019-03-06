<?php

namespace BlaudCMS\Http\Controllers\Backend\Content;

use Illuminate\Http\Request;
use BlaudCMS\Http\Controllers\Controller;
use BlaudCMS\Http\Traits\BackendAuthorizable;

use BlaudCMS\Configuration;
use BlaudCMS\LegalLibrary;
use BlaudCMS\User;

use BlaudCMS\Http\Requests\Content\LegalLibraryCreateRequest;
use BlaudCMS\Http\Requests\Content\LegalLibraryUpdateRequest;

use Cocur\Slugify\Slugify;

use Storage;

use Flashy;
use Auth;

/**
* Clase para manejo de biblioteca legal del portal web
* @Autor Raúl Chauvin
* @FechaCreacion  2019/03/03
* @Content
*/

class LegalLibrariesController extends Controller
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

        $this->sStorageDisk = 'public';
        $this->oStorage = Storage::disk($this->sStorageDisk);

        // Colocamos el valor en la variable $this->activeMenu 
        // para saber que item del menu de navegacion debe pintarse
        $this->activeMenu = 'content';
    }


    /**
     * Metodo para mostrar la lista de biblioteca legal
     * @Autor Raúl Chauvin
     * @FechaCreacion  2019/03/03
     *
     * @route /backend/content/legal-libraries/list
     * @method GET
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $legalLibrariesList = LegalLibrary::paginate(20);
        $data = [
            // Datos generales para todas las vistas
            'activeMenu' => $this->activeMenu,
            'oConfiguration' => $this->oConfiguration,

            // Datos especificos para utilizar en la vista
            'oStorage' => $this->oStorage,
            'legalLibrariesList' => $legalLibrariesList,
        ];
        $view = view('backend.content.legal-libraries.legalLibrariesList', $data);
        
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
     * Metodo para mostrar el formulario de creacion de nuevas bibliotecas legales en el sistema
     * @Autor Raúl Chauvin
     * @FechaCreacion  2019/03/03
     *
     * @route /backend/content/legal-libraries/add
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
            'oLegalLibrary' => null,
        ];

        $view = view('backend.content.legal-libraries.addEditLegalLibrary', $data);
        
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
     * Metodo para guardar en la base de datos las nuevas bibliotecas legales ingresadas desde el formulario
     * @Autor Raúl Chauvin
     * @FechaCreacion  2019/03/03
     *
     * @route /backend/content/legal-libraries/add
     * @method POST
     * @param  \BlaudCMS\Http\Requests\Content\LegalLibraryCreateRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LegalLibraryCreateRequest $request)
    {

    	if( ! $request->ajax() ){
            $request->session()->flash('errorMsg', 'Unicamente se aceptan peticiones Ajax');
            return back();
        }

        $oLegalLibrary = new LegalLibrary;
        $oLegalLibrary->title = $request->title;
        $oLegalLibrary->slug = $this->oSlugify->slugify($request->title);
        $oLegalLibrary->description = $request->description;
        $oLegalLibrary->issue_year = $request->issue_year;
        $oLegalLibrary->tags = explode(',', $request->tags);

        
        if($request->hasFile('pdf_document')){
            $pdf_document = $request->file('pdf_document');
            $name = $pdf_document->getClientOriginalName();
            $path = $pdf_document->storePubliclyAs('legal-libraries',$name, ['disk' => $this->sStorageDisk]);
            $oLegalLibrary->pdf_document = $path;
        }
        

        if($oLegalLibrary->save()){
            return response()->json(['status' => true , 'message' => 'La biblioteca legal '.$oLegalLibrary->title.' ha sido agregada exisotamente.',], 200);
        }else{
            return response()->json(['status' => false , 'message' => 'La biblioteca legal '.$oLegalLibrary->title.' no pudo ser agregada. Por favor intentelo nuevamente luego de unos minutos',], 200);
        }
    }

    /**
     * Metodo para mostrar el formulario de edicion de una biblioteca legal seleccionada previamente por su ID
     * @Autor Raúl Chauvin
     * @FechaCreacion  2019/03/03
     *
     * @route /backend/content/legal-library/edit
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
                    'title' => 'Biblioteca Legal', 
                    'message' => 'Por favor seleccione una biblioteca legal para poder editarla.', 
                    'class' => 'error',
                ];
                return response()->json($aResponseData, 200);
            }
            $request->session()->flash('errorMsg', 'Por favor seleccione una biblioteca legal para poder editarla.');
            return back();
        }
        
        $oLegalLibrary = LegalLibrary::find($sId);

        if( ! is_object($oLegalLibrary)){
            if($request->ajax()){
                $aResponseData = [
                    'type' => 'alert', 
                    'title' => 'Biblioteca Legal', 
                    'message' => 'La biblioteca legal seleccionada no existe. Por favor seleccione otra.', 
                    'class' => 'error',
                ];
                return response()->json($aResponseData, 200);
            }
            $request->session()->flash('errorMsg', 'La biblioteca legal seleccionada no existe. Por favor seleccione otra.');
            return back();   
        }

        $data = [
            // Datos generales para todas las vistas
            'activeMenu' => $this->activeMenu,
            'oConfiguration' => $this->oConfiguration,

            // Datos especificos para utilizar en la vista
            'oStorage' => $this->oStorage,
            'oLegalLibrary' => $oLegalLibrary,
        ];

        $view = view('backend.content.legal-libraries.addEditLegalLibrary', $data);

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
     * Metodo para guardar en la base de datos los cambios realizados a una biblioteca legal previamente seleccionada por su ID desde el formulario
     * @Autor Raúl Chauvin
     * @FechaCreacion  2019/03/03
     *
     * @route /backend/content/legal-library/edit
     * @method PUT/PATCH
     *
     * @param  \BlaudCMS\Http\Requests\Content\LegalLibraryUpdateRequest  $request
     * @param  string $sId
     * @return \Illuminate\Http\Response
     */
    public function update(LegalLibraryUpdateRequest $request, $sId = '')
    {
        if( ! $request->ajax() ){
            $request->session()->flash('errorMsg', 'Unicamente se aceptan peticiones Ajax');
            return back();
        }

        if( ! $sId){
            return response()->json(['status' => false , 'message' => 'Por favor seleccione una biblioteca legal para poder editarla.',], 200);
        }

        $oLegalLibrary = LegalLibrary::find($sId);
        
        if( ! is_object($oLegalLibrary)){
            return response()->json(['status' => false , 'message' => 'La biblioteca legal seleccionada no existe. Por favor seleccione otra.',], 200);
        }

        $oLegalLibrary->title = $request->title;
        $oLegalLibrary->slug = $this->oSlugify->slugify($request->title);
        $oLegalLibrary->description = $request->description;
        $oLegalLibrary->issue_year = $request->issue_year;
        $oLegalLibrary->tags = explode(',', $request->tags);

        $oldPdfDocument = $oLegalLibrary->pdf_document;

        
        if($request->hasFile('pdf_document')){
            $pdf_document = $request->file('pdf_document');
            $name = $pdf_document->getClientOriginalName();
            $path = $pdf_document->storePubliclyAs('success-stories',$name, ['disk' => $this->sStorageDisk]);
            $oLegalLibrary->pdf_document = $path;
        }

        if($oLegalLibrary->save()){
        	if($oldPdfDocument != $oLegalLibrary->pdf_document && $oldPdfDocument != ''){
                $this->oStorage->delete($oldPdfDocument);
            }
            return response()->json(['status' => true , 'message' => 'La biblioteca legal '.$oLegalLibrary->title.' ha sido actualizada exisotamente.',], 200);
        }else{                    
            return response()->json(['status' => false , 'message' => 'La biblioteca legal '.$oLegalLibrary->title.' no pudo ser actualizada. Por favor intentelo nuevamente luego de unos minutos',], 200);
        }
    }


    /**
     * Metodo para eliminar una biblioteca legal seleccionada previamente por su ID
     * @Autor Raúl Chauvin
     * @FechaCreacion  2019/03/03
     *
     * @route /backend/content/legal-library/delete
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
            return response()->json(['status' => false , 'message' => 'Por favor seleccione una biblioteca legal para poder eliminarla.',], 200);
        }

        $oLegalLibrary = LegalLibrary::find($sId);
        
        if( ! is_object($oLegalLibrary)){
            return response()->json(['status' => false , 'message' => 'La bilioteca legal seleccionada no existe. Por favor seleccione otra.',], 200);
        }

        $oldPdfDocument = $oLegalLibrary->pdf_document;
        $title = $oLegalLibrary->title;

        if($oLegalLibrary->delete()){
        	if($oldPdfDocument != $oLegalLibrary->pdf_document && $oldPdfDocument != ''){
                $this->oStorage->delete($oldPdfDocument);
            }
            return response()->json(['status' => true , 'message' => 'La biblioteca legal '.$title.' ha sido eliminada exitosamente.',], 200);
        }else{
            return response()->json(['status' => false , 'message' => 'La biblioteca legal '.$title.' no pudo ser eliminada. Por favor intentelo nuevamente luego de unos minutos.',], 200);
        }
    }
}
