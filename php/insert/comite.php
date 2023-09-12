<?php
require '../controller.php';
$c = new Controller();
session_start();

if(isset($_POST['fecha']) && isset($_POST['idnombre']) && isset($_POST['folio'])){
    $fecha = $_POST['fecha'];
    $idnombre = $_POST['idnombre'];
    $folio = $_POST['folio'];
    //Pasar folio a mayusculas
    $folio = strtoupper($folio);

    if(strlen($fecha)==0 || strlen($idnombre)==0 || strlen($folio)==0){
        echo "Faltan datos";
        return;
    }

    if($idnombre<=0){
        echo "Seleccione un nombre";
        return;
    }

    $nombrecomite = $c->buscarnombrecomiteID($idnombre);
    if($nombrecomite==null){
        echo "Nombre No Valido";
        return;
    }


    $idpac = $c->registrarcomite($folio, $fecha, $idnombre);
    if($idpac<=0){
        echo "Error al registrar paciente" . $idpac;
        return;
    }else{
        echo "1".$idpac;

        /***********Auditoria******************* */
        $titulo = "Registro de Comité";
        $enterprise = $_SESSION['CURRENT_ENTERPRISE'];
        $idUsuario = $_SESSION['USER_ID'];
        $object = $c->buscarenUsuario1($idUsuario);
        $evento = "El Usuario " . $object->getNombre() . " " . $object->getApellido1() . " " . $object->getApellido2() . " ha registrado un nuevo comité";
        $c->registrarAuditoria($_SESSION['USER_ID'],$enterprise, 1, $titulo, $evento);
        /**************************************** */
    }
}