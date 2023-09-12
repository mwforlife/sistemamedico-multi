<?php
require '../controller.php';
$c = new Controller();
session_start();
if(isset($_POST['idpac']) && isset($_POST['peso']) && isset($_POST['estatura']) && isset($_POST['pce']) && isset($_POST['pe']) && isset($_POST['pt']) && isset($_POST['te']) && isset($_POST['imc']) && isset($_POST['clasifimc']) && isset($_POST['pc']) && isset($_POST['cpc'])){
    $idpac = $_POST['idpac'];
    $paciente = $c->buscarpaciente($idpac);
    $peso = $_POST['peso'];
    $estatura = $_POST['estatura'];
    $pce = $_POST['pce'];
    $pe = $_POST['pe'];
    $pt = $_POST['pt'];
    $te = $_POST['te'];
    $imc = $_POST['imc'];
    $clasifimc = $_POST['clasifimc'];
    $pc = $_POST['pc'];
    $cpc = $_POST['cpc'];
    $result = $c->registrarmedidas($idpac, $peso, $estatura, $pce, $pe, $pt, $te, $imc, $clasifimc, $pc, $cpc);
    if($result=true){
        echo 1;
        
        /***********Auditoria******************* */
        $titulo = "Registro de Medidas Antropométricas";
        $enterprise = $_SESSION['CURRENT_ENTERPRISE'];
        $idUsuario = $_SESSION['USER_ID'];
        $object = $c->buscarenUsuario1($idUsuario);
        $evento = "El Usuario " . $object->getNombre() . " " . $object->getApellido1() . " " . $object->getApellido2() . " ha registrado nuevas medidas antropométricas para el paciente " . $paciente->getNombre() . " " . $paciente->getApellido1() . " " . $paciente->getApellido2() . "";
        $c->registrarAuditoria($_SESSION['USER_ID'],$enterprise, 1, $titulo, $evento);
        /**************************************** */
    }else{
        echo 0;
    }
}else{
    echo "No se recibieron los datos esperados";
}