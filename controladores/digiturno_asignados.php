<?PHP
require_once '../include/script.php';
require_once '../include/header_administrador.php';
$array_permisos = explode(",", $_SESSION['PERMISOS']);
?>
<style>
    .loader {
        border: 16px solid #f3f3f3;
        border-radius: 50%;
        border-top: 16px solid #3498db;
        width: 250px;
        height: 250px;
        -webkit-animation: spin 2s linear infinite; /* Safari */
        animation: spin 2s linear infinite;
    }

    /* Safari */
    @-webkit-keyframes spin {
        0% { -webkit-transform: rotate(0deg); }
        100% { -webkit-transform: rotate(360deg); }
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>
<script src="../ajax/DgTurno.js" type="text/javascript"></script>
<body style="background-color: #F6F8FA">

    <div class="main-menu-area mg-tb-40">
        <div class="container" style="height:auto;">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                    <?php if ($array_permisos[0] == "11") { ?>
                        <ol class="breadcrumb">
                            <li><a href="inicio_usuario.php" title="Inicio">Inicio</a></li>
                            <li class="active">Administracion de turnos asignados</li>
                        </ol>
                    <?php } else { ?>
                        <ol class="breadcrumb">
                            <li><a href="perfil_pago_turno.php" title="Inicio">Inicio</a></li>
                            <li class="active">Administracion de turnos asignados</li>
                        </ol>
                    <?php } ?>

                    <div class="row pad-top" style="background-color: white;">

                        <div id="clientes" style="padding: 20px;">
                            <div class="row">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h3 class="panel-title"> 
                                            <img src="images/lista.png" alt=""/> 
                                            <b>Administracion de turnos asignados</b></h3>
                                    </div>
                                    <div class="panel-body">

                                        <ul class="nav nav-tabs">
                                            <li class="active"><a data-toggle="tab" href="#home">TURNOS PARA PAGOS</a></li>
                                            <li><a data-toggle="tab" href="#menu1">GENERAR TURNOS PARA TOMA DE MUESTRAS</a></li>

                                        </ul>

                                        <div class="tab-content">
                                            <div id="home" class="tab-pane fade in active">

                                                <div id="adm_turnos_asignados">

                                                </div>
                                            </div>
                                            <div id="menu1" class="tab-pane fade">
                                                <div id="adm_turnos_toma">

                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> 
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" data-backdrop="static" data-keyboard="false" id="ModalCargando" role="dialog">
        <div class="modal-dialog modal-lg">

            <!-- Modal content-->
            <div class="modal-content">

                <div class="modal-body">
                    <div class="row">
                        <div id="div_informacion_cliente">
                            <center>
                                <div class="loader"></div>
                                <h2>REALIZANDO OPERACION POR FAVOR ESPERE</h2>
                            </center>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div> 



    <!-- End Contact Info area-->
    <?php require_once '../include/footer.php'; ?>

    <script>
        TurnosAsignados(<?php echo $_SESSION['ID_USUARIO']; ?>, "PAGO");
        SeleccionTurnosToma(<?php echo $_SESSION['ID_USUARIO']; ?>);
    </script>
</body>

