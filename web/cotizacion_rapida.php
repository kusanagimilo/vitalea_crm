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
<script src="../ajax/firmasAlmacenar.js"></script>
<script src="../ajax/venta.js"></script>
<script src="../web/js/dist/jspdf.min.js"></script>

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
                            <li class="active">Cotización rapida</li>
                        </ol>

                    <?php } else { ?>
                        <ol class="breadcrumb">
                            <li><a href="inicio_administrador.php" title="Volver atras"><img src="images/atras.png"></a></li>
                            <li><a href="inicio_administrador.php" title="Inicio">Inicio</a></li>
                            <li class="active">Cotización rapida</li>
                        </ol>
                    <?php } ?>

                    <div class="row pad-top" style="background-color: white;">

                        <div id="clientes" style="padding: 20px;">

                            <div class="row">

                                <ul class="nav nav-tabs">
                                    <li class="active"><a data-toggle="tab" href="#home">REALIZAR COTIZACIÓN</a></li>
                                    <li><a data-toggle="tab" href="#menu1">VER COTIZACIÓNES REALIZADAS</a></li>
                                </ul>

                                <div class="tab-content">
                                    <div id="home" class="tab-pane fade in active">
                                        <br>
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h3 class="panel-title">
                                                    <img src="images/lista.png" alt="" />
                                                    <b>Realizar cotización</b></h3>
                                            </div>
                                            <div class="panel-body">


                                                <div class="form-horizontal" style="margin-left: 15px;">
                                                    <div class="form-group">
                                                        <label class="control-label col-sm-2" for="txt">*Nombre:</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" class="form-control" name="nombre" id="nombre" placeholder="Ingrese el nombre del cliente (Campo Obligatorio)">
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="control-label col-sm-2" for="txt">*Correo:</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" class="form-control" id="correo" placeholder="Ingrese el correo del cliente (Campo Obligatorio)">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label col-sm-2" for="txt">*Telefono:</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" class="form-control" id="telefono" placeholder="Ingrese el telefono del cliente (Campo Obligatorio)">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label col-sm-2" for="txt">*Direccion:</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" class="form-control" id="direccion" placeholder="Ingrese la direccion del cliente (Campo Obligatorio)">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label col-sm-2" for="txt">Observaciónes</label>
                                                        <div class="col-sm-10">
                                                            <textarea class="form-control" name="observacion" id="observacion" placeholder="Ingrese las observaciones adicionales" row="5"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label col-sm-2" for="txt">Deseas ser contactado por Vitalea?</label>
                                                        <div class="col-sm-10">
                                                            <label>Si</label>
                                                            <input type="radio" value="Si" name="contacto">
                                                            <label>No</label>
                                                            <input type="radio" value="No" name="contacto">
                                                        </div>
                                                    </div>
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


                                                    <div class="panel panel-primary">
                                                        <div class="panel-heading">Adicionar examenes</div>
                                                        <div class="panel-body">
                                                            <!-- se utiliza funcion adicional en facturacion.js -->
                                                            <!-- inicio examenes -->

                                                            <div class="panel-group" id="accordion">

                                                                <div class="panel panel-info">
                                                                    <div class="panel-heading">
                                                                        <h4 class="panel-title">
                                                                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse2">Click aqui para ver perfiles</a>
                                                                        </h4>
                                                                    </div>
                                                                    <div id="collapse2" class="panel-collapse collapse">
                                                                        <div class="panel-body">
                                                                            <div class="form-group">
                                                                                <label class="control-label col-sm-2" for="txt">Categoria :</label>
                                                                                <div class="col-sm-10">
                                                                                    <select id="examen_categoria_venta" class="form-control">
                                                                                        <option value=""> Seleccione</option>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label class="control-label col-sm-2" for="txt">Perfil:</label>
                                                                                <div class="col-sm-10">
                                                                                    <select id="examen_descripcion_venta" class="form-control">
                                                                                        <option value=""> Seleccione</option>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                            <center><input type="button" onclick="CotAddItem('perfil')" class="btn btn-default" name="add_perfil" value="Adicionar perfil"></center>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="panel panel-info">
                                                                    <div class="panel-heading">
                                                                        <h4 class="panel-title">
                                                                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse3">Click aqui para ver examenes</a>
                                                                        </h4>
                                                                    </div>
                                                                    <div id="collapse3" class="panel-collapse collapse">
                                                                        <div class="panel-body">

                                                                            <div class="form-group">
                                                                                <label class="control-label col-sm-2" for="txt">Examen:</label>
                                                                                <div class="col-sm-10">
                                                                                    <select id="examen_no_perfil" style="width: 100%">
                                                                                        <option value=""> INGRESE UN VALOR PARA BUSCAR EL EXAMEN</option>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                            <center><input type="button" onclick="CotAddItem('examen')" class="btn btn-default" name="add_examen" value="Adicionar Examen"></center>

                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- fin examenes -->
                                                            <div id="contenedor_tabla" class="table-responsive">
                                                                <table class="table">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>Código</th>
                                                                            <th>Item</th>
                                                                            <th>Valor</th>
                                                                            <th>Acción</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody id="cuerpo_cotizacion">
                                                                    </tbody>
                                                                    <tfoot>
                                                                        <tr>
                                                                            <th></th>
                                                                            <th></th>
                                                                            <th>Total compra : <label id="total_m"></label><input type="hidden" value="0" id="total"></th>
                                                                            <th></th>
                                                                        </tr>
                                                                    </tfoot>

                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <center><button type="button" onclick="AlmacenarPreCotizacion()" class="btn btn-primary">Enviar al cliente y almacenar cotización</button></center>

                                                </div>


                                            </div>
                                        </div>

                                    </div>
                                    <div id="menu1" class="tab-pane fade">
                                        <br>
                                        <div id="tabla_coti" class="table-responsive">

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


    <div class="modal" id="myValoresRef" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #214761; color: white">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">
                        <img src="images/examen_venta.png" alt="" /> Ver Detalle de la cotización actual</h4>
                </div>
                <div class="modal-body col-md-12" style="height: 400px; overflow : auto;" id="cuerpo_modal">

                    <!-- Tabla contenedor -->

                    <div class="form-group">
                        <label for="inputselect">Estos son los detalles para la cotización seleccionada</label>
                    </div>

                    <div class="form-group" id="contenedorTablaDetalles"></div>
                    <button onclick="generarPdfCotizacion()" >Generar PDF Cotizacion</button>
                    <div id="masInfoGeneral"></div>
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

    <script>
        obtener_categoria_examen();
        $("#examen_categoria_venta").change(function() {
            obtener_examen();
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

        function generarPdfCotizacion() {
            var hola = "Texto de ensayo adicional"
            
            var doc = new jsPDF();
            doc.text(20, 20, "This PDF has a title"+ hola +" subject, author, keywords and a creator.");
            // Optional - set properties on the document
            doc.setProperties({
                title: 'Cotizaciones Vitalea',
                subject: 'Documento de Cotizaciones vitalea',
                author: 'Arcos Soluciones Tecnologicas',
                keywords: 'generated, javascript, web 2.0, ajax',
                creator: 'Alexander Pineda - Desarrollador'
            });
            // Output as Data URI
            doc.save('detallePDFCotizacion.pdf');
        }


        VerPrecotizaciones();
        verDetalleCotizacion();
    </script>


    <!-- End Contact Info area-->
    <?php require_once '../include/footer.php'; ?>

</body>

</html>