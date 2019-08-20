<?php

namespace BlaudCMS;

use Illuminate\Database\Eloquent\Model;
use Alsofronie\Uuid\UuidModelTrait;

/**
* Clase para administración de Articulos de Contenido del Sitio (Articulos y paginas estaticas)
* @Autor Raúl Chauvin
* @FechaCreacion  2017/06/08
* @Content
*/

class ContentArticle extends Model
{
    use UuidModelTrait;


    /**
     * Tabla de la Base de Datos usada por el modelo.
     *
     * @var string
     */
    protected $table = 'content_articles';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'slug',
        'summary',
        'content',
        'author',
        'author_email',
        'source',
        'tags',
        'main_multimedia',
        'meta_description',
        'meta_keywords',
        'extra_headers',
        'outstanding',
        'main_category',
        'main_home',
        'content_category_id',
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
     * Método que guarda en la base de datos los tags del articulo de contenido en formato JSON
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
     * Método que devuelve los tags del articulo de contenido en formato array luego de convertir el JSON
     * @Autor Raúl Chauvin
     * @FechaCreacion  2017/06/08
     *
     * @param string tags
     *
     */
    public function getTagsAttribute($tags){
    	return json_decode($tags);
    }

    /*****************************************************************
    	Autor Raúl Chauvin
    	FechaCreacion  2017/06/07
    	Metodos para construir relaciones en ORM
    ******************************************************************/

    // ContentArticle __belongs_to__ ContentCategory
    public function contentCategory() {
        return $this->belongsTo('BlaudCMS\ContentCategory','content_category_id', 'id');
    }


    /*************************************************************************************************
        Metodos scope para utilizar en el controlador
        Autor Raúl Chauvin
        FechaCreacion  2017/06/09
        EJ:
        $aPublishedContentArticles = ContentArticle::contentArticles()->active()->published()->get();
    **************************************************************************************************/

    public function scopeNewArticleContents($sQuery){
    	return $sQuery->where('created_at', Carbon::now());
    }

    public function scopeOutstandings($sQuery){
        return $sQuery->whereOutstanding(1);
    }

    public function scopeNoOutstandings($sQuery){
        return $sQuery->whereOutstanding(0);
    }

    public function scopeMainHome($sQuery){
        return $sQuery->whereMainHome(1);
    }

    public function scopeNoMainHome($sQuery){
        return $sQuery->whereMainHome(0);
    }

    public function scopeMainCategory($sQuery){
        return $sQuery->whereMainCategory(1);
    }

    public function scopeNoMainCategory($sQuery){
        return $sQuery->whereMainCategory(0);
    }


    /**
    * Metodo que devuelve un modelo ContentArticle encontrado por slug o falso en caso de no encontrarlo
    * @Autor Raúl Chauvin
    * @FechaCreacion  2017/06/09
    *
    * @param string sSlug
    * @return ContentArticle
    */
    public static function bySlug($sSlug = ''){
        return $sSlug ? ContentArticle::whereSlug($sSlug)->first() : FALSE;
    }


    /**
    * Metodo que devuelve un modelo ContentArticle encontrado por title o falso en caso de no encontrarlo
    * @Autor Raúl Chauvin
    * @FechaCreacion  2017/06/09
    *
    * @param string sTitle
    * @return ContentArticle
    */
    public static function byTitle($sTitle = ''){
        return $sTitle ? ContentArticle::whereTitle($sTitle)->first() : FALSE;
    }



    /**
     * Metodo que busca Articulos de Contenido
     * @Autor Raúl Chauvin
     * @FechaCreacion  2017/06/09
     *
     * @param string sStringSearch
     * @param integer[] aContentCategoryId
     * @param integer[] aState
     * @param integer[] aContentType
     * @param integer iPaginate
     *
     * @return ContentArticle[]
     */
    public static function searchContentArticles(
		$sStringSearch = '', 
		$aContentCategoryId = [], 
		$iPaginate = 20
	){
    	if($sStringSearch){
    		$aListContentArticle = ContentArticle::where(function($sQuery) use ($sStringSearch){
            						$sQuery->where('title','like','%'.$sStringSearch.'%')
                                    ->orWhere('summary','like','%'.$sStringSearch.'%')
                                    ->orWhere('content','like','%'.$sStringSearch.'%')
                                    ->orWhere('author','like','%'.$sStringSearch.'%')
                                    ->orWhere('tags','like','%'.$sStringSearch.'%');
            					});

    		if(count($aContentCategoryId)){
            	$aListContentArticle = $aListContentArticle->where(function($sQuery) use($aContentCategoryId){
            		$ban = 0;
            		foreach($aContentCategoryId as $iContentCategoryId){
            			if($ban == 0){
            				$sQuery->where('content_category_id', $iContentCategoryId);
            				$ban = 1;
            			}else{
            				$sQuery = $sQuery->orWhere('content_category_id', $iContentCategoryId);
            			}
            		}
            	});
            }
            
            $aListContentArticle = $aListContentArticle->paginate($iPaginate);
    	}else{
    		$aListContentArticle = null;

    		if($aListContentArticle){
    			if(count($aContentCategoryId)){
	            	$aListContentArticle = $aListContentArticle->where(function($sQuery) use($aContentCategoryId){
	            		$ban = 0;
	            		foreach($aContentCategoryId as $iContentCategoryId){
	            			if($ban == 0){
	            				$sQuery->where('content_category_id', $iContentCategoryId);
	            				$ban = 1;
	            			}else{
	            				$sQuery = $sQuery->orWhere('content_category_id', $iContentCategoryId);
	            			}
	            		}
	            	});
	            }
    		}else{
    			if(count($aContentCategoryId)){
	            	$aListContentArticle = ContentArticle::where(function($sQuery) use($aContentCategoryId){
	            		$ban = 0;
	            		foreach($aContentCategoryId as $iContentCategoryId){
	            			if($ban == 0){
	            				$sQuery->where('content_category_id', $iContentCategoryId);
	            				$ban = 1;
	            			}else{
	            				$sQuery = $sQuery->orWhere('content_category_id', $iContentCategoryId);
	            			}
	            		}
	            	});
	            }
    		}

    		if($aListContentArticle){
    			$aListContentArticle = $aListContentArticle->orderBy('created_at', 'desc')->paginate($iPaginate);
    		}else{
    			$aListContentArticle = ContentArticle::orderBy('created_at', 'desc')->paginate($iPaginate);
    		}
    	}
    	return $aListContentArticle;
    }

}
