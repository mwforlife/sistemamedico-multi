<?php
session_start();
if(isset($_POST['id'])){
    $id = $_POST['id'];
    if($id>0){
        $_SESSION['CURRENT_ENTERPRISE'] = $id;
        echo 1;
    }else{
        echo 0;
    }
}else{
    echo 0;
}