<?php

namespace BlaudCMS\Http\Controllers\Backend\Content;

use Illuminate\Http\Request;
use BlaudCMS\Http\Controllers\Controller;
use BlaudCMS\Http\Traits\BackendAuthorizable;

use BlaudCMS\Helpers\TimeFormat;

use BlaudCMS\Configuration;
use BlaudCMS\User;
use BlaudCMS\ContentCategory;
use BlaudCMS\ContentArticle;

use Cocur\Slugify\Slugify;

use BlaudCMS\Http\Requests\Content\ContentArticleCreateRequest;
use BlaudCMS\Http\Requests\Content\ContentArticleUpdateRequest;

use Storage;
use Auth;

/**
* Clase para manejo de meta tags del portal web
* @Autor Raúl Chauvin
* @FechaCreacion  2018/08/30
* @Content
*/

class ContentArticlesController extends Controller
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
     * Metodo para mostrar la lista de articulos de contenido
     * @Autor Raúl Chauvin
     * @FechaCreacion  2018/02/27
     *
     * @route /backend/content/content-articles/list
     * @method GET
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $contentArticlesList = ContentArticle::searchContentArticles($request->sStringSearch, [], 20);

        $data = [
            // Datos generales para todas las vistas
            'activeMenu' => $this->activeMenu,
            'oConfiguration' => $this->oConfiguration,

            // Datos especificos para utilizar en la vista
            'oStorage' => $this->oStorage,
            'contentArticlesList' => $contentArticlesList,
        ];
        $view = view('backend.content.content-articles.contentArticlesList', $data);

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
     * Metodo para mostrar el formulario de creacion de nuevos articulos de contenido en el portal
     * @Autor Raúl Chauvin
     * @FechaCreacion  2018/02/27
     *
     * @route /backend/content/content-articles/add
     * @method GET
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
            'oContentArticle' => null,
            'sContentCategoryId' => null,
        ];
        $view = view('backend.content.content-articles.addEditContentArticle', $data);

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
     * Metodo para guardar en la base de datos las nuevos articulos de contenido ingresados desde el formulario
     * @Autor Raúl Chauvin
     * @FechaCreacion  2018/01/27
     *
     * @route /backend/content/content-articles/add
     * @method POST
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ContentArticleCreateRequest $request)
    {

    	if( ! $request->ajax() ){
            $request->session()->flash('errorMsg', 'Unicamente se aceptan peticiones Ajax');
            return back();
        }

        $oContentArticle = new ContentArticle;
        $oContentArticle->title = $request->title;
        $oContentArticle->slug = $this->oSlugify->slugify($request->title);
        $oContentArticle->summary = $request->summary;
        $oContentArticle->content = $request->content;
        $oContentArticle->author = $request->author;
        $oContentArticle->author_email = $request->author_email;
        $oContentArticle->source = $request->source;
        $oContentArticle->tags = explode(',', $request->tags);
        $oContentArticle->outstanding = $request->outstanding;
        $oContentArticle->main_category = 0;
        $oContentArticle->main_home = 0;
        $oContentArticle->meta_description = $request->meta_description;
        $oContentArticle->meta_keywords = $request->meta_keywords;
        $oContentArticle->extra_headers = $request->extra_headers;
        $oContentArticle->content_category_id = $request->content_category_id;

        if($request->hasFile('main_multimedia')){
            $mainImage = $request->file('main_multimedia');
            $name = $mainImage->getClientOriginalName();
            $path = $mainImage->storePubliclyAs('content-articles/'.$request->content_category_id,$name, ['disk' => $this->sStorageDisk]);
            $oContentArticle->main_multimedia = $path;
        }

        if($oContentArticle->save()){
            return response()->json(['status' => true , 'message' => 'Artículo de contenido '.$oContentArticle->title.' guardado exitosamente.',], 200);
        }else{
            return response()->json(['status' => false , 'message' => 'Artículo de contenido '.$oContentArticle->title.' no pudo ser guardado. Por favor intentelo nuevamente luego de unos minutos',], 200);
        }
    }


    /**
     * Metodo para mostrar el formulario de edicion de un articulo de contenido seleccionado previamente por su ID
     * @Autor Raúl Chauvin
     * @FechaCreacion  2018/02/27
     *
     * @route /backend/content/content-articles/edit-content-article
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
                    'title' => 'Artículos de Contenido', 
                    'message' => 'Por favor seleccione un Artículo de Contenido para poder editarlo.', 
                    'class' => 'error',
                ];
                return response()->json($aResponseData, 200);
            }
            $request->session()->flash('errorMsg', 'Por favor seleccione un Artículo de Contenido para poder editarlo.');
            return back();
        }

        $oContentArticle = ContentArticle::find($sId);
        
        if( ! is_object($oContentArticle)){
            if($request->ajax()){
                $aResponseData = [
                    'type' => 'alert', 
                    'title' => 'Artículos de Contenido', 
                    'message' => 'El artículo de contenido que usted a seleccionado no existe, por favor seleccione otro.', 
                    'class' => 'error',
                ];
                return response()->json($aResponseData, 200);
            }
            $request->session()->flash('errorMsg', 'El artículo de contenido que usted a seleccionado no existe, por favor seleccione otro.');
            return back();    
        }


        $data = [
            // Datos generales para todas las vistas
            'activeMenu' => $this->activeMenu,
            'oConfiguration' => $this->oConfiguration,

            // Datos especificos para utilizar en la vista
            'oStorage' => $this->oStorage,
            'oContentArticle' => $oContentArticle,
            'sContentCategoryId' => $oContentArticle->content_category_id,
        ];
        $view = view('backend.content.content-articles.addEditContentArticle', $data);

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
     * Metodo para actualizar la informacion de un articulo de contenido que llega desde el formulario
     * @Autor Raúl Chauvin
     * @FechaCreacion  2018/02/27
     *
     * @route /backend/content/content-articles/edit-content-article
     * @method PUT/PATCH
     * @param  string $sId
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(ContentArticleUpdateRequest $request, $sId = '')
    {

    	if( ! $request->ajax() ){
            $request->session()->flash('errorMsg', 'Unicamente se aceptan peticiones Ajax');
            return back();
        }

        if( ! $sId){
            $aResponseData = [
                'status' => false, 
                'message' => 'Por favor seleccione un Artículo de Contenido para poder editarlo.', 
            ];
            return response()->json($aResponseData, 200);
        }

        $oContentArticle = ContentArticle::find($sId);
        
        if( ! is_object($oContentArticle)){
            $aResponseData = [
                'status' => false, 
                'message' => 'El artículo de contenido que usted a seleccionado no existe, por favor seleccione otro.', 
            ];
            return response()->json($aResponseData, 200);
        }

        

        $oContentArticle->title = $request->title;
        $oContentArticle->slug = $this->oSlugify->slugify($request->title);
        $oContentArticle->summary = $request->summary;
        $oContentArticle->content = $request->content;
        $oContentArticle->author = $request->author;
        $oContentArticle->author_email = $request->author_email;
        $oContentArticle->source = $request->source;
        $oContentArticle->tags = $request->tags;
        $oContentArticle->outstanding = $request->outstanding;
        $oContentArticle->main_category = 0;
        $oContentArticle->main_home = 0;
        $oContentArticle->meta_description = $request->meta_description;
        $oContentArticle->meta_keywords = $request->meta_keywords;
        $oContentArticle->extra_headers = $request->extra_headers;
        $oContentArticle->content_category_id = $request->content_category_id;

        $oldMainMultimedia = $oContentArticle->main_multimedia;
        if($request->hasFile('main_multimedia')){
            $mainImage = $request->file('main_multimedia');
            $name = $mainImage->getClientOriginalName();
            $path = $mainImage->storePubliclyAs('content-articles/'.$request->content_category_id,$name, ['disk' => $this->sStorageDisk]);
            $oContentArticle->main_multimedia = $path;
        }

        if($oContentArticle->save()){
            if($oldMainMultimedia != $oContentArticle->main_multimedia && $oldMainMultimedia != ''){
                $this->oStorage->delete($oldMainMultimedia);
            }	
            return response()->json(['status' => true , 'message' => 'Artículo de contenido '.$oContentArticle->title.' guardado exitosamente.',], 200);
        }else{
            return response()->json(['status' => false , 'message' => 'Artículo de contenido '.$oContentArticle->title.' no pudo ser guardado. Por favor intentelo nuevamente luego de unos minutos',], 200);
        }
    }


    /**
     * Metodo para eliminar un articulo de contenido seleccionado previamente por su ID
     * @Autor Raúl Chauvin
     * @FechaCreacion  2018/02/27
     *
     * @route /backend/content/content-articles/delete-content-article
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
                'message' => 'Por favor seleccione un Artículo de Contenido para poder eliminarlo.', 
            ];
            return response()->json($aResponseData, 200);
        }

        $oContentArticle = ContentArticle::find($sId);
        
        if( ! is_object($oContentArticle)){
            $aResponseData = [
                'status' => false, 
                'message' => 'El artículo de contenido que usted a seleccionado no existe, por favor seleccione otro.', 
            ];
            return response()->json($aResponseData, 200);
        }

        $oldMainMultimedia = $oContentArticle->main_multimedia;

        if($oContentArticle->delete()){
            if($oldMainMultimedia != ''){
                $this->oStorage->delete($oldMainMultimedia);
            }
            return response()->json(['status' => true, 'message' => 'El artículo de contenido '.$oContentArticle->title.' ha sido eliminado exitosamente.',], 200);    
        }else{
            return response()->json(['status' => false, 'message' => 'El artículo de contenido '.$oContentArticle->title.' no pudo ser eliminado, por favor intentelo nuevamente luego de unos minutos.',], 200);    
        }
    }
}
