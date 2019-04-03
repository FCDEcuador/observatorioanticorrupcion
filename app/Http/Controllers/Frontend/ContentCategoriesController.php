<?php

namespace BlaudCMS\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use BlaudCMS\Http\Controllers\Controller;

use BlaudCMS\Message;
use BlaudCMS\Configuration;
use BlaudCMS\Menu;
use BlaudCMS\MenuItem;
use BlaudCMS\Catalogue;
use BlaudCMS\ContentCategory;
use BlaudCMS\ContentArticle;
use BlaudCMS\CorruptionCase;
use BlaudCMS\WhatHappened;
use BlaudCMS\LegalLibrary;
use BlaudCMS\MetaTag;
use BlaudCMS\SuccessStory;
use BlaudCMS\MainSlider;

use BlaudCMS\Helpers\TimeFormat;

use SEOMeta;
use OpenGraph;
use Twitter;
use SEO;

use Storage;
use Auth;

/**
* Clase para seccion de contenido (categorias y articulos)
* @Autor Raúl Chauvin
* @FechaCreacion  2019/02/16
*/

class ContentCategoriesController extends Controller
{
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
     * Constructor del Controller, iniciamos los middlewares para validar que el usuario tenga los permisos correctos
     * @Autor Raúl Chauvin
     * @FechaCreacion  2017/05/15
     */
    public function __construct(){
    	
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
    }


    /**
     * Metodo para mostrar la pantalla de lista de articulos de una categoria de contenido
     * @Autor Raúl Chauvin
     * @FechaCreacion  2019/02/16
     *
     * @route /{aContentCategorySlug}
     * @method GET / POST
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $sContentCategorySlug = ''){

    	if( ! $sContentCategorySlug){
            return redirect()->route('home');
        }
        
        $oContentCategory = ContentCategory::bySlug($sContentCategorySlug);

        if( ! is_object($oContentCategory)){
            if($request->ajax()){
                $aResponseData = [
                    'type' => 'alert', 
                    'title' => 'Observatorio Anti Corrupcion', 
                    'message' => 'UPS!. Parece que la sección que seleccionaste no existe o fue movida.', 
                    'class' => 'error',
                ];
                return response()->json($aResponseData, 404);
            }
            abort('404', 'UPS!. Parece que la sección que seleccionaste no existe o fue movida.');
        }
        
        $aMetas = MetaTag::all();
        $title = $oContentCategory->name;
        SEO::setTitle($title);

        if($aMetas->isNotEmpty()){
            foreach($aMetas as $metaTag){
                if($metaTag->name == 'description'){
                    SEO::setDescription($metaTag->value);
                }elseif($metaTag->name == 'keywords'){
                    SEOMeta::addKeyword(explode(',', $metaTag->value));
                }else{
                    SEOMeta::addMeta($metaTag->name, $metaTag->value, $metaTag->type);
                }
            }
        }
        if($oContentCategory->meta_description != ''){
        	SEO::setDescription($oContentCategory->meta_description);
        }
        if($oContentCategory->meta_keywords != ''){
        	SEOMeta::addKeyword(explode(',', $oContentCategory->meta_keywords));
        }

        // SEO::opengraph()->setUrl('http://current.url.com');
        // SEO::setCanonical('https://codecasts.com.br/lesson');
        //  SEO::opengraph()->addProperty('type', 'articles');
        // SEO::twitter()->setSite('@LuizVinicius73');

        $oTopMenu = Menu::byName('Menu Principal Superior');

        $data = [
    		// Datos de configuracion general del sitio
            'title' => $title,
            'oConfiguration' => $this->oConfiguration,
            'oStorage' => $this->oStorage,
            'mainSliders' => MainSlider::active()->orderBy('order', 'asc')->get(),

            // menus de navegacion
            'topMenuItems' => $oTopMenu ? $oTopMenu->menuItems()->firstLevel()->orderBy('order', 'asc')->get() : null,

            // Datos para el contenido de la pagina
            'oContentCategory' => $oContentCategory,
            'outstandingContentArticlesList' => $oContentCategory->contentArticles()->outstandings()->take(3)->orderBy('created_at', 'desc')->get(),
            'contentArticlesList' => $oContentCategory->contentArticles()->noOutstandings()->orderBy('created_at', 'desc')->paginate(3),
    	];

    	$view = view('frontend.content-category', $data);
        
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
     * Metodo para mostrar la pantalla de lista de articulos de una categoria de contenido
     * @Autor Raúl Chauvin
     * @FechaCreacion  2019/02/16
     *
     * @route /{sContentCategorySlug}/{sContentArticleSlug}
     * @method GET / POST
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $sContentCategorySlug = '', $sContentArticleSlug = ''){

    	if( ! $sContentCategorySlug){
            return redirect()->route('home');
        }
        
        $oContentCategory = ContentCategory::bySlug($sContentCategorySlug);

        if( ! is_object($oContentCategory)){
            if($request->ajax()){
                $aResponseData = [
                    'type' => 'alert', 
                    'title' => 'Observatorio Anti Corrupcion', 
                    'message' => 'UPS!. Parece que la sección que seleccionaste no existe o fue movida.', 
                    'class' => 'error',
                ];
                return response()->json($aResponseData, 404);
            }
            abort('404', 'UPS!. Parece que la sección que seleccionaste no existe o fue movida.');
        }

        if( ! $sContentArticleSlug){
            return redirect()->route('content-category', [$oContentCategory->slug]);
        }
        
        $oContentArticle = ContentArticle::bySlug($sContentArticleSlug);

        if( ! is_object($oContentArticle)){
            if($request->ajax()){
                $aResponseData = [
                    'type' => 'alert', 
                    'title' => 'Observatorio Anti Corrupcion', 
                    'message' => 'UPS!. Parece que la sección que seleccionaste no existe o fue movida.', 
                    'class' => 'error',
                ];
                return response()->json($aResponseData, 404);
            }
            return redirect()->route('content-category', [$oContentCategory->slug]);
        }
        
        $aMetas = MetaTag::all();
        $title = $oContentCategory->name;
        SEO::setTitle($title);

        if($aMetas->isNotEmpty()){
            foreach($aMetas as $metaTag){
                if($metaTag->name == 'description'){
                    SEO::setDescription($metaTag->value);
                }elseif($metaTag->name == 'keywords'){
                    SEOMeta::addKeyword(explode(',', $metaTag->value));	
                }else{
                    SEOMeta::addMeta($metaTag->name, $metaTag->value, $metaTag->type);
                }
            }
        }
        if($oContentArticle->meta_description){
        	SEO::setDescription($oContentArticle->meta_description);
        }elseif($oContentCategory->meta_description != ''){
        	SEO::setDescription($oContentCategory->meta_description);
        }
        if($oContentArticle->meta_keywords){
        	SEO::setDescription($oContentArticle->meta_keywords);
        }elseif($oContentCategory->meta_keywords != ''){
        	SEOMeta::addKeyword(explode(',', $oContentCategory->meta_keywords));
        }

        // SEO::opengraph()->setUrl('http://current.url.com');
        // SEO::setCanonical('https://codecasts.com.br/lesson');
        //  SEO::opengraph()->addProperty('type', 'articles');
        // SEO::twitter()->setSite('@LuizVinicius73');

        $oTopMenu = Menu::byName('Menu Principal Superior');

        $data = [
    		// Datos de configuracion general del sitio
            'title' => $title,
            'oConfiguration' => $this->oConfiguration,
            'oStorage' => $this->oStorage,
            'mainSliders' => MainSlider::active()->orderBy('order', 'asc')->get(),

            // menus de navegacion
            'topMenuItems' => $oTopMenu ? $oTopMenu->menuItems()->firstLevel()->orderBy('order', 'asc')->get() : null,

            // Datos para el contenido de la pagina
            'contentCategoriesList' => ContentCategory::has('contentArticles')->get(),
            'oContentCategory' => $oContentCategory,
            'oContentArticle' => $oContentArticle,
            'contentArticlesListRecent' => $oContentCategory->contentArticles()->outstandings()->take(2)->orderBy('created_at', 'desc')->get(),
            'contentArticlesList' => $oContentCategory->contentArticles()->noOutstandings()->orderBy('created_at', 'desc')->paginate(2),
    	];

    	$view = view('frontend.content-article', $data);
        
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
}
