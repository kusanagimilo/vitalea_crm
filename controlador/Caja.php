<?php

require_once '../clase/Gestion.php';
require_once '../clase/Caja.php';
require_once '../clase/Cotizacion.php';
require_once '../clase/GenerarPDF.php';
require_once '../clase/Cliente.php';

$gestion = new Gestion();
$caja = new Caja();
$cotizacion = new Cotizacion();
$GenerarPDF = new GenerarPDF();
$cliente = new Cliente();

$tipo = $_POST["tipo"];


if ($tipo == 1) { /* REDIGIR Y CAJA GESTION */
    $cliente_id = $_POST["cliente_id"];
    $usuario_id = $_POST["usuario"];

    //consultar si se encuentra ocupado
    $registro_ocupado = $gestion->consulta_registro_ocupacion(date('Y-m-d'), $cliente_id);

    if ($registro_ocupado == 0) {
        $gestion->ingresar_registro_ocupacion($usuario_id, $cliente_id);
        $gestion_id = $gestion->gestion_id($cliente_id, $usuario_id, 0);

        if ($gestion_id == 0) {
            $gestion->ingresar_gestion($cliente_id, $usuario_id);
            $gestion_id = $gestion->gestion_id($cliente_id, $usuario_id, 0);
        }

        $gestion_id = base64_encode($gestion_id);
        echo $gestion_id;
    } else {
        //ocupado
        echo "O";
    }
} else if ($tipo == 2) { // TRAER PRECIOS DE EXAMEN SELECCIONADO
    $examen_id = $_POST["examen_id"];
    $precios = $caja->listar_precios_examenes($examen_id);
    echo $precios;
} else if ($tipo == 3) { // INGRESAR EXAMEN A TABLA TEMPORAL
    $examen_id = $_POST["examen_id"];
    $precio = $_POST["precio"];
    $gestion_id = $_POST["gestion_id"];
    $cliente_id = $_POST["cliente_id"];
    $tipo_examen = $_POST["tipo_examen"];

    if ($tipo_examen == 1) {
        $precio_examen = explode("_", $precio);
        $precio_id = $precio_examen[0];
        $precio_valor = $precio_examen[1];

        if ($precio_id == 1) {
            $precio_tipo = "-";
        } else if ($precio_id == 2) {
            $precio_tipo = "5% Dto.";
        } else if ($precio_id == 3) {
            $precio_tipo = "10% Dto.";
        } else if ($precio_id == 4) {
            $precio_tipo = "15% Dto.";
        }
    } else if ($tipo_examen == 2) {
        $precio_valor = $precio;
        $precio_tipo = "-";
    }

    $caja->venta_temporal($examen_id, $cliente_id, $gestion_id, $precio_tipo, $precio_valor, $tipo_examen);
    echo 1;
} else if ($tipo == 4) { // LISTAR TABLA TEMPORAL
    $gestion_id = $_POST["gestion_id"];
    $cliente_id = $_POST["cliente_id"];

    $tabla = $caja->tabla_temporal($cliente_id, $gestion_id);
    $tabla .= $caja->sumaVentaTempExamenes($cliente_id, $gestion_id);
    echo $tabla;
} else if ($tipo == 5) { //ELIMINAR EXAMEN DE TABLA TEMPORAL
    $examen_id = $_POST["examen_id"];
    $caja->eliminar_cita_temp($examen_id);
} else if ($tipo == 6) {
// INGRESAR VENTA
    $tipificacion_id = 63; // tipificacion de venta
    $gestion_id = $_POST["gestion_id"];
    $cliente_id = $_POST["cliente_id"];
    $usuario_id = $_POST["usuario_id"];
    $medio_pago = $_POST["medio_pago"];
    $medios_comunicacion = $_POST["medios_comunicacion"];
    $observacion_venta = $_POST["observacion_venta"];
    $email = $_POST["email_venta"];
    $plan = $_POST["plan_seleccionado"];

    //VALIDAR SI HAY EXAMENES EN LA TABLA TEMPORAL

    $lista_examenes_ventas = $caja->consultar_items_examenes_temp($cliente_id, $gestion_id);
    if (!empty($lista_examenes_ventas)) {
        //ACTUALIZACION DE GESTION
        $gestion->actualizar_gestion(0, 1, $medios_comunicacion, $tipificacion_id, $usuario_id, $gestion_id);
        $gestion->ingresar_observacion($observacion_venta, $gestion_id);
        //INGRESAR VENTA

        $venta_id = $caja->ingresar_gestion_pago($cliente_id, $usuario_id, $gestion_id, $medio_pago, $plan);

        //ACTUALIZAR ESTADO DEL CLIENTE
        //CONFIRMA SI TIENE VENTAS PREDIOS

        $conteo_ventas = $gestion->consultar_cantidad_ventas($cliente_id);

        if ($conteo_ventas == 1) {
            $gestion->actualizar_estado_cliente(2, $cliente_id);
        }

        //CODIGO QR:
        $datos_cliente = $cliente->consultar_paciente($cliente_id);
        foreach ($datos_cliente as $valores) {
            $documento = $valores["documento"];
            $nombre = $valores["nombre"];
            $tipo_documento = $valores["tipo_documento"];
        }

        //LIBERAR REGISTRO
        $gestion->liberar_registro($cliente_id, $usuario_id);


        include 'ticket.php';

        $pdf = PDFTICKET($venta_id);



        if ($pdf == 1) {
            include ('email_venta.php');

            $envio = EnviarCorreoVenta($venta_id, $email);

            if ($envio == 1) {
                unlink('TICKET_VENTA_' . $venta_id . '.pdf');
                $msj = 1;
            } else {
                unlink('TICKET_VENTA_' . $venta_id . '.pdf');
                $msj = 2;
            }
        } else {
            $msj = 2;
        }
    } else {
        $msj = 2;
    }
    echo $msj;
} else if ($tipo == 7) { // GENERAR COTIZACIONES
    $tipificacion_id = 19; // tipificacion de cotizaciones
    $gestion_id = $_POST["gestion_id"];
    $cliente_id = $_POST["cliente_id"];
    $usuario_id = $_POST["usuario_id"];
    $email = $_POST["email"];
    $medios_comunicacion = $_POST["medios_comunicacion"];
    $observacion_cotizacion = $_POST["observacion_cotizacion"];

    $lista_examenes_ventas = $caja->consultar_items_examenes_temp($cliente_id, $gestion_id);
    if (!empty($lista_examenes_ventas)) {
        //ACTUALIZACION DE GESTION
        $gestion->actualizar_gestion(1, 0, $medios_comunicacion, $tipificacion_id, $usuario_id, $gestion_id);
        $gestion->ingresar_observacion($observacion_cotizacion, $gestion_id);
        //INGRESAR COTIZACION
        $cotizacion_id = $cotizacion->ingresar_cotizacion($usuario_id, $cliente_id, $gestion_id);

        // ACTUALIZAR ESTADO DEL CLIENTE

        $gestion->actualizar_estado_cliente(2, $cliente_id);
        //GENERAR COTIZACION PDF
        $html = $GenerarPDF->generarPdf($cotizacion_id, $cliente_id);



        require_once('../web/pdf/html2pdf.class.php');


        try {
            $html2pdf = new HTML2PDF('P', 'b4', 'es', false, 'ISO-8859-15', array(0, 0, 0, 0));
            // display the full page
            $html2pdf->pdf->SetDisplayMode('fullpage');

            // convert
            //$html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->writeHTML($html);

            ob_clean();
            $html2pdf->Output('Cotizacion_' . $cotizacion_id . '.pdf', 'F');
        } catch (HTML2PDF_exception $e) {
            echo $e;
            exit;
        }

        //LIBERAR REGISTRO
        $gestion->liberar_registro($cliente_id, $usuario_id);

        include ('email_cotizacion.php');
        $msj = 1;
    } else {
        $msj = 2;
    }
    echo $msj;
} else if ($tipo == 8) { // TRAER PRECIOS DE EXAMEN SELECCIONADO
    $examen_id = $_POST["examen_id"];
    $id_plan = $_POST['id_plan'];
    $precios = $caja->listar_precios_examenes2($examen_id,$id_plan);
    echo $precios;
}
?>
