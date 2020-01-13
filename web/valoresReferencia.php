<?php
require_once '../include/script.php';
require_once '../include/header_administrador.php';
?>

<body style="background-color: #F6F8FA;">
     <input id="usuario" value="<?php echo $_SESSION['ID_USUARIO'] ?>" type="hidden" >

    <div class="main-menu-area mg-tb-40" style="min-height: 450px;">
        <div class="container" style="height:auto;">
            <div class="row">
            	
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <ol class="breadcrumb">
                        
                        <li><a href="inicio_administrador.php" title="Volver atras"><img src="images/atras.png"></a></li>
                        <li><a href="inicio_administrador.php" title="Inicio">Inicio</a></li>
                        
                        <li class="active">Valores de Referencia</li>
                    </ol>

                    <div class="panel panel-default">
                        <div class="panel-heading " style="height: 50px;">
                            <h3 class="panel-title"> 
                                <b  style="float: left">  <img src="images/agregar-usuario.png" alt=""/> 
                                Valores de Referencia</b> </h3> 
                        </div>
                        <div class="panel-body" >
                            <div class="row pad-top" style="background-color: white; padding: 20px;">
                                      <p style=" font-size: 11pt;">
                                        <img src="images/info.png" alt=""/>
                                        Solicite el n&uacute;mero de documento y digitelo sin puntos. De clic en buscar.
                                </p><br>
                        
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
                                             <button class="btn btn-info notika-btn-success waves-effect" id="buscar" style="width: 100%;">
                                    
                                                <img src="images/lupa.png" alt="" style="width: 20px;"/>
                                                Buscar</button> 
                                        </div>
                                    </div>    
                                </div>  
                        
                        </div>    
                    </div>
                </div>
            </div>
        </div>
    </div>    

<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header" style=" background-color: white;border-bottom: 1px solid #00c292;">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" style=" font-size: 15pt;">
                      <img src="images/cliente_1.png" alt="" style="width: 30px;"/> Informaci&oacute;n del cliente</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div id="div_informacion_cliente">
                        
                    </div>
                </div>
           
            </div>
            <div class="modal-footer">

                <h4><b> Seleccione una opcion </b></h4>
                   
            <?php if($vista == 1){?>
                <button type="button" class="btn btn-default" data-dismiss="modal" style="float: right;background-color: #ccc;border-color: #00c292;border:0px solid #ccc;outline:none;box-shadow:none;color:black">
                    <img src="images/cerrar.png" alt="" style="width: 20px"/>
                    Cancelar</button>
                <button class="btn btn-primary" id="btn_gestionar_registro" style="float: right;
                        background-image:linear-gradient(to bottom,#337ab7 0,#265a88 100%)">
                    <img src="images/finalizar.png" alt="" style="width: 20px"/>
                    Calificar Gestion</button>  
            <?php } ?>
            <?php if($vista == 2){?>
                    <button class="btn btn-success" id="btn_ir_caja" style="float: right;
                     ">
                    <img src="images/pago.png" alt="" style="width: 20px"/>
                    Generar Venta o Cotizacion</button>  
            <?php } 
            if($vista == 3){//digiturno?>
                    <button type="button" class="btn btn-default" data-dismiss="modal" style="float: right;background-color: #ccc;border-color: #00c292;border:0px solid #ccc;outline:none;box-shadow:none;color:black">
                    <img src="images/cerrar.png" alt="" style="width: 20px"/>
                    Cancelar</button>
                    <button class="btn btn-primary" id="btn_pagar" style="float: right;
                        background-image:linear-gradient(to bottom,#337ab7 0,#265a88 100%)">
                    <img src="images/finalizar.png" style="width: 20px"/>
                    Pagar</button>
                    <button class="btn btn-primary" id="btn_toma_muestra" style="float: right;
                        background-image:linear-gradient(to bottom,#337ab7 0,#265a88 100%)">
                    <img src="images/finalizar.png" style="width: 20px"/>
                    Tomar muestra</button>
            <?php } ?>  

            </div>
        </div>

    </div>
</div>  

    <?php require_once '../include/footer.php'; ?>
</body>
