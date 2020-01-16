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
</style>


<page backtop="15mm" backbottom="15mm" backleft="15mm" backright="15mm" style="font-size: 12pt; font-family: arial" >
        <page_footer>
        <table class="page_footer">
            <tr>

                <td style="width: 50%; text-align: left">
                    P&aacute;gina [[page_cu]]/[[page_nb]]
                </td>
                <td style="width: 50%; text-align: right">
                    &copy; <?php echo "COLCAN "; echo  $anio=date('Y'); ?>
                </td>
            </tr>
        </table>
    </page_footer>
	<?php include("encabezado_factura.php");?>
    <br>
    

	
    <table cellspacing="0" style="width: 100%; text-align: left; font-size: 11pt;">
        <tr>
           <td style="width:50%;" class='midnight-blue'>FACTURAR A</td>
        </tr>
		<tr>
           <td style="width:50%;" >
			<?php echo $nombre_cliente ?> <br>
			<?php echo $direccion ?> <br>
			<?php echo $telefono_1 ?>

		   </td>
        </tr>
        
   
    </table>
    
       <br>
		<table cellspacing="0" style="width: 100%; text-align: left; font-size: 11pt;">
        <tr>
           <td style="width:35%;" class='midnight-blue'>VENDEDOR</td>
		  <td style="width:25%;" class='midnight-blue'>FECHA</td>
            <?php if($opcion == 1){ ?>
		      <td style="width:40%;" class='midnight-blue'>FORMA DE PAGO</td>
            <?php } ?>
        </tr>
		<tr>
           <td style="width:35%;">
			<?php echo $usuario; ?>
		   </td>
		  <td style="width:25%;"> <?php echo $fecha_cotizacion ?></td>
        <?php if($opcion == 1){ ?>
		   <td style="width:40%;" >
				Credito
		   </td>
        <?php } ?>   
        </tr>
		
        
   
    </table>
	<br>
  
    <table cellspacing="0" style="width: 100%; text-align: left; font-size: 10pt;">
        <tr>
            <th style="width: 10%;text-align:center" class='midnight-blue'>CANT.</th>
            <th style="width: 60%" class='midnight-blue'>DESCRIPCION</th>
            <th style="width: 15%;text-align: right" class='midnight-blue'>DESCUENTO</th>
            <th style="width: 15%;text-align: right" class='midnight-blue'>PRECIO TOTAL</th>
            
        </tr>

        <?php
         $listado_cotizacion = $cotizacion->consultar_items_cotizacion($cotizacion_id);

         foreach ($listado_cotizacion as $item) {  ?>
        <tr>
            <td class='silver' style="width: 10%; text-align: center">1</td>
            <td class='clouds' style="width: 60%; text-align: left"><?php echo $item["examen"]; ?></td>
            <td class='silver' style="width: 15%; text-align: right"><?php echo $item["descuento"]; ?></td>
            <td class='silver' style="width: 15%; text-align: right"><?php echo $item["valor"]; ?></td>
            
        </tr>
        <?php } 

        $suma_cotizacion = $cotizacion->suma_cotizacion($cotizacion_id);
         ?>
 
        
		<tr>
            <td colspan="3" style="widtd: 85%; text-align: right;">TOTAL $</td>
            <td style="widtd: 15%; text-align: right;"> <?php echo $suma_cotizacion; ?></td>
        </tr>
    </table>

</page>

