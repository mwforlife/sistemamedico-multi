<?php
require '../controller.php';
$c = new Controller();

if(isset($_POST['id']) && isset($_POST['contra'])){
    $id = $_POST['id'];
    $contra = $_POST['contra'];
    $result = $c->cambiarcontrasena($id,$contra);
    if($result==true){
        echo "1";
    }else{
        echo "0";
    }
}