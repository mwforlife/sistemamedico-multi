<?php
require '../controller.php';
$c = new Controller();
$enterprise = $_POST['enterprise'];
$usuario = $_POST['user'];

$roles = $c->listarRoles();
foreach ($roles as $rol) {
    echo "<tr>";
    echo "<td>" . $rol->getCodigo() . "</td>";
    echo "<td>" . $rol->getNombre() . "</td>";
    if ($c->ValidarRolUsuarioEmpresa($enterprise, $usuario, $rol->getId()) == false) {
        echo "<td><a href='javascript:void(0)' title='Asignar' onclick='asignarRol(" . $rol->getId() . ",$enterprise," . $usuario . ")' class='btn btn-outline-primary btn-sm'><i class='fa fa-user-plus'></i></a></td>";
    } else {
        echo "<td><a href='javascript:void(0)' title='Revocar' onclick='eliminarRol(" . $rol->getId() . ",$enterprise," . $usuario . ")' class='btn btn-outline-danger btn-sm'><i class='fa fa-user-times'></i></a></td>";
    }
    echo "</tr>";
}
?>