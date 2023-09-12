<?php
require '../controller.php';
$c = new Controller();

if(isset($_POST['UserRut']) && isset($_POST['UserNombre']) && isset($_POST['UserApellido1']) && isset($_POST['UserApellido2']) && isset($_POST['UserEmail']) && isset($_POST['UserDireccion']) && isset($_POST['UserRegion']) && isset($_POST['UserComuna']) && isset($_POST['Userprofesion']) && isset($_POST['UserServicio']) && isset($_POST['UserPhone']) && isset($_POST['UserPassword']) && isset($_POST['UserPassword1']) && isset($_POST['idempresa'])){
    $rut = $_POST['UserRut'];
    $nombre = $_POST['UserNombre'];
    $nombre = $c->escapeString($nombre);
    //Mayusculas
    $nombre = strtoupper($nombre);

    $apellido = $_POST['UserApellido1'];
    $apellido = $c->escapeString($apellido);
    //Mayusculas
    $apellido = strtoupper($apellido);

    $apellido2 = $_POST['UserApellido2'];
    $apellido2 = $c->escapeString($apellido2);
    //Mayusculas
    $apellido2 = strtoupper($apellido2);

    $email = $_POST['UserEmail'];
    $email = $c->escapeString($email);

    $direccion = $_POST['UserDireccion'];
    $direccion = $c->escapeString($direccion);
    //Mayusculas
    $direccion = strtoupper($direccion);

    $region = $_POST['UserRegion'];
    $comuna = $_POST['UserComuna'];
    $profesion = $_POST['Userprofesion'];
    $servicio = $_POST['UserServicio'];
    $phone = $_POST['UserPhone'];
    $phone = $c->escapeString($phone);
    $password = $_POST['UserPassword'];
    $password1 = $_POST['UserPassword1'];
    $empresa = $_POST['idempresa'];

    if($empresa<=0){
        echo "No se puede registrar el usuario, no se ha encontrado la empresa";
        return;
    }

    if($password!==$password1){
        echo "Las contraseñas no coinciden";
        return;
    }

    if($password == $password1){
        if($c->validarusuario($rut, $email)==true){
            echo "Ya hay un usuario con los datos que usted intenta ingresar, favor de revisar el Rut y/0 Correo Electronico e intentar nuevamente";
            return;
        }
       $result= $c->registrarusuario($rut, $nombre, $apellido,$apellido2, $email, $direccion, $region, $comuna, $phone, $password);
       if($result==true){
        $id = $c->buscaridusuario($rut, $email);
        if($id == null){
            echo "Error al Registrar el Usuario";
            return;
        }
        $c->registrarusuarioprofesion($id, $profesion, $servicio,$empresa,1);
        echo 1;
        /***********Auditoria******************* */
        $titulo = "Registro de Usuario";
        $enterprise = $_SESSION['CURRENT_ENTERPRISE'];
        $idUsuario = $_SESSION['USER_ID'];
        $object = $c->buscarenUsuario1($idUsuario);
        $evento = "El Usuario " . $object->getNombre() . " " . $object->getApellido1() . " " . $object->getApellido2() . " ha registrado un nuevo usuario con el nombre de " . $nombre . " " . $apellido . " " . $apellido2 . " y Rut " . $rut . "";
        $c->registrarAuditoria($_SESSION['USER_ID'],$enterprise, 1, $titulo, $evento);
        /**************************************** */

       }else{
        echo 0;
       }
    }else{
        echo "Las contraseñas no coinciden";
    }
}else if(isset($_POST['UserRut']) && isset($_POST['UserNombre']) && isset($_POST['UserApellido1']) && isset($_POST['UserApellido2']) && isset($_POST['UserEmail']) && isset($_POST['UserDireccion']) && isset($_POST['UserRegion']) && isset($_POST['UserComuna']) && isset($_POST['Userprofesion']) && isset($_POST['UserServicio']) && isset($_POST['UserPhone']) && isset($_POST['idempresa'])&& isset($_POST['idusuario'])){
    $rut = $_POST['UserRut'];
    $nombre = $_POST['UserNombre'];
    $nombre = $c->escapeString($nombre);
    //Mayusculas
    $nombre = strtoupper($nombre);

    $apellido = $_POST['UserApellido1'];
    $apellido = $c->escapeString($apellido);
    //Mayusculas
    $apellido = strtoupper($apellido);

    $apellido2 = $_POST['UserApellido2'];
    $apellido2 = $c->escapeString($apellido2);
    //Mayusculas
    $apellido2 = strtoupper($apellido2);

    $email = $_POST['UserEmail'];
    $email = $c->escapeString($email);

    $direccion = $_POST['UserDireccion'];
    $direccion = $c->escapeString($direccion);
    //Mayusculas
    $direccion = strtoupper($direccion);

    $region = $_POST['UserRegion'];
    $comuna = $_POST['UserComuna'];
    $profesion = $_POST['Userprofesion'];
    $servicio = $_POST['UserServicio'];
    $phone = $_POST['UserPhone'];
    $phone = $c->escapeString($phone);
    $empresa = $_POST['idempresa'];
    $idusuario = $_POST['idusuario'];

    if($empresa<=0){
        echo "No se puede registrar el usuario, no se ha encontrado la empresa";
        return;
    }

    if($c->validarusuario1($rut, $email,$idusuario)==true){
        echo "Ya hay un usuario con los datos que usted intenta ingresar, favor de revisar el Rut y/0 Correo Electronico e intentar nuevamente";
        return;
    }

    if($c->validarusuarioempresa($idusuario, $empresa)==true){
        echo "El usuario ya se encuentra registrado en esta empresa";
        return;
    }

    $result= $c->editarusuario($idusuario, $rut, $nombre, $apellido,$apellido2, $email, $direccion, $region, $comuna, $phone);
    if($result==true){
        $c->registrarusuarioprofesion($idusuario, $profesion, $servicio,$empresa,1);
        echo 1;
        /***********Auditoria******************* */
        $titulo = "Registro de Usuario";
        $enterprise = $_SESSION['CURRENT_ENTERPRISE'];
        $idUsuario = $_SESSION['USER_ID'];
        $object = $c->buscarenUsuario1($idUsuario);
        $evento = "El Usuario " . $object->getNombre() . " " . $object->getApellido1() . " " . $object->getApellido2() . " ha asignado un nuevo usuario con el nombre de " . $nombre . " " . $apellido . " " . $apellido2 . " y Rut " . $rut . " al Hospital";
        $c->registrarAuditoria($_SESSION['USER_ID'],$enterprise, 1, $titulo, $evento);
        /**************************************** */
    }else{
        echo 0;
    }
}else{
    echo "No se han recibido los datos";
}