<?php

namespace BlaudCMS;

use Illuminate\Database\Eloquent\Model;
use Alsofronie\Uuid\UuidModelTrait;

/**
* Clase para administración de Categorias o Secciones de Contenido
* @Autor Raúl Chauvin
* @FechaCreacion  2017/06/07
* @Content
*/

class ContentCategory extends Model
{
    use UuidModelTrait;

    /**
     * Tabla de la Base de Datos usada por el modelo.
     *
     * @var string
     */
    protected $table = 'content_categories';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
        'title',
        'subtitle',
        'tags',
        'meta_description',
        'meta_keywords',
        'extra_headers',
        'active',
        'num_list_items',
        'advertising_positions',
        'hits',
        'content_category_id',
        'created_by',
        'updated_by',
    ];

    /**
     * Atributos generados automáticamente por el modelo.
     *
     * @var array
     */
    protected $guarded = [
        'created_at', 
        'updated_at', 
        'id',
    ];

    /**
     * Método que guarda en la base de datos los tags de la categoria en formato JSON
     * @Autor Raúl Chauvin
     * @FechaCreacion  2017/06/08
     *
     * @param string tags
     *
     */
    public function setTagsAttribute($tags){
        $this->attributes['tags'] = json_encode($tags);
    }

    /**
     * Método que devuelve los tags de la categoria en formato array luego de convertir el JSON
     * @Autor Raúl Chauvin
     * @FechaCreacion  2017/06/08
     *
     * @param string tags
     *
     */
    public function getTagsAttribute($tags){
    	return json_decode($tags);
    }

    /**
     * Método que guarda en la base de datos las posiciones de publicidad de la categoria en formato JSON
     * @Autor Raúl Chauvin
     * @FechaCreacion  2017/06/08
     *
     * @param string advertisingPositions
     *
     */
    public function setAdvertisingPositionsAttribute($advertisingPositions){
        $this->attributes['advertising_positions'] = json_encode($advertisingPositions);
    }

    /**
     * Método que devuelve las posiciones de publicidad de la categoria en formato array luego de convertir el JSON
     * @Autor Raúl Chauvin
     * @FechaCreacion  2017/06/08
     *
     * @param string advertisingPositions
     *
     */
    public function getAdvertisingPositionsAttribute($advertisingPositions){
    	return json_decode($advertisingPositions);
    }

    /*****************************************************************
    	Autor Raúl Chauvin
    	FechaCreacion  2017/06/07
    	Metodos para construir relaciones en ORM
    ******************************************************************/

    // ContentCategory __belongs_to__ ContentCategory
    public function superContentCategory() {
        return $this->belongsTo('BlaudCMS\ContentCategory','content_category_id', 'id');
    }

    // ContentCategory __has_many__ ContentCategory
    public function contentCategories() {
        return $this->hasMany('BlaudCMS\ContentCategory','content_category_id', 'id');
    }

    // ContentCategory __has_many__ MultimediaContent
    public function multimediaContents() {
        return $this->hasMany('BlaudCMS\MulimediaContent','content_category_id', 'id');
    }

    // ContentCategory __has_many__ ContentArticle
    public function contentArticles() {
        return $this->hasMany('BlaudCMS\ContentArticle','content_category_id', 'id');
    }


    /*************************************************************************************************
        Metodos scope para utilizar en el controlador
        Autor Raúl Chauvin
        FechaCreacion  2017/06/08
        EJ:
        $aActiveCategories = ContentCategory::active()->get();
        $aActiveCategoriesNoStatics = ContentCategory::active()->noStatics()->get();
    **************************************************************************************************/

    public function scopeActive($sQuery){
        return $sQuery->whereActive(1);
    }

    public function scopeInactive($sQuery){
        return $sQuery->whereActive(0);
    }

    
    public function scopeNoStatics($sQuery){
    	return $sQuery->where(function($sQuery){
    		$sQuery->where('id','<>', 1) // HOME
    		->where('id','<>', 2);		 // STATICS PAGES
    	})
    }

    /**
     * Metodo que verifica si una categoria de contenido es estatica (Home o Static Pages).
     * @Autor Raúl Chauvin
     * @FechaCreacion  2017/06/08
     *
     * @param int iId?
     * @return bool
     */
    public static function isStaticContentCategory($iId = ''){
        if($iId){
        	$oContentCategory = ContentCategory::find($iId);
        	if($oContentCategory){
        		return ($oContentCategory->id == 1 || $oContentCategory == 2) ? TRUE : FALSE;
        	}
        }
        return FALSE;
    }

    /**
     * Metodo que verifica si una categoria de contenido tiene subcategorias.
     * @Autor Raúl Chauvin
     * @FechaCreacion  2017/06/08
     *
     * @param int iId?
     * @return bool
     */
    public static function hasContentSubcategories($iId = ''){
        if($iId){
        	$oContentCategory = ContentCategory::find($iId);
        	if($oContentCategory){
        		return $oContentCategory->has('contentCategories')->count() ? TRUE : FALSE;
        	}
        }
        return FALSE;
    }

    /**
     * Metodo que verifica si una categoria de contenido es super categoria.
     * @Autor Raúl Chauvin
     * @FechaCreacion  2017/06/08
     *
     * @param int iId?
     * @return bool
     */
    public static function isSuperContentCategory($iId = ''){
        if($iId){
        	$oContentCategory = ContentCategory::find($iId);
        	if($oContentCategory){
        		return ($oContentCategory->content_category_id == "" || $oContentCategory->content_category_id == 0) ? TRUE : FALSE;
        	}
        }
        return FALSE;
    }


    /**
     * Metodo que obtiene la super categoria de una categoria dada.
     * @Autor Raúl Chauvin
     * @FechaCreacion  2017/06/08
     *
     * @param int iId?
     * @return bool
     */
    public static function superContentCategory($iId = ''){
        if($iId){
        	$oContentCategory = ContentCategory::find($iId);
        	if($oContentCategory){
        		return ContentCategory::isSuperCategory($oContentCategory->id) ? 
        													 $oContentCategory : 
        				ContentCategory::superCategory($oContentCategory->content_category_id);
        	}
        }
        return FALSE;
    }


    /**
     * Metodo que verifica si una categoria de contenido esta activa o no.
     * @Autor Raúl Chauvin
     * @FechaCreacion  2017/06/08
     *
     * @param int iId?
     * @return bool
     */
    public static function isActive($iId = ''){
        if($iId){
        	return ContentCategory::find($iId)->active == 1 ? TRUE : FALSE;
        }
        return FALSE;
    }


    /**
    * Metodo que devuelve un modelo ContentCategory encontrado por slug o falso en caso de no encontrarlo
    * @Autor Raúl Chauvin
    * @FechaCreacion  2017/06/08
    *
    * @param string sSlug
    * @return ContentCategory
    */
    public static function bySlug($sSlug = ''){
        return $sSlug ? ContentCategory::whereSlug($sSlug)->first() : FALSE;
    }


    /**
    * Metodo que devuelve un modelo ContentCategory encontrado por name o falso en caso de no encontrarlo
    * @Autor Raúl Chauvin
    * @FechaCreacion  2017/06/08
    *
    * @param string sName
    * @return ContentCategory
    */
    public static function byName($sName = ''){
        return $sName ? ContentCategory::whereName($sName)->first() : FALSE;
    }


    /**
    * Metodo que busca categorias de contenido de acuerdo a una cadena buscada
    * @Autor Raúl Chauvin
    * @FechaCreacion  2017/06/08
    *
    * @param string sStringSearch
    * @param integer iActive
    * @param integer iPaginate
    * @return ContentCategory[] 
    */
    public static function searchContentCategory($sStringSearch = '', $iActive = '', $iPaginate = 20){
        if($sStringSearch){
            $aListCategories = ContentCategory::where(function($sQuery) use ($sStringSearch){
            						->$sQuery->where('id','like','%'.$sStringSearch.'%')
                                    ->orWhere('name','like','%'.$sStringSearch.'%')
                                    ->orWhere('title','like','%'.$sStringSearch.'%')
                                    ->orWhere('subtitle','like','%'.$sStringSearch.'%')
                                    ->orWhere('tags','like','%'.$sStringSearch.'%');
            					});
            if($iActive != ''){
            	$aListCategories = $aListCategories->where('active', $iActive);
            }
            $aListCategories = $aListCategories->paginate($iPaginate);
        }else{
        	if($iActive != ''){
            	$aListCategories = ContentCategory::where('active', $iActive)->paginate($iPaginate);
            }else{
            	$aListCategories = ContentCategory::paginate($iPaginate);
            }
        }
        return $aListCategories;
    }
}
