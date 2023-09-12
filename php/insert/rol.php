<?php
require '../controller.php';
$c = new Controller();
session_start();
if(isset($_POST['rol']) && isset($_POST['usuario']) && isset($_POST['empresa'])){
    $rol = $_POST['rol'];
    $usuario = $_POST['usuario'];
    $usuarioobject = $c->buscarenUsuario1($usuario);
    $empresa = $_POST['empresa'];

    if($rol <= 0 || $usuario <= 0 || $empresa <= 0){
        echo json_encode(array('error' => true, 'message' => 'Los datos no son correctos'));
        return;
    }

    //Validar que el usuario no tenga ya el rol asignado
    $result = $c->ValidarRolUsuarioEmpresa($empresa, $usuario,$rol);
    if($result==true){
        echo json_encode(array('error' => true, 'message' => 'El usuario ya tiene asignado el rol'));
        return;
    }

    $result = $c->RegistrarRolUsuarioEmpresa($empresa, $usuario,$rol);
    if($result){
        echo json_encode(array('error' => false, 'message' => 'Rol Asignado correctamente'));
        
        /***********Auditoria******************* */
        $titulo = "Asignación de Roles";
        $enterprise = $_SESSION['CURRENT_ENTERPRISE'];
        $idUsuario = $_SESSION['USER_ID'];
        $object = $c->buscarenUsuario1($idUsuario);
        $evento = "El Usuario " . $object->getNombre() . " " . $object->getApellido1() . " " . $object->getApellido2() . " le ha asignado el rol " . $rol . " al usuario " . $usuarioobject->getNombre() . " " . $usuarioobject->getApellido1() . " " . $usuarioobject->getApellido2() . "";
        $c->registrarAuditoria($_SESSION['USER_ID'],$enterprise, 1, $titulo, $evento);
        /**************************************** */
    }else{
        echo json_encode(array('error' => true, 'message' => 'Error al Asignar el rol'));
    }
}else{
    echo json_encode(array('error' => true, 'message' => 'Los datos no son correctos'));
}