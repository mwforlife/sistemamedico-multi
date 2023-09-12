<?php
require '../controller.php';
$c = new Controller();
session_start();

if(isset($_POST['Codigo']) && isset($_POST['Nombre']) && isset($_POST['Region']) && isset($_POST['Provincia'])){
    $codigo = $_POST['Codigo'];
    $nombre = $_POST['Nombre'];
    $region = $_POST['Region'];
    $provincia = $_POST['Provincia'];
    if(strlen($codigo) > 0 && strlen($nombre) > 0){
        $codigo = $c->escapeString($codigo);
        $nombre = $c->escapeString($nombre);
        $region = $c->escapeString($region);
        $provincia = $c->escapeString($provincia);
        //Pasar a mayusculas
        $nombre = strtoupper($nombre);
        $codigo = strtoupper($codigo);
        $region = strtoupper($region);
        $provincia = strtoupper($provincia);

        $result = $c->registrarcomuna($codigo, $nombre, $region, $provincia);
        if($result==true){
            echo "1";
            $c->registraciudad($codigo,$nombre, $region, $provincia);

            
        /***********Auditoria******************* */
        $titulo = "Registro de Comuna";
        $enterprise = $_SESSION['CURRENT_ENTERPRISE'];
        $idUsuario = $_SESSION['USER_ID'];
        $object = $c->buscarenUsuario1($idUsuario);
        $evento = "El Usuario " . $object->getNombre() . " " . $object->getApellido1() . " " . $object->getApellido2() . " ha registrado una nueva comuna con el nombre de " . $nombre . " y codigo " . $codigo . " en la region " . $region . " y provincia " . $provincia . "";
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
