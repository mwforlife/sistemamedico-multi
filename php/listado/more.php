<?php
require '../controller.php';
$c = new Controller();
session_start();
if (!isset($_SESSION['USER_ID'])) {
    header("Location: signin.php");
} else {
    $valid  = $c->validarsesion($_SESSION['USER_ID'], $_SESSION['USER_TOKEN']);
    if ($valid == false) {
        header("Location: lockscreen.php");
    }
}

if(isset($_POST['id'])){
    $id = $_POST['id'];
    $empresa = $c->buscarEmpresa($id);
    $rut = $empresa->getRut();
    $nombre = $empresa->getRazonSocial();
    $calle = $empresa->getCalle();
    $numero = $empresa->getNumero();
    $dept = $empresa->getDepartamento();
    $region = $empresa->getRegion();
    $comuna = $empresa->getComuna();
    $ciudad = $empresa->getCiudad();
    $telefono = $empresa->getTelefono();
    $email = $empresa->getEmail();
    $giro = $empresa->getGiro();
    echo "<div class='row'>
            <div class='col-md-12'>
                <div class='box box-primary'>
                    <div class='box-header with-border'>
                        <h3 class='box-title'>Datos de la Empresa</h3>
                    </div>
                    <div class='box-body'>
                        <div class='row'>
                            <div class='col-md-6'>
                                <div class='form-group'>
                                    <label>Rut</label>
                                    <input type='text' class='form-control' value='".$empresa->getRut()."' readonly>
                                </div>
                            </div>
                            <div class='col-md-6'>
                                <div class='form-group'>
                                    <label>Nombre</label>
                                    <input type='text' class='form-control' value='".$empresa->getRazonSocial()."' readonly>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-md-6'>
                                <div class='form-group'>
                                    <label>Dirección</label>
                                    <p class='form-control'>".$empresa->getCalle()."</p>
                                </div>
                            </div>
                            <div class='col-md-6'>
                                <div class='form-group'>
                                    <label>Numero</label>
                                    <p class='form-control'>".$empresa->getRegion()."</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class='row'>
                            <div class='col-md-6'>
                                <div class='form-group'>
                                    <label>Departamento</label>
                                    <p class='form-control'>".$empresa->getDepartamento()."</p>
                                </div>
                            </div>
                            <div class='col-md-6'>
                                <div class='form-group'>
                                    <label>Región</label>
                                    <p class='form-control'>".$empresa->getRegion()."</p>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-md-6'>
                                <div class='form-group'>
                                    <label>Comuna</label>
                                    <p class='form-control'>".$empresa->getComuna()."</p>
                                </div>
                            </div>
                            <div class='col-md-6'>
                                <div class='form-group'>
                                    <label>Ciudad</label>
                                    <p class='form-control'>".$empresa->getCiudad()."</p>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-md-6'>
                                <div class='form-group'>
                                    <label>Teléfono</label>
                                    <p class='form-control'>".$empresa->getTelefono()."</p>
                                </div>
                            </div>
                            <div class='col-md-6'>
                                <div class='form-group'>
                                    <label>Email</label>
                                    <p class='form-control'>".$empresa->getEmail()."</p>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-md-6'>
                                <div class='form-group'>
                                    <label>Giro</label>
                                    <p class='form-control'>".$empresa->getGiro()."</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>";
        echo "<div class='row'>
                <div class='col-md-12'>
                    <div class='box box-primary'>
                        <div class='box-header
                            <h3 class='box-title'>Representantes de la Empresa</h3>
                        </div>
                        <div class='box-body'>
                            <table id='example1' class='table table-bordered table-striped'>
                                <thead>
                                    <tr>
                                        <th>Rut</th>
                                        <th>Nombre</th>
                                        <th>Apellidos</th>
                                    </tr>
                                </thead>
                                <tbody>";
                                $lista = $c->listarRepresentantelegal($id);
                                if (count($lista) > 0) {
                                    foreach ($lista as $codigo) {
                                        echo "<tr>";
                                        echo "<td>" . $codigo->getRut() . "</td>";
                                        echo "<td>" . $codigo->getNombre() . "</td>";
                                        echo "<td>" . $codigo->getApellido1() . " " .$codigo->getApellido2(). "</td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr>";
                                    echo "<td colspan='3' class='text-center'>No hay Representante Legal Registrados</td>";
                                    echo "</tr>";
                                }
                                echo "</tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>";
            echo "<div class='row'>
                    <div class='col-md-12'>
                        <div class='box box-primary'>
                            <div class='box-header
                                <h3 class='box-title'>Codigo de Actividad</h3>
                            </div>
                            <div class='box-body'>
                                <table id='example1' class='table table-bordered table-striped'>
                                    <thead>
                                        <tr>
                                            <th>Codigo SIi</th>
                                            <th>Actividad</th>
                                        </tr>
                                    </thead>
                                    <tbody>";
                                    $lista = $c->ListarCodigoActividadEmpresa($id);
                                    if (count($lista) > 0) {
                                        foreach ($lista as $codigo) {
                                            echo "<tr>";
                                            echo "<td>" . $codigo->getCodigoSii() . "</td>";
                                            echo "<td>" . $codigo->getNombre() . "</td>";
                                            echo "</tr>";
                                        }
                                    } else {
                                        echo "<tr>";
                                        echo "<td colspan='3' class='text-center'>No hay códigos de actividad</td>";
                                        echo "</tr>";
                                    }
                                    echo "</tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>";



}