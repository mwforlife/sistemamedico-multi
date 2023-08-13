<?php
require '../controller.php';
$c = new Controller();

if(isset($_POST['id'])){
    $id = $_POST['id'];
    if($id<=0){
        echo "Indentificador de comite invalido";
        return;
    }
    $response = $c->finalizarComite($id);
    if($response==true){
        echo 1;
    }else{
        echo "Error al finalizar comite";
    }
    return;
}else{
    echo "Indentificador de comite invalido";
    return;
}