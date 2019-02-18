<?php

namespace BlaudCMS;

use Illuminate\Database\Eloquent\Model;
use Alsofronie\Uuid\UuidModelTrait;

/**
* Clase para administración de Elementos multimedia de Articulos de Contenido del Sitio
* @Autor Raúl Chauvin
* @FechaCreacion  2017/07/01
* @Content
*/

class ArticleMultimedia extends Model
{
    use UuidModelTrait;

    /**
     * Tabla de la Base de Datos usada por el modelo.
     *
     * @var string
     */
    protected $table = 'article_multimedias';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'path', 
        'main_content', // 1 (SI), 0 (NO)
        'list_image', // 1 (SI), 0 (NO)
        'multimedia_content_id',
        'content_article_id',
        'cut_id',
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


    /*****************************************************************
    	Autor Raúl Chauvin
    	FechaCreacion  2017/07/01
    	Metodos para construir relaciones en ORM
    ******************************************************************/

    // ArticleMultimedia __belongs_to__ MultimediaContent
    public function multimediaContent() {
        return $this->belongsTo('BlaudCMS\MultimediaContent','multimedia_content_id', 'id');
    }

    // ArticleMultimedia __belongs_to__ ContentArticle
    public function contentArticle() {
        return $this->belongsTo('BlaudCMS\ContentArticle','content_article_id', 'id');
    }

	// ArticleMultimedia __belongs_to__ Cut
    public function cut() {
        return $this->belongsTo('BlaudCMS\Cut','cut_id', 'id');
    }

    /*************************************************************************************************
        Metodos scope para utilizar en el controlador
        Autor Raúl Chauvin
        FechaCreacion  2017/07/01
        EJ:
        $aMainArticleMultimedia = ArticleMultimedia::mainContent()->get();
    **************************************************************************************************/

    public function scopeMainContent($sQuery){
        return $sQuery->whereMainContent(1);
    }

    public function scopeListImage($sQuery){
        return $sQuery->whereListImage(1);
    }

    /**
    * Metodo que devuelve el ArticleMultimedia principal de un ContentArticle seleccionado
    * @Autor Raúl Chauvin
    * @FechaCreacion  2017/07/01
    *
    * @param string iIdContentArticle
    * @return ArticleMultimedia
    */
    public static function mainContent($iIdContentArticle = ''){
        return $iIdContentArticle ? ArticleMultimedia::where('content_article_id', $iIdContentArticle)->where('main_content', 1)->first() : FALSE;
    }

    /**
    * Metodo que devuelve el ArticleMultimedia para listados de un ContentArticle seleccionado
    * @Autor Raúl Chauvin
    * @FechaCreacion  2017/07/01
    *
    * @param string iIdContentArticle
    * @return ArticleMultimedia
    */
    public static function listImage($iIdContentArticle = ''){
        return $iIdContentArticle ? ArticleMultimedia::where('content_article_id', $iIdContentArticle)->where('list_image', 1)->first() : FALSE;
    }
}
