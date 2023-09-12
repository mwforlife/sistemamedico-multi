<?php
require '../controller.php';
$c = new Controller();

if(isset($_POST['id'])){
	$id = $_POST['id'];
	$invasion = $c->buscareninvaciontumoral($id);
	$c->eliminarinvaciontumoral($id);
	echo 1;
    /***********Auditoria******************* */
    session_start();
    $titulo = "Eliminacion de Invasion Tumoral";
    $enterprise = $_SESSION['CURRENT_ENTERPRISE'];
    $idUsuario = $_SESSION['USER_ID'];
    $object = $c->buscarenUsuario1($idUsuario);
    $evento = "El Usuario " . $object->getNombre() . " " . $object->getApellido1() . " " . $object->getApellido2() . " ha eliminado la invasion tumoral de " . $invasion->getNombre() . "";
    $c->registrarAuditoria($_SESSION['USER_ID'], $enterprise, 1, $titulo, $evento);
    /**************************************** */
}