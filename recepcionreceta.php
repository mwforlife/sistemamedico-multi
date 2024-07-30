<?php
require 'php/validation/config.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require 'php/controller.php';
$c = new Controller();

session_start();
$empresa = null;
$idempresa = 1;
if (isset($_SESSION['CURRENT_ENTERPRISE'])) {
	$enterprise = $_SESSION['CURRENT_ENTERPRISE'];
	$empresa = $c->buscarEmpresa($enterprise);
	$idempresa = $empresa->getId();
}
if (!isset($_SESSION['USER_ID'])) {
	header("Location: signin.php");
} else {
	$valid  = $c->validarsesion($_SESSION['USER_ID'], $_SESSION['USER_TOKEN']);
	if ($valid == false) {
		header("Location: lockscreen.php");
	}
}
$idempresa = $_SESSION['CURRENT_ENTERPRISE'];
$id = $_SESSION['USER_ID'];
$object = $c->buscarenUsuario1($id);
$object1 = $c->buscarenUsuarioValores($id, $idempresa);

$admingeneralrol = false;
$adminsistemarol = false;
$adminempresarol = false;
$suupervisorrol = false;
$medicorol = false;
$definicionescomiterol = false;
$definicionesgeneralesrol = false;
$definicionesempresarol = false;
$auditoriarol = false;
$reservasrol = false;
$fichaclinicarol = false;
$comiterol = false;
$usersrol = false;
if (isset($_SESSION['CURRENT_ENTERPRISE'])) {
	if ($c->validarroladmin($object->getId()) == true) {
		$admingeneralrol = true;
	}
	$idempresa = $_SESSION['CURRENT_ENTERPRISE'];
	$roles = $c->BuscarRolesUsuarioEmpresa1($idempresa, $id);
	foreach ($roles as $rol) {
		if ($rol->getNombre() == 1) {
			$admingeneralrol = true;
		}
		if ($rol->getNombre() == 2) {
			$adminsistemarol = true;
		}
		if ($rol->getNombre() == 3) {
			$adminempresarol = true;
		}
		if ($rol->getNombre() == 4) {
			$suupervisorrol = true;
		}
		if ($rol->getNombre() == 5) {
			$medicorol = true;
		}
		if ($rol->getNombre() == 6) {
			$definicionescomiterol = true;
		}
		if ($rol->getNombre() == 7) {
			$definicionesgeneralesrol = true;
		}
		if ($rol->getNombre() == 8) {
			$definicionesempresarol = true;
		}
		if ($rol->getNombre() == 9) {
			$auditoriarol = true;
		}
		if ($rol->getNombre() == 10) {
			$reservasrol = true;
		}
		if ($rol->getNombre() == 11) {
			$fichaclinicarol = true;
		}
		if ($rol->getNombre() == 12) {
			$comiterol = true;
		}
		if ($rol->getNombre() == 13) {
			$usersrol = true;
		}
	}
} else {
	if ($c->validarroladmin($object->getId()) == true) {
		$admingeneralrol = true;
	}
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
	<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
	<meta http-equiv="Pragma" content="no-cache" />
	<meta http-equiv="Expires" content="0" />
	<meta charset="utf-8">
	<meta content="width=device-width, initial-scale=1, shrink-to-fit=no" name="viewport">
	<meta name="description" content="">
	<meta name="author" content="">
	<meta name="keywords" content="">

	<!-- Favicon -->
	<link rel="icon" href="assets/img/brand/favicon.ico" type="image/x-icon" />

	<!-- Title -->
	<title>OncoWay | Recepción de Recetas</title>

	<!-- Bootstrap css-->
	<link href="assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" />

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

	<!-- Select2 css -->
	<link href="assets/plugins/select2/css/select2.min.css" rel="stylesheet">

	<!-- Internal DataTables css-->
	<link href="assets/plugins/datatable/dataTables.bootstrap4.min.css" rel="stylesheet" />
	<link href="assets/plugins/datatable/responsivebootstrap4.min.css" rel="stylesheet" />
	<link href="assets/plugins/datatable/fileexport/buttons.bootstrap4.min.css" rel="stylesheet" />

	<!-- Sidemenu css-->
	<link href="assets/css/sidemenu/sidemenu.css" rel="stylesheet">

	<link rel="stylesheet" href="JsFunctions/Alert/loader.css">
	<script src="JsFunctions/Alert/loader.js"></script>
	<style>
		.select2-selection {
			width: 100% !important;
		}
	</style>

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
					<?php 
						if($admingeneralrol == true || $adminsistemarol == true || $adminempresarol == true || $suupervisorrol == true || $definicionescomiterol == true || $definicionesgeneralesrol == true){
					?>
					<li class="nav-header"><span class="nav-label">Dashboard</span></li>
					<?php
						if($admingeneralrol == true || $adminsistemarol == true || $definicionescomiterol == true){
					?>
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
					<?php
						}
						if($admingeneralrol == true || $adminsistemarol == true || $adminempresarol == true || $suupervisorrol == true || $definicionesgeneralesrol == true){
					?>
					<li class="nav-item">
						<a class="nav-link with-sub" href="#"><i class="fe fe-home sidemenu-icon"></i><span class="sidemenu-label">Definiciones Generales</span><i class="angle fe fe-chevron-right"></i></a>
						<ul class="nav-sub">
						<?php
						}
							if($admingeneralrol == true || $adminsistemarol == true || $definicionesgeneralesrol == true){
							?>
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
								<a class="nav-sub-link" href="medicamentos.php">Medicamentos</a>
							</li>
							<?php
								}
								if($admingeneralrol == true || $adminsistemarol == true || $adminempresarol == true || $suupervisorrol == true || $definicionesgeneralesrol == true){
							?>
							<li class="nav-sub-item">
								<a class="nav-sub-link" href="esquema.php">Esquema</a>
							</li>
							<?php
								}
								if($admingeneralrol == true || $adminsistemarol == true || $definicionesgeneralesrol == true){
							?>
							<li class="nav-sub-item">
								<a class="nav-sub-link" href="diasferiados.php">DIAS FERIADOS</a>
							</li>
							<?php
								}
							?>
						</ul>
					</li>
					<?php
						}
						
					?>
					<li class="nav-header"><span class="nav-label">FUNCIONES</span></li>
					<!--------------------------Inicio Empresa--------------------------->
					<?php
						if($admingeneralrol == true || $adminsistemarol == true || $adminempresarol == true){
					?>
					<li class="nav-item">
						<a class="nav-link with-sub" href="#"><i class="fe fe-message-square sidemenu-icon"></i><span class="sidemenu-label">Empresas</span><i class="angle fe fe-chevron-right"></i></a>
						<ul class="nav-sub">
							<li class="nav-sub-item">
								<a class="nav-sub-link" href="empresas.php">Registro de Empresas</a>
							</li>
						</ul>
					</li>
					<?php
						}
					?>
					<!--------------------------Fin Empresa--------------------------->

					<!--------------------------Inicio Agenda--------------------------->
					<li class="nav-item">
						<a class="nav-link" href="agenda.php"><i class="fe fe-calendar sidemenu-icon"></i><span class="sidemenu-label">Agenda</span></a>
					</li>
					<?php
						if($admingeneralrol == true || $adminsistemarol == true || $reservasrol == true){
					?>
					<!--------------------------Inicio Reservas--------------------------->
					<li class="nav-item">
						<a class="nav-link" href="reservas.php"><i class="fe fe-calendar sidemenu-icon"></i><span class="sidemenu-label">Reservas</span></a>
					</li>
					<!--------------------------Inicio Atencion--------------------------->
					<li class="nav-item">
						<a class="nav-link" href="atencion.php"><i class="fe fe-user sidemenu-icon"></i><span class="sidemenu-label">Atención</span></a>
					</li>
					<!--------------------------Fin Atencion--------------------------->
					<!--------------------------Inicio Tratamiento--------------------------->
					<?php
						}
						if($admingeneralrol == true || $adminsistemarol == true || $gestiontratamientorol == true){
					?>
					<li class="nav-item">
						<a class="nav-link with-sub" href="#"><i class="fa fa-user-md sidemenu-icon"></i>
						<span class="sidemenu-label">Gestión de tratamiento</span>
						<i class="angle fe fe-chevron-right"></i></a>
						<ul class="nav-sub">
							<li class="nav-sub-item">
								<a class="nav-sub-link" href="recepcionreceta.php">Recepción de Receta</a>
							</li>
							<li class="nav-sub-item">
								<a class="nav-sub-link" href="listadeespera.php">Paciente en Lista de Espera</a>
							</li>
							<li class="nav-sub-item">
								<a class="nav-sub-link" href="programacionatenciones.php">Programación de Atenciones</a>
							</li>
							<li class="nav-sub-item">
								<a class="nav-sub-link" href="preparacionfarmacia.php">Preparación Farmacia</a>
							</li>
							<li class="nav-sub-item">
								<a class="nav-sub-link" href="recepcionfarmacia.php">Recepción Farmacia</a>
							</li>
							<li class="nav-sub-item">
								<a class="nav-sub-link" href="recepciondroga.php">Recepción Droga</a>
							</li>
							<li class="nav-sub-item">
								<a class="nav-sub-link" href="quimioterapia.php">quimioterapia</a>
							</li>
						</ul>
					</li>
					<?php
						}
					?>
					<!--------------------------Fin Agenda--------------------------->

					
					<?php
						if($admingeneralrol == true || $adminsistemarol == true || $auditoriarol == true){
					?>
					<!--------------------------Inicio Auditoria--------------------------->
					<li class="nav-item">
						<a class="nav-link with-sub" href="#"><i class="fe fe-droplet sidemenu-icon"></i><span class="sidemenu-label">Auditoria</span><i class="angle fe fe-chevron-right"></i></a>
						<ul class="nav-sub">
							<li class="nav-sub-item">
								<a class="nav-sub-link" href="auditoria.php">Auditoria</a>
							</li>
						</ul>
					</li>
					<!--------------------------Fin Auditoria--------------------------->
					<?php
						}
					?>


					<?php
						if($admingeneralrol == true || $adminsistemarol == true || $fichaclinicarol == true || $fichaclinicasecre == true){
					?>
					<!--------------------------Inicio Ficha Pacientes----------------->
					<li class="nav-item">
						<a class="nav-link with-sub" href="#"><i class="fe fe-map-pin sidemenu-icon"></i><span class="sidemenu-label">Ficha Clinica</span><i class="angle fe fe-chevron-right"></i></a>
						<ul class="nav-sub">
							<li class="nav-sub-item">
								<a class="nav-sub-link" href="pacientes.php">Ficha Pacientes</a>
							</li>
							<li class="nav-sub-item">
								<a class="nav-sub-link" href="registropacientes.php">Registro Pacientes</a>
							</li>
							<?php
								if($admingeneralrol == true || $adminsistemarol == true || $fichaclinicas == true){
							?>
							<li class="nav-sub-item">
								<a class="nav-sub-link" href="listadopacientes.php">Listado Pacientes</a>
							</li>
							<?php
								}
							?>

						</ul>
					</li>
					<!--------------------------Fin Ficha Pacientes----------------->
					<?php
						}
					?>


					<?php
						if($admingeneralrol == true || $adminsistemarol == true || $medicorol == true){
					?>
					<!--------------------------Inicio Consulta Medica----------------->
					<li class="nav-item">
						<a class="nav-link with-sub" href="#"><i class="fe fe-layout sidemenu-icon"></i><span class="sidemenu-label">Medico</span><i class="angle fe fe-chevron-right"></i></a>
						<ul class="nav-sub">
							<li class="nav-sub-item">
								<a class="nav-sub-link" href="pacientesmedico.php">Ficha Pacientes</a>
							</li>
							<li class="nav-sub-item">
								<a class="nav-sub-link" href="consultas.php">Consultas</a>
							</li>
							<li class="nav-sub-item">
								<a class="nav-sub-link" href="recetasemitidas.php">Recetas Emitidas</a>
							</li>
						</ul>
					</li>
					<!--------------------------Fin Consulta Medica----------------->
					<?php
						}
					?>


					<?php
						if($admingeneralrol == true || $adminsistemarol == true || $comiterol == true){
					?>
					<!--------------------------Inicio Comite----------------->
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
					<!--------------------------Fin Comite----------------->
					<?php
						}
						?>

					
					<?php
						if($admingeneralrol == true || $adminsistemarol == true || $usersrol == true){
					?>
					<!--------------------------Inicio Usuarios----------------->
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
					<!--------------------------Fin Usuarios----------------->
					<?php
						}
					?>
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
									<?php echo $object->getNombre() . " " . $object->getApellido1() . " " . $object->getApellido2(); ?></h6>
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
									<h6 class="main-notification-title"><?php echo $object->getNombre() . " " . $object->getApellido1() . " " . $object->getApellido2(); ?></h6>
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
							<h1 class="main-content-title tx-30">OncoWay</h1>
							<ol class="breadcrumb">
								<li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
							</ol>
						</div>
					</div>
					<!-- End Page Header -->
					<div class="row">

						<div class="col-xl-12 col-lg-12 col-md-12">
							<div class="card tran">
								<div class="card-header bd-b-0">
									<h4 class="card-title font-weight-semibold mb-0">Recepción</h4>
								</div>
								<div class="card-body">
									<div class="">
										<div class="table-responsive">
											<table class="table w-100 text-nowrap" id="example1">
												<thead>
													<tr class='text-center'>
														<th>Folio</th>
														<th>Fecha</th>
														<th>Estado</th>
														<th>Examen Pendiente</th>
														<th>Rut</th>
														<th>Nombre</th>
														<th>Apellido 1</th>
														<th>Apellido 2</th>
														<th>Edad</th>
														<th>Diagnostico</th>
														<th>Tratamiento</th>
														<th>Receta</th>
														<th>Acción</th>
													</tr>
												</thead>
												<tbody>
													<?php
													$lista = $c->recetasbyempresaestado($idempresa, 1);
													foreach ($lista as $receta) {
														echo "<tr class='text-center'>";
														echo "<td>" . $receta['folio'] . "</td>";
														echo "<td>" . date("d-m-Y", strtotime($receta['fecha'])) . "</td>";
														echo "<td><span class='badge bg-primary text-white'>Emitida</span></td>";
														if ($receta['pendiente']) {
															echo "<td>Si</td>";
														} else {
															echo "<td>No</td>";
														}
														echo "<td>" . $receta['rut'] . "</td>";
														echo "<td>" . $receta['nombre'] . "</td>";
														echo "<td>" . $receta['apellido1'] . "</td>";
														echo "<td>" . $receta['apellido2'] . "</td>";
														echo "<td>" . $c->calcularEdad1($receta['fechanacimiento']) . "</td>";
														echo "<td>" . $receta['diagnostico'] . "</td>";
														echo "<td><button class='btn btn-outline-primary btn-sm' onclick='vertratamiento(".$receta['idconsulta'].")'><i class='fa fa-eye'></i></button></td>";
														echo "<td><a target='_blank' href='php/reporte/receta.php?r=" . $receta['id'] . "' class='btn btn-outline-primary btn-sm'><i class='fa fa-eye'></i></a></td>";
														echo "<td>";
														echo "<button class='btn m-1 btn-outline-success btn-sm' title='Aprobar Receta' onclick='aprobar(" . $receta['id'] . ")'><i class='fa fa-check'></i></button>";
														echo "<button class='btn m-1 btn-outline-danger btn-sm' title='Rechazar Receta' onclick='rechazar(" . $receta['id'] . ")'><i class='fa fa-times'></i></button>";
														echo "</td>";
														echo "</tr>";
													}
													?>

												</tbody>
											</table>
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
		<!-- Modal effects -->
		<div class="modal" id="modaltratamiento">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content modal-content-demo">
					<div class="modal-header">
						<h6 class="modal-title">Tratamiento</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
					</div>
					<div class="modal-body">
						<p id="tratamiento"></p>
					</div>
					<div class="modal-footer">
						<button class="btn ripple btn-secondary" data-dismiss="modal" type="button">Cerrar</button>
					</div>
				</div>
			</div>
		</div>

		<div class="modal" id="modalrechazo">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content modal-content-demo">
					<div class="modal-header">
						<h6 class="modal-title">Rechazar Receta</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
					</div>
					<div class="modal-body">
						<form id="formrechazo">
							<input type="hidden" name="idreceta" id="idreceta">
							<div class="row">
								<div class="col-md-12">
									<label for="">Motivo</label>
									<select name="motivo" id="motivo" class="form-control select2" required>
										<?php
										$motivos = $c->listarmotivorechazo();
										foreach ($motivos as $motivo) {
											echo "<option value='" . $motivo['id'] . "'>" . $motivo['nombre'] . "</option>";
										}
										?>
									</select>
								</div>
								<div class="col-md-12">
									<label for="">Observación</label>
									<textarea name="observacion" id="observacion" class="form-control" cols="30" rows="10" required></textarea>
								</div>
								<div class="col-md-12 text-right mt-4">
									<button class="btn btn-primary" type="submit"> <i class="fa fa-times"></i> Rechazar</button>
									<button class="btn ripple btn-secondary" data-dismiss="modal" type="button">Cerrar</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<!-- End Modal effects-->
		<!-- Main Footer-->
		<div class="main-footer text-center">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<span>Copyright © <?php echo date('Y') ?> - OncoWay Todos los derechos reservados.</span>
					</div>
				</div>
			</div>
		</div>
		<!--End Footer-->
	</div>
	<!-- End Page -->

	<!-- Back-to-top -->
	<a href="#top" id="back-to-top"><i class="fe fe-arrow-up"></i></a>

	<!-- Jquery js-->
	<script src="assets/plugins/jquery/jquery.min.js"></script>

	<!-- Bootstrap js-->
	<script src="assets/plugins/bootstrap/js/popper.min.js"></script>
	<script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>

	<!-- Internal Chart.Bundle js-->
	<script src="assets/plugins/chart.js/Chart.bundle.min.js"></script>

	<!-- Peity js-->
	<script src="assets/plugins/peity/jquery.peity.min.js"></script>

	<!--Internal Apexchart js-->
	<script src="assets/js/apexcharts.js"></script>

	<!-- Internal Data Table js -->
	<script src="assets/plugins/datatable/jquery.dataTables.min.js"></script>
	<script src="assets/plugins/datatable/dataTables.bootstrap4.min.js"></script>
	<script src="assets/js/table-data.js"></script>
	<script src="assets/plugins/datatable/dataTables.responsive.min.js"></script>
	<script src="assets/plugins/datatable/fileexport/dataTables.buttons.min.js"></script>
	<script src="assets/plugins/datatable/fileexport/buttons.bootstrap4.min.js"></script>


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
	<!-- Custom js -->
	<script src="assets/js/custom.js"></script>
	<script src="JsFunctions/Alert/toastify.js"></script>
	<script src="JsFunctions/Alert/sweetalert2.all.min.js"></script>
	<script src="JsFunctions/Alert/alert.js"></script>
	<script src="JsFunctions/recepcionreceta.js"></script>
</body>

</html>