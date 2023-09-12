<?php
require '../controller.php';
$c = new Controller();
session_start();

if(isset($_POST['Codigo']) && isset($_POST['Nombre']) && isset($_POST['empresa'])  && isset($_POST['diagnostico']) && isset($_POST['libro'])){
    $codigo = $_POST['Codigo'];
    $nombre = $_POST['Nombre'];
    $empresa = $_POST['empresa'];
    $diagnostico = $_POST['diagnostico'];
    $libro = $_POST['libro'];
    //Validar que no esten vacios
    if(strlen($codigo) > 0 && strlen($nombre) > 0 && strlen($empresa) > 0 && strlen($diagnostico) > 0 && strlen($libro) > 0){
        $codigo = $c->escapeString($codigo);
        $nombre = $c->escapeString($nombre);
        $empresa = $c->escapeString($empresa);
        //Pasar a mayusculas
        $nombre = strtoupper($nombre);
        $codigo = strtoupper($codigo);
        $empresa = strtoupper($empresa);
        $result = $c->registraresquema($codigo, $nombre, $diagnostico, $libro, $empresa);
        if($result==true){
            echo "1";
            /***********Auditoria******************* */
            $titulo = "Registro de Esquema";
            $enterprise = $_SESSION['CURRENT_ENTERPRISE'];
            $idUsuario = $_SESSION['USER_ID'];
            $object = $c->buscarenUsuario1($idUsuario);
            $evento = "El Usuario " . $object->getNombre() . " " . $object->getApellido1() . " " . $object->getApellido2() . " ha registrado una nueva esquema con el nombre de " . $nombre . " y codigo " . $codigo . "";
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
