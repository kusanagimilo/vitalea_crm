<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once '../clase/DgTurno.php';

$obj_DgTurno = new DgTurno();
$tipo = $_POST["tipo"];

if ($tipo == 1) {
    $retorno = $obj_DgTurno->CrearTurno($_POST);
    echo $retorno;
}
if ($tipo == 2) {
    $retorno = $obj_DgTurno->DatosTurno($_POST);
    echo $retorno;
}
if ($tipo == 3) {
    $retorno = $obj_DgTurno->TurnosAsignados($_POST);
    echo $retorno;
}
if ($tipo == 4) {
    $retorno = $obj_DgTurno->AceptarCancelarTurno($_POST);
    echo $retorno;
}if ($tipo == 5) {
    $retorno = $obj_DgTurno->TurnosModulos($_POST);
    echo $retorno;
}if ($tipo == 6) {
    $retorno = $obj_DgTurno->SeleccionTurnosToma($_POST);
    echo $retorno;
}if ($tipo == 7) {
    $retorno = $obj_DgTurno->BusquedaTurnosDisponibles($_POST);
    echo $retorno;
}if ($tipo == 8) {
    $retorno = $obj_DgTurno->DetalleExamenesSolicitud($_POST);
    echo $retorno;
}
