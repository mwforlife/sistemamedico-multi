<?php
require 'php/validation/config.php';
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
$fichaclinicasecre = false;
$gestiontratamientorol = false;
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
		if ($rol->getNombre() == 14) {
			$fichaclinicasecre = true;
		}
		if ($rol->getNombre() == 15) {
			$gestiontratamientorol = true;
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
					<?php
					if ($admingeneralrol == true || $adminsistemarol == true || $adminempresarol == true || $suupervisorrol == true || $definicionescomiterol == true || $definicionesgeneralesrol == true) {
					?>
						<li class="nav-header"><span class="nav-label">Dashboard</span></li>
						<?php
						if ($admingeneralrol == true || $adminsistemarol == true || $definicionescomiterol == true) {
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
						if ($admingeneralrol == true || $adminsistemarol == true || $adminempresarol == true || $suupervisorrol == true || $definicionesgeneralesrol == true) {
						?>
							<li class="nav-item">
								<a class="nav-link with-sub" href="#"><i class="fe fe-home sidemenu-icon"></i><span class="sidemenu-label">Definiciones Generales</span><i class="angle fe fe-chevron-right"></i></a>
								<ul class="nav-sub">
								<?php
							}
							if ($admingeneralrol == true || $adminsistemarol == true || $definicionesgeneralesrol == true) {
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
							if ($admingeneralrol == true || $adminsistemarol == true || $adminempresarol == true || $suupervisorrol == true || $definicionesgeneralesrol == true) {
								?>
									<li class="nav-sub-item">
										<a class="nav-sub-link" href="esquema.php">Esquema</a>
									</li>
								<?php
							}
							if ($admingeneralrol == true || $adminsistemarol == true || $definicionesgeneralesrol == true) {
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
						if ($admingeneralrol == true || $adminsistemarol == true || $adminempresarol == true) {
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
						if ($admingeneralrol == true || $adminsistemarol == true || $reservasrol == true) {
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
						if ($admingeneralrol == true || $adminsistemarol == true || $gestiontratamientorol == true) {
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
						if ($admingeneralrol == true || $adminsistemarol == true || $auditoriarol == true) {
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
						if ($admingeneralrol == true || $adminsistemarol == true || $fichaclinicarol == true || $fichaclinicasecre == true) {
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
									if ($admingeneralrol == true || $adminsistemarol == true || $fichaclinicas == true) {
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
						if ($admingeneralrol == true || $adminsistemarol == true || $medicorol == true) {
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
						if ($admingeneralrol == true || $adminsistemarol == true || $comiterol == true) {
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
						if ($admingeneralrol == true || $adminsistemarol == true || $usersrol == true) {
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
					<div class="input-group">
						<div class="mt-0">
							<form class="form-inline">
								<div class="search-element">

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
												<a href="registropoblacional.php?code=" class="btn btn-outline-success" id="btnregpob"><i class="fa fa-user"></i> Registro Poblacional</a>
												<a href="pacientes.php?code=" class="btn btn-outline-success" id="btncargar"><i class="fa fa-user"></i> Cargar Ficha</a>

											</div>

										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
					<!-- ROW-4 opened -->
					<div class="row fichapaciente <?php if ($paciente == null) {
														echo 'd-none';
													} ?>">
						<div class="col-xl-12 col-lg-12 col-md-12">
							<div class="card" id="tab">
								<div class="card-body">
									<div class="text-wrap">
										<div class="example">
											<div class="border">
												<div class="bg-light-1 nav-bg">
													<nav class="nav nav-tabs">
														<a class="nav-link active" data-toggle="tab" href="#tabCont1">Datos Basicos</a>
														<a class="nav-link" data-toggle="tab" href="#tabCont2">Grupo Familiar</a>
														<?php
														if ($admingeneralrol == true || $adminsistemarol == true || $fichaclinicarol == true) {
														?>
															<a class="nav-link" data-toggle="tab" href="#tabCont3">Historial Clinico</a>
															<a class="nav-link" data-toggle="tab" href="#tabCont4">Signos Vitales</a>
															<a class="nav-link" data-toggle="tab" href="#tabCont5">Medidas Antropométricas</a>
															<a class="nav-link" data-toggle="tab" href="#tabCont6">Registro Poblacional</a>
														<?php
														}
														?>
													</nav>
												</div>
												<div class="card-body tab-content">
													<div class="tab-pane active show" id="tabCont1">
														<!-- Row -->

														<div class="row">
															<div class="col-lg-12">
																<form id="formpaciente" name="formpaciente" class="needs-validation was-validated">
																	<div class="card">
																		<div class="card-body">
																			<div aria-multiselectable="true" class="accordion" id="accordion" role="tablist">
																				<div class="card">
																					<div class="card-header" id="headingOne" role="tab">
																						<a aria-controls="collapseOne" aria-expanded="true" data-toggle="collapse" href="#collapseOne">Datos Paciente</a>
																					</div>
																					<input type="hidden" id="idpaciente" name="idpaciente" value="<?php if ($paciente != null) {
																																						echo $paciente->getId();
																																					} else {
																																						echo 0;
																																					} ?>">
																					<div aria-labelledby="headingOne" class="collapse active show " data-parent="#accordion" id="collapseOne" role="tabpanel">
																						<div class="card-body">
																							<div class="row">
																								<!--Tipo Identificacion-->
																								<div class="col-lg-3">
																									<div class="form-group has-success mg-b-0">
																										<label>Tipo Identificacion:</label>
																										<select class="form-control" id="tipoidentificacion" onchange="checktipo(this)" name="tipoidentificacion" required="">
																											<option value="1" <?php if ($paciente != null) {
																																	if ($paciente->getTipoidentificacion() == 1) {
																																		echo 'selected';
																																	}
																																} ?>>RUN</option>
																											<option value="2" <?php if ($paciente != null) {
																																	if ($paciente->getTipoidentificacion() == 2) {
																																		echo 'selected';
																																	}
																																} ?>>Sin RUN</option>
																											<option value="3" <?php if ($paciente != null) {
																																	if ($paciente->getTipoidentificacion() == 3) {
																																		echo 'selected';
																																	}
																																} ?>>Pasaporte</option>
																											<option value="4" <?php if ($paciente != null) {
																																	if ($paciente->getTipoidentificacion() == 4) {
																																		echo 'selected';
																																	}
																																} ?>>Indentificación de Su País</option>
																										</select>
																									</div>
																								</div>
																								<!--Rut paciente-->
																								<div class="col-lg-3 rut <?php if ($paciente != null) {
																																if ($paciente->getTipoidentificacion() != 1) {
																																	echo 'd-none';
																																}
																															} ?>">
																									<div class="form-group has-success mg-b-0">
																										<label>RUN Paciente:</label>
																										<input class="form-control" id="rut" name="rut" onkeyup="formatRut(this)" placeholder="11.111.111-1" required="" type="text" value="<?php if ($paciente != null) {
																																																												echo $paciente->getRut();
																																																											}; ?>">
																									</div>
																								</div>
																								<!--Pasaporte-->
																								<div class="col-lg-3 idotro <?php if ($paciente != null) {
																																if ($paciente->getTipoidentificacion() == 1) {
																																	echo 'd-none';
																																}
																															} ?>">
																									<div class="form-group has-success mg-b-0">
																										<label>Pasaporte/DNI/NIE:</label>
																										<input class="form-control" id="documentoadd" name="documentoadd" placeholder="Pasaporte/DNI/NIE" type="text" value="<?php if ($paciente != null) {
																																																									echo $paciente->getIdentificacion();
																																																								} ?>">
																									</div>
																								</div>
																								<!--Nacionalidad-->
																								<div class="col-lg-3">
																									<div class="form-group has-success mg-b-0">
																										<label>Nacionalidad:</label>
																										<select class="form-control select2" id="nacionalidad" name="nacionalidad" required>
																											<?php
																											if ($paciente != null) {
																												$lista = $c->listarnacionalidad();
																												foreach ($lista as $object) {
																													if ($paciente->getNacionalidad() == $object->getId()) {
																														echo "<option value='" . $object->getId() . "' selected>" . $object->getNombre() . "</option>";
																													} else {
																														echo "<option value='" . $object->getId() . "'>" . $object->getNombre() . "</option>";
																													}
																												}
																											}
																											?>
																										</select>
																									</div>
																								</div>
																								<!--Pais Origen-->
																								<div class="col-lg-3">
																									<div class="form-group has-success mg-b-0">
																										<label>Pais Origen:</label>
																										<select class="form-control select2" id="paisorigen" name="paisorigen" required>
																											<?php
																											if ($paciente != null) {
																												$lista = $c->listarpaises();
																												foreach ($lista as $object) {
																													if ($paciente->getPaisorigen() == $object->getId()) {
																														echo "<option value='" . $object->getId() . "' selected>" . $object->getNombre() . "</option>";
																													} else {
																														echo "<option value='" . $object->getId() . "'>" . $object->getNombre() . "</option>";
																													}
																												}
																											}
																											?>
																										</select>
																									</div>
																								</div>
																								<!--Correo Electronico-->
																								<div class="col-lg-3">
																									<div class="form-group has-success mg-b-0">
																										<label>Correo Electronico:</label>
																										<input class="form-control" id="email" name="email" placeholder="Correo Electronico" type="email" value="<?php if ($paciente != null) {
																																																						echo $paciente->getEmail();
																																																					} ?>">
																									</div>
																								</div>
																								<!--Nombre-->
																								<div class="col-lg-3">
																									<div class="form-group has-success mg-b-0">
																										<label>Nombre:</label>
																										<input class="form-control" id="nombre" name="nombre" placeholder="Nombre" required="" type="text" value="<?php if ($paciente != null) {
																																																						echo $paciente->getNombre();
																																																					} ?>">
																									</div>
																								</div>
																								<!--Apellido Paterno-->
																								<div class="col-lg-3">
																									<div class="form-group has-success mg-b-0">
																										<label>Apellido Paterno:</label>
																										<input class="form-control" id="apellido1" name="apellido1" placeholder="Apellido Paterno" required="" type="text" value="<?php if ($paciente != null) {
																																																										echo $paciente->getApellido1();
																																																									} ?>">
																									</div>
																								</div>
																								<!--Apellido Materno-->
																								<div class="col-lg-3">
																									<div class="form-group has-success mg-b-0">
																										<label>Apellido Materno:</label>
																										<input class="form-control" id="apellido2" name="apellido2" placeholder="Apellido Materno" type="text" value="<?php if ($paciente != null) {
																																																							echo $paciente->getApellido2();
																																																						} ?>">
																									</div>
																								</div>
																								<!--Genero-->
																								<div class="col-lg-3">
																									<div class="form-group has-success mg-b-0">
																										<label>Genero:</label>
																										<select class="form-control select2" id="genero" name="genero" required>
																											<?php
																											if ($paciente != null) {
																												$lista = $c->listargenero();
																												foreach ($lista as $object) {
																													if ($paciente->getGenero() == $object->getId()) {
																														echo "<option value='" . $object->getId() . "' selected>" . $object->getNombre() . "</option>";
																													} else {
																														echo "<option value='" . $object->getId() . "'>" . $object->getNombre() . "</option>";
																													}
																												}
																											}
																											?>
																										</select>
																									</div>
																								</div>
																								<!--Estado Civil-->
																								<div class="col-lg-3">
																									<div class="form-group has-success mg-b-0">
																										<label>Estado Civil:</label>
																										<select class="form-control select2" id="estadocivil" name="estadocivil" required>
																											<?php
																											if ($paciente != null) {
																												$lista = $c->listarestadocivil();
																												foreach ($lista as $object) {
																													if ($paciente->getEstadocivil() == $object->getId()) {
																														echo "<option value='" . $object->getId() . "' selected>" . $object->getNombre() . "</option>";
																													} else {
																														echo "<option value='" . $object->getId() . "'>" . $object->getNombre() . "</option>";
																													}
																												}
																											}
																											?>
																										</select>
																									</div>
																								</div>
																								<!--Fecha Nacimiento-->
																								<div class="col-lg-3">
																									<div class="form-group has-success mg-b-0">
																										<label>Fecha Nacimiento:</label>
																										<input class="form-control" id="fechanacimiento" name="fechanacimiento" placeholder="Fecha Nacimiento" required="" type="date" value="<?php if ($paciente != null) {
																																																													echo $paciente->getFechanacimiento();
																																																												} ?>">
																									</div>
																								</div>
																								<!--Hora Nacimiento-->
																								<div class="col-lg-3">
																									<div class="form-group has-success mg-b-0">
																										<label>Hora Nacimiento:</label>
																										<input class="form-control" id="horanacimiento" name="horanacimiento" placeholder="Hora Nacimiento" type="time" value="<?php if ($paciente != null) {
																																																									echo $paciente->getHoranacimiento();
																																																								} ?>">
																									</div>
																								</div>
																								<!--Fono Movil-->
																								<div class="col-lg-3">
																									<div class="form-group has-success mg-b-0">
																										<label>Fono Movil:</label>
																										<input class="form-control" id="fonomovil" name="fonomovil" placeholder="Fono Movil" required="" type="text" value="<?php if ($paciente != null) {
																																																								echo $paciente->getFonomovil();
																																																							} ?>">
																									</div>
																								</div>
																								<!--Fono Fijo-->
																								<div class="col-lg-3">
																									<div class="form-group has-success mg-b-0">
																										<label>Fono Fijo:</label>
																										<input class="form-control" id="fonofijo" name="fonofijo" placeholder="Fono Fijo" type="text" value="<?php if ($paciente != null) {
																																																					echo $paciente->getFonofijo();
																																																				} ?>">
																									</div>
																								</div>
																								<!--Nombre Social-->
																								<div class="col-lg-3">
																									<div class="form-group has-success mg-b-0">
																										<label>Nombre Social:</label>
																										<input class="form-control" id="nombresocial" name="nombresocial" placeholder="Nombre Social" type="text" value="<?php if ($paciente != null) {
																																																								echo $paciente->getNombresocial();
																																																							} ?>">
																									</div>
																								</div>
																								<!--¿Funcionario?-->
																								<div class="col-lg-3">
																									<div class="form-group has-success mg-b-0">
																										<label>¿Funcionario?:</label><br />
																										<input id="funcionario" name="funcionario" type="checkbox" value="1" <?php if ($paciente != null) {
																																													if ($paciente->getFuncionario() == 1) {
																																														echo "checked";
																																													}
																																												} ?>>
																									</div>
																								</div>
																								<!--¿Discapacidad?-->
																								<div class="col-lg-3">
																									<div class="form-group has-success mg-b-0">
																										<label>¿Discapacidad?:</label><br />
																										<input id="discapacidad" name="discapacidad" type="checkbox"  onclick="checkdiscapacidad()" value="1" <?php if ($paciente != null) {if ($paciente->getDiscapacidad() == 1) {echo "checked";}} ?>>
																									</div>
																								</div>

																								<!--¿Discapacidad?-->
																								<div class="col-lg-6 discapacidad <?php if ($paciente != null) {if ($paciente->getDiscapacidad() != 1) {echo "d-none";}} ?>">
																									<div class="form-group has-success mg-b-0">
																										<label>Descripción Discapacidad</label>
																										<input class="form-control" id="descripciondiscapacidad" name="descripciondiscapacidad" placeholder="Descripción Discapacidad" type="text" value="<?php if ($paciente != null) {echo $paciente->getDiscapacidaddetalle();} ?>">
																									</div>
																								</div>
																							</div>
																							<div class="row">
																								<div class="col-lg-12">
																									<h4>Datos de Nacimiento y Fallecimiento</h4>
																								</div>
																								<!--¿Recien Nacido?-->
																								<div class="col-lg-3">
																									<div class="form-group has-success mg-b-0">
																										<label>¿Recien Nacido?:</label><br />
																										<input id="reciennacido" name="reciennacido" type="checkbox" value="1" <?php if ($paciente != null) {
																																													if ($paciente->getReciennacido() == 1) {
																																														echo "checked";
																																													}
																																												} ?>>
																									</div>
																								</div>
																								<!--Hijo de-->
																								<div class="col-lg-3">
																									<div class="form-group has-success mg-b-0">
																										<label>Hijo de:</label>
																										<input class="form-control" id="hijode" name="hijode" placeholder="Hijo de" type="text" value="<?php if ($paciente != null) {
																																																			echo $paciente->getHijode();
																																																		} ?>">
																									</div>
																								</div>
																								<!--Peso de nacimiento-->
																								<div class="col-lg-3">
																									<div class="form-group has-success mg-b-0">
																										<label>Peso de nacimiento:</label>
																										<input class="form-control" id="pesodenacimiento" name="pesodenacimiento" placeholder="Peso de nacimiento" type="text" value="<?php if ($paciente != null) {
																																																											echo $paciente->getPesonacimiento();
																																																										} ?>">
																									</div>
																								</div>
																								<!--Talla de nacimiento-->
																								<div class="col-lg-3">
																									<div class="form-group has-success mg-b-0">
																										<label>Talla de nacimiento (Centimetros):</label>
																										<input class="form-control" id="talladenacimiento" name="talladenacimiento" placeholder="Talla de nacimiento" type="text" value="<?php if ($paciente != null) {
																																																												echo $paciente->getTallanacimiento();
																																																											} ?>">
																									</div>
																								</div>
																								<!--Tipo parto-->
																								<div class="col-lg-3">
																									<div class="form-group has-success mg-b-0">
																										<label>Tipo parto:</label>
																										<select class="form-control" id="tipoparto" name="tipoparto">
																											<?php
																											if ($paciente != null) {
																												$lista = $c->listartipoparto();
																												foreach ($lista as $object) {
																													if ($paciente->getTipoparto() == $object->getId()) {
																														echo "<option value='" . $object->getId() . "' selected>" . $object->getNombre() . "</option>";
																													} else {
																														echo "<option value='" . $object->getId() . "'>" . $object->getNombre() . "</option>";
																													}
																												}
																											}
																											?>
																										</select>
																									</div>
																								</div>
																								<!--Rol-->
																								<div class="col-lg-3">
																									<div class="form-group has-success mg-b-0">
																										<label>Rol:</label>
																										<input class="form-control" id="rol" name="rol" placeholder="Rol" type="text" value="<?php if ($paciente != null) {
																																																	echo $paciente->getRol();
																																																} ?>">
																									</div>
																								</div>
																								<!--Fecha Fallecimiento-->
																								<div class="col-lg-3">
																									<div class="form-group has-success mg-b-0">
																										<label>Fecha Fallecimiento:</label>
																										<input class="form-control" id="fechafallecimiento" name="fechafallecimiento" placeholder="Fecha Fallecimiento" required="" type="date" value="<?php if ($paciente != null) {
																																																															echo $paciente->getFechafallecimiento();
																																																														} ?>">
																									</div>
																								</div>
																								<!--Hora Fallecimiento-->
																								<div class="col-lg-3">
																									<div class="form-group has-success mg-b-0">
																										<label>Hora Fallecimiento:</label>
																										<input class="form-control" id="horafallecimiento" name="horafallecimiento" placeholder="Hora Fallecimiento" required="" type="text" value="<?php if ($paciente != null) {
																																																														echo $paciente->getHorafallecimiento();
																																																													} ?>">
																									</div>
																								</div>
																							</div>
																						</div>
																					</div>
																				</div>
																				<div class="card">
																					<div class="card-header" id="headingTwo" role="tab">
																						<a aria-controls="collapseTwo" aria-expanded="false" class="collapsed" data-toggle="collapse" href="#collapseTwo">Ficha, Inscipción y prevision</a>
																					</div>
																					<?php
																					$fichaid = 0;
																					$fichanum = "";
																					$fechaadmision = "";
																					$familia = "";
																					$inscrito = "";
																					$sector = "";
																					$prevision = 0;
																					$tipoprevision = 0;
																					$estadoafiliacion = 0;
																					$chilesolidario = 0;
																					$prais = 0;
																					$sename = 0;
																					$ubicacionficha = "";
																					$fichasaludmental = "";
																					if ($inscripcion != null) {
																						$fichaid = $inscripcion->getId();
																						$fichanum = $inscripcion->getFicha();
																						$fechaadmision = $inscripcion->getFechaadmision();
																						$familia = $inscripcion->getAdmision();
																						$inscrito = $inscripcion->getInscrito();
																						$sector = $inscripcion->getSector();
																						$tipoprevision = $inscripcion->getTipoprevision();
																						$prevision = $c->buscartipoprevision($tipoprevision);
																						$prevision = $prevision->getCodigo();
																						$estadoafiliacion = $inscripcion->getEstadoafiliar();
																						$chilesolidario = $inscripcion->getChilesolidario();
																						$prais = $inscripcion->getPais();
																						$sename = $inscripcion->getSename();
																						$ubicacionficha = $inscripcion->getUbicacionficha();
																						$fichasaludmental = $inscripcion->getSaludmental();
																					}
																					?>
																					<div aria-labelledby="headingTwo" class="collapse" data-parent="#accordion" id="collapseTwo" role="tabpanel">
																						<div class="card-body">
																							<div class="row">
																								<!--Ficha-->
																								<div class="col-lg-3">
																									<input class="form-control" id="fichaid" name="fichaid" type="hidden" value="<?php echo $fichaid; ?>">
																									<div class="form-group has-success mg-b-0">
																										<label>Ficha:</label>
																										<input class="form-control" id="ficha" name="ficha" placeholder="Ficha" type="text" value="<?php echo $fichanum; ?>">
																									</div>
																								</div>
																								<!--Fecha Admision-->
																								<div class="col-lg-3">
																									<div class="form-group has-success mg-b-0">
																										<label>Fecha Admision:</label>
																										<input class="form-control" id="fechaadmision" name="fechaadmision" placeholder="Fecha Admision" required="" type="date" value="<?php echo $fechaadmision; ?>">
																									</div>
																								</div>
																								<!--Familia-->
																								<div class="col-lg-3">
																									<div class="form-group has-success mg-b-0">
																										<label>Familia:</label>
																										<input class="form-control" id="familia" name="familia" placeholder="Familia" type="text" value="<?php echo $familia; ?>">
																									</div>
																								</div>
																								<!--Inscrito-->
																								<div class="col-lg-3">
																									<div class="form-group has-success mg-b-0">
																										<label>Inscrito:</label>
																										<input class="form-control" id="inscrito" name="inscrito" placeholder="Inscrito" type="text" value="<?php echo $inscrito; ?>">
																									</div>
																								</div>
																								<!--Sector-->
																								<div class="col-lg-3">
																									<div class="form-group has-success mg-b-0">
																										<label>Sector:</label>
																										<input class="form-control" id="sector" name="sector" placeholder="Sector" type="text" value="<?php echo $sector; ?>">
																									</div>
																								</div>
																								<!--Prevision-->
																								<div class="col-lg-3">
																									<div class="form-group has-success mg-b-0">
																										<label>Prevision:</label>
																										<select class="form-control select2" id="prevision" name="prevision" onchange="buscartipoprevision(this)" required>
																											<?php
																											$lista = $c->listarprevision();
																											foreach ($lista as $object) {
																												if ($prevision == $object->getId()) {
																													echo "<option value='" . $object->getId() . "' selected>" . $object->getNombre() . "</option>";
																												} else {
																													echo "<option value='" . $object->getId() . "'>" . $object->getNombre() . "</option>";
																												}
																											}
																											?>
																										</select>
																									</div>
																								</div>
																								<!--Tipo Previsión-->
																								<div class="col-lg-3 fonasa">
																									<div class="form-group has-success mg-b-0">
																										<label id="titleprevision">FONASA:</label>
																										<select class="form-control select2 tipoprevision" id="tipoprevision" name="tipoprevision">
																											<?php
																											$lista = $c->listartipoprevision($prevision);
																											foreach ($lista as $object) {
																												if ($tipoprevision == $object->getId()) {
																													echo "<option value='" . $object->getId() . "' selected>" . $object->getNombre() . "</option>";
																												} else {
																													echo "<option value='" . $object->getId() . "'>" . $object->getNombre() . "</option>";
																												}
																											}
																											?>
																										</select>
																									</div>
																								</div>

																								<!--Estado de afiliacion-->
																								<div class="col-lg-3">
																									<div class="form-group has-success mg-b-0">
																										<label>Estado de afiliacion:</label>
																										<select class="form-control" id="estadoafiliacion" name="estadoafiliacion" required>
																											<option value="1" <?php if ($estadoafiliacion == 1) {
																																	echo "selected";
																																} ?>>Activo</option>
																											Activo
																											</option>
																											<option value="2" <?php if ($estadoafiliacion == 2) {
																																	echo "selected";
																																} ?>>
																												Inactivo
																											</option>
																										</select>
																									</div>
																								</div>
																								<!--¿Chile Solidario?-->
																								<div class="col-lg-3">
																									<div class="form-group has-success mg-b-0">
																										<label>¿Chile Solidario?:</label><br />
																										<input type="checkbox" name="chilesolidario" id="chilesolidario" value="1" <?php if ($chilesolidario == 1) {
																																														echo "checked";
																																													} ?>>
																									</div>
																								</div>
																								<!--¿Prais?-->
																								<div class="col-lg-3">
																									<div class="form-group has-success mg-b-0">
																										<label>¿Prais?:</label><br />
																										<input type="checkbox" name="prais" id="prais" value="1" <?php if ($prais == 1) {
																																										echo "checked";
																																									} ?>>
																									</div>
																								</div>
																								<!--¿SENAME?-->
																								<div class="col-lg-3">
																									<div class="form-group has-success mg-b-0">
																										<label>¿SENAME?:</label><br />
																										<input type="checkbox" name="sename" id="sename" value="1" <?php if ($sename == 1) {
																																										echo "checked";
																																									} ?>>
																									</div>
																								</div>
																								<!--Ubicacion Ficha-->
																								<div class="col-lg-3">
																									<div class="form-group has-success mg-b-0">
																										<label>Ubicacion Ficha:</label>
																										<input class="form-control" id="ubicacionficha" name="ubicacionficha" placeholder="Ubicacion Ficha" type="text" value="<?php echo $ubicacionficha; ?>">
																									</div>
																								</div>
																								<!--¿Ficha salud mental?-->
																								<div class="col-lg-3">
																									<div class="form-group has-success mg-b-0">
																										<label>¿Ficha salud mental?:</label><br />
																										<input type="checkbox" name="fichasaludmental" id="fichasaludmental" value="1" <?php if ($fichasaludmental == 1) {
																																															echo "checked";
																																														} ?>>
																									</div>
																								</div>

																							</div>
																						</div>
																					</div>
																				</div>
																				<div class="card">
																					<div class="card-header" id="headingThree" role="tab">
																						<a aria-controls="collapseThree" aria-expanded="false" class="collapsed" data-toggle="collapse" href="#collapseThree">Datos de Ubicación</a>
																					</div>
																					<div aria-labelledby="headingThree" class="collapse" data-parent="#accordion" id="collapseThree" role="tabpanel">
																						<?php
																						$ubicacionid = 0;
																						$regionid = 0;
																						$provinciaid = 0;
																						$comunaid = 0;
																						$ciudadid = 0;
																						$tipocalleid = 0;
																						$nombrecalle = "";
																						$numerodireccion = "";
																						$block = "";
																						if ($ubicacion != null) {
																							$ubicacionid = $ubicacion->getId();
																							$regionid = $ubicacion->getRegion();
																							$provinciaid = $ubicacion->getProvincia();
																							$comunaid = $ubicacion->getComuna();
																							$ciudadid = $ubicacion->getCiudad();
																							$tipocalleid = $ubicacion->getTipocalle();
																							$nombrecalle = $ubicacion->getNombrecalle();
																							$numerodireccion = $ubicacion->getNumerocalle();
																							$block = $ubicacion->getRestodireccion();
																						}
																						?>
																						<div class="card-body">
																							<div class="row">
																								<!--Region-->
																								<div class="col-lg-3">
																									<div class="form-group has-success mg-b-0">
																										<input class="form-control" id="ubicacionid" name="ubicacionid" type="hidden" value="<?php echo $ubicacionid; ?>">
																										<label>Region:</label>
																										<select class="form-control select2" id="region" name="region" required onchange="listadoprovincias(this)">
																											<?php
																											$lista = $c->listarregion();
																											foreach ($lista as $object) {
																												if ($regionid == $object->getId()) {
																													echo "<option value='" . $object->getId() . "' selected>" . $object->getNombre() . "</option>";
																												} else {
																													echo "<option value='" . $object->getId() . "'>" . $object->getNombre() . "</option>";
																												}
																											}
																											?>
																										</select>
																									</div>
																								</div>
																								<!--Provincia-->
																								<div class="col-lg-3">
																									<div class="form-group has-success mg-b-0">
																										<label>Provincia:</label>
																										<select class="form-control provincias select2" required id="provincia" name="provincia" onchange="checklistados(this)">
																											<?php
																											$lista = $c->listarprovincia($regionid);
																											foreach ($lista as $object) {
																												if ($provinciaid == $object->getId()) {
																													echo "<option value='" . $object->getId() . "' selected>" . $object->getNombre() . "</option>";
																												} else {
																													echo "<option value='" . $object->getId() . "'>" . $object->getNombre() . "</option>";
																												}
																											}

																											?>

																										</select>
																									</div>
																								</div>
																								<!--Comuna-->
																								<div class="col-lg-3">
																									<div class="form-group has-success mg-b-0">
																										<label>Comuna:</label>
																										<select class="form-control comunas select2" required id="comuna" name="comuna">
																											<?php
																											$lista = $c->listarcomuna($regionid);
																											foreach ($lista as $object) {
																												if ($comunaid == $object->getId()) {
																													echo "<option value='" . $object->getId() . "' selected>" . $object->getNombre() . "</option>";
																												} else {
																													echo "<option value='" . $object->getId() . "'>" . $object->getNombre() . "</option>";
																												}
																											}

																											?>


																										</select>
																									</div>
																								</div>
																								<!--Ciudad-->
																								<div class="col-lg-3">
																									<div class="form-group has-success mg-b-0">
																										<label>Ciudad:</label>
																										<select class="form-control ciudades select2" required id="ciudad" name="ciudad">
																											<?php
																											$lista = $c->listarciudad($regionid);
																											foreach ($lista as $object) {
																												if ($ciudadid == $object->getId()) {
																													echo "<option value='" . $object->getId() . "' selected>" . $object->getNombre() . "</option>";
																												} else {
																													echo "<option value='" . $object->getId() . "'>" . $object->getNombre() . "</option>";
																												}
																											}

																											?>


																										</select>
																									</div>
																								</div>
																								<!--Tipo Calle-->
																								<div class="col-lg-3">
																									<div class="form-group has-success mg-b-0">
																										<label>Tipo Calle:</label>
																										<select class="form-control select2" required id="tipocalle" name="tipocalle">
																											<?php
																											$lista = $c->listartipocalle();
																											foreach ($lista as $object) {
																												if ($tipocalleid == $object->getId()) {
																													echo "<option value='" . $object->getId() . "' selected>" . $object->getNombre() . "</option>";
																												} else {
																													echo "<option value='" . $object->getId() . "'>" . $object->getNombre() . "</option>";
																												}
																											}
																											?>
																										</select>
																									</div>
																								</div>
																								<!--Nombre Calle-->
																								<div class="col-lg-3">
																									<div class="form-group has-success mg-b-0">
																										<label>Nombre Calle:</label>
																										<input class="form-control" id="nombrecalle" required name="nombrecalle" placeholder="Nombre Calle" required="" type="text" value="<?php echo $nombrecalle; ?>">
																									</div>
																								</div>
																								<!--Numero Dirección-->
																								<div class="col-lg-3">
																									<div class="form-group has-success mg-b-0">
																										<label>Número Dirección:</label>
																										<input class="form-control" id="numerodireccion" required name="numerodireccion" placeholder="Número Dirección" required="" type="text" value="<?php echo $numerodireccion; ?>">
																									</div>
																								</div>
																								<!--Resto Direccion-->
																								<div class="col-lg-3">
																									<div class="form-group has-success mg-b-0">
																										<label>Block / Departamento / Casa:</label>
																										<input class="form-control" id="block" name="block" placeholder="Block / Departamento / Casa" type="text" value="<?php echo $block; ?>">
																									</div>
																								</div>
																							</div>
																						</div>
																					</div><!-- collapse -->
																				</div>
																				<div class="card">
																					<div class="card-header" id="headingFour" role="tab">
																						<a aria-controls="collapseThree" aria-expanded="false" class="collapsed" data-toggle="collapse" href="#collapseFour">Otros Antecedentes</a>
																					</div>
																					<div aria-labelledby="headingFour" class="collapse" data-parent="#accordion" id="collapseFour" role="tabpanel">
																						<div class="card-body">
																							<?php
																							$otrosid = 0;
																							$puebloid = 0;
																							$escolaridadid = 0;
																							$ocupacionid = 0;
																							$situacionlaboralid = 0;
																							$cursorepite = "";
																							if ($otros != null) {
																								$otrosid = $otros->getId();
																								$puebloid = $otros->getPueblooriginario();
																								$escolaridadid = $otros->getEscolaridad();
																								$ocupacionid = $otros->getOcupacion();
																								$situacionlaboralid = $otros->getSituacionlaboral();
																								$cursorepite = $otros->getCursorepite();
																							}
																							?>
																							<div class="row">
																								<!--Pueblo Originario-->
																								<div class="col-lg-3">
																									<div class="form-group has-success mg-b-0">
																										<input type="hidden" name="otrosid" id="otrosid" value="<?php echo $otrosid; ?>">
																										<label>Pueblo Originario:</label>
																										<select class="form-control select2" id="pueblooriginario" name="pueblooriginario">
																											<?php
																											$lista = $c->listarpueblooriginario();
																											foreach ($lista as $object) {
																												if ($puebloid == $object->getId()) {
																													echo "<option value='" . $object->getId() . "' selected>" . $object->getNombre() . "</option>";
																												} else {
																													echo "<option value='" . $object->getId() . "'>" . $object->getNombre() . "</option>";
																												}
																											}
																											?>
																										</select>
																									</div>
																								</div>
																								<!--Escolaridad-->
																								<div class="col-lg-3">
																									<div class="form-group has-success mg-b-0">
																										<label>Escolaridad:</label>
																										<select class="form-control select2" id="escolaridad" name="escolaridad">
																											<?php
																											$lista = $c->listarescolaridad();
																											foreach ($lista as $object) {
																												if ($escolaridadid == $object->getId()) {
																													echo "<option value='" . $object->getId() . "' selected>" . $object->getNombre() . "</option>";
																												} else {
																													echo "<option value='" . $object->getId() . "'>" . $object->getNombre() . "</option>";
																												}
																											}
																											?>
																										</select>
																									</div>
																								</div>
																								<!--Curso Repite-->
																								<div class="col-lg-3">
																									<div class="form-group has-success mg-b-0">
																										<label>Curso Repite:</label>
																										<input class="form-control" id="cursorepite" name="cursorepite" placeholder="Curso Repite" type="text" value="<?php echo $cursorepite; ?>">
																									</div>
																								</div>
																								<!--Situacion Laboral-->
																								<div class="col-lg-3">
																									<div class="form-group has-success mg-b-0">
																										<label>Situación Laboral:</label>
																										<select class="form-control select2" onchange="checklaboral(this)" id="situacionlaboral" name="situacionlaboral">
																											<?php
																											$lista = $c->listarsituacionlaboral();
																											foreach ($lista as $object) {
																												if ($situacionlaboralid == $object->getId()) {
																													echo "<option value='" . $object->getId() . "' selected>" . $object->getNombre() . "</option>";
																												} else {
																													echo "<option value='" . $object->getId() . "'>" . $object->getNombre() . "</option>";
																												}
																											}
																											?>
																										</select>
																									</div>
																								</div>
																								<!--Opucacion-->
																								<div class="col-lg-3 ocupacion">
																									<div class="form-group has-success mg-b-0">
																										<label>Ocupación:</label>
																										<select class="form-control select2" id="ocupacion" name="ocupacion">
																											<?php
																											$lista = $c->listarocupacion();
																											foreach ($lista as $object) {
																												if ($ocupacionid == $object->getId()) {
																													echo "<option value='" . $object->getId() . "' selected>" . $object->getNombre() . "</option>";
																												} else {
																													echo "<option value='" . $object->getId() . "'>" . $object->getNombre() . "</option>";
																												}
																											}
																											?>
																										</select>
																									</div>
																								</div>
																							</div>
																						</div>
																					</div><!-- collapse -->
																				</div>
																				<div class="card">
																					<div class="card-header" id="headingFive" role="tab">
																						<a aria-controls="collapseThree" aria-expanded="false" class="collapsed" data-toggle="collapse" href="#collapseFive">Datos de Persona Responsable</a>
																					</div>
																					<div aria-labelledby="headingFive" class="collapse" data-parent="#accordion" id="collapseFive" role="tabpanel">
																						<div class="card-body">
																							<?php
																							$idresponsable = 0;
																							$rutpersona = "";
																							$nombrepersona = "";
																							$relacionid = 0;
																							$telefonomovil = "";
																							$direccion = "";
																							if ($responsable != null) {
																								$idresponsable = $responsable->getId();
																								$rutpersona = $responsable->getRut();
																								$nombrepersona = $responsable->getNombre();
																								$relacionid = $responsable->getRelacion();
																								$telefonomovil = $responsable->getTelefono();
																								$direccion = $responsable->getDireccion();
																							}
																							?>
																							<div class="row">
																								<!--RUT Persona-->
																								<div class="col-lg-3">
																									<input type="hidden" id="idresponsable" name="idresponsable" value="<?php echo $idresponsable; ?>">
																									<div class="form-group has-success mg-b-0">
																										<label>RUT Persona:</label>
																										<input class="form-control" id="rutpersona" name="rutpersona" placeholder="RUT Persona" onkeyup="formatRut(this)" type="text" value="<?php echo $rutpersona; ?>">
																									</div>
																								</div>
																								<!--Nombre persona-->
																								<div class="col-lg-3">
																									<div class="form-group has-success mg-b-0">
																										<label>Nombre Persona:</label>
																										<input class="form-control" id="nombrepersona" name="nombrepersona" placeholder="Nombre Persona" type="text" value="<?php echo $nombrepersona; ?>">
																									</div>
																								</div>
																								<!--Relación-->
																								<div class="col-lg-3">
																									<div class="form-group has-success mg-b-0">
																										<label>Relación:</label>
																										<select class="form-control select2" id="relacion" name="relacion">
																											<?php
																											$lista = $c->listarrelaciones();
																											foreach ($lista as $object) {
																												if ($relacionid == $object->getId()) {
																													echo "<option value='" . $object->getId() . "' selected>" . $object->getNombre() . "</option>";
																												} else {
																													echo "<option value='" . $object->getId() . "'>" . $object->getNombre() . "</option>";
																												}
																											}
																											?>
																										</select>
																									</div>
																								</div>
																								<!--Telefono Movil-->
																								<div class="col-lg-3">
																									<div class="form-group has-success mg-b-0">
																										<label>Teléfono Móvil:</label>
																										<input class="form-control" id="telefonomovil" name="telefonomovil" placeholder="Teléfono Móvil" type="text" value="<?php echo $telefonomovil; ?>">
																									</div>
																								</div>
																								<!--Direccion-->
																								<div class="col-lg-3">
																									<div class="form-group has-success mg-b-0">
																										<label>Dirección:</label>
																										<input class="form-control" id="direccion" name="direccion" placeholder="Dirección" type="text" value="<?php echo $direccion; ?>">
																									</div>
																								</div>
																							</div>
																						</div>
																					</div><!-- collapse -->
																				</div>
																			</div><!-- accordion -->
																			<div class="row mt-4">
																				<div class="col-md-12 text-center">
																					<!--Boton Guardar-->
																					<button type="button" id="btnactualizarpatient" class="btn btn-outline-success ml-2"><i class="fa fa-save"></i> Guardar</button>
																					<!--Boton Imprimir Ficha completo-->
																					<!--Boton Cerrar-->
																					<a href="<?php echo $previous_page; ?>" class="btn btn-outline-danger ml-2"><i class="fa fa-close"></i> Volver</a>
																				</div>
																			</div>
																		</div>
																	</div>
																</form>
															</div>
														</div>
														<!-- End Row -->
													</div>
													<div class="tab-pane" id="tabCont2">
														<!-- Row -->
														<div class="row">
															<div class="col-lg-12">
																<div class="card">
																	<div class="card-body">
																		<div aria-multiselectable="true" class="accordion" id="accordion" role="tablist">
																			<div class="card">
																				<div class="card-header" id="family" role="tab">
																					<a aria-controls="collapseOne" aria-expanded="true" data-toggle="collapse" href="#familia">Datos Familia</a>
																				</div>
																				<div aria-labelledby="family" class="collapse " data-parent="#accordion" id="familia" role="tabpanel">
																					<div class="card-body">
																						<div class="row">

																						</div>
																					</div>
																				</div>
																			</div>
																			<div class="card">
																				<div class="card-header" id="fichasocial" role="tab">
																					<a aria-controls="collapseTwo" aria-expanded="false" class="collapsed" data-toggle="collapse" href="#ficha">Ficha Social</a>
																				</div>
																				<div aria-labelledby="fichasocial" class="collapse" data-parent="#accordion" id="ficha" role="tabpanel">
																					<div class="card-body">
																						Informacion Aqui
																					</div>
																				</div>
																			</div>
																		</div><!-- accordion -->
																	</div>
																</div>
															</div>
														</div>
														<!-- End Row -->
													</div>
													<?php
													if ($admingeneralrol == true || $adminsistemarol == true || $fichaclinicarol == true) {
													?>
														<div class="tab-pane" id="tabCont3">
															<!-- Row -->
															<div class="row">
																<div class="col-lg-12">
																	<div class="card">
																		<div class="card-body">
																			<div aria-multiselectable="true" class="accordion" id="accordion" role="tablist">
																				<!--Diagnosticos-->
																				<div class="card">
																					<div class="card-header" id="diagnostic" role="tab">
																						<a aria-controls="collapseTwo" aria-expanded="false" class="collapsed" data-toggle="collapse" href="#diagnosticos">Diagnosticos</a>
																					</div>
																					<div aria-labelledby="diagnostico" class="collapse" data-parent="#accordion" id="diagnosticos" role="tabpanel">
																						<div class="card-body">
																							Informacion Aqui
																						</div>
																					</div>
																				</div>
																				<!--Intervenciones Quirurgicas-->
																				<div class="card">
																					<div class="card-header" id="intervencion" role="tab">
																						<a aria-controls="collapseTwo" aria-expanded="false" class="collapsed" data-toggle="collapse" href="#intervenciones">Intervenciones Quirurgicas</a>
																					</div>
																					<div aria-labelledby="intervencion" class="collapse" data-parent="#accordion" id="intervenciones" role="tabpanel">
																						<div class="card-body">
																							Informacion Aqui
																						</div>
																					</div>
																				</div>
																				<!--Hospitalizaciones-->
																				<div class="card">
																					<div class="card-header" id="hospitalizacion" role="tab">
																						<a aria-controls="collapseTwo" aria-expanded="false" class="collapsed" data-toggle="collapse" href="#hospitalizaciones">Hospitalizaciones</a>
																					</div>
																					<div aria-labelledby="hospitalizacion" class="collapse" data-parent="#accordion" id="hospitalizaciones" role="tabpanel">
																						<div class="card-body">
																							Informacion Aqui
																						</div>
																					</div>
																				</div>
																				<!--Atenciones-->
																				<div class="card">
																					<div class="card-header" id="atencion" role="tab">
																						<a aria-controls="collapseOne" aria-expanded="true" data-toggle="collapse" href="#atenciones">Atenciones</a>
																					</div>
																					<div aria-labelledby="atencion" class="collapse" data-parent="#accordion" id="atenciones" role="tabpanel">
																						<div class="card-body">
																							<div class="col-xl-12 col-lg-12 col-md-12">
																								<div class="card transcation-crypto1" id="transcation-crypto1">
																									<div class="card-body">
																										<div class="">
																											<div class="table-responsive">
																												<table class="table w-100 text-nowrap" id="example2">
																													<thead class="border-top text-center">
																														<tr>
																															<th class="bg-transparent">Estado de Atencion</th>
																															<th class="bg-transparent">Fecha Cita</th>
																															<th class="bg-transparent">Folio</th>
																															<th class="bg-transparent text-center">Profesional</th>
																															<th class="bg-transparent text-center">Atención</th>
																															<th class="bg-transparent text-center">Reporte</th>
																														</tr>
																													</thead>
																													<tbody class="text-center">
																														<?php
																														if ($paciente != null) {
																															$consultas = $c->listarconsultaspaciente($paciente->getId());
																															if (count($consultas) > 0) {
																																foreach ($consultas as $r) {

																																	echo "<tr>";
																																	if($r->getAtencion() == 1 || $r->getAtencion() == 2 || $r->getAtencion() == 3 || $r->getAtencion() == 4){
																																		echo "<td><span class='badge badge-warning'>Pendiente <i class='fa fa-user-clock'></i></span></td>";
																																	}else if ($r->getAtencion() == 5) {
																																		echo "<td><span class='badge badge-success'>Atendido <i class='fa fa-user-check'></i></span></td>";
																																	} else if ($r->getAtencion() == 6) {
																																		echo "<td><span class='badge badge-danger'>Cancelado <i class='fa fa-user-times'></i></span></td>";
																																	}else if ($r->getAtencion() == 7) {
																																		echo "<td><span class='badge badge-danger'>Paciente no asistió <i class='fa fa-user-slash'></i></span></td>";
																																	}
																																	echo "<td>" . date("d-m-Y", strtotime($r->getRegistro())) . "</td>";
																																	echo "<td>" . $r->getFolio() . "</td>";
																																	$idreceta = $r->getId();
																																	echo "<td>" . $r->getUsuario() . "</td>";

																																	$idreceta = $r->getId();
																																	echo "<td>" . $r->getTipodeatencion() . "</td>";
																																	echo "<td><a target='_blank' href='php/reporte/consulta.php?c=$idreceta' class='btn btn-success'><i class='fe fe-file'></i></a></td>";
																																	echo "</tr>";
																																}
																															}
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
																				<!--Procedimientos-->
																				<div class="card">
																					<div class="card-header" id="procedimiento" role="tab">
																						<a aria-controls="collapseTwo" aria-expanded="false" class="collapsed" data-toggle="collapse" href="#procedimientos">Procedimientos</a>
																					</div>
																					<div aria-labelledby="procedimiento" class="collapse" data-parent="#accordion" id="procedimientos" role="tabpanel">
																						<div class="card-body">
																							Informacion Aqui
																						</div>
																					</div>
																				</div>
																				<!--Interconsultas-->
																				<div class="card">
																					<div class="card-header" id="interconsulta" role="tab">
																						<a aria-controls="collapseTwo" aria-expanded="false" class="collapsed" data-toggle="collapse" href="#interconsultas">Interconsultas</a>
																					</div>
																					<div aria-labelledby="interconsulta" class="collapse" data-parent="#accordion" id="interconsultas" role="tabpanel">
																						<div class="card-body">
																							Informacion Aqui
																						</div>
																					</div>
																				</div>
																				<!--Imagenologia-->
																				<div class="card">
																					<div class="card-header" id="imagenologia" role="tab">
																						<a aria-controls="collapseTwo" aria-expanded="false" class="collapsed" data-toggle="collapse" href="#imagenologias">Imagenologia</a>
																					</div>
																					<div aria-labelledby="imagenologia" class="collapse" data-parent="#accordion" id="imagenologias" role="tabpanel">
																						<div class="card-body">
																							Informacion Aqui
																						</div>
																					</div>
																				</div>
																				<!--Laboratorio-->
																				<div class="card">
																					<div class="card-header" id="laboratorio" role="tab">
																						<a aria-controls="collapseTwo" aria-expanded="false" class="collapsed" data-toggle="collapse" href="#laboratorios">Laboratorio</a>
																					</div>
																					<div aria-labelledby="laboratorio" class="collapse" data-parent="#accordion" id="laboratorios" role="tabpanel">
																						<div class="card-body">
																							Informacion Aqui
																						</div>
																					</div>
																				</div>
																				<!--Medicamentos-->
																				<div class="card">
																					<div class="card-header" id="medicamento" role="tab">
																						<a aria-controls="collapseTwo" aria-expanded="false" class="collapsed" data-toggle="collapse" href="#medicamentos">Medicamentos</a>
																					</div>
																					<div aria-labelledby="medicamento" class="collapse" data-parent="#accordion" id="medicamentos" role="tabpanel">
																						<div class="card-body">
																							Informacion Aqui
																						</div>
																					</div>
																				</div>
																				<!--Alergias-->
																				<div class="card">
																					<div class="card-header" id="alergia" role="tab">
																						<a aria-controls="collapseTwo" aria-expanded="false" class="collapsed" data-toggle="collapse" href="#alergias">Alergias</a>
																					</div>
																					<div aria-labelledby="alergia" class="collapse" data-parent="#accordion" id="alergias" role="tabpanel">
																						<div class="card-body">
																							Informacion Aqui
																						</div>
																					</div>
																				</div>
																				<!--Alertas-->
																				<div class="card">
																					<div class="card-header" id="alerta" role="tab">
																						<a aria-controls="collapseTwo" aria-expanded="false" class="collapsed" data-toggle="collapse" href="#alertas">Alertas</a>
																					</div>
																					<div aria-labelledby="alerta" class="collapse" data-parent="#accordion" id="alertas" role="tabpanel">
																						<div class="card-body">
																							Informacion Aqui
																						</div>
																					</div>
																				</div>
																				<!--Antecedentes Obstetricos-->
																				<div class="card">
																					<div class="card-header" id="antecedente" role="tab">
																						<a aria-controls="collapseTwo" aria-expanded="false" class="collapsed" data-toggle="collapse" href="#antecedentes">Antecedentes Obstetricos</a>
																					</div>
																					<div aria-labelledby="antecedente" class="collapse" data-parent="#accordion" id="antecedentes" role="tabpanel">
																						<div class="card-body">
																							Informacion Aqui
																						</div>
																					</div>
																				</div>
																				<!--Antecedentes Familiares-->
																				<div class="card">
																					<div class="card-header" id="antecedente" role="tab">
																						<a aria-controls="collapseTwo" aria-expanded="false" class="collapsed" data-toggle="collapse" href="#antecedentesf">Antecedentes Familiares</a>
																					</div>
																					<div aria-labelledby="antecedente" class="collapse" data-parent="#accordion" id="antecedentesf" role="tabpanel">
																						<div class="card-body">
																							Informacion Aqui
																						</div>
																					</div>
																				</div>
																				<!--Documentos del pacientes y otros examenes-->
																				<div class="card">
																					<div class="card-header" id="documentos" role="tab">
																						<a aria-controls="collapseTwo" aria-expanded="false" class="collapsed" data-toggle="collapse" href="#documentos">Documentos del pacientes y otros examenes</a>
																					</div>
																					<div aria-labelledby="documentos" class="collapse" data-parent="#accordion" id="documentos" role="tabpanel">
																						<div class="card-body">
																							Informacion Aqui
																						</div>
																					</div>
																				</div>
																				<!--Instrumentos-->
																				<div class="card">
																					<div class="card-header" id="instrumento" role="tab">
																						<a aria-controls="collapseTwo" aria-expanded="false" class="collapsed" data-toggle="collapse" href="#instrumentos">Instrumentos</a>
																					</div>
																					<div aria-labelledby="instrumento" class="collapse" data-parent="#accordion" id="instrumentos" role="tabpanel">
																						<div class="card-body">
																							Informacion Aqui
																						</div>
																					</div>
																				</div>
																				<!--Plan de Cuidados-->
																				<div class="card">
																					<div class="card-header" id="plan" role="tab">
																						<a aria-controls="collapseTwo" aria-expanded="false" class="collapsed" data-toggle="collapse" href="#planes">Plan de Cuidados</a>
																					</div>
																					<div aria-labelledby="plan" class="collapse" data-parent="#accordion" id="planes" role="tabpanel">
																						<div class="card-body">
																							Informacion Aqui
																						</div>
																					</div>
																				</div>

																			</div><!-- accordion -->
																		</div>
																	</div>
																</div>
															</div>
															<!-- End Row -->
														</div>
														<div class="tab-pane" id="tabCont4">
															<div class="row">
																<div class="col-xl-12 col-lg-12 col-md-12">
																	<div class="card transcation-crypto1" id="transcation-crypto1">
																		<div class="card-body">

																			<form id="formsignos">
																				<div class="row">
																					<input type="hidden" name="idpac" value="<?php echo $pacienteid; ?>">
																					<div class="col-md-1">
																						<label>F RESP</label>
																						<input type="number" class="form-control" min="1" id="sfresp" name="sfresp"  step="0.01">
																					</div>
																					<div class="col-md-1">
																						<label>P SIST</label>
																						<input type="number" class="form-control" min="1" id="spsist" name="spsist"  step="0.01">
																					</div>
																					<div class="col-md-1">
																						<label>P DIAS</label>
																						<input type="number" class="form-control" min="1" id="spdias" name="spdias"  step="0.01">
																					</div>
																					<div class="col-md-1">
																						<label>% STAT 02</label>
																						<input type="number" class="form-control" min="1" id="ssat" name="ssat"  step="0.01">
																					</div>
																					<div class="col-md-1">
																						<label>FC</label>
																						<input type="number" class="form-control" min="1" id="sfc" name="sfc"  step="0.01">
																					</div>
																					<div class="col-md-1">
																						<label>T. AUXILIAR</label>
																						<input type="number" class="form-control" min="1" id="staux" name="staux"  step="0.01">
																					</div>
																					<div class="col-md-1">
																						<label>T. RECT</label>
																						<input type="number" class="form-control" min="1" id="strect" name="strect"  step="0.01">
																					</div>
																					<div class="col-md-1">
																						<label>T. OTRA</label>
																						<input type="text" class="form-control" min="1" id="stotra" name="stotra" >
																					</div>
																					<div class="col-md-1">
																						<label>HGT</label>
																						<input type="number" class="form-control" min="1" id="shgt" name="shgt"  step="0.01">
																					</div>
																					<div class="col-md-1 d-none">
																						<label>PESO</label>
																						<input type="number" class="form-control" min="1" id="speso1" name="speso1"  step="0.01">
																						<input type="hidden" id="speso" name="speso" value="0">
																					</div>
																					<div class="col-md-1 d-flex align-items-end">
																						<button class="btn btn-outline-success" type="submit"><i class="fa fa-save"></i> Registrar</button>
																					</div>
																				</div>
																			</form>
																			<div class="row mt-4">
																				<div class="col-xl-12 col-lg-12 col-md-12">
																					<div class="card transcation-crypto1" id="transcation-crypto1">
																						<div class="card-body">
																							<div class="">
																								<div class="table-responsive">
																									<table class="table w-100 text-nowrap" id="">
																										<thead class="border-top text-center">
																											<tr>
																												<th class="bg-transparent">Fecha</th>
																												<th class="bg-transparent">f Resp</th>
																												<th class="bg-transparent text-center">P. Sist</th>
																												<th class="bg-transparent text-center">P. Dias</th>
																												<th class="bg-transparent text-center">% Sat 02</th>
																												<th class="bg-transparent text-center">FC</th>
																												<th class="bg-transparent text-center">T. Axilar</th>
																												<th class="bg-transparent text-center">T. Rect</th>
																												<th class="bg-transparent text-center">T. Otra</th>
																												<th class="bg-transparent text-center">HGT</th>
																												<th class="bg-transparent text-center">PESO</th>
																												<th class="bg-transparent text-center">ID</th>
																											</tr>
																										</thead>
																										<input type="hidden" id="pacienteid" value="<?php echo $pacienteid; ?>">
																										<tbody class="text-center" id="signos">
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
															</div>

														</div>
														<div class="tab-pane" id="tabCont5">
															<!--Row-->
															<!--Row-->
															<form id="formmedidas">
																<div class="row">
																	<input type="hidden" name="idpac" value="<?php echo $pacienteid; ?>">
																	<div class="col-md-1">
																		<label>Peso</label>
																		<!--Valores Hasta con 2 decimales-->
																		<input type="number" class="form-control" min="1" id="peso" name="peso"  step="0.01">
																	</div>
																	<div class="col-md-1">
																		<label>Estatura</label>
																		<input type="number" class="form-control" min="1" id="estatura" name="estatura"  step="0.01">
																	</div>
																	<div class="col-md-1">
																		<label>PCe/E</label>
																		<input type="number" class="form-control" min="1" id="pce" name="pce"  step="0.01">
																	</div>
																	<div class="col-md-1">
																		<label>P/E</label>
																		<select type="number" class="form-control" id="pe" name="pe" >
																			<option value="1">Normal</option>
																			<option value="2">Desnutrición</option>
																			<option value="3">Sobrepeso</option>
																			<option value="4">Obesidad</option>
																		</select>
																	</div>
																	<div class="col-md-1">
																		<label>P/T</label>
																		<select type="number" class="form-control" id="pt" name="pt" >
																			<option value="1">Normal</option>
																			<option value="2">Desnutrición</option>
																			<option value="3">Sobrepeso</option>
																			<option value="4">Obesidad</option>
																		</select>
																	</div>
																	<div class="col-md-1">
																		<label>T/E</label>
																		<select type="number" class="form-control" id="te" name="te" >
																			<option value="1">Normal</option>
																			<option value="2">Desnutrición</option>
																			<option value="3">Sobrepeso</option>
																			<option value="4">Obesidad</option>
																		</select>
																	</div>
																	<div class="col-md-1">
																		<label>IMC</label>
																		<input type="number" class="form-control" min="1" id="imc" name="imc"  step="0.01">
																	</div>
																	<div class="col-md-1">
																		<label>Clasif. IMC</label>
																		<input type="text" class="form-control" min="1" id="clasifimc" name="clasifimc" >
																	</div>
																	<div class="col-md-1">
																		<label>PC/E</label>
																		<input type="number" class="form-control" min="1" id="pc" name="pc"  step="0.01">
																	</div>
																	<div class="col-md-2">
																		<label>Clasif P.Cintura</label>
																		<select type="number" class="form-control" id="cpc" name="cpc">
																			<option value="1">Normal</option>
																			<option value="2">Riesgo Obésidad abdominal</option>
																			<option value="3">Obesidad abdominal</option>
																		</select>
																	</div>
																	<div class="col-md-1 d-flex align-items-end">
																		<button class="btn btn-outline-success" type="submit"><i class="fa fa-save"></i> Registrar</button>
																	</div>
																</div>
															</form>
															<div class="row mt-4">
																<div class="col-xl-12 col-lg-12 col-md-12">
																	<div class="card transcation-crypto1" id="transcation-crypto1">
																		<div class="card-body">
																			<div class="">
																				<div class="table-responsive">
																					<table class="table w-100 text-nowrap" id="">
																						<thead class="border-top text-center">
																							<tr>
																								<th class="bg-transparent">Fecha</th>
																								<th class="bg-transparent">peso</th>
																								<th class="bg-transparent text-center">Estatura</th>
																								<th class="bg-transparent text-center">PCe/e</th>
																								<th class="bg-transparent text-center">P/E</th>
																								<th class="bg-transparent text-center">P/T</th>
																								<th class="bg-transparent text-center">T/E</th>
																								<th class="bg-transparent text-center">IMC</th>
																								<th class="bg-transparent text-center">Clasif. IMC</th>
																								<th class="bg-transparent text-center">PC/E</th>
																								<th class="bg-transparent text-center">Clasif P. Cintura</th>
																								<th class="bg-transparent text-center">ID</th>
																							</tr>
																						</thead>
																						<tbody class="text-center" id="medidas">

																						</tbody>
																					</table>
																				</div>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
														</div>
														<div class="tab-pane" id="tabCont6">
															<div class="row">
																<div class="col-md-12">
																<div class="col-md-12">
																	<div class="card">
																		<div class="card-header">
																			<div class="row">
																				<div class="col-md-6">
																					<h4 class="card-title">Registro Poblacional</h4>
																					<p>Formulario de Registro caso nuevo de Cáncer</p>
																				</div>
																				<div class="col-md-6 text-right">
																					<?php 
																						$ultimoregistro = $c->ultimoregistropoblacional($pacienteid);
																						if($ultimoregistro != null){
																							echo "<button type='button' class='btn btn-outline-success' title='Historial de Registros' data-toggle='modal' data-target='#historialregistros'><i class='fa fa-history'></i> Historial de Registros</button>";
																						}
																					?>
																				</div>
																			</div>
																			
																		</div>
																		<div class="card-body">
																			<div class="row">
																				<div class="col-md-12">
																					<label for=""><strong>Rama de Actividad</strong></label>
																				</div>
																				<div class="col-md-4">
																					<input type="checkbox" class="mr-1" value="1" name="rama" id="rama1"><span>Agricultura, Caza, Silvicultura y Pesca</span><br />
																					<input type="checkbox" class="mr-1" value="2" name="rama" id="rama2"><span>Minas y Canteras</span><br />
																					<input type="checkbox" class="mr-1" value="3" name="rama" id="rama3"><span>Industria Manufacturera</span><br />
																					<input type="checkbox" class="mr-1" value="4" name="rama" id="rama4"><span>Electricidad, Gas y Agua</span>
																				</div>
																				<div class="col-md-4">
																					<input type="checkbox" class="mr-1" value="5" name="rama" id="rama5"><span>Construcción</span><br />
																					<input type="checkbox" class="mr-1" value="6" name="rama" id="rama6"><span>Comercio mayor y menor, restaurant y hotel</span><br />
																					<input type="checkbox" class="mr-1" value="7" name="rama" id="rama7"><span>Transporte, Almacenamiento y Comunicaciones</span><br />
																					<input type="checkbox" class="mr-1" value="8" name="rama" id="rama8"><span>Servicios Financierios</span>
																				</div>
																				<div class="col-md-4">
																					<input type="checkbox" class="mr-1" value="9" name="rama" id="rama9"><span>Servicios Comunales, Sociales, Personales</span><br />
																					<input type="checkbox" class="mr-1" value="10" name="rama" id="rama10"><span>Actividad no especificada</span>
																				</div>
																			</div>
																			<hr>
																			<div class="row">
																				<div class="col-md-12">
																					<label for=""><strong>Ocupación</strong></label>
																				</div>
																				<div class="col-md-4">
																					<input type="checkbox" class="mr-1" value="1" name="ocupacion" id="ocupacion1"><span>Profesionales, Técnicos y Afines</span><br />
																					<input type="checkbox" class="mr-1" value="2" name="ocupacion" id="ocupacion2"><span>Gerentes, Administradores y Directivos</span><br />
																					<input type="checkbox" class="mr-1" value="3" name="ocupacion" id="ocupacion3"><span>Empleados oficina y afines</span><br />
																					<input type="checkbox" class="mr-1" value="4" name="ocupacion" id="ocupacion4"><span>Vendedores y afines</span>
																				</div>
																				<div class="col-md-4">
																					<input type="checkbox" class="mr-1" value="5" name="ocupacion" id="ocupacion5"><span>Agricultores, Ganadores, Pescadores</span><br />
																					<input type="checkbox" class="mr-1" value="6" name="ocupacion" id="ocupacion6"><span>Conductores y afines</span><br />
																					<input type="checkbox" class="mr-1" value="7" name="ocupacion" id="ocupacion7"><span>Artesanos y Operarios</span><br />
																					<input type="checkbox" class="mr-1" value="8" name="ocupacion" id="ocupacion8"><span>Otros Artesanos y Operarios</span>
																				</div>
																				<div class="col-md-4">
																					<input type="checkbox" class="mr-1" value="9" name="ocupacion" id="ocupacion9"><span>Obreros y Jornaleros N.E.O.C</span><br />
																					<input type="checkbox" class="mr-1" value="10" name="ocupacion" id="ocupacion10"><span>Trabajadores en Servicios Personales</span><br />
																					<input type="checkbox" class="mr-1" value="11" name="ocupacion" id="ocupacion11"><span>Otros trabajadores N.E.O.C. 2/</span>
																				</div>
																			</div>
																			<hr>
																			<div class="row">
																				<div class="col-md-12">
																					<h5>Características del cáncer</h5>
																				</div>
																				<div class="col-md-6">
																					<div class="row">
																						<div class="col-md-12">
																							<div class="row justify-content-end align-items-center">
																								<div class="col-md-1" style="margin: 0;">
																									<label for="">C</label>
																								</div>
																								<div class="col-md-1" style="margin: 0;">
																									<input type="text" class="form-control" id="sp1" name="sp1">
																								</div>
																								<div class="col-md-1" style="margin: 0;">
																									<input type="text" class="form-control" id="sp2" name="sp2">
																								</div>
																								<div class="col-md-1 text-center" style="margin: 0; font-size:40px;">
																									<label for="" class="text-center">.</label>
																								</div>
																								<div class="col-md-1" style="margin: 0;">
																									<input type="text" class="form-control" id="sp3" name="sp3">
																								</div>
																								<div class="col-md-6" style="margin: 0;">
																									<label for="">Sitio Primario:<br>(Topografía)</label>
																								</div>
																							</div>
																							<div class="row justify-content-end align-items-center">
																								<div class="col-md-1">
																									<input type="text" class="form-control" id="th1" name="th1">
																								</div>
																								<div class="col-md-1">
																									<label for="">_</label>
																								</div>
																								<div class="col-md-1">
																									<input type="text" class="form-control" id="th2" name="th2">
																								</div>
																								<div class="col-md-1">
																									<input type="text" class="form-control" id="th3" name="th3">
																								</div>
																								<div class="col-md-1">
																									<input type="text" class="form-control" id="th4" name="th4">
																								</div>
																								<div class="col-md-1">
																									<input type="text" class="form-control" id="th5" name="th5">
																								</div>
																								<div class="col-md-6">
																									<label for="">Tipo Histológico:<br>(Morfología)</label>
																								</div>
																							</div>
																							<div class="row justify-content-end align-items-center">
																								<div class="col-md-6">
																									<input type="text" class="form-control" id="comportamiento" name="comportamiento">
																								</div>
																								<div class="col-md-6">
																									<label for="">Comportamiento</label>
																								</div>
																							</div>
																						</div>
																					</div>
																				</div>
																				<div class="col-md-6">
																					<label for="">Observaciones:</label>
																					<textarea name="comportamientoobservaciones" id="comportamientoobservaciones" class="form-control" cols="30" rows="10"></textarea>
																				</div>
																			</div>

																			<hr>
																			<div class="row">
																				<div class="col-md-4">
																					<label for=""><strong>Grado de diferenciación</strong></label><br />
																					<input type="checkbox" class="mr-1" value="1" name="grado" id="grado1"><span>Bien diferenciado</span><br />
																					<input type="checkbox" class="mr-1" value="2" name="grado" id="grado2"><span>Moderadamente diferenciado</span><br />
																					<input type="checkbox" class="mr-1" value="3" name="grado" id="grado3"><span>Pobremente diferenciado</span><br />
																					<input type="checkbox" class="mr-1" value="4" name="grado" id="grado4"><span>Indiferenciado o anaplásico</span><br />
																					<input type="checkbox" class="mr-1" value="5" name="grado" id="grado5"><span>No determinado o inaplicable</span>
																				</div>
																				<div class="col-md-4">
																					<label for=""><strong>Extensión</strong></label><br />
																					<input type="checkbox" class="mr-1" value="1" name="extension" id="extension1"><span>In situ</span><br />
																					<input type="checkbox" class="mr-1" value="2" name="extension" id="extension2"><span>Localizada</span><br />
																					<input type="checkbox" class="mr-1" value="3" name="extension" id="extension3"><span>Regional</span><br />
																					<input type="checkbox" class="mr-1" value="4" name="extension" id="extension4"><span>Metástasis</span><br />
																					<input type="checkbox" class="mr-1" value="5" name="extension" id="extension5"><span>Desconocido</span>
																				</div>
																				<div class="col-md-4">
																					<label for=""><strong>Lateralidad</strong></label><br />
																					<input type="checkbox" class="mr-1" value="1" name="lateralidad" id="lateralidad1"><span>Derecho</span><br />
																					<input type="checkbox" class="mr-1" value="2" name="lateralidad" id="lateralidad2"><span>Izquierdo</span><br />
																					<input type="checkbox" class="mr-1" value="3" name="lateralidad" id="lateralidad3"><span>Bilateral</span><br />
																					<input type="checkbox" class="mr-1" value="4" name="lateralidad" id="lateralidad4"><span>No corresponde</span><br />
																					<input type="checkbox" class="mr-1" value="5" name="lateralidad" id="lateralidad5"><span>Desconocido</span>
																				</div>
																			</div>
																			<hr>
																			<div class="row">
																				<div class="col-md-12">
																					<div class="row">
																						<div class="col-md-3">
																							<label for="">Fecha Incidencia</label>
																						</div>
																						<div class="col-md-3">
																							<input type="date" class="form-control" id="fechaIncidencia" name="fechaIncidencia">
																						</div>
																						<div class="col-md-3">
																							<input type="time" class="form-control" id="horaIncidencia" name="horaIncidencia">
																						</div>
																					</div>
																				</div>
																				<div class="col-md-12">
																					<label for=""><strong>Base del Diágnóstico (El principal)</strong></label>
																				</div>
																				<div class="col-md-4">
																					<input type="checkbox" class="mr-1" value="1" name="baseDiagnostico" id="baseDiagnostico1"><span>Sólo certificado de defunción</span><br />
																					<input type="checkbox" class="mr-1" value="2" name="baseDiagnostico" id="baseDiagnostico2"><span>Sólo Clínica</span><br />
																					<input type="checkbox" class="mr-1" value="3" name="baseDiagnostico" id="baseDiagnostico3"><span>Investigación clínica</span><br />
																				</div>
																				<div class="col-md-4">
																					<input type="checkbox" class="mr-1" value="4" name="baseDiagnostico" id="baseDiagnostico4"><span>Extámenes bioquímicos / inmunológicos</span><br />
																					<input type="checkbox" class="mr-1" value="5" name="baseDiagnostico" id="baseDiagnostico5"><span>Citología / hematología</span><br />
																					<input type="checkbox" class="mr-1" value="6" name="baseDiagnostico" id="baseDiagnostico6"><span>Histología de Metástasis</span><br />
																				</div>
																				<div class="col-md-4">
																					<input type="checkbox" class="mr-1" value="7" name="baseDiagnostico" id="baseDiagnostico7"><span>Histología de cáncer primario</span><br />
																					<input type="checkbox" class="mr-1" value="8" name="baseDiagnostico" id="baseDiagnostico8"><span>Desconocido</span>
																				</div>
																			</div>
																			<hr>
																			<div class="row">
																				<div class="col-md-12">
																					<h5>Fuente de Incidencia</h5>
																				</div>
																				<div class="col-md-4">
																					<div class="row">
																						<div class="col-md-12">
																							<label for="">Fuente Nº 1</label>
																						</div>
																						<div class="col-md-12">
																							<label for="">Nombre</label>
																							<input type="text" class="form-control" id="fuente1" name="fuente1">
																						</div>
																						<div class="col-md-12">
																							<label for="">Fecha del paciente o del examen</label>
																						</div>
																						<div class="col-md-12">
																							<input type="date" class="form-control" id="fechaPaciente1" name="fechaPaciente1">
																						</div>
																						<div class="col-md-12">
																							<label for="">Fecha de la hospitalización o exámen</label>
																						</div>
																						<div class="col-md-6">
																							<input type="date" class="form-control" id="fechaHospital1" name="fechaHospital1">
																						</div>
																						<div class="col-md-6">
																							<input type="time" class="form-control" id="horaHospital1" name="horaHospital1">
																						</div>
																					</div>
																				</div>
																				<div class="col-md-4">
																					<div class="row">
																						<div class="col-md-12">
																							<label for="">Fuente Nº 2</label>
																						</div>
																						<div class="col-md-12">
																							<label for="">Nombre</label>
																							<input type="text" class="form-control" id="fuente2" name="fuente2">
																						</div>
																						<div class="col-md-12">
																							<label for="">Fecha del paciente o del examen</label>
																						</div>
																						<div class="col-md-12">
																							<input type="date" class="form-control" id="fechaPaciente2" name="fechaPaciente2">
																						</div>
																						<div class="col-md-12">
																							<label for="">Fecha de la hospitalización o exámen</label>
																						</div>
																						<div class="col-md-6">
																							<input type="date" class="form-control" id="fechaHospital2" name="fechaHospital2">
																						</div>
																						<div class="col-md-6">
																							<input type="time" class="form-control" id="horaHospital2" name="horaHospital2">
																						</div>
																					</div>
																				</div>
																				<div class="col-md-4">
																					<div class="row">
																						<div class="col-md-12">
																							<label for="">Fuente Nº 3</label>
																						</div>
																						<div class="col-md-12">
																							<label for="">Nombre</label>
																							<input type="text" class="form-control" id="fuente3" name="fuente3">
																						</div>
																						<div class="col-md-12">
																							<label for="">Fecha del paciente o del examen</label>
																						</div>
																						<div class="col-md-12">
																							<input type="date" class="form-control" id="fechaPaciente3" name="fechaPaciente3">
																						</div>
																						<div class="col-md-12">
																							<label for="">Fecha de la hospitalización o exámen</label>
																						</div>
																						<div class="col-md-6">
																							<input type="date" class="form-control" id="fechaHospital3" name="fechaHospital3">
																						</div>
																						<div class="col-md-6">
																							<input type="time" class="form-control" id="horaHospital3" name="horaHospital3">
																						</div>
																					</div>
																				</div>
																			</div>
																			<hr>
																			<div class="row">
																				<div class="col-md-6">
																					<label for="">Fecha último contacto</label>
																					<input type="date" class="form-control" id="fechacontacto" name="fechacontacto">
																				</div>
																				<div class="col-md-6">
																					<label for="">Estadio</label> <br>
																					<input type="radio" id="estadio1" selected name="estadio" value="1"><span class="ml-2">Vivo</span>
																					<input type="radio" id="estadio2" name="estadio" value="2"><span class="ml-2">Muerto</span>
																					<input type="radio" id="estadio3" name="estadio" value="3"><span class="ml-2">Sin información</span>
																				</div>
																			</div>
																			<hr>
																			<div class="row">
																				<div class="col-md-6">
																					<label for="">Defunción</label>
																					<input type="date" class="form-control" id="defuncion" name="defuncion">
																				</div>
																				<div class="col-md-6">
																					<label for="">Causa</label><br>
																					<input type="radio" id="causa1" name="causa" value="1"><span class="ml-2">Cáncer</span>
																					<input type="radio" id="causa2" name="causa" value="2"><span class="ml-2">Otra</span>
																					<input type="radio" id="causa3" name="causa" value="3"><span class="ml-2">Desconocido</span>
																				</div>
																			</div>
																			<hr>
																			<div class="row">
																				<div class="col-md-12">
																					<label for="">Observacion</label>
																					<textarea name="observacionfinal" id="observacionfinal" class="form-control" cols="30" rows="10"></textarea>
																				</div>
																			</div>
																			<input type="hidden" id="pacientepoblacional" name="pacientepoblacional" value="<?php echo $pacienteid; ?>">
																			<input type="hidden" id="proveniencia" name="proveniencia" value="1">
																			<div class="row">
																				<div class="col-md-12 text-right">
																					<button class="btn btn-outline-success" onclick="newregispoblacional()"><i class="fa fa-save"></i> Guardar</button>
																				</div>
																			</div>
																		</div>
																	</div>
																</div>
																</div>
															</div>
														</div>
													<?php
													}
													?>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- ROW-4 END -->


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
	<script src="JsFunctions/registropoblacional.js"></script>
	<script src="JsFunctions/function.js"></script>

	<script>
		//Cargar Tabla
		$(document).ready(function() {
			cargarsignos();
			cargarmedidas();
		});
	</script>


</body>

</html>