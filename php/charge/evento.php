<?php
require '../controller.php';
$c = new Controller();

if(isset($_POST['id'])){
    $auditoria = $c->buscarAuditoria($_POST['id']);
    echo $auditoria->getEvento();
}