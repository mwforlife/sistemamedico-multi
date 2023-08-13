<?php
session_start();
$empresa = null;
if(isset($_SESSION['CURRENT_ENTERPRISE'])){
	$enterprise = $_SESSION['CURRENT_ENTERPRISE'];
	$empresa = $c->buscarEmpresa($enterprise);
}else{
    header("Location: index.php");
}
if (!isset($_SESSION['USER_ID'])) {
	header("Location: signin.php");
}
$id = $_SESSION['USER_ID'];
require 'php/controller.php';
$c = new Controller();
$object = $c->buscarenUsuario1($id);
?>
<!DOCTYPE html>
<html lang="es">
	<head>

		<meta charset="utf-8">
		<meta content="width=device-width, initial-scale=1, shrink-to-fit=no" name="viewport">
		<meta name="description" content="Dashpro-  Admin Panel HTML Dashboard Template">
		<meta name="author" content="Spruko Technologies Private Limited">
		<meta name="keywords" content="responsive admin template,bootstrap dashboard theme,simple dashboard template,bootstrap admin dashboard,bootstrap 4 template admin,template admin bootstrap 4,template bootstrap 4 admin,quality dashboard template,bootstrap 4 admin template,premium bootstrap template,bootstrap simple dashboard,simple admin panel template,dashboard admin bootstrap 4,html css dashboard template,admin dashboard bootstrap 4,bootstrap 4 admin dashboard,bootstrap dashboard template">

		<!-- Favicon -->
		<link rel="icon" href="assets/img/brand/favicon.ico" type="image/x-icon"/>

		<!-- Title -->
		<title>OncoWay - Bloqueo</title>

		<!-- Bootstrap css-->
		<link href="assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet"/>
	<link href="assets/css/toastify.min.css" rel="stylesheet" />

		<!-- Icons css-->
		<link href="assets/css/icons.css" rel="stylesheet"/>

		<!-- Style css-->
		<link href="assets/css/style.css" rel="stylesheet">
		<link href="assets/css/dark-boxed.css" rel="stylesheet">
		<link href="assets/css/boxed.css" rel="stylesheet">
		<link href="assets/css/skins.css" rel="stylesheet">
		<link href="assets/css/dark-style.css" rel="stylesheet">

		<!-- Color css-->
		<link id="theme" rel="stylesheet" type="text/css" media="all" href="assets/css/colors/color.css">

		<!-- P-SCROLL css-->
		<link href="assets/plugins/perfect-scrollbar/perfect-scrollbar.css" rel="stylesheet">

	</head>

	<body class="horizontalmenu">

		<!-- Loader -->
		<div id="global-loader">
			<img src="assets/img/loader.svg" class="loader-img" alt="Loader">
		</div>
		<!-- End Loader -->

		<!-- Page -->
		<div class="page main-signin-wrapper">

			<!-- Row -->
			<div class="row signpages  justify-content-center text-center sign-2">
				<div class="col-md-12 col-xl-6">
					<div class="sign1">
						<div class="card">
							<div class="">
								<div class="card-body main-profile-overview mt-3 mb-3 p-5">
									<img src="assets/img/brand/dark-logo.png" class="header-brand-img text-left mb-5 desktop-logo" alt="logo">
									<img src="assets/img/brand/logo.png" class="header-brand-img desktop-logo text-left mb-5 theme-logo" alt="logo">
									<div class="clearfix"></div>
									<h5 class="text-left mb-2">Pantalla de Bloqueo</h5>
									<p class=" text-muted tx-13 ml-0 text-left">Haz iniciado sesión en otro navegador o en otro Dispositivo</p>
									<p class=" text-muted tx-13 ml-0 text-left">Desbloquée el Sistema Ingresando tu Contraseña</p>
									<form id="LockForm" name="LockForm">
										<div class="text-left d-flex float-left mb-4 user-lock">
											<img alt="avatar avatar-sm" class="rounded-circle mb-0" src="assets/img/users/9.jpg">
											<div class="my-auto">
												<h5 class="font-weight-semibold my-auto ml-4 text-uppercase "><?php echo $object->getNombre() . " " . $object->getApellido1() . " " . $object->getApellido2(); ?></h5>
											</div>
										</div>
										<input type="hidden" id="User" name="User" value="<?php echo $object->getEmail(); ?>">
										<div class="form-group">
											<input class="form-control rounded-11" id="Password" name="Password" placeholder="Ingresa tu Contraseña" type="password">
										</div>
										<button class="btn ripple btn-main-primary btn-block rounded-11 mt-4">Desbloquear</button>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- End Row -->

		</div>
		<!-- End Page -->

		<!-- Jquery js-->
		<script src="assets/plugins/jquery/jquery.min.js"></script>

		<!-- Bootstrap js-->
		<script src="assets/plugins/bootstrap/js/popper.min.js"></script>
		<script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>

		<!-- Perfect-scrollbar js -->
		<script src="assets/plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>

		<!-- Select2 js-->
		<script src="assets/plugins/select2/js/select2.min.js"></script>

		<!-- Custom js -->
		<script src="assets/js/custom.js"></script>
			<script src="JsFunctions/validation.js"></script>
			<script src="JsFunctions/Alert/toastify.js"></script>
			<script src="JsFunctions/Alert/sweetalert2.all.min.js"></script>
			<script src="JsFunctions/Alert/alert.js"></script>
			<script src="JsFunctions/login.js"></script>

	</body>
</html>