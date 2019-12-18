<?php

header("Content-Type: text/html;charset=utf-8");

require '../clase/Sesion.php';
$sesion = new Sesion();

$usuario = $_POST["usuario_acceso"];
$clave = $_POST["clave"];
$respuesta = 0;

list($activo, $permisos, $id_usuario, $nombre_usuario, $username) = $sesion->inicio_sesion($usuario, $clave);

if ($activo == 3) {//USUARIO NO ESTA REGISTRADO
    $respuesta = 1;
} else if ($activo == 0) { //USUARIO NO ACTIVO
    $respuesta = 2;
} else if ($activo == 1) {// USUARIO REGISTRADO Y ACTIVO
    session_start();

    //guardar tiempo de inicio de sesion
    $proceso = 1; //inicio de sesion
    $sesion->log_usuario($id_usuario, $proceso);

    //Guardamos la variable de sesión [autentica] que nos auxiliará para saber si se está o no "logueado" un usuario 
    $_SESSION["autentica"] = "SIP";

    $_SESSION['ACTIVO'] = $activo;
    $_SESSION['PERMISOS'] = $permisos;
    $_SESSION['ID_USUARIO'] = $id_usuario;
    $_SESSION['NOMBRE_USUARIO'] = $nombre_usuario;
    $_SESSION['USER_NAME'] = $username;


    $respuesta = 3;
}

echo $respuesta;
die();
