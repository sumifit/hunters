<?php

include_once $_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR."application".DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR."config".DIRECTORY_SEPARATOR."bootstrap.php";

/**
 * Created by PhpStorm.
 * User: dev
 * Date: 11/04/2017
 * Time: 19:19
 */
class TemplateController
{
    private $_scriptPath = __DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "includes" . DIRECTORY_SEPARATOR;//comes from config.php
    public $properties;

    public function setScriptPath($scriptPath)
    {
        $this->_scriptPath = $scriptPath;
    }

    public function __construct($properties)
    {
        $this->properties = $properties;
    }

    public function render($filename)
    {
        include($this->_scriptPath . $filename);
    }

    public static function truncarString($string, $tamanhoString)
    {

        if (strlen($string) > $tamanhoString)
            $string = substr($string, 0, $tamanhoString) . ' ...';

        return $string;
    }

    public static function firstName($string)
    {

        if (!empty($string))
            $string = explode(" ", $string);

        return $string[0];
    }

    public function __set($k, $v)
    {
        $this->properties[$k] = $v;
    }

    public function __get($k)
    {
        return $this->properties[$k];
    }
}