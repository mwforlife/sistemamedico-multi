<?php
require '../controller.php';
$c = new Controller();
$tipo = $_POST['tipo'];
$diagnostico = $_POST['diagnostico'];
$primario = $c->listartnmpordiagnostico($tipo, $diagnostico);
foreach ($primario as $row) {
    echo "<option value='" . $row->getId() . "'>" . $row->getNombre() . "</option>";
}
?>