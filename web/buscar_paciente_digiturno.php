<?PHP
//require_once '../include/script.php';
require_once '../include/script.php';
require_once '../include/header_administrador.php';
?>
<script src="dist/sweetalert.min.js"></script>
<link rel="stylesheet" type="text/css" href="dist/sweetalert.css">
<script type="text/javascript" src="../ajax/DgTurno.js"></script>
<body style="background-color: #F6F8FA;">


    <div class="main-menu-area mg-tb-40" style="min-height: 450px;">
        <div class="container" style="height:auto;">
            <div class="row">

                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <ol class="breadcrumb">
                        <li><a href="inicio_digiturno_generar_turno.php" title="Volver atras"><img src="images/atras.png"></a></li>
                        <li><a href="inicio_digiturno_generar_turno.php" title="Inicio">Inicio</a></li>
                        <li class="active">Busqueda de solicitudes por documento</li>
                    </ol>

                    <div class="panel panel-default">
                        <div class="panel-heading " style="height: 50px;">
                            <h3 class="panel-title"> 
                                <b  style="float: left">  <img src="images/buscar_cliente_1.png" alt=""/> 
                                    Busqueda de solicitudes por documento</b> </h3> 
                        </div>
                        <div class="panel-body" >
                            <div class="row pad-top" style="background-color: white; padding: 20px;">
                                <p style=" font-size: 11pt;">
                                    <img src="images/info.png" alt=""/>
                                    Ingrese el n&uacute;mero de documento y digitelo sin puntos. De clic en buscar.
                                </p><br>

                                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                    <div class="form-group">
                                        <span class="input-group-addon nk-ic-st-pro" style="float: left; width: 20%">
                                            <img src="images/cliente_1.png" alt="" style="width: 30px;"/>
                                        </span>
                                        <div class="nk-int-st"  style="float: left; width: 80%">
                                            <input name="documento" id="documento" class="form-control" type="text" placeholder="Numero de documento"> 
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                    <div class="form-group">
                                        <button onclick="BusquedaTurnosDisponibles()" class="btn btn-info notika-btn-success waves-effect" id="buscar" style="width: 100%;">
                                            <img src="images/lupa.png" alt="" style="width: 20px;"/>
                                            Buscar</button> 
                                    </div>
                                </div>    
                            </div>  

                        </div>    
                    </div>

                    <div class="panel panel-default">
                        <div class="panel-heading " style="height: 50px;">
                            <h3 class="panel-title"> 
                                <b  style="float: left">Solicitar turno</b></h3> 
                        </div>
                        <div class="panel-body" id="contenedor_turnos">
                            En esta seccion se cargaran las solicitudes disponibles para solicitar un turno
                        </div>    
                    </div>




                </div>
            </div>
        </div>
    </div>    



</body>
<?php require_once '../include/footer.php'; ?>
</html>