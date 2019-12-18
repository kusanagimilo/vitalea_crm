<?PHP
//require_once '../include/script.php';
require_once '../include/script.php';
require_once '../include/header_administrador.php';
?>
<script type="text/javascript" src="../ajax/Resultado.js"></script>
<body style="background-color: #F6F8FA;">
    <div class="main-menu-area mg-tb-40" style="min-height: 450px;">
        <div class="container" style="height:auto;">
            <div class="row">

                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <ol class="breadcrumb">

                        <li><a href="sub_menu_resultados.php" title="Volver atras"><img src="images/atras.png"></a></li>

                        <li class="active">Ver resultados por paciente</li>
                    </ol>
                    <div class="panel panel-default">
                        <div class="panel-heading " style="height: 50px;">
                            <h3 class="panel-title"> 
                                <b  style="float: left">  <img src="images/buscar_cliente_1.png" alt=""/> 
                                    Ver resultados por paciente</b> 
                            </h3> 
                        </div>
                        <div class="panel-body" >
                            <div class="row pad-top" style="background-color: white; padding: 20px;">
                                <p style=" font-size: 11pt;">
                                    <img src="images/info.png" alt=""/>
                                    Seleccione los filtros necesarios para realizar la busqueda (si desea buscar todos los resultados oprima el boton buscar)
                                </p>
                                <br>



                                <div class="col-md-6">
                                    Nº de documento : <input id="documento" name="documento" type="text" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    Id solicitud : <input id="id_solicitud" name="id_solicitud" type="text" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    Se han registrado resultados :
                                    <select class="form-control" id="regi_resul">
                                        <option value="">--seleccione--</option>
                                        <option value="si">SI</option>
                                        <option value="no">NO</option>
                                    </select>
                                </div>

                                <div class="col-md-6" style="margin-top: 25px;">
                                    <button onclick="ResultadosIndividual()" class="btn btn-info notika-btn-success waves-effect" id="buscar" style="width: 100%;">

                                        <img src="images/lupa.png" alt="" style="width: 20px;"/>
                                        Buscar
                                    </button> 
                                </div>    
                            </div>  

                        </div>    
                    </div>


                    <!---------------/////////////--------->					


                    <div class="panel panel-default">
                        <div class="panel-heading " style="height: 50px;">
                            <h3 class="panel-title"> 
                                <b  style="float: left">Resultados</b> 
                            </h3> 
                        </div>
                        <div class="panel-body" id="tabla_resultado">


                        </div>    
                    </div>


                </div>
            </div>
        </div>
    </div>    

    <div class="modal" id="myModalResultados"  role="dialog" aria-labelledby="myModalLabel" >
        <div class="modal-dialog" style="width: 90%;">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #214761; color: white" >
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">
                        <img src="images/examen_venta.png" alt=""/>Detalle</h4>
                </div>
                <div class="modal-body col-md-12" style="height: 400px; overflow : auto;" id="cuerpo_modal">



                </div>          
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal" style="font-size: 11pt;"><img src="images/cerrar_dos.png"> Cerrar</button>
                </div>
            </div>                            
        </div>
    </div>

    <div class="modal" id="myModalAnalito"  role="dialog" aria-labelledby="myModalLabel" >
        <div class="modal-dialog" style="width: 80%;">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #214761; color: white" >
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">
                        <img src="images/examen_venta.png" alt=""/>Detalle analito</h4>
                </div>
                <div class="modal-body col-md-12" style="height: 400px; overflow : auto;" id="cuerpo_analito">



                </div>          
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal" style="font-size: 11pt;"><img src="images/cerrar_dos.png"> Cerrar</button>
                </div>
            </div>                            
        </div>
    </div>



</body>
<?php require_once '../include/footer.php'; ?>
</html>