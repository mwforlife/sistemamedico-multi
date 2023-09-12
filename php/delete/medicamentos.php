<?php
require '../controller.php';
$c = new controller();
if(isset($_POST['id'])){
    $id = $_POST['id'];
    $medicamento = $c->buscarmedicamento($id);
    $c->eliminarmedicamentoesquemamedicamento($id);
    $c->eliminarmedicamento($id);
    echo 1;
    /***********Auditoria******************* */
    session_start();
    $titulo = "Eliminacion de Medicamento";
    $enterprise = $_SESSION['CURRENT_ENTERPRISE'];
    $idUsuario = $_SESSION['USER_ID'];
    $object = $c->buscarenUsuario1($idUsuario);
    $evento = "El Usuario " . $object->getNombre() . " " . $object->getApellido1() . " " . $object->getApellido2() . " ha eliminado el medicamento: " . $medicamento->getNombre() . "";
    $c->registrarAuditoria($_SESSION['USER_ID'], $enterprise, 1, $titulo, $evento);
    /**************************************** */
}