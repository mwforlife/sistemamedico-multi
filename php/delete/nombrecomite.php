<?php
require '../controller.php';
$c = new Controller();

if(isset($_POST['id'])){
	$id = $_POST['id'];
	$c->eliminarnombrecomite($id);
	echo 1;
}