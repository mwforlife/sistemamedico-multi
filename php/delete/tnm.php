<?php
require '../controller.php';
$c = new Controller();

if(isset($_POST['id'])){
	$id = $_POST['id'];
	$result = $c->eliminartnm($id);
	if($result==true) {
		echo json_encode(array("status"=>true, "message"=>"Registro eliminado correctamente"));
	} else {
		echo json_encode(array("status"=>false, "message"=>"Error al eliminar el registro"));
	}
}else{
	echo json_encode(array("status"=>false, "message"=>"Error en los datos enviados"));
}