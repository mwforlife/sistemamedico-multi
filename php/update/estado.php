<?php
require '../controller.php';
$c = new Controller();

session_start();
$empresa = 0;
if(isset($_SESSION['CURRENT_ENTERPRISE'])){
	$empresa = $_SESSION['CURRENT_ENTERPRISE'];
}else{
    echo 0;
    return;
}
if(isset($_POST['id']) && isset($_POST['estado'])){
    $id = $_POST['id'];
    $estado = $_POST['estado'];
    if($estado == 1){
        $estado = 2;
    }else{
        $estado = 1;
    }
    $result = $c->cambiarestado($id,$empresa,$estado);
    if($result==true){
        echo "1";
    }else{
        echo "0";
    }
}else{
    echo "No se recibieron los datos necesarios";
}