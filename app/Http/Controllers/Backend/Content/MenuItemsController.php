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
use BlaudCMS\CorruptionCase;
use BlaudCMS\SuccessStory;
use BlaudCMS\LegalLibrary;
use BlaudCMS\Menu;
use BlaudCMS\MenuItem;

use Cocur\Slugify\Slugify;

use BlaudCMS\Http\Requests\Content\MenuItemCreateRequest;
use BlaudCMS\Http\Requests\Content\MenuItemUpdateRequest;

use Storage;
use Auth;

/**
* Clase para manejo de meta tags del portal web
* @Autor Raúl Chauvin
* @FechaCreacion  2018/08/30
* @Parametrization
*/

class MenuItemsController extends Controller
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
     * Metodo para mostrar la lista de items de menu del sistema
     * @Autor Raúl Chauvin
     * @FechaCreacion  2018/03/12
     *
     * @route /backend/content/menu-items/list
     * @method GET
     * @param  string $sMenuId
     * @param  string $sMenuItemId
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $sMenuId = '', $sMenuItemId = '')
    {
        $data = [
            'activeMenu' => $this->activeMenu,
            'oConfiguration' => $this->oConfiguration,
            'oStorage' => $this->oStorage,
        ];

        if($sMenuId){
            $oMenu = Menu::find($sMenuId);
            if($oMenu){
                $menuItemsList = $oMenu->menuItems()->firstLevel()->orderBy('order', 'asc')->paginate(20);
                if($sMenuItemId){
                    $oMenuItem = MenuItem::find($sMenuItemId);
                    if($oMenuItem){
                        $menuItemsList = $oMenuItem->menuItems()->orderBy('order', 'asc')->paginate(20);
                    }
                }
                $data['oMenu'] = $oMenu;
                $data['menuItemsList'] = $menuItemsList;
                
                $view = view('backend.content.menu-items.menuItemsList', $data);
                
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

        if($sMenuItemId){
            $oMenuItem = MenuItem::find($sMenuItemId);
            if($oMenuItem){
                $menuItemsList = $oMenuItem->menuItems()->orderBy('order', 'asc')->paginate(20);
                $data['oMenu'] = $oMenuItem->menu;
                $data['menuItemsList'] = $menuItemsList;
                
                $view = view('backend.content.menu-items.menuItemsList', $data);
                
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

        $data['menusList'] = Menu::paginate(20);

        $view = view('backend.content.menu-items.menusList', $data);
        
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
     * Metodo que devuelve los items de menu de un menu en formato JSON
     * @Autor Raúl Chauvin
     * @FechaCreacion  2018/03/12
     *
     * @route /backend/content/menu-items/list-json
     * @method GET
     * @param  string $sMenuId
     * @return \Illuminate\Http\Response
     */
    public function listJson($sMenuId = '')
    {
        if($sMenuId){
            $oMenu = Menu::find($sMenuId);
            if($oMenu){
                $aMenuItems = $oMenu->menuItems()->orderBy('order', 'asc')->firstLevel()->get();
                return response()->json(['status' => true, 'menuItems' => $aMenuItems], 200);
            }
        }
        return response()->json(['status' => false, 'menuItems' => []], 200);
    }


    /**
     * Metodo para mostrar el formulario de creacion de nuevos items de menu
     * @Autor Raúl Chauvin
     * @FechaCreacion  2018/03/12
     *
     * @route /backend/content/menu-items/add
     * @method GET
     * @param  string $sMenuId
     * @param  string $sMenuItemId
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, $sMenuId = '', $sMenuItemId = '')
    {
        $data = [
            'activeMenu' => $this->activeMenu,
            'oConfiguration' => $this->oConfiguration,
            'oStorage' => $this->oStorage,
            
            'menuList' => Menu::pluck('name', 'id'),
            'contentArticlesList' => ContentArticle::all(),
            'successStoriesList' => SuccessStory::all(),
            'corruptionCasesList' => CorruptionCase::all(),
            'legalLibraryList' => LegalLibrary::all(),
            
            'sMenuId' => $sMenuId,
            'sMenuItemId' => $sMenuItemId,
            'oMenuItem' => null,
        ];

        $view = view('backend.content.menu-items.addEditMenuItem', $data);

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
     * Metodo para guardar en la base de datos los nuevos items de menu ingresadas desde el formulario
     * @Autor Raúl Chauvin
     * @FechaCreacion  2018/03/12
     *
     * @route /backend/content/menu-items/add
     * @method POST
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MenuItemCreateRequest $request)
    {
        if( ! $request->ajax() ){
            $request->session()->flash('errorMsg', 'Unicamente se aceptan peticiones Ajax');
            return back();
        }

        $oMenuItem = new MenuItem;
        $oMenuItem->name = $request->name;
        $oMenuItem->title = $request->title;
        $oMenuItem->link = $request->link;
        $oMenuItem->type = $request->type;
        $oMenuItem->target = $request->target;
        $oMenuItem->order = $request->order;
        $oMenuItem->active = $request->active;
        $oMenuItem->menu_item_id = $request->menu_item_id;
        $oMenuItem->menu_id = $request->menu_id;
        $oMenuItem->level = 0;

        if($request->menu_item_id){
            $oSuperMenuItem = MenuItem::find($request->menu_item_id);
            if($oSuperMenuItem){
                $superLevel = $oSuperMenuItem->level;
                $oMenuItem->level = (int)$superLevel + 1;
            }
        }

		if($oMenuItem->save()){        
            return response()->json(['status' => true , 'message' => 'Item de Menu '.$oMenuItem->name.' guardado exitosamente',], 200);
        }else{
        	return response()->json(['status' => false , 'message' => 'Item de Menú '.$oMenuItem->name.' no pudo ser guardado. Por favor intentelo nuevamente luego de unos minutos',], 200);
        }
    }


    /**
     * Metodo para mostrar el formulario de edicion de un item de menu seleccionado previamente por su ID
     * @Autor Raúl Chauvin
     * @FechaCreacion  2018/03/12
     *
     * @route /backend/content/menu-items/edit
     * @method GET
     * @param  string  $sId
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $sId = '')
    {

    	if( ! $sId){
            if($request->ajax()){
                $aResponseData = [
                    'type' => 'alert', 
                    'title' => 'Items de Menú', 
                    'message' => 'Por favor seleccione un Item de Menú para poder editarlo.', 
                    'class' => 'error',
                ];
                return response()->json($aResponseData, 200);
            }
            $request->session()->flash('errorMsg', 'Por favor seleccione un Item de Menú para poder editarlo.');
            return back();
        }

        $oMenuItem = MenuItem::find($sId);
        
        if( ! is_object($oMenuItem)){
            if($request->ajax()){
                $aResponseData = [
                    'type' => 'alert', 
                    'title' => 'Items de Menú', 
                    'message' => 'El item de menú que usted a seleccionado no existe, por favor seleccione otro.', 
                    'class' => 'error',
                ];
                return response()->json($aResponseData, 200);
            }
            $request->session()->flash('errorMsg', 'El item de menú que usted a seleccionado no existe, por favor seleccione otro.');
            return back();    
        }

        $data = [
            'activeMenu' => $this->activeMenu,
            'oConfiguration' => $this->oConfiguration,
            'oStorage' => $this->oStorage,
            
            'menuList' => Menu::pluck('name', 'id'),
            'contentArticlesList' => ContentArticle::all(),
            'successStoriesList' => SuccessStory::all(),
            'corruptionCasesList' => CorruptionCase::all(),
            'legalLibraryList' => LegalLibrary::all(),
            
            'sMenuId' => $oMenuItem->menu_id,
            'sMenuItemId' => $oMenuItem->menu_item_id,
            'oMenuItem' => $oMenuItem,
        ];

        $view = view('backend.content.menu-items.addEditMenuItem', $data);

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
     * Metodo para guardar en la base de datos los cambios realizados a un item de menu previamente seleccionado por su ID
     * @Autor Raúl Chauvin
     * @FechaCreacion  2017/11/24
     *
     * @route /backend/content/menu-items/edit
     * @method PUT/PATCH
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string $sId
     * @return \Illuminate\Http\Response
     */
    public function update(MenuItemUpdateRequest $request, $sId = '')
    {

    	if( ! $request->ajax() ){
            $request->session()->flash('errorMsg', 'Unicamente se aceptan peticiones Ajax');
            return back();
        }

        if( ! $sId){
            $aResponseData = [
                'status' => false, 
                'message' => 'Por favor seleccione un Item de Menú para poder editarlo.', 
            ];
            return response()->json($aResponseData, 200);
        }

        $oMenuItem = MenuItem::find($sId);
        
        if( ! is_object($oMenuItem)){
            $aResponseData = [
                'status' => false, 
                'message' => 'El item de menú que usted a seleccionado no existe, por favor seleccione otro.', 
            ];
            return response()->json($aResponseData, 200);
        }

        $oMenuItem->name = $request->name;
        $oMenuItem->title = $request->title;
        $oMenuItem->link = $request->link;
        $oMenuItem->type = $request->type;
        $oMenuItem->target = $request->target;
        $oMenuItem->order = $request->order;
        $oMenuItem->active = $request->active;
        $oMenuItem->menu_item_id = $request->menu_item_id;
        $oMenuItem->menu_id = $request->menu_id;
        $oMenuItem->level = 0;

        if($request->menu_item_id){
            $oSuperMenuItem = MenuItem::find($request->menu_item_id);
            if($oSuperMenuItem){
                $superLevel = $oSuperMenuItem->level;
                $oMenuItem->level = (int)$superLevel + 1;
            }
        }

		if($oMenuItem->save()){        
            return response()->json(['status' => true , 'message' => 'Item de Menu '.$oMenuItem->name.' actualizado exitosamente',], 200);
        }else{
        	return response()->json(['status' => false , 'message' => 'Item de Menú '.$oMenuItem->name.' no pudo ser actualizado. Por favor intentelo nuevamente luego de unos minutos',], 200);
        }
    }


    /**
     * Metodo para eliminar un item de menu seleccionado previamente por su ID
     * @Autor Raúl Chauvin
     * @FechaCreacion  2018/03/12
     *
     * @route /backend/content/menu-items/delete-menu-item
     * @method DELETE
     * @param  string $sId
     * @return \Illuminate\Http\Response
     */
    public function destroy($sId = '')
    {

    	if( ! $request->ajax() ){
            $request->session()->flash('errorMsg', 'Unicamente se aceptan peticiones Ajax');
            return back();
        }

        if( ! $sId){
            return response()->json(['status' => false, 'message' => 'Por favor seleccione un Item de Menú para poder eliminarlo.'], 200);
        }

        $oMenuItem = MenuItem::find($sId);
        
        if( ! is_object($oMenuItem)){
            $aResponseData = [
                'status' => false, 
                'message' => 'El item de menú que usted a seleccionado no existe, por favor seleccione otro.', 
            ];
            return response()->json($aResponseData, 200);
        }

        $numChildrenMenuItems = $oMenuItem->menuItems()->count();
        $name = $oMenuItem->name;
        if($numChildrenMenuItems){
            return response()->json(['status' => false, 'message' => 'El item de menu '.$name.' no puede ser eliminado debido a que tiene submenus.'], 200);
        }
        if($oMenuItem->delete()){
            return response()->json(['status' => true, 'message' => 'El item de menu '.$name.' ha sido eliminado exitosamente'], 200);
        }else{
            return response()->json(['status' => false, 'message' => 'El item de menu '.$name.' no pudo ser eliminado. Por favor inténtelo nuevamente luego de unos minutos.'], 200);
        }
    }
}
