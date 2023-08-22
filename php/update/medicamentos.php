<?php
require '../controller.php';
$c = new controller();
if(isset($_POST['codigoedit']) && isset($_POST['descripcionedit']) && isset($_POST['laboratorioedit']) && isset($_POST['division']) && isset($_POST['categoriaedit']) && isset($_POST['idmedicamento'])){
    $codigo = $_POST['codigoedit'];
    $descripcion = $_POST['descripcionedit'];
    $laboratorio = $_POST['laboratorioedit'];
    $division = $_POST['division'];
    $categoria = $_POST['categoriaedit'];
    $id = $_POST['idmedicamento'];
    if(strlen($codigo) > 0 && strlen($descripcion) > 0 && strlen($laboratorio) > 0 && strlen($division) > 0 && strlen($categoria) > 0 && strlen($id) > 0 && is_numeric($id)){
        if($id > 0){
            $result = $c->actualizarmedicamento($id,$codigo,$descripcion,$laboratorio,$division,$categoria);
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
}else{
    echo 0;
}