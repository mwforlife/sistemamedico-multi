<?php
require '../controller.php';
$c = new Controller();
session_start();

    if (isset($_POST['id'])) {
        $result = $c->eliminarEmpresa($_POST['id']);    
            if ($result == true) {
                echo 1;
            } else {
                echo 0;
            }
        
    }
