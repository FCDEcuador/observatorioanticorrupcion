<?php

namespace BlaudCMS;

use Illuminate\Database\Eloquent\Model;
use Alsofronie\Uuid\UuidModelTrait;

/**
* Clase para administración de Contenido Multimedia del Sitio (archivos, imagenes, videos, HTML libre, Galerias, audios)
* @Autor Raúl Chauvin
* @FechaCreacion  2017/06/08
* @Content
*/

class MultimediaContent extends Model
{
    use UuidModelTrait;


    /**
     * Tabla de la Base de Datos usada por el modelo.
     *
     * @var string
     */
    protected $table = 'multimedia_contents';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'author',
        'author_email',
        'content_type', // 1 (File), 2 (Audio), 3 (Gallery), 4 (Free HTML), 5 (Image), 6 (Video)
        'name',
        'slug',
        'title',
        'subtitle',
        'description',
        'geolocation',
        'file',
        'audio',
        'gallery_items',
        'free_html',
        'image',
        'video',
        'active', // 1 (Active), 0 (Inactive)
        'sum_votes',
        'total_votes',
        'hits',
        'tags',
        'meta_description',
        'meta_keywords',
        'extra_headers',
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
     * Método que guarda en la base de datos los tags del contenido multimedia en formato JSON
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
     * Método que devuelve los tags del contenido multimedia en formato array luego de convertir el JSON
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
     * Método que guarda en la base de datos los items de la galeria del contenido multimedia en formato JSON
     * @Autor Raúl Chauvin
     * @FechaCreacion  2017/06/08
     *
     * @param string galleryItems
     *
     */
    public function setGalleryItemsAttribute($galleryItems){
        $this->attributes['gallery_items'] = json_encode($galleryItems);
    }

    /**
     * Método que devuelve los items de la galeria del contenido multimedia en formato array luego de convertir el JSON
     * @Autor Raúl Chauvin
     * @FechaCreacion  2017/06/08
     *
     * @param string galleryItems
     *
     */
    public function getGalleryItemsAttribute($galleryItems){
    	return json_decode($galleryItems);
    }

    /*****************************************************************
    	Autor Raúl Chauvin
    	FechaCreacion  2017/06/07
    	Metodos para construir relaciones en ORM
    ******************************************************************/

    // MultimediaContent __belongs_to__ ContentCategory
    public function contentCategory() {
        return $this->belongsTo('BlaudCMS\ContentCategory','content_category_id', 'id');
    }

    // MultimediaContent __has_many__ ArticleMultimedia
    public function articleMultimedias() {
        return $this->hasMany('BlaudCMS\ArticleMultimedia','multimedia_content_id', 'id');
    }

    /*************************************************************************************************
        Metodos scope para utilizar en el controlador
        Autor Raúl Chauvin
        FechaCreacion  2017/06/08
        EJ:
        $aPublishedMultimediaContents = MultimediaContent::published()->get();
        $aPublishedImages = ContentCategory::published()->images()->get();
    **************************************************************************************************/

    public function scopePublished($sQuery){
        return $sQuery->whereActive(1);
    }

    public function scopeUnpublished($sQuery){
        return $sQuery->whereActive(0);
    }

    public function scopeFiles($sQuery){
    	return $sQuery->whereContentType(1);
    }

    public function scopeAudios($sQuery){
    	return $sQuery->whereContentType(2);
    }

    public function scopeGalleries($sQuery){
    	return $sQuery->whereContentType(3);
    }

    public function scopeFreeHTMLs($sQuery){
    	return $sQuery->whereContentType(4);
    }

    public function scopeImages($sQuery){
    	return $sQuery->whereContentType(5);
    }

    public function scopeVideos($sQuery){
    	return $sQuery->whereContentType(6);
    }



    /**
    * Metodo que devuelve un modelo MultimediaContent encontrado por slug o falso en caso de no encontrarlo
    * @Autor Raúl Chauvin
    * @FechaCreacion  2017/06/08
    *
    * @param string sSlug
    * @return MultimediaContent
    */
    public static function bySlug($sSlug = ''){
        return $sSlug ? MultimediaContent::whereSlug($sSlug)->first() : FALSE;
    }

    /**
    * Metodo que devuelve un modelo MultimediaContent encontrado por name o falso en caso de no encontrarlo
    * @Autor Raúl Chauvin
    * @FechaCreacion  2017/06/08
    *
    * @param string sName
    * @return MultimediaContent
    */
    public static function byName($sName = ''){
        return $sSlug ? MultimediaContent::whereName($sName)->first() : FALSE;
    }


    /**
     * Metodo que verifica si un contenido multimedia esta activo o no.
     * @Autor Raúl Chauvin
     * @FechaCreacion  2017/06/08
     *
     * @param int iId?
     * @return bool
     */
    public static function isPublished($iId = ''){
        if($iId){
        	return MultimediaContent::find($iId)->active == 1 ? TRUE : FALSE;
        }
        return FALSE;
    }

    /**
     * Metodo que verifica si un contenido multimedia es de tipo File.
     * @Autor Raúl Chauvin
     * @FechaCreacion  2017/06/08
     *
     * @param int iId?
     * @return bool
     */
    public static function isFile($iId = ''){
        if($iId){
        	return MultimediaContent::find($iId)->content_type == 1 ? TRUE : FALSE;
        }
        return FALSE;
    }

    /**
     * Metodo que verifica si un contenido multimedia es de tipo Audio.
     * @Autor Raúl Chauvin
     * @FechaCreacion  2017/06/08
     *
     * @param int iId?
     * @return bool
     */
    public static function isAudio($iId = ''){
        if($iId){
        	return MultimediaContent::find($iId)->content_type == 2 ? TRUE : FALSE;
        }
        return FALSE;
    }

    /**
     * Metodo que verifica si un contenido multimedia es de tipo Gallery.
     * @Autor Raúl Chauvin
     * @FechaCreacion  2017/06/08
     *
     * @param int iId?
     * @return bool
     */
    public static function isGallery($iId = ''){
        if($iId){
        	return MultimediaContent::find($iId)->content_type == 3 ? TRUE : FALSE;
        }
        return FALSE;
    }

    /**
     * Metodo que verifica si un contenido multimedia es de tipo Free HTML.
     * @Autor Raúl Chauvin
     * @FechaCreacion  2017/06/08
     *
     * @param int iId?
     * @return bool
     */
    public static function isFreeHTML($iId = ''){
        if($iId){
        	return MultimediaContent::find($iId)->content_type == 4 ? TRUE : FALSE;
        }
        return FALSE;
    }

    /**
     * Metodo que verifica si un contenido multimedia es de tipo Image.
     * @Autor Raúl Chauvin
     * @FechaCreacion  2017/06/08
     *
     * @param int iId?
     * @return bool
     */
    public static function isImage($iId = ''){
        if($iId){
        	return MultimediaContent::find($iId)->content_type == 5 ? TRUE : FALSE;
        }
        return FALSE;
    }

    /**
     * Metodo que verifica si un contenido multimedia es de tipo Video.
     * @Autor Raúl Chauvin
     * @FechaCreacion  2017/06/08
     *
     * @param int iId?
     * @return bool
     */
    public static function isVideo($iId = ''){
        if($iId){
        	return MultimediaContent::find($iId)->content_type == 6 ? TRUE : FALSE;
        }
        return FALSE;
    }


    /**
     * Metodo que devuelve el nombre del tipo de contenido multimedia (Imagen, Video, Galeria, etc.).
     * @Autor Raúl Chauvin
     * @FechaCreacion  2017/06/08
     *
     * @param int iId?
     * @return string
     */
    public static function contentTypeName($iId = ''){
        $contentTypeName = '';
        if($iId){
        	$oMultimediaContent = MultimediaContent::find($iId);
        	if($oMultimediaContent){
        		switch ($oMultimediaContent->content_type) {
        			case 1:
        				$contentTypeName = 'Archivo';
        				break;
        			case 2:
        				$contentTypeName = 'Audio';
        				break;
        			case 3:
        				$contentTypeName = 'Galer&iacute;a';
        				break;
        			case 4:
        				$contentTypeName = 'HTML Libre';
        				break;
        			case 5:
        				$contentTypeName = 'Imagen';
        				break;
        			case 6:
        				$contentTypeName = 'Video';
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
     * Metodo que prepara el codigo del video para adaptarlo a la seccion del sitio web en que se desea colocar.
     * @Autor Raúl Chauvin
     * @FechaCreacion  2017/06/08
     *
     * @param int iId?
     * @param int iWidth
     * @param int iHeight
     * @return string
     */
    public static function prepareVideo($iId = '', $iWidth = 100, $iHeight = 100){
    	$video = '';
    	if($iId){
    		$oMultimediaContent = MultimediaContent::find($iId);
    		if($oMultimediaContent){
    			if(MultimediaContent::isVideo($oMultimediaContent->id)){
    				$video = $oMultimediaContent->video;
    			}
    		}
    	}
    	if($video){
    		$video = preg_replace("#width=('|\")(\d+)('|\")#i", "width=\"$iWidth\"", $video);
	        $video = preg_replace("#height=('|\")(\d+)('|\")#i", "height=\"$iHeight\"", $video);

	        $wmode = "transparent";
	        //Se añade el wmode si es un iframe
	        if (preg_match("#<iframe#i", $video)) {
	            if (preg_match("#wmode=(\w+)#i", $video)) {
	                $video = preg_replace("#wmode=(\w+)#i", "wmode=$wmode", $video);
	            } else {
	                $embedParts =explode(" ", $video);
	                foreach ($embedParts as $i => $part) {
	                    if (preg_match("#src=#i", $part)) {
	                        if (preg_match("#\?#i", $part)) {
	                            $embedParts[$i] = preg_replace("#\?#i", "?wmode=$wmode&", $part);
	                        } else {
	                            $embedParts[$i] = substr($part,0,strlen($part)-1) . "?wmode=$wmode\"";
	                        }
	                    }
	                }
	                $video =implode(" ", $embedParts);
	            }
	        }
    	}
        return $video;
    }


    /**
     * Metodo que prepara el codigo del contenido pasado por parametro para adaptarlo a la seccion del sitio web en que se desea colocar.
     * @Autor Raúl Chauvin
     * @FechaCreacion  2017/06/08
     *
     * @param string sContent?
     * @param int iWidth
     * @param int iHeight
     * @return string
     */
    public static function prepareContent($sContent = '', $iWidth = 100, $iHeight = 100){
    	$video = $sContent;
    	if($video){
    		$video = preg_replace("#width=('|\")(\d+)('|\")#i", "width=\"$iWidth\"", $video);
	        $video = preg_replace("#height=('|\")(\d+)('|\")#i", "height=\"$iHeight\"", $video);

	        $wmode = "transparent";
	        //Se añade el wmode si es un iframe
	        if (preg_match("#<iframe#i", $video)) {
	            if (preg_match("#wmode=(\w+)#i", $video)) {
	                $video = preg_replace("#wmode=(\w+)#i", "wmode=$wmode", $video);
	            } else {
	                $embedParts =explode(" ", $video);
	                foreach ($embedParts as $i => $part) {
	                    if (preg_match("#src=#i", $part)) {
	                        if (preg_match("#\?#i", $part)) {
	                            $embedParts[$i] = preg_replace("#\?#i", "?wmode=$wmode&", $part);
	                        } else {
	                            $embedParts[$i] = substr($part,0,strlen($part)-1) . "?wmode=$wmode\"";
	                        }
	                    }
	                }
	                $video =implode(" ", $embedParts);
	            }
	        }
    	}
        return $video;
    }


    /**
     * Metodo que prepara el codigo de un video de youtube para luego anclarlo a una URL.
     * @Autor Raúl Chauvin
     * @FechaCreacion  2017/06/08
     *
     * @param int iId?
     * @return string
     */
    public static function codeYoutubeVideo($iId = ''){
        if($iId){
    		$oMultimediaContent = MultimediaContent::find($iId);
    		if($oMultimediaContent){
    			if(MultimediaContent::isVideo($oMultimediaContent->id)){
    				$video = $oMultimediaContent->video;
    				$result = preg_match("#embed/(.+)(\w+)#i", $video, $match);
			        $aUrl = explode('?', $match[1]);
			        return $aUrl[0];
    			}
    		}
    	}
    	return '';
    }


    /**
     * Metodo que genera la URL de un video de Youtube cuando se ha guardado el codigo como parametro.
     * @Autor Raúl Chauvin
     * @FechaCreacion  2017/06/08
     *
     * @param int iId?
     * @return string
     */
    public function urlVideoYoutube($iId = ''){
    	if($iId){
    		$oMultimediaContent = MultimediaContent::find($iId);
    		if($oMultimediaContent){
    			if(MultimediaContent::isVideo($oMultimediaContent->id)){
    				return 'https://www.youtube.com/watch?v='.MultimediaContent::codeYoutubeVideo($oMultimediaContent->id);
    			}
    		}
    	}
    	return '';
    }


    /**
     * Metodo que prepara el codigo de una galeria para adaptarla a la seccion del sitio web en que se desea colocar.
     * @Autor Raúl Chauvin
     * @FechaCreacion  2017/06/08
     *
     * @param int iId?
     * @param int iWidth
     * @param int iHeight
     * @param int iIdCut?
     * @return string
     */

    public function prepareGallery($iId = '', $iWidth, $iHeight, $iIdCut = ''){
        $galleryCode = "";
    	if($iId){
    		$oMultimediaContent = MultimediaContent::find($iId);
    		if($oMultimediaContent){
    			if(MultimediaContent::isGallery($oMultimediaContent->id)){
    				$aGalleryItems = $oMultimediaContent->gallery_items;
    				$galleryId = $oMultimediaContent->id;
			        if($aGalleryItems){
			            $ban=FALSE;
			            $galleryCode .= ''; // Incluir codigo de divs a implementarse en la galeria
			            foreach($aGalleryItems as $galleryItem){
			                $oGalleryItem = MultimediaContent::find($galleryItem);
			                if($oGalleryItem){
			                	if(MultimediaContent::isImage($oGalleryItem->id)){
				                    if(!$ban){
				                        if($iIdCut){
				                        	$galleryCode .= '
				                                <a href="'.asset('public'.Storage::url($oGalleryItem->image)).'" rel="prettyPhoto[gallery'.$oMultimediaContent->id.']" title="'.$oGalleryItem->description.'">
				                                    <img src="'.asset('public/storage/cuts/'.$iIdCut.'/'.Storage::url($oGalleryItem->image)).'" width="'.$iWidth.'" height="'.$iHeight.'" border="0" />
				                                </a>
				                            ';
				                        }else{
				                        	$galleryCode .= '
				                                <a href="'.asset('public'.Storage::url($oGalleryItem->image)).'" rel="prettyPhoto[gallery'.$oMultimediaContent->id.']" title="'.$oGalleryItem->description.'">
				                                    <img src="'.asset('public'.Storage::url($oGalleryItem->image)).'" width="'.$iWidth.'" height="'.$iHeight.'" border="0" />
				                                </a>
				                            ';
				                        }
				                        $ban = TRUE;
				                    }else{
				                        $galleryCode .= '
				                            <a href="'.asset('public'.Storage::url($oGalleryItem->image)).'" rel="prettyPhoto[gallery'.$oGalleryItem->id.']" title="'.$oGalleryItem->description.'"></a>
				                            ';
				                    }
				                }elseif(MultimediaContent::isVideo($oGalleryItem->id)){
				                    $galleryCode .= '
				                            <a href="'.MultimediaContent::urlVideoYoutube($oGalleryItem->id).'" rel="prettyPhoto[gallery'.$oMultimediaContent->id.']" title="'.$oGalleryItem->description.'"></a>
				                    ';
				                }
			                }
			            }
			            $galleryCode .= ''; // Fin de divs a implementarse en la galeria
			        }
    			}
    		}
    	}
        return $galleryCode;
    }


    /**
     * Metodo que verifica si la galeria ya tiene elementos asignados
     * @Autor Raúl Chauvin
     * @FechaCreacion  2017/06/08
     *
     * @return bool
     */
    public function hasMultimediaItems(){
        return $this->gallery_items ? TRUE : FALSE;
    }

    /**
     * Metodo que devuelve el numero de elementos multimedia que tiene la galeria
     * @Autor Raúl Chauvin
     * @FechaCreacion  2017/06/08
     *
     * @return bool
     */
    public function numElementosMultimedia(){
        return $this->hasMultimediaItems() ? count($this->gallery_items) : 0;
    }

    /**
     * Metodo que prepara el codigo de un archivo para adaptarlo a la seccion del sitio web en que se desea colocar.
     * @Autor Raúl Chauvin
     * @FechaCreacion  2017/06/08
     *
     * @param int iId?
     * @return string
     */
    public function prepareFile($iId = ''){
    	$fileLink = '';
    	if($iId){
    		$oMultimediaContent = MultimediaContent::find($iId);
    		if($oMultimediaContent){
    			if(MultimediaContent::isFile($oMultimediaContent->id)){
    				$fileExt = MultimediaContent::getExtension(asset('public'.Storage::url($oMultimediaContent->file)));
			        if((strtolower($extFile) == 'doc' || (strtolower($extFile) == 'docx' ))){
			            $fileIcon = '<img src="'.asset('public/images/icoWord.png').'" border="0" hspace="5" />';
			        }elseif((strtolower($extFile) == 'xls' || (strtolower($extFile) == 'xlsx' ))){
			            $fileIcon = '<img src="'.asset('public/images/icoExcel.png').'" border="0" hspace="5" />';
			        }elseif((strtolower($extFile) == 'ppt' || (strtolower($extFile) == 'pptx' ))){
			            $fileIcon = '<img src="'.asset('public/images/icoPowerPoint.png').'" border="0" hspace="5" />';
			        }elseif(strtolower($extFile) == 'pdf'){
			            $fileIcon = '<img src="'.asset('public/images/icoAcrobat.png').'" border="0" hspace="5" />';
			        }elseif((strtolower($extFile) == 'zip' || (strtolower($extFile) == 'rar' ))){
			            $imgArchivo = '<img src="'.asset('public/images/icoZip.png').'" border="0" hspace="5" />';
			        }else{
			            $fileIcon = '<img src="'.asset('public/images/icoTxt.png').'" border="0" hspace="5" />';
			        }
			        $fileLink = '<a href="'.asset('public'.Storage::url($oMultimediaContent->file)).'" target="_blank" title="'.$oMultimediaContent->name.': '.$oMultimediaContent->description.'">'.$fileIcon.$oMultimediaContent->name.'</a>';
    			}
    		}
    	}
        return $fileLink;
    }


    /**
     * Metodo que prepara el codigo de un audio para adaptarlo a la seccion del sitio web en que se desea colocar.
     * @Autor Raúl Chauvin
     * @FechaCreacion  2017/06/08
     *
     * @param int iId?
     * @param string width?
     * @param string initialVolume?
     * @param string animation?
     * @param string autostart?
     * @param string loop?
	 * @param string remaining?
	 * @param string noinfo?
	 * @param string transparentpagebg?
	 * @param string pagebg?
	 * @param string bg?
	 * @param string leftbg?
	 * @param string lefticon?
	 * @param string voltrack?
	 * @param string volslider?
	 * @param string rightbg?
	 * @param string rightbghover?
	 * @param string righticon?
	 * @param string righticonhover?
	 * @param string loader? 
	 * @param string track?
	 * @param string tracker?
	 * @param string border?
	 * @param string skip?
	 * @param string text?
	 * @param string buffer?
	 * @param string encode?
	 * @param string checkpolicy?
	 * @param string rtl?
	 *
     * @return string
     */
    public function prepAudio(
            $iId = '',
            $width = "100%",
            $initialVolume = "100",
            $animation = "no",
            $autostart = "no", 
            $loop = "no", 
            $remaining = "yes", 
            $noinfo = "no", 
            $transparentpagebg = "yes",
            $pagebg = "NA", 
            $bg = "E5E5E5", 
            $leftbg = "000000",
            $lefticon = "333333", 
            $voltrack = "F2F2F2", 
            $volslider = "666666",
            $rightbg = "B4B4B4", 
            $rightbghover = "999999", 
            $righticon = "333333",
            $righticonhover = "FFFFFF", 
            $loader = "009900", 
            $track = "FFFFFF",
            $tracker = "DDDDDD", 
            $border = "CCCCCC", 
            $skip = "666666", 
            $text = "333333",
            $buffer = 5, 
            $encode = "no", 
            $checkpolicy = "no",
            $rtl = "no"
            ){
        /*
         OPCIONES DEL AUDIO PLAYER (AudioPlayer.setup)
            autostart: "no" -> if yes, player starts automatically
            loop: "no" -> if yes, player loops
            animation : "no" -> if no, player is always open
            remaining : "yes" -> if yes, shows remaining track time rather than ellapsed time
            noinfo : "no" -> if yes, disables the track information display
            initialvolume : "100" -> initial volume level (from 0 to 100)
            buffer : 5 -> buffering time in seconds
            encode : "no" -> indicates that the mp3 file urls are encoded
            checkpolicy : "no" -> tells Flash to look for a policy file when loading mp3 files (this allows Flash to read ID3 tags from files hosted on a different domain)
            rtl : "no" -> switches the layout to RTL (right to left) for Hebrew and Arabic languages
            width : "100%" -> width of the player. e.g. 290 (290 pixels) or 100%
            transparentpagebg : "yes" -> if yes, the player background is transparent (matches the page background)
            pagebg : "NA" -> player background color (set it to your page background when transparentbg is set to no)
            bg : "E5E5E5" -> Background
            leftbg : "000000" -> Speaker icon/Volume control background
            lefticon : "333333" -> Speaker icon
            voltrack : "F2F2F2" -> Volume track
            volslider : "666666" -> Volume slider
            rightbg : "B4B4B4" -> Play/Pause button background
            rightbghover : "999999" -> Play/Pause button background (hover state)
            righticon : "333333" -> Play/Pause icon
            righticonhover : "FFFFFF" -> Play/Pause icon (hover state)
            loader : "009900" -> Loading bar
            track : "FFFFFF" -> Loading/Progress bar track backgrounds
            tracker : "DDDDDD" -> Progress track
            border : "CCCCCC" -> Progress bar border
            skip : "666666" -> Previous/Next skip buttons
            text : "333333" -> Text
         */
        $audioCode = '';
    	if($iId){
    		$oMultimediaContent = MultimediaContent::find($iId);
    		if($oMultimediaContent){
    			if(MultimediaContent::isAudio($oMultimediaContent->id)){
    				$audioCode = '
			            <div id="audioplayer_'.$oMultimediaContent->id.'"></div>
			            <script type="text/javascript">  
			                AudioPlayer.setup("'.asset('public/blaud-resources/js/player.swf').'", {
			                    autostart: "'.$autostart.'",
			                    loop: "'.$loop.'",
			                    animation : "'.$animation.'",
			                    remaining : "'.$remaining.'",
			                    noinfo : "'.$noinfo.'",
			                    initialvolume : "'.$initialVolume.'",
			                    buffer : '.$buffer.',
			                    encode : "'.$encode.'",
			                    checkpolicy : "'.$checkpolicy.'",
			                    rtl : "'.$rtl.'",
			                    width : "'.$width.'",
			                    transparentpagebg : "'.$transparentpagebg.'",
			                    pagebg : "'.$pagebg.'",
			                    bg : "'.$bg.'",
			                    leftbg: "'.$leftbg.'",
			                    lefticon : "'.$lefticon.'",
			                    voltrack : "'.$voltrack.'",
			                    volslider : "'.$volslider.'",
			                    rightbg : "'.$rightbg.'",
			                    rightbghover : "'.$rightbghover.'",
			                    righticon : "'.$righticon.'",
			                    righticonhover : "'.$righticonhover.'",
			                    loader : "'.$loader.'",
			                    track : "'.$track.'",
			                    tracker : "'.$tracker.'",
			                    border : "'.$border.'",
			                    skip : "'.$skip.'",
			                    text : "'.$text.'"
			                });
			                AudioPlayer.embed("audioplayer_'.$oMultimediaContent->id.'", {soundFile: "'.asset('public'.Storage::url($oMultimediaContent->audio)).'", titles: "'.$oMultimediaContent->name.'", artists: ""});
			            </script>
			                 ';
    			}
    		}
    	}
        return $audioCode;
    }



    /**
     * Metodo que obtiene la extension de un archivo dado.
     * @Autor Raúl Chauvin
     * @FechaCreacion  2017/06/08
     *
     * @param String file?
     * @return string
     */
    public function getExtension($file = ''){
  		preg_match("/(.*)\.([a-zA-Z0-9]{0,5})$/", $file, $regs);
	  	if(isset($regs[2])){
	  		return($regs[2]);
	  	}else{
		  	return false;
	  	}
    }


    /**
     * Metodo que devuelve el codigo del contenido multimedia listo para ser insertado en la seccion del sitio requerida
     * @Autor Raúl Chauvin
     * @FechaCreacion  2017/06/08
     *
     * @param integer iId?
     * @param integer width
     * @param integer height
     * @param string extra
     * @return string
     */
    public static function getMultimediaContent($iId = '', $width = '100', $height = '100', $extra = ''){
        $multimediaContent = "";
        if($iId){
    		$oMultimediaContent = MultimediaContent::find($iId);
    		if($oMultimediaContent){
    			if(MultimediaContent::isPublished($oMultimediaContent->id)){
    				
    				if(!$width){$width = '100';}
        			if(!$height){$height = '100';}
    				
    				$oCut = BlaudCMS\Cut::where('width', $width)->where('height', $height)->first();

    				if(MultimediaContent::isFreeHTML($oMultimediaContent->id)){
	                    $multimediaContent = MultimediaContent::prepareContent($oMultimediaContent->free_html, $width, $height);
	                }elseif(MultimediaContent::isAudio($oMultimediaContent->id)){
	                    $multimediaContent = MultimediaContent::prepareAudio($oMultimediaContent->id, $width);
	                }elseif(MultimediaContent::isFile($oMultimediaContent->id)){
	                    $multimediaContent = MultimediaContent::prepareFile($oMultimediaContent->id);
	                }elseif(MultimediaContent::isVideo($oMultimediaContent->id)){
	                    $multimediaContent = MultimediaContent::prepareVideo($oMultimediaContent->id, $width, $height);
	                }elseif(MultimediaContent::isImage($oMultimediaContent->id)){
	                	if($oCut){
	                		$imagePath = '<img alt="'.$oMultimediaContent->name.'" title="'.$oMultimediaContent->title.'" src="'.asset('public/storage/cuts/'.$oCut->id.'/'.Storage::url($oMultimediaContent->image)).'" width="'.$width.'" height="'.$height.'" border="0" '.$extra.' />';
	                	}else{
	                		$imagePath = '<img alt="'.$oMultimediaContent->name.'" title="'.$oMultimediaContent->title.'" src="'.asset('public'.Storage::url($oMultimediaContent->image)).'" width="'.$width.'" height="'.$height.'" border="0" '.$extra.' />';
	                	}
	                	MultimediaContent::prepareContent($imagePath, $width, $height);
	                }elseif(MultimediaContent::isGallery($oMultimediaContent->id)){
	                	$multimediaContent = MultimediaContent::prepareGallery($oMultimediaContent->id, $width, $height, $oRecorte->id_recorte);
	                }
    			}
    		}
    	}
        return $multimediaContent;
    }


    /**
    * Metodo que busca contenido multimedia de acuerdo a una cadena buscada
    * @Autor Raúl Chauvin
    * @FechaCreacion  2017/06/08
    *
    * @param string sStringSearch
    * @param integer[] aContentCategoryId
    * @param integer[] aLanguageId
    * @param integer iActive
    * @param integer[] aContentType
    * @param integer iPaginate
    *
    * @return MultimediaContent[] 
    */
    public static function searchMultimediaContent(
    												$sStringSearch = null, 
    												$aContentCategoryId = [],
    												$iActive = null, 
    												$aContentType = [], 
    												$iPaginate = 20
    											){
        if($sStringSearch){
            $aListMultimediaContents = MultimediaContent::where(function($sQuery) use ($sStringSearch){
            						$sQuery->where('name','like','%'.$sStringSearch.'%')
                                    ->orWhere('title','like','%'.$sStringSearch.'%')
                                    ->orWhere('subtitle','like','%'.$sStringSearch.'%')
                                    ->orWhere('description','like','%'.$sStringSearch.'%')
                                    ->orWhere('tags','like','%'.$sStringSearch.'%');
            					});
            
            if($iActive != null){
            	$aListMultimediaContents = $aListMultimediaContents->where('active', $iActive);
            }

            if(count($aContentType)){
            	$aListMultimediaContents = $aListMultimediaContents->where(function($sQuery) use($aContentType){
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
            
            if(count($aContentCategoryId)){
            	$aListMultimediaContents = $aListMultimediaContents->where(function($sQuery) use($aContentCategoryId){
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
            
            $aListMultimediaContents = $aListMultimediaContents->paginate($iPaginate);
        }else{
        	$aListMultimediaContents = null;
        	
        	if($aListMultimediaContents){
    			if(count($aContentType)){
	            	$aListMultimediaContents = $aListMultimediaContents->where(function($sQuery) use($aContentType){
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
	            	$aListMultimediaContents = MultimediaContent::where(function($sQuery) use($aContentType){
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

    		if($aListMultimediaContents){
    			if(count($aContentCategoryId)){
	            	$aListMultimediaContents = $aListMultimediaContents->where(function($sQuery) use($aContentCategoryId){
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
	            	$aListMultimediaContents = MultimediaContent::where(function($sQuery) use($aContentCategoryId){
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

        	if($aListMultimediaContents){
    			if($iActive != null){
	            	$aListMultimediaContents = $aListMultimediaContents->where('active', $iActive);
	            }
    		}else{
    			if($iActive != null){
	            	$aListMultimediaContents = MultimediaContent::where('active', $iActive);
	            }
    		}

    		if($aListMultimediaContents){
    			$aListMultimediaContents = $aListMultimediaContents->paginate($iPaginate);
    		}else{
    			$aListMultimediaContents = MultimediaContent::paginate($iPaginate);
    		}
        }
        return $aListMultimediaContents;
    }
}
