<?php
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
$consultaid = 0;
$consulta = null;
if (isset($_GET['c']) && isset($_GET['p'])) {
	$consultaid = $_GET['c'];

	$consulta = $c->buscarconsultaporid($consultaid);
	if ($consulta == null) {
		// Redireccionar a la página anterior
		header("Location: $previous_page");
		exit();
	}

	$paciente = $_GET['p'];
	$pa = $c->buscarpaciente($paciente);
	if ($pa == null) {
		// Redireccionar a la página anterior
		header("Location: $previous_page");
		exit();
	}
	$id = $pa->getId();
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
	$valid = $c->validarsesion($_SESSION['USER_ID'], $_SESSION['USER_TOKEN']);
	if ($valid == false) {
		header("Location: lockscreen.php");
	}
}
$id = $_SESSION['USER_ID'];
$object = $c->buscarenUsuario1($id);


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
if(isset($_SESSION['CURRENT_ENTERPRISE'])){
	if($c->validarroladmin($object->getId())==true){
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
}else{
	if($c->validarroladmin($object->getId())==true){
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
	<title>OncoWay | Receta</title>

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
					<img src="assets/img/brand/dark-logo.png" class="header-brand-img desktop-logo theme-logo"
						alt="logo">
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
						if($admingeneralrol == true || $adminsistemarol == true || $fichaclinicarol == true){
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
							<li class="nav-sub-item">
								<a class="nav-sub-link" href="listadopacientes.php">Listado Pacientes</a>
							</li>

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
						<a href="index.php"><img src="assets/img/brand/dark-logo.png" class="mobile-logo"
								alt="logo"></a>
						<a href="index.php"><img src="assets/img/brand/logo.png" class="mobile-logo-dark"
								alt="logo"></a>
					</div>
					<div class="input-group">
						<div class="mt-0">
							<form class="form-inline">
								<div class="search-element">
									<input type="search" class="form-control header-search text-dark" readonly
										value="<?php echo $empresa->getRazonSocial(); ?>" aria-label="Search"
										tabindex="1">
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
							<i class="fullscreen"><svg xmlns="http://www.w3.org/2000/svg" height="24"
									viewBox="0 0 24 24" width="24">
									<path d="M0 0h24v24H0V0z" fill="none" />
									<path
										d="M5 15H3v4c0 1.1.9 2 2 2h4v-2H5v-4zM5 5h4V3H5c-1.1 0-2 .9-2 2v4h2V5zm14-2h-4v2h4v4h2V5c0-1.1-.9-2-2-2zm0 16h-4v2h4c1.1 0 2-.9 2-2v-4h-2v4zM12 9c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z" />
								</svg></i>
							<i class="exit-fullscreen"><svg xmlns="http://www.w3.org/2000/svg" height="24"
									viewBox="0 0 24 24" width="24">
									<path d="M0 0h24v24H0V0z" fill="none" />
									<path
										d="M5 16h3v3h2v-5H5v2zm3-8H5v2h5V5H8v3zm6 11h2v-3h3v-2h-5v5zm2-11V5h-2v5h5V8h-3z" />
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
									<?php echo $object->getNombre() . " " . $object->getApellido1() . " " . $object->getApellido2(); ?>
								</h6>
							</div>
							<a class="dropdown-item" href="close.php">
								<i class="fe fe-power"></i> Cerrar Sesíon
							</a>
						</div>
					</div>
					<button class="navbar-toggler navresponsive-toggler" type="button" data-toggle="collapse"
						data-target="#navbarSupportedContent-4" aria-controls="navbarSupportedContent-4"
						aria-expanded="false" aria-label="Toggle navigation">
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
							<a class="nav-link icon full-screen-link fullscreen-button" href=""><i
									class="fullscreen"><svg xmlns="http://www.w3.org/2000/svg" height="24"
										viewBox="0 0 24 24" width="24">
										<path d="M0 0h24v24H0V0z" fill="none" />
										<path
											d="M5 15H3v4c0 1.1.9 2 2 2h4v-2H5v-4zM5 5h4V3H5c-1.1 0-2 .9-2 2v4h2V5zm14-2h-4v2h4v4h2V5c0-1.1-.9-2-2-2zm0 16h-4v2h4c1.1 0 2-.9 2-2v-4h-2v4zM12 9c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z" />
									</svg></i>
								<i class="exit-fullscreen"><svg xmlns="http://www.w3.org/2000/svg" height="24"
										viewBox="0 0 24 24" width="24">
										<path d="M0 0h24v24H0V0z" fill="none" />
										<path
											d="M5 16h3v3h2v-5H5v2zm3-8H5v2h5V5H8v3zm6 11h2v-3h3v-2h-5v5zm2-11V5h-2v5h5V8h-3z" />
									</svg></i>
							</a>
						</div>
						<div class="dropdown main-profile-menu">
							<a class="d-flex" href="#">
								<span class="main-img-user"><img alt="avatar" src="assets/img/users/9.jpg"></span>
							</a>
							<div class="dropdown-menu">
								<div class="header-navheading">
									<h6 class="main-notification-title">
										<?php echo $object->getNombre() . " " . $object->getApellido1() . " " . $object->getApellido2(); ?>
									</h6>
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

					<!-- Row -->
					<div class="row">
						<!--Información Paciente -->
						<div class="col-md-12">
							<div class="card">
								<div class="card-body">
									<div class="row">
										<div class="col-lg-12 d-flex gap-2">
											<h5 class="card-title">Paciente:
												<?php echo $pa->getNombre() . " " . $pa->getApellido1() . " " . $pa->getApellido2(); ?>
											</h5>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											<h5>
												Rut:
												<?php echo $pa->getRut(); ?>
												<!--Tabulador html-->
												&nbsp;&nbsp;&nbsp;&nbsp;
												Edad:
												<?php echo $edad ?> Años
											</h5>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-lg-12">
							<div class="card">
								<div class="card-body">
									<div class="row justify-content-between">
										<h5>Diagnostico:
											<?php echo $consulta->getDiagnosticotexto(); ?>
										</h5>
										<button class="btn btn-outline-success"
											onclick="generarreceta(<?php echo $pa->getId(); ?>,<?php echo $object->getId(); ?>,<?php echo $empresa->getId(); ?>,<?php echo $consulta->getId(); ?>)"><i
												class="fa fa-save"></i> Generar Receta</button>

										<input type="hidden" id="previo" value="<?php echo $previous_page; ?>">
									</div>
									<div class="row">
										<div class="col-md-12 mt-4">
											<div class="card">
												<div class="card-body">
													<h6 class="main-content-label mb-1">Información Paciente</h6>
													<div class="row">
														<div class="col-md-2">
															<label for="">Estadio</label>
															<select name="estadio" id="estadio" class="form-control">
																<option value="1">I</option>
																<option value="2">II</option>
																<option value="3">III</option>
																<option value="4">IV</option>
															</select>
														</div>
														<div class="col-md-2">
															<label for="">Nivel</label>
															<select name="nivel" id="nivel" class="form-control">
																<option value="1">A</option>
																<option value="2">A1</option>
																<option value="3">A2</option>
																<option value="4">A3</option>
																<option value="5">B</option>
																<option value="6">B1</option>
																<option value="7">B2</option>
																<option value="8">B3</option>
																<option value="9">C</option>
																<option value="10">C1</option>
																<option value="11">C2</option>
																<option value="12">C3</option>
															</select>
														</div>
														<div class="col-md-2">
															<label for="">GES</label>
															<select name="ges" id="ges" class="form-control">
																<option value="1">Si</option>
																<option value="2">No</option>
															</select>
														</div>
														<div class="col-md-2">
															<label for="">Peso</label>
															<input type="number" name="peso" id="peso"
																class="form-control" step="1.01" placeholder="Peso"
																value="<?php echo $peso; ?>" onkeyup="calcularBSA()">
														</div>
														<div class="col-md-2">
															<label for="">Talla</label>
															<input type="number" name="talla" id="talla"
																class="form-control" step="1.01" placeholder="Talla"
																value="<?php echo $talla; ?>" onkeyup="calcularBSA()">
														</div>
														<div class="col-md-2">
															<label for="">S. Corporal</label>
															<input type="number" name="scorporal" id="scorporal"
																class="form-control" step="1.01" readonly
																value="<?php echo $supcop; ?>">
														</div>
														<div class="col-md-2">
															<label for="">Creatinina</label>
															<input type="number" name="creatinina" id="creatinina"
																class="form-control" step="1.01"
																placeholder="Creatinina">
														</div>
														<div class="col-md-2">
															<label for="">AUC</label>
															<input type="number" name="auc" id="auc"
																class="form-control" step="1.01" placeholder="AUC">
														</div>
														<div class="col-md-2">
															<label for="">Fecha de Administración</label>
															<input type="date" name="fechaadmin" id="fechaadmin"
																class="form-control">
														</div>
														<div class="col-md-2">
															<label for="">Examen Pendiente</label>
															<select name="examen" id="examen" class="form-control">
																<option value="1">Si</option>
																<option value="2">No</option>
															</select>
														</div>
														<div class="col-md-2">
															<label for="">N° Ciclio</label>
															<input type="number" name="ciclo" id="ciclo"
																class="form-control" placeholder="N° Ciclo">
														</div>
														<div class="col-md-2">
															<label for="">Anticipada</label>
															<select name="anticipada" id="anticipada"
																class="form-control">
																<option value="2">No</option>
																<option value="1">Si</option>
															</select>
														</div>

													</div>
													<div class="row mt-2">
														<div class="col-md-2">
															<h6>Intención a Tratar</h6>
															<input type="checkbox" name="curativo" id="curativo"
																value="1"><span> Curativo</span><br />
															<input type="checkbox" name="paliativo" id="paliativo"
																value="1"><span> Paliativo</span><br />
															<input type="checkbox" name="adyuvante" id="adyuvante"
																value="1"><span> Adyuvante</span><br />
															<input type="checkbox" name="concomitante" id="concomitante"
																value="1"><span> Concomitante</span><br />
															<input type="checkbox" name="neoadyuvante" id="neoadyuvante"
																value="1"><span> Neoadyuvante</span>
														</div>
														<div class="col-md-2">
															<h6>Cormobilidades</h6>
															<input type="checkbox" name="diabetes" id="diabetes"
																value="1"><span> Diabetes</span><br />
															<input type="checkbox" name="hipertension" id="hipertension"
																value="1"><span> Hipertensión Arterial</span><br />
															<input type="checkbox" onchange="detailsrecet(this)"
																name="alergia" id="alergia" value="1"><span>
																Alergia</span><br />
															<input type="checkbox" onchange="detailscor(this)"
																name="otrocor" id="otrocor" value="1"><span>
																Otro</span><br />
														</div>
														<div class="col-md-4">
															<div class="resetdetails d-none">
																<label for="">Alergia Detalle</label>
																<textarea name="alergiadetalle" id="alergiadetalle"
																	class="form-control"
																	placeholder="Alergia Detalle"></textarea>

															</div>
															<div class="cordetails d-none">
																<label for="">Otra Cormobilidad</label>
																<textarea name="otrcormo" id="otrcormo"
																	class="form-control"
																	placeholder="Especifique"></textarea>

															</div>
														</div>
														<div class="col-md-2">
														<h6>Documento</h6>
														<input type="checkbox" name="primera" id="primera"
																value="1"><span> Primer Ingreso</span><br />
															<input type="checkbox" name="traemedicamementos"
																id="traemedicamementos" value="1"><span> Trae
																Medicamentos</span><br />
														</div>
														<div class="col-md-2">
															<div class="row justify-content-end">
																<div class="col-md-12">
																	<label for="">Receta Urgente</label>
																	<select name="urgente" id="urgente"
																		class="form-control">
																		<option value="2">No</option>
																		<option value="1">Si</option>
																	</select>

																</div>
															</div>
														</div>
													</div>
												</div>
											</div>

											<div class="card">
												<div class="card-body">

													<div class="col-md-12">
														<label for="">Seleccionar Esquema:</label>
														<select name="esquema" id="esquema" class="form-control select2"
															onchange="cargarMedicamentoesquema()">
															<?php
															$esquema = $c->listaresquemasdiagnostico($empresa->getId(), $consulta->getDiagnostico());
															foreach ($esquema as $esquemas) {
																echo "<option value='" . $esquemas->getId() . "'>" . $esquemas->getNombre() . "</option>";
															}
															?>
														</select>
													</div>
													<div class="col-md-12 mt-4" id="medi">

													</div>
												</div>
											</div>
											<div class="card mt-3">
												<div class="card-body">
													<div>
														<h6 class="main-content-label mb-1">Medicamentos</h6>
													</div>
													<div class="text-wrap">
														<div class="example">
															<div class="border">
																<div class="bg-light-1 nav-bg">
																	<nav class="nav nav-tabs">
																		<a class="nav-link active" data-toggle="tab"
																			href="#tabCont1">Premedicación</a>
																		<a class="nav-link" data-toggle="tab"
																			href="#tabCont3">Estimulador</a>
																		<a class="nav-link" data-toggle="tab"
																			href="#tabCont4">Observación General</a>
																	</nav>
																</div>
																<div class="card-body tab-content">
																	<div class="tab-pane active show" id="tabCont1">
																		<table class="table w-100">
																			<thead>
																				<tr>
																					<th></th>
																					<th>Medicamento</th>
																					<th>Dosis MG</th>
																					<th>Oral</th>
																					<th>EV</th>
																					<th>SC</th>
																					<th>Observación</th>
																				</tr>
																			</thead>
																			<tbody id="premedicamentoscharge">
																				<?php
																				$premedicacion = $c->listarpremedicacion();
																				foreach ($premedicacion as $premedicaciones) {
																					echo "<tr class='m-0' >";
																					echo "<td class='m-0'><input type='checkbox' name='premedicacion" . $premedicaciones->getId() . "' id='premedicacion" . $premedicaciones->getId() . "' value='" . $premedicaciones->getId() . "'></td>";
																					echo "<td  class='m-0'>" . $premedicaciones->getNombre() . "</td>";
																					echo "<td class='m-0'><input type='number' name='dosismg" . $premedicaciones->getId() . "' id='dosismg" . $premedicaciones->getId() . "' class='form-control' placeholder='Dosis MG'></td>";
																					echo "<td class='m-0'><input type='checkbox' name='oral" . $premedicaciones->getId() . "' id='oral" . $premedicaciones->getId() . "' value='1'></td>";
																					echo "<td class='m-0'><input type='checkbox' name='ev" . $premedicaciones->getId() . "' id='ev" . $premedicaciones->getId() . "' value='1'></td>";
																					echo "<td class='m-0'><input type='checkbox' name='sc" . $premedicaciones->getId() . "' id='sc" . $premedicaciones->getId() . "' value='1'></td>";
																					echo "<td class='m-0'><input type='text' name='observacion" . $premedicaciones->getId() . "' id='observacion" . $premedicaciones->getId() . "' class='form-control' placeholder='Observación'></td>";
																					echo "</tr>";
																				}
																				?>
																			</tbody>
																		</table>
																	</div>
																	<div class="tab-pane" id="tabCont3">
																		<table class="table">
																			<thead>
																				<tr>
																					<th></th>
																					<th>Medicamento</th>
																					<th>Cantidad</th>
																					<th>Rango de dias</th>
																				</tr>
																			</thead>
																			<tbody>
																				<tr>
																					<td><input type="checkbox"
																							name="estimulador"
																							id="estimulador"></td>
																					<td>FILGRASTIM</td>
																					<td><input type="number"
																							name="cantidades"
																							id="cantidades"
																							class="form-control"></td>
																					<td><input type="number"
																							name="rango" id="rango"
																							class="form-control"></td>
																				</tr>
																			</tbody>
																		</table>
																	</div>
																	<div class="tab-pane" id="tabCont4">
																		<div class="row">
																			<div class="col-md-6">
																				<label for="">Anamesis</label>
																				<textarea name="anamnesis"
																					id="anamnesis" cols="30" rows="10"
																					class="form-control"></textarea>
																			</div>
																			<div class="col-md-6">
																				<label for="">Observación</label>
																				<textarea name="observacion"
																					id="observacion" cols="30" rows="10"
																					class="form-control"></textarea>
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
	<script src="JsFunctions/informe.js"></script>
	<script>
		//Cargar Tabla
		$(document).ready(function () {
			cargarsignos();
			cargarmedidas();
			cargarMedicamentoesquema();
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