<?PHP
require_once '../include/script.php';
require_once '../include/header_administrador.php';
?>
<script src="../ajax/DgTurno.js" type="text/javascript"></script>
<body style="background-color: #F6F8FA">

    <div class="main-menu-area mg-tb-40">
        <div class="container" style="height:auto;">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <ol class="breadcrumb">
                        <li><a href="perfil_toma.php" title="Inicio">Inicio</a></li>
                        <li class="active">Administracion de turnos asignados</li>
                    </ol>


                    <div class="row pad-top" style="background-color: white;">

                        <button type="button" onclick="TurnosAsignados(<?php echo $_SESSION['ID_USUARIO']; ?>, 'TOMA')" class="btn btn-primary btn-lg btn-block">RECARGAR TURNOS ASIGNADOS</button>

                        <div id="clientes" style="padding: 20px;">
                            <div class="row">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h3 class="panel-title"> 
                                            <img src="images/lista.png" alt=""/> 
                                            <b>Administracion de turnos asignados</b></h3>
                                    </div>
                                    <div class="panel-body">
                                        <div id="adm_turnos_asignados" class="table-responsive">

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
    <div class="modal" id="myModalResultados"  role="dialog" aria-labelledby="myModalLabel" >
        <div class="modal-dialog" style="width: 90%;">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #214761; color: white" >
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">
                        <img src="images/examen_venta.png" alt=""/>Detalle</h4>
                </div>
                <div class="modal-body col-md-12" style="height: 400px; overflow : auto;" id="cuerpo_modal">



                </div>          
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal" style="font-size: 11pt;"><img src="images/cerrar_dos.png"> Cerrar</button>
                </div>
            </div>                            
        </div>
    </div>




    <!-- End Contact Info area-->
    <?php require_once '../include/footer.php'; ?>

    <script>
        TurnosAsignados(<?php echo $_SESSION['ID_USUARIO']; ?>, 'TOMA');
    </script>
</body>

