<?php
// Establecer el tiempo de vida de la sesión en segundos
$tiempoDeVida = 60 * 40; //40 minutos
ini_set('session.cookie_lifetime', $tiempoDeVida);
ini_set('session.gc_maxlifetime', $tiempoDeVida);
