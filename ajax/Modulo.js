function CrearModulo() {
    var confirma = confirm("¿Esta seguro de realizar esta acción?");

    if (confirma) {

        var modulo = $("#modulo").val();

        if (modulo == "" || modulo == null) {
            alert("ingrese el nombre de el modulo");
        } else {
            var retorno;
            $.ajax({
                type: 'POST',
                url: "../controladores/ModuloController.php",
                async: false,
                data: {
                    tipo: 1,
                    modulo: modulo
                },
                success: function (retu) {
                    if (retu == 1) {
                        alertify.alert("Se realizo la acción correctamente", function () {
                            $("#modulo").val("");
                            $('#myModalResultados').modal('toggle');
                            VerModulos();
                        });
                    } else if (retu == 2) {
                        alertify.alert("no se logro realizar la acción");
                    }
                }
            });
        }
    }

}

function VerModulos() {

    $("#lista_modulos_cont_body").html("");

    var tabla = '<table id="lista_modulos_cont" class="table table-bordered">' +
            '<thead>' +
            '<tr style="background-color: #214761;">' +
            '<th style="color:white">Modulo</th>' +
            '<th style="color:white">Acciones</th>' +
            '</tr>' +
            '</thead>' +
            '<tbody id="lista_modulos_cont_body">' +
            '</tbody>' +
            '</table>';

    $("#tabla_modulos").html(tabla);

    var data;
    $.ajax({
        type: "POST",
        url: "../controladores/ModuloController.php",
        async: false,
        dataType: 'json',
        data: {
            tipo: 2

        },
        success: function (retu) {
            $.each(retu, function (i, modulos) {

                var boton = "<input type='button' onclick='ModuloUsuario(" + modulos.id_modulo + ")' data-target='#myModalUsuariosModulo' data-toggle='modal' value='Asignar Usuario' class='btn btn-primary'>";

                var newRow = "<tr>";
                newRow += "<td>" + modulos.modulo + "</td>";
                newRow += "<td>" + boton + "</td>";
                newRow += "</tr>";

                $(newRow).appendTo("#lista_modulos_cont_body");
            });
        }
    });



    var tabla = $('#lista_modulos_cont').DataTable({
        responsive: true
    });




}
function ModuloUsuario(modulo) {

    FormularioAsignarUsuario(modulo);
    UsuarioAsignado(modulo);

}

function UsuarioAsignado(modulo) {
    $("#cont_usrasignado").html("");
    var html;
    $.ajax({
        type: "POST",
        url: "../controladores/ModuloController.php",
        async: false,
        dataType: 'json',
        data: {
            tipo: 4,
            modulo: modulo

        },
        success: function (retu) {
            $.each(retu, function (i, data) {
                html = "<tr>" +
                        "<th>" + data.nombre_completo + "</th>" +
                        "<th>" + data.tipo_atencion + "</th>" +
                        "<th>Editar tipo atencion</th>" +
                        "</tr>";

            });
        }
    });


    $("#cont_usrasignado").html(html);

}

function FormularioAsignarUsuario(modulo) {


    var select_usuario = "<select id='usuario' name='usuario'><option value=''>Selecione el usuario</option>";
    $.ajax({
        type: "POST",
        url: "../controladores/ModuloController.php",
        async: false,
        dataType: 'json',
        data: {
            tipo: 3

        },
        success: function (retu) {
            $.each(retu, function (i, usuarios) {
                select_usuario += "<option value='" + usuarios.id + "'>" + usuarios.nombre_completo + "</option>";

            });
        }
    });

    select_usuario += "</select>";

    var select_tipo_atencion = "<select id='tipo_atencion'>" +
            "<option value=''>Seleccione el tipo de atencion</option>" +
            "<option value='PAGO'>PAGO</option>" +
            "<option value='TOMA_MUESTRA'>TOMA_MUESTRA</option>" +
            "</select>";

    var boton = "<input type='button' class='btn btn-primary' value='Asignar usuario' onclick='AsignarUsuarioModulo(" + modulo + ")'>";

    var html = "<table class='table table-bordered table-striped'>" +
            "<thead>" +
            "<tr>" +
            "<th colspan='3'><center>ASIGNAR USUARIO</center></th>" +
            "</tr>" +
            "<tr>" +
            "<th>Usuario</th><th>Tipo atencion</th><th>Asignar</th>" +
            "</tr>" +
            "</thead>" +
            "<tbody><tr>" +
            "<td>" + select_usuario + "</td>" +
            "<td>" + select_tipo_atencion + "</td>" +
            "<td>" + boton + "</td>" +
            "</tr></tbody>" +
            "</table>";

    $("#formulario_mdusario").html(html);

}

function AsignarUsuarioModulo(modulo) {
    var confirma = confirm("¿Esta seguro de realizar esta acción?");

    if (confirma) {

        var usuario = $("#usuario").val();
        var tipo_atencion = $("#tipo_atencion").val();

        if (usuario == "" || usuario == null || tipo_atencion == "" || tipo_atencion == null) {
            alert("Ingrese todos los campos");
        } else {
            var retorno;
            $.ajax({
                type: 'POST',
                url: "../controladores/ModuloController.php",
                async: false,
                data: {
                    tipo: 5,
                    modulo: modulo,
                    usuario: usuario,
                    tipo_atencion: tipo_atencion

                },
                success: function (retu) {
                    if (retu == 1) {
                        alertify.alert("Se realizo la acción correctamente", function () {
                            ModuloUsuario(modulo);
                        });
                    } else if (retu == 2) {
                        alertify.alert("no se logro realizar la acción");
                    }
                }
            });
        }

    }
}