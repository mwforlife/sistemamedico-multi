<?php
require 'php/validation/config.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
require 'php/controller.php';
$c = new Controller();
$empresa = null;
if (isset($_SESSION['CURRENT_ENTERPRISE'])) {
	$enterprise = $_SESSION['CURRENT_ENTERPRISE'];
	$empresa = $c->buscarEmpresa($enterprise);
} else {
	header("Location: index.php");
}
$comite = null;
// Obtener la URL de la página anterior (si está disponible)
$previous_page = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
$id = 0;
$comite = 0;
$idcomite = 0;
$dipaciente = 0;
if (isset($_GET['code']) && isset($_GET['comite'])) {
	$id = $_GET['code'];
	$dipaciente = $id;
	$comite = $_GET['comite'];
	$r = $c->buscarpaciente($id);
	$pacientecomite = $c->buscarpacientecomite($comite);
	if ($r == null) {
		// Redireccionar a la página anterior
		header("Location: $previous_page");
		exit();
	}
	if ($pacientecomite == null) {
		// Redireccionar a la página anterior
		header("Location: $previous_page");
		exit();
	}
	$idcomite = $comite;
} else {
	//Redireccionar a la página anterior
	header("Location: $previous_page");
	exit();
}
$sig = $c->buscarsignovital($id);
$med = $c->buscarmedidaantropometrica($id);
$inscripcion = $c->listarinscripcionprevision($id);
$ubicacion = $c->listardatosubicacion($id);
$peso = "";
$talla = "";
$supcop = "";
$ficha = "";
$admision = "";
$prevision = "";
$comuna = "";
$establecimiento = "";

if ($med != null) {
	$peso = $med->getPeso();
	$talla = $med->getTalla();
	$supcop = $c->calculateBSA($talla, $peso);
}
if ($inscripcion != null) {
	$ficha = $inscripcion->getFicha();
	$admision = date("d-m-Y", strtotime($inscripcion->getFechaadmision()));
	$tipoprevision = $inscripcion->getTipoprevision();
	$tipoprevision = $c->buscartipoprevision($tipoprevision);
	$prevision = $tipoprevision->getCodigo();
	$tipoprevision = $tipoprevision->getNombre();
	$prevision = $c->buscarprevision($prevision);
	$prevision = $prevision->getNombre() . " " . $tipoprevision;
	$establecimiento = $inscripcion->getInscrito();
}
if ($ubicacion != null) {
	$comuna = $ubicacion->getComuna();
	$comuna = $c->buscarencomuna($comuna);
	$comuna = $comuna->getNombre();
}
$rut = $r->getRut();
$nombre = $r->getNombre();
$apellido1 = $r->getApellido1();
$apellido2 = $r->getApellido2();
$estadocivil = $r->getEstadocivil();
$estadocivil = $c->buscarnombreestadocivil($estadocivil);

//Fecha de nacimiento en texto
$dia = date("d", strtotime($r->getFechanacimiento()));
$mes = date("m", strtotime($r->getFechanacimiento()));
$mestexto = "";
$ano = date("Y", strtotime($r->getFechanacimiento()));

//Mes en texto
switch ($mes) {
	case 1:
		$mestexto = "Enero";
		break;
	case 2:
		$mestexto = "Febrero";
		break;
	case 3:
		$mestexto = "Marzo";
		break;
	case 4:
		$mestexto = "Abril";
		break;
	case 5:
		$mestexto = "Mayo";
		break;
	case 6:
		$mestexto = "Junio";
		break;
	case 7:
		$mestexto = "Julio";
		break;
	case 8:
		$mestexto = "Agosto";
		break;
	case 9:
		$mestexto = "Septiembre";
		break;
	case 10:
		$mestexto = "Octubre";
		break;
	case 11:
		$mestexto = "Noviembre";
		break;
	case 12:
		$mestexto = "Diciembre";
		break;
}
$nacimiento = $dia . " de " . $mestexto . " de " . $ano;

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

	<meta charset="utf-8">
	<meta content="width=device-width, initial-scale=1, shrink-to-fit=no" name="viewport">
	<meta name="description" content="">
	<meta name="author" content="">
	<meta name="keywords" content="">

	<!-- Favicon -->
	<link rel="icon" href="assets/img/brand/favicon.ico" type="image/x-icon" />

	<!-- Title -->
	<title>OncoWay | Registrar Informe</title>

	<!-- Bootstrap css-->
	<link href="assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
	<link href="assets/plugins/bootstrap/css/bootstrap.min.css.map" rel="stylesheet" />

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
							<h1 class="main-content-title tx-30">Evaluacion de paciente - Comité</h1>
							<ol class="breadcrumb">
								<li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
							</ol>

						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="card">
								<div class="card-header d-flex justify-content-between">
									<h5>Datos Paciente: RUN: <?php echo $rut . " / " . strtoupper($nombre . " " . $apellido1 . " " . $apellido2); ?></h5>
									<h5>Medico Presenta: <?php echo $pacientecomite->getprofesional(); ?></h5>
								</div>
								<div class="card-body">
									<div class="row">
										<div class="col-md-2">
											<label for="">Peso (KG)</label>
											<p class="form-control"> <?php echo $peso; ?></p>
										</div>
										<div class="col-md-2">
											<label for="">Talla (CM)</label>
											<p class="form-control"> <?php echo $talla; ?></p>
										</div>
										<div class="col-md-2">
											<label for="">Sup Corporal (m2)</label>
											<p class="form-control"> <?php echo $supcop; ?></p>
										</div>
										<div class="col-md-2">
											<label for="">Fecha de Nacimiento</label>
											<p class="form-control"> <?php echo $nacimiento; ?></p>
										</div>
										<div class="col-md-2">
											<label for="">Edad</label>
											<p class="form-control"> <?php echo $edad; ?> años</p>
										</div>
										<div class="col-md-2">
											<label for="">Funcionario</label>
											<p class="form-control"><?php if ($r->getFuncionario() == 1) {
																		echo "Si";
																	} else {
																		echo "No";
																	} ?></p>
										</div>
										<div class="col-md-2">
											<label for="">Ficha</label>
											<p class="form-control"> <?php echo $ficha; ?></p>
										</div>
										<div class="col-md-2">
											<label for="">Admision</label>
											<p class="form-control"> <?php echo $admision; ?></p>
										</div>
										<div class="col-md-2">
											<label for="">Previsión</label>
											<p class="form-control"> <?php echo $prevision; ?></p>
										</div>
										<div class="col-md-2">
											<label for="">Estado Civil</label>
											<p class="form-control"> <?php echo $estadocivil; ?></p>
										</div>
										<div class="col-md-2">
											<label for="">Comuna</label>
											<p class="form-control"> <?php echo $comuna; ?></p>
										</div>
										<div class="col-md-2">
											<label for="">Establecimiento Origen</label>
											<p class="form-control"> <?php echo $establecimiento; ?></p>
										</div>
									</div>

								</div>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-12">
							<div class="card">
								<div class="card-body">
									<div class="row">
										<div class="col-md-12">
											<div aria-multiselectable="true" class="accordion" id="accordion" role="tablist">
												<!--Diagnosticos-->
												<div class="card">
													<div class="card-header" id="diagnostic" role="tab">
														<a aria-controls="collapseTwo" aria-expanded="false" class="collapsed" data-toggle="collapse" href="#diagnosticos">Diagnostico</a>
													</div>
													<div aria-labelledby="diagnostico" class="collapse" data-parent="#accordion" id="diagnosticos" role="tabpanel">
														<div class="card-body">
															<div class="row">
																<?php
																$ultimaconsulta = $c->buscarconsultapaciente($dipaciente);
																$diagid = "";
																$diagtext = "";
																$diagcie10 = "";
																$diagcie10text = "";
																if ($ultimaconsulta != null) {
																	$diagid = $ultimaconsulta->getDiagnostico();
																	$diagtext = $ultimaconsulta->getDiagnosticotexto();
																	$diagcie10 = $ultimaconsulta->getDiagnosticocie10();
																	$diagcie10text = $ultimaconsulta->getDiagnosticocie10texto();
																} else {
																	echo "<script>console.log('No hay consultas $dipaciente')</script>";
																}
																?>
																<div class="col-md-4">
																	<label for="">Diagnostico General</label>
																	<button class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#modaldiagnosticos"><i class="fa fa-search"></i></button>
																	<input type="text" class="form-control" id="diagnostico" value="<?php echo $diagtext; ?>">
																	<input type="hidden" class="form-control" id="iddiag" value="<?php echo $diagid; ?>">
																</div>
																<div class="col-md-4">
																	<label for="">Diagnostico CIE10</label>
																	<button class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#modaldiagcie10"><i class="fa fa-search"></i></button>
																	<input type="text" class="form-control" id="diagnosticocie10" value="<?php echo $diagcie10text; ?>">
																	<input type="hidden" class="form-control" id="idcie10" value="<?php echo $diagcie10; ?>">
																</div>
																<div class="col-md-4">
																	<label for="">Fecha de Biopsia</label>
																	<input type="date" class="form-control" id="fechabiopsia">
																</div>
																<div class="col-md-4 d-flex align-items-center">
																	<input type="checkbox" class="mr-1" value="1" id="reingreso">
																	<label style="margin:0;" for="">Reingreso</label>
																</div>
															</div>
														</div>
													</div>
												</div>
												<!--Intervenciones Quirurgicas-->
												<div class="card">
													<div class="card-header" id="intervencion" role="tab">
														<a aria-controls="collapseTwo" aria-expanded="false" class="collapsed" data-toggle="collapse" href="#intervenciones">Diagnostico Clinico</a>
													</div>
													<div aria-labelledby="intervencion" class="collapse" data-parent="#accordion" id="intervenciones" role="tabpanel">
														<div class="card-body">
															<div class="row">
																<div class="col-md-6">
																	<label for="">Ecog</label>
																	<select name="ecog" id="ecog" class="form-control select2">
																		<?php
																		$primario = $c->listarecog();
																		foreach ($primario as $row) {
																			echo "<option value='" . $row->getId() . "'>" . $row->getCodigo() . " - " . $row->getNombre() . "</option>";
																		}
																		?>

																	</select>
																</div>
																<div class="col-md-6">
																	<label for="">Histologico</label>
																	<select name="histologico" id="histologico" class="form-control select2">
																		<?php
																		$primario = $c->listarhistologico();
																		foreach ($primario as $row) {
																			echo "<option value='" . $row->getId() . "'>" . $row->getCodigo() . " - " . $row->getNombre() . "</option>";
																		}
																		?>

																	</select>
																</div>
																<div class="col-md-6 mt-3">
																	<label for="">Invasion Tumoral</label>
																	<select name="invasiontumoral" id="invasiontumoral" class="form-control select2">
																		<?php
																		$primario = $c->listarinvaciontumoral();
																		foreach ($primario as $row) {
																			echo "<option value='" . $row->getId() . "'>" . $row->getNombre() . "</option>";
																		}
																		?>

																	</select>
																</div>
																<div class="col-md-6 mt-3">
																	<label for="">Mitótico/Ki67</label>
																	<select name="mitotico" id="mitotico" class="from-control select2">
																		<?php
																		//porcentajes del 1 al 100
																		for ($i = 1; $i <= 100; $i++) {
																			echo "<option value='" . $i . "'>" . $i . "%</option>";
																		}
																		?>
																	</select>
																</div>
															</div>
														</div>
													</div>
												</div>
												<!--TNM-->
												<div class="card">
													<div class="card-header" id="hospitalizacion" role="tab">
														<a aria-controls="collapseTwo" aria-expanded="false" class="collapsed" data-toggle="collapse" href="#hospitalizaciones">TNM</a>
													</div>
													<div aria-labelledby="hospitalizacion" class="collapse" data-parent="#accordion" id="hospitalizaciones" role="tabpanel">
														<div class="card-body">
															<div class="row">
																<div class="col-md-12">
																	<div class="row">
																		<div class="col-12">
																			<div class="row align-items-center">
																				<div class="col-md-1">
																					<select name="t1" id="t1" class="form-control">
																						<option value=""></option>
																						<option value="y">y</option>
																						<option value="r">r</option>
																					</select>
																				</div>
																				<div class="col-md-1">
																					<select name="t2" id="t2" class="form-control">
																						<option value=""></option>
																						<option value="c">c</option>
																						<option value="p">p</option>
																					</select>
																				</div>
																				<div class="col-md-1">
																					<select name="t" id="t" class="form-control">
																						<?php
																						$t = $c->listartnm(1);
																						foreach ($t as $row) {
																							echo "<option value='" . $row->getId() . "'>" . $row->getNombre() . "</option>";
																						}
																						?>
																					</select>
																				</div>
																				<div class="col-md-1">
																					<select name="n1" id="n1" class="form-control">
																						<option value=""></option>
																						<option value="a">a</option>
																						<option value="v">v</option>
																						<option value="m">m</option>
																					</select>
																				</div>
																				<div class="col-md-1">
																					<select name="n" id="n" class="form-control">
																						<?php
																						$t = $c->listartnm(2);
																						foreach ($t as $row) {
																							echo "<option value='" . $row->getId() . "'>" . $row->getNombre() . "</option>";
																						}
																						?>
																					</select>
																				</div>
																				<div class="col-md-1">
																					<select name="m1" id="m1" class="form-control">
																						<option value=""></option>
																						<option value="a">a</option>
																						<option value="v">v</option>
																					</select>
																				</div>
																				<div class="col-md-1">
																					<select name="m" id="m" class="form-control">
																						<?php
																						$t = $c->listartnm(3);
																						foreach ($t as $row) {
																							echo "<option value='" . $row->getId() . "'>" . $row->getNombre() . "</option>";
																						}
																						?>
																					</select>
																				</div>
																				<div class="col-md-1">
																					<select name="m2" id="m2" class="form-control">
																						<option value=""></option>
																						<option value="a">a</option>
																						<option value="v">v</option>
																					</select>
																				</div>
																				<div class="col-md-1">
																					<button class="btn btn-outline-primary btn-sm" onclick="addtnm()"><i class="fa fa-plus"></i> Agregar</button>
																				</div>
																			</div>
																		</div>
																	</div>
																</div>
																<div class="col-md-12 mt-2">
																	<div class="table-tnm table-responsive">
																		<table class="table table-bordered w-100">
																			<thead>
																				<tr>
																					<th style="width: 10%;">_T</th>
																					<th style="width: 10%;">_T</th>
																					<th style="width: 10%;">T</th>
																					<th style="width: 10%;">_N</th>
																					<th style="width: 10%;">N</th>
																					<th style="width: 10%;">_M</th>
																					<th style="width: 10%;">M</th>
																					<th style="width: 10%;">M_</th>
																					<th>Eliminar</th>
																				</tr>
																			</thead>
																			<tbody id="tnmbody">

																			</tbody>
																		</table>
																	</div>
																</div>
																<div class="col-md-12">
																	<label for="">Observación</label>
																	<textarea style="height: 100px;" name="observaciontnm" class="form-control" id="observaciontnm" cols="10" rows="10"></textarea>
																</div>
															</div>

														</div>
													</div>
												</div>
												<!--Atenciones-->
												<div class="card">
													<div class="card-header" id="atencion" role="tab">
														<a aria-controls="collapseOne" aria-expanded="true" data-toggle="collapse" href="#atenciones">Anamnesis y Examen Fisico</a>
													</div>
													<div aria-labelledby="atencion" class="collapse" data-parent="#accordion" id="atenciones" role="tabpanel">
														<div class="card-body">
															<div class="col-xl-12 col-lg-12 col-md-12">
																<div class="card transcation-crypto1" id="transcation-crypto1">
																	<div class="card-body">
																		<textarea style="height: 200;" name="anamnesis" class="form-control" id="anamnesis" cols="10" rows="10"></textarea>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
												<!--Procedimientos-->
												<div class="card">
													<div class="card-header" id="procedimiento" role="tab">
														<a aria-controls="collapseTwo" aria-expanded="false" class="collapsed" data-toggle="collapse" href="#procedimientos">Decisión tomada y plan</a>
													</div>
													<div aria-labelledby="procedimiento" class="collapse" data-parent="#accordion" id="procedimientos" role="tabpanel">
														<div class="card-body">
															<div class="row">
																<div class="col-md-4">
																	<div class="card">
																		<div class="card-body">
																			<div class="row">
																				<div class="col-md-12">
																					<p>Decisión Tomada:</p>
																				</div>
																				<div class="col-md-12 d-flex align-items-center">
																					<input type="checkbox" class="mr-1" value="1" id="cirugia">
																					<label style="margin: 0;" for="">Cirugía</label>
																				</div>
																				<div class="col-md-12 d-flex  align-items-center">
																					<input type="checkbox" class="mr-1" value="2" id="quimioterapia">
																					<label style="margin: 0;" for="">Quimioterapiaa</label>
																				</div>
																				<div class="col-md-12 d-flex  align-items-center">
																					<input type="checkbox" class="mr-1" value="3" id="radioterapia">
																					<label style="margin: 0;" for="">Radioterapia</label>
																				</div>
																				<div class="col-md-12 d-flex  align-items-center">
																					<input type="checkbox" class="mr-1" value="4" id="otros">
																					<label style="margin: 0;" for="">Otros Tratamientos Oncológicos</label>
																				</div>
																				<div class="col-md-12 d-flex  align-items-center">
																					<input type="checkbox" class="mr-1" value="5" id="seguimiento">
																					<label style="margin: 0;" for="">Seguimiento sin tratamiento activo</label>
																				</div>
																				<div class="col-md-12 d-flex  align-items-center">
																					<input type="checkbox" class="mr-1" value="6" id="completar">
																					<label style="margin: 0;" for="">Completar estudios</label>
																				</div>
																				<div class="col-md-12 d-flex  align-items-center">
																					<input type="checkbox" class="mr-1" value="7" id="revaluacion">
																					<label style="margin: 0;" for="">Revaluación Posterior en Comité</label>
																				</div>
																				<div class="col-md-12 d-flex  align-items-center">
																					<input type="checkbox" class="mr-1" value="8" id="estudioclinico">
																					<label style="margin: 0;" for="">Estudio Clínico</label>
																				</div>
																			</div>

																		</div>
																	</div>
																</div>
																<div class="col-md-8">
																	<div class="card">
																		<div class="card-body">

																			<p>Observaciones:</p>
																			<textarea placeholder="Ingrese el texto" style="height: 200;" name="observacionesdecision" class="form-control" id="observacionesdecision" cols="10" rows="10"></textarea>

																		</div>
																	</div>

																</div>
															</div>
															<hr />
															<div class="row">
																<div class="col-md-4">
																	<div class="card">
																		<div class="card-body">
																			<div class="row">
																				<div class="col-md-12">
																					<p>Plan Asistencial:</p>
																				</div>
																				<div class="col-md-12">
																					<div class="row">
																						<div class="col-md-12 d-flex align-items-center">
																							<label for="" style="margin: 0;">Citación en Consulta de:</label>
																						</div>
																					</div>
																					<div class="row">
																						<div class="col-md-12">
																							<select name="consultade" id="consultade" class="form-control select2">
																								<option value="1">Cirugía</option>
																								<option value="2">Quimioterapia</option>
																							</select>
																						</div>
																					</div>

																					</select>
																				</div>
																				<div class="col-md-12 mt-3 d-flex  align-items-center">
																					<input type="checkbox" class="mr-1" value="2" id="programacion">
																					<label style="margin: 0;" for="">Programación Quirúrgica</label>
																				</div>
																				<div class="col-md-12 d-flex  align-items-center">
																					<input type="checkbox" class="mr-1" value="3" id="traslado">
																					<label style="margin: 0;" for="">Traslado a otro Centro</label>
																				</div>
																				<div class="col-md-12 d-flex  align-items-center">
																					<input type="checkbox" class="mr-1" value="4" id="paliativos">
																					<label style="margin: 0;" for="">Pasa a Cuidados Paliativos</label>
																				</div>
																				<div class="col-md-12 d-flex  align-items-center">
																					<input type="checkbox" class="mr-1" value="5" id="ingreso">
																					<label style="margin: 0;" for="">Ingreso hospitalario</label>
																				</div>
																			</div>

																		</div>
																	</div>
																</div>
																<div class="col-md-8">
																	<div class="card">
																		<div class="card-body">
																			<p>Observaciones:</p>
																			<textarea placeholder="Ingrese el texto" style="height: 200;" name="observacionplan" class="form-control" id="observacionplan" cols="10" rows="10"></textarea>

																		</div>
																	</div>

																</div>
															</div>
														</div>
													</div>
												</div>
												<!--Resolución Comité-->
												<div class="card">
													<div class="card-header" id="interconsulta" role="tab">
														<a aria-controls="collapseTwo" aria-expanded="false" class="collapsed" data-toggle="collapse" href="#interconsultas">Resolución Comite</a>
													</div>
													<div aria-labelledby="interconsulta" class="collapse" data-parent="#accordion" id="interconsultas" role="tabpanel">
														<div class="card-body">
															<textarea style="height: 200;" name="resolucion" class="form-control" id="resolucion" cols="10" rows="10"></textarea>
														</div>
													</div>
												</div>
												<!--Registro Poblacional-->
												<div class="card">
													<div class="card-header" id="registropoblacional" role="tab">
														<a aria-controls="collapseOne" aria-expanded="false" class="collapsed" data-toggle="collapse" href="#registrospoblacional">Registro Poblacional</a>
													</div>
													<div aria-labelledby="registropoblacional" class="collapse" data-parent="#accordion" id="registrospoblacional" role="tabpanel">
														<div class="card-body">
															<div class="row">
																<div class="col-md-12">
																	<div class="card">
																		<div class="card-header">
																			<h4 class="card-title">Registro Poblacional</h4>
																			<p>Formulario de Registro caso nuevo de Cáncer</p>
																			<label class="custom-switch">
																				<input type="checkbox" name="completereg" class="custom-switch-input" value="1" id="completereg">
																				<span class="custom-switch-indicator"></span>
																				<span class="custom-switch-description">¿Completar Registro Poblacional?</span>
																			</label>
																		</div>
																		<div class="card-body">
																			<input type="hidden" id="pacientepoblacional" value="<?php echo $dipaciente; ?>">
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
									<div class="row mt-4">
										<div class="col-md-12 text-right">
											<input type="hidden" name="previo" id="previo" value="<?php echo $previous_page; ?>">
											<input type="hidden" name="proveniencia" id="proveniencia" value="2">
											<a class="btn btn-danger" href="<?php echo $previous_page; ?>"> <i class="fa fa-arrow-left"></i> Volver</a>
											<button class="btn btn-outline-primary" onclick="vistapreviainforme(<?php echo $dipaciente ?>,<?php echo $idcomite; ?>)"> <i class="fa fa-eye"></i> Vista Previa</button>
											<button class="btn btn-outline-success" onclick="guardarinforme(<?php echo $dipaciente ?>,<?php echo $idcomite; ?>)"> <i class="fa fa-save"></i> Guardar</button>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>


					<!-- ROW-4 opened -->
					<div class="row">
						<div class="col-xl-12 col-lg-12 col-md-12">
							<div class="card" id="tab">
								<div class="card-body">
									<div class="text-wrap">
										<div class="example">
											<div class="border">
												<div class="bg-light-1 nav-bg">
													<nav class="nav nav-tabs">
														<a class="nav-link active" data-toggle="tab" href="#tabCont3">Atenciones</a>
														<a class="nav-link" data-toggle="tab" href="#tabCont4">Signos Vitales</a>
														<a class="nav-link" data-toggle="tab" href="#tabCont5">Medidas Antropométricas</a>
													</nav>
												</div>
												<div class="card-body tab-content">
													<div class="tab-pane active show" id="tabCont3">
														<!-- Row -->
														<div class="row">
															<div class="col-lg-12">
																<div class="card">
																	<div class="card-body">
																		<div class="col-xl-12 col-lg-12 col-md-12">
																			<div class="card transcation-crypto1" id="transcation-crypto1">
																				<div class="card-body">
																					<div class="">
																						<div class="table-responsive">
																							<table class="table w-100 text-nowrap" id="example1">
																								<thead class="border-top text-center">
																									<tr>
																										<th class="bg-transparent">Estado de Atencion</th>
																										<th class="bg-transparent">Fecha Cita</th>
																										<th class="bg-transparent text-center">Fecha Registro</th>
																										<th class="bg-transparent text-center">Profesional</th>
																										<th class="bg-transparent text-center">Atención</th>
																										<th class="bg-transparent text-center">Detalle</th>
																										<th class="bg-transparent text-center">Reporte</th>
																									</tr>
																								</thead>
																								<tbody class="text-center">

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
														<!-- End Row -->
													</div>
													<div class="tab-pane" id="tabCont4">
														<form id="formsignos">
															<div class="row">
																<input type="hidden" name="idpac" value="<?php echo $dipaciente; ?>">
																<div class="col-md-1">
																	<label>F RESP</label>
																	<input type="number" class="form-control" min="1" id="sfresp" name="sfresp" required step="0.01">
																</div>
																<div class="col-md-1">
																	<label>P SIST</label>
																	<input type="number" class="form-control" min="1" id="spsist" name="spsist" required step="0.01">
																</div>
																<div class="col-md-1">
																	<label>P DIAS</label>
																	<input type="number" class="form-control" min="1" id="spdias" name="spdias" required step="0.01">
																</div>
																<div class="col-md-1">
																	<label>% STAT 02</label>
																	<input type="number" class="form-control" min="1" id="ssat" name="ssat" required step="0.01">
																</div>
																<div class="col-md-1">
																	<label>FC</label>
																	<input type="number" class="form-control" min="1" id="sfc" name="sfc" required step="0.01">
																</div>
																<div class="col-md-1">
																	<label>T. AUXILIAR</label>
																	<input type="number" class="form-control" min="1" id="staux" name="staux" required step="0.01">
																</div>
																<div class="col-md-1">
																	<label>T. RECT</label>
																	<input type="number" class="form-control" min="1" id="strect" name="strect" required step="0.01">
																</div>
																<div class="col-md-1">
																	<label>T. OTRA</label>
																	<input type="text" class="form-control" min="1" id="stotra" name="stotra" required>
																</div>
																<div class="col-md-1">
																	<label>HGT</label>
																	<input type="number" class="form-control" min="1" id="shgt" name="shgt" required step="0.01">
																</div>
																<div class="col-md-1">
																	<label>PESO</label>
																	<input type="number" class="form-control" min="1" id="speso" name="speso" required step="0.01">
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
																					<input type="hidden" id="pacienteid" value="<?php echo $dipaciente; ?>">
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
													<div class="tab-pane" id="tabCont5">
														<!--Row-->
														<form id="formmedidas">
															<div class="row">
																<input type="hidden" name="idpac" value="<?php echo $dipaciente; ?>">
																<div class="col-md-1">
																	<label>Peso</label>
																	<!--Valores Hasta con 2 decimales-->
																	<input type="number" class="form-control" min="1" id="peso" name="peso" required step="0.01">
																</div>
																<div class="col-md-1">
																	<label>Estatura</label>
																	<input type="number" class="form-control" min="1" id="estatura" name="estatura" required step="0.01">
																</div>
																<div class="col-md-1">
																	<label>PCe/E</label>
																	<input type="number" class="form-control" min="1" id="pce" name="pce" required step="0.01">
																</div>
																<div class="col-md-1">
																	<label>P/E</label>
																	<select type="number" class="form-control" id="pe" name="pe" required>
																		<option value="1">Normal</option>
																		<option value="2">Desnutrición</option>
																		<option value="3">Sobrepeso</option>
																		<option value="4">Obesidad</option>
																	</select>
																</div>
																<div class="col-md-1">
																	<label>P/T</label>
																	<select type="number" class="form-control" id="pt" name="pt" required>
																		<option value="1">Normal</option>
																		<option value="2">Desnutrición</option>
																		<option value="3">Sobrepeso</option>
																		<option value="4">Obesidad</option>
																	</select>
																</div>
																<div class="col-md-1">
																	<label>T/E</label>
																	<select type="number" class="form-control" id="te" name="te" required>
																		<option value="1">Normal</option>
																		<option value="2">Desnutrición</option>
																		<option value="3">Sobrepeso</option>
																		<option value="4">Obesidad</option>
																	</select>
																</div>
																<div class="col-md-1">
																	<label>IMC</label>
																	<input type="number" class="form-control" min="1" id="imc" name="imc" required step="0.01">
																</div>
																<div class="col-md-1">
																	<label>Clasif. IMC</label>
																	<input type="text" class="form-control" min="1" id="clasifimc" name="clasifimc" required>
																</div>
																<div class="col-md-1">
																	<label>PC/E</label>
																	<input type="number" class="form-control" min="1" id="pc" name="pc" required step="0.01">
																</div>
																<div class="col-md-2">
																	<label>Clasif P.Cintura</label>
																	<select type="number" class="form-control" id="cpc" name="cpc" required>
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


		<!-- Modal Diagnosticos -->
		<div class="modal fade" id="modaldiagnosticos" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
			<div class="modal-dialog modal-xl">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="staticBackdropLabel">Diagnosticos Generales</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">

						<div class="row">
							<div class="col-xl-12 col-lg-12 col-md-12">
								<div class="card transcation-crypto1" id="transcation-crypto1">
									<div class="card-header bd-b-0">
										<h4 class="card-title font-weight-semibold mb-0">Listado de Diagnosticos General</h4>
									</div>
									<div class="card-body">
										<div class="row">
											<div class="col-md-12">

												<div class="table-responsive">
													<table class="table text-wrap w-100 " id="tablegeneral">
														<thead class="border-top text-center">
															<tr>
																<th class="bg-transparent">Codigo</th>
																<th class="bg-transparent text-wrap">Descripcion</th>
																<th class="bg-transparent text-center">Agregar</th>
															</tr>
														</thead>
														<tbody class="text-center">
															<?php
															$lista = $c->listarDiagnosticos();
															foreach ($lista as $object) {
																echo "<tr>";
																echo "<td>" . $object->getCodigo() . "</td>";
																echo "<td class='text-wrap'>" . $object->getNombre() . "</td>";
																echo "<td class='text-center'>";
																echo "<a href='javascript:void(0)' class='btn btn-outline-primary btn-sm' onclick='agregarDiagnosticos(" . $object->getId() . ",\"" . $object->getNombre() . "\")'><i class='fa fa-plus'></i></a>";
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
			</div>
		</div>

		<!-- Modal Diagnosticos CIEO -->
		<div class="modal fade" id="modaldiagcie10" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
			<div class="modal-dialog modal-xl">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="staticBackdropLabel">Diagnosticos CIE10</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">

						<div class="row">
							<div class="col-xl-12 col-lg-12 col-md-12">
								<div class="card transcation-crypto1" id="transcation-crypto2">
									<div class="card-header bd-b-0">
										<h4 class="card-title font-weight-semibold mb-0">Listado de Diagnosticos CIE10</h4>
									</div>
									<div class="card-body">
										<div class="row">
											<div class="col-md-12">
												<div class="table-responsive">
													<table class="table w-100 text-nowrap" id="tablecie10">
														<thead class="border-top text-center">
															<tr>
																<th class="bg-transparent">Codigo</th>
																<th class="bg-transparent text-wrap">Descripcion Completo</th>
																<th class="bg-transparent text-center">Agregar</th>
															</tr>
														</thead>
														<tbody class="text-center">
															<?php
															$lista = $c->listarDiagnosticosCIE101();
															foreach ($lista as $object) {
																echo "<tr>";
																echo "<td>" . $object->getCodigo() . "</td>";
																echo "<td class='text-wrap'>" . $object->getDescripcion() . "</td>";
																echo "<td class='text-center'>";
																echo "<a href='javascript:void(0)' class='btn btn-outline-primary btn-sm' onclick='agregarDiagnosticoCIE10(" . $object->getId() . ",\"" . $object->getDescripcion() . "\")'><i class='fa fa-plus'></i></a>";
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
			</div>
		</div>

		<div class="modal" id="modalprevia">
		<div class="modal-dialog modal-xl" role="document">
			<div class="modal-content modal-content-demo">
				<div class="modal-header">
					<h6 class="modal-title">Vista Previa</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-12">
							<iframe id="frameprevia" style="min-height: 700px;" class="w-100" frameborder="0"></iframe>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button class="btn ripple btn-primary" type="button" data-dismiss="modal">Cerrar</button>
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
	<script src="JsFunctions/registropoblacional.js"></script>
	<script src="JsFunctions/informe.js"></script>
	<script>
		//Cargar Tabla
		$(document).ready(function() {
			cargarsignos();
			cargarmedidas();
		});

		$('#tablegeneral').DataTable({
			language: {
				searchPlaceholder: 'Buscar..',
				sSearch: '',
				lengthMenu: '_MENU_ datos/página',
				zeroRecords: 'No se encontraron resultados',
				info: 'Mostrando página _PAGE_ de _PAGES_',
				infoEmpty: 'No hay datos disponibles',
				infoFiltered: '(filtrado de _MAX_ datos totales)',
				paginate: {
					first: 'Primero',
					previous: 'Anterior',
					next: 'Siguiente',
					last: 'Último'
				},
			},
			"paging": true,
			"lengthChange": true,
			"searching": true,
			"ordering": true,
			"info": true,
			"autoWidth": true,
			"responsive": true
		});

		$('#tablecieo1').DataTable({
			language: {
				searchPlaceholder: 'Buscar..',
				sSearch: '',
				lengthMenu: '_MENU_ datos/página',
				zeroRecords: 'No se encontraron resultados',
				info: 'Mostrando página _PAGE_ de _PAGES_',
				infoEmpty: 'No hay datos disponibles',
				infoFiltered: '(filtrado de _MAX_ datos totales)',
				paginate: {
					first: 'Primero',
					previous: 'Anterior',
					next: 'Siguiente',
					last: 'Último'
				},
			},
			"paging": true,
			"lengthChange": true,
			"searching": true,
			"ordering": true,
			"info": true,
			"autoWidth": true,
			"responsive": true,
			//Ajustar el texto al tamaño del contenedor
			"columnDefs": [{
				"className": "dt-center",
				"targets": "_all"
			}]

		});

		$('#tablecieo2').DataTable({
			language: {
				searchPlaceholder: 'Buscar..',
				sSearch: '',
				lengthMenu: '_MENU_ datos/página',
				zeroRecords: 'No se encontraron resultados',
				info: 'Mostrando página _PAGE_ de _PAGES_',
				infoEmpty: 'No hay datos disponibles',
				infoFiltered: '(filtrado de _MAX_ datos totales)',
				paginate: {
					first: 'Primero',
					previous: 'Anterior',
					next: 'Siguiente',
					last: 'Último'
				},
			},
			"paging": true,
			"lengthChange": true,
			"searching": true,
			"ordering": true,
			"info": true,
			"autoWidth": true,
			"responsive": true
		});

		$('#tablecie10').DataTable({
			language: {
				searchPlaceholder: 'Buscar..',
				sSearch: '',
				lengthMenu: '_MENU_ datos/página',
				zeroRecords: 'No se encontraron resultados',
				info: 'Mostrando página _PAGE_ de _PAGES_',
				infoEmpty: 'No hay datos disponibles',
				infoFiltered: '(filtrado de _MAX_ datos totales)',
				paginate: {
					first: 'Primero',
					previous: 'Anterior',
					next: 'Siguiente',
					last: 'Último'
				},
			},
			"paging": true,
			"lengthChange": true,
			"searching": true,
			"ordering": true,
			"info": true,
			"autoWidth": true,
			"responsive": true
		});
	</script>



</body>

</html>