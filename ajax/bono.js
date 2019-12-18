function lista_clasificacion() {
    $.ajax({
        url: '../controladores/bono.php',
        data:
                {
                    tipo: 1
                },
        type: 'post',
        dataType: 'json',
        success: function (data)
        {

            $.each(data, function (i, clasificacion) {
                var newRow = "<option value='" + clasificacion.id + "' >" + clasificacion.nombre + "</option>";
                $(newRow).appendTo("#lista_clasificacion");
            });


        }
    });
}


function lista_pacientes() {
    var clasificacion_id = $("#lista_clasificacion").val();

    $.ajax({
        url: '../controladores/bono.php',
        data:
                {
                    tipo: 2,
                    clasificacion_id: clasificacion_id
                },
        type: 'post',
        dataType: 'json',
        success: function (data)
        {

            $.each(data, function (i, cliente) {
                var newRow = "<option value='" + cliente.id_cliente + "' >" + cliente.nombre_completo + "</option>";
                $(newRow).appendTo("#lista_paciente");
            });


        }
    });
}

function ListaPacientesBon() {
    $.ajax({
        url: '../controladores/bono.php',
        data:
                {
                    tipo: 3
                },
        type: 'post',
        dataType: 'json',
        success: function (data)
        {

            $.each(data, function (i, cliente) {
                var newRow = "<option value='" + cliente.id_cliente + "' >" + cliente.documento + " - " + cliente.nombre + " " + cliente.apellido + "</option>";
                $(newRow).appendTo("#lista_paciente");
            });


        }
    });

    $("#lista_paciente").select2();
}



function BonosPersona(cliente_id) {
    $.ajax({
        url: '../controladores/bono.php',
        data: {
            tipo: 4,
            cliente_id: cliente_id
        },
        type: 'post',
        dataType: 'json',
        success: function (data)
        {
            if (data == "sin_bonos") {
                $("#contenedor_bonos").attr('style', 'display:none');
                $("#con_bon").html("");
            } else {

                var select = "<select id='bono_r' name='bono_r'>" +
                        "<option value=''>--no usar bonos--</option>";
                $.each(data, function (i, bonos) {

                    select += "<option value='" + bonos.id + "-" + bonos.cantidad_descuento + "'>" + bonos.codigo_bono + " = menos " + bonos.cantidad_descuento + "</option>";

                });
                select += "</select>";

                var tabla = "<table class='table table-responsive'><thead><tr><th>Codigo bono</th><th>Utilizar bono</th><th>Accion</th></tr></thead>" +
                        "<tbody>" +
                        "<tr>" +
                        "<td>Seleccione uno de los bonos disponibles si desea hacer uso de el bono</td>" +
                        "<td>" + select + "</td>" +
                        "<td id='boton_bono'><input type='button' onclick='SeleccionarBono()' value='Usar bono' class='btn btn-default'></td>" +
                        "</tr>" +
                        "</tbody>";


                /*$.each(data, function (i, bonos) {
                 tabla += "<tr><td>" + bonos.codigo_bono + "</td><td><input type='radio' value='" + bonos.id + "' id='bono_r' name='bono_r'></td></tr>";
                 });*/
                tabla += "</table>";
                $("#con_bon").html(tabla);
            }

            /* $.each(data, function (i, cliente) {
             var newRow = "<option value='" + cliente.id_cliente + "' >" + cliente.documento + " - " + cliente.nombre + " " + cliente.apellido + "</option>";
             $(newRow).appendTo("#lista_paciente");
             });*/


        }
    });
}


function SeleccionarBono() {
    var bono_seleccionado = $("#bono_r").val();

    //alert(bono_seleccionado);

    if (bono_seleccionado == "" || bono_seleccionado == null) {
        alert("Seleccione un bono");
    } else {
        $("#bono_seleccionado").val(bono_seleccionado);
        $("#bono_r").attr("disabled", "disabled");
        $("#boton_bono").html("<input type='button' onclick='CambiarBono()' value='Cambiar bono' class='btn btn-info'>");
    }
}

function CambiarBono() {
    if ($("#examenes_agregados").length == 0) {
        $("#bono_seleccionado").val("NO");
        $("#boton_bono").html("<input type='button' onclick='SeleccionarBono()' value='Usar bono' class='btn btn-default'>");
        $("#bono_r").removeAttr("disabled");
    } else {
        alert("Debe eliminar todos los examenes agregados para cambiar de bono");
    }

}
