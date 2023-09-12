<?php
require '../controller.php';
$c = new Controller();

if(isset($_POST['id'])){
	$id = $_POST['id'];
	$provincia = $c->buscarenprovincia($id);
	$c->eliminarprovincia($id);
	echo 1;
    /***********Auditoria******************* */
    session_start();
    $titulo = "Eliminacion de Provincia";
    $enterprise = $_SESSION['CURRENT_ENTERPRISE'];
    $idUsuario = $_SESSION['USER_ID'];
    $object = $c->buscarenUsuario1($idUsuario);
    $evento = "El Usuario " . $object->getNombre() . " " . $object->getApellido1() . " " . $object->getApellido2() . " ha eliminado la provincia de " . $provincia->getNombre() . " con el ID: " . $provincia->getId() . "";
    $c->registrarAuditoria($_SESSION['USER_ID'], $enterprise, 1, $titulo, $evento);
    /**************************************** */
}