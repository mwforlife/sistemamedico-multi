<?php
require '../controller.php';
$c = new controller();
if(isset($_POST['id'])){
    $id = $_POST['id'];
    $c->eliminarmedicamento($id);
    echo 1;
}