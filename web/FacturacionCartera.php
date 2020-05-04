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
<script src="../ajax/Facturacion.js" type="text/javascript"></script>
<body style="background-color: #F6F8FA">

    <div class="main-menu-area mg-tb-40">
        <div class="container" style="height:auto;">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                    <?php if ($array_permisos[0] == "11") { ?>
                        <ol class="breadcrumb">
                            <li><a href="inicio_usuario.php" title="Volver atras"><img src="images/atras.png"></a></li>
                            <li><a href="inicio_usuario.php" title="Inicio">Inicio</a></li>
                            <li class="active">Facturación y/o Cartera</li>
                        </ol>

                    <?php } else { ?>
                        <ol class="breadcrumb">
                            <li><a href="inicio_administrador.php" title="Volver atras"><img src="images/atras.png"></a></li>
                            <li><a href="inicio_administrador.php" title="Inicio">Inicio</a></li>
                            <li class="active">Facturación y/o Cartera</li>
                        </ol>
                    <?php } ?>

                    <div class="row pad-top" style="background-color: white;">

                        <div id="clientes" style="padding: 20px;">
                            <div class="row">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h3 class="panel-title"> 
                                            <img src="images/lista.png" alt=""/> 
                                            <b> Lista ventas y/o prospectos</b></h3>
                                    </div>
                                    <div class="panel-body">

                                        <p style="font-size: 11pt;">
                                            <img src="images/info.png" alt="">
                                            Seleccione los filtros necesarios para realizar la busqueda
                                        </p>

                                        <div class="row">
                                            <div class="col-md-6">
                                                Nº de documento : <input id="n_documento" name="n_documento" type="text" class="form-control">
                                            </div>
                                            <div class="col-md-6">
                                                Medio de pago : 
                                                <select class="form-control" id="medio_pago" name="medio_pago">
                                                    <option value="">--seleccione--</option>
                                                    <option value="1">PSE (Pago Online)</option>
                                                    <option value="3">Tarjeta de Crédito</option>
                                                    <option value="2">En efectivo</option>
                                                    <option value="4">Transferencia Bancaria</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                Estado : 
                                                <select class="form-control" id="estado_ven" name="estado_ven">
                                                    <option value="">--seleccione--</option>
                                                    <option value="2">Pagado</option>
                                                    <option value="1">Por pagar</option>
                                                    <option value="3">Cancelado</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <br>
                                                <button onclick="VerListaFacturacion()" class="btn btn-primary" id="btn_filtro" style="width: 100%">  <img src="images/lupa.png" style="width: 20px;"> Iniciar Búsqueda</button>
                                            </div>
                                        </div>

                                        <br>

                                        <div id="tabla_factur" class="table-responsive">

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

    <!--<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" style="text-align: right;">                 
        <button type="button" id="openBtn" class="btn btn-default" data-toggle="modal" data-target="#myModalResultados"> <img src="images/anadir_dos.png"> Agregar examen</button>
    </div> -->
    <div class="modal" id="myModalResultados"  role="dialog" aria-labelledby="myModalLabel" >
        <div class="modal-dialog" style="width: 80%;">
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


    <div class="modal" id="myNoFactura"  role="dialog" aria-labelledby="myModalLabel" >
        <div class="modal-dialog" style="width: 80%;">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #214761; color: white" >
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">
                        <img src="images/examen_venta.png" alt=""/>Detalle</h4>
                </div>
                <div class="modal-body col-md-12" style="height: 400px; overflow : auto;" id="cuerpo_modal_factura">


                </div>          
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal" style="font-size: 11pt;"><img src="images/cerrar_dos.png"> Cerrar</button>
                </div>
            </div>                            
        </div>
    </div>


    <!-- Modal de verificación de Transferencia Bancaria -->
    <div class="modal" id="modalTransferenciaBancaria" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" style="width: 58%">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #214761; color: white">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">
                        <img width="40" style="border-radius: 50%" src="images/transferenciaBancaria.png" alt="imagen_logo_transferencia_bancaria" /> Transferencia Bancaria</h4>
                </div>
                <div class="modal-body col-md-12" id="cuerpo_modal">
                    <!-- Contenedor del Header de la ventana modal -->
                    <div class="contenedor">
                        <section>
                            <h3 style="text-align: center;">En esta opcion podras guardar el comprobante de la transferencia realizado en la compra.</h3>
                        </section>
                    </div>
                    <!-- Contenedor del cuerpo de la ventana modal -->
                    <div class="contenedor" style="overflow:auto">
                        <section>
                            <p style="text-align: left; margin: 20px">Por favor seleccione un archivo como comprobante para subir al sistema.</p>
                        </section>
                        <section>
                            <form enctype="multipart/form-data" method="post" name="fileinfo" id="frm_forms"> 
                                <input style="margin: 20px" type="file" name="archivo" id="archivo" class="custom-file-input">

                                <div class="alert alert-info" role="alert" id="documento_tran" style="display:none;">
                                </div>


                                <button  id="btn_documento" type="button" class="btn btn-primary btn-lg btn-block">Adicionar documento</button>
                                <!--<button onclick="AdicionarComprobante('44', '21')" style="margin-left: 20px" class="btn btn-success" name="enviarTransferenciaBancaria" id="enviarTransferenciaBancaria"><i class="fas fa-cloud-upload-alt"></i> Subir Archivo</button>-->
                            </form>
                        </section>
                    </div>



                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal" style="font-size: 11pt;"><img src="images/cerrar_dos.png"> Cerrar</button>
                </div>
            </div>
        </div>
    </div>


    <!-- End Contact Info area-->
    <?php require_once '../include/footer.php'; ?>

</body>

</html>