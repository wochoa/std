<?php
/**
 * Created by PhpStorm.
 * User: Walther
 * Date: 11/05/2017
 * Time: 12:22
 */

namespace App\_clases\utilitarios;


class Cadena
{
    public static function  iniciales($str){
        $words=explode(' ',$str);
        $iniciales='';
        $excludeWords=array('___','POR', 'DE', 'EN', 'Y');
       //if ($str=='RECURSOS POR OPERACIONES OFICIALES DE CREDITO')dd([$words,$excludeWords, $words[1], array_search($words[1], $excludeWords)]);
        foreach ($words as $word){
            if(strlen($word)>1){
                if ( array_search($word, $excludeWords)== NULL)
                $iniciales.=substr($word,0,1);
            }
        }
        return $iniciales;
    }

    public static function ReplaceCadena($valores, $cadena){
        $cad =$cadena;
        foreach ($valores as $key => $value) {
            $cad = str_replace($key, $value, $cad);
        }
        return $cad;
    }

    public static function firstuppchar($cadena){
        $excludeWords=array('___','por', 'de', 'en', 'y');
        $cad = array();
        foreach (explode(' ',$cadena) as $key => $value) {
            if (in_array($value, $excludeWords)) {
                $cad[$key] = $value;
            }else{
                $cad[$key] = ucwords($value);
            }
        }
        return implode(' ', $cad);
    }
    public static function getHash($data){
        return md5(utf8_decode(json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK )));
    }
}