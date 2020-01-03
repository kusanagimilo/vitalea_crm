function VerExamenesNoPerfiles() {


    $("#lista_nperfiles_cot_body").html("");

    var tabla = '<table id="lista_nperfiles_cot" class="table table-bordered">' +
            '<thead>' +
            '<tr style="background-color: #214761;">' +
            '<th style="color:white">Codigo perfil</th>' +
            '<th style="color:white">Nombre perfil</th>' +
            '<th style="color:white">Precio</th>' +
            '<th style="color:white">Acciones</th>' +
            '</tr>' +
            '</thead>' +
            '<tbody id="lista_nperfiles_cot_body">' +
            '</tbody>' +
            '</table>';

    $("#tabla_examen_perfil").html(tabla);

    var data;
    $.ajax({
        type: "POST",
        url: "../controladores/ExamenController.php",
        async: false,
        dataType: 'json',
        data: {
            tipo: 1

        },
        success: function (retu) {
            $.each(retu, function (i, nperfil) {


                var botones = '<input type="button" data-toggle="modal" data-target="#myModalPerfilesMod" onclick="CargaDataExamenPerfil(' + nperfil.id + ')" value="Modificar perfil" class="btn btn-sm btn-default"><br>' +
                        '<input type="button" data-toggle="modal" data-target="#myModalResultados" onclick="VerExamenesPorPerfil(' + nperfil.id + ')" value="Ver y adicionar examenes" class="btn btn-sm btn-primary">';



                //var btn_prueba = "<input value='pdf_prueba' type='button' class='btn btn-sm btn-danger' onclick='pfdprueba(" + ventas.id_venta + ")'>";

                var newRow = "<tr>";
                newRow += "<td id='np_co" + nperfil.id + "'>" + nperfil.codigo_crm + "</td>";
                newRow += "<td id='np_nom" + nperfil.id + "'>" + nperfil.nombre + "</td>";
                newRow += "<td id='np_pre" + nperfil.id + "'>" + nperfil.precio + "</td>";
                newRow += "<td id='np_boto" + nperfil.id + "'>" + botones + "</td>";
                newRow += "</tr>";

                $(newRow).appendTo("#lista_nperfiles_cot_body");
            });
        }
    });



    var tabla = $('#lista_nperfiles_cot').DataTable({
        responsive: true
    });

}

function VerExamenesPorPerfil(id_perfil) {


    $("#boton_add_exam").attr("onclick", "AdicionarExamenPorPerfil(" + id_perfil + ")");
    $("#lista_nexa_cot_body").html("");

    var tabla = '<table id="lista_nexa_cot" class="table table-bordered">' +
            '<thead>' +
            '<tr style="background-color: #214761;">' +
            '<th style="color:white">Codigo examen</th>' +
            '<th style="color:white">Nombre examen</th>' +
            '<th style="color:white">Acciones</th>' +
            '</tr>' +
            '</thead>' +
            '<tbody id="lista_nexa_cot_body">' +
            '</tbody>' +
            '</table>';

    $("#cont_modal_nexa").html(tabla);

    var data;
    $.ajax({
        type: "POST",
        url: "../controladores/ExamenController.php",
        async: false,
        dataType: 'json',
        data: {
            tipo: 2,
            id_perfil: id_perfil

        },
        success: function (retu) {
            console.log(retu);

            $.each(retu, function (i, exaper) {

                var botones = '<input type="button" value="Eliminar" onclick="EliminarExamenPorPerfil(' + exaper.id_examen_perfil + ',' + exaper.id_perfil_examen + ')" class="btn btn-danger">';
                var newRow = "<tr id='exa_" + exaper.id_no_perfil + "'>";
                newRow += "<td>" + exaper.codigo_no_perfil + "</td>";
                newRow += "<td>" + exaper.nombre_no_perfil + "</td>";
                newRow += "<td>" + botones + "</td>";
                newRow += "</tr>";

                $(newRow).appendTo("#lista_nexa_cot_body");
            });
        }
    });

}

function SelectExamenes() {
    $.ajax({
        url: '../controladores/Gestion.php',
        data:
                {
                    tipo: 28
                },
        type: 'post',
        dataType: 'json',
        success: function (data)
        {

            $("#examen_no_perfil").empty();
            $("#examen_no_perfil").append("<option value=''>--seleccione--</option>");
            $.each(data, function (i, examen) {
                $("#examen_no_perfil").append("<option value='" + examen.id + "'>" + examen.nombre + "</option>");
                /*var newRow ="<option value='"+examen.id+"'>"+examen.nombre+"</option>";
                 $(newRow).appendTo("#examen_no_perfil");*/

            });
        }
    });
}

function AdicionarExamenPorPerfil(id_perfil) {
    var examen_adicion = $("#examen_no_perfil").val();
    if (examen_adicion == "") {
        alert("Seleccione un examen");
    } else {
        if ($("#exa_" + examen_adicion + "").length > 0) {
            alert("Ya se encuentra adicionado este examen para este perfil");
        } else {


            var data;
            $.ajax({
                type: "POST",
                url: "../controladores/ExamenController.php",
                async: false,
                data: {
                    tipo: 3,
                    id_perfil: id_perfil,
                    id_examen: examen_adicion

                },
                success: function (retu) {
                    data = retu;
                }
            });

            if (data == 1) {
                alert("Se adiciono correctamente el examen");
                VerExamenesPorPerfil(id_perfil);
            } else {
                alert("Ocurrio un error al tratar de adicionar el examen");
            }


        }
    }
}

function EliminarExamenPorPerfil(id_perfil, id_examen_perfil) {
    var confirma = confirm("Esta seguro de retirar este examen de este perfil");
    if (confirma) {
        var data;
        $.ajax({
            type: "POST",
            url: "../controladores/ExamenController.php",
            async: false,
            data: {
                tipo: 7,
                id_perfil_examen: id_examen_perfil
            },
            success: function (retu) {
                data = retu;
            }
        });

        if (data == 1) {
            VerExamenesPorPerfil(id_perfil);
        } else {
            alert("Error al tratar de eliminar el examen");
        }

    }
}

function ListaExamenes() {


    $("#lista_examen_cot_body").html("");

    var tabla = '<table id="lista_examen_cot" class="table table-bordered">' +
            '<thead>' +
            '<tr style="background-color: #214761;">' +
            '<th style="color:white">Codigo</th>' +
            '<th style="color:white">Nombre</th>' +
            '<th style="color:white">Precio</th>' +
            '<th style="color:white">Acciones</th>' +
            '</tr>' +
            '</thead>' +
            '<tbody id="lista_examen_cot_body">' +
            '</tbody>' +
            '</table>';

    $("#tabla_examen").html(tabla);

    var data;
    $.ajax({
        type: "POST",
        url: "../controladores/ExamenController.php",
        async: false,
        dataType: 'json',
        data: {
            tipo: 4

        },
        success: function (retu) {
            $.each(retu, function (i, examen) {


                var botones = '<input type="button" data-toggle="modal" data-target="#myModalResultados" onclick="VerSubExamen(' + examen.id + ')" value="Ver y/o adicionar sub examen" class="btn btn-sm btn-primary">';


                var newRow = "<tr>";
                newRow += "<td id='ex_cod" + examen.id + "'>" + examen.codigo + "</td>";
                newRow += "<td id='ex_nom" + examen.id + "'>" + examen.nombre + "</td>";
                newRow += "<td id='ex_pre" + examen.id + "'>" + examen.precio + "</td>";
                newRow += "<td id='ex_btn" + examen.id + "'>" + botones + "</td>";
                newRow += "</tr>";

                $(newRow).appendTo("#lista_examen_cot_body");
            });
        }
    });



    var tabla = $('#lista_examen_cot').DataTable({
        responsive: true
    });

}


function VerSubExamen(id_examen) {


    $("#codigo_sub_examen").val("");
    $("#nombre_sub_examen").val("");
    $("#boton_add_subexa").attr("onclick", "AdicionarSubExamen(" + id_examen + ")");
    $("#lista_subexamen_cot_body").html("");


    var tabla = '<table id="lista_subexamen_cot" class="table table-bordered">' +
            '<thead>' +
            '<tr style="background-color: #214761;">' +
            '<th style="color:white">Codigo examen</th>' +
            '<th style="color:white">Nombre examen</th>' +
            '<th style="color:white">Acciones</th>' +
            '</tr>' +
            '</thead>' +
            '<tbody id="lista_subexamen_cot_body">' +
            '</tbody>' +
            '</table>';

    $("#cont_modal_subexamen").html(tabla);

    var data;
    $.ajax({
        type: "POST",
        url: "../controladores/ExamenController.php",
        async: false,
        dataType: 'json',
        data: {
            tipo: 5,
            id_examen: id_examen

        },
        success: function (retu) {
            console.log(retu);

            $.each(retu, function (i, subexa) {

                var botones = '';
                var newRow = "<tr id='subexa_" + subexa.id_sub_examen + "'>";
                newRow += "<td>" + subexa.codigo_sub_examen + "</td>";
                newRow += "<td>" + subexa.nombre_sub_examen + "</td>";
                newRow += "<td>" + botones + "</td>";
                newRow += "</tr>";

                $(newRow).appendTo("#lista_subexamen_cot_body");
            });
        }
    });

}


function AdicionarSubExamen(id_examen) {
    var codigo_sub_examen = $("#codigo_sub_examen").val();
    var nombre_sub_examen = $("#nombre_sub_examen").val();

    if (codigo_sub_examen == "" || nombre_sub_examen == "") {
        alert("Todos los datos son obligatorios");
    } else {
        var data;
        $.ajax({
            type: "POST",
            url: "../controladores/ExamenController.php",
            async: false,
            data: {
                tipo: 6,
                id_examen: id_examen,
                codigo_sub_examen: codigo_sub_examen,
                nombre_sub_examen: nombre_sub_examen

            },
            success: function (retu) {
                data = retu;
            }
        });

        if (data == 1) {
            alert("Se adiciono correctamente el examen");
            VerSubExamen(id_examen);
        } else if (data == 2) {
            alert("Ocurrio un error al tratar de adicionar el examen");
        } else if (data == 3) {
            alert("El codigo de el sub examen ya existe cambielo");
        }
    }
}

function ListaGrupos() {
    var datos;
    $.ajax({
        type: "POST",
        url: "../controladores/ExamenController.php",
        async: false,
        dataType: 'json',
        data: {
            tipo: 8

        },
        success: function (retu) {
            datos = retu;
        }
    });

    $("#grupo_perfil").empty();
    $("#grupo_perfil").append("<option value=''>--seleccione--</option>");
    $("#grupo_perfil_mod").empty();
    $("#grupo_perfil_mod").append("<option value=''>--seleccione--</option>");
    $.each(datos, function (i, examen) {
        $("#grupo_perfil").append("<option value='" + examen.id + "'>" + examen.nombre + "</option>");
        $("#grupo_perfil_mod").append("<option value='" + examen.id + "'>" + examen.nombre + "</option>");
    });
}

function LimpiarFormPerfil() {
    $("#grupo_perfil").val('');
    $("#nombre_perfil").val("");
    $("#codigo_perfil").val("");
    $("#precio_perfil").val("");
    $("#recomendaciones_perfil").val("");
    $("#preparacion_perfil").val("");
}

function AlmacenarPerfil() {


    var grupo_id = $("#grupo_perfil").val();
    var nombre = $("#nombre_perfil").val();
    var codigo_crm = $("#codigo_perfil").val();
    var preparacion = $("#preparacion_perfil").val();
    var recomendaciones = $("#recomendaciones_perfil").val();
    var precio = $("#precio_perfil").val();

    if (grupo_id == "" || nombre == "" || codigo_crm == "" || preparacion == "" || recomendaciones == "" || precio == "") {
        alertify.alert("Revise el formulario y complete los datos obligatorios");
    } else {

        var confirma = confirm("Esta seguro de adicionar este perfil");
        if (confirma) {

            var datos;
            $.ajax({
                type: "POST",
                url: "../controladores/ExamenController.php",
                async: false,
                dataType: 'json',
                data: {
                    tipo: 9,
                    grupo_id: grupo_id,
                    nombre: nombre,
                    codigo_crm: codigo_crm,
                    preparacion: preparacion,
                    recomendaciones: recomendaciones,
                    precio: precio
                },
                success: function (retu) {
                    datos = retu;
                }
            });

            if (datos == 1) {
                alertify.alert("Se ingreso correctamente el perfil", function () {
                    VerExamenesNoPerfiles();
                    $('#myModalPerfiles').modal('toggle');
                });
            } else if (datos == 2) {
                alertify.alert("Ocurrio un error al tratar de ingresar el perfil");
            } else if (datos == 3) {
                alertify.alert("Este perfil ya existe, cambielo");
            }

        }

    }

}

function AlmacenarExamen() {


    var codigo = $("#codigo_examen").val();
    var nombre = $("#nombre_examen").val();
    var precio = $("#precio_examen").val();

    if (codigo == "" || nombre == "" || precio == "") {
        alertify.alert("Revise el formulario y complete los datos obligatorios");
    } else {

        var confirma = confirm("Esta seguro de adicionar este examen");
        if (confirma) {

            var datos;
            $.ajax({
                type: "POST",
                url: "../controladores/ExamenController.php",
                async: false,
                dataType: 'json',
                data: {
                    tipo: 10,
                    codigo: codigo,
                    nombre: nombre,
                    precio: precio
                },
                success: function (retu) {
                    datos = retu;
                }
            });

            if (datos == 1) {
                alertify.alert("Se ingreso correctamente el examen", function () {
                    ListaExamenes();
                    $('#myModalExamen').modal('toggle');
                });
            } else if (datos == 2) {
                alertify.alert("Ocurrio un error al tratar de ingresar el examen");
            } else if (datos == 3) {
                alertify.alert("Este examen ya existe, cambielo");
            }

        }

    }

}

function LimpiarExamen() {
    $("#codigo_examen").val();
    $("#nombre_examen").val();
    $("#precio_examen").val();
}


function CargaDataExamenPerfil(id_perfil) {

    var datos;
    $.ajax({
        type: "POST",
        url: "../controladores/ExamenController.php",
        async: false,
        dataType: 'json',
        data: {
            tipo: 11,
            id_perfil: id_perfil

        },
        success: function (retu) {
            datos = retu;
        }
    });
    var datos_perfil = datos[0];
    console.log(datos_perfil);
    $("#grupo_perfil_mod").val(datos_perfil.grupo_id);
    $("#nombre_perfil_mod").val(datos_perfil.nombre);
    $("#codigo_perfil_mod").val(datos_perfil.codigo_crm);
    $("#precio_perfil_mod").val(datos_perfil.precio);
    $("#recomendaciones_perfil_mod").html(datos_perfil.recomendaciones);
    $("#preparacion_perfil_mod").html(datos_perfil.preparacion);
    $("#modi_perf").attr("onclick", "ModificarPerfil(" + id_perfil + ")");


}

function ModificarPerfil(id_perfil) {

    var grupo_id = $.trim($("#grupo_perfil_mod").val());
    var nombre = $.trim($("#nombre_perfil_mod").val());
    var codigo = $.trim($("#codigo_perfil_mod").val());
    var precio = $.trim($("#precio_perfil_mod").val());
    var recomendaciones = $.trim($("#recomendaciones_perfil_mod").val());
    var preparacion = $.trim($("#preparacion_perfil_mod").val());

    if (grupo_id == "" || precio == "" || recomendaciones == "" || preparacion == "" || codigo == "" || nombre == "") {
        alertify.alert("Revise el formulario y complete los datos obligatorios");
    } else {

        var confirma = confirm("Esta seguro de  modificar el perfil");
        if (confirma) {

            var datos;
            $.ajax({
                type: "POST",
                url: "../controladores/ExamenController.php",
                async: false,
                dataType: 'json',
                data: {
                    tipo: 12,
                    grupo_id: grupo_id,
                    nombre: nombre,
                    codigo: codigo,
                    precio: precio,
                    recomendaciones: recomendaciones,
                    preparacion: preparacion,
                    id_perfil: id_perfil
                },
                success: function (retu) {
                    datos = retu;
                }
            });

            if (datos == 1) {
                alertify.alert("Se modifico correctamente el perfil", function () {
                    VerExamenesNoPerfiles();
                    $('#myModalPerfilesMod').modal('toggle');
                });
            } else if (datos == 2) {
                alertify.alert("Ocurrio un error al tratar de modificar el perfil");
            }

        }

    }
}