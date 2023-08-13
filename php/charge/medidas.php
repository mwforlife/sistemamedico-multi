<?php
require '../controller.php';
$c = new Controller();
$id = $_POST['id'];
$medidasant = $c->listarmedidasantropometricas5($id);
foreach ($medidasant as $row) {
    echo "<tr>";
    echo "<td>" . date("d/m/Y", strtotime($row->getRegistro())) . "</td>";
    echo "<td>" . $row->getPeso() . "</td>";
    echo "<td>" . $row->getTalla() . "</td>";
    echo "<td>" . $row->getPcee() . "</td>";
    echo "<td>" . $row->getPe() . "</td>";
    echo "<td>" . $row->getPt() . "</td>";
    echo "<td>" . $row->getTe() . "</td>";
    echo "<td>" . $row->getImc() . "</td>";
    echo "<td>" . $row->getClasifimc() . "</td>";
    echo "<td>" . $row->getPce() . "</td>";
    echo "<td>" . $row->getClasificacioncintura() . "</td>";
    echo "<td>" . $row->getId() . "</td>";
    echo "</tr>";
}
