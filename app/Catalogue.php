<?php

namespace BlaudCMS;

use Illuminate\Database\Eloquent\Model;
use Alsofronie\Uuid\UuidModelTrait;

/**
* Clase para administración de catalogos del sistema
* @Autor Raúl Chauvin
* @FechaCreacion  2018/08/30
* @Parametrization
*/

class Catalogue extends Model
{
    use UuidModelTrait;
    
    /**
     * Tabla de la Base de Datos usada por el modelo.
     *
     * @var string
     */
    protected $table = 'catalogs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'context',
        'code',
        'description',
        'coordinates',
        'string_value1',
        'string_value2',
        'long_string_value1',
        'long_string_value2',
        'text_value1',
        'text_value2',
        'boolean_value1',
        'boolean_value2',
        'boolean_value3',
        'integer_value1',
        'integer_value2',
        'integer_value3',
        'decimal_value1',
        'decimal_value2',
        'decimal_value3',
        'date_value1',
        'date_value2',
        'time_value1',
        'time_value2',
        'datetime_value1',
        'datetime_value2',
        'father_code',
        'father_description',
        'catalogue_id',
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
    FechaCreacion  2018/08/30
    Metodos para construir relaciones en ORM
    ******************************************************************/

    // Catalogue __has_many__ Catalogue
    public function childrenCatalogs() {
        return $this->hasMany('BlaudCMS\Catalogue','catalogue_id', 'id');
    }

    // Catalogue __belongs_to__ Catalogue
    public function superCatalogue() {
        return $this->belongsTo('BlaudCMS\Catalogue','catalogue_id', 'id');
    }

    /*************************************************************************************************
        Metodos scope para utilizar en el controlador
        Autor Raúl Chauvin
        FechaCreacion  2018/08/30
    **************************************************************************************************/

    public function scopeByCode($sQuery, $sCode){
        return $sQuery->where('code', $sCode);
    }

    public function scopeByDescription($sQuery, $sDescription){
        return $sQuery->where('description', $sDescription);
    }

    public function scopeByContext($sQuery, $sContext){
        return $sQuery->where('context', $sContext);
    }

    public function scopeBySuperCatalogue($sQuery, $iIdSuperCatalogue){
        return $sQuery->where('catalogue_id', $iIdSuperCatalogue);
    }

    /**
    * Metodo que busca catalogos de acuerdo a una cadena buscada y el contexto del catalogo
    * @Autor Raúl Chauvin
    * @FechaCreacion  2018/01/03
    *
    * @param string sStringSearch
    * @param string sContext
    * @param int iIdSuperCatalogue
    * @param int iPaginate
    * @return Catalogue[] 
    */
    public static function searchCatalogs($sStringSearch = '', $sContext = '', $iIdSuperCatalogue = '', $iPaginate = 20){
        if($sStringSearch){
            if($sContext){
                if($iIdSuperCatalogue){
                  return Catalogue::byContext($sContext)
                            ->bySuperCatalogue($iIdSuperCatalogue)
                            ->where(function($sQuery) use($sStringSearch){
                                $sQuery->where('code','like','%'.$sStringSearch.'%')
                                      ->orWhere('description','like','%'.$sStringSearch.'%')
                                      ->orWhere('string_value1','like','%'.$sStringSearch.'%')
                                      ->orWhere('string_value2','like','%'.$sStringSearch.'%')
                                      ->orWhere('long_string_value1','like','%'.$sStringSearch.'%')
                                      ->orWhere('long_string_value2','like','%'.$sStringSearch.'%')
                                      ->orWhere('text_value1','like','%'.$sStringSearch.'%')
                                      ->orWhere('text_value2','like','%'.$sStringSearch.'%')
                                      ->orWhere('father_code','like','%'.$sStringSearch.'%')
                                      ->orWhere('father_description','like','%'.$sStringSearch.'%');
                            })
                            ->orderBy('description', 'asc')
                            ->paginate($iPaginate);
                }else{
                  return Catalogue::byContext($sContext)
                            ->where(function($sQuery) use($sStringSearch){
                                $sQuery->where('code','like','%'.$sStringSearch.'%')
                                      ->orWhere('description','like','%'.$sStringSearch.'%')
                                      ->orWhere('string_value1','like','%'.$sStringSearch.'%')
                                      ->orWhere('string_value2','like','%'.$sStringSearch.'%')
                                      ->orWhere('long_string_value1','like','%'.$sStringSearch.'%')
                                      ->orWhere('long_string_value2','like','%'.$sStringSearch.'%')
                                      ->orWhere('text_value1','like','%'.$sStringSearch.'%')
                                      ->orWhere('text_value2','like','%'.$sStringSearch.'%')
                                      ->orWhere('father_code','like','%'.$sStringSearch.'%')
                                      ->orWhere('father_description','like','%'.$sStringSearch.'%');
                            })
                            ->orderBy('description', 'asc')
                            ->paginate($iPaginate);
                }
            }else{
                return [];
            }
        }else{
            if($sContext){
                if($iIdSuperCatalogue){
                  return Catalogue::byContext($sContext)->bySuperCatalogue($iIdSuperCatalogue)->orderBy('description', 'asc')->paginate($iPaginate);
                }else{
                  return Catalogue::byContext($sContext)->orderBy('description', 'asc')->paginate($iPaginate);
                }
            }else{
                return [];
            }
        }
    }

    /**
    * Metodo que genera un nuevo codigo para el catalogo que se va a insertar en la BD
    * @Autor Raúl Chauvin
    * @FechaCreacion  2018/01/03
    *
    * @param string sContext
    * @param int iIdSuperCatalogue
    * @return string sCode
    */
    public static function generateCode($sContext = '', $iIdSuperCatalogue = ''){
      // Se inicializa la variable
      $newCode = '';

      if($sContext){  // Verificamos si esta llegando el parametro Contexto, de otra manera se devolvera el codigo en blanco
        // Obtenemos la lista de catalogos relacionados con el contexto 
        $catalogsList = Catalogue::byContext($sContext);
        if($iIdSuperCatalogue){
          // Si llega el ID del catalogo padre, obtenemos unicamente los registros hijos de este catalogo
          $catalogsList = $catalogsList->bySuperCatalogue($iIdSuperCatalogue);
        }
        $catalogsList = $catalogsList->get();
        $numCharacters = 1;
        $codeMax = 0; // En esta variable se almacenara el codigo maximo de la lista de catalogos
        $nextCode = 1; // En esta variable se almacenara
        if(count($catalogsList)){
          foreach($catalogsList as $oCatalogue){
            // A continuacion obtenemos unicamente el secuencial de cada catalogo, quitando el resto del codigo para poder obtener el maximo
            // En la variable $numCharacters seteamos el numero de caracteres que debe tener el secuencial de cada catalogo
            switch (strtolower($sContext)) {
              case 'ciudades':
                $sequential = substr($oCatalogue->code, 3, 2);
                $numCharacters = 2;
                break;
              default:
                $sequential = $oCatalogue->code;
                $numCharacters = 1;
                break;
            }
            $secInt = (int)$sequential;  // Una vez obtenido el maximo secuencial, guardamos el numero entero en otra variable para incrementarlo
            if($secInt > $codeMax){
              $codeMax = $secInt;
            }
          }
          // Incrementamos en 1 el secuencial del codigo del catalogo
          $nextCode += $codeMax;
        }else{
          // A continuacion obtenemos unicamente el secuencial de cada catalogo, quitando el resto del codigo para poder obtener el maximo
          // En la variable $numCharacters seteamos el numero de caracteres que debe tener el secuencial de cada catalogo
          $sequential = 0;
          switch (strtolower($sContext)) {
            case 'ciudades':
              $numCharacters = 2;
              break;
            default:
              $numCharacters = 1;
              break;
          }
          $secInt = (int)$sequential;  // Una vez obtenido el maximo secuencial, guardamos el numero entero en otra variable para incrementarlo
          if($secInt > $codeMax){
            $codeMax = $secInt;
          }
          // Incrementamos en 1 el secuencial del codigo del catalogo
          $nextCode += $codeMax;
        }
        // De acuerdo al numero de caracteres que tiene cada secuencial, llenamos con ceros (0) a la izquierda el secuencial para completar el numero de caracteres que debe tener el secuencial
        $newCode = str_pad($nextCode, $numCharacters, "0", STR_PAD_LEFT);
        // Si el catalogo tiene un padre, obtenemos el padre y agregamos su codigo al codigo del secuencial generado para completar el codigo del catalogo
        if($iIdSuperCatalogue){
          $objSuperCatalogue = Catalogue::find($iIdSuperCatalogue);
          if($objSuperCatalogue){
            $newCode = $objSuperCatalogue->code."-".$newCode;
          }
        }
      }
      return $newCode; // retornamos el codigo nuevo generado
    }
}
