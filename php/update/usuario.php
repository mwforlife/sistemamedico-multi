<?php
require '../controller.php';
$c = new Controller();
session_start();
if (!isset($_SESSION['USER_ID'])) {
	echo "No hay ninguna sesion iniciada";
    return;
} else {
	$valid  = $c->validarsesion($_SESSION['USER_ID'], $_SESSION['USER_TOKEN']);
	if ($valid == false) {
		echo "No hay ninguna sesion iniciada";
        return;
	}
}
$empresa = null;
if(isset($_SESSION['CURRENT_ENTERPRISE'])){
	$enterprise = $_SESSION['CURRENT_ENTERPRISE'];
	$empresa = $c->buscarEmpresa($enterprise);
	$idempresa = $empresa->getId();
}else{
    echo "No hay ninguna empresa seleccionada";
    return;
}
$id = $_SESSION['USER_ID'];
$object = $c->buscarenUsuario($id,$empresa->getId());

if (isset($_POST['id']) && isset($_POST['UserRut']) && isset($_POST['UserNombre']) && isset($_POST['UserApellido1']) && isset($_POST['UserApellido2']) && isset($_POST['UserEmail']) && isset($_POST['UserDireccion']) && isset($_POST['UserRegion']) && isset($_POST['UserComuna']) && isset($_POST['Userprofesion']) && isset($_POST['UserServicio'])  && isset($_POST['UserPhone']) && isset($_POST['idempresa'])) {
    $id = $_POST['id'];
    $object1 = $c->buscarenUsuario($id,$empresa->getId());

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

    if ($c->validarusuario1($rut, $email,$id) == true) {
        echo "El usuario ya existe";
        return;
    }
    $titulo = "Modificacion de datos de Usuario";
    $evento = "El Usuario " . $object->getNombre() . " " . $object->getApellido1() . " " . $object->getApellido2() . " ha realizado una modificacion de datos personales de un usuario";
    $evento .= "<br/>";
    $evento .= "Datos Anteriores: ";
    $evento .= "<br/>";
    $evento .= "Rut: " . $object1->getRut();
    $evento .= "<br/>";
    $evento .= "Nombre: " . $object1->getNombre();
    $evento .= "<br/>";
    $evento .= "Apellido 1: " . $object1->getApellido1();
    $evento .= "<br/>";
    $evento .= "Apellido 2: " . $object1->getApellido2();
    $evento .= "<br/>";
    $evento .= "Email: " . $object1->getEmail();
    $evento .= "<br/>";
    $evento .= "Direccion: " . $c->escapeString($object1->getDireccion());
    $evento .= "<br/>";
    $evento .= "Telefono: " . $object1->getTelefono();
    $evento .= "<br/>";
    
    $evento .= "<br/>";
    $evento .= "Datos Datos Actuales: ";
    $evento .= "<br/>";
    $evento .= "Rut: " . $rut;
    $evento .= "<br/>";
    $evento .= "Nombre: " . $nombre;
    $evento .= "<br/>";
    $evento .= "Apellido 1: " . $apellido;
    $evento .= "<br/>";
    $evento .= "Apellido 2: " . $apellido2;
    $evento .= "<br/>";
    $evento .= "Email: " . $email;
    $evento .= "<br/>";
    $evento .= "Direccion: " . $c->escapeString($direccion);
    $evento .= "<br/>";
    $evento .= "Telefono: " . $phone;
    $evento .= "<br/>";
    $eventos = $c->escapeString($evento);
    
    $result = $c->editarusuario($id,$rut, $nombre, $apellido, $apellido2, $email, $direccion, $region, $comuna, $phone);

    $c->editarusuarioprofesion($id, $profesion,$servicio,$empresa);



    if ($result == true) {
        echo 1;
        $c->registrarAuditoria($_SESSION['USER_ID'], 2, $titulo, $evento);
    } else {
        echo 0;
    }
} else {
    echo "Error al recibir los datos";
}
