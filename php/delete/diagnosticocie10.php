<?php
require '../controller.php';
$c = new Controller();

if(isset($_POST['id'])){
	$id = $_POST['id'];
	$diagnostico = $c->buscarDiagnosticocie10($id);
    /***********Auditoria******************* */
    session_start();
    $titulo = "Eliminacion de Diagnostico CIE10";
    $enterprise = $_SESSION['CURRENT_ENTERPRISE'];
    $idUsuario = $_SESSION['USER_ID'];
    $object = $c->buscarenUsuario1($idUsuario);
    $evento = "El Usuario " . $object->getNombre() . " " . $object->getApellido1() . " " . $object->getApellido2() . " ha eliminado el diagnostico CIE10 de " . $diagnostico->getCodigo() . " " . $diagnostico->getDescripcion() . "";
    $c->registrarAuditoria($_SESSION['USER_ID'], $enterprise, 3, $titulo, $evento);
    /**************************************** */
	$c->eliminarDiagnosticocie10($id);
	echo 1;
}