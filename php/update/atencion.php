<?php
require '../controller.php';
$c = new Controller();
if(isset($_POST['id']) && isset($_POST['estado']) && isset($_POST['observacion'])){
    $id = $_POST['id'];
    $estado = $_POST['estado'];
    $observacion = $_POST['observacion'];
    $c->query("update atenciones set estado = '$estado', observacion = '$observacion' where id = $id");
    echo 1;
}