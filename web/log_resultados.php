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

                        <li class="active">Log carga de resultados</li>
                    </ol>
                    <div class="panel panel-default">
                        <div class="panel-heading " style="height: 50px;">
                            <h3 class="panel-title"> 
                                <b  style="float: left">  <img src="images/buscar_cliente_1.png" alt=""/> 
                                    Log carga de resultados</b> 
                            </h3> 
                        </div>
                        <div class="panel-body" >
                            <div class="row pad-top" style="background-color: white; padding: 20px;">
                                <p style=" font-size: 11pt;">
                                    <img src="images/info.png" alt=""/>
                                    Solicite el número de documento y digítelo sin puntos. De clic en buscar, en 
                                    este modulo se mostraran los resultados que no se lograron adicionar a una 
                                    solicitud, las razones por las cuales no pudo haber adicionado un resultado 
                                    son las siguientes : (el código del examen no existe y se debe crear, no esta asociado el examen a un perfil o el código de el examen esta mal escrito).
                                    <br>
                                    Si corrige el error en administración de exámenes , este modulo le permite usar los exámenes que no se 
                                    lograron adicionar para realizar el cargue
                                </p>
                                <br>

                                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                    <div class="form-group">
                                        <span class="input-group-addon nk-ic-st-pro" style="float: left; width: 20%">
                                            <img src="images/cliente_1.png" alt="" style="width: 30px;"/>
                                        </span>
                                        <div class="nk-int-st"  style="float: left; width: 80%">
                                            <input name="documento" id="documento" class="form-control" type="text" placeholder=" Numero de documento"> 

                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                    <div class="form-group">
                                        <button onclick="ResultadosIndividualLog()" class="btn btn-info notika-btn-success waves-effect" id="buscar" style="width: 100%;">

                                            <img src="images/lupa.png" alt="" style="width: 20px;"/>
                                            Buscar
                                        </button> 
                                    </div>
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
                        <img src="images/examen_venta.png" alt=""/>Logs en detalle</h4>
                </div>
                <div class="modal-body col-md-12" style="height: 400px; overflow : auto;" id="cuerpo_modal">



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