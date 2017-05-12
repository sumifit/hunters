<?php
header('Content-Type: application/json');

include_once $_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR."application".DIRECTORY_SEPARATOR."config".DIRECTORY_SEPARATOR."bootstrap.php";

ob_start();
session_start();

/**
 * Created by PhpStorm.
 * User: fl4m3
 * Date: 05/05/2017
 * Time: 18:37
 */
class VagasController extends MongoSample
{
    public function listarVagas($filtros = []){

        $manager = new \MongoDB\Driver\Manager($this->getConString());

        $result = array();

        $options = [];

        $query = new MongoDB\Driver\Query($filtros, $options);
        $cursor = $manager->executeQuery($this->getNamespace("vagas"), $query);

        foreach ($cursor as $document) {
            $queryEmpresa = new MongoDB\Driver\Query(["_id"=>new MongoDB\BSON\ObjectID($document->empresa_id)], ['multi'=>false]);
            $cursorEmpresa = $manager->executeQuery($this->getNamespace("usuario"), $queryEmpresa);

            foreach($cursorEmpresa as $documentEmpresa){
                $document->empresa = $documentEmpresa;
            }

            array_push($result, $document);
        }
        if(count($result) >= 1){
            return ['success'=> 1, 'msg'=> $result];
        }else return ['success'=> 0, 'msg'=> $result];
    }
    public function listarCargos($filtros = []){

        $manager = new \MongoDB\Driver\Manager($this->getConString());

        $result = array();

        $options = [];

        $query = new MongoDB\Driver\Query($filtros, $options);
        $cursor = $manager->executeQuery($this->getNamespace("cargos"), $query);

        foreach ($cursor as $document) {
            array_push($result, $document);
        }

        if(count($result) >= 1){
            return ['success'=> 1, 'msg'=> $result];
        }else return ['success'=> 0, 'msg'=> $result];
    }

    public function listarEmpresas(){

        $manager = new \MongoDB\Driver\Manager($this->getConString());

        $result = array();

        $options = [];
        $filtros = [];

        $query = new MongoDB\Driver\Query($filtros, $options);
        $cursor = $manager->executeQuery($this->getNamespace("usuario"), $query);

        foreach ($cursor as $document) {
            if(property_exists($document, "empresa")){
                array_push($result, $document->empresa);
            }
        }

        if(count($result) >= 1){
            return ['success'=> 1, 'msg'=> $result];
        }else return ['success'=> 0, 'msg'=> $result];
    }
}
if (isset($_POST['action']) && !empty($_POST['action'])) {
    $action = $_POST['action'];
    $uController = new VagasController();
    try {
        switch ($action) {
            case 'listarVagas'        :
                echo json_encode($uController->listarVagas());
                break;
            case 'listarCargos'        :
                echo json_encode($uController->listarCargos());
                break;
            case 'listarEmpresas'        :
                echo json_encode($uController->listarEmpresas());
                break;
        }
    } catch (MongoDB\Driver\Exception\ConnectionTimeoutException $e) {
        echo Helpers::jsonEncode(["success" => 0, "msg" => "Tempo limite de conexão atingido, tente novamente!"]);
    }
}