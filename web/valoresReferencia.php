<?php
require_once '../include/script.php';
require_once '../include/header_administrador.php';
?>

<body style="background-color: #F6F8FA">
    <script src="../ajax/Facturacion.js" type="text/javascript"></script>
    <div class="main-menu-area mg-tb-40">
        <div class="container" style="height:auto;">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                    <?php if ($array_permisos[0] == "11") { ?>
                        <ol class="breadcrumb">
                            <li><a href="inicio_usuario.php" title="Volver atras"><img src="images/atras.png"></a></li>
                            <li><a href="inicio_usuario.php" title="Inicio">Inicio</a></li>
                            <li class="active">Arqueo</li>
                        </ol>

                    <?php }if ($array_permisos[0] == "13") {
                        ?>
                        <ol class="breadcrumb">
                            <li><a href="inicio_arqueo.php" title="Volver atras"><img src="images/atras.png"></a></li>
                            <li><a href="inicio_arqueo.php" title="Inicio">Inicio</a></li>
                            <li class="active">Arqueo</li>
                        </ol>


                    <?php } else { ?>
                        <ol class="breadcrumb">
                            <li><a href="inicio_administrador.php" title="Volver atras"><img src="images/atras.png"></a></li>
                            <li><a href="inicio_administrador.php" title="Inicio">Inicio</a></li>
                            <li class="active">Arqueo</li>
                        </ol>
                    <?php } ?>

                    <div class="row pad-top" style="background-color: white;">

                        <div id="clientes" style="padding: 20px;">
                            <div class="row">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h3 class="panel-title"> 
                                            <img src="images/lista.png" alt=""/> 
                                            <b>Listado de compras realizadas (Arqueo)</b></h3>
                                    </div>
                                    <div class="panel-body">

                                        <p style="font-size: 11pt;">
                                            <img src="images/info.png" alt="">
                                            Seleccione los filtros necesarios para realizar la busqueda
                                        </p>

                                        <div class="row">
                                            <div class="col-md-6">
                                                Asesor : 
                                                <select class="form-control" id="asesor" name="asesor">
                                                    <option value="">--seleccione--</option>
                                                </select>
                                            </div>

                                            <div class="col-md-6">
                                                Fecha inicial : 
                                                <div class="form-group">
                                                    <div class='input-group date' id='datetimepicker6_cont'>
                                                        <input id="datetimepicker6" type='text' class="form-control" />
                                                        <span class="input-group-addon">
                                                            <span class="glyphicon glyphicon-calendar"></span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                Fecha final : 

                                                <div class="form-group">
                                                    <div class='input-group date' id='datetimepicker7_cont'>
                                                        <input id="datetimepicker7" type='text' class="form-control" />
                                                        <span class="input-group-addon">
                                                            <span class="glyphicon glyphicon-calendar"></span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <br>
                                                <button onclick="ListaArqueo()" class="btn btn-primary" id="btn_filtro" style="width: 100%">  <img src="images/lupa.png" style="width: 20px;"> Iniciar Búsqueda</button>
                                            </div>
                                        </div>

                                        <br>

                                        <div id="tabla_arqueo" class="table-responsive">

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

</body>
