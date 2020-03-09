<?PHP
//require_once '../include/script.php';
require_once '../include/script.php';
require_once '../include/header_administrador.php';
?>
<style>
    .loader {
        border: 16px solid #f3f3f3;
        border-radius: 50%;
        border-top: 16px solid #3498db;
        width: 250px;
        height: 250px;
        -webkit-animation: spin 2s linear infinite; /* Safari */
        animation: spin 2s linear infinite;
    }

    /* Safari */
    @-webkit-keyframes spin {
        0% { -webkit-transform: rotate(0deg); }
        100% { -webkit-transform: rotate(360deg); }
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>
<script>
    $(document).ready(function (){

        alertify.set({labels: {
                ok: "Entendido",
                cancel: "Consultar anteriores"
            }, color: {
                ok: "rgb(124, 35, 16)"
            }
        });

        $("#numero_documento").change(function () {
            cargar_tercero();
        });


        listar_tipo_documento();
        listar_estado_civil();
        listar_departamento();
        listar_seccion_direccion();
        listar_parentesco();
        // listar_barrio();

        $("#departamento").change(function () {
            listar_ciudad();
        });

        $('.i-checks').on('click', function () {
            if ($(this).is(':checked')) {
                var valor = $(this).val();
                if (valor == "Tercero") {
                    $("#panel_terceros").css("display", "block");
                } else {
                    $("#panel_terceros").css("display", "none");
                }

            }
        });


        $('select').select2();
        $("#buscar").click(function () {
            var documento = $("#documento").val();

            $.ajax({
                url: '../controladores/Gestion.php',
                data:
                        {
                            tipo: 1,
                            documento: documento
                        },
                type: 'post',
                dataType: 'json',
                success: function (data)
                {

                    $.each(data, function (i, cliente) {
                        if (cliente.id == 0) {
                            alertify.alert("Registro no encontrado");
                        } else {
                            $("#div_informacion_cliente").empty();
                            $("#myModal").modal();
                            var newRow = "<table class='table table-bordered' style='font-size:11px' >";
                            newRow += "<tr class='success'><th>Tipo de documento</th><td>" + cliente.tipo_documento + "</td><th>N° Documento</th><td>" + cliente.documento + "</td>  </tr>";
                            newRow += "<tr><th>Nombres</th><td>" + cliente.nombre_cliente + "</td><th>Apellidos</th><td>" + cliente.apellido_cliente + "</td></tr>";
                            newRow += "<tr class='success'><th>Fecha de Nacimiento</th><td>" + cliente.fecha_nacimiento + "</td><th>Email</th><td>" + cliente.email + "</td></tr>";
                            newRow += "<tr><th>Telefono 1</th><td>" + cliente.telefono_1 + "</td><th>Telefono 2</th><td>" + cliente.telefono_2 + "</td></tr>";
                            newRow += "<tr class='success'><th>Departamento</th><td>" + cliente.departamento + "</td><th>Ciudad</th><td>" + cliente.ciudad + "</td></tr>";
                            newRow += "<tr><th>Barrio</th><td>" + cliente.barrio + "</td><th>Dirección</th><td>" + cliente.direccion + "</td></tr>";
                            newRow += "<tr class='success'><th>Estado civil</th><td>" + cliente.estado_civil + "</td><th>Sexo</th><td>" + cliente.sexo + "</td></tr>";
                            newRow += "<tr><th>Estrato</th><td>" + cliente.estrato + "</td><th>Estado</th><td>" + cliente.activo + "</td></tr>";
                            newRow += "</table>";
                            newRow += "<input id='cliente_id' value='" + cliente.id + "' type='hidden'>";
                            $(newRow).appendTo("#div_informacion_cliente");

                        }
                    });

                }
            });
        });


        $("#colapsible_basico").click(function () {

            var isVisible = $("#collapse1").is(":visible");

            if (isVisible) {
                $("#collapse1").css("display", "none");
            } else {
                $("#collapse1").css("display", "block");
            }

        });

        $("#colapsible_ubicacion").click(function () {


            var isVisible = $("#collapse2").is(":visible");

            if (isVisible) {
                $("#collapse2").css("display", "none");
            } else {
                $("#collapse2").css("display", "block");
            }

        });

        $("#colapsible_terceros").click(function () {


            var isVisible = $("#collapse4").is(":visible");

            if (isVisible) {
                $("#collapse4").css("display", "none");
            } else {
                $("#collapse4").css("display", "block");
            }

        });

        $("#colapsible_clasificacion").click(function () {


            var isVisible = $("#collapse3").is(":visible");

            if (isVisible) {
                $("#collapse3").css("display", "none");
            } else {
                $("#collapse3").css("display", "block");
            }

        });

        $("#btn_gestionar_registro").click(function () {
            var cliente_id = $("#cliente_id").val();
            $.ajax({
                url: '../controladores/Gestion.php',
                data:
                        {
                            tipo: 11,
                            cliente_id: cliente_id
                        },
                type: 'post',
                success: function (data)
                {
                    window.location.href = "gestion.php?id=" + data;
                }
            });
        });


        $("#js_up").slideDown(300);

        //agregar tercero temporal 
        $("#btn_agregar_tercero").click(function () {
            agregar_tercero();
        });

        $("#nuevo_registro").click(function () {    
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
            var usuario = $("#usuario").val();
            var coincide_email = $("#coincide_email").val();
            var edad = $("#edad").val();
            //var firma = imagenBase64 = sessionStorage.getItem('imagenCadena');


            if (typeof tipo_cliente === 'undefined') {
                alertify.alert("Seleccione <b>Tipo de Cliente</b>");
                return false;
            }

            if (tipo_cliente == "Tercero") {
                var cantidad_tercero = $("#cantidad_tercero").val();
                if (cantidad_tercero == 0 || typeof cantidad_tercero === 'undefined') {
                    alertify.alert("Ingrese al menos un registro de Tercero");
                    return false;
                }
            }

            if (tipo_documento.length == 0) {
                alertify.alert("Seleccione un <b>Tipo de documento</b>");
                return false;
            } else if (numero_documento.length == 0 || isNaN(numero_documento)) {
                alertify.alert("Verifique o Ingrese <b>Numero de Documento correctamente</b>");
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
            } else if (telefono_uno.length == 0 || isNaN(telefono_uno)) {
                alertify.alert("Verifique <b>el ingreso correcto de telefono Uno</b>");
                return false;
            } else if (isNaN(telefono_dos)) {
                alertify.alert("Verifique <b>el ingreso correcto de telefono dos</b>");
                return false;
            } else if (email.length == 0) {
                alertify.alert("Ingrese <b>Correo Electronico</b>");
                return false;
            } else if (coincide_email == 0) {
                alertify.alert("Realice la confirmacion del <b>Correo Electronico</b>");
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
            } else if (estrato.length == 0) {
                alertify.alert("Seleccione <b>Estrato</b>");
                return false;
            }

            //perfilamiento

            //perfilamiento paciente
            var pregunta_22 = $("#selectDeContacto").val();
            if (pregunta_22 == "") {
                alertify.alert("Responda la pregunta ¿Como conociste Vitalea?");
                return false;
            } else {
                if (pregunta_22 == 'Otro') {
                    pregunta_22 = $("#otro_ven").val();
                } else {
                    pregunta_22 = $("#selectDeContacto").val();
                }
            }

            var pregunta_23 = $("#venta_virtual").val();
            if (pregunta_23 == "") {
                alertify.alert("Responda la pregunta ¿Esta es una venta virtual?");
                return false;
            }

            


            var clasificacion = 1;
            $.ajax({
                url: '../controladores/Gestion.php',
                beforeSend: function () {
                    $('#ModalCargando').modal({backdrop: 'static', keyboard: false});
                },
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
                            usuario: usuario,
                            edad: edad,
                            pregunta_22: pregunta_22,
                            pregunta_23: pregunta_23,
                            clasificacion: clasificacion
                            //firma: firma   
                        },
                type: 'post',
                success: function (data)
                {

                    //console.log(data);


                    if (data == 0) {
                        alertify.alert("El numero de documento ya existe.\n Verifique e intente nuevamente");
                    } else {

                        var gender_id;
                        if (sexo == "Femenino") {
                            gender_id = 2;
                        } else {
                            gender_id = 1;
                        }

                        var cliente = {
                            email: email,
                            name: nombre,
                            last_name: apellido,
                            document: numero_documento,
                            document_type_id: tipo_documento,
                            phone1: telefono_uno,
                            phone2: telefono_dos,
                            birth_date: fecha_nacimiento,
                            district: barrio,
                            address: direccion,
                            civil_status_id: estado_civil,
                            gender_id: gender_id,
                            department_id: $("#departamento").val(),
                            city_id: ciudad
                        };
                        var retorno_holding = CrearPacienteHolding(cliente);
                        /*console.log(retorno_holding);
                         console.log(retorno_holding.data);
                         console.log(retorno_holding.status);*/

                        if (retorno_holding.status == "ok") {
                            var retorno_correo = EnviarCorreoNuevoUsuario(cliente);
                            if (retorno_correo == 1 || retorno_correo == "1") {
                                $('#ModalCargando').modal('toggle');
                                alert("Usuario creado correctamente y mensaje de notificación enviado");
                                window.location.href = "../web/gestion.php?id=" + data;
                            } else {
                                $('#ModalCargando').modal('toggle');
                                alert("No se logró enviar el correo de confirmación, pero el usuario fue creado exitosamente ");
                                window.location.href = "../web/gestion.php?id=" + data;
                            }
                        } else {
                            alert("Error al ingresar el paciente comuniquese con soporte");
                        }

                        //window.location.href = "../web/gestion.php?id=" + data;
                    }
                }
            });
        });
    });

</script>
<script src="../ajax/clasificar_paciente.js" ></script>
<script src="../include/constante.js" ></script>
<!-- <script src="../ajax/firmasAlmacenar.js"></script> -->
<body style="background-color: #F6F8FA;">
    <input type="hidden" id="coincide_email" value="0">
    <div class="main-menu-area mg-tb-40" style="min-height: 400px;">
        <div class="container" style="height:auto;">
            <div class="row">
                <ol class="breadcrumb">
                    <li><a href="inicio_administrador.php" title="Volver atras"><img src="images/atras.png"></a></li>

                    <li><a href="inicio_usuario.php" title="Inicio">Inicio</a></li>
                    <li class="active">Nuevo Paciente</li>
                </ol>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="row pad-top" style="background-color: white;">
                        <div class="panel panel-default">
                            <div class="panel-heading " style="height: 50px;">
                                <h3 class="panel-title"> 
                                    <b  style="float: left">  <img src="images/agregar-usuario.png" alt=""/> 
                                        Ingresar Nuevo Paciente</b> </h3>       
                            </div>
                            <input id="usuario" value="<?php echo $_SESSION['ID_USUARIO'] ?>" type="hidden" >
                            <div id="nuevo_paciente" >
                                <div class="form-element-list mg-t-30" >
                                    <p style=" font-size: 11pt;">
                                        <img src="images/info.png" alt=""/>
                                        Solicite los datos al paciente para crear un nuevo registro.

                                    </p>

                                    <div class="panel-group" id="accordion" role="tablist">

                                        <div class="panel panel-default">
                                            <div style="height: 50px;border-bottom:1px solid #00c292;padding: 10px; ">
                                                <a  href="#collapse1" id="colapsible_basico" style=" text-decoration: none; color: black;">
                                                    <h4 style="color:#00c292;">

                                                        <img src="images/basico.png" alt="" style="width: 20px;"/>  Datos básicos 
                                                        <span style="float:right"><img src="images/sort_desc.png" alt=""/></span></h4> 

                                                </a>

                                            </div>
                                            <div id="collapse1" class="panel-collapse collapse" style="display: block;">
                                                <div class="panel-body">
                                                    <div class="cta-desc">

                                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                            <div class="form-group">

                                                                <div class="nk-int-st">
                                                                    <input name="tipo_cliente" type="radio" value="Titular" class="i-checks"> Titular
                                                                    <input name="tipo_cliente" type="radio" value="Tercero" class="i-checks"> Acudiente
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div id="titular_datos" >    
                                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">


                                                                <p style=" font-size: 11pt;">
                                                                    <img src="images/info.png" alt=""/>
                                                                    Solicite los datos de la persona que se comunica.

                                                                </p>  
                                                            </div>
                                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">    
                                                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                    <div class="form-group">
                                                                        <label>Tipo de documento</label>
                                                                        <div class="nk-int-st">
                                                                            <select id="tipo_documento" style="width: 100%;"  class="form-control tipo_documento">
                                                                                <option value=''> -- </option>
                                                                            </select>

                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                    <div class="form-group">
                                                                        <label>Numero documento</label>
                                                                        <div class="nk-int-st">
                                                                            <input type="text" class="form-control"  id="numero_documento" >
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                    <div class="form-group">
                                                                        <label>Nombres</label>
                                                                        <div class="nk-int-st">
                                                                            <input type="text" class="form-control"  id="nombre">
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                    <div class="form-group">
                                                                        <label>Apellidos</label>
                                                                        <div class="nk-int-st">
                                                                            <input type="text" class="form-control" id="apellido">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                                                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                    <div class="form-group">
                                                                        <label>Fecha de nacimiento</label>
                                                                        <div class="nk-int-st">
                                                                            <input type="date" onchange="calcularEdad()" class="form-control"  id="fecha_nacimiento">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                    <div class="form-group">
                                                                        <label>Edad</label>
                                                                        <div class="nk-int-st">
                                                                            <input readonly="true" type="text" class="form-control"  id="edad">
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                    <div class="form-group">
                                                                        <label>G&eacute;nero</label>
                                                                        <div class="nk-int-st">
                                                                            <select id="sexo" style="width: 100%;" class="form-control">
                                                                                <option value=''> - </option>
                                                                                <option value="Femenino">Femenino</option>
                                                                                <option value="Masculino">Masculino</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                    <div class="form-group">
                                                                        <label>Estado civil</label>
                                                                        <div class="nk-int-st">
                                                                            <select id="estado_civil" style="width: 100%;" class="form-control">
                                                                                <option value=''> - </option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                    <div class="form-group">
                                                                        <label>Telefono 1</label>
                                                                        <div class="nk-int-st">
                                                                            <input name="telefono_uno" id="telefono_uno" class="form-control" type="text">
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                    <div class="form-group">
                                                                        <label>Telefono 2</label>
                                                                        <div class="nk-int-st">
                                                                            <input name="telefono_dos" id="telefono_dos" class="form-control" type="text" placeholder="Opcional">
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                    <div class="form-group">
                                                                        <label>Correo electr&oacute;nico</label>
                                                                        <div class="nk-int-st">
                                                                            <input name="email" id="email" class="form-control" type="text">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                    <div class="form-group">
                                                                        <label>Confirmacion Correo electr&oacute;nico</label>
                                                                        <div class="nk-int-st">
                                                                            <input name="email" id="email_confirmacion" class="form-control" type="text" onblur="valida(this.value);">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div> 
                                                        </div> 

                                                    </div>
                                                </div>

                                            </div>

                                        </div>
                                    </div>

                                    <div class="panel panel-default" id="panel_terceros" style="display: none">
                                        <div style="height: 50px;border-bottom:1px solid #00c292;padding: 10px; ">
                                            <a href="#collapse4" id="colapsible_terceros" style=" text-decoration: none; color: black;">
                                                <h4 style="color:#00c292;">
                                                    <img src="images/terceros.png" alt=""/>
                                                    Informacion del Acudiente
                                                    <span style="float:right"><img src="images/sort_desc.png" alt=""/></span></h4> 

                                            </a>

                                        </div>

                                        <div id="collapse4" class="panel-collapse collapse" style="display: block">
                                            <div class="panel-body">
                                                <div class="cta-desc">
                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="text-align: right;">
                                                        <button type="button" class="btn btn-default" data-toggle="modal" data-target="#myModalResultados"> <img src="images/anadir_dos.png"> Agregar Acudiente</button>
                                                    </div>
                                                    <div id="div_informacion_terceros"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>    



                                    <div class="panel panel-default">
                                        <div style="height: 50px;border-bottom:1px solid #00c292;padding: 10px; ">
                                            <a href="#collapse2" id="colapsible_ubicacion" style=" text-decoration: none; color: black;">
                                                <h4 style="color:#00c292;">
                                                    <img src="images/ubicacion.png" alt=""/>
                                                    Datos de ubicación 
                                                    <span style="float:right"><img src="images/sort_desc.png" alt=""/></span></h4> 

                                            </a>

                                        </div>

                                        <div id="collapse2" class="panel-collapse collapse" style="display: block">
                                            <div class="panel-body">
                                                <div class="cta-desc">
                                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                        <div class="form-group">
                                                            <label>Departamento</label>
                                                            <div class="nk-int-st">
                                                                <select id="departamento" style="width: 100%;" class="form-control" >
                                                                    <option value=''> - </option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                        <div class="form-group">
                                                            <label>Ciudad</label>
                                                            <div class="nk-int-st">
                                                                <select id="ciudad" style="width: 100%;" class="form-control">
                                                                    <option value=''> - </option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                        <div class="form-group">
                                                            <label>Barrio</label>
                                                            <div class="nk-int-st">
                                                                <select id="barrio" class="form-control" type="text" style="max-width: 200px">
                                                                    <option value=''> - </option>
                                                                    <?php include('./reportes/listaBarrios.php') ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                        <div class="form-group">
                                                            <label>Estrato</label>
                                                            <div class="nk-int-st">
                                                                <select id="estrato" style="width: 100%;" class="form-control">
                                                                    <option value=''> - </option>
                                                                    <option value="1">1</option>
                                                                    <option value="2">2</option>
                                                                    <option value="3">3</option>
                                                                    <option value="4">4</option>
                                                                    <option value="5">5</option>
                                                                    <option value="6">6</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                        <p style=" font-size: 11pt;">
                                                            <img src="images/info.png" alt=""/>
                                                            Seleccione cada sección para armar la direccion</p> 
                                                    </div>

                                                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                        <div class="form-group">
                                                            <label>Sección 1:</label>
                                                            <div class="nk-int-st">
                                                                <select id="seccion_uno" style="width: 100%;" class="form-control seccion" onchange="armar_direccion()">
                                                                    <option value=''> -- </option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                        <div class="form-group">
                                                            <label>N&uacute;mero:</label>
                                                            <div class="nk-int-st">
                                                                <input name="numero_uno" id="numero_uno" class="form-control" type="text" onchange="armar_direccion()">
                                                            </div>
                                                        </div>
                                                    </div>



                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-8">
                                                        <div class="form-group">
                                                            <label>Direcci&oacute;n:</label>
                                                            <div class="nk-int-st">
                                                                <input name="direccion" id="direccion" class="form-control" type="text" readonly="true">
                                                            </div>
                                                        </div>
                                                    </div>  


                                                </div>
                                            </div>
                                        </div>
                                    </div> 

                                    <div class="panel panel-default">
                                        <div style="height: 50px;border-bottom:1px solid #00c292;padding: 10px; ">
                                            <a href="#collapse3" id="colapsible_clasificacion" style=" text-decoration: none; color: black;">
                                                <h4 style="color:#00c292;">
                                                    <img src="images/clasificacion.png" alt=""/>
                                                    Perfilamiento
                                                    <span style="float:right"><img src="images/sort_desc.png" alt=""/></span></h4> 

                                            </a>

                                        </div>

                                        <div id="collapse3" class="panel-collapse collapse" style="display: block">
                                            <div class="panel-body">
                                                <div class="cta-desc">
                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                        <p>
                                                            <br>
                                                            Hola. Bienvenido a Vitălea salud proactiva.<br>
                                                            ¿En qué te puedo ayudar?.<br>
                                                            Somos la nueva generación de laboratorios clínicos enfocados en prevención, contamos con diferentes chequeos especializados donde podrás evaluar, monitorear y entender tu estado general de salud.
                                                            <br>    
                                                            Una consulta…

                                                        </p> <br>

  <!--<input type="hidden" readonly="true"  class="form-control"  id="pregunta_1">-->

                                                        <table class="table table-bordered" data-select2-id="27">
                                                            <tbody>
                                                                <tr id="p2">
                                                                    <th>¿Como conociste Vitalea?</th>
                                                                    <td data-select2-id="26">
                                                                        <select name="selectDeContacto"  class="form-control" id="selectDeContacto" onchange="condicionalValorOtros()">
                                                                            <option value="Instagram">Instagram</option>
                                                                            <option value="Facebook">Facebook</option>
                                                                            <option value="Pagina Web">Pagina Web</option>
                                                                            <option value="Un Amigo">Un Amigo</option>
                                                                            <option value="Vi el local">Vi el local</option>
                                                                            <option value="Otro">Otro</option>
                                                                        </select>
                                                                        <div id="otro_cono"></div>
                                                                    </td>

                                                                </tr>


                                                                <tr id="resultado_clasificacion">
                                                                    <th><p style="color:#00c292;">¿Esta es una venta virtual?</p></th>
                                                                    <td data-select2-id="40">
                                                                        <select name="venta_virtual" style="width: 30%" class="form-control" id="venta_virtual" >
                                                                            <option value="Si">SI</option>
                                                                            <option value="No">NO</option>
                                                                        </select>     
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>   
                                            </div>   
                                        </div>                                                                               
                                    </div>
                                    
                                    <button id="nuevo_registro" class="btn btn-info notika-btn-success waves-effect" style="width: 30%;float: right;">
                                        <img src="images/guardar.png" alt="" style="width: 20px"/> Guardar
                                    </button>
                                </div>
                            </div>



                        </div>   

                    </div>

                </div>
            </div>
        </div>
    </div>
    
    

   
    
    <!-- modal terceros -->
    <div class="modal" id="myModalResultados" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" >
        <div class="modal-dialog" style="width: 80%;">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #214761; color: white" >
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">
                        <img src="images/examen_venta.png" alt=""/>
                        Seleccione examen</h4>
                </div>
                <div class="modal-body col-md-12" style="height: auto">

                    <div id="tercero_datos"  >
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <h4 style="color:#00c292;">
                                <img src="images/cliente_1.png" alt="" style="width: 20px;"/>  Acudiente o responsable 
                            </h4> 
                            <p style=" font-size: 11pt;">
                                <img src="images/info.png" alt=""/>
                                Solicite los datos de la persona a la cual representa.

                            </p>    

                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <div class="form-group">
                                <label>Tipo de documento</label>
                                <div class="nk-int-st">
                                    <select id="tipo_documento_tercero" style="width: 100%;"  class="form-control tipo_documento">
                                        <option value=''> -- </option>
                                    </select>

                                </div>
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <div class="form-group">
                                <label>Numero documento</label>
                                <div class="nk-int-st">
                                    <input type="text" class="form-control"  id="numero_documento_tercero" >
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <div class="form-group">
                                <label>Nombres</label>
                                <div class="nk-int-st">
                                    <input type="text" class="form-control"  id="nombre_tercero">
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <div class="form-group">
                                <label>Apellidos</label>
                                <div class="nk-int-st">
                                    <input type="text" class="form-control" id="apellido_tercero">
                                </div>
                            </div>
                        </div>


                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <div class="form-group">
                                <label>Fecha de nacimiento</label>
                                <div class="nk-int-st">
                                    <input type="date" class="form-control" max="<?php echo date("YYYY-MM-DD"); ?>"  id="fecha_nacimiento_tercero">
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <div class="form-group">
                                <label>G&eacute;nero</label>
                                <div class="nk-int-st">
                                    <select id="sexo_tercero" style="width: 100%;" class="form-control">
                                        <option value=''> - </option>
                                        <option value="Femenino">Femenino</option>
                                        <option value="Masculino">Masculino</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <div class="form-group">
                                <label>Parentesco</label>
                                <div class="nk-int-st">
                                    <select id="parentesco" style="width: 100%;" class="form-control">

                                    </select>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>          
                <div class="modal-footer">
                    <button type="button" id="btn_agregar_tercero" class="btn btn-primary" style="font-size: 11pt;">  <img src="images/anadir_dos.png"> Agregar Acudiente</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal" style="font-size: 11pt;"><img src="images/cerrar_dos.png"> Cerrar</button>
                </div>
            </div>                            
        </div>
    </div>
    <div class="modal fade" data-backdrop="static" data-keyboard="false" id="ModalCargando" role="dialog">
        <div class="modal-dialog modal-lg">

            <!-- Modal content-->
            <div class="modal-content">

                <div class="modal-body">
                    <div class="row">
                        <div id="div_informacion_cliente">
                            <center>
                                <div class="loader"></div>
                                <h2>REALIZANDO OPERACION POR FAVOR ESPERE</h2>
                            </center>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div> 

    <!--fin modal --->

    <script>
        /*Esta Funcion se crea con el objetivo de leer el valor del select - De como conociste a Vitalea, 
         y cuando se selecciones el campo otros reaparecera un input para que incluya un string, donde se pueda ingresar ese valor*/
        function condicionalValorOtros() {

            var cond = $("#selectDeContacto").val();
            if (cond == "Otro") {
                var html = '<input class="form-control" id="otro_ven" name="otro_ven" type="text" placeholder="Escriba su respuesta.">';
                $("#otro_cono").html(html);
            } else {
                $("#otro_cono").html("");
            }
        }
    </script>
    <script src="../ajax/Crear_usuario.js" ></script>
</body>
<?php require_once '../include/footer.php'; ?>
</html>