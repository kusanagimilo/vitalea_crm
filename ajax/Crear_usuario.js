function listar_tipo_documento() {

    $.ajax({
        url: '../controladores/Cliente.php',
        data:
                {
                    tipo: 1
                },
        type: 'post',
        dataType: 'json',
        success: function (data)
        {

            $.each(data, function (i, cliente) {
                var newRow = "<option value='" + cliente.id + "' >" + cliente.nombre + "</option>";
                $(newRow).appendTo(".tipo_documento");
            });


        }
    });
}


function listar_estado_civil() {

    $.ajax({
        url: '../controladores/Cliente.php',
        data:
                {
                    tipo: 2
                },
        type: 'post',
        dataType: 'json',
        success: function (data)
        {

            $.each(data, function (i, cliente) {
                var newRow = "<option value='" + cliente.id + "'>" + cliente.nombre + "</option>";
                $(newRow).appendTo("#estado_civil");
            });


        }
    });
}


function listar_parentesco() {

    $.ajax({
        url: '../controladores/Cliente.php',
        data:
                {
                    tipo: 8
                },
        type: 'post',
        dataType: 'json',
        success: function (data)
        {

            $.each(data, function (i, cliente) {
                var newRow = "<option value='" + cliente.id + "'>" + cliente.nombre + "</option>";
                $(newRow).appendTo("#parentesco");
            });


        }
    });
}
function listar_departamento() {

    $.ajax({
        url: '../controladores/Cliente.php',
        data:
                {
                    tipo: 3
                },
        type: 'post',
        dataType: 'json',
        success: function (data)
        {

            $.each(data, function (i, cliente) {
                var newRow = "<option value='" + cliente.id + "'>" + cliente.nombre + "</option>";
                $(newRow).appendTo("#departamento");
            });


        }
    });
}

function listar_ciudad() {
    var departamento_id = $("#departamento").val();


    $.ajax({
        url: '../controladores/Cliente.php',
        data:
                {
                    tipo: 4,
                    departamento_id: departamento_id
                },
        type: 'post',
        dataType: 'json',
        success: function (data)
        {

            $.each(data, function (i, cliente) {
                var newRow = "<option value='" + cliente.id + "'>" + cliente.nombre + "</option>";
                $(newRow).appendTo("#ciudad");
            });


        }
    });
}

function listar_seccion_direccion() {
    $.ajax({
        url: '../controladores/Cliente.php',
        data:
                {
                    tipo: 7
                },
        type: 'post',
        dataType: 'json',
        success: function (data)
        {

            $.each(data, function (i, cliente) {

                var newRow = "<option value='" + cliente.id + "'>" + cliente.nombre + "</option>";
                $(newRow).appendTo(".seccion");
            });


        }
    });
}



function armar_direccion() {
    var seccion_uno = $("#seccion_uno").val();
    var numero_uno = $("#numero_uno").val();
    /*var seccion_dos = $("#seccion_dos").val();
     var numero_dos = $("#numero_dos").val();
     var seccion_tres = $("#seccion_tres").val();
     var adicional = $("#adicional").val();*/
    $("#direccion").val(seccion_uno + " " + numero_uno);

    // $("#direccion").val(seccion_uno + " " + numero_uno + " " + seccion_dos + " " + numero_dos + " " + seccion_tres + " " + adicional);
}

function actualizar_paciente() {
    var tipo_cliente = $('.i-checks:checked').val();

    var tipo_documento = $("#tipo_documento").val();
    var numero_documento = $("#numero_documento").val();
    var nombre = $("#nombre").val();
    var apellido = $("#apellido").val();
    var fecha_nacimiento = $("#fecha_nacimiento").val();
    var estado_civil = $("#estado_civil").val();
    var telefono_uno = $("#telefono_uno").val();
    var telefono_dos = $("#telefono_dos").val();
    var email = $("#email").val();
    var ciudad = $("#ciudad").val();
    var barrio = $("#barrio").val();
    var direccion = $("#direccion").val();
    var sexo = $("#sexo").val();
    var estrato = $("#estrato").val();


    var tipo_documento_tercero = "";
    var numero_documento_tercero = "";
    var nombre_tercero = "";
    var apellido_tercero = "";
    var fecha_nacimiento_tercero = "";
    var sexo_tercero = "";
    var parentesco = "";

    if (tipo_cliente == "Tercero") {
        tipo_documento_tercero = $("#tipo_documento_tercero").val();
        numero_documento_tercero = $("#numero_documento_tercero").val();
        nombre_tercero = $("#nombre_tercero").val();
        apellido_tercero = $("#apellido_tercero").val();
        fecha_nacimiento_tercero = $("#fecha_nacimiento_tercero").val();
        sexo_tercero = $("#sexo_tercero").val();
        parentesco = $("#parentesco").val();


        if (tipo_documento_tercero.length == 0) {
            alertify.alert("Seleccione un <b>Tipo de documento</b>");
            return false;
        } else if (numero_documento_tercero.length == 0) {
            alertify.alert("Ingrese el <b>Numero de Documento</b>");
            return false;
        } else if (nombre_tercero.length == 0) {
            alertify.alert("Ingrese <b>Nombre</b>");
            return false;
        } else if (apellido_tercero.length == 0) {
            alertify.alert("Ingrese <b>Apellido</b>");
            return false;
        } else if (fecha_nacimiento_tercero.length == 0) {
            alertify.alert("Seleeccion <b>Fecha de Nacimiento</b>");
            return false;
        } else if (sexo_tercero.length == 0) {
            alertify.alert("Seleccione <b>Genero</b>");
            return false;
        } else if (parentesco.length == 0) {
            alertify.alert("Seleccione <b>Parentesco</b>");
            return false;
        }
    }


    if (tipo_documento.length == 0) {
        alertify.alert("Seleccione un <b>Tipo de documento</b>");
        return false;
    } else if (numero_documento.length == 0) {
        alertify.alert("Ingrese el <b>Numero de Documento</b>");
        return false;
    } else if (nombre.length == 0) {
        alertify.alert("Ingrese <b>Nombre</b>");
        return false;
    } else if (apellido.length == 0) {
        alertify.alert("Ingrese <b>Apellido</b>");
        return false;
    } else if (fecha_nacimiento.length == 0) {
        alertify.alert("Seleeccion <b>Fecha de Nacimiento</b>");
        return false;
    } else if (estado_civil.length == 0) {
        alertify.alert("Seleccione <b>Estado Civil</b>");
        return false;
    } else if (telefono_uno.length == 0) {
        alertify.alert("Ingrese <b>Telefono Uno</b>");
        return false;
    } else if (email.length == 0) {
        alertify.alert("Ingrese <b>Correo Electronico</b>");
        return false;
    } else if (ciudad.length == 0) {
        alertify.alert("Seleccione <b>Ciudad</b>");
        return false;
    } else if (barrio.length == 0) {
        alertify.alert("Ingrese <b>Barrio</b>");
        return false;
    } else if (direccion.length == 0) {
        alertify.alert("Ingrese <b>Direccion</b>");
        return false;
    } else if (sexo.length == 0) {
        alertify.alert("Seleccione <b>Genero</b>");
        return false;
    } else if (estrato.length == 0) {
        alertify.alert("Seleccione <b>Estrato</b>");
        return false;
    }

    $.ajax({
        url: '../controladores/Gestion.php',
        data:
                {
                    tipo: 2,
                    tipo_documento: tipo_documento,
                    numero_documento: numero_documento,
                    nombre: nombre,
                    apellido: apellido,
                    fecha_nacimiento: fecha_nacimiento,
                    estado_civil: estado_civil,
                    telefono_uno: telefono_uno,
                    telefono_dos: telefono_dos,
                    email: email,
                    ciudad: ciudad,
                    barrio: barrio,
                    direccion: direccion,
                    sexo: sexo,
                    estrato: estrato,
                    tipo_cliente: tipo_cliente,
                    tipo_documento_tercero: tipo_documento_tercero,
                    numero_documento_tercero: numero_documento_tercero,
                    nombre_tercero: nombre_tercero,
                    apellido_tercero: apellido_tercero,
                    fecha_nacimiento_tercero: fecha_nacimiento_tercero,
                    sexo_tercero: sexo_tercero,
                    parentesco: parentesco
                },
        type: 'post',
        success: function (data)
        {
            if (data == 0) {
                alertify.alert("El numero de documento ya existe.\n Verifique he intente nuevamente");

            } else {

                window.location.href = "../web/gestion.php?id=" + data;
            }
        }
    });
}

function agregar_tercero() {

    var numero_documento_titular = $("#numero_documento").val();
    var tipo_documento_tercero = $("#tipo_documento_tercero").val();
    var numero_documento_tercero = $("#numero_documento_tercero").val();
    var nombre_tercero = $("#nombre_tercero").val();
    var apellido_tercero = $("#apellido_tercero").val();
    var fecha_nacimiento_tercero = $("#fecha_nacimiento_tercero").val();
    var sexo_tercero = $("#sexo_tercero").val();
    var parentesco = $("#parentesco").val();

    if (numero_documento_titular.length == 0) {
        alertify.alert("Ingrese primero los datos del titular");
        return false;
    } else if (tipo_documento_tercero.length == 0) {
        alertify.alert("Seleccione un <b>Tipo de documento</b>");
        return false;
    } else if (numero_documento_tercero.length == 0) {
        alertify.alert("Ingrese el <b>Numero de Documento</b>");
        return false;
    } else if (nombre_tercero.length == 0) {
        alertify.alert("Ingrese <b>Nombre</b>");
        return false;
    } else if (apellido_tercero.length == 0) {
        alertify.alert("Ingrese <b>Apellido</b>");
        return false;
    } else if (fecha_nacimiento_tercero.length == 0) {
        alertify.alert("Seleeccion <b>Fecha de Nacimiento</b>");
        return false;
    } else if (sexo_tercero.length == 0) {
        alertify.alert("Seleccione <b>Genero</b>");
        return false;
    } else if (parentesco.length == 0) {
        alertify.alert("Seleccione <b>Parentesco</b>");
        return false;
    }


    $.ajax({
        url: '../controladores/Gestion.php',
        data:
                {
                    tipo: 23,
                    tipo_documento_tercero: tipo_documento_tercero,
                    numero_documento_tercero: numero_documento_tercero,
                    nombre_tercero: nombre_tercero,
                    apellido_tercero: apellido_tercero,
                    fecha_nacimiento_tercero: fecha_nacimiento_tercero,
                    sexo_tercero: sexo_tercero,
                    parentesco: parentesco,
                    numero_documento_titular: numero_documento_titular
                },
        type: 'post',
        success: function (data)
        {
            if (data == 1) {
                alertify.alert("El numero de documento ya existe.\n Verifique e intente nuevamente");

            } else {
                $("#div_informacion_terceros").html(data);
                alertify.success("Tercero Agregado");
            }
        }
    });
}

function cargar_tercero() {

    var numero_documento_titular = $("#numero_documento").val();

    $.ajax({
        url: '../controladores/Gestion.php',
        data:
                {
                    tipo: 24,
                    numero_documento_titular: numero_documento_titular
                },
        type: 'post',
        success: function (data)
        {
            if (data == 1) {


            } else {
                $("#div_informacion_terceros").html(data);

            }
        }
    });
}
function calcularEdad() {


    var fecha = $("#fecha_nacimiento").val();

    var hoy = new Date();
    var cumpleanos = new Date(fecha);
    var edad = hoy.getFullYear() - cumpleanos.getFullYear();
    var m = hoy.getMonth() - cumpleanos.getMonth();

    if (m < 0 || (m === 0 && hoy.getDate() < cumpleanos.getDate())) {
        edad--;
    }

    $("#edad").attr('value', edad);

    if (edad > 40) {
        $("#pregunta_1").attr('value', "Mas 40");
    } else if (edad < 40) {
        if (edad >= 0 && edad <= 5) {
            $("#pregunta_1").attr('value', "0 a 5 años");
        } else if (edad > 5 && edad <= 18) {
            $("#pregunta_1").attr('value', "5 a 18 años");
        } else if (edad > 18) {
            $("#pregunta_1").attr('value', "Menos 40");
        }
    }





    /*
     if (edad < 40) {
     $("#pregunta_1").val("Menos 40");
     }else if() else if (edad >= 0 || edad <= 5) {
     $("#pregunta_1").val("0 a 5 años");
     }*/


    //pregunta_1
}


function CrearPacienteHolding(cliente) {

    var id_cliente;
    var retorno;

    var retorno;
    $.ajax({
        type: 'POST',
        url: "../controladores/Gestion.php",
        async: false,
        dataType: 'json',
        data: {
            tipo: 1,
            documento: cliente.document
        },
        success: function (retu) {
            id_cliente = retu[0].id;
        }
    });


    $.ajax({
        type: 'POST',
        async: false,
        headers: {
            'Authorization': 'Bearer 20759f2e13e83281b23382d37b41888ee07126b0',
            'Content-Type': 'application/json'},
        url: "https://vitalea.co/api/users/create_user",
        data: JSON.stringify({
            "users": [
                {
                    "email": cliente.email,
                    "name": cliente.name,
                    "last_name": cliente.last_name,
                    "client_id": id_cliente,
                    "document": cliente.document,
                    "document_type_id": cliente.document_type_id,
                    "phone1": cliente.phone1,
                    "phone2": cliente.phone2,
                    "birth_date": cliente.birth_date,
                    "district": cliente.district,
                    "address": cliente.address,
                    "civil_status_id": cliente.civil_status_id,
                    "gender_id": cliente.gender_id,
                    "department_id": cliente.department_id,
                    "city_id": cliente.city_id,
                    "password": "Vitalea123",
                    "password_confirmation": "Vitalea123"
                }
            ]
        }),
        error: function (xhr, status, error) {
            console.log(xhr.responseText);
        },
        success: function (retu) {
            retorno = retu;
        }
    });


    return retorno;
}

function EnviarCorreoNuevoUsuario(cliente) {

    var retorno;
    $.ajax({
        type: 'POST',
        url: "../controlador/email_nuevo_user.php",
        async: false,
        data: {
            nombre: cliente.name,
            correo: cliente.email
        },
        success: function (retu) {
            retorno = retu;
        }
    });
    return retorno;
}

