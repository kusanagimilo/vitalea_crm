<?php

require '../clase/sedesVitalea.php';

$vitaleaSedes = new sedesVitalea();

$tipo = $_POST["tipo"];

if ($tipo == 1) {
    /* Controlador para visualizacion de la tabla, llamando los parametros desde el documento 
    de clases llamado 'sedesVitalea.php', que nos hace un echo de los parametros de la consulta*/
    $retorno = $vitaleaSedes->sedesVitaleaFuncion($_POST);
    echo $retorno;
}


if ($tipo == 2) {
    /* Controlador para la creacion de datos de la tabla sedes_vitalea, llevando los parametros hacia el documento 
    de clases llamado 'sedesVitalea.php', que nos hace el 'POST' de los parametros de la consulta*/
    $nombre = $_POST["nombre"];
    $ciudad = $_POST["ciudad"];
    $direccion = $_POST["direccion"];
    $barrio = $_POST["barrio"];
    $telefono = $_POST["telefono"];

    $envio = $vitaleaSedes->ingresarNuevaSede($nombre, $ciudad, $direccion, $barrio, $telefono);
}

if ($tipo == 3) {
    /* Controlador para la eliminacion de datos de la tabla sedes_vitalea, Llevando el parametro identificador para realizar
    la query hacia el documento de clases llamado 'sedesVitalea.php', que es el ejecutor final de la consulta a la BD*/
    $eliminacion = $_POST["eliminar"];
    $orden = $vitaleaSedes->eliminacionDeSede($eliminacion);
}

?>