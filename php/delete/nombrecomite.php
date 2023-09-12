<?php
require '../controller.php';
$c = new Controller();

if(isset($_POST['id'])){
	$id = $_POST['id'];
	$nombrecomite = $c->buscarnombrecomiteID($id);
	$c->eliminarnombrecomite($id);
	echo 1;
    /***********Auditoria******************* */
    session_start();
    $titulo = "Eliminacion de Nombre Comité";
    $enterprise = $_SESSION['CURRENT_ENTERPRISE'];
    $idUsuario = $_SESSION['USER_ID'];
    $object = $c->buscarenUsuario1($idUsuario);
    $evento = "El Usuario " . $object->getNombre() . " " . $object->getApellido1() . " " . $object->getApellido2() . " ha eliminado el nombre del comité: " . $nombrecomite->getNombre() . " con el ID " . $nombrecomite->getId() . "";
    $c->registrarAuditoria($_SESSION['USER_ID'], $enterprise, 1, $titulo, $evento);
    /**************************************** */
}