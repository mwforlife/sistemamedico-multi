<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require 'php/controller.php';
$c = new Controller();

session_start();
$empresa = null;
if (isset($_SESSION['CURRENT_ENTERPRISE'])) {
    $enterprise = $_SESSION['CURRENT_ENTERPRISE'];
    $empresa = $c->buscarEmpresa($enterprise);
} else {
    header("Location: index.php");
}

if (!isset($_SESSION['USER_ID'])) {
    header("Location: signin.php");
} else {
    $valid = $c->validarsesion($_SESSION['USER_ID'], $_SESSION['USER_TOKEN']);
    if ($valid == false) {
        header("Location: lockscreen.php");
    }
}
$id = $_SESSION['USER_ID'];
$object = $c->buscarenUsuario1($id);
?>
<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1, shrink-to-fit=no" name="viewport">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="keywords" content="">

    <!-- Favicon -->
    <link rel="icon" href="assets/img/brand/favicon.ico" type="image/x-icon" />

    <!-- Title -->
    <title>OncoWay</title>

    <!-- Bootstrap css-->
    <link href="css/bootstrap.css" rel="stylesheet">

    <!-- Icons css-->
    <link href="assets/css/icons.css" rel="stylesheet" />
    <link href="assets/css/toastify.min.css" rel="stylesheet" />

    <!-- Style css-->
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/dark-boxed.css" rel="stylesheet">
    <link href="assets/css/boxed.css" rel="stylesheet">
    <link href="assets/css/skins.css" rel="stylesheet">
    <link href="assets/css/dark-style.css" rel="stylesheet">

    <!-- Color css-->
    <link id="theme" rel="stylesheet" type="text/css" media="all" href="assets/css/colors/color.css">
    <!-- Fullcalendar css-->
    <link href='assets/plugins/fullcalendar/fullcalendar.css' rel='stylesheet' />
    <link href='assets/plugins/fullcalendar/fullcalendar.print.min.css' rel='stylesheet' media='print' />


    <!-- Select2 css -->
    <link href="assets/plugins/select2/css/select2.min.css" rel="stylesheet">


    <!-- Sidemenu css-->
    <link href="assets/css/sidemenu/sidemenu.css" rel="stylesheet">

    <link rel="stylesheet" href="JsFunctions/Alert/loader.css">


</head>

<body class="main-body leftmenu">

    <!-- Loader -->
    <div id="global-loader">
        <div class="loader-box">
            <div class="loading-wrapper">
                <div class="loader">
                    <div class="loader-inner">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Loader -->


    <!-- Page -->
    <div class="page">


        <!-- Sidemenu -->
        <div class="main-sidebar main-sidebar-sticky side-menu">
            <div class="sidemenu-logo">
                <a class="main-logo" href="index.php">
                    <img src="assets/img/brand/logo.png" class="header-brand-img desktop-logo" alt="logo">
                    <img src="assets/img/brand/icon.png" class="header-brand-img icon-logo" alt="logo">
                    <img src="assets/img/brand/dark-logo.png" class="header-brand-img desktop-logo theme-logo" alt="logo">
                    <img src="assets/img/brand/icon.png" class="header-brand-img icon-logo theme-logo" alt="logo">
                </a>
            </div>
            <div class="main-sidebar-body">
                <ul class="nav">
                    <li class="nav-header"><span class="nav-label">Dashboard</span></li>
                    <li class="nav-item">
                        <a class="nav-link with-sub" href="#"><i class="fe fe-home sidemenu-icon"></i><span class="sidemenu-label">Definiciones de Comité</span><i class="angle fe fe-chevron-right"></i></a>
                        <ul class="nav-sub">
                            <li class="nav-sub-item">
                                <a class="nav-sub-link" href="diagnosticos.php">Diagnosticos CIEO</a>
                            </li>
                            <li class="nav-sub-item">
                                <a class="nav-sub-link" href="diagnosticos1.php">Diagnosticos CIE10</a>
                            </li>
                            <li class="nav-sub-item">
                                <a class="nav-sub-link" href="ecog.php">Ecog</a>
                            </li>
                            <li class="nav-sub-item">
                                <a class="nav-sub-link" href="histologico.php">Histologico</a>
                            </li>
                            <li class="nav-sub-item">
                                <a class="nav-sub-link" href="invasiontumoral.php">Invasión Tumoral</a>
                            </li>
                            <li class="nav-sub-item">
                                <a class="nav-sub-link" href="tnmprimario.php">TNM-Primario clinico</a>
                            </li>
                            <li class="nav-sub-item">
                                <a class="nav-sub-link" href="tnmregionales.php">TNM-Regionales clinico</a>
                            </li>
                            <li class="nav-sub-item">
                                <a class="nav-sub-link" href="tnmdistancia.php">TNM-Distancia clinico</a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link with-sub" href="#"><i class="fe fe-home sidemenu-icon"></i><span class="sidemenu-label">Definiciones Generales</span><i class="angle fe fe-chevron-right"></i></a>
                        <ul class="nav-sub">
                            <li class="nav-sub-item">
                                <a class="nav-sub-link" href="regiones.php">Regiones</a>
                            </li>
                            <li class="nav-sub-item">
                                <a class="nav-sub-link" href="comunas.php">Comunas</a>
                            </li>
                            <li class="nav-sub-item">
                                <a class="nav-sub-link" href="nacionalidad.php">Nacionalidades</a>
                            </li>
                            <li class="nav-sub-item">
                                <a class="nav-sub-link" href="generos.php">Generos</a>
                            </li>
                            <li class="nav-sub-item">
                                <a class="nav-sub-link" href="especialidad.php">Especialidad</a>
                            </li>
                            <li class="nav-sub-item">
                                <a class="nav-sub-link" href="causaltermino.html">CAUSAL TERMINO CONTRATO</a>
                            </li>
                            <li class="nav-sub-item">
                                <a class="nav-sub-link" href="diasferiados.php">DIAS FERIADOS</a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-header"><span class="nav-label">FUNCIONES</span></li>
                    <li class="nav-item">
                        <a class="nav-link" href="tipodocumento.html"><i class="fe fe-grid sidemenu-icon"></i><span class="sidemenu-label">Redactar documentos</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link with-sub" href="#"><i class="fe fe-message-square sidemenu-icon"></i><span class="sidemenu-label">Empresas</span><i class="angle fe fe-chevron-right"></i></a>
                        <ul class="nav-sub">
                            <li class="nav-sub-item">
                                <a class="nav-sub-link" href="empresas.html">Registro de Empresas</a>
                            </li>
                            <li class="nav-sub-item">
                                <a class="nav-sub-link" href="centrocosto.html">Registro de Centro de Costo</a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link with-sub" href="#"><i class="fe fe-droplet sidemenu-icon"></i><span class="sidemenu-label">Auditoria</span><i class="angle fe fe-chevron-right"></i></a>
                        <ul class="nav-sub">
                            <li class="nav-sub-item">
                                <a class="nav-sub-link" href="auditoria.html">Auditoria</a>
                            </li>
                            <li class="nav-sub-item">
                                <a class="nav-sub-link" href="auditoriaeventos.html">Auditoria de eventos</a>
                            </li>

                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link with-sub" href="#"><i class="fe fe-map-pin sidemenu-icon"></i><span class="sidemenu-label">Ficha Clinica</span><i class="angle fe fe-chevron-right"></i></a>
                        <ul class="nav-sub">
                            <li class="nav-sub-item">
                                <a class="nav-sub-link" href="pacientes.php">Ficha Pacientes</a>
                            </li>
                            <li class="nav-sub-item">
                                <a class="nav-sub-link" href="registropacientes.php">Registro Pacientes</a>
                            </li>
                            <li class="nav-sub-item">
                                <a class="nav-sub-link" href="listadopacientes.php">Listado Pacientes</a>
                            </li>

                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link with-sub" href="#"><i class="fe fe-layout sidemenu-icon"></i><span class="sidemenu-label">Medico</span><i class="angle fe fe-chevron-right"></i></a>
                        <ul class="nav-sub">
                            <li class="nav-sub-item">
                                <a class="nav-sub-link" href="pacientesmedico.html">Ficha Pacientes</a>
                            </li>
                            <li class="nav-sub-item">
                                <a class="nav-sub-link" href="consultas.html">Consultas</a>
                            </li>
                            <li class="nav-sub-item">
                                <a class="nav-sub-link" href="recetas.html">Recetas Emitidas</a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link with-sub" href="#"><i class="fe fe-layout sidemenu-icon"></i><span class="sidemenu-label">Comité</span><i class="angle fe fe-chevron-right"></i></a>
                        <ul class="nav-sub">
                            <li class="nav-sub-item">
                                <a class="nav-sub-link" href="comite.php">Crear Comité</a>
                            </li>
                            <li class="nav-sub-item">
                                <a class="nav-sub-link" href="listadocomite.php">Listado de Comité</a>
                            </li>
                            <li class="nav-sub-item">
                                <a class="nav-sub-link" href="nombrecomite.php">Nombres de Comite</a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link with-sub" href="#"><i class="fe fe-box sidemenu-icon"></i><span class="sidemenu-label">Gestion de Usuarios</span><i class="angle fe fe-chevron-right"></i></a>
                        <ul class="nav-sub">
                            <li class="nav-sub-item">
                                <a class="nav-sub-link" href="profesiones.php">Registrar de profesiones</a>
                            </li>
                            <li class="nav-sub-item">
                                <a class="nav-sub-link" href="usuarios.php">Registrar Usuarios</a>
                            </li>
                            <li class="nav-sub-item">
                                <a class="nav-sub-link" href="activacion.php">Activación de Usuarios</a>
                            </li>

                        </ul>
                    </li>
                </ul>
            </div>
        </div>
        <!-- End Sidemenu -->

        <!-- Main Header-->
        <div class="main-header side-header sticky">
            <div class="container-fluid">
                <div class="main-header-left">
                    <a class="main-header-menu-icon" href="#" id="mainSidebarToggle"><span></span></a>
                </div>
                <div class="main-header-center">
                    <div class="responsive-logo">
                        <a href="index.php"><img src="assets/img/brand/dark-logo.png" class="mobile-logo" alt="logo"></a>
                        <a href="index.php"><img src="assets/img/brand/logo.png" class="mobile-logo-dark" alt="logo"></a>
                    </div>
                    <div class="input-group">
                        <div class="mt-0">
                            <form class="form-inline">
                                <div class="search-element">
                                    <input type="search" class="form-control header-search text-dark" readonly value="<?php echo $empresa->getRazonSocial(); ?>" aria-label="Search" tabindex="1">
                                    <button class="btn" type="submit">
                                        <i class="fa fa-"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="main-header-right">
                    <div class="dropdown d-md-flex">
                        <a class="nav-link icon full-screen-link fullscreen-button" href="">
                            <i class="fullscreen"><svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24">
                                    <path d="M0 0h24v24H0V0z" fill="none" />
                                    <path d="M5 15H3v4c0 1.1.9 2 2 2h4v-2H5v-4zM5 5h4V3H5c-1.1 0-2 .9-2 2v4h2V5zm14-2h-4v2h4v4h2V5c0-1.1-.9-2-2-2zm0 16h-4v2h4c1.1 0 2-.9 2-2v-4h-2v4zM12 9c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z" />
                                </svg></i>
                            <i class="exit-fullscreen"><svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24">
                                    <path d="M0 0h24v24H0V0z" fill="none" />
                                    <path d="M5 16h3v3h2v-5H5v2zm3-8H5v2h5V5H8v3zm6 11h2v-3h3v-2h-5v5zm2-11V5h-2v5h5V8h-3z" />
                                </svg></i>
                        </a>
                    </div>
                    <div class="dropdown main-profile-menu">
                        <a class="d-flex" href="">
                            <span class="main-img-user"><img alt="avatar" src="assets/img/users/9.jpg"></span>
                        </a>
                        <div class="dropdown-menu">
                            <div class="header-navheading">
                                <h6 class="main-notification-title">
                                    Administrador</h6>
                            </div>
                            <a class="dropdown-item" href="close.php">
                                <i class="fe fe-power"></i> Cerrar Sesíon
                            </a>
                        </div>
                    </div>
                    <button class="navbar-toggler navresponsive-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent-4" aria-controls="navbarSupportedContent-4" aria-expanded="false" aria-label="Toggle navigation">
                        <i class="fe fe-more-vertical header-icons navbar-toggler-icon"></i>
                    </button><!-- Navresponsive closed -->
                </div>
            </div>
        </div>
        <!-- End Main Header-->

        <!-- Mobile-header -->
        <div class="mobile-main-header">
            <div class="mb-1 navbar navbar-expand-lg  nav nav-item  navbar-nav-right responsive-navbar navbar-dark  ">
                <div class="collapse navbar-collapse" id="navbarSupportedContent-4">
                    <div class="d-flex order-lg-2 ml-auto">
                        <div class="dropdown">
                            <a class="nav-link icon full-screen-link fullscreen-button" href=""><i class="fullscreen"><svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24">
                                        <path d="M0 0h24v24H0V0z" fill="none" />
                                        <path d="M5 15H3v4c0 1.1.9 2 2 2h4v-2H5v-4zM5 5h4V3H5c-1.1 0-2 .9-2 2v4h2V5zm14-2h-4v2h4v4h2V5c0-1.1-.9-2-2-2zm0 16h-4v2h4c1.1 0 2-.9 2-2v-4h-2v4zM12 9c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z" />
                                    </svg></i>
                                <i class="exit-fullscreen"><svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24">
                                        <path d="M0 0h24v24H0V0z" fill="none" />
                                        <path d="M5 16h3v3h2v-5H5v2zm3-8H5v2h5V5H8v3zm6 11h2v-3h3v-2h-5v5zm2-11V5h-2v5h5V8h-3z" />
                                    </svg></i>
                            </a>
                        </div>
                        <div class="dropdown main-profile-menu">
                            <a class="d-flex" href="#">
                                <span class="main-img-user"><img alt="avatar" src="assets/img/users/9.jpg"></span>
                            </a>
                            <div class="dropdown-menu">
                                <div class="header-navheading">
                                    <h6 class="main-notification-title">Administrador</h6>
                                </div>

                                <a class="dropdown-item" href="close.php">
                                    <i class="fe fe-power"></i> Cerrar Sesión
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Mobile-header closed -->

        <!-- Main Content-->
        <div class="main-content side-content pt-0">

            <div class="container-fluid">
                <div class="inner-body">


                    <!-- Page Header -->
                    <div class="page-header">
                        <div class="page-header-1">
                            <h1 class="main-content-title tx-30">Registrar Consultas</h1>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
                            </ol>
                        </div>
                    </div>
                    <!--End Footer-->
                    <input type="hidden" id="idEmpresa" value="<?php echo $empresa->getId(); ?>">
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12">
                            <div class="card transcation-crypto1" id="transcation-crypto1">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3">
                                            Medico:
                                            <select name="idUsuario" id="idUsuario" class='select2 form-control' onchange="sessionReserva()">
                                                <option value="0">Seleccione un Medico</option>
                                                <?php
                                                $medicos = $c->listarusuario($empresa->getId());
                                                foreach ($medicos as $medico) {
                                                    if (isset($_SESSION['MED_ID'])) {
                                                        if ($_SESSION['MED_ID'] == $medico->getId()) {
                                                            echo "<option value='" . $medico->getId() . "' selected>" . $medico->getNombre() . " " . $medico->getApellido1() . " " . $medico->getApellido2() . "</option>";
                                                        } else {
                                                            echo "<option value='" . $medico->getId() . "'>" . $medico->getNombre() . " " . $medico->getApellido1() . " " . $medico->getApellido2() . "</option>";
                                                        }
                                                    } else {
                                                        echo "<option value='" . $medico->getId() . "'>" . $medico->getNombre() . " " . $medico->getApellido1() . " " . $medico->getApellido2() . "</option>";
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            Hospital:
                                            <?php echo $empresa->getRazonSocial(); ?>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <!-- Row -->
                                            <div class="card">
                                                <div class="row no-gutters">
                                                    <div class="col-lg-12">
                                                        <div class="main-content-body main-content-body-calendar card-body border-left">
                                                            <div class="main-calendar" id="calendar"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Main Content-->

        <!-- Main Footer-->
        <div class="main-footer text-center">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <span>Copyright © 2022 - KaiserTech Todos los derechos reservados.</span>
                    </div>
                </div>
            </div>
        </div>

        <div aria-hidden="true" class="modal main-modal-calendar-event" id="modalCalendarEvent" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header justify-content-between align-items-center">
                        <p class="text-white fs-20"><?php $medic = $c->buscarenUsuario1($_SESSION['MED_ID']);
                                                    echo "Medico: " . $medic->getNombre() . " " . $medic->getApellido1() . " " . $medic->getApellido2();
                                                    ?></p>
                        <p class="event-title text-start"></p>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <input type="hidden" id="event-id">
                            <div class="col-sm-12">
                                <p class="m-0 fs-18">Horas Disponibles</p>
                                <p class="horario d-flex gap-1 flex-wrap"></p>
                            </div>
                            <hr>
                            <div class="row">
                                <!--Tipo Identificacion-->
                                <div class="col-lg-3">
                                    <div class="form-group has-success mg-b-0">
                                        <label>Tipo Identificacion:</label>
                                        <select class="form-control" id="tipoidentificacion" onchange="checktipo(this)" name="tipoidentificacion" required="">
                                            <option value="1">RUN</option>
                                            <option value="2">Sin RUN</option>
                                            <option value="3">Pasaporte</option>
                                            <option value="4">Indentificación de Su País</option>
                                        </select>
                                    </div>
                                </div>
                                <!--Rut paciente-->
                                <div class="col-lg-3 rut">
                                    <div class="form-group has-success mg-b-0">
                                        <label>RUN Paciente:</label>
                                        <input class="form-control" id="rut" name="rut" onkeyup="formatRut(this), buscarpacienterun(this)" placeholder="11.111.111-1" required="" type="text" value="">
                                    </div>
                                </div>
                                <!--Pasaporte-->
                                <div class="col-lg-3 d-none idotro">
                                    <div class="form-group has-success mg-b-0">
                                        <label>Pasaporte/DNI/NIE:</label>
                                        <input class="form-control" id="documentoadd" onkeyup="buscarpacientepasaporte(this)" name="documentoadd" placeholder="Pasaporte/DNI/NIE" type="text" value="">
                                    </div>
                                </div>
                                <div class="col-md-12 details">

                                </div>

                            </div>
                        </div>
                        <hr>
                        <div class="row justify-content-end">
                            <div class="col-md-12 d-flex justify-content-end gap-2">
                            <button class="btn btn-outline-success" id="btnReservar" onclick="reservar()"><i class="fa fa-calendar"></i> Reservar</button>
                            <p class="event-desc tx-gray-900"></p><a class="btn btn-secondary" data-dismiss="modal" href=""><i class="fa fa-times"></i> Cerrar</a>
                        
                            </div>
                            </div>

                    </div>
                </div>
            </div>

        </div>
        <!-- End Page -->

        <!-- Back-to-top -->
        <a href="#top" id="back-to-top"><i class="fe fe-arrow-up"></i></a>

        <!-- Jquery js-->
        <script src="assets/plugins/jquery/jquery.min.js"></script>

        <!-- Bootstrap js-->
        <script src="assets/plugins/bootstrap/js/popper.min.js"></script>
        <script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>
        <!-- Moment js-->
        <script src="assets/plugins/moment/min/moment.min.js"></script>

        <!-- Datepicker js-->
        <script src="assets/plugins/jquery-ui/ui/widgets/datepicker.js"></script>

        <!-- Perfect-scrollbar js -->
        <script src="assets/plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>

        <!-- Select2 js-->
        <script src="assets/plugins/select2/js/select2.min.js"></script>
        <script src="assets/js/select2.js"></script>

        <!-- Sidemenu js -->
        <script src="assets/plugins/sidemenu/sidemenu.js"></script>

        <!-- Sidebar js -->
        <script src="assets/plugins/sidebar/sidebar.js"></script>
        <!-- Sticky js -->
        <script src="assets/js/sticky.js"></script>
        <!-- Custom js -->
        <script src="assets/js/custom.js"></script>

        <script src='assets/plugins/fullcalendar/moment-es.min.js'></script>
        <script src='assets/plugins/fullcalendar/fullcalendar.min.js'></script>
        <script src="JsFunctions/Alert/toastify.js"></script>
        <script src="JsFunctions/Alert/sweetalert2.all.min.js"></script>
        <script src="JsFunctions/Alert/alert.js"></script>
        <script src="JsFunctions/function.js"></script>
        <script src="JsFunctions/Alert/loader.js"></script>
        <script src="JsFunctions/validation.js"></script>
        <script src="JsFunctions/reservas.js"></script>
        <script>
            // sample calendar events data 
            'use strict'
            var curYear = moment().format('YYYY');
            var curMonth = moment().format('MM');
            // Calendar Event Source
            var sptCalendarEvents = {
                color: '#000',
                id: 1,
                events: [<?php
                            if (isset($_SESSION['MED_ID'])) {
                                $id = $_SESSION['MED_ID'];
                                $empresa = $empresa->getId();
                                $disponibilidad = $c->buscardisponibilidad($id, $empresa);
                                $cantidad = count($disponibilidad);
                                $posicion = 0;
                                foreach ($disponibilidad as $d) {
                                    $fecha = $d->getFecha();
                                    $horaInicio = $d->getHoraInicio();
                                    $horaFin = $d->getHoraFin();
                                    $intervalo = $d->getIntervalo();
                                    if ($d->getEstado() == 1) {
                                        if ($posicion == $cantidad - 1) {
                                            echo "{id:'" . $d->getId() . "',start:'" . $fecha . "T" . $horaInicio . "',end:'" . $fecha . "T" . $horaFin . "',title:'Agenda de Atención',backgroundColor:'#2E64FE', color:'#214fbe',borderColor:'#2E64FE',description:'Disponible',intervalo:'" . $intervalo . "'}";
                                        } else {
                                            //Disponible
                                            echo "{id:'" . $d->getId() . "',start:'" . $fecha . "T" . $horaInicio . "',end:'" . $fecha . "T" . $horaFin . "',title:'Agenda de Atención',backgroundColor:'#2E64FE', Color:'#214fbe',borderColor:'#2E64FE',description:'Disponible',intervalo:'" . $intervalo . "'},";
                                        }
                                    } else if ($d->getEstado() == 2) {
                                        //Reservado
                                        if ($posicion == $cantidad - 1) {
                                            echo "{id:'" . $d->getId() . "',start:'" . $fecha . "T" . $horaInicio . "',end:'" . $fecha . "T" . $horaFin . "',title:'Agenda de Atención',backgroundColor:'#088A29',borderColor:'#088A29',description:'Reservada'}";
                                        } else {
                                            echo "{id:'" . $d->getId() . "',start:'" . $fecha . "T" . $horaInicio . "',end:'" . $fecha . "T" . $horaFin . "',title:'Agenda de Atención',backgroundColor:'#088A29',borderColor:'#088A29',description:'Reservada'},";
                                        }
                                    } else if ($d->getEstado() == 3) {
                                        if ($posicion == $cantidad - 1) {
                                            //Cancelado
                                            echo "{id:'" . $d->getId() . "',start:'" . $fecha . "T" . $horaInicio . "',end:'" . $fecha . "T" . $horaFin . "',title:'Agenda de Atención',backgroundColor:'#e54d26',borderColor:'#e54d26',description:'Cancelada'}";
                                        } else {
                                            //Cancelado
                                            echo "{id:'" . $d->getId() . "',start:'" . $fecha . "T" . $horaInicio . "',end:'" . $fecha . "T" . $horaFin . "',title:'Agenda de Atención',backgroundColor:'#424242',borderColor:'#424242',description:'Cancelada'},";
                                        }
                                    }
                                }
                            }
                            ?>]
            };
            // Birthday Events Source
            var sptBirthdayEvents = {
                id: 2,
                backgroundColor: '#e54d26',
                borderColor: '#e54d26',
                events: []
            };
            var sptHolidayEvents = {
                id: 3,
                backgroundColor: '#FF8000',
                borderColor: '#FF8000',
                events: [<?php
                            $diasferiados = $c->listardiasferiados();
                            foreach ($diasferiados as $df) {
                                $fecha = $df->getFecha();
                                echo "{id:'" . $df->getId() . "',start:'" . $fecha . "T00:00:00',end:'" . $fecha . "T23:59:59',title:'" . $df->getDescripcion() . "',description:'Feriado'},";
                            }
                            ?>]
            };
            var sptOtherEvents = {
                id: 4,
                backgroundColor: 'rgb(38, 156 ,142)',
                borderColor: 'rgb(38, 156 ,142)',
                events: []
            };
        </script>
        <script>
            $(function() {

                // Datepicker found in left sidebar of the page
                var highlightedDays = ['2021-1-10', '2021-1-11', '2021-1-12', '2021-1-13', '2021-1-14', '2021-1-15', '2021-1-16'];
                var date = new Date();

                var generateTime = function(element) {
                    var n = 0,
                        min = 30,
                        periods = [' AM', ' PM'],
                        times = [],
                        hours = [12, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11];
                    for (var i = 0; i < hours.length; i++) {
                        times.push(hours[i] + ':' + n + n + periods[0]);
                        while (n < 60 - min) {
                            times.push(hours[i] + ':' + ((n += min) < 10 ? 'O' + n : n) + periods[0])
                        }
                        n = 0;
                    }
                    times = times.concat(times.slice(0).map(function(time) {
                        return time.replace(periods[0], periods[1])
                    }));
                    //console.log(times);
                    $.each(times, function(index, val) {
                        $(element).append('<option value="' + val + '">' + val + '</option>');
                    });
                }
                generateTime('.main-event-time');

                moment.locale('es');
                $('#calendar').fullCalendar({
                    header: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'month,agendaWeek,agendaDay,listWeek'
                    },
                    buttonText: {
                        today: 'Hoy',
                        month: 'Mes',
                        week: 'Semana',
                        day: 'Dia',
                        listWeek: 'Lista Semana'
                    },
                    monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
                        'Julio', 'Agosto', 'Septiembre', 'Octubre',
                        'Noviembre', 'Diciembre'
                    ],
                    editable: true,
                    droppable: true,
                    //NOmbre de los dias
                    dayNamesShort: ['Domingo', 'Lunes', 'Martes', 'Miercoles',
                        'Jueves', 'Viernes', 'Sabado'
                    ],
                    //Formato de fecha
                    formatDate: 'DD/MM/YYYY',
                    //Formato de hora
                    timeFormat: 'HH:mm',
                    titleFormat: 'DD MMMM YYYY',
                    //Formato de los dias de la semana en el titulo
                    columnFormat: 'ddd',
                    //Formato de los dias del mes
                    dayOfMonthFormat: 'dddd DD/MM',
                    //Formato de los eventos del dia
                    eventFormat: 'HH:mm',
                    //Formato de los eventos del dia
                    displayEventTime: true,
                    //No events to display
                    noEventsMessage: 'No hay eventos para mostrar',


                    contentHeight: 480,
                    firstDay: 1,
                    defaultView: 'month',

                    allDayText: 'All Day',
                    views: {
                        agenda: {
                            columnHeaderHtml: function(mom) {
                                return '<span>' + mom.format('ddd') + '</span>' + '<span>' + mom.format('DD') + '</span>';
                            }
                        },
                        day: {
                            columnHeader: false
                        },
                        listMonth: {
                            listDayFormat: 'ddd DD',
                            listDayAltFormat: false
                        },
                        listWeek: {
                            listDayFormat: 'ddd DD',
                            listDayAltFormat: false
                        },
                        agendaThreeDay: {
                            type: 'agenda',
                            duration: {
                                days: 3
                            },
                            titleFormat: 'MMMM YYYY'
                        }
                    },
                    eventSources: [sptCalendarEvents, sptBirthdayEvents, sptHolidayEvents, sptOtherEvents],
                    eventAfterAllRender: function(view) {
                        if (view.name === 'listMonth' || view.name === 'listWeek') {
                            var dates = view.el.find('.fc-list-heading-main');
                            dates.each(function() {
                                var text = $(this).text().split(' ');
                                var now = moment().format('DD');
                                $(this).html(text[0] + '<span>' + text[1] + '</span>');
                                if (now === text[1]) {
                                    $(this).addClass('now');
                                }
                            });
                        }
                    },
                    eventRender: function(event, element) {
                        if (event.description) {
                            element.find('.fc-list-item-title').append('<span class="fc-desc">' + event.description + '</span>');
                            element.find('.fc-content').append('<span class="fc-desc">' + event.description + '</span>');
                        }
                        var eBorderColor = (event.source.borderColor) ? event.source.borderColor : event.borderColor;
                        element.find('.fc-list-item-time').css({
                            color: eBorderColor,
                            borderColor: eBorderColor
                        });
                        element.find('.fc-list-item-title').css({
                            borderColor: eBorderColor
                        });
                        element.css('borderLeftColor', eBorderColor);
                    },
                });
                var azCalendar = $('#calendar').fullCalendar('getCalendar');
                // change view to week when in tablet
                if (window.matchMedia('(min-width: 576px)').matches) {
                    azCalendar.changeView('month');
                }
                // change view to month when in desktop
                if (window.matchMedia('(min-width: 992px)').matches) {
                    azCalendar.changeView('month');
                }
                // change view based in viewport width when resize is detected
                azCalendar.option('windowResize', function(view) {
                    if (view.name === 'listWeek') {
                        if (window.matchMedia('(min-width: 992px)').matches) {
                            azCalendar.changeView('month');
                        } else {
                            azCalendar.changeView('listWeek');
                        }
                    }
                });
                // display current date
                var azDateNow = azCalendar.getDate();
                azCalendar.option('select', function(startDate, endDate) {
                    $('#modalSetSchedule').modal('show');
                    $('#mainEventStartDate').val(startDate.format('LL'));
                    $('#EventEndDate').val(endDate.format('LL'));
                    $('#mainEventStartTime').val(startDate.format('LT')).trigger('change');
                    $('#EventEndTime').val(endDate.format('LT')).trigger('change');
                    $('#mainEventStartTime1').val(startDate.format('LT')).trigger('change');
                    $('#EventEndTime1').val(endDate.format('LT')).trigger('change');
                    $('#mainEventStartTime2').val(startDate.format('LT')).trigger('change');
                    $('#EventEndTime2').val(endDate.format('LT')).trigger('change');
                    $('#mainEventStartTime3').val(startDate.format('LT')).trigger('change');
                    $('#EventEndTime3').val(endDate.format('LT')).trigger('change');
                });
                // Display calendar event modal
                azCalendar.on('eventClick', function(calEvent, jsEvent, view) {
                    if (calEvent.description == 'Disponible') {
                        var modal = $('#modalCalendarEvent');
                        modal.modal('show');
                        modal.find('.event-title').text("Agenda de Atención " + moment(calEvent.start).format('DD MMMM YYYY') + " " + moment(calEvent.start).format('LT') + " - " + moment(calEvent.end).format('LT'));
                        modal.find('#event-id').val(calEvent.id);
                        modal.find('.modal-header').css('backgroundColor', (calEvent.source.borderColor) ? calEvent.source.borderColor : calEvent.borderColor);
                        cargarHorario(calEvent.id);


                    } else if (calEvent.description == 'Feriado') {

                    } else {
                        ToastifyError("La Hora " + calEvent.start.format('LT') + " - " + calEvent.end.format('LT') + " Ha sido " + calEvent.description);
                    }
                });
                // Enable/disable calendar events from displaying in calendar
                $('.main-nav-calendar-event a').on('click', function(e) {
                    e.preventDefault();
                    if ($(this).hasClass('exclude')) {
                        $(this).removeClass('exclude');
                        $(this).is(':first-child') ? azCalendar.addEventSource(sptCalendarEvents) : '';
                        $(this).is(':nth-child(2)') ? azCalendar.addEventSource(sptBirthdayEvents) : '';
                        $(this).is(':nth-child(3)') ? azCalendar.addEventSource(sptHolidayEvents) : '';
                        $(this).is(':nth-child(4)') ? azCalendar.addEventSource(sptOtherEvents) : '';
                    } else {
                        $(this).addClass('exclude');
                        $(this).is(':first-child') ? azCalendar.removeEventSource(1) : '';
                        $(this).is(':nth-child(2)') ? azCalendar.removeEventSource(2) : '';
                        $(this).is(':nth-child(3)') ? azCalendar.removeEventSource(3) : '';
                        $(this).is(':nth-child(4)') ? azCalendar.removeEventSource(4) : '';
                    }
                    azCalendar.render();
                    if (window.matchMedia('(max-width: 575px)').matches) {
                        $('body').removeClass('main-content-left-show');
                    }
                });

            })
        </script>



</body>

</html>