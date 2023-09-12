<?php
require '../controller.php';
$c = new Controller();

if(isset($_POST['id'])){
	$id = $_POST['id'];
	$esquema =$c->buscarenesquema($id);
	$c->eliminarmedicamentoesquemaesquema($id);
	$c->eliminaresquema($id);
	echo 1;
	
    /***********Auditoria******************* */
    session_start();
    $titulo = "Eliminacion de Esquema";
    $enterprise = $_SESSION['CURRENT_ENTERPRISE'];
    $idUsuario = $_SESSION['USER_ID'];
    $object = $c->buscarenUsuario1($idUsuario);
    $evento = "El Usuario " . $object->getNombre() . " " . $object->getApellido1() . " " . $object->getApellido2() . " ha eliminado el esquema de " . $esquema->getNombre() . "";
    $c->registrarAuditoria($_SESSION['USER_ID'], $enterprise, 1, $titulo, $evento);
    /**************************************** */
}