<?PHP require_once '../include/script.php';
require_once '../include/header_sin_menu.php';
require_once '../clase/Caja.php';

$caja= new Caja();

$opcion = base64_decode($_REQUEST["o"]);
$cliente_id = base64_decode($_REQUEST["x"]);

if($opcion == 1){ // CONSULTAR VENTAS
    $campo = "fecha_pago";
    $tabla_principal = "venta";
    $tabla_inner = "venta_items";
    $id = "venta_id";
    $titulo ="Ventas";
    $img = "pago_paciente";
}
else if($opcion == 2){ // CONSULTAR COTIZACIONS
    $campo = "fecha_cotizacion";
    $tabla_principal = "cotizacion";
    $tabla_inner = "cotizacion_items";
    $id = "cotizacion_id";
    $titulo ="Cotizaciones";
    $img = "resultados-medicos";
}


$informacion = $caja->consultar_ventas_cotizaciones($cliente_id, $campo, $tabla_principal,$tabla_inner ,$id);


?>


<script>
    
    $(document).ready(function() {
     
        $('#lista_examenes').DataTable();
} );
    </script>
    <script src="../include/constante.js" ></script>
<body style="background-color: #F6F8FA">

    <div class="main-menu-area mg-tb-40">
        <div class="container" style="height:auto;">
            <div class="row">
                <ol class="breadcrumb">
                        <li><a  onclick="window.close()" title="Volver atras"><img src="images/atras.png"></a></li>
                       
                        <li><a onclick="window.close()" title="Inicio">Ventas y/o Cotizaciones</a></li>
                        <li class="active"><?php echo $titulo ?> </li>
                    </ol>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                   

                    <div class="row pad-top" style="background-color: white;">
                      
                       
                            <div id="examenes" style="padding: 20px;">
                                <div class="row">
                                
                                           
                                          <div class="panel panel-default">
                                              <div class="panel-heading" style="height: 50px;">
                                        <h3 class="panel-title"> 
                                            <b  style="float: left">  <img src="images/<?php echo $img; ?>.png" alt=""/> 
                                            Lista de <?php echo $titulo; ?></b> </h3>
                                                </div>
                                              <div class="panel-body" class="table table-responsive">
                                                   <table id="lista_examenes" class="table table-bordered">
                                            <thead>
                                                <tr style="background-color: white;">
                                                    <th style="color:#214761">Fecha</th>
                                                    <th style="color:#214761">Usuario que realizo <?php echo $titulo ?> </th>
                                                    <th style="color:#214761">Valor $</th>
                                                    <th style="color:#214761">Detalle</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                
                                                foreach ($informacion as $datos_solicitud){?>
                                                <tr>
                                                    <td><?php echo $datos_solicitud["".$campo.""] ?></td>
                                                    <td><?php echo $datos_solicitud["usuario_id"] ?></td>
                                                   
                                                    <td><?php echo number_format($datos_solicitud["valor"],0,",",".") ?></td>
                                                    
                                                    <td>

                                                        <?php if($opcion == 1){ ?>
                                                            <center>
                                                            <button type="button" class="btn btn-default" onclick="imprimir_factura(<?php echo   $datos_solicitud["id"]  ?>, <?php echo $cliente_id; ?>)">
                                                                 <img src="images/pdf_pequenio.png" alt=""/>  Ver Factura
                                                                </button>
                                                            </center>
                                                        <?php }
                                                        else if($opcion == 2){ ?>
                                                            <center>
                                                         <a  href="javascript:VentanaCentrada('../controlador/Cotizacion_<?php echo $datos_solicitud["id"] ?>.pdf','Ventas','','1024','768','true')" style="float: right; margin-right: 5px;" >
                                                             <img src="images/pdf_pequenio.png" alt=""/>  Ver Cotizacion
                                                          </a>
                                                     </center>
                                                        <?php  }?> 
                                                    </td>
                                                   
                                                    
                                                </tr>
                                               <?php }
                                                
                                                ?>
                                            </tbody>
                                        </table>
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

</body>

</html>