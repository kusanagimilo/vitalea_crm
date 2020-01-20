<?php

require '../clase/sedesVitalea.php';

$vitaleaSedes = new sedesVitalea();

$tipo = $_POST["tipo"];

if ($tipo == 1) {
    $retorno = $vitaleaSedes->sedesVitaleaFuncion($_POST);
    echo $retorno;
}


if ($tipo == 2) {
    $nombre = $_POST["nombre"];
    $ciudad = $_POST["ciudad"];
    $direccion = $_POST["direccion"];
    $barrio = $_POST["barrio"];
    $telefono = $_POST["telefono"];

    $envio = $vitaleaSedes->ingresarNuevaSede($nombre, $ciudad, $direccion, $barrio, $telefono);
}

?>