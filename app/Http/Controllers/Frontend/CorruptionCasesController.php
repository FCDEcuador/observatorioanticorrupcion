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

use SEOMeta;
use OpenGraph;
use Twitter;
use SEO;

use Storage;
use Auth;

/**
* Clase para seccion de casos de corrupcion
* @Autor Raúl Chauvin
* @FechaCreacion  2019/02/16
*/

class CorruptionCasesController extends Controller
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
     * Metodo para mostrar la pantalla de lista de casos de corrupcion
     * @Autor Raúl Chauvin
     * @FechaCreacion  2019/02/16
     *
     * @route /casos-de-corrupcion
     * @method GET / POST
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){

        $aMetas = MetaTag::all();
        $title = 'Casos de Corrupción';
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
            'caseStageList' => Catalogue::byContext('Etapa Actual del Caso')->get(),
            'provinceList' => Catalogue::byContext('Provincias')->get(),
            'stateFunctionList' => Catalogue::byContext('Función del Estado')->get(),
            'corruptionCasesList' => CorruptionCase::searchCorruptionCases($request->sStringSearch, $request->sCaseStage, null, $request->sProvince, $request->sStateFunction, 6),
    	];

    	$view = view('frontend.corruption-cases', $data);
        
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
     * Metodo que devuelve el detalle de un caso de corrupcion en formato JSON
     * @Autor Raúl Chauvin
     * @FechaCreacion  2019/02/16
     *
     * @route /casos-de-corrupcion/json/
     * @method GET
     * @return \Illuminate\Http\Response
     */
    public function detail(Request $request, $sCorruptionCaseId){
    	if( ! $sCorruptionCaseId){
    		return response()->json(['status' => false, 'oCorruptionCase' => [], 'message' => 'Por favor seleccione un caso de corrupcion para ver su detalle'], 200);
    	}

    	$oCorruptionCase = CorruptionCase::find($sCorruptionCaseId);

    	if( ! is_object($oCorruptionCase)){
    		return response()->json(['status' => false, 'oCorruptionCase' => [], 'message' => 'El caso de corrupción que usted a seleccionado no existe, por favor seleccione otro.'], 200);
    	}
    	$minYear = $oCorruptionCase->whatsHappeneds()->min('year');
    	$maxYear = $oCorruptionCase->whatsHappeneds()->max('year');

        $periodValue = $minYear.' - '.$maxYear;

        if($minYear == $maxYear){
            $periodValue = $minYear;
        }
    	
    	$oCorruptionCaseParse = [
    		'case_stage' => $oCorruptionCase->case_stage,
	        'case_stage_detail' => $oCorruptionCase->case_stage_detail,
	        'province' => $oCorruptionCase->province,
	        'state_function' => $oCorruptionCase->state_function,
	        'involved_number' => $oCorruptionCase->involved_number,
	        'linked_institutions' => $oCorruptionCase->linked_institutions,
	        'public_officials_involved' => $oCorruptionCase->public_officials_involved,
	        'main_multimedia' => $this->oStorage->url($oCorruptionCase->home_image),
	        'title' => $oCorruptionCase->title,
	        'summary' => $oCorruptionCase->summary,
	        'url' => route('corruption-cases.show', [$oCorruptionCase->slug]),
	        'period' => $periodValue,
    	];
    	return response()->json(['status' => true, 'oCorruptionCase' => $oCorruptionCaseParse, 'message' => ''], 200);
    }



    /**
     * Metodo que muestra la pantalla de detalle de un caso de corrupcion de acuerdo a su slug
     * @Autor Raúl Chauvin
     * @FechaCreacion  2019/02/16
     *
     * @route /casos-de-corrupcion/{sCorruptionCaseSlug}
     * @method GET
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $sCorruptionCaseSlug){
    	
    	if( ! $sCorruptionCaseSlug){
            if($request->ajax()){
                $aResponseData = [
                    'type' => 'alert', 
                    'title' => 'Casos de Corrupcion', 
                    'message' => 'Por favor seleccione un Caso de Corrupcion para poder ver su detalle.', 
                    'class' => 'error',
                ];
                return response()->json($aResponseData, 200);
            }
            $request->session()->flash('errorMsg', 'Por favor seleccione un Caso de Corrupcion para poder ver su detalle.');
            return back();
        }
        
        $oCorruptionCase = CorruptionCase::bySlug($sCorruptionCaseSlug);

        if( ! is_object($oCorruptionCase)){
            if($request->ajax()){
                $aResponseData = [
                    'type' => 'alert', 
                    'title' => 'Casos de Corrupción', 
                    'message' => 'El Caso de COrrupcion seleccionado no existe. Por favor seleccione otro.', 
                    'class' => 'error',
                ];
                return response()->json($aResponseData, 404);
            }
            abort('404', 'El Caso de Corrupcion seleccionado no existe. Por favor seleccione otro.');
        }
    	
    	$aMetas = MetaTag::all();
        $title = $oCorruptionCase->title;
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
            'oCorruptionCase' => $oCorruptionCase,
            'corruptionCasesList' => CorruptionCase::where('id', '<>', $oCorruptionCase->id)->take(2)->inRandomOrder()->get(),
    	];

    	$view = view('frontend.corruption-case-detail', $data);
        
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
     * Metodo que descarga el caso de corrupcion en formato PDF
     * @Autor Raúl Chauvin
     * @FechaCreacion  2019/02/16
     *
     * @route /casos-de-corrupcion/pdf/{sCorruptionCaseSlug}
     * @method GET
     * @return \Illuminate\Http\Response
     */
    public function downloadPdf(Request $request, $sCorruptionCaseSlug){
        
        if( ! $sCorruptionCaseSlug){
            if($request->ajax()){
                $aResponseData = [
                    'type' => 'alert', 
                    'title' => 'Casos de Corrupcion', 
                    'message' => 'Por favor seleccione un Caso de Corrupcion para poder ver su detalle.', 
                    'class' => 'error',
                ];
                return response()->json($aResponseData, 200);
            }
            $request->session()->flash('errorMsg', 'Por favor seleccione un Caso de Corrupcion para poder ver su detalle.');
            return back();
        }
        
        $oCorruptionCase = CorruptionCase::bySlug($sCorruptionCaseSlug);

        if( ! is_object($oCorruptionCase)){
            if($request->ajax()){
                $aResponseData = [
                    'type' => 'alert', 
                    'title' => 'Casos de Corrupción', 
                    'message' => 'El Caso de COrrupcion seleccionado no existe. Por favor seleccione otro.', 
                    'class' => 'error',
                ];
                return response()->json($aResponseData, 404);
            }
            abort('404', 'El Caso de Corrupcion seleccionado no existe. Por favor seleccione otro.');
        }

        $aMetas = MetaTag::all();
        $title = $oCorruptionCase->title;
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
            'oCorruptionCase' => $oCorruptionCase,
            'corruptionCasesList' => CorruptionCase::where('id', '<>', $oCorruptionCase->id)->take(0)->inRandomOrder()->get(),
        ];

        $headerHtml = view()->make('frontend.corruption-case-detail-pdf-header')->render();
        $footerHtml = view()->make('frontend.corruption-case-detail-pdf-footer')->render();

        $pdf = \PDF::loadView('frontend.corruption-case-detail-pdf', $data);
        \PDF::setOptions('header-html', $headerHtml);
        \PDF::setOptions('footer-html', $footerHtml);
            
        return $pdf->download($oCorruptionCase->slug.'.pdf');
    }
}
