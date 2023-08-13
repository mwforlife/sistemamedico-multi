<?php
require '../controller.php';
$c = new Controller();
session_start();

if (isset($_POST['EnterpriseRut']) && isset($_POST['EnterpriseNombre']) && isset($_POST['Enterprisecalle']) && isset($_POST['Enterprisevilla']) && isset($_POST['Enterprisenumero']) && isset($_POST['Enterprisedept']) && isset($_POST['EnterpriseRegion']) && isset($_POST['EnterpriseComuna']) && isset($_POST['EnterpriseCiudad']) && isset($_POST['EnterpriseTelefono']) && isset($_POST['EnterpriseCorreo']) && isset($_POST['EnterpriseGire'])) {
    $EnterpriseRut = $_POST['EnterpriseRut'];
    if (strlen($EnterpriseRut) <= 0) {
        echo "El rut no puede estar vacio";
        return;
    }
    $EnterpriseNombre = $_POST['EnterpriseNombre'];
    if (strlen($EnterpriseNombre) <= 0) {
        echo "El nombre no puede estar vacio";
        return;
    }
    $EnterpriseNombre = $c->escapeString($EnterpriseNombre);
    $EnterpriseNombre = strtoupper($EnterpriseNombre);
    $Enterprisecalle = $_POST['Enterprisecalle'];
    if (strlen($Enterprisecalle) <= 0) {
        echo "La calle no puede estar vacia";
        return;
    }
    $Enterprisecalle = $c->escapeString($Enterprisecalle);
    $Enterprisecalle = strtoupper($Enterprisecalle);
    $Enterprisenumero = $_POST['Enterprisenumero'];
    if (strlen($Enterprisenumero) <= 0) {
        echo "El numero no puede estar vacio";
        return;
    }
    $Enterprisevilla = $_POST['Enterprisevilla'];
    $Enterprisenumero = $c->escapeString($Enterprisenumero);
    $Enterprisenumero = strtoupper($Enterprisenumero);
    $Enterprisedept = $_POST['Enterprisedept'];
    $Enterprisedept = $c->escapeString($Enterprisedept);
    $Enterprisedept = strtoupper($Enterprisedept);
    $EnterpriseRegion = $_POST['EnterpriseRegion'];
    if ($EnterpriseRegion < 1) {
        echo "La region no puede estar vacia";
        return;
    }
    $EnterpriseComuna = $_POST['EnterpriseComuna'];
    if ($EnterpriseComuna < 1) {
        echo "La comuna no puede estar vacia";
        return;
    }
    $EnterpriseCiudad = $_POST['EnterpriseCiudad'];
    if ($EnterpriseCiudad < 1) {
        echo "La ciudad no puede estar vacia";
        return;
    }
    $EnterpriseTelefono = $_POST['EnterpriseTelefono'];
    if (strlen($EnterpriseTelefono) <= 0) {
        echo "El telefono no puede estar vacio";
        return;
    }
    $EnterpriseTelefono = $c->escapeString($EnterpriseTelefono);
    $EnterpriseCorreo = $_POST['EnterpriseCorreo'];
    if (strlen($EnterpriseCorreo) <= 0) {
        echo "El correo no puede estar vacio";
        return;
    }
    $EnterpriseCorreo = $c->escapeString($EnterpriseCorreo);
    $EnterpriseGire = $_POST['EnterpriseGire'];
    if (strlen($EnterpriseGire) <= 0) {
        echo "El giro no puede estar vacio";
        return;
    }
    $EnterpriseGire = $c->escapeString($EnterpriseGire);
    $EnterpriseGire = strtoupper($EnterpriseGire);

    if (isset($_SESSION['EMPRESA_EDIT'])) {
        $EnterpriseId = $_SESSION['EMPRESA_EDIT'];
        $result = $c->actualizarEmpresa($EnterpriseId, $EnterpriseRut, $EnterpriseNombre, $Enterprisecalle, $Enterprisevilla, $Enterprisenumero, $Enterprisedept, $EnterpriseRegion, $EnterpriseComuna, $EnterpriseCiudad, $EnterpriseTelefono, $EnterpriseCorreo, $EnterpriseGire);
        if ($result == true) {
            echo 1;
            $emp = $c->BuscarEmpresaporRut($EnterpriseRut);
            $id = $emp->getId();
        }
    } else {
        $valid = $c->validarEmpresa($EnterpriseRut);
        if ($valid == true) {
            echo 2;
        } else {
            $result = $c->RegistrarEmpresa($EnterpriseRut, $EnterpriseNombre, $Enterprisecalle, $Enterprisevilla, $Enterprisenumero, $Enterprisedept, $EnterpriseRegion, $EnterpriseComuna, $EnterpriseCiudad, $EnterpriseTelefono, $EnterpriseCorreo, $EnterpriseGire);
            if ($result == true) {
                echo 1;
                $emp = $c->BuscarEmpresaporRut($EnterpriseRut);
                $id = $emp->getId();
                $_SESSION['EMPRESA_ID'] = $id;
            }
        }
    }
}else{
    echo "Error al recibir los datos";
}
