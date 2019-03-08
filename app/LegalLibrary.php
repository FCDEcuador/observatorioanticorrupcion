<?php

namespace BlaudCMS;

use Illuminate\Database\Eloquent\Model;
use Alsofronie\Uuid\UuidModelTrait;

/**
* Clase para administración de bibioteca legal
* @Autor Raúl Chauvin
* @FechaCreacion  2017/07/05
* @Content
*/

class LegalLibrary extends Model
{
    use UuidModelTrait;

    /**
     * Tabla de la Base de Datos usada por el modelo.
     *
     * @var string
     */
    protected $table = 'legal_libraries';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'slug',
        'description',
        'issue_year',
        'pdf_document',
        'tags',
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
     * Método que guarda en la base de datos los tags del caso de corrupcion en formato JSON
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
     * Método que devuelve los tags del caso de corrupcion en formato array luego de convertir el JSON
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
    * Metodo que devuelve un modelo LegalLibrary encontrado por titulo o falso en caso de no encontrarlo
    * @Autor Raúl Chauvin
    * @FechaCreacion  2019/03/02
    *
    * @param string sTitle
    * @return LegalLibrary
    */
    public static function byTitle($sTitle = ''){
        return $sTitle ? LegalLibrary::whereTitle($sTitle)->first() : FALSE;
    }

    /**
    * Metodo que devuelve un modelo LegalLibrary encontrado por slug o falso en caso de no encontrarlo
    * @Autor Raúl Chauvin
    * @FechaCreacion  2019/03/02
    *
    * @param string sSlug
    * @return LegalLibrary
    */
    public static function bySlug($sSlug = ''){
        return $sSlug ? LegalLibrary::whereSlug($sSlug)->first() : FALSE;
    }


    /**
     * Metodo que busca registros en Biblioteca Legal
     * @Autor Raúl Chauvin
     * @FechaCreacion  2019/03/02
     *
     * @param string sTags
     * @param integer iIssueYear
     * @param integer iPaginate
     *
     * @return LegalLibrary[]
     */
    public static function searchLegalLibraries($sTags = null, $iIssueYear = null, $iPaginate = 20){
    	
	    $aLegalLibraryList = null;

    	if($sTags){
    		$aLegalLibraryList = LegalLibrary::where(function($sQuery) use ($sTags){
            						$sQuery->where('title','like','%'.$sTags.'%')
                                    ->orWhere('description','like','%'.$sTags.'%')
                                    ->orWhere('tags','like','%'.$sTags.'%');
            					});
    	}

    	if($iIssueYear){
    		if($aLegalLibraryList){
	    		$aLegalLibraryList = $aLegalLibraryList->where('issue_year', $iIssueYear);
	    	}else{
	    		$aLegalLibraryList = LegalLibrary::where('issue_year', $iIssueYear);
	    	}
    	}

        if($aLegalLibraryList){
            $aLegalLibraryList = $aLegalLibraryList->orderBy('created_at', 'desc')->paginate($iPaginate);
        }else{
            $aLegalLibraryList = LegalLibrary::orderBy('created_at', 'desc')->paginate($iPaginate);
        }
    	
    	return $aLegalLibraryList;
    }
}
