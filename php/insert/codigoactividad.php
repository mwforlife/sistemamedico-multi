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
        }else{
            echo 0;
        }
    }
}else{
    echo 0;
}