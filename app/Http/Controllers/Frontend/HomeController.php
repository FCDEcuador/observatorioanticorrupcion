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
use BlaudCMS\LegalLibrary;
use BlaudCMS\MetaTag;
use BlaudCMS\SuccessStory;
use BlaudCMS\MainSlider;
use BlaudCMS\HomeField;

use SEOMeta;
use OpenGraph;
use Twitter;
use SEO;

use Storage;
use Auth;

/**
* Clase para mostrar el home del sitio web
* @Autor Raúl Chauvin
* @FechaCreacion  2019/02/16
*/

class HomeController extends Controller
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
     * Instancia del modelo.
     *
     * @var homeField
     */
    private $oHomeField;

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

        // Instanciamos el objeto de configuracion para obtener su data, si no existe creamos un nuevo objeto
        $oHomeField = HomeField::find(1);
        if( ! is_object($oHomeField)){
            $oHomeField = new HomeField;
            $oHomeField->id = 1;
            $oHomeField->save();
        }
        $this->oHomeField = $oHomeField;

        $this->sStorageDisk = 'public';
        $this->oStorage = Storage::disk($this->sStorageDisk);
    }


    /**
     * Metodo para mostrar el home del sitio
     * @Autor Raúl Chauvin
     * @FechaCreacion  2019/02/16
     *
     * @route /
     * @method GET
     * @return \Illuminate\Http\Response
     */
    public function home(Request $request){

        $aMetas = MetaTag::all();
        $title = $this->oConfiguration->title_website ? $this->oConfiguration->title_website : 'Inicio';
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

        $oContentCategory = ContentCategory::has('contentArticles')->inRandomOrder()->first();

        $data = [
    		// Datos de configuracion general del sitio
            'title' => $title,
            'oConfiguration' => $this->oConfiguration,
            'oStorage' => $this->oStorage,
            'mainSliders' => MainSlider::active()->orderBy('order', 'asc')->get(),

            // menus de navegacion
            'topMenuItems' => $oTopMenu ? $oTopMenu->menuItems()->firstLevel()->orderBy('order', 'asc')->get() : null,

            // Datos para el contenido de la pagina
            'oHomeField' => $this->oHomeField,
            'numCases' => CorruptionCase::count(),
            'aCaseStageList' => CorruptionCase::select(\DB::raw('case_stage, case_stage_detail, count(id) as numCases'))
                                              ->groupBy('case_stage', 'case_stage_detail')
                                              ->orderBy('numCases', 'asc')
                                              ->get(),
            'corruptionCasesList' => CorruptionCase::orderBy('created_at', 'desc')->skip(0)->take(3)->get(),
            'caseStages' => Catalogue::byContext('Etapa Actual del Caso')->get(),
            'oContentCategory' => $oContentCategory,
            'oSuccessStory' => SuccessStory::orderBy('created_at', 'desc')->first(),
    	];

    	$view = view('frontend.home', $data);
        
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
