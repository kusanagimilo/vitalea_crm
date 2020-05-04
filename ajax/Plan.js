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
                '<input type="file" class="custom-file-input" id="archivo" name="archivo">'
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
            } else if (desicion == 2) {
                var archivo = document.getElementById("archivo");
                var formElement = document.getElementById("frm_forms");
                var data = new FormData(formElement);
                var file;
                file = archivo.files[0];
                data.append('archivo', file);
                data.append('tipo', 5);
                data.append('codigo_plan', codigo_plan);
                data.append('nombre_plan', nombre_plan);

                var url = "../controladores/PlanController.php";
                var retorno;
                $.ajax({
                    url: url,
                    type: 'POST',
                    contentType: false,
                    data: data,
                    async: false,
                    processData: false,
                    cache: false
                }).done(function (retu) {
                    retorno = retu;
                });


                if (retorno == 1) {
                    /*alertify.alert("Se ingreso correctamente el plan");*/
                    alertify.alert("Se ingreso correctamente el plan", function () {
                        VerPlanes();
                        $('#myModalPlanes').modal('toggle');
                    });
                } else if (retorno == 2) {
                    alertify.alert("Ocurrio un error al tratar de ingresar el plan");
                } else if (retorno == 3) {
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
            '<th style="color:white">Estado</th>' +
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
                //var botones = "BOTONES";

                let estado;

                var botones = '<input type="button" data-toggle="modal" onclick="LlenarOnclick(' + plan.id_plan + ')" data-target="#myModalPlanesItems"  value="Ver items" class="btn btn-sm btn-default"><br>' +
                        '<input type="button" onclick="InfoPlan(' + plan.id_plan + ')" data-toggle="modal" data-target="#myModalEdtPlan"  value="Editar info plan" class="btn btn-sm btn-info">';

                if (plan.activo == 1) {
                    estado = "Activo";
                } else {
                    estado = "Inactivo";
                }

                var newRow = "<tr>";
                newRow += "<td id='plc_" + plan.id_plan + "'>" + plan.codigo_plan + "</td>";
                newRow += "<td id='pln_" + plan.id_plan + "'>" + plan.nombre_plan + "</td>";
                newRow += "<td id='pln_" + plan.id_plan + "'>" + estado + "</td>";
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

function ListaPlanesVenta() {
    $.ajax({
        url: '../controladores/PlanController.php',
        data: {
            tipo: 8
        },
        type: 'post',
        dataType: 'json',
        success: function (data)
        {


            var select = "<select id='plan_r' name='plan_r'>" +
                    "<option value=''>--selecione un plan --</option>";
            $.each(data, function (i, plan) {

                select += "<option value='" + plan.id_plan + "'>" + plan.codigo_plan + " -- " + plan.nombre_plan + "</option>";

            });
            select += "</select>";

            var tabla = "<table class='table table-responsive'><thead><tr><th colspan='2'>Utilizar plan</th><th>Accion</th></tr></thead>" +
                    "<tbody>" +
                    "<tr>" +
                    "<td>Seleccione uno de los planes disponibles</td>" +
                    "<td>" + select + "</td>" +
                    "<td id='boton_plan'><input type='button' onclick='SeleccionarPlan()' value='Usar plan' class='btn btn-default'></td>" +
                    "</tr>" +
                    "</tbody>";

            tabla += "</table>";
            $("#con_plan").html(tabla);

        }
    });
}

function SeleccionarPlan() {
    var plan_seleccionado = $("#plan_r").val();

    //alert(bono_seleccionado);

    if (plan_seleccionado == "" || plan_seleccionado == null) {
        alert("Seleccione un plan");
    } else {
        $("#plan_seleccionado").val(plan_seleccionado);
        $("#plan_r").attr("disabled", "disabled");
        $("#boton_plan").html("<input type='button' onclick='CambiarPlan()' value='Cambiar plan' class='btn btn-info'>");
        $("#btn_adicionar_plan").attr("data-toggle", "modal");
        $("#btn_adicionar_plan").attr("data-target", "#myModalResultados");
    }
}

function CambiarPlan() {
    if ($("#examenes_agregados").length == 0) {
        $("#plan_seleccionado").val("NO");
        $("#boton_plan").html("<input type='button' onclick='SeleccionarPlan()' value='Usar plan' class='btn btn-default'>");
        $("#plan_r").removeAttr("disabled");
        $("#btn_adicionar_plan").removeAttr("data-toggle");
        $("#btn_adicionar_plan").removeAttr("data-target");
    } else {
        alert("Debe eliminar todos los examenes agregados para cambiar de plan");
    }

}

function RevisaSeleccionPlan() {

    if ($("#plan_seleccionado").val() == "NO") {
        alert("Debe usar un plan para poder adicionar examenes");
    } else {
        obtener_examen();
    }
}

function LlenarOnclick(id_plan) {
    $("#ver_itm_pl").attr("onclick", "ItemsPorPlan(" + id_plan + ")");
    $("#tipo_item").val("");
    $("#tabla_items_int").html("");
}

function ItemsPorPlan(id_plan) {

    var tipo_item = $("#tipo_item").val();

    if (tipo_item == "") {
        alert("Seleccione una opcion");
    } else {

        $("#tabla_items_int").html("");

        $("#lista_itemp_cot_body").html("");

        var tabla = '<table id="lista_itemp_cot" class="table table-bordered">' +
                '<thead>' +
                '<tr style="background-color: #214761;">' +
                '<th style="color:white">Codigo item</th>' +
                '<th style="color:white">Nombre item</th>' +
                '<th style="color:white">Precio regular</th>' +
                '<th style="color:white">Precio plan</th>' +
                '<th style="color:white">Editar precio plan</th>' +
                '</tr>' +
                '</thead>' +
                '<tbody id="lista_itemp_cot_body">' +
                '</tbody>' +
                '</table>';

        $("#tabla_items_int").html(tabla);

        var data;
        $.ajax({
            type: "POST",
            url: "../controladores/PlanController.php",
            async: false,
            dataType: 'json',
            data: {
                tipo: 3,
                id_plan: id_plan,
                tipo_item: tipo_item
            },
            success: function (retu) {
                $.each(retu, function (i, plan) {

                    var precio = '"' + plan.precio_plan + '"';
                    var boton = "<input type='button' onclick='InicioEdicion(" + plan.id_plan_item + "," + precio + ")' value='editar' class='btn btn-default'>";

                    var newRow = "<tr>";
                    newRow += "<td id='plic_" + plan.id_plan_item + "'>" + plan.codigo + "</td>";
                    newRow += "<td id='plin_" + plan.id_plan_item + "'>" + plan.nombre + "</td>";
                    newRow += "<td id='plipr_" + plan.id_plan_item + "'>" + plan.precio_regular + "</td>";
                    newRow += "<td id='plipp_" + plan.id_plan_item + "'>" + plan.precio_plan + "</td>";
                    newRow += "<td id='plib_" + plan.id_plan_item + "'>" + boton + "</td>";
                    newRow += "</tr>";

                    $(newRow).appendTo("#lista_itemp_cot_body");
                });
            }
        });



        var tabla = $('#lista_itemp_cot').DataTable({
            responsive: true
        });
    }
}
function InicioEdicion(id_plan_item, precio) {

    var html_botones = "<input type='button' class='btn btn-primary' value='Editar' onclick='EditarItemPlan(" + id_plan_item + ")'>" +
            "<input type='button' class='btn btn-danger' value='Cancelar' onclick='CancelarEdicion(" + id_plan_item + "," + precio + ")'>";
    var html_campo = "<input type='text' value='" + precio + "' placeholder='precio item' id='precio_item_" + id_plan_item + "' name='precio_item_" + id_plan_item + "'>"
    $("#plib_" + id_plan_item + "").html(html_botones);
    $("#plipp_" + id_plan_item + "").html(html_campo);
}
function CancelarEdicion(id_plan_item, precio) {
    var html_botones = "<input type='button' onclick='InicioEdicion(" + id_plan_item + "," + precio + ")' value='editar' class='btn btn-default'>";
    $("#plib_" + id_plan_item + "").html(html_botones);
    $("#plipp_" + id_plan_item + "").html(precio);
}

function EditarItemPlan(id_plan_item) {
    var confirma = confirm("Esta seguro de realizar esta accion");
    if (confirma) {
        var precio_item = $("#precio_item_" + id_plan_item + "").val();
        if ($.trim(precio_item) == "") {
            alert("Debe ingresar un valor");
        } else {
            var datos;
            $.ajax({
                type: "POST",
                url: "../controladores/PlanController.php",
                async: false,
                dataType: 'json',
                data: {
                    tipo: 4,
                    id_plan_item: id_plan_item,
                    precio: precio_item
                },
                success: function (retu) {
                    datos = retu;
                }
            });

            if (datos == 1) {
                /*alertify.alert("Se ingreso correctamente el plan");*/
                alertify.alert("Se modifico correctamente el plan", function () {
                    CancelarEdicion(id_plan_item, precio_item);
                });
            } else if (datos == 2) {
                alertify.alert("Ocurrio un error al tratar de modificar el plan");
            }
        }
    }

}

function EditarInfoPlan(id_plan) {
    var codigo_plan = $("#edt_codigo_plan").val();
    var nombre_plan = $("#edt_nombre_plan").val();
    var estado_plan = $("#edt_estado_plan").val();


    if (codigo_plan == "" || nombre_plan == "" || estado_plan == "") {
        alertify.alert("Revise el formulario y complete los datos obligatorios");
    } else {

        var confirma = confirm("Esta seguro de modificar este plan");
        if (confirma) {

            var archivo = document.getElementById("archivo_edt");
            var formElement = document.getElementById("frm_forms_edt");
            var data = new FormData(formElement);
            var file;
            file = archivo.files[0];
            data.append('archivo_edt', file);
            data.append('tipo', 7);
            data.append('id_plan', id_plan);
            data.append('codigo_plan', codigo_plan);
            data.append('nombre_plan', nombre_plan);
            data.append('estado_plan', estado_plan);

            var url = "../controladores/PlanController.php";
            var retorno;
            $.ajax({
                url: url,
                type: 'POST',
                contentType: false,
                data: data,
                async: false,
                processData: false,
                cache: false
            }).done(function (retu) {
                retorno = retu;
            });

            if (retorno == 1) {
                /*alertify.alert("Se ingreso correctamente el plan");*/
                alertify.alert("Se modifico correctamente el plan", function () {
                    VerPlanes();
                    $('#myModalEdtPlan').modal('toggle');
                });
            } else if (retorno == 2) {
                alertify.alert("Ocurrio un error al tratar de modificar el plan");
            } else if (retorno == 3) {
                alertify.alert("Este plan ya existe, cambielo");
            }
        }

    }
}

function InfoPlan(id_plan) {
    $("#edt_codigo_plan").val("");
    $("#edt_nombre_plan").val("");
    $("#archivo_edt").val("");

    var datos;
    $.ajax({
        type: "POST",
        url: "../controladores/PlanController.php",
        async: false,
        dataType: 'json',
        data: {
            tipo: 6,
            id_plan: id_plan
        },
        success: function (retu) {
            datos = retu;
        }
    });

    $("#edt_btn_plan").attr("onclick", "EditarInfoPlan(" + datos.id_plan + ")");
    $("#edt_codigo_plan").val(datos.codigo_plan);
    $("#edt_nombre_plan").val(datos.nombre_plan);
    $("#edt_estado_plan").val(datos.activo);
}