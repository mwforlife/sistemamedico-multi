<?php
require '../php/controller.php';
$c = new Controller();
$lista  = array();

 // Intentar obtener los datos de la caché primero
 $cachedData = obtenerDatosDeCache('diagnosticos_cie10');

 if ($cachedData !== false) {
     // Si los datos están en caché, devolverlos
     echo "dats en cache";
     echo  json_encode($cachedData);
     echo "dats en cache";
     return;
 }

 $lista = $c->listarDiagnosticosCIE10test();
 // Almacenar los datos en caché
 almacenarDatosEnCache('diagnosticos_cie10', $lista);
echo "dats no en cache";
echo json_encode($lista);
echo "dats no en cache";

function obtenerDatosDeCache($clave) {
    $archivoCache = '../uploads/' . $clave . '.cache';

    if (file_exists($archivoCache) && is_readable($archivoCache)) {
        // Obtener el contenido del archivo de caché
        $contenido = file_get_contents($archivoCache);

        // Decodificar los datos del archivo (pueden estar serializados)
        $datos = unserialize($contenido);

        // Verificar si los datos son válidos y no han expirado
        if ($datos !== false && is_array($datos) && isset($datos['expira']) && $datos['expira'] > time()) {
            return $datos['datos'];
        }
    }

    return false;
}

function almacenarDatosEnCache($clave, $datos, $tiempoVida = 3600) {
    $archivoCache = '../uploads/' . $clave . '.cache';

    // Crear una matriz con los datos y la marca de tiempo de expiración
    $datosCache = [
        'datos' => $datos,
        'expira' => time() + $tiempoVida
    ];

    // Serializar y guardar en el archivo de caché
    file_put_contents($archivoCache, serialize($datosCache));
}