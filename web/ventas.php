<?PHP
//require_once '../include/script.php';
require_once '../include/script.php';
require_once '../include/header_administrador.php';

require_once '../clase/Gestion.php';
require_once '../clase/Cliente.php';

$gestion = new Gestion();
$cliente = new Cliente();

$gestion_id = base64_decode($_REQUEST["id"]);

$id_cliente = $gestion->gestion_cliente_id($gestion_id);
$email = $cliente->correo_paciente($id_cliente);


$array_permisos = explode(",", $_SESSION['PERMISOS']);
$conteo = count($array_permisos);

if ($conteo == 1) {
    if (in_array("1", $array_permisos)) { // PERMISO CALL CENTER
        $permiso = 1;
    } else if (in_array("2", $array_permisos)) { //PERMISO PRESENCIAL
        $permiso = 2;
    }
}

$clasificacion_id = $gestion->clasificacion_paciente($id_cliente);
$guion = $gestion->guion($clasificacion_id);
?>

<script src="../ajax/bono.js"></script>
<script src="../ajax/Plan.js"></script>
<script src="../web/js/dist/jspdf.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<script>
    $(document).ready(function() {
        window.location.hash = "no-back-button";
        window.location.hash = "Again-No-back-button"; //esta linea es necesaria para chrome
        window.onhashchange = function() {
            window.location.hash = "no-back-button";
        }

        $('select').select2();
        informacion_cliente();

        medios_comunicacion();
        obtener_categoria_examen();
        tablaTemporalInicial();

        $('.i-checks').on('click', function() {
            if ($(this).is(':checked')) {
                var valor = $(this).val();
                if (valor == "1") {
                    $("#examenes_perfiles").css("display", "block");
                    $("#examenes_no_perfiles").css("display", "none");
                } else {
                    $("#examenes_no_perfiles").css("display", "block");
                    $("#examenes_perfiles").css("display", "none");
                }

            }
        });

        $(".atras").click(function() {
            var usuario_id = $("#usuario_id").val();
            var id_cliente = $("#cliente_id").val();
            var gestion_id = $("#gestion_id").val();

            $.ajax({
                url: '../controladores/Gestion.php',
                data: {
                    tipo: 27,
                    gestion_id: gestion_id,
                    id_cliente: id_cliente,
                    usuario_id: usuario_id
                },
                type: 'post',
                success: function(data) {
                    window.location.href = "../web/inicio_usuario.php";
                }
            });
        });

        $("#medios_comunicacion").change(function() {
            div_medio_comunicacion();
        })

        $("#examen_categoria_venta").change(function() {
            obtener_examen();
        });

        $("#examen_descripcion_venta").change(function() {

            obtener_examen_precios2();
        });

        $("#btn_agregar_producto").click(function() {
            agregarVentaTemp();
        });

        $("#btn_finalizar_cotizacion").click(function() {
            generarCotizacion();
        });

        $("#btn_finalizar_venta").click(function() {
            agregarVenta();
        });

        //obtenerExamenNoPerfil();
        $("#examen_no_perfil").select2({
            ajax: {
                url: "../controladores/Gestion.php",
                type: "POST",
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        searchTerm: params.term,
                        tipo: 32
                    };
                },
                processResults: function(response) {
                    return {
                        results: response
                    };
                },
                cache: true
            }
        });

        $("#examen_no_perfil").change(function() {
            obtenerPrecioExamenNoPerfil2();
        });

        ListaPlanesVenta();
        //BonosPersona($("#cliente_id").val());

    });
</script>

<style type="text/css">
    @media screen and (max-width: 800px) {

        /* Desaparecer el header */
        table.tinfo thead,
        th {
            border: none;
            clip: rect(0, 0, 0, 0);
            height: 1px;
            margin: -1px;
            overflow: hidden;
            padding: 0;
            position: absolute;
            width: 1px;
        }

        table.tinfo tr {
            border-bottom: 3px solid;
        }

        table.tinfo td {
            border-bottom: 1px solid #ddd;
            display: block;
            font-size: 1.2em;
            text-align: right;
            padding: 10px;
        }

        table.tinfo th {
            border-bottom: 1px solid #ddd;
            display: block;
            font-size: 1.2em;
            text-align: right;
            padding: 10px;
        }

        table.tinfo td:before {
            content: attr(data-label);
            float: left;
            color: #273b47;
            font-weight: bold;
            font-size: 1em;
            padding: 1px 5px;
        }


    }

    .loader {
        border: 16px solid #f3f3f3;
        border-radius: 50%;
        border-top: 16px solid #3498db;
        width: 250px;
        height: 250px;
        -webkit-animation: spin 2s linear infinite;
        /* Safari */
        animation: spin 2s linear infinite;
    }

    /* Safari */
    @-webkit-keyframes spin {
        0% {
            -webkit-transform: rotate(0deg);
        }

        100% {
            -webkit-transform: rotate(360deg);
        }
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }
</style>

<script src="../ajax/venta.js"></script>
<script src="../include/constante.js"></script>

<body style="background-color: #F6F8FA; ">


    <input name="cliente_id" id="cliente_id" value="<?php echo $id_cliente; ?>" type="hidden">
    <input name="gestion_id" id="gestion_id" value="<?php echo $gestion_id; ?>" type="hidden">
    <input name="permiso" id="permiso" value="<?php echo $permiso; ?>" type="hidden">
    <input name="usuario_id" id="usuario_id" value="<?php echo $_SESSION['ID_USUARIO']; ?>" type="hidden">


    <div class="main-menu-area mg-tb-40" style="height:auto;">
        <div id="div_cargando">
            <div class="container" style="height:auto;">
                <div class="row">
                    <ol class="breadcrumb">
                        <li><a class="atras" title="Volver atras"><img src="images/atras.png"></a></li>

                        <li><a class="atras" title="Inicio">Inicio</a></li>
                        <li class="active">Ventas y/o Cotizaciónes</li>
                    </ol>

                    <div class="panel panel-default">
                        <div class="panel-heading col-lg-12 col-md-12 col-sm-12 col-xs-12" style="height:auto; min-height: 50px; ">
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                <h3 class="panel-title">
                                    <b style="float: left"> <img src="images/calificacion.png" alt="" />
                                        Ventas y/o Cotizaciónes</b> </h3>
                            </div>
                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">

                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                    <a href="javascript:VentanaCentrada('ver_solicitud.php?x=<?php echo base64_encode($id_cliente) ?>&o=<?php echo base64_encode(1) ?>','Ventas','','1024','768','true')" style="width: 100%">
                                        <button class="btn btn-primary" style="width: 100%">
                                            <img src="images/pago_paciente.png" alt="" style="width: 20px;" /> Ventas Realizadas
                                        </button></a>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                    <a href="javascript:VentanaCentrada('ver_solicitud.php?x=<?php echo base64_encode($id_cliente) ?>&o=<?php echo base64_encode(2) ?>','Cotizaciones','','1024','768','true')" style="width: 100%">
                                        <button class="btn btn-primary" style="width: 100%">
                                            <img src="images/cotizacion.png" alt="" style="width: 20px;" /> Cotizaciónes Realizadas
                                        </button></a>
                                </div>

                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                    <a href="javascript:VentanaCentrada('examenes.php','Examenes','','1024','768','true')" style="width: 100%">
                                        <button class="btn btn-default" style="width: 100%">
                                            <img src="images/cerrar.png" alt="" style="width: 20px;" /> Lista de Examenes
                                        </button></a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="panel panel-default">
                        <div class="panel-heading col-lg-12 col-md-12 col-sm-12 col-xs-12" style="height:auto; min-height: 50px;">
                            <h3 class="panel-title">
                                <img src="images/gestion_llamada.png" alt="" /> <b>Bienvenida</b> </h3>

                        </div>
                        <div class="panel-body">
                            <div class="row pad-top" style="background-color: white; padding: 20px;">
                                <br><br>
                                <?php echo $guion; ?>
                            </div>
                        </div>
                    </div>

                    <div class="panel panel-default">
                                        <div style="height: 50px;border-bottom:1px solid #00c292;padding: 10px; ">
                                            <a href="#collapse3" id="colapsible_clasificacion" style=" text-decoration: none; color: black;">
                                                <h4 style="color:#00c292;">
                                                <i class="fas fa-id-card"></i>
                                                    Politica de Tratamiento de datos "Habeas-Data"
                                                    <span style="float:right"><img src="images/sort_desc.png" alt=""/></span></h4>
                                            </a>
                                        </div>

                                        <div id="collapse3" class="panel-collapse collapse" style="display: block">
                                            <div class="panel-body">
                                                <div class="cta-desc">
                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                    <h3 style="text-align: center">Politica de tratamiento de datos VITALEA </h3>
                                                    <div style="max-height: 350px; overflow-y: scroll; padding: 70px; text-align: justify; box-sizing: border-box">
                                                        <?php include('./reportes/habeasData.php') ?>
                                                    </div>
                                                    <div style="padding: 40px; text-align: center; box-sizing: border-box; display: inline;">
                                                        <div>
                                                            <label for="">¿Estas de acuerdo con la politica de tratamiento de datos "Habeas Data"?</label>
                                                        </div>
                                                        <div style="display: block">
                                                            Si <input name="habeasData" data-toggle="modal" data-target="#myModalFirma" type="radio" id="checkHabeasData" style="margin-top: -4px;">
                                                            No <input name="habeasData" data-toggle="modal" data-target="#modalAnuncioHD" type="radio" id="checkHabeasData" style="margin-top: -4px;">
                                                        </div>
                                                    </div>
                                                    </div>
                                                </div>   
                                            </div>   
                                        </div>                                                                               
                                    </div>

                    <div class="panel panel-default">
                        <div class="panel-heading col-lg-12 col-md-12 col-sm-12 col-xs-12" style="height:auto; min-height: 50px;">
                            <h3 class="panel-title">
                                <img src="images/examen_venta.png" alt="" /> Informacion del Paciente </h3>

                        </div>

                        <div class="panel-body">
                            <div class="row pad-top" style="background-color: white;">
                                <div id="tabla_informacion_cliente" class="table table-responsive"></div>
                            </div>
                        </div>
                        <button class="btn btn-danger" id="btnHabeas" style="margin: 0px 0px 35px 20px"><i class="fas fa-file-pdf"></i> Generar PDF Habeas Data</button>
                    </div>

                    <div class="panel panel-default" id="contenedor_planes">
                        <div class="panel-heading col-lg-12 col-md-12 col-sm-12 col-xs-12" style="height:auto; min-height: 50px;">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <h3 class="panel-title">
                                    <img src="images/examen_venta.png" alt="" />
                                    Seleccione el plan que va a aplicar para esta venta
                                </h3>
                            </div>


                        </div>
                        <div class="panel-body">
                            <div class="row pad-top" style="background-color: white;">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="con_plan">

                                </div>
                            </div>
                        </div>
                    </div>

                    <!--<div class="panel panel-default" id="contenedor_bonos">
                        <div class="panel-heading col-lg-12 col-md-12 col-sm-12 col-xs-12" style="height:auto; min-height: 50px;">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12"> 
                                <h3 class="panel-title"> 
                                    <img src="images/examen_venta.png" alt=""/>
                                    Bonos disponibles para redimir
                                </h3>
                            </div>


                        </div>
                        <div class="panel-body" >
                            <div class="row pad-top" style="background-color: white;">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="con_bon">

                                </div>
                            </div>           
                        </div>
                    </div>-->

                    <div class="panel panel-default">
                        <div class="panel-heading col-lg-12 col-md-12 col-sm-12 col-xs-12" style="height:auto; min-height: 50px;">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <h3 class="panel-title">
                                    <img src="images/examen_venta.png" alt="" />
                                    Agregue examenes para generar venta o cotización </h3>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" style="text-align: right;">
                                <button type="button" class="btn btn-default" id="btn_adicionar_plan" onclick="RevisaSeleccionPlan()"> <img src="images/anadir_dos.png"> Agregar examen</button>
                            </div>

                        </div>
                        <div class="panel-body">
                            <div class="row pad-top" style="background-color: white;">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div id="tabla_temporal" class="table table-responsive"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Seleccion medio de comunicacion -->
                    <?php if ($permiso == 1) { ?>
                        <div class="panel panel-default">
                            <div class="panel-heading col-lg-12 col-md-12 col-sm-12 col-xs-12" style="min-height: 50px;height: auto">
                                <h3 class="panel-title col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <img src="images/medio_comunicacion.png" alt="" /> Seleccione el medio de comunicación por el cual el paciente se comunica</h3>

                            </div>
                            <div class="panel-body">
                                <div class="row pad-top col-lg-12 col-md-12 col-sm-12 col-xs-12" style="background-color: white;">

                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                                        <div class="form-group">
                                            <label><img src="images/charlar.png"> Medio</label>
                                            <div class="nk-int-st">
                                                <select id="medios_comunicacion" style="width: 100%">
                                                    <option value=''>Seleccione</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-top: 10px;">

                                        <p id="texto_comunicacion"></p>
                                        <div id="medio_chat" style="display: none">

                                            <textarea class="form-control" id="mensaje" style="width: 100%;" rows="10"></textarea>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    <div class="panel panel-default">
                        <div class="panel-heading " style="height: 50px;">
                            <h3 class="panel-title">
                                <img src="images/finalizar_dos.png" alt="" /> Seleccione proceso</h3>

                        </div>
                        <div class="panel-body">
                            <div class="row pad-top" style="background-color: white;">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <input type="radio" value="1" name="evento" onclick="mostrarCotizacion()">
                                    <img src="images/historial-medico.png">
                                    Cotización
                                    <input type="radio" value="2" name="evento" onclick="mostrarVenta()">
                                    <img src="images/pago_paciente.png">
                                    Venta
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div id="evento_cotizacion" style="display: none">
                                        <hr>
                                        <p style="font-size: 11pt;">
                                            <img src="images/info.png" alt="" />
                                            Realice la validaci&oacute;n de correo electronico</p>
                                        <hr>
                                        <div class="form-group">
                                            <label> <img src="images/arroba.png" alt="" /> Correo electronico</label>
                                            <div class="nk-int-st">
                                                <input type="email" id="email" name="email" value="<?php echo $email; ?>" class="form-control">
                                            </div>
                                        </div>

                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="panel-heading" style="border: 1px solid #ddd">
                                                <label><img src="images/notas.png"> Observaciones</label>
                                                <div class="nk-int-st">
                                                    <textarea class="form-control" id="observacion_cotizacion"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <br><br>
                                        <button id="btn_finalizar_cotizacion" style="float: right;" class="btn btn-primary"> <img src="images/finalizar_tres.png"> Finalizar y enviar correo electr&oacute;nico</button> <br>

                                    </div>
                                    <div id="evento_venta" style="display: none">
                                        <hr>
                                        <p style="font-size: 11pt;">
                                            <img src="images/info.png" alt="" />
                                            Seleccione el medio de pago</p>
                                        <hr>
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="col-md-4">
                                                <input type="radio" value="1" name="medio_pago">
                                                <img src="images/internet.png"> PSE (Pago Online)
                                            </div>
                                            <div class="col-md-4">
                                                <input type="radio" value="3" name="medio_pago">
                                                <img src="images/tarjeta_credito.png"> Tarjeta de Crédito
                                            </div>


                                            <div class="col-md-4">
                                                <input type="radio" value="2" name="medio_pago">
                                                <img src="images/efectivo.png"> En efectivo
                                            </div>
                                        </div>
                                        <br><br>
                                        <div class="form-group">
                                            <label> <img src="images/arroba.png" alt="" /> Realice la validaci&oacute;n de Correo electronico para envio de Codigo QR</label>
                                            <div class="nk-int-st">
                                                <input type="email" id="email_venta" name="email" value="<?php echo $email; ?>" class="form-control">
                                            </div>
                                        </div>
                                        <br>
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="panel-heading" style="border: 1px solid #ddd">
                                                <label><img src="images/notas.png"> Observaciones</label>
                                                <div class="nk-int-st">
                                                    <textarea class="form-control" id="observacion_venta"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <br><br>
                                        <button type="button" id="btn_finalizar_venta" style="float: right;" class="btn btn-primary"> <img src="images/finalizar_tres.png"> Finalizar venta</button>

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
    <!-- /. ROW  -->
    </div>

    <!-- Modal de firmas Habeas Data -->
    <div class="modal" id="myModalFirma" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" style="width: 90%;">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #214761; color: white">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">
                        <img src="images/examen_venta.png" alt="" /> Aceptacion de las politicas de tratamiento de datos</h4>
                </div>
                <div class="modal-body col-md-12" style="height: 420px; overflow : auto; display: flex; justify-content: center;" id="cuerpo_modal">
                    <!-- Contenedor de firma -->
                    <div class="contenedor">

                        <div class="row">
                            <div class="col-md-12">
                                <canvas id="draw-canvas" width="620" height="360" style="box-shadow: 0px 0px 4px 2px #BBC0C4">
                                    No tienes un buen navegador.
                                </canvas>
                            </div>
                        </div><br>
                        <div>
                            <div style="display: inline-flex; flex-direction: column; margin-left: 25%; width: 50%">
                                <input type="button" class="button" id="draw-submitBtn" value="Guardar Firma"></input>
                                <input type="button" class="button" id="draw-clearBtn" value="Borrar Firma"></input>
                                <label>Color</label>
                                <input type="color" id="color">
                                <br>
                                <label>Tamaño Puntero</label>
                                <input type="range" id="puntero" min="1" default="1" max="5" width="10%">
                            </div>
                        </div>
                        <br />
                        <br />
                        <div class="contenedor">
                            <div class="col-md-12">
                                <img id="draw-image" src="" alt="Tu Imagen aparecera Aqui!" />
                            </div>
                        </div>
                    </div>



                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal" style="font-size: 11pt;"><img src="images/cerrar_dos.png"> Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Anuncio de aceptacion Habeas Data -->
    <div class="modal" id="modalAnuncioHD" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" style="width: 80%;">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #214761; color: white">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">
                        <img src="images/examen_venta.png" alt="" /> Aceptacion de las politicas de tratamiento de datos</h4>
                </div>
                <div class="modal-body col-md-12" style="height: 100px; overflow : auto;" id="cuerpo_modal">
                    <!-- Contenedor de firma -->
                    <div class="contenedor">
                        <section>
                            <h3 style="text-align: center;">Es Necesario aceptar las politicas de tratamiento de datos "Habeas Data", para poder continuar el proceso.</h3>
                        </section>
                    </div>



                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal" style="font-size: 11pt;"><img src="images/cerrar_dos.png"> Cerrar</button>
                </div>
            </div>
        </div>
    </div>



    <!-- PANTALLA MODAL  AGREGAR PRODUCTO -->

    <!-- Modal -->
    <div class="modal" id="myModalResultados" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" style="width: 80%;">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #214761; color: white">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">
                        <img src="images/examen_venta.png" alt="" />
                        Seleccione examen</h4>
                </div>
                <div class="modal-body col-md-12" style="height: auto">
                    <div class="col-md-12">
                        <input type="radio" name="examen_lista" value="1" class="i-checks"> Chequeo

                        <input type="radio" name="examen_lista" value="2" class="i-checks"> Examen
                    </div>
                    <div id="examenes_perfiles" style="display: none">
                        <div class="col-md-6">
                            <label> <img src="images/item.png"> Categoria</label> <br>
                            <select id="examen_categoria_venta" style="width: 100%">
                                <option value=""> Seleccione</option>
                            </select>
                        </div>

                        <div class="col-md-12">
                            <label> <img src="images/item.png"> Examen</label><br>
                            <select id="examen_descripcion_venta" style="width: 100%">
                                <option value=""> Seleccione</option>
                            </select>
                        </div>
                        <div class="col-md-6" id="div_preparacion" style="display: none; padding: 20px;">
                            <label><img src="images/recomendacion.png"> Recomendaciones</label>
                            <div id="preparacion"></div>
                        </div>

                        <div class="col-md-6" id="div_precios"><br>
                            <div id="examen_precios"></div>
                        </div>
                    </div>
                    <div id="examenes_no_perfiles" style="display: none">
                        <div class="col-md-12">
                            <label> <img src="images/item.png"> Examen</label><br>
                            <select id="examen_no_perfil" style="width: 100%">
                                <option value=""> INGRESE UN VALOR PARA BUSCAR EL EXAMEN</option>
                            </select>
                        </div>
                        <div class="col-md-12">
                            <label>Precio $</label><br><input type="text" id="precio_examen_no_perfil" class="form-control" readonly="true">
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" id="btn_agregar_producto" class="btn btn-primary" style="font-size: 11pt;"> <img src="images/anadir_dos.png"> Agregar Examen</button>
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
    <input type="hidden" id="plan_seleccionado" value="NO">
    <!--<input type="hidden" id="bono_seleccionado" value="NO">-->
    <script src="../ajax/firmasAlmacenar.js"></script>
</body>
<?php require_once '../include/footer.php'; ?>

</html>