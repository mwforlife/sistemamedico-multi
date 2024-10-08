<?php
require '../controller.php';
$c = new Controller();
if (isset($_POST['id'])) {
	$id = $_POST['id'];
	$tnm = $c->listartnmborrador($id);
    echo json_encode(array("status" => true, "tnm" => $tnm));
}else{
    echo json_encode(array("status" => false, "message" => "No se recibieron los datos correctamente"));
}