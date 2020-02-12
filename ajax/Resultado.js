function VerListaResultados(id_cliente) {

    $("#lista_resultado_cot_body").html("");

    var tabla = '<br><table id="lista_resultado" class="table table-bordered">' +
            '<thead>' +
            '<tr style="background-color: #214761;">' +
            '<th style="color:white">Codigo unico solicitud</th>' +
            '<th style="color:white">Estado</th>' +
            '<th style="color:white">Fecha creacion solicitud</th>' +
            '<th style="color:white">Fecha recepcion resultados</th>' +
            '<th style="color:white">Ver documentos anexos</th>' +
            '</tr>' +
            '</thead>' +
            '<tbody id="lista_resultado_cot_body">' +
            '</tbody>' +
            '</table>';

    $("#tabla_resul").html(tabla);

    var data;
    $.ajax({
        type: "POST",
        url: "../controladores/ResultadoController.php",
        async: false,
        dataType: 'json',
        data: {
            tipo: 1,
            id_cliente: id_cliente

        },
        success: function (retu) {



            $.each(retu, function (i, resultados) {

                var estado = "";
                var fecha_recepcion = "";
                var archivos = "";
                if (resultados.estado == 1) {
                    estado = "En espera de envio de resultados";
                    fecha_recepcion = "En espera de envio de resultados";
                    archivos = "En espera de envio de resultados";
                } else if (resultados.estado == 2) {
                    estado = "Resultado recibido";
                    fecha_recepcion = resultados.fecha_modificacion;

                    if (resultados.nombre_archivo_sistema == null || resultados.nombre_archivo_sistema == "") {
                        archivos = "<input type='button' disabled='true' class='btn btn-danger' value='No se ha cargado ningun documento'>";
                    } else {
                        archivos = '<a target="_blank" href="resultados/' + resultados.nombre_archivo_sistema + '" class="btn btn-danger"><span class="glyphicon glyphicon-save"></span> Descargar resultado</a>';
                    }


                }
                var newRow = "<tr>";
                newRow += "<td>" + resultados.id_solicitud_athenea + "</td>";
                newRow += "<td>" + estado + "</td>";
                newRow += "<td>" + resultados.fecha_creacion + "</td>";
                newRow += "<td>" + fecha_recepcion + "</td>";
                newRow += "<td>" + archivos + "</td>";
                newRow += "</tr>";

                $(newRow).appendTo("#lista_resultado_cot_body");
            });
        }
    });

    var tabla = $('#lista_resultado').DataTable({
        responsive: true
    });


}

function ResultadosIndividual() {

    var documento = $("#documento").val();
    var id_solicitud = $("#id_solicitud").val();
    var regi_resul = $("#regi_resul").val();
    $("#tabla_resultado").html("");



    var data;
    $.ajax({
        type: "POST",
        url: "../controladores/ResultadoController.php",
        async: false,
        dataType: 'json',
        data: {
            tipo: 2,
            documento: documento,
            id_solicitud: id_solicitud,
            regi_resul: regi_resul

        },
        success: function (retu) {

            $("#lista_resultado_cot_body").html("");

            var tabla = '<br><table id="lista_resultado" class="table table-bordered">' +
                    '<thead>' +
                    '<tr style="background-color: #214761;">' +
                    '<th style="color:white">Codigo unico solicitud</th>' +
                    '<th style="color:white">Documento paciente</th>' +
                    '<th style="color:white">Nombre paciente</th>' +
                    '<th style="color:white">Estado</th>' +
                    '<th style="color:white">Fecha creacion solicitud</th>' +
                    '<th style="color:white">Fecha recepcion resultados</th>' +
                    '<th style="color:white">Documento</th>' +
                    '<th style="color:white">Ver detalle</th>' +
                    '<th style="color:white">Enviar resultado</th>' +
                    //'<th style="color:white">%Resultados</th>' +
                    '</tr>' +
                    '</thead>' +
                    '<tbody id="lista_resultado_cot_body">' +
                    '</tbody>' +
                    '</table>';

            var html = '<div id="tabla_resul" class="table-responsive">';
            $("#tabla_resultado").html(html);
            $("#tabla_resul").html(tabla);

            $.each(retu.resultados, function (i, resultados) {

                var estado = "";
                var fecha_recepcion = "";
                var archivos = "";
                var detalle = "";
                var boton_envio = "";
                if (resultados.estado == 1) {
                    estado = "En espera de envio de resultados";
                    fecha_recepcion = "En espera de envio de resultados";
                    archivos = "En espera de envio de resultados";
                    detalle = '<input type="button" onclick="ResultadosDetalle(' + resultados.idventa + ',' + resultados.idresultado + ')" data-toggle="modal" data-target="#myModalResultados" value="Ver detalle" class="btn btn-sm btn-primary">'
                    boton_envio = "En espera de envio de resultados";
                } else if (resultados.estado == 2) {

                    var correo = '"' + resultados.email + '"';
                    var cliente = '"' + resultados.nombre + ' ' + resultados.apellido + '"';

                    estado = "Resultado recibido";
                    fecha_recepcion = resultados.fecha_modificacion;

                    if (resultados.nombre_archivo_sistema == null || resultados.nombre_archivo_sistema == "") {
                        archivos = "<input type='button' disabled='true' class='btn btn-danger' value='No se ha cargado ningun documento'>";
                    } else {
                        archivos = '<a target="_blank" href="resultados/' + resultados.nombre_archivo_sistema + '" class="btn btn-danger"><span class="glyphicon glyphicon-save"></span> Descargar resultado</a>';
                    }

                    detalle = '<input type="button" onclick="ResultadosDetalle(' + resultados.idventa + ',' + resultados.idresultado + ')" data-toggle="modal" data-target="#myModalResultados" value="Ver detalle" class="btn btn-sm btn-primary">';
                    boton_envio = "<input type='button' onclick='CargaDataEnvioRes(" + correo + "," + cliente + "," + resultados.idresultado + ")' class='btn btn-info' value='Enviar' data-toggle='modal' data-target='#myModalEnvio'>";

                }
                var newRow = "<tr>";
                newRow += "<td>" + resultados.id_solicitud_athenea + "</td>";
                newRow += "<td>" + resultados.documento + "</td>";
                newRow += "<td>" + resultados.nombre + " " + resultados.apellido + "</td>";
                newRow += "<td>" + estado + "</td>";
                newRow += "<td>" + resultados.fecha_pago + "</td>";
                newRow += "<td>" + fecha_recepcion + "</td>";
                newRow += "<td>" + archivos + "</td>";
                newRow += "<td>" + detalle + "</td>";
                newRow += "<td>" + boton_envio + "</td>";
                //newRow += "<td>" + resultados.porcentaje + "</td>";
                newRow += "</tr>";

                /* function EnviarCorreo($correo_cliente, $nombre_cliente, $id_resultado, $tipo_envio)*/
                $(newRow).appendTo("#lista_resultado_cot_body");
            });

            var tabla = $('#lista_resultado').DataTable({
                responsive: true
            });



        }
    });


}

function ResultadosDetalle(venta_id, id_resultado) {
    var datos;
    $.ajax({
        type: "POST",
        url: "../controladores/ResultadoController.php",
        async: false,
        dataType: 'json',
        data: {
            tipo: 3,
            venta_id: venta_id,
            id_resultado: id_resultado
        },
        success: function (retu) {
            datos = retu;
        }
    });

    var arreglo_por = datos.porcentaje;

    var porcentaje = '<h2>Porcentaje de resultados ingresados</h2>' +
            '<div class="progress">' +
            '<div class="progress-bar" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width:' + arreglo_por.porcentaje + '%">' + arreglo_por.porcentaje + '%</div>' +
            '</div>'
    var html = porcentaje + "<div id='perfiles'><h4>Perfiles</h4>";
    html += '<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">';
    $.each(datos.perfiles, function (i, perfi) {

        var datos_por_perfil = perfi.examenes;

        html += '<div class="panel panel-default">' +
                '<div class="panel-heading" role="tab" id="heading' + perfi.codigo + '">' +
                '<h4 class="panel-title">' +
                '<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse' + perfi.codigo + '" aria-expanded="false" aria-controls="collapse' + perfi.codigo + '">' +
                perfi.nombre + " - " + perfi.codigo + ' ↓ ' +
                '</a>' +
                '</h4>' +
                '</div>';

        var tabla = '<div id="tabla_resul" class="table-responsive">' +
                '<table class="table table-bordered">' +
                '<thead><tr><th>Codigo</th><th>Nombre</th><th>Fecha ingreso</th><th>Valor</th></tr></thead><tbody>';

        $.each(datos_por_perfil, function (i, examenes) {

            td_analitos = "";
            if (examenes.valor != "revisar_analitos") {
                td_analitos = "<td>" + examenes.fecha + "</td>" +
                        "<td>" + examenes.valor + "</td>";
            } else {
                td_analitos = '<td colspan="2"><center><input type="button" onclick="VerAnalitos(' + examenes.id_c + ',' + id_resultado + ')" data-toggle="modal" data-target="#myModalAnalito" value="Revisar analitos" class="btn btn-primary"></center></td>';
            }


            tabla += "<tr>" +
                    "<td>" + examenes.codigo + "</td>" +
                    "<td>" + examenes.nombre + "</td>" +
                    td_analitos +
                    "</tr>";
        });

        tabla += "</tbody></table></div>";

        html += '<div id="collapse' + perfi.codigo + '" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading' + perfi.codigo + '">' +
                '<div class="panel-body">' + tabla + '</div>' +
                '</div>' +
                '</div>';


    });
    html += '</div></div>';

    html += "<div id='examenes_no_perfiles' class='table-responsive'><h4>Examenes individuales</h4>" +
            "<table class='table table-bordered'>" +
            '<thead><tr><th>Codigo</th><th>Nombre</th><th>Fecha ingreso</th><th>Valor</th></tr></thead><tbody>';

    $.each(datos.no_perfiles, function (i, no_perfil) {

        td_analitos = "";
        if (no_perfil.valor != "revisar_analitos") {
            td_analitos = "<td>" + no_perfil.fecha + "</td>" +
                    "<td>" + no_perfil.valor + "</td>";
        } else {
            td_analitos = '<td colspan="2"><center><input type="button" onclick="VerAnalitos(' + no_perfil.id + ',' + id_resultado + ')" data-toggle="modal" data-target="#myModalAnalito" value="Revisar analitos" class="btn btn-primary"></center></td>';
        }

        html += "<tr>" +
                "<td>" + no_perfil.codigo + "</td>" +
                "<td>" + no_perfil.nombre + "</td>" +
                td_analitos +
                "</tr>";

    });

    html += "</tbody></table></div>";

    $("#cuerpo_modal").html(html);



}

function VerAnalitos(id_examen, id_resultado) {
    var datos;
    $.ajax({
        type: "POST",
        url: "../controladores/ResultadoController.php",
        async: false,
        dataType: 'json',
        data: {
            tipo: 5,
            id_examen: id_examen,
            id_resultado: id_resultado
        },
        success: function (retu) {
            datos = retu;
        }
    });

    var tabla = '<div id="tabla_resul" class="table-responsive">' +
            '<table class="table table-bordered">' +
            '<thead><tr><th>Codigo</th><th>Nombre</th><th>Fecha ingreso</th><th>Valor</th></tr></thead><tbody>';

    $.each(datos, function (i, sub_examen) {

        tabla += "<tr>" +
                "<td>" + sub_examen.codigo + "</td>" +
                "<td>" + sub_examen.nombre + "</td>" +
                "<td>" + sub_examen.fecha + "</td>" +
                "<td>" + sub_examen.valor + "</td>" +
                "</tr>";

    });
    tabla += "</tbody></table></div>";

    $("#cuerpo_analito").html(tabla);
}
function ResultadosIndividualLog() {

    var documento = $("#documento").val();
    $("#tabla_resultado").html("");


    if (documento != null || documento != "") {
        var data;
        $.ajax({
            type: "POST",
            url: "../controladores/ResultadoController.php",
            async: false,
            dataType: 'json',
            data: {
                tipo: 2,
                documento: documento

            },
            success: function (retu) {
                if (retu == 2) {
                    alertify.alert("Este documento no se encuentra registrado");
                    $("#tabla_resultado").html("");
                } else {

                    $("#lista_resultado_cot_body").html("");

                    var tabla = '<br><table id="lista_resultado" class="table table-bordered">' +
                            '<thead>' +
                            '<tr style="background-color: #214761;">' +
                            '<th style="color:white">Codigo unico solicitud</th>' +
                            '<th style="color:white">Estado</th>' +
                            '<th style="color:white">Fecha creacion solicitud</th>' +
                            '<th style="color:white">Fecha recepcion resultados</th>' +
                            '<th style="color:white">Ver Logs</th>' +
                            '</tr>' +
                            '</thead>' +
                            '<tbody id="lista_resultado_cot_body">' +
                            '</tbody>' +
                            '</table>';

                    var html = '<b><div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">' + retu.nombre + ' ' + retu.apellido + '</div>' +
                            '<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">' + retu.documento + '</div>' +
                            '<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">' + retu.email + '</div></b><br>' +
                            '<div id="tabla_resul" class="table-responsive">';
                    $("#tabla_resultado").html(html);
                    $("#tabla_resul").html(tabla);

                    $.each(retu.resultados, function (i, resultados) {

                        var estado = "";
                        var fecha_recepcion = "";
                        var archivos = "";
                        var logs = "";
                        if (resultados.estado == 1) {
                            estado = "En espera de envio de resultados";
                            fecha_recepcion = "En espera de envio de resultados";
                            archivos = "En espera de envio de resultados";
                        } else if (resultados.estado == 2) {
                            estado = "Resultado recibido";
                            fecha_recepcion = resultados.fecha_modificacion;
                            logs = '<input type="button" data-toggle="modal" onclick="VerLogsSolicitud(' + resultados.id_solicitud_athenea + ')" data-target="#myModalResultados" value="Ver logs" class="btn btn-danger">';


                        }
                        var newRow = "<tr>";
                        newRow += "<td>" + resultados.id_solicitud_athenea + "</td>";
                        newRow += "<td>" + estado + "</td>";
                        newRow += "<td>" + resultados.fecha_pago + "</td>";
                        newRow += "<td>" + fecha_recepcion + "</td>";
                        newRow += "<td>" + logs + "</td>";
                        newRow += "</tr>";

                        $(newRow).appendTo("#lista_resultado_cot_body");
                    });

                    var tabla = $('#lista_resultado').DataTable({
                        responsive: true
                    });

                }

            }
        });

    } else {
        alertify.alert("Ingrese un documento");
    }
}

function VerLogsSolicitud(id_solicitud_athenea) {

    $("#cuerpo_modal").html("");
    var data;
    $.ajax({
        type: "POST",
        url: "../controladores/ResultadoController.php",
        async: false,
        dataType: 'json',
        data: {
            tipo: 4,
            id_solicitud_athenea: id_solicitud_athenea

        },
        success: function (retu) {
            if (retu != 2) {
                $("#cuerpo_modal").html("");


                var tabla = '<br><table id="lista_logs" class="table table-bordered">' +
                        '<thead>' +
                        '<tr style="background-color: #214761;">' +
                        '<th style="color:white">Codigo examen</th>' +
                        '<th style="color:white">Fecha creacion</th>' +
                        '<th style="color:white">Resultado</th>' +
                        '<th style="color:white">Usar resultado</th>' +
                        '</tr>' +
                        '</thead>' +
                        '<tbody id="lista_logs_cot_body">' +
                        '</tbody>' +
                        '</table>';
                $("#cuerpo_modal").html(tabla);

                $.each(retu, function (i, logs) {

                    var boton_usar = '<input type="button" value="Usar log" class="btn btn-primary">';

                    var newRow = "<tr>";
                    newRow += "<td>" + logs.codigo_examen + "</td>";
                    newRow += "<td>" + logs.fecha_creacion + "</td>";
                    newRow += "<td>" + logs.resultado + "</td>";
                    newRow += "<td>" + boton_usar + "</td>";
                    newRow += "</tr>";

                    $(newRow).appendTo("#lista_logs_cot_body");

                });

                var tabla = $('#lista_logs').DataTable({
                    responsive: true
                });

            } else {
                $("#cuerpo_modal").html("");
            }
        }
    });

}


function CargaDataEnvioRes(correo_cli, nombre_cliente, id_resultado) {

    var nombre_cliente_f = "'" + nombre_cliente + "'";
    $("#correo_resultado").val("");
    $("#correo_resultado").val(correo_cli);
    $("#enviar_res").attr("onclick", "EnviarCorreoResultado(" + nombre_cliente_f + "," + id_resultado + ")");

}

function EnviarCorreoResultado(nombre_cliente, id_resultado) {


    var correo_cliente = $("#correo_resultado").val();

    if (correo_cliente == "") {
        alertify.alert("Revise el formulario y complete los datos obligatorios");
    } else {
        var confirma = confirm("Esta seguro de  enviar el correo");
        if (confirma) {

            var datos;
            $.ajax({
                type: "POST",
                url: "../controladores/ResultadoController.php",
                async: false,
                dataType: 'json',
                data: {
                    tipo: 6,
                    correo_cliente: correo_cliente,
                    nombre_cliente: nombre_cliente,
                    id_resultado: id_resultado
                },
                success: function (retu) {
                    datos = retu;
                }
            });

            if (datos == 1) {
                alertify.alert("Se envio el correo correctamente", function () {
                    $('#myModalEnvio').modal('toggle');
                });
            } else if (datos == 2) {
                alertify.alert("Ocurrio un error al tratar de enviar el correo");
            }

        }
    }

    /*$correo_cliente = $_POST['correo_cliente'];
     $nombre_cliente = $_POST['nombre_cliente'];
     $id_resultado = $_POST['id_resultado'];*/
}