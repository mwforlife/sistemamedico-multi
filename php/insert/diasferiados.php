<?php
require '../controller.php';
$c = new Controller();
session_start();
if (!isset($_SESSION['USER_ID'])) {
	echo "No hay ninguna sesion iniciada";
    return;
} else {
	$valid  = $c->validarsesion($_SESSION['USER_ID'], $_SESSION['USER_TOKEN']);
	if ($valid == false) {
		echo "No hay ninguna sesion iniciada";
        return;
	}
}
$empresa = null;
if(isset($_SESSION['CURRENT_ENTERPRISE'])){
	$enterprise = $_SESSION['CURRENT_ENTERPRISE'];
	$empresa = $c->buscarEmpresa($enterprise);
	$idempresa = $empresa->getId();
}else{
    echo "No hay ninguna empresa seleccionada";
    return;
}

if (isset($_POST['periodo']) && isset($_POST['fecha']) && isset($_POST['descripcion'])) {
    $periodo = $_POST['periodo'];
    $fecha = $_POST['fecha'];
    $descripcion = $_POST['descripcion'];
    $result = $c->query("insert into diasferiado values (null, $periodo, '$fecha', '$descripcion')");
    if ($result == true) {
        echo 1;
        $usuario = $_SESSION['USER_ID'];
        $eventos = "Se Agrego el dia " . $fecha . " como feriado";
        $c->registrarAuditoria($usuario, 1, "Registro de Feriado", $eventos);
    } else {
        echo 0;
    }
}
