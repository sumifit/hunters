<?php


$manager     =  new \MongoDB\Driver\Manager("mongodb://hunters_usr:hunters%402017@104.154.101.161:27017/huntersdb?authSource=huntersdb&connectTimeoutMS=1000");

/* success, error messages to be displayed */
ob_start();
session_start();
$messages = array(
		1=>'Record deleted successfully',
		2=>'Error occurred. Please try again',
		3=>'Record saved successfully',
		4=>'Record updated successfully',
		5=>'All fields are required' );

$email    = $_POST['email'];
$senha = $_POST['senha'];
$result = array();

if($email){

	$filter = ['email' => $email];

	$options = [];

	$query = new MongoDB\Driver\Query($filter,$options);

	$cursor = $manager->executeQuery('huntersdb.usuario', $query);

	foreach($cursor as $row){
		if($row->senha == $senha ){
			$result ['id'] = $row->_id;
			$_SESSION['valid'] = true;
			$_SESSION['timeout'] = time();
			$_SESSION['_id'] = $row->_id;
			$_SESSION ['email']        = $row->email;
			$_SESSION ['nome']        = $row->nome;
			$_SESSION ['page']        = 0;

			echo json_encode($result);
			break;
		}else{
			$result ["erro"]= "usuario e senha não conferem";
			echo json_encode($result);
		}
		

	}


}


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