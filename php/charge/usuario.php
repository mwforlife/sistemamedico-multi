<?php
require '../controller.php';
$c = new Controller();
session_start();
if(isset($_POST['rut']) && isset($_POST['empresa'])){
    $usuario = $_POST['rut'];
    $empresa = $_POST['empresa'];

    if(strlen($usuario) < 8){
        echo json_encode(array('error' => true, 'message' => 'Los datos no son correctos'));
        return;
    }

    $usuarios = $c->buscarusuariobyRUT($usuario);
    if($usuarios == null){
        echo json_encode(array('error' => true, 'message' => 'Error al buscar el usuario'));
        return;
    }

    $objectjson = array('error' => false, 'message' => 'Hay un Usuario registrado con este RUT, confirma la información y rellena los datos faltantes. ¡Gracias!', 'id' => $usuarios->getId(), 'rut' => $usuarios->getRut(), 'nombre' => $usuarios->getNombre(), 'apellido' => $usuarios->getApellido1(), 'apellido2' => $usuarios->getApellido2(), 'email' => $usuarios->getEmail(), 'direccion' => $usuarios->getDireccion(), 'region' => $usuarios->getRegion(), 'comuna' => $usuarios->getComuna(), 'profesion' => $usuarios->getProfesion(), 'servicio' => $usuarios->getProveniencia(), 'phone' => $usuarios->getTelefono(), 'password' => $usuarios->getPassword(), 'estado' => $usuarios->getEstado());
    echo json_encode($objectjson);

}else{
    echo json_encode(array('error' => true, 'message' => 'No se han recibido los datos'));
}