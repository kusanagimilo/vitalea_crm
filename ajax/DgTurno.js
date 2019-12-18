/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
function LeerOtroQr() {
    location.reload();
}
function SolicitarTurno(tipo_turno, id_cliente, id_venta) {

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
                        LeerOtroQr();
                    });
                } else if (retu.retorno == 2) {
                    alertify.alert("no se logro realizar la acción");
                }
            }
        });

    }
}
function DatosTurno(venta, tipo_turno) {
    var retorno;
    $.ajax({
        type: "POST",
        url: "../controladores/DgTurnoController.php",
        async: false,
        dataType: 'json',
        data: {
            tipo: 2,
            venta: venta,
            tipo_turno: tipo_turno

        },
        success: function (retu) {
            retorno = retu;
        }
    });

    return retorno;
}

function TurnosAsignados(usuario, tp_usuario) {
    var tp_usuario_c = '"' + tp_usuario + '"';
    $("#lista_adm_tasignados").html("");

    var tabla = '<table id="lista_turnos_asignados" class="table table-bordered">' +
            '<thead>' +
            '<tr style="background-color: #214761;">' +
            '<th style="color:white">Turno</th>' +
            '<th style="color:white">Tipo de turno</th>' +
            '<th style="color:white">Modulo</th>' +
            '<th style="color:white">Fecha generacion</th>' +
            '<th style="color:white">Fecha aceptacion</th>' +
            '<th style="color:white">Documento cliente</th>' +
            '<th style="color:white">Cliente</th>' +
            '<th style="color:white">Acciones</th>' +
            '</tr>' +
            '</thead>' +
            '<tbody id="lista_adm_tasignados">' +
            '</tbody>' +
            '</table>';

    $("#adm_turnos_asignados").html(tabla);

    var data;
    $.ajax({
        type: "POST",
        url: "../controladores/DgTurnoController.php",
        async: false,
        dataType: 'json',
        data: {
            tipo: 3,
            id_usuario: usuario,
            tp_usuario: tp_usuario
        },
        success: function (retu) {



            //console.log(retu);
            $.each(retu, function (i, turno) {

                var botones = "";
                if (tp_usuario == "PAGO") {


                    if (turno.estado == 'INICIADO') {
                        aceptar = '"ACEPTADO"';
                        cancelar = '"CANCELADO"';
                        botones = "<input type='button' onclick='CambiarEstado(" + turno.id_turno + "," + aceptar + "," + usuario + "," + tp_usuario_c + ")' value='Atender turno' class='btn btn-sm btn-primary'><br>" +
                                "<input type='button' onclick='CambiarEstado(" + turno.id_turno + "," + cancelar + "," + usuario + "," + tp_usuario_c + ")' value='Cancelar turno' class='btn btn-sm btn-danger'>";
                    } else if (turno.estado == 'ACEPTADO') {
                        botones = "<input type='button' onclick='CambiarEstadoVentaD(2," + turno.id_venta + "," + usuario + "," + turno.id_turno + "," + tp_usuario_c + ")' value='Confirmar pago' class='btn btn-sm btn-success' />" +
                                "<input type='button' onclick='CambiarEstadoVentaD(3," + turno.id_venta + "," + usuario + "," + turno.id_turno + "," + tp_usuario_c + ")' value='Cancelar pago' class='btn btn-sm btn-danger' />";
                    }
                } else if (tp_usuario == "TOMA") {
                    if (turno.estado == 'INICIADO') {
                        aceptar = '"ACEPTADO"';
                        cancelar = '"CANCELADO"';
                        botones = "<input type='button' onclick='CambiarEstado(" + turno.id_turno + "," + aceptar + "," + usuario + "," + tp_usuario_c + ")' value='Atender turno' class='btn btn-sm btn-primary'><br>" +
                                "<input type='button' onclick='CambiarEstado(" + turno.id_turno + "," + cancelar + "," + usuario + "," + tp_usuario_c + ")' value='Cancelar turno' class='btn btn-sm btn-danger'>";
                    } else if (turno.estado == 'ACEPTADO') {
                        terminar = '"TERMINADO"';
                        botones = "<input type='button' onclick='CambiarEstado(" + turno.id_turno + "," + terminar + "," + usuario + "," + tp_usuario_c + ")' value='Terminar toma de muestra' class='btn btn-sm btn-success' />" +
                                '<input type="button" onclick="DetalleExamenesSolicitud(' + turno.id_venta + ')" data-toggle="modal" data-target="#myModalResultados" value="Ver detalle solicitud" class="btn btn-sm btn-info">';
                    }
                }

                var newRow = "<tr>";
                newRow += "<td id='turno_" + turno.id_turno + "'>" + turno.turno + "</td>";
                newRow += "<td id='tp_turno_" + turno.id_turno + "'>" + turno.tipo_turno + "</td>";
                newRow += "<td id='modulo_" + turno.id_turno + "'>" + turno.modulo + "</td>";
                newRow += "<td id='fecha_gen_" + turno.id_turno + "'>" + turno.fecha_creacion + "</td>";
                newRow += "<td id='fecha_gen_" + turno.id_turno + "'>" + turno.fecha_atencion + "</td>";
                newRow += "<td id='documento_" + turno.id_turno + "'>" + turno.documento + "</td>";
                newRow += "<td id='cliente_" + turno.id_turno + "'>" + turno.nombre + " " + turno.apellido + "</td>";
                newRow += "<td id='cliente_" + turno.id_turno + "'>" + botones + "</td>";
                newRow += "</tr>";

                $(newRow).appendTo("#lista_adm_tasignados");
            });
        }
    });



    var tabla = $('#lista_turnos_asignados').DataTable({
        responsive: true
    });


}
function CambiarEstado(turno, estado, usuario, tp_usuario) {
    var confirma = confirm("¿Esta seguro de realizar esta acción?");

    if (confirma) {
        var retorno;
        $.ajax({
            type: 'POST',
            url: "../controladores/DgTurnoController.php",
            async: false,
            data: {
                tipo: 4,
                id_turno: turno,
                estado: estado
            },
            success: function (retu) {
                if (retu == 1) {
                    alertify.alert("Accion realizada", function () {
                        TurnosAsignados(usuario, tp_usuario);
                    });
                } else if (retu == 2) {
                    alertify.alert("no se logro realizar la acción");
                }
            }
        });

    }
}

function CambiarEstadoVentaD(estado, id, usuario, turno, tp_usuario) {

    var confirma = confirm("¿Esta seguro de realizar esta acción?");

    if (confirma) {

        $('#ModalCargando').modal({backdrop: 'static', keyboard: false});

        var retorno;
        $.ajax({
            type: 'POST',
            url: "../controladores/FacturacionController.php",
            async: false,
            data: {
                tipo: 2,
                estado: estado,
                id: id
            },
            success: function (retu) {
                if (retu == 1) {


                    $.ajax({
                        type: 'POST',
                        async: false,
                        url: "../controladores/DgTurnoController.php",
                        data: {
                            tipo: 4,
                            id_turno: turno,
                            estado: 'TERMINADO'
                        },
                        success: function (retu) {
                            $('#ModalCargando').modal('toggle');

                            if (retu == 1) {
                                alertify.alert("Se realizo la acción correctamente", function () {
                                    TurnosAsignados(usuario, tp_usuario);
                                    SeleccionTurnosToma(usuario);
                                });
                            } else if (retu == 2) {
                                alertify.alert("no se logro realizar la acción");
                            }

                        }
                    });
                } else if (retu == 2) {
                    alertify.alert("no se logro realizar la acción");
                }
            }
        });
    }

}

function TurnosModulos() {

    var html = '<table class="redTable">' +
            '<thead style="border-radius: 2em;">' +
            '<tr>' +
            '<th>TURNO</th>' +
            '<th>CLIENTE</th>' +
            '<th>MÓDULO</th>' +
            '<th>ESTADO</th>' +
            '</tr>' +
            '</thead>' +
            '<tbody>';

    var retorno;
    $.ajax({
        type: 'POST',
        url: "../controladores/DgTurnoController.php",
        async: false,
        dataType: 'json',
        data: {
            tipo: 5
        },
        success: function (retu) {

            $.each(retu, function (i, pantalla) {

                if (pantalla.estado == 'INICIADO') {

                    html += '<tr style="border-color: #B900FF;">' +
                            '<td style="font-size:40px;color:#000;"><b>' + pantalla.turno + '</b></td>' +
                            '<td style="font-size: 40px;color:#000;"><b>' + pantalla.nombre + ' ' + pantalla.apellido + '</b></td>' +
                            '<td style="font-size: 40px;color:#000;"><b>' + pantalla.modulo + '</b></td>' +
                            '<td style="font-size: 40px;color:#000;"><b>LLAMANDO</b></td>' +
                            '</tr>';


                } else if (pantalla.estado == 'ACEPTADO') {

                    html += '<tr>' +
                            '<td>' + pantalla.turno + '</td>' +
                            '<td>' + pantalla.nombre + ' ' + pantalla.apellido + '</td>' +
                            '<td>' + pantalla.modulo + '</td>' +
                            '<td>ATENDIENDO</td>' +
                            '</tr>';
                }
            });
        }
    });

    html += '</tbody>' +
            '</table>';

    $("#contenido_dg").html(html);
}


function SeleccionTurnosToma(usuario) {

    $("#lista_adm_toma").html("");

    var tabla = '<table id="lista_turnos_toma" class="table table-bordered">' +
            '<thead>' +
            '<tr style="background-color: #214761;">' +
            '<th style="color:white">Turno</th>' +
            '<th style="color:white">Modulo</th>' +
            '<th style="color:white">Fecha generacion</th>' +
            '<th style="color:white">Fecha aceptacion</th>' +
            '<th style="color:white">Documento cliente</th>' +
            '<th style="color:white">Cliente</th>' +
            '<th style="color:white">Acciones</th>' +
            '</tr>' +
            '</thead>' +
            '<tbody id="lista_adm_toma">' +
            '</tbody>' +
            '</table>';

    $("#adm_turnos_toma").html(tabla);

    var data;
    $.ajax({
        type: "POST",
        url: "../controladores/DgTurnoController.php",
        async: false,
        dataType: 'json',
        data: {
            tipo: 6,
            id_usuario: usuario

        },
        success: function (retu) {



            // console.log(retu);
            $.each(retu, function (i, turno) {

                tipo_turno = '"TOMA_MUESTRA"';

                botones = "<input type='button' onclick='SolicitarTurnoT(" + tipo_turno + "," + turno.id_cliente + "," + turno.id_venta + "," + usuario + ")' value='Enviar a toma de muestra' class='btn btn-sm btn-primary'><br>" +
                        "<input type='button' onclick='' value='Enviar turno a correo' class='btn btn-sm btn-danger'>";

                var newRow = "<tr>";
                newRow += "<td id='turno_" + turno.id_turno + "'>" + turno.turno + "</td>";
                newRow += "<td id='modulo_" + turno.id_turno + "'>" + turno.modulo + "</td>";
                newRow += "<td id='fecha_gen_" + turno.id_turno + "'>" + turno.fecha_creacion + "</td>";
                newRow += "<td id='fecha_gen_" + turno.id_turno + "'>" + turno.fecha_atencion + "</td>";
                newRow += "<td id='documento_" + turno.id_turno + "'>" + turno.documento + "</td>";
                newRow += "<td id='cliente_" + turno.id_turno + "'>" + turno.nombre + " " + turno.apellido + "</td>";
                newRow += "<td id='cliente_" + turno.id_turno + "'>" + botones + "</td>";
                newRow += "</tr>";

                $(newRow).appendTo("#lista_turnos_toma");
            });
        }
    });



    var tabla = $('#lista_turnos_toma').DataTable({
        responsive: true
    });
}

function SolicitarTurnoT(tipo_turno, id_cliente, id_venta, usuario) {

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
                    alertify.alert("El turno genrado es : " + retu.turno, function () {
                        SeleccionTurnosToma(usuario);
                    });
                } else if (retu.retorno == 2) {
                    alertify.alert("no se logro realizar la acción");
                }
            }
        });

    }
}

function BusquedaTurnosDisponibles() {

    var documento = $.trim($("#documento").val());


    if (documento == "" || documento == null) {

        alertify.alert("Ingrese un documento");

    } else {
        var retorno;

        $.ajax({
            type: 'POST',
            url: "../controladores/DgTurnoController.php",
            async: false,
            dataType: 'json',
            data: {
                tipo: 7,
                documento: documento

            },
            success: function (retu) {
                retorno = retu;
            }
        });

        if (retorno == "sin_informacion") {
            alertify.alert("NO SE ENCONTRO INFORMACION PARA ESTE DOCUMENTO");
        } else {
            var html = "<table class='table table-bordered'><thead>" +
                    "<tr>" +
                    "<th>Paciente</th>" +
                    "<th>Documento</th>" +
                    "</tr></thead>" +
                    "<tbody>" +
                    "<tr>" +
                    "<td>" + retorno.nombre_completo + "</td>" +
                    "<td>" + retorno.documento + "</td>" +
                    "</tr>" +
                    "</tbody></table>";

            html += "<table class='table table-bordered'><thead>" +
                    "<tr>" +
                    "<th>Codigo solicitud</th>" +
                    "<th>Fecha solicitud</th>" +
                    "<th>Tipo turno</th>" +
                    "<th>Solicitar turno</th>" +
                    "</tr></thead>" +
                    "<tbody>";

            $.each(retorno.turnos_disponibles, function (i, turnos) {

                var tipo_turno_on = '"' + turnos.tipo_turno + '"';
                var boton = "<input type='button' class='btn btn-primary' value='Solicitar turno' onclick='SolicitarTurno(" + tipo_turno_on + "," + retorno.id_cliente + "," + turnos.id_venta + ")' >";

                html += "<tr>" +
                        "<td>" + turnos.id_solicitud + "</td>" +
                        "<td>" + turnos.fecha_generacion + "</td>" +
                        "<td>" + turnos.tipo_turno + "</td>" +
                        "<td>" + boton + "</td>" +
                        "</tr>";
            });

            html += "</tbody></table>";

            $("#contenedor_turnos").html(html);
        }
    }



}
function DetalleExamenesSolicitud(venta_id) {
    var datos;
    $.ajax({
        type: "POST",
        url: "../controladores/DgTurnoController.php",
        async: false,
        dataType: 'json',
        data: {
            tipo: 8,
            venta_id: venta_id
        },
        success: function (retu) {
            datos = retu;
        }
    });


    var html = "<div id='perfiles'><h4>Perfiles</h4>";
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
                '<thead><tr><th>Codigo</th><th>Nombre</th></tr></thead><tbody>';

        $.each(datos_por_perfil, function (i, examenes) {
            tabla += "<tr>" +
                    "<td>" + examenes.codigo + "</td>" +
                    "<td>" + examenes.nombre + "</td>" +
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
            '<thead><tr><th>Codigo</th><th>Nombre</th></tr></thead><tbody>';

    $.each(datos.no_perfiles, function (i, no_perfil) {
        html += "<tr>" +
                "<td>" + no_perfil.codigo + "</td>" +
                "<td>" + no_perfil.nombre + "</td>" +
                "</tr>";
    });

    html += "</tbody></table></div>";

    $("#cuerpo_modal").html(html);

}