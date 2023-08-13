<?php
require '../controller.php';
$c = new Controller();

if(isset($_POST['id']) && isset($_POST['estado'])){
    $id = $_POST['id'];
    $estado = $_POST['estado'];
    if($estado == 1){
        $estado = 2;
    }else{
        $estado = 1;
    }
    $result = $c->cambiarestado($id,$estado);
    if($result==true){
        echo "1";
    }else{
        echo "0";
    }
}else{
    echo "No se recibieron los datos necesarios";
}