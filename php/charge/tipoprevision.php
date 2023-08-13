<?php
require '../controller.php';
$c = new Controller();

if(isset($_POST['id'])){
    $id = $_POST['id'];
    $lista = $c->listartipoprevision($id);
    foreach ($lista as $object) {
        echo "<option value='" . $object->getId() . "'>" . $object->getNombre() . "</option>";
    }
}