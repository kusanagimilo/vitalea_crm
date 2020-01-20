<?php
require_once '../include/script.php';
require_once '../include/header_administrador.php';
$array_permisos = explode(",", $_SESSION['PERMISOS']);
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
<script src="../ajax/sedesVitalea.js" type="text/javascript"></script>
<body style="background-color: #F6F8FA">

<div class="main-menu-area mg-tb-40">
        <div class="container" style="height:auto;">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <ol class="breadcrumb">
                        <li><a href="administrador.php" title="Volver atras"><img src="images/atras.png"></a></li>
                        <li class="active">Sedes Vitalea</li>
                    </ol>

                    <div class="row pad-top" style="background-color: white;">

                        <div id="clientes" style="padding: 20px;">
                            <div class="row">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h3 class="panel-title"> 
                                            <img style="max-width: 30px;" src="images/sedesIcon.png" alt=""/> 
                                            <b>Administrador de Sedes Vitalea</b></h3>
                                    </div>
                                    <div class="panel-body">

                                        <p style="font-size: 11pt;">
                                            <img src="images/info.png" alt="">
                                            Ingresa la informacion de la nueva sede acontinuacion.
                                        </p>

                                        <div class="row">
                                            <div class="col-md-6">
                                                Ingresa Nombre Sede <input id="nombreInput" type="text" class="form-control">
                                                Ingresa Ciudad <input id="ciudadInput" type="text" class="form-control">
                                                Ingresa Direccion <input id="direccionInput" type="text" class="form-control">
                                                Ingresa Barrio <input id="barrioInput" type="text" class="form-control">
                                                Ingresa Telefono <input id="telefonoInput" type="text" class="form-control">
                                            </div>                              
                                            <div class="col-md-6">
                                                <br>
                                                <button class="btn btn-primary" id="btnEnvioDatos" style="width: 100%">Ingresar Valores</button>
                                            </div>
                                        </div>

                                        <br>

                                        <div id="tabla_listado_sedes" class="table-responsive">

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


    <!-- End Contact Info area-->
    <?php require_once '../include/footer.php'; ?>
    <script>
        verSedesVitalea();
        ingresarSedesVitalea();
    </script>
</body>

</html>