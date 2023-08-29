<?php
require '../controller.php';
$c = new Controller();
$peso = $_POST['peso'];
$talla = $_POST['talla'];
$sp = $c->calculateBSA($talla,$peso);