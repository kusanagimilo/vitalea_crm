function VerListaFacturacion() {

    var n_documento = $.trim($("#n_documento").val());
    var medio_pago = $.trim($("#medio_pago").val());
    var estado = $.trim($("#estado_ven").val());


    if (n_documento == "" && medio_pago == "" && estado == "") {
        alert("Seleccione un filtro");
    } else {
        $("#lista_ventas_cot_body").html("");

        var tabla = '<table id="lista_ventas_cot" class="table table-bordered">' +
                '<thead>' +
                '<tr style="background-color: #214761;">' +
                '<th style="color:white">Tipo de Documento</th>' +
                '<th style="color:white">No. Documento</th>' +
                '<th style="color:white">Nombre Completo paciente</th>' +
                '<th style="color:white">Medio de pago</th>' +
                '<th style="color:white">Código</th>' +
                '<th style="color:white">Factura Athenea</th>' +
                '<th style="color:white">Fecha creacion</th>' +
                '<th style="color:white">Fecha pagó</th>' +
                '<th style="color:white">Estado</th>' +
                '<th style="color:white">Valor total servicios</th>' +
                '<th style="color:white">Acciónes</th>' +
                '</tr>' +
                '</thead>' +
                '<tbody id="lista_ventas_cot_body">' +
                '</tbody>' +
                '</table>';

        $("#tabla_factur").html(tabla);

        var data;
        $.ajax({
            type: "POST",
            url: "../controladores/FacturacionController.php",
            async: false,
            dataType: 'json',
            data: {
                tipo: 1,
                n_documento: n_documento,
                medio_pago: medio_pago,
                estado: estado

            },
            success: function (retu) {
                $.each(retu, function (i, ventas) {

                    var estado = "";
                    var botones = "";
                    var turno = "";
                    var boton_turno = "";
                    if (ventas.estado == 1) {
                        estado = "Por pagar";
                        botones = '<input type="button" onclick="CambiarEstadoVenta(2,' + ventas.id_venta + ')" value="Confirmar pago" class="btn btn-sm btn-success" />' +
                                '<input type="button" onclick="CambiarEstadoVenta(3,' + ventas.id_venta + ')" value="Cancelar pago" class="btn btn-sm btn-danger" />';
                    } else if (ventas.estado == 2) {

                        if (ventas.turno_facturacion == "permite_turno") {
                            var tipo_turno = '"TOMA_MUESTRA"';
                            //SolicitarTurnoFacturacion(tipo_turno, id_cliente, id_venta)
                            boton_turno = "<input type='button' onclick='SolicitarTurnoFacturacion(" + tipo_turno + ", " + ventas.id_cliente + ", " + ventas.id_venta + ")' value='Enviar TM' class='btn btn-sm btn-success'> ";
                        }

                        estado = "Pagado";
                        if (ventas.medio_pago == "Presencial con Tarjeta de Credito") {
                            botones = '<input type="button" data-toggle="modal" data-target="#myModalResultados" onclick="VerDetalleFacturacion(' + ventas.id_venta + ')" value="Ver detalle" class="btn btn-sm btn-primary">' +
                                    '<input type="button" data-toggle="modal" data-target="#myNoFactura" onclick="NoFactura(' + ventas.id_venta + ')" value="Ingresar NºFactura" class="btn btn-sm btn-warning">' + boton_turno;
                        } else {
                            botones = '<input type="button" data-toggle="modal" data-target="#myModalResultados" onclick="VerDetalleFacturacion(' + ventas.id_venta + ')" value="Ver detalle" class="btn btn-sm btn-primary">' + boton_turno;

                        }
                        //myNoFactura
                    } else if (ventas.estado == 3) {
                        estado = "Cancelado";
                        botones = '<input type="button" data-toggle="modal" data-target="#myModalResultados" onclick="VerDetalleFacturacion(' + ventas.id_venta + ')" value="Ver detalle" class="btn btn-sm btn-primary">';
                    }

                    var fecha_pago;
                    if (ventas.fecha_pago == null || ventas.fecha_pago == "") {
                        fecha_pago = "Sin pago";
                    } else {
                        fecha_pago = ventas.fecha_pago;
                    }

                    //var btn_prueba = "<input value='pdf_prueba' type='button' class='btn btn-sm btn-danger' onclick='pfdprueba(" + ventas.id_venta + ")'>";

                    var newRow = "<tr>";
                    newRow += "<td id='ftipodoc_" + ventas.id_venta + "'>" + ventas.tipo_doc + "</td>";
                    newRow += "<td id='fdocu_" + ventas.id_venta + "'>" + ventas.documento + "</td>";
                    newRow += "<td id='fclien_" + ventas.id_venta + "'>" + ventas.cliente + "</td>";
                    newRow += "<td id='fmediop_" + ventas.id_venta + "'>" + ventas.medio_pago + "</td>";
                    newRow += "<td id='fcodigo_" + ventas.id_venta + "'>" + ventas.codigo_venta + "</td>";
                    newRow += "<td id='fcodigoa_" + ventas.id_venta + "'>" + ventas.numero_factura + "</td>";
                    newRow += "<td id='ffechac_" + ventas.id_venta + "'>" + ventas.fecha_creacion + "</td>";
                    newRow += "<td id='ffechap_" + ventas.id_venta + "'>" + fecha_pago + "</td>";
                    newRow += "<td id='festado_" + ventas.id_venta + "'>" + estado + "</td>";
                    newRow += "<td id='ftotal_" + ventas.id_venta + "'>" + ventas.total_venta + "</td>";
                    newRow += "<td id='fbtn_" + ventas.id_venta + "'>" + botones + " </td>";
                    newRow += "</tr>";

                    $(newRow).appendTo("#lista_ventas_cot_body");
                });
            }
        });



        var tabla = $('#lista_ventas_cot').DataTable({
            responsive: true
        });
    }

}

function CambiarEstadoVenta(estado, id) {

    var confirma = confirm("¿Esta seguro de realizar esta acción?");

    if (confirma) {

        var retorno;
        $.ajax({
            type: 'POST',
            url: "../controladores/FacturacionController.php",
            beforeSend: function () {
                $('#ModalCargando').modal({backdrop: 'static', keyboard: false});
            },
            data: {
                tipo: 2,
                estado: estado,
                id: id
            },
            success: function (retu) {

                $('#ModalCargando').modal('toggle');

                if (retu == 1) {
                    alertify.alert("Se realizo la acción correctamente", function () {
                        Cambiartd(id);
                    });
                } else if (retu == 2) {
                    alertify.alert("no se logro realizar la acción");
                }
            }
        });

    }

}

function Cambiartd(idventa) {

    $.ajax({
        type: "POST",
        url: "../controladores/FacturacionController.php",
        async: false,
        dataType: 'json',
        data: {
            tipo: 3,
            id: idventa
        },
        success: function (retu) {
            $.each(retu, function (i, ventas) {

                var estado = "";
                var botones = "";
                var boton_turno = "";
                if (ventas.estado == 1) {
                    estado = "Por pagar";
                    botones = '<input type="button" onclick="CambiarEstadoVenta(2,' + ventas.id_venta + ')" value="Confirmar pago" class="btn btn-sm btn-success" />' +
                            '<input type="button" onclick="CambiarEstadoVenta(3,' + ventas.id_venta + ')" value="Cancelar pago" class="btn btn-sm btn-danger" />';
                } else if (ventas.estado == 2) {
                    estado = "Pagado";
                    if (ventas.turno_facturacion == "permite_turno") {
                        var tipo_turno = '"TOMA_MUESTRA"';
                        //SolicitarTurnoFacturacion(tipo_turno, id_cliente, id_venta)
                        boton_turno = "<input type='button' onclick='SolicitarTurnoFacturacion(" + tipo_turno + ", " + ventas.id_cliente + ", " + ventas.id_venta + ")' value='Enviar TM' class='btn btn-sm btn-success'> ";
                    }

                    estado = "Pagado";
                    if (ventas.medio_pago == "Presencial con Tarjeta de Credito") {
                        botones = '<input type="button" data-toggle="modal" data-target="#myModalResultados" onclick="VerDetalleFacturacion(' + ventas.id_venta + ')" value="Ver detalle" class="btn btn-sm btn-primary">' +
                                '<input type="button" data-toggle="modal" data-target="#myNoFactura" onclick="NoFactura(' + ventas.id_venta + ')" value="Ingresar NºFactura" class="btn btn-sm btn-warning">' + boton_turno;
                    } else {
                        botones = '<input type="button" data-toggle="modal" data-target="#myModalResultados" onclick="VerDetalleFacturacion(' + ventas.id_venta + ')" value="Ver detalle" class="btn btn-sm btn-primary">' + boton_turno;

                    }
                } else if (ventas.estado == 3) {
                    estado = "Cancelado";
                    botones = '<input type="button" value="Ver detalle" onclick="VerDetalleFacturacion(' + ventas.id_venta + ')" class="btn btn-sm btn-primary">';
                }

                var fecha_pago;
                if (ventas.fecha_pago == null || ventas.fecha_pago == "") {
                    fecha_pago = "Sin pago";
                } else {
                    fecha_pago = ventas.fecha_pago;
                }

                $("#ftipodoc_" + idventa + "").html(ventas.tipo_doc);
                $("#fdocu_" + idventa + "").html(ventas.documento);
                $("#fclien_" + idventa + "").html(ventas.cliente);
                $("#fmediop_" + idventa + "").html(ventas.medio_pago);
                $("#fcodigo_" + idventa + "").html(ventas.codigo_venta);
                $("#fcodigoa_" + idventa + "").html(ventas.numero_factura);
                $("#ffechac_" + idventa + "").html(ventas.fecha_creacion);
                $("#ffechap_" + idventa + "").html(fecha_pago);
                $("#festado_" + idventa + "").html(estado);
                $("#ftotal_" + idventa + "").html(ventas.total_venta);
                $("#fbtn_" + idventa + "").html(botones);

            });
        }
    });

}

function pfdprueba(id_venta) {

    window.open("../web/pdf/documentos/ticket.php?venta=" + id_venta + "", "ticket");


}

function VerDetalleFacturacion(id_venta) {
    $("#cuerpo_modal").html("");
    var retorno;
    $.ajax({
        type: 'POST',
        url: "../controladores/FacturacionController.php",
        async: false,
        dataType: 'json',
        data: {
            tipo: 4,
            id: id_venta
        },
        success: function (retu) {

            retorno = retu;
        }
    });


    var info_factura = retorno.informacion_factura;


    var html = '<table class="table table-striped">' +
            '<thead>' +
            '<tr>' +
            '<th scope="col" colpsan="2">Informacion general de la venta</th>' +
            '</tr>' +
            '</thead>' +
            '<tbody>' +
            '<tr><td>Tipo de documento</td><td>' + info_factura.tipo_doc + '</td></tr>' +
            '<tr><td># Documento</td><td>' + info_factura.documento + '</td></tr>' +
            '<tr><td>Nombre paciente</td><td>' + info_factura.cliente + '</td></tr>' +
            '<tr><td>Fecha generacion solicitud</td><td>' + info_factura.fecha_creacion + '</td></tr>' +
            '<tr><td>Medio de pago</td><td>' + info_factura.medio_pago + '</td></tr>' +
            '<tr><td>Fecha de pago</td><td>' + info_factura.fecha_pago + '</td></tr>' +
            '<tr><td>Valor total servicios</td><td>' + info_factura.total_venta + '</td></tr>' +
            '<tr><td>Observaciones</td><td>' + info_factura.observacion + '</td></tr>' +
            '</tbody>' +
            '</table>' +
            '<table class="table table-striped">' +
            '<thead>' +
            '<tr>' +
            '<th scope="col" colpsan="3">Examenes</th>' +
            '</tr>' +
            '<tr>' +
            '<th scope="col">Examen</th>' +
            '<th scope="col">Descuento</th>' +
            '<th scope="col">Valor</th>' +
            '</tr>' +
            '</thead><tbody>';
    $.each(retorno.items, function (i, items) {
        html += '<tr>' +
                '<td>' + items.nombre_examen + '</td>' +
                '<td>' + items.descuento + '</td>' +
                '<td>' + items.valor + '</td>' +
                '</tr>';
    });

    html += '</tbody></table>';


    $("#cuerpo_modal").html(html);

}

function NoFactura(id_venta) {

    var retorno;
    $.ajax({
        type: 'POST',
        url: "../controladores/FacturacionController.php",
        async: false,
        data: {
            tipo: 5,
            id_venta: id_venta
        },
        success: function (retu) {
            retorno = retu;
        }
    });

    var html = '<div class="panel panel-default">' +
            '<div class="panel-heading">' +
            '<h3 class="panel-title">' +
            '<img src="images/lista.png" alt=""/>' +
            '<b>Modificar Numero factura</b></h3>' +
            '</div>' +
            '<div class="panel-body">' +
            '<div class="row">' +
            '<div class="col-md-12" style="color:red; margin; margin-bottom: 5px;">' +
            'Numero de actual factura actual: ' + retorno + '' +
            '</div>' +
            '<div class="col-md-6">' +
            '<input id="no_factura" name="no_factura" placeholder="Ingrese el numero de la factura" name="" type="text" class="form-control">' +
            '</div>' +
            '<div class="col-md-6">' +
            '<input type="button" onclick="ModificarNoFacturacion(' + id_venta + ')" value="Modificar NºFactura" class="btn btn-primary">' +
            '</div>' +
            '</div>' +
            '</div>' +
            '</div>';

    $("#cuerpo_modal_factura").html(html);

}

function ModificarNoFacturacion(id_venta) {

    var confirma = confirm("¿Esta seguro de realizar esta acción?");

    if (confirma) {

        var numero_factura = $.trim($("#no_factura").val());

        if (numero_factura == "") {
            alert("Ingrese un valor");
        } else {

            var retorno;
            $.ajax({
                type: 'POST',
                url: "../controladores/FacturacionController.php",
                async: false,
                data: {
                    tipo: 6,
                    id_venta: id_venta,
                    no_factura: numero_factura

                },
                success: function (retu) {
                    retorno = retu;
                }
            });

            if (retorno == 1) {
                NoFactura(id_venta)
            } else {
                alert("Error al tratar de modificar la factura");
            }
        }

    }
}

function SolicitarTurnoFacturacion(tipo_turno, id_cliente, id_venta) {

    var confirma = confirm("¿Esta seguro de realizar esta acción?");

    if (confirma) {

        var retorno;
        $.ajax({
            type: 'POST',
            url: "../controladores/DgTurnoController.php",
            async: false,
            dataType: 'json',
            data: {
                tipo: 1,
                tipo_turno: tipo_turno,
                id_cliente: id_cliente,
                id_venta: id_venta
            },
            success: function (retu) {
                if (retu.retorno == 1) {
                    alertify.alert("Su turno es : " + retu.turno, function () {
                        Cambiartd(id_venta);
                    });
                } else if (retu.retorno == 2) {
                    alertify.alert("no se logro realizar la acción");
                }
            }
        });

    }
}

/*function EstadoTurnoFacturacion(id_venta) {
 var retorno;
 $.ajax({
 type: 'POST',
 url: "../controladores/FacturacionController.php",
 async: false,
 data: {
 tipo: 7,
 id_venta: id_venta
 },
 success: function (retu) {
 retorno = retu;
 }
 });
 
 return retorno;
 }*/
function ListaArqueo() {
    $("#lista_arqueo_cot_body").html("");

    var tabla = '<center><input type="button" onclick="DescargarArqueo()" value="Descargar pdf arqueo" class="btn btn-danger"> <input type="button" onclick="descargarExcelArqueo()" value="Descargar Excel" class="btn btn-success"></center><table id="lista_arqueo_cot" class="table table-bordered">' +
            '<thead>' +
            '<tr style="background-color: #214761;">' +
            '<th style="color:white">Fecha venta</th>' +
            '<th style="color:white">Factura</th>' +
            '<th style="color:white">Medio pago</th>' +
            '<th style="color:white">Asesor</th>' +
            '<th style="color:white">Documento asesor</th>' +
            '<th style="color:white">Paciente</th>' +
            '<th style="color:white">Documento paciente</th>' +
            '<th style="color:white">Total venta</th>' +
            '</tr>' +
            '</thead>' +
            '<tbody id="lista_arqueo_cot_body">' +
            '</tbody>' +
            '</table>';

    $("#tabla_arqueo").html(tabla);

    var data;
    $.ajax({
        type: "POST",
        url: "../controladores/FacturacionController.php",
        async: false,
        dataType: 'json',
        data: {
            tipo: 8,
            asesor: $("#asesor").val(),
            fecha_inicial: $("#datetimepicker6").val(),
            fecha_final: $("#datetimepicker7").val()

        },
        success: function (retu) {
            $.each(retu, function (i, ventas) {


                var newRow = "<tr>";
                newRow += "<td>" + ventas.fecha_pago + "</td>";
                newRow += "<td>" + ventas.numero_factura + "</td>";
                newRow += "<td>" + ventas.medio_pago + "</td>";
                newRow += "<td>" + ventas.nombre_atendio + "</td>";
                newRow += "<td>" + ventas.documento_atendio + "</td>";
                newRow += "<td>" + ventas.paciente + "</td>";
                newRow += "<td>" + ventas.documento_paciente + "</td>";
                newRow += "<td>" + formatNumber(parseInt(ventas.valor_total)) + "</td>";
                newRow += "</tr>";

                $(newRow).appendTo("#lista_arqueo_cot_body");
            });
        }
    });



    var tabla = $('#lista_arqueo_cot').DataTable({
        responsive: true
    });
}

function descargarExcelArqueo() {
    var asesor = $("#asesor").val();
    var fecha_inicial = $("#datetimepicker6").val();
    var fecha_final = $("#datetimepicker7").val();
    window.open("../PHPExcel/Arqueo.php?asesor=" + asesor + "&fecha_inicial=" + fecha_inicial + "&fecha_final=" + fecha_final + "");
}

function DescargarArqueo() {

    var asesor = $("#asesor").val();
    var fecha_inicial = $("#datetimepicker6").val();
    var fecha_final = $("#datetimepicker7").val();
    window.open("../controlador/arqueo.php?asesor=" + asesor + "&fecha_inicial=" + fecha_inicial + "&fecha_final=" + fecha_final + "", "ARQUEO", "width=500, height=500")
}

function AsesoresConVentas() {
    $.ajax({
        type: "POST",
        url: "../controladores/FacturacionController.php",
        async: false,
        dataType: 'json',
        data: {
            tipo: 9
        },
        success: function (retu) {
            $.each(retu, function (i, asesor) {
                $("#asesor").append("<option value='" + asesor.usuario_id + "'>" + asesor.nombre_completo + "</option>")
            });
        }
    });
}


function CotAddItem(tipo_item) {

    var id = "";

    if (tipo_item == 'perfil') {
        id = $("#examen_descripcion_venta").val();
    } else if (tipo_item == 'examen') {
        id = $("#examen_no_perfil").val();
    }

    if (id == "") {
        alert("Seleccione un perfil");
    } else {

        var envio;

        if (tipo_item == 'perfil') {
            envio = {
                tipo: 10,
                id: id
            };
        } else if (tipo_item == 'examen') {
            envio = {
                tipo: 11,
                id: id
            };
        }


        var datos;
        $.ajax({
            type: "POST",
            url: "../controladores/FacturacionController.php",
            async: false,
            dataType: 'json',
            data: envio,
            success: function (retu) {
                datos = retu[0];
            }
        });

        var existe;
        var codigo;
        var td_id;
        if (tipo_item == 'perfil') {
            existe = $("#pe_" + datos.id + "").length;
            codigo = datos.codigo_crm;
            td_id = "pe_" + datos.id;
        } else if (tipo_item == 'examen') {
            existe = $("#ex_" + datos.id + "").length;
            codigo = datos.codigo;
            td_id = "ex_" + datos.id;
        }

        if (existe) {
            alert("ya adiciono este item");
        } else {

            var numero = formatNumber(parseInt(datos.precio));
            var td_on = '"' + td_id + '"';
            var html = "<tr id='" + td_id + "'>" +
                    "<td>" + codigo + "<input type='hidden' value='" + datos.id + "' name='item_id[]' id='item_id[]' />" +
                    "<input type='hidden' value='" + tipo_item + "' name='tipo_item[]' id='tipo_item[]' ></td>" +
                    "<td>" + datos.nombre + "</td>" +
                    "<td>" + numero + "</td>" +
                    "<td><input type='button' onclick='ElimItem(" + td_on + "," + datos.precio + ")' class='btn btn-danger' value='Eliminar item'></td>" +
                    "</tr>";

            $("#cuerpo_cotizacion").append(html);


            var valor_actual = parseInt($("#total").val());
            var precio = 0;
            if (datos.precio != "" || datos.precio != 0) {
                precio = parseInt(datos.precio);
            }

            var valor_total = valor_actual + precio;

            $("#total_m").html(formatNumber(valor_total));
            $("#total").val(valor_total);

        }



    }

}


function ElimItem(td_item, precio_item) {
    $("#" + td_item + "").remove();
    var valor_actual = parseInt($("#total").val());
    var valor_restado = valor_actual - precio_item;
    $("#total_m").html(valor_restado);
    $("#total").val(valor_restado);
}

function AlmacenarPreCotizacion() {

    var confirma = confirm("Esta seguro de realizar esta accion");

    if (confirma) {

        var items = [];
        $('input[name^="item_id"]').each(function () {
            items.push($(this).val());
        });
        var tipo_items = [];
        $('input[name^="tipo_item"]').each(function () {
            tipo_items.push($(this).val());
        });

        var nombre = $("#nombre").val();
        var correo = $("#correo").val();
        var telefono = $("#telefono").val();
        var direccion = $("#direccion").val();
        var observaciones = $("#observacion").val();
        var radio = $('input:radio[name=contacto]:checked').val();
        /*En la variable imagenBase64 Realizamos la lectura de la codificacion de la firma, almacenada via SessionStorage desde el documento ../ajax/firmasAlmacenar.js*/
        let imagenBase64 = sessionStorage.getItem('imagenCadena');
        /*---------------------------------------------------------------------------------------------------------------------*/


        if (nombre == "" || correo == "" || telefono == "" || $("#cuerpo_cotizacion").length == 0 || radio == null) {
            alertify.alert("Todos los campos son obligatorios");
        } else {
            //nombre_cliente,:correo,:telefono,:valor,:descuento,:id_usr_creo
            var datos;
            var valor = $("#total").val();
            $.ajax({
                type: "POST",
                url: "../controladores/FacturacionController.php",
                beforeSend: function () {
                    $('#ModalCargando').modal({backdrop: 'static', keyboard: false});
                },
                dataType: 'json',
                data: {
                    tipo: 12,
                    nombre_cliente: nombre,
                    correo: correo,
                    telefono: telefono,
                    valor: valor,
                    items: items,
                    tipo_items: tipo_items,
                    direccion: direccion,
                    observacion: observaciones,
                    contactado: radio,
                    imagenBase64: imagenBase64
                },
                success: function (retu) {

                    $('#ModalCargando').modal('toggle');

                    if (retu == 1) {
                        alertify.alert("Se realizo la acción correctamente", function () {
                            location.reload();
                        });

                    } else {
                        alertify.alert("Ocurrio un eror al tratar de almacenar la cotización");
                    }
                }
            });
        }
    }


}


function VerPrecotizaciones() {

    $("#lista_precot_cot_body").html("");

    var tabla = '<table id="lista_precot_cot" class="table table-bordered">' +
            '<thead>' +
            '<tr style="background-color: #214761;">' +
            '<th style="color:white">#Cotización</th>' +
            '<th style="color:white">Nombre cliente</th>' +
            '<th style="color:white">Correo</th>' +
            '<th style="color:white">Telefono</th>' +
            '<th style="color:white">Direccion</th>' +
            '<th style="color:white">Asesor(a)</th>' +
            '<th style="color:white">Fecha cotización</th>' +
            '<th style="color:white">Valor</th>' +
            '<th style="color:white">Ver detalle</th>' +
            '</tr>' +
            '</thead>' +
            '<tbody id="lista_precot_cot_body">' +
            '</tbody>' +
            '</table>';

    $("#tabla_coti").html(tabla);

    var data;
    $.ajax({
        type: "POST",
        url: "../controladores/FacturacionController.php",
        async: false,
        dataType: 'json',
        data: {
            tipo: 13

        },
        success: function (retu) {

            $.each(retu, function (i, precot) {


                var newRow = "<tr>";
                newRow += "<td name='idPrecotizaciones'>" + precot.id_precotizacion + "</td>";
                newRow += "<td>" + precot.nombre_cliente + "</td>";
                newRow += "<td>" + precot.correo + "</td>";
                newRow += "<td>" + precot.telefono + "</td>";
                newRow += "<td>" + precot.direccion + "</td>";
                newRow += "<td>" + precot.nombre_completo + "</td>";
                newRow += "<td>" + precot.fecha_creacion + "</td>";
                newRow += "<td>" + formatNumber(parseInt(precot.valor)) + "</td>";
                newRow += "<td><button class='btn btn-success botonVerDetalle' data-toggle='modal' data-target='#myValoresRef'>" + 'Ver detalle' + "</button></td>";
                newRow += "</tr>";

                $(newRow).appendTo("#lista_precot_cot_body");
            });

        }
    });

    var tabla = $('#lista_precot_cot').DataTable({
        responsive: true
    });

}

function verDetalleCotizacion() {
    agregarDatosTabla();

    function agregarDatosTabla() {
        const boton = document.querySelectorAll('.botonVerDetalle');
        for (const i of boton) {
            i.addEventListener("click", (e) => {
                $("#listaResultadosVerDetalle").html("");
                var tabla = '<table id="listaDetallesVer" class="table table-bordered">' +
                        '<thead>' +
                        '<tr style="background-color: #214761;">' +
                        '<th style="color:white">#Cotización</th>' +
                        '<th style="color:white">valor</th>' +
                        '<th style="color:white">Codigo Examen</th>' +
                        '<th style="color:white">Item</th>' +
                        '</tr>' +
                        '</thead>' +
                        '<tbody id="listaResultadosVerDetalle">' +
                        '</tbody>' +
                        '</table>';

                $("#contenedorTablaDetalles").html(tabla);

                var data;
                $.ajax({
                    type: "POST",
                    url: "../controladores/FacturacionController.php",
                    async: true,
                    dataType: 'json',
                    data: {
                        tipo: 14

                    },
                    success: function (retu) {
                        $.each(retu, function (i, precot) {


                            var newRow = "<tr>";
                            newRow += "<td name='idCotizacion'>" + precot.id_precotizacion + "</td>";
                            newRow += "<td>" + precot.valor + "</td>";
                            newRow += "<td>" + precot.codigo + "</td>";
                            newRow += "<td>" + precot.nombre + "</td>";
                            newRow += "</tr>";

                            $(newRow).appendTo("#listaResultadosVerDetalle");
                        });

                        var tabla = $('#listaDetallesVer').DataTable({
                            responsive: true
                        });
                    }
                });

            })
        }
    }

    const paginacion = document.querySelector('.paginate_button').parentNode;
    paginacion.addEventListener("mouseover", () => {
        agregarDatosTabla();
    });

}

function formatNumber(num) {
    if (!num || num == 'NaN')
        return '-';
    if (num == 'Infinity')
        return '&#x221e;';
    num = num.toString().replace(/\$|\,/g, '');
    if (isNaN(num))
        num = "0";
    sign = (num == (num = Math.abs(num)));
    num = Math.floor(num * 100 + 0.50000000001);
    cents = num % 100;
    num = Math.floor(num / 100).toString();
    if (cents < 10)
        cents = "0" + cents;
    for (var i = 0; i < Math.floor((num.length - (1 + i)) / 3); i++)
        num = num.substring(0, num.length - (4 * i + 3)) + '.' + num.substring(num.length - (4 * i + 3));
    return (((sign) ? '' : '-') + num);
}