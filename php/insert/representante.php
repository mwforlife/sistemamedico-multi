<?php
require '../controller.php';
$c = new Controller();
session_start();

if (isset($_POST['RepresentanteRut']) && isset($_POST['RepresentanteNombre']) && isset($_POST['RepresentanteApellido1']) && isset($_POST['RepresentanteApellido2']) && isset($_SESSION['EMPRESA_ID'])) {
    $rut = $_POST['RepresentanteRut'];
    $nombre = $_POST['RepresentanteNombre'];
    $nombre = strtoupper($nombre);
    $apellido1 = $_POST['RepresentanteApellido1'];
    $apellido1 = strtoupper($apellido1);
    $apellido2 = $_POST['RepresentanteApellido2'];
    $apellido2 = strtoupper($apellido2);
    if(strlen($apellido2)==0){
        $apellido2 = "";
    }
    $empresa = $_SESSION['EMPRESA_ID'];
    $valid = $c->validarRepresentanteLegal($rut, $empresa);
    if ($valid == false) {
        $result = $c->RegistrarRepresentanteLegal($rut, $nombre, $apellido1, $apellido2, $empresa);
        if ($result == true) {
            echo 1;
            /***********Auditoria******************* */
            $titulo = "Registro de Representante Legal";
            $enterprise = $_SESSION['CURRENT_ENTERPRISE'];
            $idUsuario = $_SESSION['USER_ID'];
            $object = $c->buscarenUsuario1($idUsuario);
            $evento = "El Usuario " . $object->getNombre() . " " . $object->getApellido1() . " " . $object->getApellido2() . " ha registrado un nuevo Representante Legal con el nombre de " . $nombre . " " . $apellido1 . " " . $apellido2 . " y rut " . $rut . "";
            $c->registrarAuditoria($_SESSION['USER_ID'],$enterprise, 1, $titulo, $evento);
            /**************************************** */
        } else {
            echo 0;
        }
    } else {
        echo 2;
    }
}else if (isset($_POST['RepresentanteRut']) && isset($_POST['RepresentanteNombre']) && isset($_POST['RepresentanteApellido1']) && isset($_POST['RepresentanteApellido2']) && isset($_SESSION['EMPRESA_EDIT'])) {
    $rut = $_POST['RepresentanteRut'];
    $nombre = $_POST['RepresentanteNombre'];
    $nombre = strtoupper($nombre);
    $apellido1 = $_POST['RepresentanteApellido1'];
    $apellido1 = strtoupper($apellido1);
    $apellido2 = $_POST['RepresentanteApellido2'];
    $apellido2 = strtoupper($apellido2);
    if(strlen($apellido2)==0){
        $apellido2 = "No posee";
    }
    $empresa = $_SESSION['EMPRESA_EDIT'];
    $valid = $c->validarRepresentanteLegal($rut, $empresa);
    if ($valid == false) {
        $result = $c->RegistrarRepresentanteLegal($rut, $nombre, $apellido1, $apellido2, $empresa);
        if ($result == true) {
            echo 1;
            /***********Auditoria******************* */
            $titulo = "Registro de Representante Legal";
            $enterprise = $_SESSION['CURRENT_ENTERPRISE'];
            $idUsuario = $_SESSION['USER_ID'];
            $object = $c->buscarenUsuario1($idUsuario);
            $evento = "El Usuario " . $object->getNombre() . " " . $object->getApellido1() . " " . $object->getApellido2() . " ha registrado un nuevo Representante Legal con el nombre de " . $nombre . " " . $apellido1 . " " . $apellido2 . " y rut " . $rut . "";
            $c->registrarAuditoria($_SESSION['USER_ID'],$enterprise, 1, $titulo, $evento);
            /**************************************** */
        } else {
            echo 0;
        }
    } else {
        echo 2;
    }
} else {
    echo 0;
}
