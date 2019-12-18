<?php

function PDFTICKET($id) {

    ob_start();

    include_once '../conexion/conexion_bd.php';
    //$id = $_REQUEST['venta'];
    $conexion = new Conexion();
    $query = $conexion->prepare("SELECT ven.id as id_venta,cli.id_cliente,tpd.nombre as tipo_doc,cli.documento,ges.observacion,
mdp.medio_pago,CONCAT(cli.nombre,' ',cli.apellido) as cliente,
SUM(vei.valor) as total_venta,ven.fecha_creacion,ven.fecha_pago,ven.estado,mdp.id as id_medio_pago,ven.codigo_venta
FROM venta ven
INNER JOIN gestion ges ON ges.id = ven.gestion_id
INNER JOIN cliente cli ON cli.id_cliente = ven.cliente_id
INNER JOIN tipo_documento tpd ON tpd.id = cli.tipo_documento
INNER JOIN medio_pago mdp ON mdp.id = ven.medio_pago
INNER JOIN venta_items vei ON vei.venta_id = ven.id 
WHERE ven.id=:id
GROUP BY ven.id");
    $query->execute(array(':id' => $id));

    $rows = $query->fetchAll(PDO::FETCH_ASSOC);

    ?>
    <style type="text/css">
        <!--
        div.zone { border: none; border-radius: 6mm; background: #FFFFFF; border-collapse: collapse; padding:3mm; font-size: 2.7mm;}
        h1 { padding: 0; margin: 0; color: #DD0000; font-size: 7mm; }
        h2 { padding: 0; margin: 0; color: #222222; font-size: 5mm; position: relative; }
        -->
    </style>
    <page format="100x200" orientation="L" backcolor="#d4f0ff" style="font: arial;"> 

        <table style="width: 99%;border: none;" cellspacing="4mm" cellpadding="0">
            <tr>
                <td colspan="2" style="width: 100%">
                    <div class="zone" style="height: 34mm;position: relative;font-size: 5mm;">
                        <div style="position: absolute; right: 3mm; top: 3mm; text-align: right; font-size: 4mm; ">
                            <b><?php echo $rows[0]['cliente']; ?></b><br>
                        </div>
                        <div style="position: absolute; right: 3mm; bottom: 3mm; text-align: right; font-size: 4mm; ">
                            Documento : <b><?php echo $rows[0]['documento']; ?></b><br>
                            Medio de pago : <b><?php echo $rows[0]['medio_pago']; ?></b><br>
                            Fecha solicitud : <b><?php echo $rows[0]['fecha_creacion']; ?></b><br>
                            Codigo unico : <b><?php echo $rows[0]['codigo_venta']; ?></b><br>
                            Valor : <b><?php echo number_format($rows[0]['total_venta']); ?></b><br>
                        </div>
                        
                        &nbsp;&nbsp;<b>Bienvenido a Vitalea</b><br>

                    </div>
                </td>
            </tr>
            <tr>
                <td style="width: 25%;">
                    <div class="zone" style="height: 40mm;vertical-align: middle;text-align: center;">
                        <qrcode value="<?php echo $rows[0]['id_venta']; ?>" ec="Q" style="width: 37mm; border: none;" ></qrcode>
                    </div>
                </td>
                <td style="width: 75%">
                    <div class="zone" style="height: 40mm;vertical-align: middle; text-align: justify">
                        <b>Terminos y condiciones</b><br>
                        Este ticket deber&aacute; ser presentado en las instalaciones de Vitalea 
                        impreso o en forma digital, posee un c&oacute;digo QR con el cual se le asignar&aacute; un turno para 
                        realizar el pago de los servicios que solicit&oacute; o para pasar a toma de muestras.<br>
                        <br>
                        <i>La asignaci&oacute;n de el turno solo se dar&aacute; cuando dicho QR sea presentado 
                            en las instalaciones de Vitalea</i>
                    </div>
                </td>
            </tr>
        </table>
    </page>
    <?php
    $content = ob_get_clean();
    //require_once("../" . dirname(__FILE__) . '/html2pdf.class.php');
    require_once ('../web/pdf/html2pdf.class.php');
  
    try {

        $html2pdf = new HTML2PDF('P', 'b4', 'es', false, 'ISO-8859-15', array(0, 0, 0, 0));
        $html2pdf->pdf->SetDisplayMode('fullpage');
   
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
    
     
        $html2pdf->Output('TICKET_VENTA_' . $id . '.pdf', 'F');
    	
    
        return 1;
    } catch (HTML2PDF_exception $e) {
        return 3;
    }
}
?>