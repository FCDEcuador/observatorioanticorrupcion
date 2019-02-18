<?php

namespace BlaudCMS\Http\Controllers\Backend;

use Illuminate\Http\Request;
use BlaudCMS\Http\Controllers\Controller;

use BlaudCMS\Message;
use BlaudCMS\Configuration;
use BlaudCMS\User;

use Storage;

use Flashy;
use Auth;

/**
* Clase para manejo de dashboard del CMS
* @Autor Raúl Chauvin
* @FechaCreacion  2018/08/30
* @Parametrization
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
     * Variable para verificar cual menu debe estar activo.
     *
     * @var activeMenu
     */
    private $activeMenu;

    /**
     * Variable para almacenar la lista de mensajes no leidos.
     *
     * @var unreadMessages
     */
    private $unreadMessages;

    /**
     * Variable para almacenar la cantidad de mensajes no leidos.
     *
     * @var cantUnreadMessages
     */
    private $cantUnreadMessages;

    /**
     * Constructor del Controller, iniciamos los middlewares para validar que el usuario tenga los permisos correctos
     * @Autor Raúl Chauvin
     * @FechaCreacion  2017/05/15
     */
    public function __construct(){
    	
    	// Agregando restriccion para usuarios logueados y que sean de backend
    	$this->middleware('auth');
        $this->middleware('reporter');

        // Obteniendo ultimos mensajes no leidos y la cantidad total de los mismos
        $this->unreadMessages = Message::unread()->orderBy('created_at', 'DESC')->limit(10)->get();
        $this->cantUnreadMessages = Message::unread()->count();

        // Instanciamos el objeto de configuracion para obtener su data, si no existe creamos un nuevo objeto
        $oConfiguration = Configuration::find(1);
        if( ! is_object($oConfiguration)){
            $oConfiguration = new Configuration;
            $oConfiguration->id = 1;
            $oConfiguration->save();
        }
        $this->oConfiguration = $oConfiguration;

        $this->sStorageDisk = config('app.env') == 'production' ? 's3' : 'local';
        $this->oStorage = config('app.env') == 'production' ? Storage::disk('s3') : Storage::disk('local');

        // Colocamos el valor en la variable $this->activeMenu 
        // para saber que item del menu de navegacion debe pintarse
        $this->activeMenu = 'dashboard';
    }


    /**
     * Metodo para mostrar el dashboard
     * @Autor Raúl Chauvin
     * @FechaCreacion  2018/01/24
     *
     * @route /backend/dashboard
     * @method GET
     * @return \Illuminate\Http\Response
     */
    public function dashboard(){

        $data = [
    		'cantUnreadMessages' => $this->cantUnreadMessages,
    		'unreadMessages' => $this->unreadMessages,
            'oConfiguration' => $this->oConfiguration,
            'oStorage' => $this->oStorage,
            'env' => config('app.env'),
            'activeMenu' => $this->activeMenu,

            // Datos para el dashboard
            
    	];

    	// Si existen mensajes sin leer, mostramos en el dashboard una notificacion push al usuario
    	if($this->cantUnreadMessages){
    		Flashy::message('Existen '.$this->cantUnreadMessages.' mensajes sin leer en la bandeja de entrada');
    	}

        $view = view('backend.dashboard', $data);
        
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
