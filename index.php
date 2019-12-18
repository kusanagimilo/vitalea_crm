<?php require_once './header_inicio.php'; ?>
<script>
    $(document).ready(function ()
    {
        jQuery("#btn_inicio_sesion").on("click", function () {
            alertify.set({labels:
                        {
                            ok: "Entendido",
                            cancel: "Consultar anteriores"
                        }
            });

            var usuario_acceso = $("#usuario_acceso").val();
            var clave = $("#clave").val();

            if (usuario_acceso.length === 0 || clave.length === 0) {
                alertify.alert("Digite usuario y contraseña");
            } else {
                jQuery.ajax({
                    url: 'controladores/Sesion.php',
                    data:
                            {
                                usuario_acceso: usuario_acceso,
                                clave: clave
                            },
                    type: 'post',
                }).done(function (data) {

                    if (data == 1) {
                        alertify.alert('Usuario no registrado', function () {
                            alertify.success('Verifica e intenta nuevamente');
                        });
                    } else if (data == 2) {
                        alertify.alert('Usuario Inactivo', function () {
                            alertify.success('Comuniquese con el Administrador');
                        });
                    } else {
                        window.location.href = "web/inicio.php";
                    }

                });
            }
        });
    });

</script>     


<!--<script src="ajax/Sesion.js"></script>-->
<body>

    <div class="login-content">
        <!-- Login -->
        <div class="nk-block toggled" id="l-login">
            <div class="nk-form">
                <img src="images/vitalea_logo.png" alt="" width="100px"/>
                <br><br>
                <div class="input-group">

                    <span class="input-group-addon" style="background-color: transparent;border:none;"></span>
                    <div class="nk-int-st" style="float: left;">
                        <input id="usuario_acceso" class="form-control" type="text" placeholder="Usuario" style="font-size: 12pt;color:black;">
                    </div>
                </div>
                <div class="input-group mg-t-15">

                    <span class="input-group-addon nk-ic-st-pro"></span>

                    <div class="nk-int-st">
                        <input id="clave" class="form-control" type="password" placeholder="Contraseña" style="font-size: 12pt;color:black;">
                    </div>
                </div>
                <br>
                <br>
                <div class="input-group mg-t-15">
                    <span class="input-group-addon nk-ic-st-pro"></span>
                    <button class="btn btn-success" id="btn_inicio_sesion" style="background-color: #14988A;border-color: #00c292;border:0px solid #ccc;outline:none;box-shadow:none;width: 100%;">
                        Ingresar   
                        <img src="web/images/proximo.png" alt=""/>
                    </button>  
                </div>
            </div>

            <br>
            <a href="#" data-ma-action="nk-login-switch" data-ma-block="#l-forget-password">
                <img src="web/images/pregunta.png" alt=""/>
                <span style="color:white;">Olvido contrase&ntilde;a</span></a>

        </div>


        <!-- Forgot Password -->
        <div class="nk-block" id="l-forget-password">


            <div class="nk-form">

                <img src="images/vitalea_logo.png" alt="" width="100px"/>
                <br><br>

                <h3>Restablecer contrase&ntilde;a</h3>
                <br>

                <div class="input-group">


                    <span class="input-group-addon" style="background-color: transparent;border:none;"></span>
                    <div class="nk-int-st" style="float: left;">
                        <input type="text" class="form-control" placeholder="Ingrese usuario" style="font-size: 12pt;color:black;">
                    </div>
                </div>
                <div class="input-group mg-t-15">
                    <span class="input-group-addon nk-ic-st-pro"></span>
                    <button class="btn btn-primary" id="restablecer_clave" style="float: right;background-color: #14988A;border-color: #00c292;border:0px solid #ccc;outline:none;box-shadow:none;width: 100%;">
                        Enviar  <img src="web/images/proximo.png" alt=""/></button>    
                </div>
            </div>

            <br>
            <a href="" data-ma-action="nk-login-switch" data-ma-block="#l-login"><i class="notika-icon notika-left-arrow"></i> <span  style="color:white;">Atr&aacute;s</span></a>

        </div>
    </div>

</body>





</html>