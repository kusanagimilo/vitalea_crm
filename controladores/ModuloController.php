<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once '../clase/Modulo.php';

$obj_modulo = new Modulo();
$tipo = $_POST["tipo"];

if ($tipo == 1) {
    $retorno = $obj_modulo->CrearModulo($_POST);
    echo $retorno;
}
if ($tipo == 2) {
    $retorno = $obj_modulo->VerModulos($_POST);
    echo $retorno;
}
if ($tipo == 3) {
    $retorno = $obj_modulo->UsuariosSelec($_POST);
    echo $retorno;
}if ($tipo == 4) {
    $retorno = $obj_modulo->UsuarioAsignado($_POST);
    echo $retorno;
}if ($tipo == 5) {
    $retorno = $obj_modulo->AsignarUsuarioModulo($_POST);
    echo $retorno;
}


