<?php
require '../controller.php';
$c = new Controller();
if(isset($_POST['id'])){
    $id = $_POST['id'];
    $c->cambiarestadoreserva($id,3);
    echo 1;
}