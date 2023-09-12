<?php
require '../controller.php';
$c = new Controller();

if(isset($_POST['id'])){
	$id = $_POST['id'];
	$comuna = $c->buscarencomuna($id);
    /***********Auditoria******************* */
    session_start();
    $titulo = "Eliminacion de Comuna";
    $enterprise = $_SESSION['CURRENT_ENTERPRISE'];
    $idUsuario = $_SESSION['USER_ID'];
    $object = $c->buscarenUsuario1($idUsuario);
    $evento = "El Usuario " . $object->getNombre() . " " . $object->getApellido1() . " " . $object->getApellido2() . " ha eliminado la comuna de " . $comuna->getNombre() . "";
    /**************************************** */
	$c->eliminarcomuna($id);
	$c->eliminarciudad($id);
	echo 1;
}