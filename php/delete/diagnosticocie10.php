<?php
require '../controller.php';
$c = new Controller();

if(isset($_POST['id'])){
	$id = $_POST['id'];
	$c->eliminarDiagnosticocie10($id);
	echo 1;
}