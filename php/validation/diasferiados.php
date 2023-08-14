<?php
require '../controller.php';
$c = new Controller();

if(isset($_POST['fecha'])){
    $fecha = $_POST['fecha'];
    $diasferiados = $c->comprobardiasferiados($fecha);
    if($diasferiados==true){
        echo 1;
    }else{
        echo 0;
    }
}else{
    echo 2;
}
?>
