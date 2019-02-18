<?php

namespace BlaudCMS\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use BlaudCMS\Http\Controllers\Controller;

use BlaudCMS\Message;
use BlaudCMS\Configuration;

use Storage;
use Auth;

/**
* Clase para manejo de dashboard del CMS
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

        $this->sStorageDisk = config('app.env') == 'production' ? 's3' : 'local';
        $this->oStorage = config('app.env') == 'production' ? Storage::disk('s3') : Storage::disk('local');
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

        $data = [
    		'oConfiguration' => $this->oConfiguration,
            'oStorage' => $this->oStorage,
            'env' => config('app.env'),

            // Datos para el dashboard
            
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
