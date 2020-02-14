$(document).ready(function ()
{

    $('input:radio[name=opcion_tarifa]').change(function () {
        var tipo_cambio = ($('input:radio[name=opcion_tarifa]:checked').val());
        CambiarTipoTarifa(tipo_cambio)
    });

});


function CambiarTipoTarifa(tipo_cambio) {
    var html = "";
    if (tipo_cambio == 1)
    {
        html = "<h4><span class='label label-info'>ESTA OPCION PERMITE CARGAR AUTOMATICAMENTE TODAS LAS TARIFAS QUE EXISTEN EN EL SISTEMA, LUEGO SE PODRA MODIFICAR EL VALOR DE CADA UNO DE LOS ITEMS DE ESTE PLAN</span></h4>";
    } else if (tipo_cambio == 2) {
        html = '<label for="inputtext">* Seleccione el archivo csv de tarifas</label>' +
                '<input type="file" class="custom-file-input" id="csv_carga">'
    }

    $("#desicion").html(html);
}

function AlmacenarPlan() {


    var codigo_plan = $("#codigo_plan").val();
    var nombre_plan = $("#nombre_plan").val();
    var desicion = $('input:radio[name=opcion_tarifa]:checked').val();

    if (codigo_plan == "" || nombre_plan == "" || desicion == "") {
        alertify.alert("Revise el formulario y complete los datos obligatorios");
    } else {

        var confirma = confirm("Esta seguro de crear este plan");
        if (confirma) {

            if (desicion == 1) {

                var datos;
                $.ajax({
                    type: "POST",
                    url: "../controladores/PlanController.php",
                    async: false,
                    dataType: 'json',
                    data: {
                        tipo: 1,
                        codigo_plan: codigo_plan,
                        nombre_plan: nombre_plan
                    },
                    success: function (retu) {
                        datos = retu;
                    }
                });

                if (datos == 1) {
                    /*alertify.alert("Se ingreso correctamente el plan");*/
                    alertify.alert("Se ingreso correctamente el plan", function () {
                        VerPlanes();
                        $('#myModalPlanes').modal('toggle');
                    });
                } else if (datos == 2) {
                    alertify.alert("Ocurrio un error al tratar de ingresar el plan");
                } else if (datos == 3) {
                    alertify.alert("Este plan ya existe, cambielo");
                }
            }
        }

    }
}

function VerPlanes() {
    $("#lista_planes_cot_body").html("");

    var tabla = '<table id="lista_planes_cot" class="table table-bordered">' +
            '<thead>' +
            '<tr style="background-color: #214761;">' +
            '<th style="color:white">Codigo plan</th>' +
            '<th style="color:white">Nombre plan</th>' +
            '<th style="color:white">Acciones</th>' +
            '</tr>' +
            '</thead>' +
            '<tbody id="lista_planes_cot_body">' +
            '</tbody>' +
            '</table>';

    $("#tabla_planes").html(tabla);

    var data;
    $.ajax({
        type: "POST",
        url: "../controladores/PlanController.php",
        async: false,
        dataType: 'json',
        data: {
            tipo: 2
        },
        success: function (retu) {
            $.each(retu, function (i, plan) {
                var botones = "BOTONES";

                /*var botones = '<input type="button" data-toggle="modal" data-target="#myModalPerfilesMod" onclick="CargaDataExamenPerfil(' + nperfil.id + ')" value="Modificar perfil" class="btn btn-sm btn-default"><br>' +
                 '<input type="button" data-toggle="modal" data-target="#myModalResultados" onclick="VerExamenesPorPerfil(' + nperfil.id + ')" value="Ver y adicionar examenes" class="btn btn-sm btn-primary">';*/
                //var btn_prueba = "<input value='pdf_prueba' type='button' class='btn btn-sm btn-danger' onclick='pfdprueba(" + ventas.id_venta + ")'>";

                var newRow = "<tr>";
                newRow += "<td id='plc_" + plan.id_plan + "'>" + plan.codigo_plan + "</td>";
                newRow += "<td id='pln_" + plan.id_plan + "'>" + plan.nombre_plan + "</td>";
                newRow += "<td id='plb_" + plan.id_plan + "'>" + botones + "</td>";
                newRow += "</tr>";

                $(newRow).appendTo("#lista_planes_cot_body");
            });
        }
    });



    var tabla = $('#lista_planes_cot').DataTable({
        responsive: true
    });
}

