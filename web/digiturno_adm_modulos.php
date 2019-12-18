<?PHP
require_once '../include/script.php';
require_once '../include/header_administrador.php';
?>
<script src="../ajax/Modulo.js" type="text/javascript"></script>
<body style="background-color: #F6F8FA">

    <div class="main-menu-area mg-tb-40">
        <div class="container" style="height:auto;">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <ol class="breadcrumb">
                        <li><a href="inicio_admin_digiturno.php" title="Inicio">Inicio</a></li>
                        <li class="active">Administrar modulos</li>
                    </ol>

                    <div class="row pad-top" style="background-color: white;">

                        <div id="clientes" style="padding: 20px;">
                            <div class="row">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h3 class="panel-title"> 
                                            <img src="images/lista.png" alt=""/> 
                                            <b> Administrar modulos</b></h3>
                                    </div>
                                    <div class="panel-body">

                                        <center>
                                            <input type="button" data-toggle="modal" data-target="#myModalResultados"  value="Crear Modulo" class="btn btn btn-success">
                                        </center>
                                        <br>
                                        <div id="tabla_modulos">

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

    <!--<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" style="text-align: right;">                 
        <button type="button" id="openBtn" class="btn btn-default" data-toggle="modal" data-target="#myModalResultados"> <img src="images/anadir_dos.png"> Agregar examen</button>
    </div> -->
    <div class="modal" id="myModalResultados"  role="dialog" aria-labelledby="myModalLabel" >
        <div class="modal-dialog" style="width: 80%;">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #214761; color: white" >
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">
                        <img src="images/examen_venta.png" alt=""/>Crear modulo</h4>
                </div>
                <div class="modal-body col-md-12" style="height: 300px; overflow : auto;" id="cuerpo_modal">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th colspan="2">Crear modulo</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Ingrese el nombre de el modulo</td>
                                <td><input class="form-control" type="text" name="modulo" id="modulo"></td>
                            </tr>
                            <tr>
                                <td colspan="2">
                        <center>
                            <input type="button" value="Crear modulo" onclick="CrearModulo()" class="btn btn-success">
                        </center>
                        </td>
                        </tr>
                        </tbody>
                    </table>
                </div>          
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal" style="font-size: 11pt;"><img src="images/cerrar_dos.png"> Cerrar</button>
                </div>
            </div>                            
        </div>
    </div>  



    <div class="modal" id="myModalUsuariosModulo"  role="dialog" aria-labelledby="myModalLabel" >
        <div class="modal-dialog" style="width: 80%;">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #214761; color: white" >
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">
                        <img src="images/examen_venta.png" alt=""/>Usuario asignado al modulo</h4>
                </div>
                <div class="modal-body col-md-12" style="height: 500px; overflow : auto;" id="cuerpo_modal_mdusuarios">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th colspan="3">
                        <center>Usuario asignado a este modulo</center>
                        </th>
                        </tr>
                        <tr>
                            <th>Ususario</th>
                            <th>Tipo atencion</th>
                            <th>Editar tipo atencion</th>
                        </tr>
                        </thead>
                        <tbody id="cont_usrasignado">

                        </tbody>
                    </table>
                    <div id="formulario_mdusario">

                    </div>
                </div>          
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal" style="font-size: 11pt;"><img src="images/cerrar_dos.png"> Cerrar</button>
                </div>
            </div>                            
        </div>
    </div>  
    <!-- End Contact Info area-->
    <?php require_once '../include/footer.php'; ?>
    <script>
        VerModulos();
    </script>
</body>

