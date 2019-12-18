
<?php

require_once '../clase/Bono.php';
require_once '../clase/Cliente.php';
//Agregamos la libreria para genera códigos QR
require "../web/phpqrcode/qrlib.php";

$bono = new Bono();
$cliente = new Cliente();

$codigo_descuento = $_POST["codigo_descuento"];
$cliente_id = $_POST["cliente_id"];
$fecha_inicio = $_POST["fecha_inicio"];
$fecha_final = $_POST["fecha_final"];
$cantidad_descuento = $_POST["cantidad_descuento"];

$existe_bono = $bono->existe_bono($codigo_descuento);
//$email = $cliente->correo_paciente($cliente_id);

if ($existe_bono == 0) {

    //$dir = 'bonos/';
    //Declaramos la ruta y nombre del archivo a generar
    //$filename = $dir.'bono_'.$codigo_descuento.".png";
    //Parametros de Condiguración
    //$tamaño = 10; //Tamaño de Pixel
    //$level = 'H'; //Precisión Baja
    //$framSize = 3; //Tamaño en blanco

    $contenido = "{bono:'" . $codigo_descuento . "',cliente:'" . $cliente_id . "',fecha_inicio:'" . $fecha_inicio . "',fecha_final:'" . $fecha_final . "'}";
    //Enviamos los parametros a la Función para generar código QR 
    //QRcode::png($contenido, $filename, $level, $tamaño, $framSize); 

    $bono->ingresar_bono($codigo_descuento, $cliente_id, $fecha_inicio, $fecha_final, $cantidad_descuento);

    //include '../web/email/email_bono.php';
    //echo 'bono_' . $codigo_descuento . ".png";
    echo "bien";
} else {
    echo 1;
}

//Declaramos una carpeta temporal para guardar la imagenes generadas
?>