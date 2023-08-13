<?php
if (isset($_POST['User']) && isset($_POST['Password'])) {
    require '../controller.php';
    $c = new Controller();
    $User = $_POST['User'];
    $User = $c->escapeString($User);
    $Password = $_POST['Password'];
    $Password = $c->escapeString($Password);

    $object = $c->login($User, $Password);
    if ($object != null) {
        session_start();
        $_SESSION['USER_ID'] = $object->getId();
        //Valor alfanumerico aleatorio
        $token = md5(uniqid(mt_rand(), true));
        $_SESSION['USER_TOKEN'] = $token;
        $c->crearsesion($object->getId(), $token);
        echo 1;
        
    } else {
        echo "Usuario o contraseña incorrectos";
    }
} else {
    echo "No se ha recibido ningun dato";
}
