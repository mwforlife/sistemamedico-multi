<?php
require '../controller.php';
$c = new controller();
if(isset($_POST['Codigo']) && isset($_POST['descripcion']) && isset($_POST['laboratorio']) && isset($_POST['division']) && isset($_POST['categoria'])){
    $codigo = $_POST['Codigo'];
    $descripcion = $_POST['descripcion'];
    $laboratorio = $_POST['laboratorio'];
    $division = $_POST['division'];
    $categoria = $_POST['categoria'];

    if(strlen($codigo) > 0 && strlen($descripcion) > 0 && strlen($laboratorio) > 0 && strlen($division) > 0 && strlen($categoria) > 0){
        $result = $c->registrarmedicamentos($codigo,$descripcion,$laboratorio,$division,$categoria);
         if($result==true){
            echo 1;
         }else{
            echo 0;
         }
        }else{
            echo 0;
        }
}else{
    echo 0;
}