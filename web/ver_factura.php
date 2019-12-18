<?php

    $venta_id=  intval($_GET['id_factura']);
    $cliente_id= intval($_GET['cliente_id']);
    
	require_once('pdf/html2pdf.class.php');
    // get the HTML

    require_once('../clase/Caja.php'); 
require_once('../clase/Cliente.php'); 

$caja = new Caja();
$cliente = new Cliente();



     ob_start();
     include('ver_factura_html.php');
    $content = ob_get_clean();

    try
    {
        // init HTML2PDF
        $html2pdf = new HTML2PDF('P', 'LETTER', 'es', true, 'UTF-8', array(0, 0, 0, 0));
        // display the full page
        $html2pdf->pdf->SetDisplayMode('fullpage');
        // convert
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        // send the PDF
        $html2pdf->Output('Factura.pdf');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
