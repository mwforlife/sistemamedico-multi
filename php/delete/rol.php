<?php
require '../controller.php';
$c = new Controller();
if(isset($_POST['rol']) && isset($_POST['empresa']) && isset($_POST['usuario'])){
    $rol = $_POST['rol'];
    $empresa = $_POST['empresa'];
    $usuario = $_POST['usuario'];
    if($rol <= 0){
        echo json_encode(array('error' => true, 'message' => 'Los datos no son correctos'));
        return;
    }
    $result = $c->EliminarRolUsuarioEmpresa($rol, $empresa, $usuario);
    if($result){
        echo json_encode(array('error' => false, 'message' => 'Rol eliminado correctamente'));
    }else{
        echo json_encode(array('error' => true, 'message' => 'Error al eliminar el rol'));
    }
}