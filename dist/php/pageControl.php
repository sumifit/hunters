<?php
ob_start();
session_start();
$_SESSION ['page']        = $_POST['pagina'];

echo $_SESSION ['page'] ;