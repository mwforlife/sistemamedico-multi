<?php
session_start();
if(isset($_POST['action']) && isset($_POST['id'])){
    if($_POST['action'] == 'sessionReserva'){
        $_SESSION['MED_ID'] = $_POST['id'];
    }
}