<?php

require_once '../clase/Usuario.php';

$usuario = new Usuario();

$tipo = $_POST["tipo"];
$fecha_actual = date("Y-m-d");
if ($tipo == 1) {
    $listar_usuarios = $usuario->listar_usuarios();
    echo $listar_usuarios;
} else if ($tipo == 2) { // numero_usuarios_ call center
    $call_center = $usuario->numero_usuarios(1);
    echo $call_center;
} else if ($tipo == 3) { // numero_usuarios_ presencial
    $presencial = $usuario->numero_usuarios(2);
    echo $presencial;
} else if ($tipo == 4) { // activos call center
    $activos_call_center = $usuario->usuarios_activos($fecha_actual, 1, 1);
    echo $activos_call_center;
} else if ($tipo == 5) { // activos presencial
    $activos_presencial = $usuario->usuarios_activos($fecha_actual, 1, 2);
    echo $activos_presencial;
} else if ($tipo == 6) { // lista perfil
    $lista_perfil = $usuario->lista_perfil();
    echo $lista_perfil;
} else if ($tipo == 7) {
    $perfil = $_POST["perfil"];
    $numero_documento = $_POST["numero_documento"];
    $nombre_completo = $_POST["nombre_completo"];
    $correo = $_POST["correo"];
    $nombre_usuario = $_POST["nombre_usuario"];

    //$existe = $usuario->consultar_usuario($numero_documento);
    $existe = $usuario->ValidaExisteUsuario($numero_documento, $nombre_usuario);


    if ($existe == 0) {

        $guardar_usuario = $usuario->crear_usuario($numero_documento, $nombre_completo, $numero_documento, $correo, $nombre_usuario);
        $usuario_id = $usuario->consultar_usuario($numero_documento);
        $crear_perfil = $usuario->asignar_permiso($usuario_id, $perfil);

        $msj = $nombre_usuario;
    } else {
        $msj = 0;
    }

    echo $msj;
} else if ($tipo == 8) { //inactivar o activar usuarios
    $usuario_id = $_POST["usuario_id"];
    $estado_id = $_POST["estado_id"];

    if ($estado_id == 0) {
        $estado_final = 1;
    } else {
        $estado_final = 0;
    }

    $actualizar = $usuario->actualizar_estado($estado_final, $usuario_id);

    echo $estado_final;
} else if ($tipo == 9) { // usuarios digiturno
    $usuario_digiturno = $usuario->usuario_digiturno();
    echo $usuario_digiturno;
}
 else if ($tipo == 10) { // usuarios digiturno
    $usuario_id_digiturno = $_POST["usuario_id_digiturno"];
    $estado_id_digiturno = $_POST["estado_id_digiturno"];

    if ($estado_id_digiturno == 1) {
        $estado_final = 2;
    } else {
        $estado_final = 1;
    }

    $actualizar = $usuario->actualizar_estado_digiturno($estado_final, $usuario_id_digiturno);

    echo $estado_final;
}