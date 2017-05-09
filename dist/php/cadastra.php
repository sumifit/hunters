<?php


$manager     =  new \MongoDB\Driver\Manager("mongodb://hunters_usr:hunters%402017@104.154.101.161:27017/huntersdb?authSource=huntersdb&connectTimeoutMS=1000");

/* success, error messages to be displayed */

$messages = array(
		1=>'Record deleted successfully',
		2=>'Error occurred. Please try again',
		3=>'Record saved successfully',
		4=>'Record updated successfully',
		5=>'All fields are required' );


$nome  = $_POST['nome'];
$email                 = $_POST['email'];
$senha          = $_POST['senha1'];
$candidato = true;

$insRec       = new MongoDB\Driver\BulkWrite;

$insRec->insert(['nome' =>$nome, 'email'=>$email, 'senha'=>$senha, 'candidato'=>$candidato]);

$writeConcern = new MongoDB\Driver\WriteConcern(MongoDB\Driver\WriteConcern::MAJORITY, 1000);

$result       = $manager->executeBulkWrite('huntersdb.usuario', $insRec, $writeConcern);

echo $result->getInsertedCount();


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