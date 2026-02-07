<?php

/**
 * Clase con diversas utilidades
 * ::camelcase($str, $lower = false)
 * ::smallcase($str)
 * ::smallcase($str)
 * ::underscore($str)
 * ::dash($str)
 * ::humanize($str)
 * ::getParams($params)
 * ::encomillar($lista)
 * 
 * @package     Libs
 */


class OdaUtils extends Util {
  const PERIODOS = [
    1=>'Periodo 1', 
    2=>'Periodo 2', 
    3=>'Periodo 3', 
    4=>'Periodo 4'
  ];
  
  
  const PERIODOS2 = [
    1=>'Periodo 1', 
    2=>'Periodo 2', 
    3=>'Periodo 3', 
    4=>'Periodo 4',
    5=>'Periodo 5',
  ];
  
  const VALORATIVOS = [
    'Fortaleza'     => 'Fortaleza', 
    'Debilidad'     => 'Debilidad', 
    'Recomendación' => 'Recomendación'
  ];

  const GENERO = [
    'M' => 'Masculino',
    'F' => 'Femenino',
  ];
    
  const MESES = [
    1 => 'Enero',
    2 => 'Febrero',
    3 => 'Marzo',
    4 => 'Abril',
    5 => 'Mayo',
    6 => 'Junio',
    7 => 'Julio',
    8 => 'Agosto',
    9 => 'Septiembre',
    10 => 'Octubre',
    11 => 'Noviembre',
    12 => 'Diciembre',
  ];
    
  const DIAS_SEMANA = [
    1 => 'Domingo',
    2 => 'Lunes',
    3 => 'Martes',
    4 => 'Miercoles',
    5 => 'Jueves',
    6 => 'Viernes',
    7 => 'Sábado',
  ];
  
  const IS_ACTIVE = [
    0 => 'Inactivo',
    1 => 'Activo',
  ];

  const IS_VISIBLE = [
    0 => 'Invisible',
    1 => 'Visible',
  ];

  const TIPO_REG_OBSERV = [
    'ACAD' => 'Académico',
    'DISC' => 'Disciplinario',
  ];
  
  /**
     * Obtiene el nombre del mes (valor numérico)
     */
    public static function nombreMes(int $mes=0, $abrev=false): string {
        $nombre_mes = match($mes) {
            1       => 'Enero',
            2       => 'Febrero',
            3       => 'Marzo',
            4       => 'Abril',
            5       => 'Mayo',
            6       => 'Junio',
            7       => 'Julio',
            8       => 'Agosto',
            9       => 'Septiembre',
            10      => 'Octubre',
            11      => 'Noviembre',
            12      => 'Diciembre',
            default => 'Mes no existe',
        };
        return (($abrev) ? substr($nombre_mes, offset: 0, length: 3) : $nombre_mes );
    } // END-nombreMes


    public static function fecha_corta($fecha) {
      if (!is_null($fecha)) {
        $date = new DateTimeImmutable($fecha, new DateTimeZone('America/Bogota'));
        return $date->format('M-d') ;
      } else {
        return $fecha;
      }      
    } //END-fecha_corta


    public static function ver_array(array $var) {
        return '<pre>' .print_r($var).'<br>'.count($var).'</pre>';
    }

    /**
     * Obtiene el nombre del Género
     */
    public static function nombreGenero(string $abrev): string {
        return match($abrev) {
            'M'  => self::GENERO['M'],
            'F'  => self::GENERO['F'],
            default => 'Género no existe',
        };
    } // END-nombreGenero

    /**
     * Genera una cadena de caracteres aleatrorios.
     */
    public static function randomString($length = 8) {
        $values = 'abcdefghijklmnopqrstuvwxyz0123456789';
        $len_values = strlen($values)-1;
        $strRand = '';
        for ( $i = 0; $i < $length; $i++ ) {
          $strRand .= $values[rand( 0, $len_values )];
        }
        return $strRand;
    } // END-randomString

    /**
     * Retorna la misma cadena truncada.
     */
    public static function truncate($text, int $length = 30, 
        string $truncateString = '...', bool $truncateLastspace = false): string {
        if(is_array($text)) {
            throw new KumbiaException('No puede truncar un array: '.implode(', ', $text));
        }
        if(is_null($text)) {
          return '';
          //  throw new KumbiaException('No puede truncar un valor nulo: ');
        }
        $text = (string) $text;
        if (mb_strlen($text) > $length) {
            $text = mb_substr($text, 0, $length - mb_strlen($truncateString));
            if ($truncateLastspace) {
                $text = preg_replace('/\s+?(\S+)?$/', '', $text);
            }
        $text = $text.$truncateString;
        }
        return $text;
    } // END-truncate

  
    /***
     * Retorna una cadena con cada palabra en su primera letra en mayusculas y el resto en minúsculas.
     * 
     */
    static function nombrePersona(string $string, bool $sanear = false, bool $notildes=false): string {
      $string = ($sanear) ? OdaUtils::sanearString(string: $string) : $string ;
      $string = ($notildes) ? self::eliminarTildes(texto: $string) : $string ;
      return ucwords(string: mb_strtolower(string: $string, encoding: 'UTF-8'));
    } // END-nombrePersona

    static function functionNames(string $string): string {
      $arr = str_split(string: str_replace(search: '_', replace: '', subject: $string));
      $new_string = '';
      foreach ($arr as $letra) {
        $new_string .= (($letra==strtoupper(string: $letra)) ? ' '.$letra : $letra);
      }
      return self::nombrePersona(string: $new_string);
    } // END-nombrePersona

    static function eliminarTildes(string $texto): string 
    { 
      return strtr($texto, "áéíóúÁÉÍÓÚüÜ", "aeiouAEIOUuU");
    }

  /***
   * Retorna una cadena limpia de caracteres no deseados
   */
  static function sanearString($string) {
    $resultado = trim($string);
    $resultado = str_replace(
        search: array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),
        replace: array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
        subject: $resultado
    );
 
    $resultado = str_replace(
        search: array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
        replace: array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
        subject: $resultado
    );
 
    $resultado = str_replace(
        search: array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
        replace: array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
        subject: $resultado
    );
 
    $resultado = str_replace(
        search: array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
        replace: array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
        subject: $resultado
    );
 
    $resultado = str_replace(
        search: array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
        replace: array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
        subject: $resultado
    );

    $resultado = str_replace(
        search: array('ç', 'Ç'),
        replace: array('c', 'C'),
        subject: $resultado
    );
 
    //Esta parte se encarga de eliminar cualquier caracter extraño
    $resultado = str_replace(
        search: array("¨", "º", "-", "~",
             "#", "@", "|", "!", '"',
             "·", "$", "%", "&", "/",
             "(", ")", "?", "'", "¡",
             "¿", "[", "^", "]",
             "+", "}", "{", "¨", "´",
             ">", "< ", ";", ",", ":",
             "."),
        replace: '',
        subject: $resultado
    );

    return $resultado;
  }



    /*
     * Metodo para obtener la ip real del cliente
     */
    public static function getIp() {
        return (isset($_SERVER['HTTP_CLIENT_IP']) ? $_SERVER['HTTP_CLIENT_IP'] : (isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR']));

        // if( isset($_SERVER['HTTP_X_FORWARDED_FOR']) ) {
        //     $client_ip = ( !empty($_SERVER['REMOTE_ADDR']) ) ? $_SERVER['REMOTE_ADDR'] : ( ( !empty($_ENV['REMOTE_ADDR']) ) ? $_ENV['REMOTE_ADDR'] : "unknown" );
        //     $entries = explode('[, ]', $_SERVER['HTTP_X_FORWARDED_FOR']);
        //     reset($entries);
        //     while (list(, $entry) = each($entries)) {
        //         $entry = trim($entry);
        //         if ( preg_match("/^([0-9]+\\.[0-9]+\\.[0-9]+\\.[0-9]+)/", $entry, $ip_list) ) {
        //             $private_ip = array('/^0\\./', '/^127\\.0\\.0\\.1/', '/^192\\.168\\..*/', '/^172\\.((1[6-9])|(2[0-9])|(3[0-1]))\\..*/', '/^10\\..*/');
        //             $found_ip = preg_replace($private_ip, $client_ip, $ip_list[1]);
        //             if ($client_ip != $found_ip) {
        //                 $client_ip = $found_ip;
        //                 break;
        //             }
        //         }
        //     }
        // } else {
        //     $client_ip = ( !empty($_SERVER['REMOTE_ADDR']) ) ? $_SERVER['REMOTE_ADDR'] : ( ( !empty($_ENV['REMOTE_ADDR']) ) ? $_ENV['REMOTE_ADDR'] : "unknown" );
        // }
        // return $client_ip;
    }

    //=============
    static function isLocalhost(): bool {
      return    $_SERVER["HTTP_HOST"] === "127.0.0.1"
             || $_SERVER["HTTP_HOST"] === "localhost"
             || strncmp(string1: $_SERVER["HTTP_HOST"], string2: "192.168.", length: 8) === 0;
    } // END-isLocalhost

    /*
     * Metodo para resaltar palabras de una cadena de texto
     */
    public static function resaltar(string $palabra, string $texto): string {
        $reemp = str_ireplace(search: $palabra, replace: '%s', subject: $texto);
        $aux = $reemp;
        $veces = substr_count(haystack: $reemp, needle: '%s');
        
        if($veces == 0) { return $texto; }

        $palabras_originales = array();
        for($i = 0 ; $i < $veces ; $i ++) {
            $palabras_originales[] = '<b style="color: red;">'.substr(string: $texto, offset: strpos(haystack: $aux, needle: '%s'), length: strlen(string: $palabra)).'</b>';
            $aux = substr(string: $aux, offset: 0, length: strpos(haystack: $aux, needle: '%s')). $palabra.substr(string: $aux, offset: strlen(string: substr(string: $aux, offset: 0, length: strpos(haystack: $aux, needle: '%s')))+2);
        }
        return vsprintf(format: $reemp, values: $palabras_originales);
    }

    /**
     * Metodo para crear el slug de cadenas de string dadas
     */
    public static function getSlug(
        string $string, 
        string $separator = '-', 
        int $length = 100,
    ): string {
        $search = explode(separator: ',', string: 'ç,Ç,ñ,Ñ,æ,Æ,œ,á,Á,é,É,í,Í,ó,Ó,ú,Ú,à,À,è,È,ì,Ì,ò,Ò,ù,Ù,ä,ë,ï,Ï,ö,ü,ÿ,â,ê,î,ô,û,å,e,i,ø,u,Š,Œ,Ž,š,¥');
        $replace = explode(separator: ',', string: 'c,C,n,N,ae,AE,oe,a,A,e,E,i,I,o,O,u,U,a,A,e,E,i,I,o,O,u,U,ae,e,i,I,oe,ue,y,a,e,i,o,u,a,e,i,o,u,s,o,z,s,Y');
        $string = str_replace(search: $search, replace: $replace, subject: $string);
        $string = strtolower(string: $string);
        $string = preg_replace(pattern: '/[^a-z0-9_]/i', replacement: $separator, subject: $string);
        $string = preg_replace(pattern: '/\\' . $separator . '[\\' . $separator . ']*/', replacement: $separator, subject: $string);
        if (strlen(string: $string) > $length) {
            $string = substr(string: $string, offset: 0, length: $length);
        }
        $string = preg_replace(pattern: '/\\' . $separator . '$/', replacement: '', subject: $string);
        $string = preg_replace(pattern: '/^\\' . $separator . '/', replacement: '', subject: $string);
        return $string;
    }

    /**
     * Método para ordenar un array de datos
     *
     * @param array $toOrderArray Array de datos
     * @param string $field Campo del array por el cual se va a ordenar
     * @param string $type Variable para indicar si ordena ASC o DESC
     * @return array
     */
    public static function orderArray(
        array $toOrderArray, 
        string|int $field, 
        string $type='DESC'
    ): array {
        $position = array();
        $newRow = array();
        foreach ($toOrderArray as $key => $row) {
            $position[$key]  = $row[$field];
            $newRow[$key] = $row;
        }
        if ($type=='DESC') {
            arsort($position);
        } else {
            asort($position);
        }
        $returnArray = array();
        foreach ($position as $key => $pos) {
            $returnArray[] = $newRow[$key];
        }
        return $returnArray;
    }
    
    /**
     * Devuelve el plural de un texto
     */
    public static function pluralize(string $cadena): string {
      if (str_ends_with(haystack: $cadena, needle: 'es')) { return $cadena; }
      if (str_ends_with(haystack: $cadena, needle: 's'))  { return $cadena; }
      return $cadena.'s';
    } // END-pluralize

    
    /**
     * Devuelve el singular de un texto
     */
    public static function singularize(string $cadena): string {
      $excepciones = [
        'aspirantes'=>'Aspirante', 
        'estudiantes'=>'Estudiante', 
        'cargas'=>'SalAsigProf'
      ];

      if (array_key_exists(strtolower($cadena), $excepciones)) {
        return $excepciones[$cadena];
      }
      if (str_ends_with($cadena, 'es')) { return substr($cadena, 0, strlen($cadena)-2); }
      if (str_ends_with($cadena, 's'))  { return substr($cadena, 0, strlen($cadena)-1); }
      return $cadena;
    } // END-pluralize

  
  /*
   * @url https://faq.whatsapp.com/5913398998672934/?locale=es_LA
   */
  public static function linkWhatsApp(
    string $telefono, 
    string $caption='Escribir al WhatsApp', 
    bool $show_tel=false, 
    string $message=''
  ): string 
  {
    if (!$telefono) return '';
    $insitit_name = Config::get('institutions.'.INSTITUTION_KEY.'.nombre');
    $text = $show_tel ? $telefono : $caption;
    $message_comp = "$insitit_name: $message";
    return "<a 
        title=\"$caption\" 
        href=\"https://wa.me/{$telefono}?text=$message_comp\" target=\"_blank\">"
        ._Icons::brands(icon: 'whatsapp', size: 'w3-large').' '.$text
      .'</a>';
  }

  public static function linkWA(
    string $telefono, 
    string $message='Escribir al WhatsApp'
  ): string 
  {
    if (!$telefono) return '';
    return "&nbsp;<a 
        title=\"$message\" href=\"https://wa.me/{$telefono}?text=$message\" target=\"_blank\">"
        ._Icons::brands(icon: 'whatsapp', size: 'w3-large')
      .'</a>&nbsp;';
  }

  public static function linkTelefono(string $telefono, string $caption='(click) Llamarle ahora', $show_tel=false): string {
    if (!$telefono) return '';
    $text = ($show_tel) ? ' '.$telefono : '' ;
    return "$text <a title=\"$caption\" href=\"tel:57$telefono\">"._Icons::solid(icon: 'square-phone', size: 'w3-large').'</a>';
  }

  public static function linkToSupportWhatsApp(string $uuid_error): string {
    $telefono = Config::get('config.construxzion.whatsapp');
    $username = Session::get('username');
    $date = date('Y-m-d H:i a', time());
    return "<a 
          title=\"Soporte técnico por WhatsApp\" 
          href=\"https://api.whatsapp.com/send?phone=573017153066&text=%F0%9F%9B%91%20SchoolNext%20%0AEXCEPCI%C3%93N%20INTERNA%20CAPTURADA%3A%20*$uuid_error*%0A%0Ausuario%3A%20*$username*%20%0Afecha%3A%20*$date*\" target=\"_blank\">$uuid_error</a>";
  }


    /**
     * Escribe en letras un monto numerico
     *
     * @param numeric $valor
     * @param string $moneda
     * @param string $centavos
     * @return string
     */
    public static function getNumeroALetras(
        int $valor=0, 
        string $moneda='PESOS', 
        int $centavos=0
    ): string {
        $a = $valor;
        $p = $moneda;
        $c = $centavos;
        $val = "";
        $v = $a;
        $a = (int) $a;
        $d = round($v - $a, 2);
        if($a>=1000000){
            $val = millones($a - ($a % 1000000));
            $a = $a % 1000000;
        }
        if($a>=1000){
            $val.= miles($a - ($a % 1000));
            $a = $a % 1000;
        }
        $val.= trim(value_num($a))." $p ";
        if($d){
            $d*=100;
            $val.= "CON ".value_num($d)." $c ";
        }
        return $val;
    }

}




/**
 * Las siguientes funciones son utilizadas para la generación
 * de versiones escritas de numeros
 *
 * @param numeric $a
 * @return string
 */
function value_num($a=1){
    if($a<=21){
        switch ($a){
            case 1: return 'UNO';
            case 2: return 'DOS';
            case 3: return 'TRES';
            case 4: return 'CUATRO';
            case 5: return 'CINCO';
            case 6: return 'SEIS';
            case 7: return 'SIETE';
            case 8: return 'OCHO';
            case 9: return 'NUEVE';
            case 10: return 'DIEZ';
            case 11: return 'ONCE';
            case 12: return 'DOCE';
            case 13: return 'TRECE';
            case 14: return 'CATORCE';
            case 15: return 'QUINCE';
            case 16: return 'DIECISEIS';
            case 17: return 'DIECISIETE';
            case 18: return 'DIECIOCHO';
            case 19: return 'DIECINUEVE';
            case 20: return 'VEINTE';
            case 21: return 'VEINTIUN';
        }
    } else {
        if($a<=99){
            if($a>=22&&$a<=29) {
                return "VENTI".value_num($a % 10);
            }
            if($a==30) {
                return  "TREINTA";
            }
            if($a>=31&&$a<=39) {
                return "TREINTA Y ".value_num($a % 10);
            }
            if($a==40) {
                $b = "CUARENTA";
            }
            if($a>=41&&$a<=49) {
                return "CUARENTA Y ".value_num($a % 10);
            }
            if($a==50) {
                return "CINCUENTA";
            }
            if($a>=51&&$a<=59) {
                return "CINCUENTA Y ".value_num($a % 10);
            }
            if($a==60) {
                return "SESENTA";
            }
            if($a>=61&&$a<=69) {
                return "SESENTA Y ".value_num($a % 10);
            }
            if($a==70) {
                return "SETENTA";
            }
            if($a>=71&&$a<=79) {
                return "SETENTA Y ".value_num($a % 10);
            }
            if($a==80) {
                return "OCHENTA";
            }
            if($a>=81&&$a<=89) {
                return "OCHENTA Y ".value_num($a % 10);
            }
            if($a==90) {
                return "NOVENTA";
            }
            if($a>=91&&$a<=99) {
                return "NOVENTA Y ".value_num($a % 10);
            }
        } else {
            if($a==100) {
                return "CIEN";
            }
            if($a>=101&&$a<=199) {
                return "CIENTO ".value_num($a % 100);
            }
            if($a>=200&&$a<=299) {
                return "DOSCIENTOS ".value_num($a % 100);
            }
            if($a>=300&&$a<=399) {
                return "TRECIENTOS ".value_num($a % 100);
            }
            if($a>=400&&$a<=499) {
                return "CUATROCIENTOS ".value_num($a % 100);
            }
            if($a>=500&&$a<=599) {
                return "QUINIENTOS ".value_num($a % 100);
            }
            if($a>=600&&$a<=699) {
                return "SEICIENTOS ".value_num($a % 100);
            }
            if($a>=700&&$a<=799) {
                return "SETECIENTOS ".value_num($a % 100);
            }
            if($a>=800&&$a<=899) {
                return "OCHOCIENTOS ".value_num($a % 100);
            }
            if($a>=901&&$a<=999) {
                return "NOVECIENTOS ".value_num($a % 100);
            }
        }
    }
}
/**
 * Genera una cadena de millones
 *
 * @param numeric $a
 * @return string
 */
function millones($a=1) {
    $a = $a / 1000000;
    if($a==1) {
        return "UN MILLON ";
    } else {
        return value_num($a)." MILLONES ";
    }
}

/**
 * Genera una cadena de miles
 *
 * @param numeric $a
 * @return string
 */
function miles($a=1){
    $a = $a / 1000;
    if($a==1) {
	return "MIL";
    } else {
	return value_num($a)." MIL ";
    }
}




?>
