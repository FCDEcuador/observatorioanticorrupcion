<?php

namespace BlaudCMS\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use BlaudCMS\Http\Controllers\Controller;

use BlaudCMS\Mail\ContactForm;
use Illuminate\Support\Facades\Mail;

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

use BlaudCMS\Http\Requests\Frontend\ContactFormRequest;

use SEOMeta;
use OpenGraph;
use Twitter;
use SEO;

use Storage;
use Auth;

/**
* Clase para manejo de dashboard del CMS
* @Autor Raúl Chauvin
* @FechaCreacion  2019/02/16
*/

class StaticPagesController extends Controller
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
     * Metodo para mostrar la pantalla 'Sobre Nosotros' del observatorio
     * @Autor Raúl Chauvin
     * @FechaCreacion  2019/02/16
     *
     * @route /sobre-el-observatorio
     * @method GET
     * @return \Illuminate\Http\Response
     */
    public function about(Request $request){

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

        $data = [
    		// Datos de configuracion general del sitio
            'title' => $title,
            'oConfiguration' => $this->oConfiguration,
            'oStorage' => $this->oStorage,
            'mainSliders' => MainSlider::active()->orderBy('order', 'asc')->get(),

            // menus de navegacion
            'topMenuItems' => $oTopMenu ? $oTopMenu->menuItems()->firstLevel()->orderBy('order', 'asc')->get() : null,
    	];

    	$view = view('frontend.about-us', $data);
        
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
     * Metodo para mostrar la pantalla del formulario de contacto del observatorio
     * @Autor Raúl Chauvin
     * @FechaCreacion  2019/02/16
     *
     * @route /contactenos
     * @method GET
     * @return \Illuminate\Http\Response
     */
    public function contact(Request $request){

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

        $data = [
    		// Datos de configuracion general del sitio
            'title' => $title,
            'oConfiguration' => $this->oConfiguration,
            'oStorage' => $this->oStorage,
            'mainSliders' => MainSlider::active()->orderBy('order', 'asc')->get(),

            // menus de navegacion
            'topMenuItems' => $oTopMenu ? $oTopMenu->menuItems()->firstLevel()->orderBy('order', 'asc')->get() : null,
    	];

    	$view = view('frontend.contact-us', $data);
        
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
     * Metodo para enviar el email con los datos del formulario de contacto
     * @Autor Raúl Chauvin
     * @FechaCreacion  2019/02/16
     *
     * @route /contactenos
     * @method GET
     * @param BlaudCMS\Http\Requests\Frontend\ContactFormRequest $request
     * @return \Illuminate\Http\Response
     */
    public function contactSend(ContactFormRequest $request){

        if( ! $request->ajax() ){
            $request->session()->flash('errorMsg', 'Unicamente se aceptan peticiones Ajax');
            return back();
        }

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'subject' => $request->subject,
            'message' => $request->message,
        ];

        if($this->oConfiguration->contact_emails != ''){
            $aEmails = explode(',', $this->oConfiguration->contact_emails);
            if(count($aEmails)){
                foreach($aEmails as $email){
                    if( ! empty($email)){
                        Mail::to($email)->send(new ContactForm($data));
                    }
                }
            }
        }

        return response()->json(['status' => true , 'message' => 'Muchas gracias, sus comentarios y sugerencias han sido enviadas correctamente.',], 200);
    }
}
