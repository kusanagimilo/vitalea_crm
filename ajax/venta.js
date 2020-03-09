document.addEventListener("DOMContentLoaded", function (event) {
    showFieldHabeasData();
});

/* INFORMACION DEL CLIENTE */

function informacion_cliente() {

    var id_cliente = $("#cliente_id").val();

    $.ajax({
        url: '../controladores/Gestion.php',
        data:
        {
            tipo: 4,
            id_cliente: id_cliente
        },
        type: 'post',
        dataType: 'json',
        success: function (data) {
            $.each(data, function (i, cliente) {
                var newRow = "<table class='tinfo table table-striped'  >";
                newRow += "<tr><th style='color:#0C4F5A;text-align: left;'><b>Tipo de documento</b></th><td data-label='Tipo documento'>" + cliente.tipo_documento + "</td>";
                newRow += "<th style='color:#0C4F5A;text-align: left;'><b>N° Documento</th><td data-label='N° Documento'>" + cliente.documento + "</b></td>";
                newRow += "<th style='color:#0C4F5A;text-align: left;'><b>Nombre Completo</b></th><td data-label='Nombre Completo'>" + cliente.nombre_cliente + " " + cliente.apellido_cliente + "</td></tr>";
                newRow += "<tr><th style='color:#0C4F5A;text-align: left;'><b>Fecha de Nacimiento</b></th><td data-label='Fecha de Nacimiento'>" + cliente.fecha_nacimiento + "</td>";
                newRow += "<th style='color:#0C4F5A;text-align: left;'><b>Email</th><td data-label='Email'>" + cliente.email + "</b></td>";
                newRow += "<th style='color:#0C4F5A;text-align: left;'><b>Telefono 1</b></th><td data-label='Telefono 1'>" + cliente.telefono_1 + "</td></tr>";
                newRow += "<tr><th style='color:#0C4F5A;text-align: left;'><b>Telefono 2</th><td data-label='Telefono 2'>" + cliente.telefono_2 + "</b></td>";
                newRow += "<th style='color:#0C4F5A;text-align: left;'><b>Departamento</b></th><td data-label='Departamento'>" + cliente.departamento + "</td>";
                newRow += "<th style='color:#0C4F5A;text-align: left;'><b>Ciudad</th><td data-label='Ciudad'>" + cliente.ciudad + "</b></td></tr>";
                newRow += "<tr><th style='color:#0C4F5A;text-align: left;'><b>Barrio</b></th><td data-label='Barrio'>" + cliente.barrio + "</td>";
                newRow += "<th style='color:#0C4F5A;text-align: left;'><b>Dirección</th><td data-label='Dirección'>" + cliente.direccion + "</b></td>";
                newRow += "<th style='color:#0C4F5A;text-align: left;'><b>Estado civil</b></th><td data-label='Estado civil'>" + cliente.estado_civil + "</td></tr>";
                newRow += "<tr><th style='color:#0C4F5A;text-align: left;'><b>Sexo</th><td data-label='Sexo'>" + cliente.sexo + "</b></td>";
                newRow += "<th style='color:#0C4F5A;text-align: left;'><b>Estrato</b></th><td data-label='Estrato'>" + cliente.estrato + "</td>";
                newRow += "<th style='color:#0C4F5A;text-align: left;'><b>Estado</th><td data-label='Estado' style='color:#079244'><b>" + cliente.estado_cliente + "</b></td></tr>";
                newRow += "<th style='color:#0C4F5A;text-align: left;'><b>Tipo cliente</th><td data-label='Tipo cliente' style='color:#079244'><b>" + cliente.tipo_cliente + "</b></td>";
                newRow += "<th style='color:#0C4F5A;text-align: left;'><b>Clasificacion</th><td data-label='Clasificacion' style='color:#079244'><b>" + cliente.clasificacion + "</b></td></tr>";
                newRow += "</table>";
                var nombre_cliente = "<b>" + cliente.nombre_cliente + " " + cliente.apellido_cliente + "</b>";
                $(newRow).appendTo("#tabla_informacion_cliente");
                $(nombre_cliente).appendTo("#nombre_cliente");
                sessionStorage.setItem('nombreCliente', cliente.nombre_cliente + " " + cliente.apellido_cliente);
                sessionStorage.setItem('documento', cliente.tipo_documento + ": " + cliente.documento);
                sessionStorage.setItem('documentoNumero', cliente.documento);
                sessionStorage.setItem('firma', cliente.firma);


                const btnpdf = document.querySelector("#btnHabeas");
                btnpdf.addEventListener("click", () => {
                    const firmaComprobacion = sessionStorage.getItem('firma').substr(0, 1);

                    if (firmaComprobacion != "d") {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Generacion PDF Fallida',
                            text: 'No se completo la operacion debido a que no hay registros de firmas, guardados en la base de datos!',
                            footer: '<a target="_blank" href="https://wa.me/573506793449">¿Algun problema con el CRM?, Contacta a Soporte.</a>',
                            allowOutsideClick: false
                        });

                    } else {
                        generarPdf();
                    }
                })

            });

        }
    });
}




function obtener_categoria_examen() {

    $.ajax({
        url: '../controladores/Gestion.php',
        data:
        {
            tipo: 13
        },
        type: 'post',
        dataType: 'json',
        success: function (data) {

            $("#examen_categoria_venta").empty();
            $("#examen_categoria_venta").append("<option value=''>---Seleccione----</option>");
            $.each(data, function (i, cliente) {
                var newRow = "<option value='" + cliente.id + "'>" + cliente.nombre + "</option>";
                $(newRow).appendTo("#examen_categoria_venta");

            });
        }
    });
}



function obtener_examen() {
    var examen_sub_categoria = $("#examen_categoria_venta").val();

    $.ajax({
        url: '../controladores/Gestion.php',
        data:
        {
            tipo: 14,
            categoria_id: examen_sub_categoria
        },
        type: 'post',
        dataType: 'json',
        success: function (data) {

            $('#examen_descripcion_venta').html("<option value=''> - </option>");

            $("#div_preparacion").hide();
            $("#examen_precios").hide();

            $.each(data, function (i, cliente) {
                var newRow = "<option value='" + cliente.id + "'>" + cliente.nombre + "</option>";
                $(newRow).appendTo("#examen_descripcion_venta");

            });
        }
    });
}


function obtener_examen_precios() {
    var examen_descripcion_venta = $("#examen_descripcion_venta").val();

    $.ajax({
        url: '../controlador/Caja.php',
        data:
        {
            tipo: 2,
            examen_id: examen_descripcion_venta
        },
        type: 'post',
        dataType: 'json',
        success: function (data) {
            /*var bono;
             
             if ($("#bono_seleccionado").val() != "" || $("#bono_seleccionado").val() != null) {
             bono = $('#bono_seleccionado').val();
             } else {
             bono = "no_seleccionado";
             }*/

            $("#examen_precios").empty();
            $("#preparacion").empty();
            $("#div_preparacion").show();
            $("#examen_precios").show();

            $.each(data, function (i, precio) {
                var newRow = "<table class='table table-striped'>";
                newRow += "<tr><th colspan='3'>Seleccion de Precios</th></tr>";

                newRow += "<tr><td style='width:10px;' > <input type='radio' value='1_" + precio.precio + "' name='examen_precio'> </td><th>Precio</th><td>" + precio.precio + "</td></tr>";

                /*if (bono != "NO") {
                 
                 var bono_arr = bono.split("-");
                 if (bono_arr[1] == "5000") {
                 newRow += "<tr><td style='width:10px;'> <input type='radio' value='2_" + precio.precio_menos_cinco + "' name='examen_precio'> </td><th>Precio $5.000 Dto. </th><td>$" + precio.precio_menos_cinco + "</td></tr>";
                 } else if (bono_arr[1] == "10000") {
                 newRow += "<tr><td style='width:10px;'> <input type='radio' value='3_" + precio.precio_menos_diez + "' name='examen_precio'> </td><th>Precio $10.000 Dto.</th><td>$" + precio.precio_menos_diez + "</td></tr>";
                 }
                 newRow += "</table>";
                 } else {
                 newRow += "<tr><td style='width:10px;' > <input type='radio' value='1_" + precio.precio + "' name='examen_precio'> </td><th>Precio Full</th><td>" + precio.precio + "</td></tr>";
                 }*/

                var preparacion = "<p>" + precio.preparacion + "</p>";

                $(newRow).appendTo("#examen_precios");
                $(preparacion).appendTo("#preparacion");

            });
        }
    });
}

// AGREGAR VENTA TEMPORAL
function agregarVentaTemp() {

    var tipo_examen = $('.i-checks:checked').val();

    var examen_id = "";
    var precio = "";

    if (typeof tipo_examen === 'undefined') {
        alertify.alert("Seleccione <b>Tipo de Examen</b>");
        return false;
    }

    if (tipo_examen == 1) { //Perfiles
        examen_id = $("#examen_descripcion_venta").val();
        precio = $('input:radio[name=examen_precio]:checked').val();


        if (typeof precio === 'undefined') {
            alertify.alert(" Seleccione uno de los precios");
            return false;
        }

        if ($("#td_perfil_" + examen_id + "").length) {
            alertify.alert("El examen ya ha sido agregado");
            return false;
        }


    } else if (tipo_examen = 2) { // No perfiles
        examen_id = $("#examen_no_perfil").val();
        precio = $("#precio_examen_no_perfil").val();

        if ($("#td_no_perfil_" + examen_id + "").length) {
            alertify.alert("El examen ya ha sido agregado");
            return false;
        }
    }



    var cliente_id = $("#cliente_id").val();
    var gestion_id = $("#gestion_id").val();


    if (examen_id.length == 0) {
        alertify.alert(" Realice la selección del examen");
        return false;
    }


    $.ajax({
        url: '../controlador/Caja.php',
        data:
        {
            tipo: 3,
            examen_id: examen_id,
            precio: precio,
            gestion_id: gestion_id,
            cliente_id: cliente_id,
            tipo_examen: tipo_examen
        },
        type: 'post',
        success: function (data) {

            alertify.success("Examen agregado");
            tablaTemporalInicial();
        }
    });
}

// VISTA INICIAL DE TABLA TEMPORAL

function tablaTemporalInicial() {
    var cliente_id = $("#cliente_id").val();
    var gestion_id = $("#gestion_id").val();

    $.ajax({
        url: '../controlador/Caja.php',
        data:
        {
            tipo: 4,
            gestion_id: gestion_id,
            cliente_id: cliente_id
        },
        type: 'post',
        success: function (data) {
            $("#tabla_temporal").html(data);
        }
    });
}

//ELIMINAR EXAMEN DE TABLA TEMPORAL

function eliminar(element) {

    $.ajax({
        url: '../controlador/Caja.php',
        data:
        {
            tipo: 5,
            examen_id: element
        },
        type: 'post',
        success: function (data) {
            tablaTemporalInicial();
        }
    });

}

// VISTA DE COTIZACION 

function mostrarCotizacion() {
    $("#evento_cotizacion").show();
    $("#evento_venta").hide();
}

//MOSTRAR VENTA
function mostrarVenta() {
    $("#evento_venta").show();
    $("#evento_cotizacion").hide();
}

//LISTA MEDIO DE COMUNICACION

function medios_comunicacion() {

    $.ajax({
        url: '../controladores/Gestion.php',
        data:
        {
            tipo: 3
        },
        type: 'post',
        dataType: 'json',
        success: function (data) {
            $.each(data, function (i, cliente) {
                var newRow = "<option value='" + cliente.id + "'>" + cliente.nombre + "</option>";

                $(newRow).appendTo("#medios_comunicacion");
            });

        }
    });
}


// MEDIO DE COMUNICACION DIV

function div_medio_comunicacion() {
    var medio_comunicacion_id = $("#medios_comunicacion").val();

    if (medio_comunicacion_id < 8) {
        $.ajax({
            url: '../controladores/Gestion.php',
            data:
            {
                tipo: 12,
                medio_comunicacion_id: medio_comunicacion_id

            },
            type: 'post',
            dataType: 'json',
            success: function (data) {
                $("#imagen_medio_comunicacion").empty();
                $("#texto_comunicacion").empty();

                $.each(data, function (i, cliente) {
                    var texto = "<b>" + cliente.texto + "</b>";
                    var imagen = "<img src='" + cliente.imagen + "'>";
                    $(imagen).appendTo("#imagen_medio_comunicacion");
                    $(texto).appendTo("#texto_comunicacion");
                });

            }
        });
        $("#medio_chat").css("display", "block");
    } else {
        $("#medio_chat").css("display", "none");
        $("#imagen_medio_comunicacion").css("display", "none");
        $("#texto_comunicacion").css("display", "none");
    }


}

// GENERAR COTIZACION

function generarCotizacion() {


    $('#ModalCargando').modal({ backdrop: 'static', keyboard: false });



    var cliente_id = $("#cliente_id").val();
    var gestion_id = $("#gestion_id").val();
    var permiso = $("#permiso").val();
    var usuario_id = $("#usuario_id").val();
    var email = $("#email").val();
    var observacion_cotizacion = $("#observacion_cotizacion").val();

    //medio de comunicacion
    if (permiso == 1) {

        medios_comunicacion = $("#medios_comunicacion").val();


        if (typeof medios_comunicacion === 'undefined') {
            alertify.alert("Seleccion el medio de comunicacion");
        } else {
            if (medios_comunicacion < 8) {
                mensaje = $("#mensaje").val();
            }
        }
    } else {
        medios_comunicacion = 11;
    }


    if (email.length == 0) {
        alertify.alert("Ingrese un correo valido");
    } else {

        $.ajax({
            url: '../controlador/Caja.php',
            data:
            {
                tipo: 7,
                cliente_id: cliente_id,
                gestion_id: gestion_id,
                usuario_id: usuario_id,
                email: email,
                medios_comunicacion: medios_comunicacion,
                observacion_cotizacion: observacion_cotizacion

            },
            type: 'post',
            success: function (data) {
                $('#ModalCargando').modal('toggle');
                if (data == 1) {
                    alertify.alert("Cotizacion enviada a <b>" + email + "</b>", function () {
                        window.location.href = "inicio_usuario.php";
                    });
                } else if (data == 2) {
                    alertify.alert("Seleccione al menos un examen para realizar la cotizacion");
                }

            }
        });
    }
}


// GUARDAR VENTA 
function agregarVenta() {
    var cliente_id = $("#cliente_id").val();
    var gestion_id = $("#gestion_id").val();
    var permiso = $("#permiso").val();
    var usuario_id = $("#usuario_id").val();
    var medio_pago = $('input:radio[name=medio_pago]:checked').val();
    var observacion_venta = $("#observacion_venta").val();
    var email_venta = $("#email_venta").val();
    var plan_seleccionado = $("#plan_seleccionado").val();

    //medio de comunicacion
    if (permiso == 1) {

        medios_comunicacion = $("#medios_comunicacion").val();


        if (typeof medios_comunicacion === 'undefined') {
            alertify.alert("Seleccion el medio de comunicacion");
        } else {
            if (medios_comunicacion < 8) {
                mensaje = $("#mensaje").val();
            }
        }
    } else {
        medios_comunicacion = 11;
    }


    if (typeof medio_pago === 'undefined') {
        alertify.alert("Seleccione el medio de pago");
    } else {

        $('#ModalCargando').modal({ backdrop: 'static', keyboard: false });
        $.ajax({
            url: '../controlador/Caja.php',
            data:
            {
                tipo: 6,
                cliente_id: cliente_id,
                gestion_id: gestion_id,
                usuario_id: usuario_id,
                medio_pago: medio_pago,
                medios_comunicacion: medios_comunicacion,
                observacion_venta: observacion_venta,
                email_venta: email_venta,
                plan_seleccionado: plan_seleccionado

            },
            type: 'post',
            beforeSend: function () {
                //$('#ModalCargando').modal({backdrop: 'static', keyboard: false});
            },
            success: function (data) {
                $('#ModalCargando').modal('toggle');
                //$('#div_cargando').css('background', 'none')
                if (data == 1) {
                    alertify.alert("Codigo de Confirmacion de Examenes enviada a " + email_venta, function () {
                        window.location.href = "inicio_usuario.php";
                    });
                } else if (data == 2) {
                    alertify.alert("Seleccione al menos un examen para realizar la venta");
                }

            }
        });


    }

}

function obtenerExamenNoPerfil() {
    $.ajax({
        url: '../controladores/Gestion.php',
        data:
        {
            tipo: 28
        },
        type: 'post',
        dataType: 'json',
        success: function (data) {

            $("#examen_no_perfil").empty();

            $.each(data, function (i, examen) {
                $("#examen_no_perfil").append("<option value='" + examen.id + "'>" + examen.nombre + "</option>");
                /*var newRow ="<option value='"+examen.id+"'>"+examen.nombre+"</option>";
                 $(newRow).appendTo("#examen_no_perfil");*/

            });
        }
    });
}

function obtenerPrecioExamenNoPerfil() {
    var examen_no_perfil = $("#examen_no_perfil").val();
    $.ajax({
        url: '../controladores/Gestion.php',
        data:
        {
            tipo: 29,
            examen_no_perfil: examen_no_perfil
        },
        type: 'post',
        success: function (data) {
            $("#precio_examen_no_perfil").val(data);
        }
    });

}

function obtener_examen2() {
    var examen_sub_categoria = $("#examen_categoria_venta").val();
    var id_plan = $("#plan_seleccionado").val();

    $.ajax({
        url: '../controladores/Gestion.php',
        data:
        {
            tipo: 33,
            categoria_id: examen_sub_categoria,
            id_plan: id_plan
        },
        type: 'post',
        dataType: 'json',
        success: function (data) {

            $('#examen_descripcion_venta').html("<option value=''> - </option>");

            $("#div_preparacion").hide();
            $("#examen_precios").hide();

            $.each(data, function (i, cliente) {
                var newRow = "<option value='" + cliente.id + "'>" + cliente.nombre + "</option>";
                $(newRow).appendTo("#examen_descripcion_venta");

            });
        }
    });
}


function obtener_examen_precios2() {
    var examen_descripcion_venta = $("#examen_descripcion_venta").val();
    var plan = $("#plan_seleccionado").val();
    $.ajax({
        url: '../controlador/Caja.php',
        data:
        {
            tipo: 8,
            examen_id: examen_descripcion_venta,
            id_plan: plan
        },
        type: 'post',
        dataType: 'json',
        success: function (data) {


            $("#examen_precios").empty();
            $("#preparacion").empty();
            $("#div_preparacion").show();
            $("#examen_precios").show();

            $.each(data, function (i, precio) {
                var newRow = "<table class='table table-striped'>";
                newRow += "<tr><th colspan='3'>Seleccion de Precios</th></tr>";

                newRow += "<tr><td style='width:10px;' > <input type='radio' value='1_" + precio.precio + "' name='examen_precio'> </td><th>Precio</th><td>" + precio.precio + "</td></tr>";

                var preparacion = "<p>" + precio.preparacion + "</p>";

                $(newRow).appendTo("#examen_precios");
                $(preparacion).appendTo("#preparacion");

            });
        }
    });
}

function obtenerPrecioExamenNoPerfil2() {
    var examen_no_perfil = $("#examen_no_perfil").val();
    var id_plan = $("#plan_seleccionado").val();
    $.ajax({
        url: '../controladores/Gestion.php',
        data:
        {
            tipo: 34,
            examen_no_perfil: examen_no_perfil,
            id_plan: id_plan
        },
        type: 'post',
        success: function (data) {
            $("#precio_examen_no_perfil").val(data);
        }
    });

}

function generarPdf() {
    const firma = sessionStorage.getItem('imagenCadena');
    // Funcion para la creacion del PDF, utilizando la libreria JSPDF.
    let nombreCliente = sessionStorage.getItem('nombreCliente');
    let docu = sessionStorage.getItem('documento');
    var imgData = new Image();
    imgData.src = "../images/habeasData.png";
    var imgData2 = new Image();
    imgData2.src = "../images/vitaleaPdf2.png";
    // console.log(firma);

    var doc = new jsPDF();
    doc.addImage(firma, 'png', 134, 215, 80, 26);
    doc.addImage(imgData, 'png', 2, 1, 205, 190);
    doc.setFontSize(10);
    doc.setFont("helvetica");
    doc.setTextColor(0, 24, 0);
    doc.text(5, 230, "Nombre: " + nombreCliente);
    doc.text(55, 230, docu);
    doc.text(125, 230, "Firma: ");

    doc.setDrawColor(0);
    doc.addImage(imgData2, 'JPG', 132, 272, 80, 26, 'right');
    doc.setFillColor(133, 0, 144);
    doc.rect(0, 272, 132, 26, 'F');

    doc.setProperties({
        //Metadatos del documento
        title: 'Cotizaciones Vitalea',
        subject: 'Documento de Cotizaciones vitalea',
        author: 'Arcos Soluciones Tecnologicas',
        keywords: 'generated, javascript, web 2.0, ajax',
        creator: 'Alexander Pineda - Desarrollador'
    });
    // Funcion Generadora del PDF
    doc.save('detallePerfilCliente.pdf');
}

function showFieldHabeasData() {
    setTimeout(() => {
        var documentoFirma = sessionStorage.getItem('documentoNumero');
        const fielHabeasData = document.querySelector("#fieldHabeasData");
        $.ajax({
            type: "POST",
            url: "../controladores/FacturacionController.php",
            async: false,
            dataType: 'json',
            data: {
                tipo: 20,
                inputIdValue: documentoFirma
            },
            success: function (retu) {
                let firmaParametro = retu[0].firma
                if (firmaParametro === null || firmaParametro === "null") {
                    var condicional = 0;    
                } else {
                    var condicional = firmaParametro.toString();
                    var condicionalStr = condicional.substr(0, 4);                    
                }
                if (condicionalStr === "data") {
                    fielHabeasData.setAttribute("style", "display: none");
                } else {
                    fielHabeasData.setAttribute("style", "display: block");    
                }
            }
        });
    }, 500);
}
