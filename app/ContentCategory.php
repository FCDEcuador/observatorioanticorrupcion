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

    // ContentCategory __has_many__ ContentArticle
    public function contentArticles() {
        return $this->hasMany('BlaudCMS\ContentArticle','content_category_id', 'id');
    }

    /*************************************************************************************************
        Metodos scope para utilizar en el controlador
        Autor Raúl Chauvin
        FechaCreacion  2018/01/03
    **************************************************************************************************/

    public function scopeBySuperContentCategory($sQuery, $sIdSuperContentCategory){
        return $sQuery->where('content_category_id', $sIdSuperContentCategory);
    }

    public function scopeSuperCategories($query){
        return $query->whereNull('content_category_id');
    }

    public function scopeSubCategories($query, $sId){
        return $query->where('content_category_id', $sId);
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
    * @param integer iPaginate
    * @return ContentCategory[] 
    */
    public static function searchContentCategory($sStringSearch = '', $iPaginate = 20){
        if($sStringSearch){
            $aListCategories = ContentCategory::where(function($sQuery) use ($sStringSearch){
            						$sQuery->where('id','like','%'.$sStringSearch.'%')
                                    ->orWhere('name','like','%'.$sStringSearch.'%')
                                    ->orWhere('title','like','%'.$sStringSearch.'%')
                                    ->orWhere('subtitle','like','%'.$sStringSearch.'%')
                                    ->orWhere('tags','like','%'.$sStringSearch.'%');
            					});
            
            $aListCategories = $aListCategories->paginate($iPaginate);
        }else{
        	$aListCategories = ContentCategory::paginate($iPaginate);
        }
        return $aListCategories;
    }


    public static function dropDownItems($superContentCategoryId = null, $selectedItemId = null, $sSpacesString = ''){
        $selectItems = '';
        if($superContentCategoryId){
            $sSpacesString .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
            $aContentCategories = ContentCategory::subCategories($superContentCategoryId)->get();
        }else{
            $aContentCategories = ContentCategory::superCategories()->get();
        }
        if($aContentCategories->isNotEmpty()){
            foreach($aContentCategories as $oContentCategory){
                if($selectedItemId == $oContentCategory->id){
                    $selectItems .= '<option selected="selected" value="'.$oContentCategory->id.'">'.$sSpacesString.$oContentCategory->name.'</option>';
                }else{
                    $selectItems .= '<option value="'.$oContentCategory->id.'">'.$sSpacesString.$oContentCategory->name.'</option>';
                }
                $subCategories = ContentCategory::subCategories($oContentCategory->id)->count();
                if($subCategories){
                    $selectItems .= ContentCategory::dropDownItems($oContentCategory->id, $selectedItemId, $sSpacesString);
                }
            }
        }
        return $selectItems;
    }


    public static function dropDownItemsMenu($superContentCategoryId = null, $selectedItemId = null, $sSpacesString = ''){
        $selectItems = '';
        if($superContentCategoryId){
            $sSpacesString .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
            $aContentCategories = ContentCategory::subCategories($superContentCategoryId)->get();
        }else{
            $aContentCategories = ContentCategory::superCategories()->get();
        }
        if($aContentCategories->isNotEmpty()){
            foreach($aContentCategories as $oContentCategory){
                if($selectedItemId == $oContentCategory->id){
                    $selectItems .= '<option selected="selected" value="'.$oContentCategory->slug.'">'.$sSpacesString.$oContentCategory->name.'</option>';
                }else{
                    $selectItems .= '<option value="'.$oContentCategory->slug.'">'.$sSpacesString.$oContentCategory->name.'</option>';
                }
                $subCategories = ContentCategory::subCategories($oContentCategory->id)->count();
                if($subCategories){
                    $selectItems .= ContentCategory::dropDownItems($oContentCategory->id, $selectedItemId, $sSpacesString);
                }
            }
        }
        return $selectItems;
    }
}
