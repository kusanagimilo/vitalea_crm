<?php

require '../clase/sedesVitalea.php';

$vitaleaSedes = new sedesVitalea();

$tipo = $_POST["tipo"];
if ($tipo == 1) {
    $retorno = $vitaleaSedes->sedesVitaleaFuncion($_POST);
    echo $retorno;
}
$botonEnvioArray = $_POST["botonEnvioArray"];
if ($tipo == 2) {
    $retorno = $vitaleaSedes->ingresarNuevaSede($_POST);
}
?>