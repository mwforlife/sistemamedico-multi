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
$reserva = null;
$consulta = null;
$pa = null;
if (isset($_GET['id'])) {
	$atencion = $_GET['id'];
	$consulta = $c->buscarconsultaporid($atencion);
	if ($consulta == null) {
		// Redireccionar a la página anterior
		header("Location: $previous_page");
		exit();
	}
	$id = $consulta->getPaciente();
	$pa = $c->buscarpaciente($id);
	if ($pa == null) {
		// Redireccionar a la página anterior
		header("Location: $previous_page");
		exit();
	}

	$dipaciente = $pa->getId();

	$reservaid = $consulta->getAtencion();
	if (is_numeric($reservaid)) {
		$reservaid = intval($reservaid);
		if ($reservaid <= 0) {
			// Redireccionar a la página anterior
			header("Location: $previous_page&error=upps");
			exit();
		}
	} else {
		// Redireccionar a la página anterior
		header("Location: $previous_page");
		exit();
	}

	$reserva = $c->buscarreservaporid($reservaid);
	if ($reserva == null) {
		// Redireccionar a la página anterior
		header("Location: $previous_page");
		exit();
	}
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
$rut = $pa->getRut();
$nombre = $pa->getNombre();
$apellido1 = $pa->getApellido1();
$apellido2 = $pa->getApellido2();
$estadocivil = $pa->getEstadocivil();
$estadocivil = $c->buscarnombreestadocivil($estadocivil);

//Fecha de nacimiento en texto
$dia = date("d", strtotime($pa->getFechanacimiento()));
$mes = date("m", strtotime($pa->getFechanacimiento()));
$mestexto = "";
$ano = date("Y", strtotime($pa->getFechanacimiento()));

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
$object2 = null;
if ($empresa != null) {
	$object2 = $c->buscarenUsuario($id, $empresa->getId());
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
	<title>OncoWay | Generar Consulta</title>

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
							<h1 class="main-content-title tx-30">Paciente Atenciones</h1>
							<ol class="breadcrumb">
								<li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
							</ol>

						</div>
					</div>
					<?php
					$pacienteid = $pa->getId();
					$pac = $c->buscarpacientetext($pacienteid);
					$inscripcion = $c->listarinscripcionprevisionrelacionado($pacienteid);
					$datosubicacion = $c->listardatosubicacionrelacionado($pacienteid);
					$otros = $c->listarotrosantecedentesrelacionado($pacienteid);
					?>
					<!-- Row -->
					<div class="row">
						<!--Información Paciente -->
						<div class="col-md-12">
							<div class="card">
								<div class="card-body">
									<div class="row justify-content-between">
									<div class="col-lg-9">
											<div class="row">
												<div class="col-md-12">
													<h5 class="card-title">Información Paciente</h5>
												</div>
												<div class="col-md-3">
													<?php
													echo "<h6 class='card-title'>Rut: " . $pac->getRut() . "</h6>";
													echo "<h6 class='card-title'>Nombre: " . $pac->getNombre() . " " . $pac->getApellido1() . " " . $pac->getApellido2() . "</h6>";
													echo "<h6 class='card-title'>Fecha Nacimiento: " . date("d-m-Y", strtotime($pac->getFechanacimiento())) . "</h6>";
													echo "<h6 class='card-title'>Edad: " . $edad . " Años</h6>";
													?>
												</div>
												<div class="col-md-3">
													<?php
													echo "<h6 class='card-title'>Genero: " . $pac->getGenero() . "</h6>";
													echo "<h6 class='card-title'>Nacionalidad: " . $pac->getNacionalidad() . "</h6>";
													echo "<h6 class='card-title'>Estado Civil: " . $pac->getEstadocivil() . "</h6>";
													echo "<h6 class='card-title'>Previsión: "; if($inscripcion!=null){echo $inscripcion->getRegistro() . " " . $inscripcion->getTipoprevision();} echo "</h6>";
													?>
												</div>
												<div class="col-md-3">
													<?php
													echo "<h6 class='card-title'>Dirección: " . $datosubicacion->getNombrecalle() . " " . $datosubicacion->getNumerocalle() . ", " . $datosubicacion->getRestodireccion() . "</h6>";
													echo "<h6 class='card-title'>Comuna: " . $datosubicacion->getComuna() . "</h6>";
													echo "<h6 class='card-title'>Región: " . $datosubicacion->getRegion() . "</h6>";
													echo "<h6 class='card-title'>Teléfono: " . $pac->getFonomovil() . "</h6>";
													?>
												</div>
												<div class="col-md-3">
													<?php
													echo "<h6 class='card-title'>Pueblo Originario: " . $otros->getPueblooriginario() . "</h6>";
													echo "<h6 class='card-title'>N° Ficha: "; if($inscripcion!=null){echo  $inscripcion->getFicha() ;} echo"</h6>";
													echo "<h6 class='card-title'>Fecha Admision: "; if($inscripcion!=null){echo  $inscripcion->getFechaadmision() ;} echo "</h6>";
													echo "<h6 class='card-title'>Inscrito En: "; if($inscripcion!=null){echo  $inscripcion->getInscrito();} echo "</h6>";
													?>
												</div>

											</div>
										</div>
										<div class="col-lg-3 d-flex justify-content-end align-items-center">
											<label for="">Modalidad Atención</label>
											<select name="modalidad" id="modalidad" class="form-control select2">
												<option value="1" <?php if ($consulta->getModalidad() == 1) {echo "selected";} ?>>Presencial</option>
												<option value="2" <?php if ($consulta->getModalidad() == 2) {echo "selected";} ?>>Remota</option>
											</select>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-12">

							<!-- ROW-4 opened -->
							<div class="row">
								<div class="col-xl-12 col-lg-12 col-md-12">
									<div class="card" id="tab">
										<div class="card-body">

											<!-- Row -->
											<div class="row">
												<div class="col-lg-12">
													<div class="row">
														<div class="col-md-12">
															<div aria-multiselectable="true" class="accordion" id="accordion" role="tablist">
																<!--Diagnosticos-->
																<div class="card">
																	<div class="card-header" id="diagnostic" role="tab">
																		<a aria-controls="collapseTwo" aria-expanded="false" class="collapsed" data-toggle="collapse" href="#diagnosticos">Atención - Diagnostico</a>
																	</div>
																	<div aria-labelledby="diagnostico" class="collapse" data-parent="#accordion" id="diagnosticos" role="tabpanel">
																		<div class="card-body">
																			<div class="row">
																				<div class="col-md-4">
																					<label for="">Diagnostico General</label>
																					<button class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#modaldiagnosticos"><i class="fa fa-search"></i></button>
																					<input type="text" class="form-control" id="diagnostico" value="<?php echo $consulta->getDiagnosticotexto(); ?>">
																					<input type="hidden" class="form-control" id="iddiag" value="<?php echo $consulta->getDiagnostico(); ?>">
																				</div>
																				<div class="col-md-4">
																					<label for="">Diagnostico CIE10</label>
																					<button class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#modaldiagcie10"><i class="fa fa-search"></i></button>
																					<input type="text" class="form-control" id="diagnosticocie10" value="<?php echo $consulta->getDiagnosticocie10texto(); ?>">
																					<input type="hidden" class="form-control" id="idcie10" value="<?php echo $consulta->getDiagnosticocie10(); ?>">
																				</div>
																				<div class="col-md-4">
																					<label for="">Tipo de atención</label>
																					<input type="text" class="form-control" id="tipoatencion" value="<?php echo $consulta->getTipodeatencion(); ?> " readonly>
																					<input type="hidden" class="form-control" id="tipoatencionid">
																				</div>
																				<div class="col-md-4">
																					<label for="">Ecog</label>
																					<select name="ecog" id="ecog" class="form-control select2">
																						<?php
																						$ecog = $c->listarecog();
																						foreach ($ecog as $e) {
																							if ($consulta->getEcog() == $e->getId()) {
																								echo "<option value='" . $e->getId() . "' selected>" . $e->getCodigo() . " - " . $e->getNombre() . "</option>";
																							} else {
																								echo "<option value='" . $e->getId() . "'>" . $e->getCodigo() . " - " . $e->getNombre() . "</option>";
																							}
																						}

																						?>
																					</select>
																				</div>
																				<div class="col-md-2 d-flex align-items-center  mt-2">
																					<input type="checkbox" class="mr-1" value="1" id="ingreso" <?php if ($consulta->getIngreso() == 1) {
																																					echo "checked";
																																				} ?>>
																					<label style="margin:0;" for="">Ingreso</label>
																				</div>
																				<div class="col-md-2 d-flex align-items-center  mt-2">
																					<input type="checkbox" class="mr-1" value="1" id="receta" <?php if ($consulta->getReceta() == 1) {
																																					echo "checked";
																																				} ?>>
																					<label style="margin:0;" for="">Receta</label>
																				</div>
																				<div class="col-md-2 d-flex align-items-center  mt-2">
																					<input type="checkbox" class="mr-1" value="1" id="reingreso" <?php if ($consulta->getReingreso() == 1) {
																																						echo "checked";
																																					} ?>>
																					<label style="margin:0;" for="">Reingreso</label>
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
																						<textarea style="height: 200;" name="anamnesis" class="form-control" id="anamnesis" cols="10" rows="10"><?php echo $consulta->getAnamesis(); ?></textarea>
																					</div>
																				</div>
																			</div>
																		</div>
																	</div>
																</div>
																<!--Procedimientos-->
																<div class="card">
																	<div class="card-header" id="procedimiento" role="tab">
																		<a aria-controls="collapseTwo" aria-expanded="false" class="collapsed" data-toggle="collapse" href="#procedimientos">Estudios Complementarios</a>
																	</div>
																	<div aria-labelledby="procedimiento" class="collapse" data-parent="#accordion" id="procedimientos" role="tabpanel">
																		<div class="card-body">
																			<textarea style="height: 200;" name="estudiocomplementarios" class="form-control" id="estudiocomplementarios" cols="10" rows="10"><?php echo $consulta->getEstudiocomplementarios(); ?></textarea>

																		</div>
																	</div>
																</div>
																<div class="card">
																	<div class="card-header" id="decisionyplan" role="tab">
																		<a aria-controls="collapseTwo" aria-expanded="false" class="collapsed" data-toggle="collapse" href="#decisionyplans">Decisión tomada y plan</a>
																	</div>
																	<div aria-labelledby="decisionyplan" class="collapse" data-parent="#accordion" id="decisionyplans" role="tabpanel">
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
																									<input type="checkbox" class="mr-1" value="1" id="cirugia" <?php if ($consulta->getCirugia() == 1) {echo "checked";} ?>>
																									<label style="margin: 0;" for="">Cirugía</label>
																								</div>
																								<div class="col-md-12 d-flex  align-items-center">
																									<input type="checkbox" class="mr-1" value="2" id="quimioterapia" <?php if ($consulta->getQuimioterapia() == 2) {echo "checked";} ?>>
																									<label style="margin: 0;" for="">Quimioterapiaa</label>
																								</div>
																								<div class="col-md-12 d-flex  align-items-center">
																									<input type="checkbox" class="mr-1" value="3" id="radioterapia" <?php if ($consulta->getRadioterapia() == 3) {echo "checked";} ?>>
																									<label style="margin: 0;" for="">Radioterapia</label>
																								</div>
																								<div class="col-md-12 d-flex  align-items-center">
																									<input type="checkbox" class="mr-1" value="4" id="otros" <?php if ($consulta->getTratamientosoncologicos() == 4) {echo "checked";} ?>>
																									<label style="margin: 0;" for="">Otros Tratamientos Oncológicos</label>
																								</div>
																								<div class="col-md-12 d-flex  align-items-center">
																									<input type="checkbox" class="mr-1" value="5" id="seguimiento" <?php if ($consulta->getSeguimientosintratamiento() == 5) {echo "checked";} ?>>
																									<label style="margin: 0;" for="">Seguimiento sin tratamiento activo</label>
																								</div>
																								<div class="col-md-12 d-flex  align-items-center">
																									<input type="checkbox" class="mr-1" value="6" id="completar" <?php if ($consulta->getCompletarestudios() == 6) {echo "checked";} ?>>
																									<label style="margin: 0;" for="">Completar estudios</label>
																								</div>
																								<div class="col-md-12 d-flex  align-items-center">
																									<input type="checkbox" class="mr-1" value="7" id="revaluacion" <?php if ($consulta->getRevaluacionposterior() == 7) {echo "checked";} ?>>
																									<label style="margin: 0;" for="">Revaluación Posterior en Comité</label>
																								</div>
																								<div class="col-md-12 d-flex  align-items-center">
																									<input type="checkbox" class="mr-1" value="8" id="estudioclinico" <?php if ($consulta->getEstudioclinico() == 8) {echo "checked";} ?>>
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
																							<textarea placeholder="Ingrese el texto" style="height: 200;" name="observacionesdecision" class="form-control" id="observacionesdecision" cols="10" rows="10"><?php echo $consulta->getObservaciondesicion();?></textarea>

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
																												<option value="1" <?php if ($consulta->getConsultadeid() == 1) {echo "selected";} ?>>Cirugía</option>
																												<option value="2" <?php if ($consulta->getConsultadeid() == 2) {echo "selected";} ?>>Quimioterapia</option>
																											</select>
																										</div>
																									</div>

																									</select>
																								</div>
																								<div class="col-md-12 mt-3 d-flex  align-items-center">
																									<input type="checkbox" class="mr-1" value="2" id="programacion" <?php if ($consulta->getProgramacionquirurgica() == 2) {echo "checked";} ?>>
																									<label style="margin: 0;" for="">Programación Quirúrgica</label>
																								</div>
																								<div class="col-md-12 d-flex  align-items-center">
																									<input type="checkbox" class="mr-1" value="3" id="traslado" <?php if ($consulta->getTraslado() == 3) {echo "checked";} ?>>
																									<label style="margin: 0;" for="">Traslado a otro Centro</label>
																								</div>
																								<div class="col-md-12 d-flex  align-items-center">
																									<input type="checkbox" class="mr-1" value="4" id="paliativos" <?php if ($consulta->getCiudadospaliativos() == 4) {echo "checked";} ?>>
																									<label style="margin: 0;" for="">Pasa a Cuidados Paliativos</label>
																								</div>
																								<div class="col-md-12 d-flex  align-items-center">
																									<input type="checkbox" class="mr-1" value="5" id="ingresohospitalario" <?php if ($consulta->getIngresohospitalario() == 5) {echo "checked";} ?>>
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
																							<textarea placeholder="Ingrese el texto" style="height: 200;" name="observacionplan" class="form-control" id="observacionplan" cols="10" rows="10"><?php echo $consulta->getObservacionplan();?></textarea>

																						</div>
																					</div>

																				</div>
																			</div>
																		</div>
																	</div>
																</div>
															<input type="hidden" id="atpacienteid" value="<?php echo $consulta->getPaciente(); ?>">
															<input type="hidden" id="atempresaid" value="<?php echo $consulta->getEmpresa(); ?>">
															<input type="hidden" id="atprofesionalid" value="<?php echo $consulta->getUsuario(); ?>">
															<input type="hidden" id="atreservaid" value="<?php echo $consulta->getAtencion(); ?>">
															<input type="hidden" id="atfolio" value="<?php echo $consulta->getFolio(); ?>">
															<input type="hidden" id="previo" value="<?php echo $previous_page; ?>">
															</div>
														</div>
													</div>
													<div class="row mt-4">
														<div class="col-md-12 text-right">
															<input type="hidden" id="previo" value="<?php echo $previous_page; ?>">
															<!--Boton volver-->
															<a class="btn btn-danger" href="<?php echo $previous_page; ?>"> <i class="fa fa-arrow-left"></i> Volver</a>
															<!--Boton Vista Previa-->
															<button type="button" class="btn btn-info" onclick="vistapreviaatencion()"> <i class="fa fa-eye"></i> Vista Previa</button>
															<!--Boton Guardar-->
															<button type="button" class="btn btn-success" onclick="registraratencion()"> <i class="fa fa-save"></i> Registrar</button>
														</div>
													</div>
												</div>
											</div>
											<!-- End Row -->
										</div>
									</div>
								</div>
							</div>
							<!-- ROW-4 END -->
						</div>
						<div class="col-lg-12">

							<div class="row">
								<div class="col-lg-12">
									<div class="card">
										<div class="card-body">
											<div aria-multiselectable="true" class="accordion" id="accordion" role="tablist">
												<!--Diagnosticos-->
												<div class="card">
													<div class="card-header" id="diagnostic" role="tab">
														<a aria-controls="collapseTwo" aria-expanded="false" class="collapsed" data-toggle="collapse" href="#recet">Recetas</a>
													</div>
													<div aria-labelledby="diagnostico" class="collapse" data-parent="#accordion" id="recet" role="tabpanel">
														<div class="card-body">
															<table class="table w-100 table-bordered table-striped" id="example3">
																<thead>
																	<tr>
																		<th>Fecha</th>
																		<th>Estado</th>
																		<th>Folio</th>
																		<th>Atención</th>
																		<th>Receta</th>
																		<th>Acción</th>
																	</tr>
																</thead>
																<tbody>
																	<?php
																	$recetas = $c->recetalist($pa->getId());
																	if (count($recetas) > 0) {
																		foreach ($recetas as $r) {
																			echo "<tr>";
																			echo "<td>" . date("d-m-Y", strtotime($r->getFecha())) . "</td>";

																			if ($r->getEstado() == 1) {
																				echo "<td><span class='badge bg-primary text-white'>Emitida</span></td>";
																			} else if ($r->getEstado() == 2) {
																				echo "<td><span class='badge bg-warning'>Editado</span></td>";
																			} else if ($r->getEstado() == 3) {
																				echo "<td><span class='badge bg-success text-white'>Aprobada</span></td>";
																			} else if ($r->getEstado() == 4) {
																				echo "<td><span class='badge bg-danger text-white'>Rechazada</span></td>";
																			}
																			$idreceta = $r->getId();
																			echo "<td>" . $r->getFolio() . "</td>";
																			echo "<td>" . $r->getConsulta() . "</td>";
																			echo "<td><a target='_blank' href='php/reporte/receta.php?r=$idreceta' class='btn-sm btn btn-outline-success'><i class='fe fe-file'></i></a></td>";
																			echo "<td>";
																			if ($r->getEstado() == 1) {
																				echo "<a href='recetaedit.php?id=$idreceta' class='btn-sm btn btn-outline-warning'><i class='fe fe-edit'></i></a>";
																			}
																			echo "</td>";
																			echo "</tr>";
																		}
																	}
																	?>

																</tbody>
															</table>
														</div>
													</div>
												</div>
												<!--Diagnosticos-->
												<div class="card">
													<div class="card-header" id="intervencion" role="tab">
														<a aria-controls="collapseTwo" aria-expanded="false" class="collapsed" data-toggle="collapse" href="#diagnost">Diagnosticos</a>
													</div>
													<div aria-labelledby="intervencion" class="collapse" data-parent="#accordion" id="diagnost" role="tabpanel">
														<div class="card-body">
															<table class="table w-100">
																<thead>
																	<tr>
																		<th>Folio</th>
																		<th>Diagnostico</th>
																		<th>Fecha</th>
																		<th>Origen</th>
																		<th>Rut Profesional</th>
																		<th>Nombre Profesional</th>
																		<th>Folio Comité</th>
																		<th>Tipo Comité</th>
																		<th>Informe</th>
																	</tr>
																</thead>
															</table>
														</div>
													</div>
												</div>
												<!--Hospitalizaciones-->
												<div class="card">
													<div class="card-header" id="hospitalizacion" role="tab">
														<a aria-controls="collapseTwo" aria-expanded="false" class="collapsed" data-toggle="collapse" href="#hospitalizaciones">Quimioterapia</a>
													</div>
													<div aria-labelledby="hospitalizacion" class="collapse" data-parent="#accordion" id="hospitalizaciones" role="tabpanel">
														<div class="card-body">
															<table class="table w-100">
																<thead>
																	<tr>
																		<th>Fecha</th>
																		<th>N° Receta</th>
																		<th>N° Ciclo</th>
																		<th>Nombre</th>
																		<th>Esquema</th>
																		<th>Receta</th>
																	</tr>
																</thead>
																<tbody>

																</tbody>
															</table>
														</div>
													</div>
												</div>
												<!--Signos Vitales-->
												<div class="card">
													<div class="card-header" id="atencion" role="tab">
														<a aria-controls="collapseOne" aria-expanded="true" data-toggle="collapse" href="#sig">Signos Vitales</a>
													</div>
													<div aria-labelledby="atencion" class="collapse" data-parent="#accordion" id="sig" role="tabpanel">
														<div class="card-body">
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
																						<input type="hidden" id="pacienteid" value="<?php echo $pa->getId(); ?>">
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
												<!--Medidas Antropometricas-->
												<div class="card">
													<div class="card-header" id="atros" role="tab">
														<a aria-controls="collapseTwo" aria-expanded="false" class="collapsed" data-toggle="collapse" href="#atro">Antropométrica</a>
													</div>
													<div aria-labelledby="procedimiento" class="collapse" data-parent="#accordion" id="atro" role="tabpanel">
														<div class="card-body">
															<!--Row-->
															<form id="formmedidas">
																<div class="row">
																	<input type="hidden" name="idpac" value="<?php echo $pa->getId(); ?>">
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
												<!--Historial Clinico-->
												<div class="card">
													<div class="card-header" id="interconsulta" role="tab">
														<a aria-controls="collapseTwo" aria-expanded="false" class="collapsed" data-toggle="collapse" href="#histo">Historial Clinico</a>
													</div>
													<div aria-labelledby="interconsulta" class="collapse" data-parent="#accordion" id="histo" role="tabpanel">
														<div class="card-body">
															<div class="row">
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
																							<?php
																							$atenciones = $c->buscarreservaspaciente($pa->getId());
																							foreach ($atenciones as $at) {
																								echo "<tr>";
																								if ($at->getEstado() == 1) {
																									//Pendiente Atencion
																									echo "<td class='bg-transparent'><span class='badge badge-warning'><i class='fa fa-clock-o'></i> Pendiente</span></td>";
																								} else if ($at->getEstado() == 2) {
																									//Confirmado
																									echo "<td class='bg-transparent'><span class='badge badge-success'><i class='fa fa-check'></i> Confirmado</span></td>";
																								} else if ($at->getEstado() == 3) {
																									//En Sala de Espera
																									echo "<td class='bg-transparent'><span class='badge badge-info'><i class='fa fa-clock-o'></i> En Sala de Espera</span></td>";
																								} else if ($at->getEstado() == 5) {
																									//Atendido
																									echo "<td class='bg-transparent'><span class='badge badge-success'><i class='fa fa-user-check'></i>Atendido</span></td>";
																								} else if ($at->getEstado() == 7) {
																									//Paciente no se Presenta
																									echo "<td class='bg-transparent'><span class='badge badge-danger'><i class='fa fa-clock-o'></i> Paciente no se Presenta</span></td>";
																								} else {
																									//Cancelado
																									echo "<td class='bg-transparent'><span class='badge badge-danger'><i class='fa fa-clock-o'></i> Cancelado</span></td>";
																								}
																								echo "<td class='bg-transparent'>" . $at->getFecha() . "</td>";
																								echo "<td class='bg-transparent text-center'>" . $at->getRegistro() . "</td>";
																								echo "<td class='bg-transparent text-center'>" . $at->getProfesional() . "</td>";
																								echo "<td class='bg-transparent text-center'><a href='atencion.php?id=" . $at->getId() . "'><i class='fa fa-eye'></i></a></td>";
																								echo "<td class='bg-transparent text-center'><a href='reporte.php?id=" . $at->getId() . "'><i class='fa fa-eye'></i></a></td>";
																								echo "<td class='bg-transparent text-center'><a href='reporte.php?id=" . $at->getId() . "'><i class='fa fa-file-pdf-o'></i></a></td>";

																								echo "</tr>";
																							}
																							?>

																						</tbody>
																					</table>
																				</div>
																			</div>
																		</div>
																	</div>
																</div><!-- COL END -->
															</div>
														</div>
													</div>
												</div>
												<!--Imagenologia-->
												<div class="card">
													<div class="card-header" id="imagenologia" role="tab">
														<a aria-controls="collapseTwo" aria-expanded="false" class="collapsed" data-toggle="collapse" href="#imagenologias">Procedimiento / Evolución</a>
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
														<a aria-controls="collapseTwo" aria-expanded="false" class="collapsed" data-toggle="collapse" href="#laboratorios">Anamnesis</a>
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
														<a aria-controls="collapseTwo" aria-expanded="false" class="collapsed" data-toggle="collapse" href="#medicamentos">Archivos Adjuntos</a>
													</div>
													<div aria-labelledby="medicamento" class="collapse" data-parent="#accordion" id="medicamentos" role="tabpanel">
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
															<th class="bg-transparent">Descripcion</th>
															<th class="bg-transparent text-center">Agregar</th>
														</tr>
													</thead>
													<tbody class="text-center">
														<?php
														$lista = $c->listarDiagnosticos();
														foreach ($lista as $object) {
															echo "<tr>";
															echo "<td>" . $object->getCodigo() . "</td>";
															echo "<td>" . $object->getNombre() . "</td>";
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
															<th class="bg-transparent">Descripcion Completo</th>
															<th class="bg-transparent text-center">Agregar</th>
														</tr>
													</thead>
													<tbody class="text-center">
														<?php
														$lista = $c->listarDiagnosticosCIE101();
														foreach ($lista as $object) {
															echo "<tr>";
															echo "<td>" . $object->getCodigo() . "</td>";
															echo "<td>" . $object->getDescripcion() . "</td>";
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
	<script src="JsFunctions/atencionpaciente.js"></script>
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
			"responsive": true
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