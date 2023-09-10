<?php
require '../controller.php';
$c = new Controller();
if(isset($_POST['rol']) && isset($_POST['usuario']) && isset($_POST['empresa'])){
    $rol = $_POST['rol'];
    $usuario = $_POST['usuario'];
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
    }else{
        echo json_encode(array('error' => true, 'message' => 'Error al Asignar el rol'));
    }
}else{
    echo json_encode(array('error' => true, 'message' => 'Los datos no son correctos'));
}