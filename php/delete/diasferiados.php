<?php
require '../controller.php';
$c = new Controller();

if(isset($_POST['id'])){
    $id = $_POST['id'];
    $result = $c->query("delete from diasferiado where id = $id");
    if($result == true){
        echo 1;
        /***********Auditoria******************* */
        session_start();
        $titulo = "Eliminacion de Dia Feriado";
        $enterprise = $_SESSION['CURRENT_ENTERPRISE'];
        $idUsuario = $_SESSION['USER_ID'];
        $object = $c->buscarenUsuario1($idUsuario);
        $evento = "El Usuario " . $object->getNombre() . " " . $object->getApellido1() . " " . $object->getApellido2() . " ha eliminado un dia feriado";
        $c->registrarAuditoria($_SESSION['USER_ID'], $enterprise, 1, $titulo, $evento);
        /**************************************** */
    }else{
        echo 0;
    }
}