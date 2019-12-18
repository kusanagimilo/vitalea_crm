$(document).ready(function ()
{

    usuario_call_center();
    usuario_presencial();
    usuarios_activos_call_center();
    activos_presencial();
    perfil();
    $('select').select2();

    $("#btn_usuario_nuevo").click(function () {
        nuevoUsuario();
    });


    $('.estado_usuario').click(function ()
    {
        var datos = $(this).data();
        var usuario_id = datos.id;
        var estado_id = datos.estado;

        var info_estado = "";

        if (estado_id == 1) {
            info_estado = "Inactivar";
        } else {
            info_estado = "Activar";
        }

        alertify.set({labels:
                    {
                        ok: "Si, continuar",
                        cancel: "Cancelar proceso"
                    }, color: {
                ok: "rgb(124, 35, 16)"
            },

        });
        alertify.set({buttonReverse: true});

        alertify.confirm("¿Desea <b>" + info_estado + "</b> al usuario <b>" + usuario_id + "</b>?",
                function (e) {
                    if (e) {
                        $.ajax({
                            url: '../controladores/Usuario.php',
                            data:
                                    {
                                        usuario_id: usuario_id,
                                        estado_id: estado_id,
                                        tipo: 8
                                    },
                            type: 'post',
                            success: function (data)
                            {
                                alertify.set({labels:
                                            {
                                                ok: "Entendido"
                                            }, color: {
                                        ok: "rgb(124, 35, 16)"
                                    }

                                });

                                if (data == 1) {
                                    alertify.alert("El usuario " + usuario_id + " ha sido <b>Activado  </b>", function () {
                                        location.reload();
                                    });
                                } else {
                                    alertify.alert("El usuario " + usuario_id + " ha sido <b>Inactivado  </b>", function () {
                                        location.reload();
                                    });
                                }
                            }
                        });
                    } else {
                        alertify.error('Ha cancelado la solicitud');
                    }
                });
    });


    $('.estado_usuario_digiturno').click(function ()
    {
        var datos = $(this).data();
        var usuario_id_digiturno = datos.id;
        var estado_id_digiturno = datos.estado;

        var info_estado = "";

        if (estado_id_digiturno == 1) {
            info_estado = "Cambiar a Toma";
        } else {
            info_estado = "Cambiar a Pago";
        }

        alertify.set({labels:
                    {
                        ok: "Si, continuar",
                        cancel: "Cancelar proceso"
                    }, color: {
                ok: "rgb(124, 35, 16)"
            },

        });


        alertify.set({buttonReverse: true});

        alertify.confirm("¿Desea <b>" + info_estado + "</b> el usuario <b>" + usuario_id_digiturno + "</b>?",
                function (e) {
                    if (e) {
                        $.ajax({
                            url: '../controladores/Usuario.php',
                            data:
                                    {
                                        usuario_id_digiturno: usuario_id_digiturno,
                                        estado_id_digiturno: estado_id_digiturno,
                                        tipo: 10
                                    },
                            type: 'post',
                            success: function (data)
                            {
                                alertify.set({labels:
                                            {
                                                ok: "Entendido"
                                            }, color: {
                                        ok: "rgb(124, 35, 16)"
                                    }

                                });
                                if (data == 1) {
                                    alertify.alert("El usuario " + usuario_id_digiturno + " ha cambiado a <b>Pago  </b>", function () {
                                        location.reload();
                                    });
                                } else {
                                    alertify.alert("El usuario " + usuario_id_digiturno + " ha cambiado a <b>Toma  </b>", function () {
                                        location.reload();
                                    });
                                }
                            }
                        });
                    } else {
                        alertify.error('Ha cancelado la solicitud');
                    }
                });
    });

});

function listarUsuario() {
    $.ajax({
        url: '../controladores/Usuario.php',
        data:
                {
                    tipo: 1
                },
        type: 'post',
        dataType: 'json',
        success: function (data)
        {

            $.each(data, function (i, cliente) {


                var newRow = "<tr>";
                newRow += "<td>" + cliente.id + "</td>";
                newRow += "<td>" + cliente.perfil + "</td>";
                newRow += "<td>" + cliente.documento + "</td>";
                newRow += "<td>" + cliente.nombre_completo + "</td>";
                newRow += "<td>" + cliente.correo + "</td>";
                newRow += "<td>" + cliente.estado + "</td>";
                newRow += "<td>" + cliente.permisos_digiturno + "</td>";

                newRow += "</tr>";

                $(newRow).appendTo("#lista_usuario");
            });

        }
    });
}

function listarUsuarioDigiturno() {
    $.ajax({
        url: '../controladores/Usuario.php',
        data:
                {
                    tipo: 1
                },
        type: 'post',
        dataType: 'json',
        success: function (data)
        {

            $.each(data, function (i, cliente) {


                var newRow = "<tr>";
                newRow += "<td>" + cliente.id + "</td>";
                newRow += "<td>" + cliente.perfil + "</td>";
                newRow += "<td>" + cliente.documento + "</td>";
                newRow += "<td>" + cliente.nombre_completo + "</td>";
                newRow += "<td>" + cliente.correo + "</td>";
                newRow += "<td>" + cliente.estado + "</td>";
                newRow += "<td>" + cliente.descripcion_permiso + "</td>";

                newRow += "</tr>";

                $(newRow).appendTo("#listar_usuarios_digiturno");
            });

        }
    });
}

function habilitarUsuarioDigiturno() {
    $.ajax({
        url: '../controladores/Usuario.php',
        data:
                {
                    tipo: 1
                },
        type: 'post',
        dataType: 'json',
        success: function (data)
        {

            $.each(data, function (i, cliente) {


                var newRow = "<tr>";
                newRow += "<td>" + cliente.id + "</td>";
                newRow += "<td>" + cliente.perfil + "</td>";
                newRow += "<td>" + cliente.documento + "</td>";
                newRow += "<td>" + cliente.nombre_completo + "</td>";
                newRow += "<td>" + cliente.correo + "</td>";
                newRow += "<td>" + cliente.estado + "</td>";

                newRow += "</tr>";

                $(newRow).appendTo("#habilitar_usuarios_digiturno");
            });

        }
    });
}

function usuario_call_center() {
    $.ajax({
        url: '../controladores/Usuario.php',
        data:
                {
                    tipo: 2
                },
        type: 'post',
        dataType: 'json',
        success: function (data)
        {

            $.each(data, function (i, usuario) {
                var newRow = "<b>" + usuario.conteo + "</b>";

                $(newRow).appendTo("#conteo_call_center");
            });

        }
    });
}

function usuario_presencial() {
    $.ajax({
        url: '../controladores/Usuario.php',
        data:
                {
                    tipo: 3
                },
        type: 'post',
        dataType: 'json',
        success: function (data)
        {

            $.each(data, function (i, usuario) {
                var newRow = "<b>" + usuario.conteo + "</b>";

                $(newRow).appendTo("#conteo_presencial");
            });

        }
    });
}

function usuarios_activos_call_center() {
    $.ajax({
        url: '../controladores/Usuario.php',
        data:
                {
                    tipo: 4
                },
        type: 'post',
        dataType: 'json',
        success: function (data)
        {

            $.each(data, function (i, usuario) {
                var newRow = "<b>" + usuario.cantidad + "</b>";

                $(newRow).appendTo("#activo_call_center");
            });

        }
    });
}
function activos_presencial() {
    $.ajax({
        url: '../controladores/Usuario.php',
        data:
                {
                    tipo: 5
                },
        type: 'post',
        dataType: 'json',
        success: function (data)
        {

            $.each(data, function (i, usuario) {
                var newRow = "<b>" + usuario.cantidad + "</b>";

                $(newRow).appendTo("#activo_presencial");
            });

        }
    });
}

function perfil() {
    $.ajax({
        url: '../controladores/Usuario.php',
        data:
                {
                    tipo: 6
                },
        type: 'post',
        dataType: 'json',
        success: function (data)
        {

            $.each(data, function (i, perfil) {
                var newRow = "<option value=" + perfil.id + ">" + perfil.nombre + "</option>";

                $(newRow).appendTo("#perfil");
            });

        }
    });
}




function nuevoUsuario() {
    var perfil = $("#perfil").val();
    var numero_documento = $("#numero_documento").val();
    var nombre_completo = $("#nombre_completo").val();
    var correo = $("#correo").val();
    var nombre_usuario = $("#nombre_usuario").val();

    if (perfil.length == 0) {
        alertify.alert("Seleccione una opcion para <b>Perfil</b>");
    } else if (numero_documento.length == 0) {
        alertify.alert("Ingrese el <b>Numero de Documento</b>");
    } else if (nombre_completo.length == 0) {
        alertify.alert("Ingrese el <b>Nombre Completo</b>");
    } else if (correo.length == 0) {
        alertify.alert("Ingrese el <b>Correo Electronico</b>");
    } else if (nombre_usuario.length == 0) {
        alertify.alert("Ingrese el <b>Nombre de Usuario</b>");
    } else {
        $.ajax({
            url: '../controladores/Usuario.php',
            data:
                    {
                        perfil: perfil,
                        numero_documento: numero_documento,
                        nombre_completo: nombre_completo,
                        correo: correo,
                        nombre_usuario: nombre_usuario,
                        tipo: 7
                    },
            type: 'post',
            success: function (data)
            {
                if (data == 0) {
                    alertify.alert("El usuario ya se encuentra registrado \n Verifique he intente nuevamente.");
                } else {
                    alertify.alert("Usuario creado. \n  Los datos de acceso son \n <b>Usuario:</b> " + data + " \n <b>Clave:</b> Numero de documento ", function () {
                        location.reload();
                    });
                }


            }
        });
    }
}
