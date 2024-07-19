
<?php
require '../controller.php';
$c = new Controller();
$id = $_POST['id'];
$medidasant = $c->listarsignosvitales5($id);
foreach ($medidasant as $row) {
    echo "<tr>";
    echo "<td>" . date("d/m/Y", strtotime($row->getRegistro())) . "</td>";
    echo "<td>" . $row->getFresp() . "</td>";
    echo "<td>" . $row->getPsist() . "</td>";
    echo "<td>" . $row->getPdias() . "</td>";
    echo "<td>" . $row->getSat02() . "</td>";
    echo "<td>" . $row->getFc() . "</td>";
    echo "<td>" . $row->getTauxiliar() . "</td>";
    echo "<td>" . $row->getTrect() . "</td>";
    echo "<td>" . $row->getTotra() . "</td>";
    echo "<td>" . $row->getHgt() . "</td>";
    echo "<td>-</td>";
    echo "<td>" . $row->getId() . "</td>";
    echo "</tr>";
}
?>
