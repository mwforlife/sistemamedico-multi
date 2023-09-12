<?php
require '../controller.php';
$c = new Controller();
session_start();

if(isset($_POST['id']) && isset($_SESSION['EMPRESA_ID'])){
    $codigo = $_POST['id'];
    $id = $_SESSION['EMPRESA_ID'];
    $valid = $c->ValidarCodigoActividadEmpresa($id, $codigo);
    if($valid == true){
        echo 2;
    }else{
        $result = $c->RegistrarCodigoActividadEmpresa($id, $codigo);
        if($result == true){
            echo 1;
            /***********Auditoria******************* */
            $titulo = "Registro de Codigo de Actividad";
            $enterprise = $_SESSION['CURRENT_ENTERPRISE'];
            $idUsuario = $_SESSION['USER_ID'];
            $object = $c->buscarenUsuario1($idUsuario);
            $evento = "El Usuario " . $object->getNombre() . " " . $object->getApellido1() . " " . $object->getApellido2() . " ha asignado un nuevo codigo de actividad a la empresa";
            $c->registrarAuditoria($_SESSION['USER_ID'],$enterprise, 1, $titulo, $evento);
            /**************************************** */
        }else{
            echo 0;
        }
    }
}else if(isset($_POST['id']) && isset($_SESSION['EMPRESA_EDIT'])){
    $codigo = $_POST['id'];
    $id = $_SESSION['EMPRESA_EDIT'];
    $valid = $c->ValidarCodigoActividadEmpresa($id, $codigo);
    if($valid == true){
        echo 2;
    }else{
        $result = $c->RegistrarCodigoActividadEmpresa($id, $codigo);
        if($result == true){
            echo 1;
            /***********Auditoria******************* */
            $titulo = "Registro de Codigo de Actividad";
            $enterprise = $_SESSION['CURRENT_ENTERPRISE'];
            $idUsuario = $_SESSION['USER_ID'];
            $object = $c->buscarenUsuario1($idUsuario);
            $evento = "El Usuario " . $object->getNombre() . " " . $object->getApellido1() . " " . $object->getApellido2() . " ha asignado un nuevo codigo de actividad a la empresa";
            $c->registrarAuditoria($_SESSION['USER_ID'],$enterprise, 1, $titulo, $evento);
        }else{
            echo 0;
        }
    }
}else{
    echo 0;
}