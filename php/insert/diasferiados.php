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
        
        
        /***********Auditoria******************* */
        $titulo = "Registro de Dias Feriados";
        $enterprise = $_SESSION['CURRENT_ENTERPRISE'];
        $idUsuario = $_SESSION['USER_ID'];
        $object = $c->buscarenUsuario1($idUsuario);
        $evento = "El Usuario " . $object->getNombre() . " " . $object->getApellido1() . " " . $object->getApellido2() . " ha registrado la fecha ". date("d-m-Y", strtotime($fecha)) . " como feriado";
        $c->registrarAuditoria($_SESSION['USER_ID'],$enterprise, 1, $titulo, $evento);
        /**************************************** */
    } else {
        echo 0;
    }
}
