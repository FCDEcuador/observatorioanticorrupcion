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
        'content_type', // A (Articulo), S (Pagina Estatica)
        'title',
        'short_title',
        'slug',
        'summary',
        'content',
        'state',  // 0 (Despublicada), 1 (Borrador), 2 (Publicada)
        'publication_date',
        'release_date',
        'author',
        'author_email',
        'source',
        'sum_votes',
        'total_votes',
        'hits',
        'tags',
        'meta_description',
        'meta_keywords',
        'extra_headers',
        'outstanding',
        'main_category',
        'main_home',
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

    // ContentArticle __has_many__ ArticleMultimedia
    public function articleMultimedias() {
        return $this->hasMany('BlaudCMS\ArticleMultimedia','content_article_id', 'id');
    }


    /*************************************************************************************************
        Metodos scope para utilizar en el controlador
        Autor Raúl Chauvin
        FechaCreacion  2017/06/09
        EJ:
        $aPublishedContentArticles = ContentArticle::contentArticles()->active()->published()->get();
    **************************************************************************************************/

    public function scopeActive($sQuery){
        return $sQuery->whereState(2);
    }

    public function scopeDraft($sQuery){
        return $sQuery->whereState(1);
    }

    public function scopeInactive($sQuery){
        return $sQuery->whereState(0);
    }

    public function scopePublished($sQuery){
    	return $sQuery->where(function($sQuery){
    					$sQuery->where(function($sQuery){
    						 $sQuery->where('publication_date', '<=', Carbon::now())
    			   					->orWhereNull('publication_date')
                                    ->orWhere('publication_date', '0000-00-00 00:00:00');
    					})
    					->where(function($sQuery){
    						 $sQuery->where('release_date', '>', Carbon::now())
    			   					->orWhereNull('release_date')
                                    ->orWhere('release_date', '0000-00-00 00:00:00');
    					});
    	});
    }

    public function scopeNewArticleContents($sQuery){
    	return $sQuery->where('created_at', Carbon::now());
    }

    public function scopeMoreRead($sQuery){
    	return $sQuery->orderBy('hits', 'desc');
    }

    public function scopeMoreVoted($sQuery){
    	return $sQuery->orderBy('sum_votes', 'desc');
    }

    public function scopeByPublishedDate($sQuery){
    	return $sQuery->orderBy('publication_date', 'desc');
    }

    public function scopeContentArticles($sQuery){
        return $sQuery->whereContentType('A');
    }

    public function scopeStaticPages($sQuery){
        return $sQuery->whereContentType('S');
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
    * Metodo que devuelve un modelo ContentArticle encontrado por short title o falso en caso de no encontrarlo
    * @Autor Raúl Chauvin
    * @FechaCreacion  2017/06/09
    *
    * @param string sShortTitle
    * @return ContentArticle
    */
    public static function byShortTitle($sShortTitle = ''){
        return $sShortTitle ? ContentArticle::whereShortTitle($sShortTitle)->first() : FALSE;
    }


    /**
     * Metodo que verifica si un articulo de contenido esta activo o no.
     * @Autor Raúl Chauvin
     * @FechaCreacion  2017/06/09
     *
     * @param int iId?
     * @return bool
     */
    public static function isActive($iId = ''){
        if($iId){
        	$oContentArticle = ContentArticle::find($iId);
            if($oContentArticle){
                return $oContentArticle->state == 2 ? TRUE : FALSE;
            }
        }
        return FALSE;
    }

    /**
     * Metodo que verifica si un ContentArticle es articulo de contenido o pagina estatica
     * @Autor Raúl Chauvin
     * @FechaCreacion  2017/06/09
     *
     * @param int iId?
     * @return bool
     */
    public static function isContentArticle($iId = ''){
        if($iId){
        	return ContentArticle::find($iId)->content_type == 'A' ? TRUE : FALSE;
        }
        return FALSE;
    }

    /**
     * Metodo que verifica si un articulo de contenido esta publicado o no.
     * @Autor Raúl Chauvin
     * @FechaCreacion  2017/06/09
     *
     * @param int iId?
     * @return bool
     */
    public static function isPublished($iId = ''){
        if($iId){
        	$oContentArticle = ContentArticle::find($iId);
        	if($oContentArticle && ContentArticle::isActive($iId)){
        		if(
        				(
        					$oContentArticle->publication_date <= Carbon::now() || 
        					$oContentArticle->publication_date == null || 
        					$oContentArticle->publication_date == '0000-00-00 00:00:00'
        				) &&
        				(
        					$oContentArticle->release_date > Carbon::now() || 
        					$oContentArticle->release_date == null || 
        					$oContentArticle->release_date == '0000-00-00 00:00:00'
        				)
        			){
        			return TRUE;
        		}
        	}
        }
        return FALSE;
    }

    /**
     * Metodo que devuelve el nombre del tipo de contenido que es el ContentArticle seleccionado
     * @Autor Raúl Chauvin
     * @FechaCreacion  2017/06/09
     *
     * @param int iId?
     * @return bool
     */
    public static function contentTypeName($iId = ''){
        $contentTypeName = '';
        if($iId){
        	$oContentArticle = ContentArticle::find($iId);
        	if($oContentArticle){
        		switch ($oContentArticle->content_type) {
        			case 'A':
        				$contentTypeName = 'Articulo de Contenido';
        				break;
        			case 'S':
        				$contentTypeName = 'Página Estática';
        				break;
        			default:
        				$contentTypeName = '';
        				break;
        		}
        	}
        }
        return $contentTypeName;
    }


    /**
     * Metodo que toma el contenido del articulo y reemplaza los BlaudObjects por los elementos multimedia del ContentArticle
     * @Autor Raúl Chauvin
     * @FechaCreacion  2017/06/09
     *
     * @return string
     */
    public function replaceBlaudObjects(){
        $finalContent = ""; // Iniciamos la variable que devolvera el contenido con los elementos multimedia
        // Obtenemos los elementos multimedia secundarios, o que no son de apertura, para el ContentArticle instanciado
		$multimediaItems = $this->articleMultimedias()->where('main_content', 0);
		// Separamos en parrafos el contenido, tomando como base el BlaudObject
		$aParagraphs = explode("{{blaudobject}}", $this->content);
		// Contamos el numero de parrafos con los que vamos a contar.
		$numParagraphs = count($aParagraphs);
		// Iniciamos la iteraccion para poder ir colocando los elementos multimedia luego de cada parrafo
		for($i=0; $i < $numParagraphs; $i++){
			// Verificamos si existe la correspondencia de BlaudObject con un elemento multimedia 
			// (Hacemos esto debido a que puede haberse incluido un numero diferente de BlaudObjects en el
			//   contenido al numero de elementos multimedia secundarios asignados.)
			if(isset($multimediaItems[$i])){
				// Instanciamos el contenido multimedia y verificamos que exista y que este activo
				$oMultimediaContent = BlaudCMS\MultimediaContent::find($multimediaItems[$i]->multimedia_content_id);
				if($oMultimediaContent){
					if(BlaudCMS\MultimediaContent::isPublished($oMultimediaContent->id)){
						// En el caso de que sea un video, colocamos la imagen de preview, y cargamos en video onDemand cuando el 
						// usuario de un click sobre la imagen.
						// Caso contrario simplemente colocamos el elemento multimedia.
						if(BlaudCMS\MultimediaContent::isVideo($oMultimediaContent->id)){
							$finalContent .= $aParagraphs[$i].'<div style="width:100%; margin:0 auto; position:relative;" id="multimediaItem'.$oMultimediaContent->id.'"><img src="'.asset('public'.Storage::url($oMultimediaContent->image)).'" border="0" width="100%" style="cursor:pointer;" title="Click sobre la imagen para ver el video" onclick="javascript: $(\'multimediaItem'.$oMultimediaContent->id.'\').html(\''.BlaudCMS\MultimediaContent::getMultimediaContent($oMultimediaContent->id, BlaudCMS\Cut::find($multimediaItems[$i]->cut_id)->width, BlaudCMS\Cut::find($multimediaItems[$i]->cut_id)->height).'\')" /><img src="'.asset('public/blaud-resources/images/btnPlayVideo.png').'" style="border:0; position: absolute; left: 50%; top: 50%; margin: -32px 0 0 -45px; cursor: pointer;" onclick="javascript: $(\'multimediaItem'.$oMultimediaContent->id.'\').html(\''.BlaudCMS\MultimediaContent::getMultimediaContent($oMultimediaContent->id, BlaudCMS\Cut::find($multimediaItems[$i]->cut_id)->width, BlaudCMS\Cut::find($multimediaItems[$i]->cut_id)->width).'\')" /><div class="pie-foto"><p><strong>'.$oMultimediaContent->title.'</strong></p><p>'.$oMultimediaContent->description.'</p></div></div><br />';
						}else{
								$finalContent .= $aParagraphs[$i].'<div style="width:100%; margin:0 auto; display:block; cursor: default; relative;">'.BlaudCMS\MultimediaContent::getMultimediaContent($oMultimediaContent->id, BlaudCMS\Cut::find($multimediaItems[$i]->cut_id)->width, BlaudCMS\Cut::find($multimediaItems[$i]->cut_id)->height).'</div><br />';
						}
					}else{
						// Si el elemento multimedia no esta activo, lo descartamos y colocamos el siguiente parrafo.
						$finalContent .= $aParagraphs[$i];
					}
				}else{
					// Si el elemento multimedia no existe, lo descartamos y colocamos el siguiente parrafo.
					$finalContent .= $aParagraphs[$i];
				}
			}else{
				// Si no existe este numero de elemento multimedia, lo descartamos y colocamos el siguiente parrafo.
				$finalContent .= $aParagraphs[$i];
			}
		}
        return $finalContent;
    }



    /**
     * Metodo que quita los BlaudObjects del contenido
     * @Autor Raúl Chauvin
     * @FechaCreacion  2017/06/09
     *
     * @return string
     */
    public function removeBlaudObjects($iId = ''){
        $finalContent = ""; // Iniciamos la variable que devolvera el contenido con los elementos multimedia
        // Obtenemos los elementos multimedia secundarios, o que no son de apertura, para el ContentArticle instanciado
		$multimediaItems = $this->articleMultimedias()->where('main_content', 0);
		// Separamos en parrafos el contenido, tomando como base el BlaudObject
		$aParagraphs = explode("{{blaudobject}}", $this->content);
		// Contamos el numero de parrafos con los que vamos a contar.
		$numParagraphs = count($aParagraphs);
        $finalContent = "";
        for($i=0;$i<$numElem;$i++){
            $finalContent .= isset($secundarios[$i]) ? $aParrafos[$i]."<br />" : $aParrafos[$i];
        }
        return $finalContent;
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
		$aState = [], 
		$aContentType = [], 
		$iPaginate = 20
	){
    	if($sStringSearch){
    		$aListContentArticle = ContentArticle:::where(function($sQuery) use ($sStringSearch){
            						$sQuery->where('title','like','%'.$sStringSearch.'%')
                                    ->orWhere('short_title','like','%'.$sStringSearch.'%')
                                    ->orWhere('subtitle','like','%'.$sStringSearch.'%')
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

            if(count($aState)){
            	$aListContentArticle = $aListContentArticle->where(function($sQuery) use($aState){
            		$ban = 0;
            		foreach($aState as $iState){
            			if($ban == 0){
            				$sQuery->where('state', $iState);
            				$ban = 1;
            			}else{
            				$sQuery = $sQuery->orWhere('state', $iState);
            			}
            		}
            	});	
            }

    		if(count($aContentType)){
            	$aListContentArticle = $aListContentArticle->where(function($sQuery) use($aContentType){
            		$ban = 0;
            		foreach($aContentType as $iContentType){
            			if($ban == 0){
            				$sQuery->where('content_type', $iContentType);
            				$ban = 1;
            			}else{
            				$sQuery = $sQuery->orWhere('content_type', $iContentType);
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
    			if(count($aState)){
	            	$aListContentArticle = $aListContentArticle->where(function($sQuery) use($aLanguageId){
	            		$ban = 0;
	            		foreach($aState as $iState){
	            			if($ban == 0){
	            				$sQuery->where('state', $iState);
	            				$ban = 1;
	            			}else{
	            				$sQuery = $sQuery->orWhere('state', $iState);
	            			}
	            		}
	            	});	
	            }
    		}else{
    			if(count($aState)){
	            	$aListContentArticle = ContentArticle::where(function($sQuery) use($aLanguageId){
	            		$ban = 0;
	            		foreach($aState as $iState){
	            			if($ban == 0){
	            				$sQuery->where('state', $iState);
	            				$ban = 1;
	            			}else{
	            				$sQuery = $sQuery->orWhere('state', $iState);
	            			}
	            		}
	            	});	
	            }
    		}

    		if($aListContentArticle){
    			if(count($aContentType)){
	            	$aListContentArticle = $aListContentArticle->where(function($sQuery) use($aContentType){
	            		$ban = 0;
	            		foreach($aContentType as $iContentType){
	            			if($ban == 0){
	            				$sQuery->where('content_type', $iContentType);
	            				$ban = 1;
	            			}else{
	            				$sQuery = $sQuery->orWhere('content_type', $iContentType);
	            			}
	            		}
	            	});
	            }
    		}else{
    			if(count($aContentType)){
	            	$aListContentArticle = ContentArticle::where(function($sQuery) use($aContentType){
	            		$ban = 0;
	            		foreach($aContentType as $iContentType){
	            			if($ban == 0){
	            				$sQuery->where('content_type', $iContentType);
	            				$ban = 1;
	            			}else{
	            				$sQuery = $sQuery->orWhere('content_type', $iContentType);
	            			}
	            		}
	            	});
	            }
    		}

    		if($aListContentArticle){
    			$aListContentArticle = $aListContentArticle->orderBy('publication_date', 'desc')->paginate($iPaginate);
    		}else{
    			$aListContentArticle = ContentArticle::orderBy('publication_date', 'desc')->paginate($iPaginate);
    		}
    	}
    	return $aListContentArticle
    }


    /**
     * Metodo que busca Articulos de Contenido Publicados y Activos (Busquedas para frontend)
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
    public static function searchPublishedContentArticles(
		$sStringSearch = '', 
		$aContentCategoryId = [], 
		$aContentType = [], 
		$iPaginate = 20
	){
    	$aListContentArticle = ContentArticle::where(function($sQuery){
						    					$sQuery->where(function($sQuery){
						    						 $sQuery->where('publication_date', '<=', Carbon::now())
						    			   					->orWhereNull('publication_date')
                                                            ->orWhere('publication_date', '0000-00-00 00:00:00');
						    					})
						    					->where(function($sQuery){
						    						 $sQuery->where('release_date', '>', Carbon::now())
						    			   					->orWhereNull('release_date')
                                                            ->orWhere('release_date', '0000-00-00 00:00:00');
						    					});
						    	});
    	$aListContentArticle = $aListContentArticle->where('state', 2);

    	if($sStringSearch){
    		$aListContentArticle = ContentArticle:::where(function($sQuery) use ($sStringSearch){
            						$sQuery->where('title','like','%'.$sStringSearch.'%')
                                    ->orWhere('short_title','like','%'.$sStringSearch.'%')
                                    ->orWhere('subtitle','like','%'.$sStringSearch.'%')
                                    ->orWhere('summary','like','%'.$sStringSearch.'%')
                                    ->orWhere('content','like','%'.$sStringSearch.'%')
                                    ->orWhere('author','like','%'.$sStringSearch.'%')
                                    ->orWhere('tags','like','%'.$sStringSearch.'%');
            					});
    	}

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

		if(count($aContentType)){
        	$aListContentArticle = $aListContentArticle->where(function($sQuery) use($aContentType){
        		$ban = 0;
        		foreach($aContentType as $iContentType){
        			if($ban == 0){
        				$sQuery->where('content_type', $iContentType);
        				$ban = 1;
        			}else{
        				$sQuery = $sQuery->orWhere('content_type', $iContentType);
        			}
        		}
        	});
        }
        $aListContentArticle = $aListContentArticle->orderBy('publication_date', 'desc');
        $aListContentArticle = $aListContentArticle->paginate($iPaginate);
    }
}
