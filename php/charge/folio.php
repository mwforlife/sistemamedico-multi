<?php
require '../controller.php';
$c = new Controller();

if(isset($_POST['id'])){
    $id = $_POST['id'];
    $folio = $c->buscarultimofoliocomite($id);
    $folio = $folio + 1;
    echo $folio;
}