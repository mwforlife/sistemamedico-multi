<?php
require "../controller.php";
$c = new Controller();
session_start();
if(isset($_POST['idpac']) && isset($_POST['sfresp']) && isset($_POST['spsist']) && isset($_POST['spdias']) && isset($_POST['ssat']) && isset($_POST['sfc']) && isset($_POST['staux']) && isset($_POST['strect']) && isset($_POST['stotra']) && isset($_POST['shgt']) && isset($_POST['speso'])){
    $idpac = $_POST['idpac'];
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
    $result = $c->registrarsignos($idpac, $sfresp, $spsist, $spdias, $ssat, $sfc, $staux, $strect, $stotra, $shgt, $speso);
    if($result=true){
        echo 1;
        /***********Auditoria******************* */
        $titulo = "Registro de Signos Vitales";
        $enterprise = $_SESSION['CURRENT_ENTERPRISE'];
        $idUsuario = $_SESSION['USER_ID'];
        $object = $c->buscarenUsuario1($idUsuario);
        $evento = "El Usuario " . $object->getNombre() . " " . $object->getApellido1() . " " . $object->getApellido2() . " ha registrado los signos vitales del paciente " . $paciente->getNombre() . " " . $paciente->getApellido1() . " " . $paciente->getApellido2() . "";
        $c->registrarAuditoria($_SESSION['USER_ID'],$enterprise, 1, $titulo, $evento);
        /**************************************** */
    }else{
        echo 0;
    }
}else{
    echo "No se recibieron los datos esperados";
}
?>