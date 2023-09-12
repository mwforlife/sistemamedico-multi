<?php
require '../controller.php';
$c = new Controller();

if(isset($_POST['id'])){
	$id = $_POST['id'];
	$ecog = $c->buscarenecog($id);
	
    /***********Auditoria******************* */
    session_start();
    $titulo = "Eliminacion de ECOG";
    $enterprise = $_SESSION['CURRENT_ENTERPRISE'];
    $idUsuario = $_SESSION['USER_ID'];
    $object = $c->buscarenUsuario1($idUsuario);
    $evento = "El Usuario " . $object->getNombre() . " " . $object->getApellido1() . " " . $object->getApellido2() . " ha eliminado el ECOG de " . $ecog->getNombre() . "con el codigo " . $ecog->getCodigo() . "";
    $c->registrarAuditoria($_SESSION['USER_ID'], $enterprise, 1, $titulo, $evento);
    /**************************************** */
	$c->eliminarecog($id);
	echo 1;
}