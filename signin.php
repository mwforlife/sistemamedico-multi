<?php
session_start();
if (isset($_SESSION['USER_ID'])) {
	header("Location: index.php");
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
	<title>OncoWay | Login</title>

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

	<!-- P-SCROLL css-->
	<link href="assets/plugins/perfect-scrollbar/perfect-scrollbar.css" rel="stylesheet">

</head>

<body class="horizontalmenu" style="background-image: url(assets/img/globe-bg.jpg);">

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
							<div class="card-body mt-2 mb-2 p-5">
								<img src="assets/img/brand/ud-white-logo2.png" style="width:150px !important;" class="header-brand-img text-left mb-5 desktop-logo" alt="logo">
								<img src="assets/img/brand/ud-white-logo2.png" width="150" class="header-brand-img desktop-logo text-left mb-5 theme-logo" alt="logo">
								<div class="clearfix"></div>
								<form id="LoginForm" name="LoginForm">
									<h5 class="text-left mb-2">Iniciar Session</h5>
									<p class="mb-4 text-muted tx-13 ml-0 text-left">Inicie Sesión para ingresar al sistema</p>
									<div class="row">
										<div class="col-12">
											<select name="" id="tiposesion" class="form-control rounded-11">
												<option value="1">Email</option>
												<option value="2">RUT</option>
											</select>
										</div>
									</div>
									<div class="form-group text-left">
										<label class="">Correo Electronico</label>
										<input id="User" name="User" class="form-control rounded-11" placeholder="Correo Electronico" type="email">
									</div>
									<div class="form-group text-left">
										<label class="">Contraseña</label>
										<input id="Password" name="Password" class="form-control rounded-11" placeholder="Contraseña" type="password">
									</div>
									<div class="row">
										<div class="col-12 mt-3">
											<button type="submit" class="btn btn-primary rounded-11 btn-block">Entrar</button>
										</div>
									</div>
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