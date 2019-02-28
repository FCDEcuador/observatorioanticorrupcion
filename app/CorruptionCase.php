<?php

namespace BlaudCMS;

use Illuminate\Database\Eloquent\Model;
use Alsofronie\Uuid\UuidModelTrait;

/**
* Clase para administración de Casos de corrupcion
* @Autor Raúl Chauvin
* @FechaCreacion  2019/02/18
* @Content
*/

class CorruptionCase extends Model
{
    use UuidModelTrait;


    /**
     * Tabla de la Base de Datos usada por el modelo.
     *
     * @var string
     */
    protected $table = 'corruption_cases';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'case_stage',
        'case_stage_detail',
        'province',
        'state_function',
        'tags',
        'involved_number',
        'linked_institutions',
        'public_officials_involved',
        'main_multimedia',
        'home_image',
        'title',
        'slug',
        'summary',
        'history',
        'history_image',
        'legal_causes',
        'political_causes',
        'consequences_introduction',
        'consequences_title',
        'consequences_description',
        'economic_consequences',
        'social_consequences',
        'sources',
        'consequences_image',
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
     * Método que guarda en la base de datos las instituciones vinculadas del caso de corrupcion en formato JSON
     * @Autor Raúl Chauvin
     * @FechaCreacion  2017/06/08
     *
     * @param string linkedInstitutions
     *
     */
    public function setLinkedInstitutionsAttribute($linkedInstitutions){
        $this->attributes['linked_institutions'] = json_encode($linkedInstitutions);
    }

    /**
     * Método que devuelve las instituciones vinculadas del caso de corrupcion en formato array luego de convertir el JSON
     * @Autor Raúl Chauvin
     * @FechaCreacion  2017/06/08
     *
     * @param string linkedInstitutions
     *
     */
    public function getLinkedInstitutionsAttribute($linkedInstitutions){
    	return json_decode($linkedInstitutions);
    }

    /**
     * Método que guarda en la base de datos los funcionarios publicos involucrados del caso de corrupcion en formato JSON
     * @Autor Raúl Chauvin
     * @FechaCreacion  2017/06/08
     *
     * @param string publicOfficialsInvolved
     *
     */
    public function setPublicOfficialsInvolvedAttribute($publicOfficialsInvolved){
        $this->attributes['public_officials_involved'] = json_encode($publicOfficialsInvolved);
    }

    /**
     * Método que devuelve los funcionarios publicos involucrados del caso de corrupcion en formato array luego de convertir el JSON
     * @Autor Raúl Chauvin
     * @FechaCreacion  2017/06/08
     *
     * @param string publicOfficialsInvolved
     *
     */
    public function getPublicOfficialsInvolvedAttribute($publicOfficialsInvolved){
    	return json_decode($publicOfficialsInvolved);
    }

    /*****************************************************************
    	Autor Raúl Chauvin
    	FechaCreacion  2017/06/07
    	Metodos para construir relaciones en ORM
    ******************************************************************/

    // CorruptionCase __has_many__ WhatHappened
    public function whatsHappeneds() {
        return $this->hasMany('BlaudCMS\WhatHappened','corruption_case_id', 'id');
    }


    /*************************************************************************************************
        Metodos scope para utilizar en el controlador
        Autor Raúl Chauvin
        FechaCreacion  2017/06/09
        EJ:
        $aPublishedContentArticles = ContentArticle::contentArticles()->active()->published()->get();
    **************************************************************************************************/

    public function scopeNewCorruptionCases($sQuery){
    	return $sQuery->where('created_at', Carbon::now());
    }
    
    public function scopeByCaseStage($sQuery, $sCaseStage){
    	return $sQuery->where('case_stage', $sCaseStage);
    }

    public function scopeByCaseStageDetail($sQuery, $sCaseStageDetail){
    	return $sQuery->where('case_stage_detail', $sCaseStageDetail);
    }

    public function scopeByProvince($sQuery, $sProvince){
    	return $sQuery->where('province', $sProvince);
    }

    public function scopeByStateFunction($sQuery, $sStateFunction){
    	return $sQuery->where('state_function', $sStateFunction);
    }


    /**
    * Metodo que devuelve un modelo CorruptionCase encontrado por slug o falso en caso de no encontrarlo
    * @Autor Raúl Chauvin
    * @FechaCreacion  2017/06/09
    *
    * @param string sSlug
    * @return CorruptionCase
    */
    public static function bySlug($sSlug = ''){
        return $sSlug ? CorruptionCase::whereSlug($sSlug)->first() : FALSE;
    }


    /**
    * Metodo que devuelve un modelo CorruptionCase encontrado por title o falso en caso de no encontrarlo
    * @Autor Raúl Chauvin
    * @FechaCreacion  2017/06/09
    *
    * @param string sTitle
    * @return CorruptionCase
    */
    public static function byTitle($sTitle = ''){
        return $sTitle ? CorruptionCase::whereTitle($sTitle)->first() : FALSE;
    }


    /**
     * Metodo que busca Casos de Corrupcion
     * @Autor Raúl Chauvin
     * @FechaCreacion  2017/06/09
     *
     * @param string sStringSearch
     * @param string sCaseStage
     * @param string sCaseStageDetail
     * @param string sProvince
     * @param string sStateFunction
     * @param integer iPaginate
     *
     * @return CorruptionCases[]
     */
    public static function searchCorruptionCasess(
		$sStringSearch = null, 
		$sCaseStage = null, 
		$sCaseStageDetail = null, 
		$sProvince = null, 
		$sStateFunction = null, 
		$iPaginate = 20
	){
    	
	    $aListCorruptionCases = null;

    	if($sStringSearch){
    		$aListCorruptionCases = CorruptionCase::where(function($sQuery) use ($sStringSearch){
            						$sQuery->where('title','like','%'.$sStringSearch.'%')
                                    ->orWhere('summary','like','%'.$sStringSearch.'%')
                                    ->orWhere('linked_institutions','like','%'.$sStringSearch.'%')
                                    ->orWhere('public_officials_involved','like','%'.$sStringSearch.'%')
                                    ->orWhere('history','like','%'.$sStringSearch.'%')
                                    ->orWhere('legal_causes','like','%'.$sStringSearch.'%')
                                    ->orWhere('political_causes','like','%'.$sStringSearch.'%')
                                    ->orWhere('consequences_introduction','like','%'.$sStringSearch.'%')
                                    ->orWhere('consequences_title','like','%'.$sStringSearch.'%')
                                    ->orWhere('consequences_description','like','%'.$sStringSearch.'%')
                                    ->orWhere('economic_consequences','like','%'.$sStringSearch.'%')
                                    ->orWhere('social_consequences','like','%'.$sStringSearch.'%')
                                    ->orWhere('tags','like','%'.$sStringSearch.'%');
            					});

    		
    	}

    	if($sCaseStage){
    		if($aListCorruptionCases){
	    		$aListCorruptionCases = $aListCorruptionCases->where('case_stage', $sCaseStage);
	    	}else{
	    		$aListCorruptionCases = CorruptionCase::where('case_stage', $sCaseStage);
	    	}
    	}

    	if($sCaseStageDetail){
    		if($aListCorruptionCases){
	    		$aListCorruptionCases = $aListCorruptionCases->where('case_stage_detail', $sCaseStageDetail);
	    	}else{
	    		$aListCorruptionCases = CorruptionCase::where('case_stage_detail', $sCaseStageDetail);
	    	}
    	}

    	if($sProvince){
    		if($aListCorruptionCases){
	    		$aListCorruptionCases = $aListCorruptionCases->where('province', $sProvince);
	    	}else{
	    		$aListCorruptionCases = CorruptionCase::where('province', $sProvince);
	    	}
    	}

    	if($sStateFunction){
    		if($aListCorruptionCases){
	    		$aListCorruptionCases = $aListCorruptionCases->where('state_function', $sStateFunction);
	    	}else{
	    		$aListCorruptionCases = CorruptionCase::where('state_function', $sStateFunction);
	    	}
    	}

    	if($aListCorruptionCases){
			$aListCorruptionCases = $aListCorruptionCases->orderBy('created_at', 'desc')->paginate($iPaginate);
		}else{
			$aListCorruptionCases = CorruptionCase::orderBy('created_at', 'desc')->paginate($iPaginate);
		}
    	
    	return $aListCorruptionCases;
    }
}
