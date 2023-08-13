<?php
require '../controller.php';
$c = new Controller();

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
    }
}