<?php
ob_start();
session_start();

$manager     =  new \MongoDB\Driver\Manager("mongodb://hunters_usr:hunters%402017@104.154.101.161:27017/huntersdb?authSource=huntersdb&connectTimeoutMS=1000");

/* success, error messages to be displayed */

$messages = array(
		1=>'Record deleted successfully',
		2=>'Error occurred. Please try again',
		3=>'Record saved successfully',
		4=>'Record updated successfully',
		5=>'All fields are required' );


$nome  = $_POST['nome'];
$email = $_POST['email'];
$rg = $_POST['rg'];
$digito = $_POST['digito'];
$dataexp = $_POST['dataexp'];
$cpf = $_POST['cpf'];
$nacionalidade = $_POST['nacionalidade'];
$nomepai = $_POST['nomepai'];
$nomemae = $_POST['nomemae'];
$datanasc = $_POST['datanasc'];
$estadocivil = $_POST['estadocivil'];
$telefone = $_POST['tel'];

$_SESSION['nome'] = $nome;
$_SESSION['email'] = $email;

$insRec       = new MongoDB\Driver\BulkWrite;


$insRec->update(['_id'=>new MongoDB\BSON\ObjectID($_SESSION['_id'])],['$set' =>['nome' =>$nome, 'email' =>$email, 'cpf' =>$cpf, 'telefone'=>$telefone, 'candidato'=>['rg'=>$rg,'nome_pai'=>$nomepai,'nome_mae'=>$nomemae,'digito'=>$digito] ]], ['multi' => false, 'upsert' => false]);


$writeConcern = new MongoDB\Driver\WriteConcern(MongoDB\Driver\WriteConcern::MAJORITY, 1000);

 
$result       = $manager->executeBulkWrite('huntersdb.usuario', $insRec, $writeConcern);




echo $result->getModifiedCount();


// $filter = [];

// $options = [
// 		'sort' => ['_id' => -1],
// ];

// $query = new MongoDB\Driver\Query($filter, $options);

// $cursor = $manager->executeQuery('huntersdb.usuario', $query);
// foreach ($cursor as $document) {
// 	echo $document->_id;
// }






?>