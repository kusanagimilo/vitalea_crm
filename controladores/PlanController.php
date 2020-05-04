<?php

require_once '../clase/Plan.php';

$Obj_Plan = new Plan();

$tipo = $_POST["tipo"];

if ($tipo == 1) {
    $retorno = $Obj_Plan->AlmacenarPlanTarifaSistema($_POST);
    echo $retorno;
}if ($tipo == 2) {
    $retorno = $Obj_Plan->VerPlanes($_POST);
    echo $retorno;
}if ($tipo == 3) {
    $retorno = $Obj_Plan->ItemsPorPlan($_POST);
    echo $retorno;
}if ($tipo == 4) {
    $retorno = $Obj_Plan->EditarPrecioItem($_POST);
    echo $retorno;
}if ($tipo == 5) {
    $retorno = $Obj_Plan->AlmacenarPlanTarifaCsv($_POST, $_FILES);
    echo $retorno;
}if ($tipo == 6) {
    $retorno = $Obj_Plan->InfoPlan($_POST);
    echo $retorno;
}if ($tipo == 7) {
    $retorno = $Obj_Plan->EditarInfoPlan($_POST, $_FILES);
    echo $retorno;
}if ($tipo == 8) {
    $retorno = $Obj_Plan->VerPlanesLista($_POST, $_FILES);
    echo $retorno;
}
