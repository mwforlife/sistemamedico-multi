<?php
require '../controller.php';
$c = new Controller();
session_start();

if(isset($_POST['id'])){
    $id = $_POST['id'];
    $result = $c->EliminarCodigoActividadEmpresa($id);
    if($result){
        echo "1";
    }else{
        echo "0";
    }
}