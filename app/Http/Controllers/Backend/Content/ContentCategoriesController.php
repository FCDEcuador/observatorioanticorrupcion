<?php

namespace BlaudCMS\Http\Controllers\Backend\Content;

use Illuminate\Http\Request;
use BlaudCMS\Http\Controllers\Controller;
use BlaudCMS\Http\Traits\BackendAuthorizable;

use BlaudCMS\Helpers\TimeFormat;

use BlaudCMS\Configuration;
use BlaudCMS\User;
use BlaudCMS\ContentCategory;

use Cocur\Slugify\Slugify;

use BlaudCMS\Http\Requests\Content\ContentCategoryCreateRequest;
use BlaudCMS\Http\Requests\Content\ContentCategoryUpdateRequest;

use Storage;
use Auth;

/**
* Clase para manejo de categorias de contenido del portal web
* @Autor Raúl Chauvin
* @FechaCreacion  2018/08/30
* @content
*/

class ContentCategoriesController extends Controller
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

        $this->sStorageDisk = config('app.env') == 'production' ? 'public' : 'public';
        $this->oStorage = config('app.env') == 'production' ? Storage::disk('public') : Storage::disk('public');

        // Colocamos el valor en la variable $this->activeMenu 
        // para saber que item del menu de navegacion debe pintarse
        $this->activeMenu = 'Content';
    }


    /**
     * Metodo para mostrar la lista de categorias o secciones de contenido
     * @Autor Raúl Chauvin
     * @FechaCreacion  2019/02/26
     *
     * @route /backend/content/content-categories/list
     * @method GET
     * @param  \Illuminate\Http\Request  $request
     * @param  string $sSuperContentCategoryId
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $sSuperContentCategoryId = null)
    {
        $contentCategoriesList = ContentCategory::superCategories()->paginate(20);
        $hasSuperContentCategory = FALSE;
        $oSuperContentCategory = null;
        if($sSuperContentCategoryId){
            $oSuperContentCategory = ContentCategory::find($sSuperContentCategoryId);
            if($oSuperContentCategory){
                $contentCategoriesList = ContentCategory::subCategories($oSuperContentCategory->id)->paginate(20);
                $hasSuperContentCategory = TRUE;
            }
        }

        $data = [
            // Datos generales para todas las vistas
            'title' => 'BlaudCMS :: Contenido - Categorias',
            'activeMenu' => $this->activeMenu,
            'oConfiguration' => $this->oConfiguration,

            // Datos especificos para utilizar en la vista
            'oStorage' => $this->oStorage,
            'sSuperContentCategoryId' => $sSuperContentCategoryId,
            'hasSuperContentCategory' => $hasSuperContentCategory,
            'oSuperContentCategory' => $oSuperContentCategory,
            'contentCategoriesList' => $contentCategoriesList,
        ];

        $view = view('backend.content.content-categories.contentCategoriesList', $data);
        
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
     * Metodo para mostrar el formulario de creacion de nuevas categorias o secciones de contenido en el portal
     *  Como parametro adicional el metodo puede recibir el ID de una categoria padre
     *  para directamente crear una subcategoria de la misma
     * @Autor Raúl Chauvin
     * @FechaCreacion  2019/02/26
     *
     * @route /backend/content/content-categories/add
     * @method GET
     * @param string sSuperContentCategoryId
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, $sSuperContentCategoryId = '')
    {
        $hasSuperContentCategory = FALSE;
        if($sSuperContentCategoryId){
            $oSuperContentCategory = ContentCategory::find($sSuperContentCategoryId);
            if($oSuperContentCategory){
                $hasSuperContentCategory = TRUE;
            }
        }else{
            $oSuperContentCategory = null;
        }

        $data = [
            // Datos generales para todas las vistas
            'title' => 'BlaudCMS :: Contenido - Categorias',
            'activeMenu' => $this->activeMenu,
            'oConfiguration' => $this->oConfiguration,

            // Datos especificos para utilizar en la vista
            'oStorage' => $this->oStorage,
            'hasSuperContentCategory' => $hasSuperContentCategory,
            'oSuperContentCategory' => $oSuperContentCategory,
            'oContentCategory' => null,
        ];
        $view = view('backend.content.content-categories.addEditContentCategory', $data);

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
     * Metodo para guardar en la base de datos las nuevas categorias ingresadas desde el formulario
     * @Autor Raúl Chauvin
     * @FechaCreacion  2018/01/26
     *
     * @route /backend/content/content-categories/add
     * @method POST
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ContentCategoryCreateRequest $request)
    {
        if( ! $request->ajax() ){
            $request->session()->flash('errorMsg', 'Unicamente se aceptan peticiones Ajax');
            return back();
        }

        $oContentCategory = new ContentCategory;
        $oContentCategory->name = $request->name;
        $oContentCategory->title = $request->title;
        $oContentCategory->slug = $this->oSlugify->slugify($request->title);
        $oContentCategory->subtitle = $request->subtitle;
        $oContentCategory->tags = explode(',', $request->tags);
        $oContentCategory->meta_description = $request->meta_description;
        $oContentCategory->meta_keywords = $request->meta_keywords;
        $oContentCategory->extra_headers = $request->extra_headers;
        $oContentCategory->content_category_id = $request->content_category_id;

        if($oContentCategory->save()){
            return response()->json(['status' => true , 'message' => 'Seccion de contenido '.$oContentCategory->name.' guardada exitosamente.',], 200);
        }else{
        	return response()->json(['status' => false , 'message' => 'Seccion de contenido '.$oContentCategory->name.' no pudo ser guardada. Por favor intentelo nuevamente luego de unos minutos.',], 200);
        }
    }


    /**
     * Metodo para mostrar el formulario de edicion de una categoria seleccionada previamente por su ID
     * @Autor Raúl Chauvin
     * @FechaCreacion  2018/01/25
     *
     * @route /backend/content/content-categories/edit
     * @method GET
     * @param  string $sId
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $sId = '')
    {
        if( ! $sId){
            if($request->ajax()){
                $aResponseData = [
                    'type' => 'alert', 
                    'title' => 'Categorías de Contenido', 
                    'message' => 'Por favor seleccione una Categoria de Contenido para poder editarla.', 
                    'class' => 'error',
                ];
                return response()->json($aResponseData, 200);
            }
            $request->session()->flash('errorMsg', 'Por favor seleccione una Categoría de Contenido para poder editarla.');
            return back();
        }

        $oContentCategory = ContentCategory::find($sId);
        
        if( ! is_object($oContentCategory)){
            if($request->ajax()){
                $aResponseData = [
                    'type' => 'alert', 
                    'title' => 'Categorías de Contenido', 
                    'message' => 'La categoría de contenido que usted a seleccionado no existe, por favor seleccione otra.', 
                    'class' => 'error',
                ];
                return response()->json($aResponseData, 200);
            }
            $request->session()->flash('errorMsg', 'La categoría de contenido que usted a seleccionado no existe, por favor seleccione otra.');
            return back();    
        }

        $hasSuperContentCategory = FALSE;
        if($oContentCategory->content_category_id){
            $oSuperContentCategory = $oContentCategory->superContentCategory;
            if($oSuperContentCategory){
                $hasSuperContentCategory = TRUE;
            }
        }else{
            $oSuperContentCategory = null;
        }

        $data = [
            // Datos generales para todas las vistas
            'title' => 'BlaudCMS :: Contenido - Categorias',
            'activeMenu' => $this->activeMenu,
            'oConfiguration' => $this->oConfiguration,

            // Datos especificos para utilizar en la vista
            'oStorage' => $this->oStorage,
            'hasSuperContentCategory' => $hasSuperContentCategory,
            'oSuperContentCategory' => $oSuperContentCategory,
            'oContentCategory' => $oContentCategory,
        ];
        $view = view('backend.content.content-categories.addEditContentCategory', $data);

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
     * Metodo para actualizar la informacion de una categoria de contenido que llega desde el formulario
     * @Autor Raúl Chauvin
     * @FechaCreacion  2018/01/25
     *
     * @route /backend/content/content-categories/edit
     * @method PUT/PATCH
     * @param  string $sId
     * @param  \Illuminate\Http\Content\ContentCategoryUpdateRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function update(ContentCategoryUpdateRequest $request, $sId = '')
    {
    	if( ! $request->ajax() ){
            $request->session()->flash('errorMsg', 'Unicamente se aceptan peticiones Ajax');
            return back();
        }

        if( ! $sId){
            $aResponseData = [
                'status' => false, 
                'message' => 'Por favor seleccione una Categoria de Contenido para poder editarla.', 
            ];
            return response()->json($aResponseData, 200);
        }

        $oContentCategory = ContentCategory::find($sId);
        
        if( ! is_object($oContentCategory)){
            $aResponseData = [
                'status' => false, 
                'message' => 'La categoría de contenido que usted a seleccionado no existe, por favor seleccione otra.', 
            ];
            return response()->json($aResponseData, 200);
        }

        $oContentCategory->name = $request->name;
        $oContentCategory->title = $request->title;
        $oContentCategory->slug = $this->oSlugify->slugify($request->title);
        $oContentCategory->subtitle = $request->subtitle;
        $oContentCategory->tags = explode(',', $request->tags);
        $oContentCategory->meta_description = $request->meta_description;
        $oContentCategory->meta_keywords = $request->meta_keywords;
        $oContentCategory->extra_headers = $request->extra_headers;
        $oContentCategory->content_category_id = $request->content_category_id;

        if($oContentCategory->save()){
            return response()->json(['status' => true , 'message' => 'Seccion de contenido '.$oContentCategory->name.' guardada exitosamente.',], 200);
        }else{
        	return response()->json(['status' => false , 'message' => 'Seccion de contenido '.$oContentCategory->name.' no pudo ser guardada. Por favor intentelo nuevamente luego de unos minutos.',], 200);
        }
    }



    /**
     * Metodo para eliminar una categoria o seccion de contenido seleccionado previamente por su ID
     * @Autor Raúl Chauvin
     * @FechaCreacion  2018/01/26
     *
     * @route /backend/content/content-categories/delete
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
            $aResponseData = [
                'status' => false, 
                'message' => 'Por favor seleccione una Categoria de Contenido para poder eliminarla.', 
            ];
            return response()->json($aResponseData, 200);
        }

        $oContentCategory = ContentCategory::find($sId);
        
        if( ! is_object($oContentCategory)){
            $aResponseData = [
                'status' => false, 
                'message' => 'La categoría de contenido que usted a seleccionado no existe, por favor seleccione otra.', 
            ];
            return response()->json($aResponseData, 200);
        }

        $hasSubContentCategories = $oContentCategory->contentCategories;
        $hasArticles = $oContentCategory->contentArticles;
        if($hasSubContentCategories->isNotEmpty() || $hasArticles->isNotEmpty()){
            return response()->json(['status' => false , 'message' => 'La categoria '.$oContentCategory->name.' no puede ser eliminada debido a que tiene subcategorias o articulos de contenido asociados a la misma.',], 200);
        }
        if($oContentCategory->delete()){
            return response()->json(['status' => true , 'message' => 'La categoria '.$oContentCategory->name.' ha sido eliminada exitosamente.',], 200);    
        }else{
            return response()->json(['status' => true , 'message' => 'La categoria '.$oContentCategory->name.' no pudo ser eliminada, por favor intentelo nuevamente luego de unos minutos.',], 200);    
        }
    }
}
