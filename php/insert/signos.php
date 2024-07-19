<?php
require "../controller.php";
$c = new Controller();
session_start();
if (isset($_POST['idpac']) && isset($_POST['sfresp']) && isset($_POST['spsist']) && isset($_POST['spdias']) && isset($_POST['ssat']) && isset($_POST['sfc']) && isset($_POST['staux']) && isset($_POST['strect']) && isset($_POST['stotra']) && isset($_POST['shgt']) && isset($_POST['speso'])) {
    $idpac = $_POST['idpac'];

    if (strlen($idpac) == 0) {
        echo json_encode(array("status" => false, "message" => "Ups! Ha ocurrido un error, No se ha recibido el id del paciente"));
        return;
    }

    if ($idpac < 0) {
        echo json_encode(array("status" => false, "message" => "Ups! Ha ocurrido un error, El id del paciente no puede ser negativo"));
        return;
    }


    $paciente = $c->buscarpaciente($idpac);
    $sfresp = $_POST['sfresp'];
    $spsist = $_POST['spsist'];
    $spdias = $_POST['spdias'];
    $ssat = $_POST['ssat'];
    $sfc = $_POST['sfc'];
    $staux = $_POST['staux'];
    $strect = $_POST['strect'];
    $stotra = $_POST['stotra'];
    $shgt = $_POST['shgt'];
    $speso = $_POST['speso'];

    if (strlen($sfresp) == 0 && strlen($spsist) == 0 && strlen($spdias) == 0 && strlen($ssat) == 0 && strlen($sfc) == 0 && strlen($staux) == 0 && strlen($strect) == 0 && strlen($stotra) == 0 && strlen($shgt) == 0 && strlen($speso) == 0) {
        //Si todos estan vacios
        echo json_encode(array("status" => false, "message" => "Ups! Ha ocurrido un error, Debe ingresar al menos un valor de signo vital"));
        return;
    }

    if (strlen($sfresp) == 0) {
        $sfresp = 'null';
    }
    if (strlen($spsist) == 0) {
        $spsist = 'null';
    }
    if (strlen($spdias) == 0) {
        $spdias = 'null';
    }
    if (strlen($ssat) == 0) {
        $ssat = 'null';
    }
    if (strlen($sfc) == 0) {
        $sfc = 'null';
    }
    if (strlen($staux) == 0) {
        $staux = 'null';
    }
    if (strlen($strect) == 0) {
        $strect = 'null';
    }
    if (strlen($stotra) == 0) {
        $stotra = 'null';
    }
    if (strlen($shgt) == 0) {
        $shgt = 'null';
    }
    $speso = 'null';


    //Validar que se haya ingresado al menos un valor
    if ($sfresp == 'null' && $spsist == 'null' && $spdias == 'null' && $ssat == 'null' && $sfc == 'null' && $staux == 'null' && $strect == 'null' && $stotra == 'null' && $shgt == 'null') {
        echo json_encode(array("status" => false, "message" => "Ups! Ha ocurrido un error, Debe ingresar al menos un valor de signo vital"));
        return;
    }



    $result = $c->registrarsignos($idpac, $sfresp, $spsist, $spdias, $ssat, $sfc, $staux, $strect, $stotra, $shgt, $speso);
    if ($result = true) {
        echo json_encode(array("status" => true, "message" => "Signos vitales registrados correctamente"));
        /***********Auditoria******************* */
        $titulo = "Registro de Signos Vitales";
        $enterprise = $_SESSION['CURRENT_ENTERPRISE'];
        $idUsuario = $_SESSION['USER_ID'];
        $object = $c->buscarenUsuario1($idUsuario);
        $evento = "El Usuario " . $object->getNombre() . " " . $object->getApellido1() . " " . $object->getApellido2() . " ha registrado los signos vitales del paciente " . $paciente->getNombre() . " " . $paciente->getApellido1() . " " . $paciente->getApellido2() . "";
        $c->registrarAuditoria($_SESSION['USER_ID'], $enterprise, 1, $titulo, $evento);
        /**************************************** */
    } else {
        echo json_encode(array("status" => false, "message" => "Ups! Ha ocurrido un error, No se han podido registrar los signos vitales"));
    }
} else {
    echo json_encode(array("status" => false, "message" => "Ups! Ha ocurrido un error, No se han recibido los datos necesarios"));
}
?>