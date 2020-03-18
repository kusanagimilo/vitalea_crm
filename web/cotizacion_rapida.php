<?PHP
require_once '../include/script.php';
require_once '../include/header_administrador.php';
$array_permisos = explode(",", $_SESSION['PERMISOS']);
?>
<style>
    .nombreChequeo {
        width: 20%;
        font-size: 11px;
        text-align: center;
    }

    .nombreChequeo:hover {
        text-decoration: underline;
        cursor: pointer;
        color: #214761;
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
<!-- <script src="../ajax/firmasAlmacenar.js"></script> -->
<script src="../ajax/venta.js"></script>
<script src="../web/js/dist/jspdf.min.js"></script>
<script src="../ajax/Facturacion.js" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<script src="https://unpkg.com/@popperjs/core@2"></script>

<body style="background-color: #F6F8FA">
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

    <!-- Modal de firmas Habeas Data
    <div class="modal" id="myModalFirma" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #214761; color: white">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">
                        <img src="images/examen_venta.png" alt="" /> Aceptacion de las politicas de tratamiento de datos</h4>
                </div>
                <div class="modal-body col-md-12" style="height: 420px; overflow : auto; display: flex; justify-content: center;" id="cuerpo_modal">
                    <!-- Contenedor de firma -->
    <!-- <div class="contenedor">

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
                    </div> -->



    <!-- </div>
    <div class="modal-footer">
        <button type="button" id="closeModal" class="btn btn-default" data-dismiss="modal" style="font-size: 11pt;"><img src="images/cerrar_dos.png"> Cerrar</button>
    </div>
    </div>
    </div>
    </div> --> -->


    <div class="modal" id="myValoresRef" role="dialog" aria-labelledby="myModalLabel" style="width: 100%; margin-top: -10px">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #214761; color: white">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">
                        <img src="images/examen_venta.png" alt="" /> Ver Detalle Cotizaciones</h4>
                </div>
                <div class="modal-body col-md-12" style="height: 400px; overflow : auto;" id="cuerpo_modal">

                    <!-- Tabla contenedor -->

                    <div>
                        <table class="table">
                            <caption>Este es el detalle completo patra esta cotización.</caption>
                            <thead id="headerChequeos" style="visibility: hidden">
                                <tr>
                                    <th scope="col">Codigo</th>
                                    <th scope="col">Nombre Chequeo</th>
                                    <th scope="col">Precio</th>
                                    <th scope="col">Ver Detalle</th>
                                </tr>
                            </thead>
                            <tbody id="bodyTableModalChequeos"></tbody>
                        </table>
                        <table class="table">
                            <thead id="headerExamenes" style="visibility: hidden">
                                <tr>
                                    <th scope="col">Codigo</th>
                                    <th scope="col">Nombre Examen</th>
                                    <th scope="col">Precio</th>
                                </tr>
                            </thead>
                            <tbody id="bodyTableModalExamenes"></tbody>
                        </table>
                    </div>
                    <br><button onclick="generarPdfCotizacion()" class="btn btn-danger btn-lg"><i class="fas fa-file-pdf"></i> Generar PDF Cotizacion</button>
                </div>
                <div class="modal-footer">
                    <button type="button" id="cerrarModal" class="btn btn-default" data-dismiss="modal" style="font-size: 11pt;"><img src="images/cerrar_dos.png"> Cerrar</button>
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
        (function borrarTemp() {
            const closeModal = document.getElementById("closeModal");
        }());

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

        function generarPdfCotizacion(chequeos, examenes) {
            //Funcion para la creacion del PDF, utilizando la libreria JSPDF.
            var imgData = new Image();
            imgData.src = "../images/vitaleaPdf.jpg";
            var nombreCliente = sessionStorage.getItem('nameClient');
            var nombreAsesor = sessionStorage.getItem('nameUser');
            var precioCot = sessionStorage.getItem('priceCot');
            let todaLaCotizacion = JSON.parse(sessionStorage.getItem('todaLaCotizacion'));
            let idChequeo = todaLaCotizacion[0][0].id;

            var doc = new jsPDF();
            doc.addImage(imgData, 'JPG', 25, 1, 162, 110);


            doc.setFontSize(12);
            doc.setFont("helvetica");
            doc.setTextColor(117, 117, 117);
            doc.text(35, 116, nombreCliente);
            doc.text(115, 116, nombreAsesor);

            doc.setDrawColor(255, 255, 255)
            doc.setLineWidth(1.5)
            doc.line(25, 111, 187, 111);


            doc.setProperties({
                // Metadatos del documento
                title: 'Cotizaciones Vitalea',
                subject: 'Documento de Cotizaciones vitalea',
                author: 'Arcos Soluciones Tecnologicas',
                keywords: 'generated, javascript, web 2.0, ajax',
                creator: 'Alexander Pineda - Desarrollador'
            });

            function consultarChequeos(idChequeo, margen) {
                $.ajax({
                    type: "POST",
                    url: "../controladores/FacturacionController.php",
                    async: false,
                    dataType: 'json',
                    data: {
                        tipo: 18,
                        respuestaId: idChequeo
                    },
                    success: function(retorno) {
                        let listaExamenes = "";
                        retorno.forEach(element => {
                            listaExamenes += "- " + element.codigo + " " + element.nombre + "\n";
                        });
                        doc.setFontSize(8);
                        doc.text(45, margen, listaExamenes);
                    }
                });
            }

            function todosLosExamenesPdf() {
                var index = 0;
                var marginPdf = 0;
                for (let i = 0; i < 8; i++) {
                    if (todaLaCotizacion[i]) {
                        if (todaLaCotizacion[index][0].nombre.substring(0, 7) == "CHEQUEO") {
                            if (todaLaCotizacion[i] == todaLaCotizacion[0]) {
                                var marginCchequeos = 77;
                            } else {
                                var marginCchequeos = 31;
                            }
                            doc.setDrawColor(186, 186, 186)
                            doc.setLineWidth(0.1)
                            doc.line(40, 123 + marginPdf, 175, 123 + marginPdf);
                            doc.setFontSize(10.5);
                            doc.text(40, 127 + marginPdf, todaLaCotizacion[index][0].nombre);
                            doc.text(160, 127 + marginPdf, "$" + formatNumber(todaLaCotizacion[index][0].precio));
                            let idChequeo = todaLaCotizacion[index][0].id;
                            consultarChequeos(idChequeo, 131 + marginPdf);
                            marginPdf = marginPdf + marginCchequeos;
                            index++;

                        } else {
                            doc.setDrawColor(186, 186, 186)
                            doc.setLineWidth(0.1)
                            doc.line(40, 123 + marginPdf, 175, 123 + marginPdf);
                            doc.setFontSize(10.5);
                            doc.text(40, 128 + marginPdf, todaLaCotizacion[index][0].nombre);
                            doc.text(160, 128 + marginPdf, "$" + formatNumber(todaLaCotizacion[index][0].precio));
                            marginPdf = marginPdf + 8;
                            index++;
                            if (todaLaCotizacion[i] == todaLaCotizacion[7] && marginPdf < 85) {
                                marginPdf = 86;
                            }
                        }
                    }
                }

                function pagina2() {
                    let index = 8;
                    marginPdf = 20;
                    doc.setTextColor(117, 117, 117);
                    doc.setFontStyle("normal");
                    for (let i = 8; i < todaLaCotizacion.length; i++) {
                        if (todaLaCotizacion[i]) {
                            if (todaLaCotizacion[index][0].nombre.substring(0, 7) == "CHEQUEO") {
                                doc.setDrawColor(186, 186, 186)
                                doc.setLineWidth(0.1)
                                doc.line(40, 5 + marginPdf, 175, 5 + marginPdf);
                                doc.setFontSize(10.5);
                                doc.text(40, 10 + marginPdf, todaLaCotizacion[index][0].nombre);
                                doc.text(160, 10 + marginPdf, "$" + formatNumber(todaLaCotizacion[index][0].precio));
                                let idChequeo = todaLaCotizacion[index][0].id;
                                consultarChequeos(idChequeo, 14 + marginPdf);
                                marginPdf = marginPdf + 36;
                                index++;
                            } else {
                                doc.setDrawColor(186, 186, 186)
                                doc.setLineWidth(0.1)
                                doc.line(40, 5 + marginPdf, 175, 5 + marginPdf);
                                doc.setFontSize(10.5);
                                doc.text(40, 10 + marginPdf, todaLaCotizacion[index][0].nombre);
                                doc.text(160, 10 + marginPdf, "$" + formatNumber(todaLaCotizacion[index][0].precio));
                                marginPdf = marginPdf + 10;
                                index++;
                            }
                        }
                    }
                }
                console.log(marginPdf)
                if (marginPdf > 85) {
                    doc.addPage();
                    doc.setFontStyle("bold");
                    doc.setFontSize(14);
                    doc.setTextColor(0, 0, 0);
                    doc.setDrawColor(186, 186, 186);
                    doc.setLineWidth(0.7);
                    doc.line(35, 253, 182, 253);
                    doc.text(40, 250, "Total");
                    doc.setTextColor(235, 31, 129);
                    doc.text(160, 250, '$' + precioCot);
                    pagina2();


                } else {
                    doc.setDrawColor(186, 186, 186)
                    doc.setLineWidth(0.7)
                    doc.line(35, 253, 180, 253);

                    doc.setFontStyle("bold");
                    doc.setFontSize(14);
                    doc.setTextColor(0, 0, 0);
                    doc.text(40, 250, "Total");
                    doc.setTextColor(235, 31, 129);
                    doc.text(160, 250, '$' + precioCot);
                }


            }

            todosLosExamenesPdf();
            // Funcion Generadora del PDF
            doc.save('detallePDFCotizacion.pdf');

        }

        VerPrecotizaciones();
    </script>
    <!-- End Contact Info area-->
    <?php require_once '../include/footer.php'; ?>

</body>

</html>