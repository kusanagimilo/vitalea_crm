<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once '../clase/Examen.php';

$Obj_Examen = new Examen();

$tipo = $_POST["tipo"];

if ($tipo == 1) {
    $retorno = $Obj_Examen->VerExamenesNoPerfiles($_POST);
    echo $retorno;
}if ($tipo == 2) {
    $retorno = $Obj_Examen->VerExamenesPorPerfil($_POST);
    echo $retorno;
}if ($tipo == 3) {
    $retorno = $Obj_Examen->AdicionarExamenPorPerfil($_POST);
    echo $retorno;
}if ($tipo == 4) {
    $retorno = $Obj_Examen->ListaExamenes($_POST);
    echo $retorno;
}if ($tipo == 5) {
    $retorno = $Obj_Examen->VerSubExamen($_POST);
    echo $retorno;
}if ($tipo == 6) {
    $retorno = $Obj_Examen->AdicionarSubExamen($_POST);
    echo $retorno;
}if ($tipo == 7) {
    $retorno = $Obj_Examen->EliminarExamenPorPerfil($_POST);
    echo $retorno;
}if ($tipo == 8) {
    $retorno = $Obj_Examen->ListaGrupos($_POST);
    echo $retorno;
}if ($tipo == 9) {
    $retorno = $Obj_Examen->AlmacenarPerfil($_POST);
    echo $retorno;
}if ($tipo == 10) {
    $retorno = $Obj_Examen->AlmacenarExamen($_POST);
    echo $retorno;
}if ($tipo == 11) {
    $retorno = $Obj_Examen->InformacionPerfil($_POST);
    echo $retorno;
}if ($tipo == 12) {
    $retorno = $Obj_Examen->ModificarPerfil($_POST);
    echo $retorno;
}

