<?php
require_once "constantes.php";

extract($_POST);

date_default_timezone_set('America/Sao_Paulo');

//AutoLoader
spl_autoload_register(function ($class_name) {
    include CONTROLLERS . $class_name . '.php';
});

define("DEBUG", false);

function switchMethod($object, $action){
    if (isset($_POST['action']) && !empty($_POST['action'])) {
        $action = $_POST['action'];

        try {
            $object->$action();
        }catch(Exception $e){

        }
}

}