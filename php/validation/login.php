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
        $empresas = $c->empresasusuario($object->getId());
        if(count($empresas)==0){
            if($c->validarroladmin($object->getId())==false){
                echo "No puede ingresar no tiene ninguna empresa asignada, contacte a su administrador";
                return;
            }
           
        }
        $_SESSION['USER_ID'] = $object->getId();
        //Valor alfanumerico aleatorio
        $token = md5(uniqid(mt_rand(), true));
        $_SESSION['USER_TOKEN'] = $token;
        $c->crearsesion($object->getId(), $token);

        //Obtener fecha y hora actual
        $fecha = "";
        $hora = "";
        $fechahora = $c->obtenerFechaYHoraActual();
        if($fechahora!=null){
            $fecha = $fechahora["fecha"];
            $hora = $fechahora["hora"];
        }else{
            $fecha = date("Y-m-d");
            $hora = date("H:i:s");
        }
        foreach($empresas as $empresa){
            $titulo = "Inicio de sesión";
            $idUsuario = $_SESSION['USER_ID'];
            $object = $c->buscarenUsuario1($idUsuario);
            $evento = "El Usuario " . $object->getNombre() . " " . $object->getApellido1() . " " . $object->getApellido2() . " ha iniciado sesión en el sistema a las " . date("H:i:s") . " del día " . date("d/m/Y");
            $c->registrarAuditoria($_SESSION['USER_ID'],$empresa->getId(), 5, $titulo, $evento);
        }
        echo 1;
        
    } else {
        echo "Usuario o contraseña incorrectos";
    }
} else {
    echo "No se ha recibido ningun dato";
}
