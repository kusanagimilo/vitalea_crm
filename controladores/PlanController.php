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
}
