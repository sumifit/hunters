<?php

header('Content-Type: application/json');

include_once $_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR."application".DIRECTORY_SEPARATOR."config".DIRECTORY_SEPARATOR."bootstrap.php";

ob_start();
session_start();

class Agenda extends MongoSample
{
    private $_id;
    private $candidato;
    private $hunter_empresa_id;
    private $evento;
    private $data_evento;
    private $hora_evento;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->_id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->_id = $id;
    }

    /**
     * @return mixed
     */
    public function getCandidato()
    {
        return $this->candidato;
    }

    /**
     * @param mixed $candidato
     */
    public function setCandidato($candidato)
    {
        $this->candidato = $candidato;
    }

    /**
     * @return mixed
     */
    public function getHunterEmpresaId()
    {
        return $this->hunter_empresa_id;
    }

    /**
     * @param mixed $hunter_empresa_id
     */
    public function setHunterEmpresaId($hunter_empresa_id)
    {
        $this->hunter_empresa_id = $hunter_empresa_id;
    }

    /**
     * @return mixed
     */
    public function getEvento()
    {
        return $this->evento;
    }

    /**
     * @param mixed $evento
     */
    public function setEvento($evento)
    {
        $this->evento = $evento;
    }

    /**
     * @return mixed
     */
    public function getDataEvento()
    {
        return $this->data_evento;
    }

    /**
     * @param mixed $data_evento
     */
    public function setDataEvento($data_evento)
    {
        $this->data_evento = $data_evento;
    }

    /**
     * @return mixed
     */
    public function getHoraEvento()
    {
        return $this->hora_evento;
    }

    /**
     * @param mixed $hora_evento
     */
    public function setHoraEvento($hora_evento)
    {
        $this->hora_evento = $hora_evento;
    }

    public function getEventos(){
        try{
            $resultado = $this->get("agenda", ['candidato_id'=>new MongoDB\BSON\ObjectID($_SESSION['_id'])]);

            if((int)$resultado >= 1) echo json_encode(["success"=>1, "msg"=>$resultado]);
            else echo json_encode(["success"=>0, "msg"=>""]);

        }catch(Exception $e){
            echo json_encode(["success"=>0, "msg"=>$e->getMessage()]);
        }
    }
    public function getNoti(){
        try{
            $resultado = $this->get("agenda", ['candidato_id'=>new MongoDB\BSON\ObjectID($_SESSION['_id'])]);
            $caixa = $this->get("enviado_para", ['usuario_id'=>new MongoDB\BSON\ObjectID($_SESSION['_id'])]);
            $avaliacao = $this->get("email_entrada", ['enviado_para_id'=>new MongoDB\BSON\ObjectID($_SESSION['_id'])]);


            if((int)$resultado >= 1) echo json_encode(["success"=>1, "msg"=>['agenda'=>$resultado, 'caixa'=>$caixa, 'avaliacao'=>$avaliacao]]);
            else echo json_encode(["success"=>0, "msg"=>['agenda'=>[], 'caixa'=>[], 'avaliacao'=>[]]]);

        }catch(Exception $e){
            echo json_encode(["success"=>0, "msg"=>$e->getMessage()]);
        }
    }
}
if (isset($_POST['action']) && !empty($_POST['action'])) {
    $action = $_POST['action'];
    $agenda = new Agenda();
    try {
        switch ($action) {
            case 'getEventos'        :
                $agenda->getEventos();
                break;
        }
        switch ($action) {
            case 'getNoti'        :
                $agenda->getNoti();
                break;
        }
    } catch (MongoDB\Driver\Exception\ConnectionTimeoutException $e) {
        echo json_encode(["success" => 0, "msg" => "Tempo limite de conexão atingido, tente novamente!"]);
    }
}