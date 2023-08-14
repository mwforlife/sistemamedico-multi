<?php
require '../controller.php';
$c = new Controller();

if(isset($_POST['id'])){
    $id = $_POST['id'];
    $result = $c->query("delete from diasferiado where id = $id");
    if($result == true){
        echo 1;
    }else{
        echo 0;
    }
}