<?php
require_once '../include/script_inicio.php';
//require_once '../include/script.php';
require_once '../include/header_administrador.php';




$array_permisos = explode(",", $_SESSION['PERMISOS']);
$conteo = count($array_permisos);

if ($conteo == 1) {
    if (in_array("1", $array_permisos)) { // PERMISO CALL CENTER
        $permiso = 1;
    } else if (in_array("2", $array_permisos)) { //PERMISO PRESENCIAL
        $permiso = 2;
    }
}
?>


<body>
    <div class="container-fluid">

        <div id="fh5co-hero">
            <div id="fh5co-main">

                <div class="fh5co-cards">


                    <div class="row">
                        <div class="col-lg-4 col-md-6 col-sm-6 animate-box">
                            <a class="fh5co-card" href="buscar_paciente.php?v=1" style="padding-top: 10px;">
                                <center>
                                    <img class="rounded-circle img-fluid d-block mx-auto" src="images/asesores.png" height="100" width="100" alt="">
                                    <div class="fh5co-card-body">
                                        <h3>Buscar Paciente</h3>
                                    </div>
                                </center>
                            </a>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-6 animate-box">
                            <a class="fh5co-card" href="crear_cliente.php" style="padding-top: 10px;">
                                <center>
                                    <img class="rounded-circle img-fluid d-block mx-auto" src="images/equipo.png" height="100" width="100" alt="">
                                    <div class="fh5co-card-body">
                                        <h3>Nuevo Paciente</h3>
                                    </div>
                                </center>
                            </a>
                        </div>

                        <div class="col-lg-4 col-md-6 col-sm-6 animate-box">
                            <a class="fh5co-card" href="buscar_paciente.php?v=2" style="padding-top: 10px;">
                                <center>
                                    <img class="rounded-circle img-fluid d-block mx-auto" src="images/caja.png" height="100" width="100" alt="">
                                    <div class="fh5co-card-body">
                                        <h3>Ventas</h3>
                                    </div>
                                </center>
                            </a>
                        </div>


                        <?php if ($array_permisos[0] == "11") { ?>

                            <div class="col-lg-4 col-md-6 col-sm-6 animate-box">
                                <a class="fh5co-card" href="FacturacionCartera.php" style="padding-top: 10px;">
                                    <center>
                                        <img class="rounded-circle img-fluid d-block mx-auto" src="images/cartera.png" height="100" width="100" alt="">
                                        <div class="fh5co-card-body">
                                            <h3>Facturación y/o Cartera</h3>
                                        </div>
                                    </center>
                                </a>
                            </div>
                        <?php } ?>

                        <?php if ($array_permisos[0] == "11") { ?>

                            <div class="col-lg-4 col-md-6 col-sm-6 animate-box">
                                <a class="fh5co-card" href="digiturno_asignados.php" style="padding-top: 10px;">
                                    <center>
                                        <img class="rounded-circle img-fluid d-block mx-auto" src="images/mostrar_turno.png" height="100"width="100" alt="">
                                        <div class="fh5co-card-body">
                                            <h3>Administracion de turnos asignados</h3>
                                        </div>
                                    </center>
                                </a>
                            </div>
                        <?php } ?>

                        <div class="col-lg-4 col-md-6 col-sm-6 animate-box">
                            <a class="fh5co-card" href="seguimiento_usuarios.php" style="padding-top: 10px;">
                                <center>
                                    <img class="rounded-circle img-fluid d-block mx-auto" src="images/coordinador.png" height="100" width="100" alt="">
                                    <div class="fh5co-card-body">
                                        <h3>Seguimiento y Reventa  </h3>
                                    </div>
                                </center>
                            </a>
                        </div>

                        <div class="col-lg-4 col-md-6 col-sm-6 animate-box">
                            <a class="fh5co-card" href="calendario.php" style="padding-top: 10px;">
                                <center>
                                    <img class="rounded-circle img-fluid d-block mx-auto" src="images/calendario_inicio.png" height="100" width="100" alt="">
                                    <div class="fh5co-card-body">
                                        <h3>Seguimiento Programados  </h3>
                                    </div>
                                </center>
                            </a>
                        </div>


                        <?php //if ($permiso == 1) { ?>
                        <!-- <div class="col-lg-4 col-md-6 col-sm-6 animate-box">
                             <a class="fh5co-card" href="https://app.jivosite.com/" target="_blank" style="padding-top: 10px;">
                                 <center>
                                     <img class="rounded-circle img-fluid d-block mx-auto" src="images/jivochat.png" height="100" width="100" alt="">
                                     <div class="fh5co-card-body">
                                         <h3>Chat </h3>
                                     </div>
                                 </center>
                             </a>
                         </div>-->
                        <?php // } ?>


                    </div>
                </div>
            </div>
        </div>

        <!-- /.container -->

        <!-- Footer -->
        <?php require_once '../include/footer.php'; ?>

</body>


</html>
