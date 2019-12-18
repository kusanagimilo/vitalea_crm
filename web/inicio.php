<?php

require_once '../conexion/seguridad.php';


$array_permisos = explode(",", $_SESSION['PERMISOS']);

$conteo = count($array_permisos);

if ($conteo == 1) {

    if (in_array("1", $array_permisos) || in_array("11", $array_permisos)) { //PERMISO ASESOR CALL CENTER
        header("Location: ../web/inicio_usuario.php");
    } else if (in_array("2", $array_permisos)) { // PERMISO PRESENCIAL
        header("Location: ../web/inicio_usuario.php");
    } else if (in_array("3", $array_permisos)) { // PERMISO CLIENTE
    } else if (in_array("4", $array_permisos)) { // PERMISO TOMA DE MUESTRAS
    } else if (in_array("5", $array_permisos)) { // PERMISO ADMINISTRADOR
        header("Location: ../web/inicio_administrador.php");
    } else if (in_array("6", $array_permisos)) { // PERMISO ADMINISTRADOR
        header("Location: ../web/inicio_digiturno.php");
    } else if (in_array("7", $array_permisos)) { // PERMISO ADMINISTRADOR
        header("Location: ../web/inicio_admin_digiturno.php");
    } else if (in_array("8", $array_permisos)) { // PERMISO AUTOGESTION-TURNO
        header("Location: ../web/inicio_digiturno_generar_turno.php");
    } else if (in_array("9", $array_permisos)) { // PERMISO AUTOGESTION-TURNO
        header("Location: ../web/perfil_pago_turno.php");
    } else if (in_array("10", $array_permisos)) { // PERMISO TOMA DE MUESTRAS
        header("Location: ../web/perfil_toma.php");
    } else if (in_array("12", $array_permisos)) { // PERMISO DOCTOR
        header("Location: ../web/inicio_doc.php");
    } else if (in_array("13", $array_permisos)) { // PERMISO ARQUEO
        header("Location: ../web/inicio_arqueo.php");
    }
} else if ($conteo == 2) { //ASESOR CALL CENTER Y PRESENCIAL
} else if ($conteo == 5) { //ADMINISTRADOR -- CAMBIAR LOCATION AL ADMINISTRADOR
    header("Location: ../web/crear_cliente.php");
}
?>
