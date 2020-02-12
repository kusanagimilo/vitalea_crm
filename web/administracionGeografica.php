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
<script src="../ajax/administracionGeografica.js" type="text/javascript"></script>
<body style="background-color: #F6F8FA">

<div class="main-menu-area mg-tb-40">
        <div class="container" style="height:auto;">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <ol class="breadcrumb">
                        <li><a href="administrador.php" title="Volver atras"><img src="images/atras.png"></a></li>
                        <li class="active">Administracion Geografica</li>
                    </ol>

                    <div class="row pad-top" style="background-color: white;">

                        <div id="clientes" style="padding: 20px;">
                            <div class="row">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h3 class="panel-title"> 
                                            <img style="max-width: 30px;" src="images/sedesIcon.png" alt=""/> 
                                            <b>Módulo de Administración Geográfica</b></h3>
                                    </div>
                                    <div class="panel-body">

                                        <p style="font-size: 11pt;">
                                            <img src="images/info.png" alt="">
                                            Digite la información geográfica a ingresar.
                                        </p>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div style="border: 1px solid #909090; padding: 0 35px; margin: 5px 0; border-radius:15px;">
                                                    <span>Agregar País</span>  
                                                    <input id="addCounrty" type="text" style="width: 57%; margin: 10px 30px 10px 129.5px; border-radius: 5px" value="">
                                                    <button class="btn btn-success" style="margin: 10px 0px 10px 0px;" id="envioDatosPais"><i class="fas fa-upload"></i> Ingresar Valores</button>
                                                </div>
                                                <div style="border: 1px solid #909090; padding: 0 35px; margin: 5px 0; border-radius:15px;">
                                                    <span>Agregar Departamento o Estado</span>  
                                                    <input id="addState" type="text" style="width: 57%; margin: 10px 30px 10px 0px; border-radius: 5px" value=""><br>
                                                    <span style="margin: 10px 5px 10px 0px;" >Asociar al País: </span>
                                                    <select style="margin: 10px 10px 10px 2px; max-width: 130px;"  id="muestraPais"></select>
                                                    <button class="btn btn-success" style="margin: 10px 0px 10px 0px;" id="envioDatosEstado"><i class="fas fa-upload"></i> Ingresar Valores</button>
                                                </div>
                                                <div style="border: 1px solid #909090; padding: 0 35px; margin: 5px 0; border-radius:15px;">
                                                    <span>Agregar Ciudad</span>  
                                                    <input id="addCity" type="text" style="width: 57%; margin: 10px 30px 10px 109.5px; border-radius: 5px" value=""><br>
                                                    <span style="margin: 10px 5px 10px 0px;" >Asociar al País: </span>
                                                    <select style="margin: 10px 10px 10px 2px; max-width: 130px;" id="muestraPais2"></select>
                                                    <span style="margin: 10px 5px 10px 0px;" >Asociar al Departamento: </span>
                                                    <select style="margin: 10px 10px 10px 2px; max-width: 130px;"  id="muestraEstado2"></select>
                                                    <button class="btn btn-success" style="margin: 10px 0px 10px 0px;" id="envioDatosCiudad"><i class="fas fa-upload"></i> Ingresar Valores</button>
                                                </div>
                                                <div style="border: 1px solid #909090; padding: 0 35px; margin: 5px 0; border-radius:15px;">
                                                    <span>Agregar Barrio</span>  
                                                    <input id="addZone" type="text" style="width: 57%; margin: 10px 30px 10px 115px; border-radius: 5px" value=""><br>
                                                    <span style="margin: 10px 5px 10px 0px;" >Asociar al País: </span>  
                                                    <select style="margin: 10px 10px 10px 2px; max-width: 130px;"  name="" id="muestraPais3"></select>
                                                    <span style="margin: 10px 5px 10px 0px;" >Asociar al Departamento: </span>  
                                                    <select style="margin: 10px 10px 10px 2px; max-width: 130px;" id="muestraEstado3"></select>
                                                    <span style="margin: 10px 5px 10px 0px;" >Asociar al País: </span>  
                                                    <select style="margin: 10px 10px 10px 2px; max-width: 130px;" id="muestraCiudad3"></select>
                                                    <button class="btn btn-success" style="margin: 10px 0px 10px 0px;" id="envioDatosBarrio"><i class="fas fa-upload"></i> Ingresar Valores</button>
                                                </div>                                                
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
        
    </script>
</body>

</html>