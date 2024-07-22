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

$pacienteid = 0;
$paciente = null;
if (isset($_GET['code'])) {
	$pacienteid = $_GET['code'];
	if ($pacienteid <= 0 || !is_numeric($pacienteid)) {
		header("Location: pacientes.php");
	}
	$paciente = $c->buscarpaciente($pacienteid);
	if ($paciente == null) {
		header("Location: pacientes.php");
	}
}


if (!isset($_SESSION['USER_ID'])) {
	header("Location: signin.php");
} else {
	$valid  = $c->validarsesion($_SESSION['USER_ID'], $_SESSION['USER_TOKEN']);
	if ($valid == false) {
		header("Location: lockscreen.php");
	}
}
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

$inscripcion = $c->listarinscripcionprevision($pacienteid);
$datosubicacion = $c->listardatosubicacion($pacienteid);
$otros = $c->listarotrosantecedentes($pacienteid);
$responsable = $c->listarresponsable($pacienteid);

$rut = $paciente->getRut();
$nombre = $paciente->getNombre();
$apellido1 = $paciente->getApellido1();
$apellido2 = $paciente->getApellido2();
$identificacion = $paciente->getIdentificacion();
$nacionalidad = $paciente->getNacionalidad();
$ficha = "";
$ubicacion = "";
$social = $paciente->getNombresocial();
$ano = date("Y", strtotime($paciente->getFechanacimiento()));
$dia = date("d", strtotime($paciente->getFechanacimiento()));
$mes = date("m", strtotime($paciente->getFechanacimiento()));
$ano_actual = date("Y");
$mes_actual = date("m");
$dia_actual = date("d");
$edad = $ano_actual - $ano;
if ($mes_actual < $mes) {
	$edad--;
} else {
	if ($mes_actual == $mes) {
		if ($dia_actual < $dia) {
			$edad--;
		}
	}
}
$edad = $edad . " años";
$genero = $paciente->getGenero();
$prevision = "";
$estadoafiliacion = "";
$direccion = "";
$fonomovil = $paciente->getFonomovil();
$email = $paciente->getEmail();
$inscrito = "";

if ($inscripcion != null) {
	$ficha = $inscripcion->getFicha();
	$ubicacion = $inscripcion->getUbicacionficha();
	$prevision = $inscripcion->getTipoprevision();
	$prevision = $c->buscartipoprevisionvalores($prevision);
	$prevision = $prevision->getCodigo() . " - " . $prevision->getNombre();
	$estadoafiliacion = $inscripcion->getEstadoafiliar();
	if ($estadoafiliacion == 1) {
		$estadoafiliacion = "Activo";
	} else if ($estadoafiliacion == 2) {
		$estadoafiliacion = "Inactivo";
	}
	$inscrito = $inscripcion->getInscrito();
}

if ($datosubicacion != null) {
	$direccion = $datosubicacion->getNombrecalle() . " " . $datosubicacion->getNumerocalle();
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
	<title>OncoWay | Registro Poblacional</title>

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
							<!--------------------------Inicio Ficha paciente----------------->
							<li class="nav-item">
								<a class="nav-link with-sub" href="#"><i class="fe fe-map-pin sidemenu-icon"></i><span class="sidemenu-label">Ficha Clinica</span><i class="angle fe fe-chevron-right"></i></a>
								<ul class="nav-sub">
									<li class="nav-sub-item">
										<a class="nav-sub-link" href="pacientes.php">Ficha paciente</a>
									</li>
									<li class="nav-sub-item">
										<a class="nav-sub-link" href="registropacientes.php">Registro paciente</a>
									</li>
									<?php
									if ($admingeneralrol == true || $adminsistemarol == true || $fichaclinicas == true) {
									?>
										<li class="nav-sub-item">
											<a class="nav-sub-link" href="listadopacientes.php">Listado paciente</a>
										</li>
									<?php
									}
									?>

								</ul>
							</li>
							<!--------------------------Fin Ficha paciente----------------->
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
										<a class="nav-sub-link" href="pacientemedico.php">Ficha paciente</a>
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
								<p class="main-notification-text"><?php echo $object1->getProfesion(); ?>
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
									<p class="main-notification-text"><?php echo $object1->getProfesion(); ?>
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

					<div class="row "> <?php if ($paciente != null) { ?>
							<div class="col-lg-12">
								<div class="card orverflow-hidden">
									<div class="card-body">
										<form id="diagcieoform" name="diagcieoform" class="needs-validation was-validated">
											<div class="row">
												<div class="col-lg-3">
													<div class="form-group has-success mg-b-0">
														<label>RUT:</label>
														<input class="form-control" id="rutsearch" readonly name="rutsearch" placeholder="11.111.111-1" type="text" maxlength="12" value="<?php echo $rut; ?>">
													</div>
												</div>
											</div>
											<div class="row  datospaciente">
												<div class="col-lg-3">
													<div class="form-group has-success mg-b-0">
														<label>Numero Ficha:</label>
														<input class="form-control" readonly id="fichasearch" name="fichasearch" placeholder="N° Ficha" required="" type="number" value="<?php echo $ficha; ?>">
													</div>
												</div>
												<div class="col-lg-3">
													<div class="form-group has-success mg-b-0">
														<label>Ubicacion:</label>
														<input class="form-control" readonly id="ubicacionsearch" name="ubicacionsearch" placeholder="Ubicacion" required="" type="text" value="<?php echo $ubicacion; ?>">
													</div>
												</div>
												<div class="col-lg-3">
													<div class="form-group has-success mg-b-0">
														<label>Pasaporte/DNI/NIE:</label>
														<input class="form-control" readonly id="documentsearch" name="documentsearch" placeholder="Pasaporte" required="" type="text" value="<?php echo $identificacion; ?>">
													</div>
												</div>
												<div class="col-lg-3">
													<div class="form-group has-success mg-b-0">
														<label>Nacionalidad:</label>
														<input class="form-control" readonly id="nacionalidadsearch" name="nacionalidadsearch" placeholder="Nacionalidad" required="" type="text" value="<?php echo $c->nombrenacionalidad($nacionalidad); ?>">
													</div>
												</div>
												<div class="col-lg-3">
													<div class="form-group has-success mg-b-0">
														<label>Nombre:</label>
														<input class="form-control" readonly id="nombresearch" name="nombresearch" placeholder="Nombre" required="" type="text" value="<?php echo $nombre; ?>">
													</div>
												</div>
												<div class="col-lg-3">
													<div class="form-group has-success mg-b-0">
														<label>Apellido Paterno:</label>
														<input class="form-control" readonly id="apellidosearch" name="apellidosearch" placeholder="Primer Apellido" required="" type="text" value="<?php echo $apellido1; ?>">
													</div>
												</div>
												<div class="col-lg-3">
													<div class="form-group has-success mg-b-0">
														<label>Apellido Materno:</label>
														<input class="form-control" readonly id="apellido1search" name="apellido1search" placeholder="Segundo Apellido" required="" type="text" value="<?php echo $apellido2; ?>">
													</div>
												</div>
												<div class="col-lg-3">
													<div class="form-group has-success mg-b-0">
														<label>Nombre Social:</label>
														<input class="form-control" readonly id="nombresocialsearch" name="nombresocialsearch" placeholder="Nombre Social" required="" type="text" value="<?php echo $social; ?>">
													</div>
												</div>
												<div class="col-lg-3">
													<div class="form-group has-success mg-b-0">
														<label>Edad:</label>
														<input class="form-control" readonly id="edadsearch" name="edadsearch" placeholder="Edad" required="" type="text" value="<?php echo $edad; ?>">
													</div>
												</div>
												<div class="col-lg-3">
													<div class="form-group has-success mg-b-0">
														<label>Genero:</label>
														<input class="form-control" readonly id="sexosearch" name="sexosearch" placeholder="Sexo" required="" type="text" value="<?php echo $c->nombregenero($genero); ?>">
													</div>
												</div>
												<div class="col-lg-3">
													<div class="form-group has-success mg-b-0">
														<label>Prevision:</label>
														<input class="form-control" readonly id="previsionsearch" name="previsionsearch" placeholder="Prevision" required="" type="text" value="<?php echo $prevision; ?>">
													</div>
												</div>
												<div class="col-lg-3">
													<div class="form-group has-success mg-b-0">
														<label>Estado Afiliacion:</label>
														<input class="form-control" readonly id="estadoafiliacionsearch" name="estadoafiliacionsearch" placeholder="Estado Afiliacion" required="" type="text" value="<?php echo $estadoafiliacion; ?>">
													</div>
												</div>
												<div class="col-lg-3">
													<div class="form-group has-success mg-b-0">
														<label>Dirección:</label>
														<input class="form-control" readonly id="direccionsearch" name="direccionsearch" placeholder="Direccion" required="" type="text" value="<?php echo $direccion; ?>">
													</div>
												</div>
												<div class="col-lg-3">
													<div class="form-group has-success mg-b-0">
														<label>Fonos Contacto:</label>
														<input class="form-control" readonly id="fonosearch" name="fonosearch" placeholder="Fono Contacto" required="" type="text" value="<?php echo $fonomovil; ?>">
													</div>
												</div>
												<div class="col-lg-3">
													<div class="form-group has-success mg-b-0">
														<label>Correo Electronico:</label>
														<input class="form-control" readonly id="correosearch" name="correosearch" placeholder="Correo Electronico" required="" type="text" value="<?php echo $email; ?>">
													</div>
												</div>
												<div class="col-lg-3">
													<div class="form-group has-success mg-b-0">
														<label>Inscrito:</label>
														<input class="form-control" readonly id="inscritosearch" name="inscritosearch" placeholder="Inscrito" required="" type="text" value="<?php echo $inscrito; ?>">
													</div>
												</div>
											</div>
										</form>
									</div>
								</div>
							</div>
						<?php } ?>
					</div>

					<div class="row">
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
											if ($ultimoregistro != null) {
												echo "<a href='php/reporte/registropoblacional.php?id=" . $ultimoregistro['id'] . "' target='_blank' class='btn btn-outline-info' title='Imprimir'><i class='fa fa-print'></i> Imprimir Registro</a>";
												echo "<button type='button' class='btn btn-outline-success' title='Historial de Registros' onclick='cargarhistorialregistros()' ><i class='fa fa-history'></i> Historial de Registros</button>";
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
											<input type="checkbox" class="mr-1" value="1" name="rama" id="rama1" <?php if($ultimoregistro!=null){if($ultimoregistro['rama1']==1){ echo "checked";}}?>><span>Agricultura, Caza, Silvicultura y Pesca</span><br />
											<input type="checkbox" class="mr-1" value="1" name="rama" id="rama2" <?php if($ultimoregistro!=null){if($ultimoregistro['rama2']==1){ echo "checked";}}?>><span>Minas y Canteras</span><br />
											<input type="checkbox" class="mr-1" value="1" name="rama" id="rama3" <?php if($ultimoregistro!=null){if($ultimoregistro['rama3']==1){ echo "checked";}}?>><span>Industria Manufacturera</span><br />
											<input type="checkbox" class="mr-1" value="1" name="rama" id="rama4" <?php if($ultimoregistro!=null){if($ultimoregistro['rama4']==1){ echo "checked";}}?>><span>Electricidad, Gas y Agua</span>
										</div>
										<div class="col-md-4">
											<input type="checkbox" class="mr-1" value="1" name="rama" id="rama5" <?php if($ultimoregistro!=null){if($ultimoregistro['rama5']==1){ echo "checked";}}?>><span>Construcción</span><br />
											<input type="checkbox" class="mr-1" value="1" name="rama" id="rama6" <?php if($ultimoregistro!=null){if($ultimoregistro['rama6']==1){ echo "checked";}}?>><span>Comercio mayor y menor, restaurant y hotel</span><br />
											<input type="checkbox" class="mr-1" value="1" name="rama" id="rama7" <?php if($ultimoregistro!=null){if($ultimoregistro['rama7']==1){ echo "checked";}}?>><span>Transporte, Almacenamiento y Comunicaciones</span><br />
											<input type="checkbox" class="mr-1" value="1" name="rama" id="rama8" <?php if($ultimoregistro!=null){if($ultimoregistro['rama8']==1){ echo "checked";}}?>><span>Servicios Financierios</span>
										</div>
										<div class="col-md-4">
											<input type="checkbox" class="mr-1" value="1" name="rama" id="rama9" <?php if($ultimoregistro!=null){if($ultimoregistro['rama9']==1){ echo "checked";}}?>><span>Servicios Comunales, Sociales, Personales</span><br />
											<input type="checkbox" class="mr-1" value="1" name="rama" id="rama10" <?php if($ultimoregistro!=null){if($ultimoregistro['rama10']==1){ echo "checked";}}?>><span>Actividad no especificada</span>
										</div>
									</div>
									<hr>
									<div class="row">
										<div class="col-md-12">
											<label for=""><strong>Ocupación</strong></label>
										</div>
										<div class="col-md-4">
											<input type="checkbox" class="mr-1" value="1" name="ocupacion" id="ocupacion1" <?php if($ultimoregistro!=null){if($ultimoregistro['ocupacion1']==1){ echo "checked";}}?>><span>Profesionales, Técnicos y Afines</span><br />
											<input type="checkbox" class="mr-1" value="1" name="ocupacion" id="ocupacion2" <?php if($ultimoregistro!=null){if($ultimoregistro['ocupacion2']==1){ echo "checked";}}?>><span>Gerentes, Administradores y Directivos</span><br />
											<input type="checkbox" class="mr-1" value="1" name="ocupacion" id="ocupacion3" <?php if($ultimoregistro!=null){if($ultimoregistro['ocupacion3']==1){ echo "checked";}}?>><span>Empleados oficina y afines</span><br />
											<input type="checkbox" class="mr-1" value="1" name="ocupacion" id="ocupacion4" <?php if($ultimoregistro!=null){if($ultimoregistro['ocupacion4']==1){ echo "checked";}}?>><span>Vendedores y afines</span>
										</div>
										<div class="col-md-4">
											<input type="checkbox" class="mr-1" value="1" name="ocupacion" id="ocupacion5" <?php if($ultimoregistro!=null){if($ultimoregistro['ocupacion5']==1){ echo "checked";}}?>><span>Agricultores, Ganadores, Pescadores</span><br />
											<input type="checkbox" class="mr-1" value="1" name="ocupacion" id="ocupacion6" <?php if($ultimoregistro!=null){if($ultimoregistro['ocupacion6']==1){ echo "checked";}}?>><span>Conductores y afines</span><br />
											<input type="checkbox" class="mr-1" value="1" name="ocupacion" id="ocupacion7" <?php if($ultimoregistro!=null){if($ultimoregistro['ocupacion7']==1){ echo "checked";}}?>><span>Artesanos y Operarios</span><br />
											<input type="checkbox" class="mr-1" value="1" name="ocupacion" id="ocupacion8" <?php if($ultimoregistro!=null){if($ultimoregistro['ocupacion8']==1){ echo "checked";}}?>><span>Otros Artesanos y Operarios</span>
										</div>
										<div class="col-md-4">
											<input type="checkbox" class="mr-1" value="1" name="ocupacion" id="ocupacion9" <?php if($ultimoregistro!=null){if($ultimoregistro['ocupacion9']==1){ echo "checked";}}?>><span>Obreros y Jornaleros N.E.O.C</span><br />
											<input type="checkbox" class="mr-1" value="1" name="ocupacion" id="ocupacion10" <?php if($ultimoregistro!=null){if($ultimoregistro['ocupacion10']==1){ echo "checked";}}?>><span>Trabajadores en Servicios Personales</span><br />
											<input type="checkbox" class="mr-1" value="1" name="ocupacion" id="ocupacion11" <?php if($ultimoregistro!=null){if($ultimoregistro['ocupacion11']==1){ echo "checked";}}?>><span>Otros trabajadores N.E.O.C. 2/</span>
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
													<div class="row align-items-center">
														<div class="col-md-12" style="margin: 0;">
															<label for="">Sitio Primario:<br>(Topografía)</label>
														</div>
														<div class="col-md-1" style="margin: 0;">
															<label for="">C</label>
														</div>
														<div class="col-md-2" style="margin: 0;">
															<input type="text" class="form-control" id="sp1" name="sp1" value="<?php if($ultimoregistro!=null){echo $ultimoregistro['sp1'];}?>">
														</div>
														<div class="col-md-2" style="margin: 0;">
															<input type="text" class="form-control" id="sp2" name="sp2" value="<?php if($ultimoregistro!=null){echo $ultimoregistro['sp2'];}?>">
														</div>
														<div class="col-md-1 text-center" style="margin: 0; font-size:40px;">
															<label for="" class="text-center">.</label>
														</div>
														<div class="col-md-2" style="margin: 0;">
															<input type="text" class="form-control" id="sp3" name="sp3" value="<?php if($ultimoregistro!=null){echo $ultimoregistro['sp3'];}?>">
														</div>
													</div>
													<div class="row align-items-center">
														<div class="col-md-12">
															<label for="">Tipo Histológico:<br>(Morfología)</label>
														</div>
														<div class="col-md-2">
															<input type="text" class="form-control" id="th1" name="th1" value="<?php if($ultimoregistro!=null){echo $ultimoregistro['th1'];}?>">
														</div>
														<div class="col-md-1">
															<label for="">_</label>
														</div>
														<div class="col-md-2">
															<input type="text" class="form-control" id="th2" name="th2" value="<?php if($ultimoregistro!=null){echo $ultimoregistro['th2'];}?>">
														</div>
														<div class="col-md-2">
															<input type="text" class="form-control" id="th3" name="th3" value="<?php if($ultimoregistro!=null){echo $ultimoregistro['th3'];}?>">
														</div>
														<div class="col-md-2">
															<input type="text" class="form-control" id="th4" name="th4" value="<?php if($ultimoregistro!=null){echo $ultimoregistro['th4'];}?>">
														</div>
														<div class="col-md-2">
															<input type="text" class="form-control" id="th5" name="th5" value="<?php if($ultimoregistro!=null){echo $ultimoregistro['th5'];}?>">
														</div>
													</div>
													<div class="row align-items-center">
														<div class="col-md-12">
															<label for="">Comportamiento</label>
														</div>
														<div class="col-md-12">
															<input type="text" class="form-control" id="comportamiento" name="comportamiento" value="<?php if($ultimoregistro!=null){echo $ultimoregistro['comportamiento'];}?>">
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<label for="">Observaciones:</label>
											<textarea name="comportamientoobservaciones" id="comportamientoobservaciones" class="form-control" cols="30" rows="10"><?php if($ultimoregistro!=null){echo $ultimoregistro['comportamientoobservaciones'];}?></textarea>
										</div>
									</div>

									<hr>
									<div class="row">
										<div class="col-md-4">
											<label for=""><strong>Grado de diferenciación</strong></label><br />
											<input type="checkbox" class="mr-1" value="1" name="grado" id="grado1" <?php if($ultimoregistro!=null){if($ultimoregistro['grado1']==1){ echo "checked";}}?>><span>Bien diferenciado</span><br />
											<input type="checkbox" class="mr-1" value="1" name="grado" id="grado2" <?php if($ultimoregistro!=null){if($ultimoregistro['grado2']==1){ echo "checked";}}?>><span>Moderadamente diferenciado</span><br />
											<input type="checkbox" class="mr-1" value="1" name="grado" id="grado3" <?php if($ultimoregistro!=null){if($ultimoregistro['grado3']==1){ echo "checked";}}?>><span>Pobremente diferenciado</span><br />
											<input type="checkbox" class="mr-1" value="1" name="grado" id="grado4" <?php if($ultimoregistro!=null){if($ultimoregistro['grado4']==1){ echo "checked";}}?>><span>Indiferenciado o anaplásico</span><br />
											<input type="checkbox" class="mr-1" value="1" name="grado" id="grado5" <?php if($ultimoregistro!=null){if($ultimoregistro['grado5']==1){ echo "checked";}}?>><span>No determinado o inaplicable</span>
										</div>
										<div class="col-md-4">
											<label for=""><strong>Extensión</strong></label><br />
											<input type="checkbox" class="mr-1" value="1" name="extension" id="extension1" <?php if($ultimoregistro!=null){if($ultimoregistro['extension1']==1){ echo "checked";}}?>><span>In situ</span><br />
											<input type="checkbox" class="mr-1" value="1" name="extension" id="extension2" <?php if($ultimoregistro!=null){if($ultimoregistro['extension2']==1){ echo "checked";}}?>><span>Localizada</span><br />
											<input type="checkbox" class="mr-1" value="1" name="extension" id="extension3" <?php if($ultimoregistro!=null){if($ultimoregistro['extension3']==1){ echo "checked";}}?>><span>Regional</span><br />
											<input type="checkbox" class="mr-1" value="1" name="extension" id="extension4" <?php if($ultimoregistro!=null){if($ultimoregistro['extension4']==1){ echo "checked";}}?>><span>Metástasis</span><br />
											<input type="checkbox" class="mr-1" value="1" name="extension" id="extension5" <?php if($ultimoregistro!=null){if($ultimoregistro['extension5']==1){ echo "checked";}}?>><span>Desconocido</span>
										</div>
										<div class="col-md-4">
											<label for=""><strong>Lateralidad</strong></label><br />
											<input type="checkbox" class="mr-1" value="1" name="lateralidad" id="lateralidad1" <?php if($ultimoregistro!=null){if($ultimoregistro['lateralidad1']==1){ echo "checked";}}?>><span>Derecho</span><br />
											<input type="checkbox" class="mr-1" value="1" name="lateralidad" id="lateralidad2" <?php if($ultimoregistro!=null){if($ultimoregistro['lateralidad2']==1){ echo "checked";}}?>><span>Izquierdo</span><br />
											<input type="checkbox" class="mr-1" value="1" name="lateralidad" id="lateralidad3" <?php if($ultimoregistro!=null){if($ultimoregistro['lateralidad3']==1){ echo "checked";}}?>><span>Bilateral</span><br />
											<input type="checkbox" class="mr-1" value="1" name="lateralidad" id="lateralidad4" <?php if($ultimoregistro!=null){if($ultimoregistro['lateralidad4']==1){ echo "checked";}}?>><span>No corresponde</span><br />
											<input type="checkbox" class="mr-1" value="1" name="lateralidad" id="lateralidad5" <?php if($ultimoregistro!=null){if($ultimoregistro['lateralidad5']==1){ echo "checked";}}?>><span>Desconocido</span>
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
													<input type="date" class="form-control" id="fechaIncidencia" name="fechaIncidencia" value="<?php if($ultimoregistro!=null){echo $ultimoregistro['fechaincidencia'];}?>">
												</div>
												<div class="col-md-3">
													<input type="time" class="form-control" id="horaIncidencia" name="horaIncidencia" value="<?php if($ultimoregistro!=null){echo $ultimoregistro['horaincidencia'];}?>">
												</div>
											</div>
										</div>
										<div class="col-md-12">
											<label for=""><strong>Base del Diágnóstico (El principal)</strong></label>
										</div>
										<div class="col-md-4">
											<input type="checkbox" class="mr-1" value="1" name="baseDiagnostico" id="baseDiagnostico1" <?php if($ultimoregistro!=null){if($ultimoregistro['basediagnostico1']==1){ echo "checked";}}?>><span>Sólo certificado de defunción</span><br />
											<input type="checkbox" class="mr-1" value="2" name="baseDiagnostico" id="baseDiagnostico2" <?php if($ultimoregistro!=null){if($ultimoregistro['basediagnostico2']==1){ echo "checked";}}?>><span>Sólo Clínica</span><br />
											<input type="checkbox" class="mr-1" value="3" name="baseDiagnostico" id="baseDiagnostico3" <?php if($ultimoregistro!=null){if($ultimoregistro['basediagnostico3']==1){ echo "checked";}}?>><span>Investigación clínica</span><br />
										</div>
										<div class="col-md-4">
											<input type="checkbox" class="mr-1" value="4" name="baseDiagnostico" id="baseDiagnostico4" <?php if($ultimoregistro!=null){if($ultimoregistro['basediagnostico4']==1){ echo "checked";}}?>><span>Extámenes bioquímicos / inmunológicos</span><br />
											<input type="checkbox" class="mr-1" value="5" name="baseDiagnostico" id="baseDiagnostico5" <?php if($ultimoregistro!=null){if($ultimoregistro['basediagnostico5']==1){ echo "checked";}}?>><span>Citología / hematología</span><br />
											<input type="checkbox" class="mr-1" value="6" name="baseDiagnostico" id="baseDiagnostico6" <?php if($ultimoregistro!=null){if($ultimoregistro['basediagnostico6']==1){ echo "checked";}}?>><span>Histología de Metástasis</span><br />
										</div>
										<div class="col-md-4">
											<input type="checkbox" class="mr-1" value="7" name="baseDiagnostico" id="baseDiagnostico7" <?php if($ultimoregistro!=null){if($ultimoregistro['basediagnostico7']==1){ echo "checked";}}?>><span>Histología de cáncer primario</span><br />
											<input type="checkbox" class="mr-1" value="8" name="baseDiagnostico" id="baseDiagnostico8" <?php if($ultimoregistro!=null){if($ultimoregistro['basediagnostico8']==1){ echo "checked";}}?>><span>Desconocido</span>
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
													<input type="text" class="form-control" id="fuente1" name="fuente1" value="<?php if($ultimoregistro!=null){echo $ultimoregistro['fuente1'];}?>">
												</div>
												<div class="col-md-12">
													<label for="">N° Ficha del paciente o del examen</label>
												</div>
												<div class="col-md-12">
													<input type="text" class="form-control" id="fichaPaciente1" name="fichaPaciente1" value="<?php if($ultimoregistro!=null){echo $ultimoregistro['fichapacex1'];}?>">
												</div>
												<div class="col-md-12">
													<label for="">Fecha de la hospitalización o exámen</label>
												</div>
												<div class="col-md-6">
													<input type="date" class="form-control" id="fechaHospital1" name="fechaHospital1" value="<?php if($ultimoregistro!=null){echo $ultimoregistro['fechahospex1'];}?>">
												</div>
												<div class="col-md-6">
													<input type="time" class="form-control" id="horaHospital1" name="horaHospital1" value="<?php if($ultimoregistro!=null){echo $ultimoregistro['horahospex1'];}?>">
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
													<input type="text" class="form-control" id="fuente2" name="fuente2" value="<?php if($ultimoregistro!=null){echo $ultimoregistro['fuente2'];}?>">
												</div>
												<div class="col-md-12">
													<label for="">N° Ficha del paciente o del examen</label>
												</div>
												<div class="col-md-12">
													<input type="text" class="form-control" id="fichaPaciente2" name="fichaPaciente2" value="<?php if($ultimoregistro!=null){echo $ultimoregistro['fichapacex2'];}?>">
												</div>
												<div class="col-md-12">
													<label for="">Fecha de la hospitalización o exámen</label>
												</div>
												<div class="col-md-6">
													<input type="date" class="form-control" id="fechaHospital2" name="fechaHospital2" value="<?php if($ultimoregistro!=null){echo $ultimoregistro['fechahospex2'];}?>">
												</div>
												<div class="col-md-6">
													<input type="time" class="form-control" id="horaHospital2" name="horaHospital2" value="<?php if($ultimoregistro!=null){echo $ultimoregistro['horahospex2'];}?>">
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
													<input type="text" class="form-control" id="fuente3" name="fuente3" value="<?php if($ultimoregistro!=null){echo $ultimoregistro['fuente3'];}?>">
												</div>
												<div class="col-md-12">
													<label for="">N° Ficha del paciente o del examen</label>
												</div>
												<div class="col-md-12">
													<input type="text" class="form-control" id="fichaPaciente3" name="fichaPaciente3" value="<?php if($ultimoregistro!=null){echo $ultimoregistro['fichapacex3'];}?>">
												</div>
												<div class="col-md-12">
													<label for="">Fecha de la hospitalización o exámen</label>
												</div>
												<div class="col-md-6">
													<input type="date" class="form-control" id="fechaHospital3" name="fechaHospital3" value="<?php if($ultimoregistro!=null){echo $ultimoregistro['fechahospex3'];}?>">
												</div>
												<div class="col-md-6">
													<input type="time" class="form-control" id="horaHospital3" name="horaHospital3" value="<?php if($ultimoregistro!=null){echo $ultimoregistro['horahospex3'];}?>">
												</div>
											</div>
										</div>
									</div>
									<hr>
									<div class="row">
										<div class="col-md-6">
											<label for="">Fecha último contacto</label>
											<input type="date" class="form-control" id="fechacontacto" name="fechacontacto" value="<?php if($ultimoregistro!=null){echo $ultimoregistro['fechaultimocontacto'];}?>">
										</div>
										<div class="col-md-6">
											<label for="">Estadio</label> <br>
											<input type="radio" id="estadio1" name="estadio" value="1" <?php if($ultimoregistro!=null){if($ultimoregistro['estadio']==1){ echo "checked";}}else{echo "checked";}?>><span class="ml-2">Vivo</span>
											<input type="radio" id="estadio2" name="estadio" value="2" <?php if($ultimoregistro!=null){if($ultimoregistro['estadio']==2){ echo "checked";}}?>><span class="ml-2">Muerto</span>
											<input type="radio" id="estadio3" name="estadio" value="3" <?php if($ultimoregistro!=null){if($ultimoregistro['estadio']==3){ echo "checked";}}?>><span class="ml-2">Sin información</span>
										</div>
									</div>
									<hr>
									<div class="row">
										<div class="col-md-6">
											<label for="">Defunción</label>
											<input type="date" class="form-control" id="defuncion" name="defuncion" value="<?php if($ultimoregistro!=null){echo $ultimoregistro['defuncion'];}?>">
										</div>
										<div class="col-md-6">
											<label for="">Causa</label><br>
											<input type="radio" id="causa1" name="causa" value="1" <?php if($ultimoregistro!=null){if($ultimoregistro['causa']==1){ echo "checked";}}?>><span class="ml-2">Cáncer</span>
											<input type="radio" id="causa2" name="causa" value="2" <?php if($ultimoregistro!=null){if($ultimoregistro['causa']==2){ echo "checked";}}?>><span class="ml-2">Otra</span>
											<input type="radio" id="causa3" name="causa" value="3" <?php if($ultimoregistro!=null){if($ultimoregistro['causa']==3){ echo "checked";}}?>><span class="ml-2">Desconocido</span>
										</div>
									</div>
									<hr>
									<div class="row">
										<div class="col-md-12">
											<label for="">Observacion</label>
											<textarea name="observacionfinal" id="observacionfinal" class="form-control" cols="30" rows="10"><?php if($ultimoregistro!=null){echo $ultimoregistro['obsersavacionfinal'];}?></textarea>
										</div>
									</div>
									<input type="hidden" id="pacientepoblacional" name="pacientepoblacional" value="<?php echo $pacienteid; ?>">
									<input type="hidden" id="proveniencia" name="proveniencia" value="1">
									<div class="row">
										<div class="col-md-12 text-right">
											<button class="btn btn-outline-success" onclick="registropoblacional()"><i class="fa fa-save"></i> Guardar</button>
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

		<div class="modal" id="modalhistorial">
			<div class="modal-dialog modal-xl" role="document">
				<div class="modal-content modal-content-demo">
					<div class="modal-header">
						<h6 class="modal-title">Historial De registros</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
					</div>
					<div class="modal-body">
						<div class="row">
							<div class="col-md-12" id="historialregistros">
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button class="btn ripple btn-primary" type="button" data-dismiss="modal">Cerrar</button>
					</div>
				</div>
			</div>
		</div>

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
	<script src="JsFunctions/function.js"></script>
	<script src="JsFunctions/main.js"></script>
	<script src="JsFunctions/registropoblacional.js"></script>
</body>

</html>