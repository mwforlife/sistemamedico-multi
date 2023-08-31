<?php
require '../controller.php';
$c = new Controller();
$lista = $c->listarDiagnosticosCIE101();
foreach ($lista as $object) {
    echo "<tr>";
    echo "<td>" . $object->getCodigo() . "</td>";
    echo "<td>" . $object->getDescripcion() . "</td>";
    echo "<td class='text-center'>";
    echo "<a href='javascript:void(0)' class='btn btn-outline-primary btn-sm' onclick='agregarDiagnosticoCIE10(" . $object->getId() . ",\"" . $object->getDescripcion() . "\")'><i class='fa fa-plus'></i></a>";
    echo "</td>";
    echo "</tr>";
}