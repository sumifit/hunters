<?php

/**
 * Created by PhpStorm.
 * User: dev
 * Date: 22/04/2017
 * Time: 02:46
 */
class Helpers
{
    public static function jsonEncode( $array ) {
        self::recursive_utf8_encode( $array );
        return utf8_decode( json_encode( $array ) );
    }
    public static function jsonDecode( $json ) {
        if( !is_object( $json ) || !$json instanceof stdClass )
            $json = json_decode( $json );
        if( is_array( $json ) ) {
            $array = array();
            foreach( $json as $object )
                $array[] = self::jsonDecode( $object );
            return $array;
        }
        $array = get_object_vars( $json );
        self::recursive_utf8_decode( $array );
        return $array;
    }
    public static function recursive_utf8_encode( &$array ) {
        if(isset($array) && !empty($array) && is_array($array)){
            array_walk_recursive($array, create_function('&$item, $key', '$item = utf8_encode((string)$item);'));
        }else{
            return false;
        }
    }
    public static function recursive_utf8_decode( &$array ) {
        if(isset($array) && !empty($array) && is_array($array)){
            array_walk_recursive($array, create_function('&$item, $key', '$item = utf8_decode((string)$item);'));
        }else{
            return false;
        }
    }
    public static function geraSenha($tamanho = 8, $maiusculas = true, $numeros = true, $simbolos = false)
    {
        $lmin = 'abcdefghijklmnopqrstuvwxyz';
        $lmai = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $num = '1234567890';
        $simb = '!@#$%*-';
        $retorno = '';
        $caracteres = '';
        $caracteres .= $lmin;
        if ($maiusculas) $caracteres .= $lmai;
        if ($numeros) $caracteres .= $num;
        if ($simbolos) $caracteres .= $simb;
        $len = strlen($caracteres);
        for ($n = 1; $n <= $tamanho; $n++) {
            $rand = mt_rand(1, $len);
            $retorno .= $caracteres[$rand-1];
        }
        return $retorno;
    }
}