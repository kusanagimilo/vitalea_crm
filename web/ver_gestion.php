<?PHP require_once '../include/script.php';
require_once '../include/header_administrador.php';

require_once '../clase/Cliente.php';
require_once '../clase/Gestion.php';
require_once '../clase/Caja.php';
require_once '../clase/Cotizacion.php';


$cliente = new Cliente();
$gestion = new Gestion();
$caja    = new Caja();
$cotizacion = new Cotizacion(); 

$gestion_id = base64_decode($_REQUEST["gestion_id"]);

$info_gestion = $gestion->detalle_gestion($gestion_id);

if(empty($info_gestion)){

}else{
    foreach ($info_gestion as  $valor) {
        $fecha_ingreso = $valor["fecha_ingreso"];
        $usuario = $valor["usuario"];
        $causal = $valor["causal"];
        $nombre = $valor["nombre"];


        $medio_comunicacion = $valor["medio_comunicacion"];
        $nota = $valor["nota"];

        $cotizacion_item = $valor["cotizacion"];
        $venta = $valor["venta"];
        $cotizacion_id = $valor["cotizacion_id"];
        $venta_id = $valor["venta_id"];
        $imagen = $valor["imagen"];
        $cliente_id = $valor["cliente_id"];
        $mensaje = $valor["mensaje"];
        $medio_comunicacion_id = $valor["medio_comunicacion_id"];
     
    }
}

$info_cliente = $cliente->consultar_paciente($cliente_id);

foreach ($info_cliente as $dato) {
    $nombre = $dato["nombre"];
    $tipo_documento = $dato["tipo_documento"];
    $documento = $dato["documento"];
    $estado_cliente = $dato["estado_cliente"];
    $tipo_cliente = $dato["tipo_cliente"];
    $telefono_1 = $dato["telefono_1"];
}

?>

<script>
    
    $(document).ready(function() {
     
        $('#lista_examenes').DataTable();
} );
    </script>
        <script src="../include/constante.js" ></script>
    <style type="text/css">

        table { vertical-align: top; }
        tr    { vertical-align: top; }
        td    { vertical-align: top; }
        .midnight-blue{
            background:#2c3e50;
            padding: 4px 4px 4px;
            color:white;
            font-weight:bold;
            font-size:12px;
        }
        .silver{
            background:white;
            padding: 3px 4px 3px;
        }
        .clouds{
            background:#ecf0f1;
            padding: 3px 4px 3px;
        }
        .border-top{
            border-top: solid 1px #bdc3c7;
            
        }
        .border-left{
            border-left: solid 1px #bdc3c7;
        }
        .border-right{
            border-right: solid 1px #bdc3c7;
        }
        .border-bottom{
            border-bottom: solid 1px #bdc3c7;
        }
        table.page_footer {width: 100%; border: none; background-color: white; padding: 2mm;border-collapse:collapse; border: none;}
        }

    </style>
<body style="background-color: #F6F8FA">

    <div class="main-menu-area mg-tb-40">
        <div class="container" style="height:auto;">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                   

                    <div class="row pad-top" style="background-color: white;">
                      
                       
                            <div id="gestiones" style="padding: 20px;">
                                <p style="font-size: 11pt;">
                                        <img src="images/info.png" alt=""/>
                                        Gestion </p> 
                               <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">          
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 ">
                                    <div style="width: 100%;" class="clouds"> <img src="images/fecha.png"><b> Fecha</b></div>
                                    <?php echo $fecha_ingreso; ?>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                              
                                    <div style="width: 100%;" class="clouds"> <img src="images/item.png"><b> Tipificacion</b></div>     
                                    <?php echo $causal." - ".$nombre; ?>
                                </div>
                            </div>
                             <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                 <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                               
                                     <div style="width: 100%;" class="clouds"> <img src="images/gestion_llamada.png"><b> Usuario</b></div>
                                     <?php echo $usuario;  ?>
                                 </div>

                                  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 ">
                                   
                                       <div style="width: 100%;" class="clouds"> <img src="images/informacion.png"><b> Observación</b></div>
                                    <?php echo $nota ?>
                                </div>
                            </div>
                             <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                                 <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                   
                                    <div style="width: 100%;" class="clouds"> <img src="images/call-center.png"><b> Medio de Comunicacion</b></div>
                                    <img src="<?php echo $imagen ?>">
                                    <?php echo $medio_comunicacion ; ?>
                                </div>

                                <?php 
                                if($medio_comunicacion_id <= 7){ ?>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                   
                                    <div style="width: 100%;" class="clouds"> <img src="images/charlar.png"><b> Mensaje</b></div>
                                   
                                    <?php echo $mensaje ; ?>
                                </div>

                             <?php    }
                                ?>
                            </div>
                                 
                               
                                <br>
                                <hr style="width: 100%">
                                 <p style="font-size: 11pt;">
                                        <img src="images/info.png" alt=""/>
                                        Paciente </p> 
                              
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                    <div style="width: 100%;" class="clouds"> <img src="images/basico.png"><b> Identificación</b></div>
                                    <?php echo $tipo_documento.": <b>".$documento ."</b>"; ?>
                                </div>
                                 <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                     <div style="width: 100%;" class="clouds"> <img src="images/cliente_1.png"><b> Nombre Completo</b></div>
                                    <?php echo $nombre ; ?>
                                </div>
                                  <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                    <div style="width: 100%;" class="clouds"> <img src="images/estado_cliente.png"><b> Tipo Paciente </b></div>
                                    <?php echo $tipo_cliente ; ?>
                                </div>
                                  <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                     <div style="width: 100%;" class="clouds"> <img src="images/estado_precliente.png"><b> Estado </b></div>
                                    <?php echo $estado_cliente ; ?>
                                </div>
                         

                            <hr style="width: 100%; margin:10px;">
                            <?php if($venta == 1){ 
                                    //CONSULTAR  FACTURA 

                                $datos_venta = $caja->consultar_examenes_venta($cliente_id,$venta_id);
                                $detalles_venta = $caja->detalles_venta($cliente_id,$venta_id);


                                foreach ($detalles_venta as $valor) {
                                   $fecha_pago = $valor["fecha_pago"];
                                   $vendedor = $valor["vendedor"];
                                   $medio_pago = $valor["medio_pago"];
                                }

                                ?>

<br><br>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">   

                                <fieldset>
                                    <legend style="color:#00c292; font-size: 15pt;">
                                    <img src="images/pdf_pequenio.png" alt=""/>
                                Detalle de la venta</legend>
                                        <br>
                                <table cellspacing="0" style="width: 100%; text-align: left; font-size: 11pt;">
                                    <tr>
                                       <td style="width:35%;" class='midnight-blue'>VENDEDOR</td>
                                      <td style="width:25%;" class='midnight-blue'>FECHA</td>
                                       
                                          <td style="width:40%;" class='midnight-blue'>FORMA DE PAGO</td>
                                
                                    </tr>
                                    <tr>
                                       <td style="width:35%;">
                                        <?php echo $vendedor; ?>
                                       </td>
                                      <td style="width:25%;"> <?php echo $fecha_pago ?></td>
                                  
                                       <td style="width:40%;" >
                                            <?php echo $medio_pago; ?>
                                       </td>
                                    
                                    </tr>
                                </table>

                                <br>
                                  
                                    <table cellspacing="0" style="width: 100%; text-align: left; font-size: 10pt;">
                                        <tr>
                                            <td style="width: 10%;text-align:center" class='midnight-blue'>CANT.</td>
                                            <td style="width: 60%" class='midnight-blue'>DESCRIPCION</td>
                                            <td style="width: 15%;text-align: right" class='midnight-blue'>DESCUENTO</td>
                                            <td style="width: 15%;text-align: right" class='midnight-blue'>PRECIO TOTAL</td>
                                            
                                        </tr>

                                        <?php


                                         foreach ($datos_venta as $item) {  ?>
                                        <tr>
                                            <td class='silver' style="width: 10%; text-align: center">1</td>
                                            <td class='clouds' style="width: 60%; text-align: left"><?php echo $item["nombre"]; ?></td>
                                            <td class='silver' style="width: 15%; text-align: right"><?php echo $item["descuento"]; ?></td>
                                            <td class='silver' style="width: 15%; text-align: right"><?php echo $item["valor"]; ?></td>
                                            
                                        </tr>
                                        <?php } 

                                        $suma_venta = $caja->suma_venta($venta_id);
                                         ?>
                                 
                                        
                                        <tr>
                                            <td colspan="3" style="widtd: 85%; text-align: right;">TOTAL $</td>
                                            <td style="widtd: 15%; text-align: right;"> <?php echo $suma_venta; ?></td>
                                        </tr>
                                    </table>

                                        <button type="button" class="btn btn-default" onclick="imprimir_factura(<?php echo  $venta_id  ?>, <?php echo $cliente_id; ?>)">
                                                                 <img src="images/pdf_pequenio.png" alt=""/>  Ver Factura
                                        </button>
                                    </fieldset>
                               </div>                                 
                          <?php  }
                          if($cotizacion_item == 1)  { 
                            //CONSULTAR COTIZACION
                            ?>
                              <fieldset>
                                    <legend style="color:#00c292; font-size: 15pt;">
                                    <img src="images/pdf_pequenio.png" alt=""/>
                                Detalle de la cotización</legend>

                                <br>


              
                                <table cellspacing="0" style="width: 100%; text-align: left; font-size: 10pt;">
                                  <tr>
                                      <th style="width: 10%;text-align:center" class="midnight-blue">CANT.</th>
                                      <th style="width: 60%" class="midnight-blue">DESCRIPCION</th>
                                      <th style="width: 15%;text-align: right" class="midnight-blue">DESCUENTO</th>
                                      <th style="width: 15%;text-align: right" class="midnight-blue">PRECIO TOTAL</th>
                                      
                                  </tr>
                                  <?php 

                                   $listado_cotizacion = $cotizacion->consultar_items_cotizacion($cotizacion_id);
                                    $i=1;
                                     foreach ($listado_cotizacion as $item) {  ?>
                                         <tr>
                                              <td class="silver" style="width: 10%; text-align: center"><?php echo $i++; ?></td>
                                              <td class="clouds" style="width: 60%; text-align: left"><?php echo $item["examen"] ?></td>
                                              <td class="silver" style="width: 15%; text-align: right"><?php echo $item["descuento"] ?></td>
                                              <td class="silver" style="width: 15%; text-align: right"><?php echo number_format($item["valor"],0,',','.') ?></td>
                                              
                                          </tr>
                                   <?php  } 

                                       $suma_cotizacion = $cotizacion->suma_cotizacion($cotizacion_id); ?>
                                     
                                      <tr>
                                                <td colspan="3" style="widtd: 85%; text-align: right;">TOTAL $</td>
                                                <td style="widtd: 15%; text-align: right;"><?php number_format($suma_cotizacion,0,','.'.')  ?></td>
                                              </tr>
                                              </table>

                                        <br>
                                <a  href="javascript:VentanaCentrada('../controlador/Cotizacion_<?php echo $cotizacion_id ?>.pdf','Ventas','','1024','768','true')" style="float: right; margin-right: 5px;" >
                                                             <img src="images/pdf_pequenio.png" alt=""/>  Ver Cotizacion
                                                          </a>
                                </fieldset>                          
                           <?php } ?>
                        
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