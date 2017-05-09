<?php

header('Content-Type: application/json');

include_once $_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR."application".DIRECTORY_SEPARATOR."config".DIRECTORY_SEPARATOR."bootstrap.php";

ob_start();
session_start();

/**
 * Created by PhpStorm.
 * User: fl4m3
 * Date: 05/05/2017
 * Time: 18:35
 */
class CaixaEntradaController extends MongoSample
{
    public function getCaixaEntrada(){
        try{
            $resultado = $this->get("email_entrada", ['enviado_para_id'=>new MongoDB\BSON\ObjectID($_SESSION['_id'])]);

            if((int)$resultado >= 1) echo json_encode(["success"=>1, "msg"=>$resultado]);
            else echo json_encode(["success"=>0, "msg"=>""]);

        }catch(Exception $e){
            echo json_encode(["success"=>0, "msg"=>$e->getMessage()]);
        }
    }
}
if (isset($_POST['action']) && !empty($_POST['action'])) {
    $action = $_POST['action'];
    $agenda = new CaixaEntradaController();
    try {
        switch ($action) {
            case 'getCaixaEntrada'        :
                $agenda->getCaixaEntrada();
                break;
        }
    } catch (MongoDB\Driver\Exception\ConnectionTimeoutException $e) {
        echo json_encode(["success" => 0, "msg" => "Tempo limite de conexão atingido, tente novamente!"]);
    }
}