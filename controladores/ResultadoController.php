<?php

require_once '../clase/Resultado.php';

$Obj_Resultado = new Resultado();

$tipo = $_POST["tipo"];

if ($tipo == 1) {
    $retorno = $Obj_Resultado->VerListaResultados($_POST);
    echo $retorno;
}
if ($tipo == 2) {
    $retorno = $Obj_Resultado->ResultadosIndividual($_POST);
    echo $retorno;
}if ($tipo == 3) {
    $retorno = $Obj_Resultado->ResultadosDetalle($_POST);
    echo $retorno;
}if ($tipo == 4) {
    $retorno = $Obj_Resultado->VerLogsSolicitud($_POST);
    echo $retorno;
}if ($tipo == 5) {
    $retorno = $Obj_Resultado->VerAnalitos($_POST);
    echo $retorno;
}
