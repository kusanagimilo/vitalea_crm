<?php
require_once '../include/script_inicio.php';
require_once '../include/header_administrador.php';

$array_permisos = explode(",", $_SESSION['PERMISOS']);
$conteo = count($array_permisos);

if ($conteo == 1) {
    if (in_array("1", $array_permisos)) { // PERMISO CALL CENTER
        $permiso = 1;
    } else if (in_array("2", $array_permisos)) { //PERMISO PRESENCIAL
        $permiso = 2;
    } else if (in_array("6", $array_permisos)) { //PERMISO DIGITURNO
        $permiso = 3;
    }
}
?>
<body style="background-color: #f5f5f5;">
    <div id="fh5co-hero">
        <div>
            <div class="fh5co-cards">
                <div class="container-fluid">
                    <div class="row">
                        <center><h1 style="color: #535353; margin-top:-80px;">Administador Digiturno</h1></center><br>
                        <!--<div class="col-lg-4 col-md-6 col-sm-6 animate-box">
                            <a class="fh5co-card" href="inicio_digiturno_generar_turno.php" style="padding-top: 10px;">
                                <center>
                                    <img class="rounded-circle img-fluid d-block mx-auto" src="images/ticket_2.png" height="100" width="100" alt="">
                                    <div class="fh5co-card-body">
                                        <h3>Autogestion-Turno</h3>
                                    </div>
                                </center>
                            </a>
                        </div>-->
                        <div class="col-lg-4 col-md-6 col-sm-6 animate-box">
                            <a class="fh5co-card" href="administrar_asesores.php" style="padding-top: 10px;">
                                <center>
                                    <img class="rounded-circle img-fluid d-block mx-auto" src="images/admin_asesores.png" height="100"width="100" alt="">
                                    <div class="fh5co-card-body">
                                        <h3>Administrar permisos de asesores</h3>
                                    </div>
                                </center>
                            </a>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-6 animate-box">
                            <a class="fh5co-card" href="digiturno_adm_modulos.php" style="padding-top: 10px;">
                                <center>
                                    <img class="rounded-circle img-fluid d-block mx-auto" src="images/mostrar_turno.png" height="100"width="100" alt="">
                                    <div class="fh5co-card-body">
                                        <h3>Administracion de modulos</h3>
                                    </div>
                                </center>
                            </a>
                        </div>
                         <div class="col-lg-4 col-md-6 col-sm-6 animate-box">
                             <a class="fh5co-card" target="_blank" href="DigiturnoPantalla.php" style="padding-top: 10px;">
                                <center>
                                    <img class="rounded-circle img-fluid d-block mx-auto" src="images/modulo.png" height="100"width="100" alt="">
                                    <div class="fh5co-card-body">
                                        <h3>Generar pantalla de turnos</h3>
                                    </div>
                                </center>
                            </a>
                        </div>
                        <!--<div class="col-lg-4 col-md-6 col-sm-6 animate-box">
                            <a class="fh5co-card" href="digiturno_asignados.php" style="padding-top: 10px;">
                                <center>
                                    <img class="rounded-circle img-fluid d-block mx-auto" src="images/mostrar_turno.png" height="100"width="100" alt="">
                                    <div class="fh5co-card-body">
                                        <h3>Administracion de turnos asignados</h3>
                                    </div>
                                </center>
                            </a>
                        </div>-->
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>