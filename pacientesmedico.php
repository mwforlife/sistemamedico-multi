<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require 'php/controller.php';
$c = new Controller();

session_start();

// Obtener la URL de la página anterior (si está disponible)
$previous_page = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
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
$object = $c->buscarenUsuario($id, $empresa->getId());

$pacienteid = 0;
$paciente = null;
$inscripcion = null;
$ubicacion = null;
$otros = null;
$responsable = null;
if (isset($_GET['code'])) {
	$pacienteid = $_GET['code'];
	$pacienteid = $c->escapeString($pacienteid);

	$paciente = $c->buscarpaciente($pacienteid);
	$inscripcion = $c->listarinscripcionprevision($pacienteid);
	$ubicacion = $c->listardatosubicacion($pacienteid);
	$otros = $c->listarotrosantecedentes($pacienteid);
	$responsable = $c->listarresponsable($pacienteid);
}
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
	<title>OncoWay | Paciente</title>

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
								<a class="nav-sub-link" href="medicamentos.php">Medicamentos</a>
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
								<a class="nav-sub-link" href="auditoria.php">Auditoria</a>
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
									<input type="search" class="form-control header-search" placeholder="Search…" aria-label="Search" tabindex="1">
									<button class="btn" type="submit">
										<i class="fa fa-search"></i>
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
							<h1 class="main-content-title tx-30">Ficha Pacientes</h1>
							<ol class="breadcrumb">
								<li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
							</ol>
						</div>
					</div>
					<!-- End Page Header -->

					<div class="row  <?php if ($paciente != null) {
										echo 'd-none';
									} ?>">
						<div class="col-lg-12">
							<div class="card orverflow-hidden">
								<div class="card-body">
									<form id="diagcieoform" name="diagcieoform" class="needs-validation was-validated">
										<div class="row">
											<div class="col-lg-3">
												<div class="form-group has-success mg-b-0">
													<label>RUT:</label>
													<input class="form-control" id="rutsearch" onkeyup="formatRut(this), searchpaciente(this)" name="rutsearch" placeholder="11.111.111-1" type="text" maxlength="12">
												</div>
											</div>
										</div>
										<div class="row  datospaciente d-none">
											<div class="col-lg-3">
												<div class="form-group has-success mg-b-0">
													<label>Numero Ficha:</label>
													<input class="form-control" id="fichasearch" name="fichasearch" placeholder="N° Ficha" required="" type="number" value="">
												</div>
											</div>
											<div class="col-lg-3">
												<div class="form-group has-success mg-b-0">
													<label>Ubicacion:</label>
													<input class="form-control" id="ubicacionsearch" name="ubicacionsearch" placeholder="Ubicacion" required="" type="text" value="">
												</div>
											</div>
											<div class="col-lg-3">
												<div class="form-group has-success mg-b-0">
													<label>Pasaporte/DNI/NIE:</label>
													<input class="form-control" id="documentsearch" name="documentsearch" placeholder="Pasaporte" required="" type="text" value="">
												</div>
											</div>
											<div class="col-lg-3">
												<div class="form-group has-success mg-b-0">
													<label>Nacionalidad:</label>
													<input class="form-control" id="nacionalidadsearch" name="nacionalidadsearch" placeholder="Nacionalidad" required="" type="text" value="">
												</div>
											</div>
											<div class="col-lg-3">
												<div class="form-group has-success mg-b-0">
													<label>Nombre:</label>
													<input class="form-control" id="nombresearch" name="nombresearch" placeholder="Nombre" required="" type="text" value="">
												</div>
											</div>
											<div class="col-lg-3">
												<div class="form-group has-success mg-b-0">
													<label>Apellido Paterno:</label>
													<input class="form-control" id="apellidosearch" name="apellidosearch" placeholder="Primer Apellido" required="" type="text" value="">
												</div>
											</div>
											<div class="col-lg-3">
												<div class="form-group has-success mg-b-0">
													<label>Apellido Materno:</label>
													<input class="form-control" id="apellido1search" name="apellido1search" placeholder="Segundo Apellido" required="" type="text" value="">
												</div>
											</div>
											<div class="col-lg-3">
												<div class="form-group has-success mg-b-0">
													<label>Nombre Social:</label>
													<input class="form-control" id="nombresocialsearch" name="nombresocialsearch" placeholder="Nombre Social" required="" type="text" value="">
												</div>
											</div>
											<div class="col-lg-3">
												<div class="form-group has-success mg-b-0">
													<label>Edad:</label>
													<input class="form-control" id="edadsearch" name="edadsearch" placeholder="Edad" required="" type="text" value="">
												</div>
											</div>
											<div class="col-lg-3">
												<div class="form-group has-success mg-b-0">
													<label>Sexo:</label>
													<input class="form-control" id="sexosearch" name="sexosearch" placeholder="Sexo" required="" type="text" value="">
												</div>
											</div>
											<div class="col-lg-3">
												<div class="form-group has-success mg-b-0">
													<label>Prevision:</label>
													<input class="form-control" id="previsionsearch" name="previsionsearch" placeholder="Prevision" required="" type="text" value="">
												</div>
											</div>
											<div class="col-lg-3">
												<div class="form-group has-success mg-b-0">
													<label>Estado Afiliacion:</label>
													<input class="form-control" id="estadoafiliacionsearch" name="estadoafiliacionsearch" placeholder="Estado Afiliacion" required="" type="text" value="">
												</div>
											</div>
											<div class="col-lg-3">
												<div class="form-group has-success mg-b-0">
													<label>Dirección:</label>
													<input class="form-control" id="direccionsearch" name="direccionsearch" placeholder="Direccion" required="" type="text" value="">
												</div>
											</div>
											<div class="col-lg-3">
												<div class="form-group has-success mg-b-0">
													<label>Fonos Contacto:</label>
													<input class="form-control" id="fonosearch" name="fonosearch" placeholder="Fono Contacto" required="" type="text" value="">
												</div>
											</div>
											<div class="col-lg-3">
												<div class="form-group has-success mg-b-0">
													<label>Correo Electronico:</label>
													<input class="form-control" id="correosearch" name="correosearch" placeholder="Correo Electronico" required="" type="text" value="">
												</div>
											</div>
											<div class="col-lg-3">
												<div class="form-group has-success mg-b-0">
													<label>Inscrito:</label>
													<input class="form-control" id="inscritosearch" name="inscritosearch" placeholder="Inscrito" required="" type="text" value="">
												</div>
											</div>
											<div class="col-md-12 text-right mt-3">
												<hr>
											<button class="btn btn-outline-success" onclick="searchother()" type="button"><i class="fa fa-search"></i> Buscar Otro</button>
											<a href="pacientes.php?code=" class="btn btn-outline-success" id="btncargar"><i class="fa fa-user"></i> Cargar Ficha</a>

											</div>

										</div>
									</form>
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


	<!-- Internal lightslider js-->
	<script src="assets/plugins/lightslider/js/lightslider.min.js"></script>

	<!-- Internal navigation js-->
	<script src="assets/js/navigation.js"></script>

	<!-- Internal Clipboard js-->
	<script src="assets/plugins/clipboard/clipboard.min.js"></script>
	<script src="assets/plugins/clipboard/clipboard.js"></script>

	<!-- Internal Prism js-->
	<script src="assets/plugins/prism/prism.js"></script>

	<!-- Perfect-scrollbar js -->
	<script src="assets/plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>

	<!-- Select2 js-->
	<script src="assets/plugins/select2/js/select2.min.js"></script>
	<script src="assets/js/select2.js"></script>

	<!-- Sidemenu js -->
	<script src="assets/plugins/sidemenu/sidemenu.js"></script>

	<!-- Sidebar js -->
	<script src="assets/plugins/sidebar/sidebar.js"></script>
	<!-- Custom js -->
	<script src="assets/js/custom.js"></script>


	<!-- Sticky js -->
	<script src="assets/js/sticky.js"></script>

	<!-- Custom js -->
	<!-- Custom js -->
	<script src="assets/js/custom.js"></script>
	<script src="JsFunctions/Alert/toastify.js"></script>
	<script src="JsFunctions/Alert/sweetalert2.all.min.js"></script>
	<script src="JsFunctions/Alert/alert.js"></script>
	<script src="JsFunctions/validation.js"></script>
	<script src="JsFunctions/function.js"></script>

	<script>
		//Cargar Tabla
		$(document).ready(function() {
			cargarsignos();
			cargarmedidas();
            searchpaciente(document.getElementById('rutsearch'));
            console.log("cargado");
		});
	</script>


</body>

</html>