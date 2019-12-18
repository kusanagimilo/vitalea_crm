<?php
date_default_timezone_set('America/Bogota');
ob_start();

include_once '../conexion/conexion_bd.php';

@$fecha_inicial = $_REQUEST["fecha_inicial"];
@$fecha_final = $_REQUEST["fecha_final"];
@$asesor = $_REQUEST["asesor"];

$fechas = "";
$asesor_seleccionado = "";
if ($fecha_inicial == null || $fecha_final == null) {
    $fechas = "N/A";
} else {
    $fechas = "inicio : " . $fecha_inicial . " fin : " . $fecha_final;
}


$filtro_asesor = "";
$filtro_fecha = "";

if ($asesor != "" || $asesor != NULL) {
    $filtro_asesor = " AND ven.usuario_id  = " . $asesor . "";
}

if ($fecha_inicial != "" || $fecha_inicial != NULL) {
    $filtro_fecha = " AND ven.fecha_pago BETWEEN '" . $fecha_inicial . "' AND '" . $fecha_final . "'";
}


$conexion = new Conexion();
$sql_p = "select ven.*,usr.nombre_completo as nombre_atendio,usr.documento as documento_atendio,
cli.documento as documento_paciente,cli.nombre as paciente_nombre,cli.apellido as apellido_paciente
from venta ven 
inner join usuario usr ON ven.usuario_id = usr.id
inner join cliente cli on ven.cliente_id = cli.id_cliente
INNER JOIN gestion ges ON ges.id = ven.gestion_id
where numero_factura is not null
and factura_athenea = 'SI'
and ven.estado = 2
$filtro_asesor 
$filtro_fecha";



$query = $conexion->prepare($sql_p);

$query->execute();

$rows = $query->fetchAll(PDO::FETCH_ASSOC);


if ($asesor == null) {
    $asesor_seleccionado = "TODOS";
} else {
    @$asesor_seleccionado = $rows[0]["nombre_atendio"];
}

$hoy = date("Y-m-d H:i:s");
?>
<style type="text/css">
    <!--
    div.special { margin: auto; width:95%; border:1px solid #000000; padding: 2px; }
    div.special table { width:100%; border:1px solid #000000; font-size:10px; border-collapse:collapse; }
    .topLeftRight     { border-top:1px solid #000; border-left:1px solid #000; border-right:1px solid #000;}
    .topLeftBottom    { border-top:1px solid #000; border-left:1px solid #000; border-bottom:1px solid #000; }
    .topLeft          { border-top:1px solid #000; border-left:1px solid #000; }
    .bottomLeft       { border-bottom:1px solid #000; border-left:1px solid #000; }
    .topRight         { border-top:1px solid #000; border-right:1px solid #000; }
    .bottomRight      { border-bottom:1px solid #000; border-right:1px solid #000; }
    .topRightBottom   { border-top:1px solid #000; border-bottom:1px solid #000; border-right:1px solid #000; }
    -->
</style>

<page backtop="14mm" backbottom="14mm" backleft="10mm" backright="10mm" orientation="paysage" style="font-size: 12px">

    <table style="width: 100%; border: solid 1px #FFFFFF; font-weight: bold;">
        <tr>
            <td style="width: 30%; border: solid 1px #0000FF;">Fecha generacion arqueo</td>
            <td style="width: 30%; border: solid 1px #0000FF;"><?php echo $hoy; ?></td>
        </tr>
        <tr>
            <td style="width: 30%; border: solid 1px #0000FF;">Rango de fechas</td>
            <td style="width: 30%; border: solid 1px #0000FF;"><?php echo $fechas; ?></td>
        </tr>
        <tr>
            <td style="width: 30%; border: solid 1px #0000FF;">Asesor</td>
            <td style="width: 30%; border: solid 1px #0000FF;"><?php echo $asesor_seleccionado; ?></td>
        </tr>
    </table>
    <br>



    <table style="width: 100%; border: solid 1px #FFFFFF;">
        <tr>
            <td style="width: 100%; border: solid 1px #0000FF; text-align: center;" colspan="8"><b>ARQUEO</b></td>
        </tr>    
        <tr>
            <td style="width: 10%; border: solid 1px #0000FF;">Fecha venta</td>
            <td style="width: 10%; border: solid 1px #0000FF;">Factura</td>
            <td style="width: 10%; border: solid 1px #0000FF;">Medio pago</td>
            <td style="width: 20%; border: solid 1px #0000FF;">Asesor</td>
            <td style="width: 10%; border: solid 1px #0000FF;">Documento asesor</td>
            <td style="width: 20%; border: solid 1px #0000FF;">Paciente</td>
            <td style="width: 10%; border: solid 1px #0000FF;">Documento paciente</td>
            <td style="width: 10%; border: solid 1px #0000FF;">Total venta</td>
        </tr>

        <?php
        foreach ($rows as $key => $value) {

            $medio_pago = "";

            if ($value["medio_pago"] == 1) {
                $medio_pago = "PSE";
            } else if ($value["medio_pago"] == 2) {
                $medio_pago = "EFECTIVO";
            } else if ($value["medio_pago"] == 3) {
                $medio_pago = "TARJETA";
            }

            $sql_valor = "select SUM(valor) as venta_total from venta_items where venta_id = '" . $value["id"] . "'";


            $query2 = $conexion->prepare($sql_valor);
            $query2->execute();
            $rows2 = $query2->fetchAll(PDO::FETCH_ASSOC);
            ?>
            <tr>
                <td style="width: 10%; border: solid 1px #000000;"><?php echo $value["fecha_pago"]; ?></td>
                <td style="width: 10%; border: solid 1px #000000;"><?php echo $value["numero_factura"]; ?></td>
                <td style="width: 10%; border: solid 1px #000000;"><?php echo $medio_pago; ?></td>
                <td style="width: 10%; border: solid 1px #000000;"><?php echo utf8_decode($value["nombre_atendio"]); ?></td>
                <td style="width: 10%; border: solid 1px #000000;"><?php echo $value["documento_atendio"]; ?></td>
                <td style="width: 10%; border: solid 1px #000000;"><?php echo utf8_decode($value["paciente_nombre"] . " " . $value["apellido_paciente"]); ?></td>
                <td style="width: 10%; border: solid 1px #000000;"><?php echo $value["documento_paciente"]; ?></td>
                <td style="width: 10%; border: solid 1px #000000;"><?php echo $rows2[0]['venta_total']; ?></td>
            </tr>
        <?php } ?>


    </table>


</page>


<?php
$content = ob_get_clean();
//require_once("../" . dirname(__FILE__) . '/html2pdf.class.php');
require_once ('../web/pdf/html2pdf.class.php');
try {

    $html2pdf = new HTML2PDF('P', 'B4', 'es', false, 'UTF-8', array(0, 0, 0, 0));
    $html2pdf->pdf->SetDisplayMode('fullpage');
    $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
    $html2pdf->Output('ARQUEO_VITALEA.pdf');
    return 1;
} catch (HTML2PDF_exception $e) {
    echo $e;
}
?>
