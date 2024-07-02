<?php
require '../controller.php';
$c = new Controller();
session_start();

if(isset($_POST['id'])){
    $id = $_POST['id'];
    if($id <= 0){
        echo json_encode(array('status' => false, 'message' => 'El Identificador de la receta es incorrecto'));
        return;
    }
    $result = $c->buscarrechazoreceta($id);
    if($result!=null){
        echo "<div class='row'>";
        echo "<div class='col-md-12'>";
        echo "<p><strong>Motivo:</strong> ".$result['motivo']."</p>";
        echo "<p><strong>Observación:</strong><br/> ".$result['observacion']."</p>";
        echo "</div>";
        echo "</div>";
    }else{
        echo "<div class='row'>";
        echo "<div class='col-md-12'>";
        echo "<div class='alert alert-danger' role='alert'>";
        echo "No se encontraron datos";
        echo "</div>";
        echo "</div>";
        echo "</div>";
    }
}else{
    echo "<div class='row'>";
    echo "<div class='col-md-12'>";
    echo "<div class='alert alert-danger' role='alert'>";
    echo "No se encontraron datos";
    echo "</div>";
    echo "</div>";
    echo "</div>";
}