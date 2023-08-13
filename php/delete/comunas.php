<?php
require '../controller.php';
$c = new Controller();

if(isset($_POST['id'])){
	$id = $_POST['id'];
	$c->eliminarcomuna($id);
	$c->eliminarciudad($id);
	echo 1;
}