<?php
require '../controller.php';
$c = new Controller();

if(isset($_POST['id'])){
	$id = $_POST['id'];
	$diagnostico = $c->buscarDiagnosticocieo($id);
    /***********Auditoria******************* */
    session_start();
    $titulo = "Eliminacion de Diagnosticos CIEO";
    $enterprise = $_SESSION['CURRENT_ENTERPRISE'];
    $idUsuario = $_SESSION['USER_ID'];
    $object = $c->buscarenUsuario1($idUsuario);
    $evento = "El Usuario " . $object->getNombre() . " " . $object->getApellido1() . " " . $object->getApellido2() . " ha eliminado el diagnostico CIEO de " . $diagnostico->getCodigo() . " " . $diagnostico->getDescripcionCompleto() . "";
    $c->registrarAuditoria($_SESSION['USER_ID'], $enterprise, 1, $titulo, $evento);
    /**************************************** */

	$c->eliminarDiagnosticocieo($id);
	echo 1;
}