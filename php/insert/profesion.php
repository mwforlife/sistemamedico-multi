<?php
require '../controller.php';
$c = new Controller();
session_start();

if(isset($_POST['Codigo']) && isset($_POST['Nombre']) && isset($_POST['especialidad'])){
    $codigo = $_POST['Codigo'];
    $nombre = $_POST['Nombre'];
    $tipo = $_POST['especialidad'];
    if(strlen($codigo) > 0 && strlen($nombre) > 0){
        $codigo = $c->escapeString($codigo);
        $nombre = $c->escapeString($nombre);
        $tipo = $c->escapeString($tipo);
        $tipo = strtoupper($tipo);
        $codigo = strtoupper($codigo);
        $nombre = strtoupper($nombre);
        $result = $c->registrarprofesion($codigo, $nombre, $tipo);
        if($result==true){
            echo "1";
            
        /***********Auditoria******************* */
        $titulo = "Registro de Profesion";
        $enterprise = $_SESSION['CURRENT_ENTERPRISE'];
        $idUsuario = $_SESSION['USER_ID'];
        $object = $c->buscarenUsuario1($idUsuario);
        $evento = "El Usuario " . $object->getNombre() . " " . $object->getApellido1() . " " . $object->getApellido2() . " ha registrado una nueva profesion con el nombre de " . $nombre . " y codigo " . $codigo . "";
        $c->registrarAuditoria($_SESSION['USER_ID'],$enterprise, 1, $titulo, $evento);
        /**************************************** */
        }else{
            echo "0";
        }
    }else{
        echo "Hay campos vacios";
    }
}else{
    echo "No se han enviado los parametros";
}
