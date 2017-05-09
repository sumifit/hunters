<?php
header('Content-Type: application/json');

include_once $_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR."application".DIRECTORY_SEPARATOR."config".DIRECTORY_SEPARATOR."bootstrap.php";

ob_start();
session_start();

class UserController extends MongoSample
{
    public function setSessionData($session)
    {
        $_SESSION['valid'] = true;
        $_SESSION['timeout'] = time();
        $_SESSION['_id'] = $session["id"];
        $_SESSION ['email'] = $session["email"];
        $_SESSION ['nome'] = $session["nome"];
        $_SESSION ['page'] = 0;
    }

    public function login()
    {
        $manager = new \MongoDB\Driver\Manager($this->getConString());
        $email = $_POST['email'];
        $senha = $_POST['senha'];
        $result = array();

        if ($email) {

            $filter = ['email' => $email];

            $options = [];

            $query = new MongoDB\Driver\Query($filter, $options);

            $cursor = $manager->executeQuery('huntersdb.usuario', $query);

            foreach ($cursor as $row) {
                if ($row->senha == $senha && $row->email = $senha && !isset($row->boolfacebook)) {
                    $result ['id'] = $row->_id;

                    $session["id"] = $row->_id;
                    $session["email"] = $row->email;
                    $session["nome"] = $row->nome;
                    $this->setSessionData($session);

                    $retorno = ["success" => 1, "msg" => "Logado com sucesso", "id" => $result ['id']];
                    echo json_encode($retorno);
                    break;
                } else {
                    $result ["erro"] = "usuario e senha não conferem";
                    echo json_encode($result);
                }


            }

        }
    }

    public function getUsuarioData()
    {
        if(!isset($_SESSION['_id'])){
            echo json_encode(array("success"=>0, "msg" => []));
            die;
        }

        $manager = new \MongoDB\Driver\Manager($this->getConString());
        $id = $_SESSION['_id'];
        $result = array();
        $filter = ['_id' => new MongoDB\BSON\ObjectID($id)];

        $options = [];

        $query = new MongoDB\Driver\Query($filter, $options);

        $cursor = $manager->executeQuery('huntersdb.usuario', $query);
        foreach ($cursor as $row) {
            return array("msg" => $row);
        }
    }

    public function getDominioData()
    {
        try{

            $manager = new \MongoDB\Driver\Manager($this->getConString());
            $result = array();

            $filter = [];
            $options = [];
            $collections = ['escolaridade', 'bandeira_cartoes', 'cargos', 'disponibilidade_inicio', 'estado_civil', 'estados', 'formas_contratacao', 'habilidades', 'idiomas', 'nacionalidade', 'nivel_idioma', 'pais'];

            $query = new MongoDB\Driver\Query($filter, $options);

            foreach($collections as $chave => $valor){
                $result[$valor] = [];
                $actualNamespace = $this->getNamespace($valor);

                $cursor = $manager->executeQuery($actualNamespace, $query);

                foreach ($cursor as $document) {
                    array_push($result[$valor], $document);
                }
            }

            if(count($result) >= 1) return ['success'=>true, 'msg'=>$result];
            else return ['success'=>false, 'msg'=>$result];

        }catch(Exception $e){
            return ['success'=>false, 'msg'=>$e->getMessage()];
        }

    }

    /*
     * Recebe um array chave valor dos dados a serem gravados no banco
     *
     * @param (dados) array chave valor dos dados a serem gravados no banco
     * @return (getModifiedCount) quantidade de linhas alteradas
     */
    public function atualizarDadosPessoais($dados)
    {

        $manager = new \MongoDB\Driver\Manager($this->getConString());
        $insRec = new MongoDB\Driver\BulkWrite;
        $insRec->update(['_id' => new MongoDB\BSON\ObjectID($_SESSION['_id'])], ['$set' => $dados], ['multi' => false, 'upsert' => false]);

        $writeConcern = new MongoDB\Driver\WriteConcern(MongoDB\Driver\WriteConcern::MAJORITY, 1000);

        $result = $manager->executeBulkWrite('huntersdb.usuario', $insRec, $writeConcern);

        echo json_encode(['success' => $result->getModifiedCount()]);

    }

    /*
     * recebe uma lista com uma formação academica e empurra no array instituição do documento MongoDB
     *
     * @param (dados) array chave valor dos dados a serem gravados no banco
     * @return (getModifiedCount) quantidade de linhas alteradas
     */
    public function pushFormacaoAcademica($dados)
    {

        $manager = new \MongoDB\Driver\Manager($this->getConString());
        $insRec = new MongoDB\Driver\BulkWrite;

        if( !($this->getMongo('usuario', ['formacao_academica' => $dados]) >= 1) ){
            $insRec->update(['_id' => new MongoDB\BSON\ObjectID($_SESSION['_id'])], ['$push' => ['formacao_academica' => $dados]], ['multi' => false, 'upsert' => false]);

            $writeConcern = new MongoDB\Driver\WriteConcern(MongoDB\Driver\WriteConcern::MAJORITY, 1000);

            $result = $manager->executeBulkWrite('huntersdb.usuario', $insRec, $writeConcern);

            echo json_encode(['success' => $result->getModifiedCount(), 'msg'=>'']);
        }else{
            echo json_encode(['success' => 0, 'msg'=>'Esse curso já foi cadastrado']);
        }
    }

    /*
     * recebe uma lista com uma experiencia profissional e empurra no array experiencia_profissional do documento MongoDB
     *
     * @param (dados) array chave valor dos dados a serem gravados no banco
     * @return (getModifiedCount) quantidade de linhas alteradas
     */
    public function pushExperienciaProfissional($dados)
    {
        if( !($this->getMongo('usuario', ['experiencia_profissional' => $dados]) >= 1) ) {

            $manager = new \MongoDB\Driver\Manager($this->getConString());
            $insRec = new MongoDB\Driver\BulkWrite;

            $insRec->update(['_id' => new MongoDB\BSON\ObjectID($_SESSION['_id'])], ['$push' => ['experiencia_profissional' => $dados]], ['multi' => false, 'upsert' => false]);

            $writeConcern = new MongoDB\Driver\WriteConcern(MongoDB\Driver\WriteConcern::MAJORITY, 1000);

            $result = $manager->executeBulkWrite('huntersdb.usuario', $insRec, $writeConcern);

            echo json_encode(['success' => $result->getModifiedCount()]);

        }else{
            echo json_encode(['success' => 0, 'msg'=>'Esse histórico profissional já foi cadastrado']);
        }

    }

    /*
     * recebe uma lista com cursos extra curriculares e da push
     *
     * @param (dados) array chave valor dos dados a serem gravados no banco
     * @return (getModifiedCount) quantidade de linhas alteradas
     */
    public function pushExtraCurriculares($dados)
    {

        if( !($this->getMongo('usuario', ['curso_extra' => $dados]) >= 1) ) {
            $manager = new \MongoDB\Driver\Manager($this->getConString());
            $insRec = new MongoDB\Driver\BulkWrite;

            $insRec->update(['_id' => new MongoDB\BSON\ObjectID($_SESSION['_id'])], ['$push' => ['curso_extra' => $dados]], ['multi' => false, 'upsert' => false]);

            $writeConcern = new MongoDB\Driver\WriteConcern(MongoDB\Driver\WriteConcern::MAJORITY, 1000);

            $result = $manager->executeBulkWrite('huntersdb.usuario', $insRec, $writeConcern);

            echo json_encode(['success' => $result->getModifiedCount()]);
        }else{
            echo json_encode(['success' => 0, 'msg'=>'Esse curso já foi cadastrado']);
        }


    }


    /*
     * recebe uma lista com uma experiencia profissional e empurra no array experiencia_profissional do documento MongoDB
     *
     * @param (dados) array chave valor dos dados a serem gravados no banco
     * @return (getModifiedCount) quantidade de linhas alteradas
     */
    public function pushCertificacoes($dados)
    {

        if( !($this->getMongo('usuario', ['certificacoes' => $dados]) >= 1) ) {

            $manager = new \MongoDB\Driver\Manager($this->getConString());
            $insRec = new MongoDB\Driver\BulkWrite;

            $insRec->update(['_id' => new MongoDB\BSON\ObjectID($_SESSION['_id'])], ['$push' => ['certificacoes' => $dados]], ['multi' => false, 'upsert' => false]);

            $writeConcern = new MongoDB\Driver\WriteConcern(MongoDB\Driver\WriteConcern::MAJORITY, 1000);

            $result = $manager->executeBulkWrite('huntersdb.usuario', $insRec, $writeConcern);

            echo json_encode(['success' => $result->getModifiedCount()]);

        }else{
            echo json_encode(['success' => 0, 'msg'=>'Essa certificação já foi cadastrada']);
        }

    }

    /*
     * recebe uma lista com uma experiencia profissional e empurra no array experiencia_profissional do documento MongoDB
     *
     * @param (dados) array chave valor dos dados a serem gravados no banco
     * @return (getModifiedCount) quantidade de linhas alteradas
     */
    public function pushOutrasFormacoes($dados)
    {
        if( !($this->getMongo('usuario', ['outros' => $dados]) >= 1) ) {
            $manager = new \MongoDB\Driver\Manager($this->getConString());
            $insRec = new MongoDB\Driver\BulkWrite;

            $insRec->update(['_id' => new MongoDB\BSON\ObjectID($_SESSION['_id'])], ['$set' => ['outros' => $dados]], ['multi' => false, 'upsert' => false]);

            $writeConcern = new MongoDB\Driver\WriteConcern(MongoDB\Driver\WriteConcern::MAJORITY, 1000);

            $result = $manager->executeBulkWrite('huntersdb.usuario', $insRec, $writeConcern);

            echo json_encode(['success' => $result->getModifiedCount()]);
        }else{
            echo json_encode(['success' => 0, 'msg'=>'Essa formação já foi cadastrada']);
        }

    }

    /*
     * Empurra uma posição no documento dado um determinado objeto
     *
     * @param (dados) array chave valor dos dados a serem gravados no banco
     * @return (getModifiedCount) quantidade de linhas alteradas
     */
    public function pushSubArray($dados, $subArrayName)
    {
        if (!is_array($dados) || empty($subArrayName)) {
            echo json_encode(['success' => 0]);
            return false;
        }

        if( !($this->getMongo('usuario', ["outros.{$subArrayName}" => $dados]) >= 1) ) {

            $manager = new \MongoDB\Driver\Manager($this->getConString());
            $insRec = new MongoDB\Driver\BulkWrite;

            $insRec->update(['_id' => new MongoDB\BSON\ObjectID($_SESSION['_id'])], ['$push' => ["outros.{$subArrayName}" => $dados]], ['multi' => false, 'upsert' => false]);

            $writeConcern = new MongoDB\Driver\WriteConcern(MongoDB\Driver\WriteConcern::MAJORITY, 1000);

            $result = $manager->executeBulkWrite('huntersdb.usuario', $insRec, $writeConcern);

            echo json_encode(['success' => $result->getModifiedCount()]);

        }else{
            echo json_encode(['success' => 0, 'msg'=>'Não é permitido dados repetidos']);
        }


    }

    /*
     * recebe uma lista com uma experiencia profissional e empurra no array experiencia_profissional do documento MongoDB
     *
     * @param (dados) array chave valor dos dados a serem gravados no banco
     * @return (getModifiedCount) quantidade de linhas alteradas
     */
    public function pullFormacaoAcademica($argument)
    {
        $manager = new \MongoDB\Driver\Manager($this->getConString());
        $insRec = new MongoDB\Driver\BulkWrite;

        $insRec->update(['_id' => new MongoDB\BSON\ObjectID($_SESSION['_id'])], ['$pull' => ['formacao_academica' => $argument]], ['multi' => false, 'upsert' => false]);

        $writeConcern = new MongoDB\Driver\WriteConcern(MongoDB\Driver\WriteConcern::MAJORITY, 1000);

        $result = $manager->executeBulkWrite('huntersdb.usuario', $insRec, $writeConcern);

        echo json_encode(['success' => $result->getModifiedCount()]);

    }

    public function pullMongo($argument, $documento)
    {

        $manager = new \MongoDB\Driver\Manager($this->getConString());
        $insRec = new MongoDB\Driver\BulkWrite;

        $argument = json_decode($argument);

        $insRec->update(['_id' => new MongoDB\BSON\ObjectID($_SESSION['_id'])], ['$pull' => ["{$documento}" => $argument]], ['multi' => false, 'upsert' => false]);

        $writeConcern = new MongoDB\Driver\WriteConcern(MongoDB\Driver\WriteConcern::MAJORITY, 1000);

        $result = $manager->executeBulkWrite('huntersdb.usuario', $insRec, $writeConcern);

        echo json_encode(['success' => $result->getModifiedCount()]);

    }

    public function cadastra()
    {
        $manager = new \MongoDB\Driver\Manager($this->getConString());
        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $senha = $_POST['senha1'];
        $candidato = true;
        $image_link = "../dist/img/avatar_padrao.png";

        $today = new MongoDB\BSON\UTCDateTime(time()*1000);

        $insRec = new MongoDB\Driver\BulkWrite;

        $insRec->insert(['nome' => $nome, 'email' => $email, 'senha' => $senha, 'candidato' => $candidato, 'image_link'=> $image_link, 'data_cadastro'=>$today]);

        $writeConcern = new MongoDB\Driver\WriteConcern(MongoDB\Driver\WriteConcern::MAJORITY, 1000);

        $result = $manager->executeBulkWrite('huntersdb.usuario', $insRec, $writeConcern);

        echo $result->getInsertedCount();
    }

    public function verificarUserFacebook($id)
    {
        $manager = new \MongoDB\Driver\Manager($this->getConString());
        $result = array();

        if (isset($id)) {

            $filter = ['_idfacebook' => $id];

            $options = [];

            $query = new MongoDB\Driver\Query($filter, $options);

            $cursor = $manager->executeQuery('huntersdb.usuario', $query);

            foreach ($cursor as $row) {
                $result[] = $row;
            }

        }
        return $result;
    }

    public function verificarGoogle($id)
    {
        $manager = new \MongoDB\Driver\Manager($this->getConString());
        $result = array();

        if (isset($id)) {

            $filter = ['_idgoogle' => $id];

            $options = [];

            $query = new MongoDB\Driver\Query($filter, $options);

            $cursor = $manager->executeQuery('huntersdb.usuario', $query);

            foreach ($cursor as $row) {
                $result[] = $row;
            }

        }
        return $result;
    }

    public function verificarLinkedin($id)
    {
        $manager = new \MongoDB\Driver\Manager($this->getConString());
        $result = array();

        if (isset($id)) {

            $filter = ['_idlinkedin' => $id];

            $options = [];

            $query = new MongoDB\Driver\Query($filter, $options);

            $cursor = $manager->executeQuery('huntersdb.usuario', $query);

            foreach ($cursor as $row) {
                $result[] = $row;
            }

        }
        return $result;
    }

    public function loginLinkedin()
    {
        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $idlinkedin = $_POST['linkedin_id'];

        $candidato = true;
        $boolLinkedin = true;

        $dadosCadastrado = $this->verificarLinkedin($idlinkedin);

        if ((int)$this->verificarLinkedin($idlinkedin) >= 1) {

            $session["id"] = $dadosCadastrado[0]->_id;
            $session["email"] = $dadosCadastrado[0]->email;
            $session["nome"] = $dadosCadastrado[0]->nome;
            $this->setSessionData($session);

            $retorno = ["success" => 1, "msg" => "Logado com sucesso", "id" => $session["id"]];

            echo json_encode($retorno);
        } else {
            $dados['nome'] = $nome;
            $dados['email'] = $email;
            $dados['_idlinkedin'] = $idlinkedin;
            $dados['candidato'] = $candidato;
            $dados['boollinkedin'] = $boolLinkedin;
            $dados['image_link'] = $_POST['image_link'];
            $dados['data_cadastro'] = new MongoDB\BSON\UTCDateTime(time()*1000);

            $intGravado = $this->insert("usuario", $dados);

            if ($intGravado >= 1) {
                $dadosCadastrado = $this->verificarLinkedin($idlinkedin);

                $session["id"] = $dadosCadastrado[0]->_id;
                $session["email"] = $dadosCadastrado[0]->email;
                $session["nome"] = $dadosCadastrado[0]->nome;
                $this->setSessionData($session);

                $retorno = ["success" => 1, "msg" => "Logado com sucesso", "id" => $session["id"]];

                echo json_encode($retorno);
            } else echo json_encode(["success" => 0, "msg" => "Não foi possivel realizar login"]);
        }
    }

    public function cadastrarFacebook()
    {
        $manager = new \MongoDB\Driver\Manager($this->getConString());
        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $idfacebook = $_POST['facebook_id'];
        $image_link = $_POST['image_link'];
        $image_link = str_replace('%26', '&', $image_link);

        $candidato = true;
        $boolFacebook = true;

        $dadosCadastrado = $this->verificarUserFacebook($idfacebook);
        $today = new MongoDB\BSON\UTCDateTime(time()*1000);

        if ((int)$this->verificarUserFacebook($idfacebook) >= 1) {
            $session["id"] = $dadosCadastrado[0]->_id;
            $session["email"] = $dadosCadastrado[0]->email;
            $session["nome"] = $dadosCadastrado[0]->nome;
            $this->setSessionData($session);

            $retorno = ["success" => 1, "msg" => "Logado com sucesso", "id" => $session["id"]];

            echo json_encode($retorno);
        } else {
            $insRec = new MongoDB\Driver\BulkWrite;

            $insRec->insert(['_idfacebook' => $idfacebook, 'nome' => $nome, 'email' => $email, 'boolfacebook' => $boolFacebook,'image_link' => $image_link, 'candidato' => $candidato, 'data_cadastro'=>$today]);

            $writeConcern = new MongoDB\Driver\WriteConcern(MongoDB\Driver\WriteConcern::MAJORITY, 1000);

            $result = $manager->executeBulkWrite('huntersdb.usuario', $insRec, $writeConcern);

            $intGravado = $result->getInsertedCount();

            if ($intGravado >= 1) {
                $dadosCadastrado = $this->verificarUserFacebook($idfacebook);

                $session["id"] = $dadosCadastrado[0]->_id;
                $session["email"] = $dadosCadastrado[0]->email;
                $session["nome"] = $dadosCadastrado[0]->nome;
                $this->setSessionData($session);

                $retorno = ["success" => 1, "msg" => "Logado com sucesso", "id" => $session["id"]];

                echo json_encode($retorno);
            } else echo json_encode(["success" => 0, "msg" => "Não foi possivel realizar login"]);
        }

    }

    public function getFlags()
    {
        $resultado = $this->get("usuario", ['_id' => new MongoDB\BSON\ObjectID($_SESSION['_id']) ]);

        if(property_exists($resultado[0], "flags")){
            echo json_encode([
                "success" => 1,
                "msg" => $resultado[0]->flags
            ]);
        }else echo json_encode([
            "success" => 2,
            "msg" => "null"
        ]);
    }
    public function pushFlags($dados){
        $insert = $this->update("usuario", ['_id' => new MongoDB\BSON\ObjectID($_SESSION['_id'])] ,["flags"=>$dados]);
        if($insert) echo json_encode(["success"=>1, "msg"=>""]);
        else        echo json_encode(["success"=>0, "msg"=>""]);
    }

    public function cadastrarGoogle()
    {
        $manager = new \MongoDB\Driver\Manager($this->getConString());
        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $idgoogle = $_POST['google_id'];
        $image_link = $_POST['image_link'];

        $candidato = true;
        $boolgoogle = true;
        $today = new MongoDB\BSON\UTCDateTime(time()*1000);
        $dadosCadastrado = $this->verificarGoogle($idgoogle);


        if ((int)$dadosCadastrado >= 1) {
            $session["id"] = $dadosCadastrado[0]->_id;
            $session["email"] = $dadosCadastrado[0]->email;
            $session["nome"] = $dadosCadastrado[0]->nome;
            $this->setSessionData($session);

            $retorno = ["success" => 1, "msg" => "Logado com sucesso", "id" => $session["id"]];

            echo json_encode($retorno);
        } else {
            $insRec = new MongoDB\Driver\BulkWrite;

            $insRec->insert(['_idgoogle' => $idgoogle, 'nome' => $nome, 'email' => $email, 'boolgoogle' => $boolgoogle, 'image_link' => $image_link, 'candidato' => $candidato, 'data_cadastro'=>$today]);

            $writeConcern = new MongoDB\Driver\WriteConcern(MongoDB\Driver\WriteConcern::MAJORITY, 1000);

            $result = $manager->executeBulkWrite('huntersdb.usuario', $insRec, $writeConcern);

            $intGravado = $result->getInsertedCount();

            if ($intGravado >= 1) {
                $dadosCadastrado = $this->verificarGoogle($idgoogle);

                $session["id"] = $dadosCadastrado[0]->_id;
                $session["email"] = $dadosCadastrado[0]->email;
                $session["nome"] = $dadosCadastrado[0]->nome;
                $this->setSessionData($session);

                $retorno = ["success" => 1, "msg" => "Logado com sucesso", "id" => $session["id"]];

                echo json_encode($retorno);
            } else echo json_encode(["success" => 0, "msg" => "Não foi possivel realizar login"]);
        }

    }

    public function recoverPass($email){

        if($this->getMongo("usuario", ['email' => $email])){
            $novaSenha = Helpers::geraSenha();

            $mensagem = file_get_contents(DOCUMENT_ROOT."application/includes/emailRecover.html");
            $nMensagem = str_replace("%senha%", $novaSenha, $mensagem);

            $mail = new PHPMailer;
            $mail->SMTPDebug = 0;           // Enable verbose debug output
            global $error;
            $mail->IsSMTP();		        // Debugar: 1 = erros e mensagens, 2 = mensagens apenas
            $mail->SMTPAuth = true;		    // Autenticação ativada
            $mail->SMTPSecure = SMTPSECURE;	// SSL REQUERIDO pelo GMail
            $mail->Host = HOSTSMTP;         //'smtp.gmail.com';	// SMTP utilizado
            $mail->Port = PORTSMTP;  		// A porta 587 deverá estar aberta em seu servidor
            $mail->Username = USERSMTP;     //'bbndnascimento@gmail.com';
            $mail->Password = PASSSMTP;     //'{Brunob3n1c10}';

            $mail->setFrom(SETFROMEMAILSMTP, SETFROMNAMESMTP);
            $mail->addAddress($email);      // Add a recipient
            $mail->addReplyTo(REPLYTOSMTP);

            $mail->isHTML(true);                                  // Set email format to HTML

            $mail->Subject = "Recuperação de senha";
            $mail->Body    = $nMensagem;

            if(!$mail->send()) {
                echo json_encode(['success'=>0,'msg'=>"Não foi possivel enviar o email"]);
            } else if($this->update("usuario", ["email"=>$email], ["senha"=>$novaSenha])){
                echo json_encode(['success'=>1,'msg'=>'Verifique seu email para recuperar sua senha!']);
            }else{
                echo json_encode(['success'=>0,'msg'=>'Não foi possivel trocar a senha, tente novamente mais tarde']);
            }
        }else{
            echo json_encode(['success'=>0,'msg'=>"Este email não está cadastrado!"]);
        }
    }
}


if (isset($_POST['action']) && !empty($_POST['action'])) {
    $action = $_POST['action'];
    $uController = new UserController();
    try {
        switch ($action) {
            case 'login'        :
                $uController->login();
                break;
            case 'atualizarDadosPessoais'  :
                $uController->atualizarDadosPessoais($dados);
                break;
            case 'pushFormacaoAcademica'  :
                $uController->pushFormacaoAcademica($dados);
                break;
            case 'pushCertificacoes'  :
                $uController->pushCertificacoes($dados);
                break;
            case 'pushOutrasFormacoes'  :
                $uController->pushOutrasFormacoes($dados);
                break;
            case 'pushExperienciaProfissional'  :
                $uController->pushExperienciaProfissional($dados);
                break;
            case 'pushExtraCurriculares'  :
                $uController->pushExtraCurriculares($dados);
                break;
            case 'pushSubArray'  :
                $uController->pushSubArray($dados, $subArrayName);
                break;
            case 'pullFormacaoAcademica'  :
                $uController->pullFormacaoAcademica($argument);
                break;
            case 'pullMongo'  :
                $uController->pullMongo($argument, $documento);
                break;
            case 'getUsuarioData'  :
                echo json_encode($uController->getUsuarioData());
                break;
            case 'cadastra'     :
                $uController->cadastra();
                break;
            case 'cadastrarFacebook'     :
                $uController->cadastrarFacebook();
                break;
            case 'cadastrarGoogle'     :
                $uController->cadastrarGoogle();
                break;
            case 'loginLinkedin'     :
                $uController->loginLinkedin();
                break;
            case 'recoverPass'     :
                $uController->recoverPass($email);
                break;
            case 'getFlags'     :
                $uController->getFlags();
                break;
            case 'pushFlags'     :
                $uController->pushFlags($dados);
                break;
            case 'getDominioData'     :
                echo json_encode($uController->getDominioData());
                break;
        }
    } catch (MongoDB\Driver\Exception\ConnectionTimeoutException $e) {
        echo Helpers::jsonEncode(["success" => 0, "msg" => "Tempo limite de conexão atingido, tente novamente!"]);
    }
}