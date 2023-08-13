<?php
require '../controller.php';
$c = new Controller();

if(isset($_POST['id'])){
    $id = $_POST['id'];
    $lista = $c->listarprovincia($id);
    if(count($lista) > 0){
        foreach($lista as $l){
            echo "<option value='".$l->getId()."'>".$l->getNombre()."</option>";
        }
    }else{
        echo "<option value='0'>No hay Provincia Registrada</option>";
    }
}