<?php
require '../controller.php';
$c = new Controller();
$id = $_POST['id'];
$medidasant = $c->listarmedicamentosesquemas($id);
if(count($medidasant)>0){
foreach ($medidasant as $row) {
    echo "<tr>";
    echo "<td>" . $row->getId() . "</td>";
    echo "<td>" . $row->getMedicamento() . "</td>";
    echo "<td>" . $row->getDosis() . "</td>";
    echo "<td>" . $row->getMedicion() . "</td>";
    if($row->getCarboplatino() == 1){
        echo "<td>Si</td>";
    }else{
        echo "<td>No</td>";
    }
    echo "<td><button type='button' class='btn btn-danger' onclick='EliminarMedicamentoEsquema(" . $row->getId() . ")'><i class='fa fa-trash'></i></button></td>"; 
    echo "</tr>";
}         
}else{
    echo "<tr>";
    echo "<td colspan='5'>No hay medicamentos en este esquema</td>";
    echo "</tr>";
}
