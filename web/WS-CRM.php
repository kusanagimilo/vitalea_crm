<?php

include_once '../clase/Resultado.php';
include_once 'nusoap-0.9.5/lib/nusoap.php';
$servicio = new nusoap_server();
$name_space = "urn:serviciocrmwsdl";
$servicio->configureWSDL("ServicioWEBCRM", $name_space);

/* $servicio->register("RegistrarResultado", array(
  "tipo_documento" => "xsd:string",
  "numero_documento" => "xsd:string",
  "id_solicitud" => "xsd:string",
  "nombre_archivo_resultado" => "xsd:string",
  "archivo_resultado" => "xsd:string",
  "codigo_examen" => "xsd:string",
  "sub_codigo_examen" => "xsd:string"), array("return" => "xsd:string"), $name_space); */
$servicio->register("RegistrarResultado", array(
    "tipo_documento" => "xsd:string",
    "numero_documento" => "xsd:string",
    "id_solicitud" => "xsd:string",
    "nombre_archivo_resultado" => "xsd:string",
    "archivo_resultado" => "xsd:string",
    "codigo" => "xsd:string",
    "valor_resultado" => "xsd:string"), array("return" => "xsd:string"), $name_space);

function RegistrarResultado1($tipo_documento, $numero_documento, $id_solicitud, $nombre_archivo, $archivo_resultado, $codigo_examen, $sub_codigo_examen) {

    $obj_resultado = new Resultado();

    $arreglo_almacenamiento = array("tipo_documento" => $tipo_documento,
        "numero_documento" => $numero_documento,
        "id_solicitud" => $id_solicitud,
        "nombre_archivo" => $nombre_archivo,
        "archivo_resultado" => $archivo_resultado,
        "codigo_examen" => $codigo_examen,
        "sub_codigo_examen" => $sub_codigo_examen);

    $retorno = $obj_resultado->RegistrarResultadoCRM($arreglo_almacenamiento);


    return $retorno;
    //return var_dump($archivo_resultado);
    //return "su archivo se almaceno con exito en el sistema";
    //$parametros = $tipo_documento . "-" . $numero_documento . "-" . $numero_solicitud . "-" . $numero_factura;
    //return $parametros;
}

function RegistrarResultado($tipo_documento, $numero_documento, $id_solicitud, $nombre_archivo, $archivo_resultado, $codigo, $valor_resultado) {
    $obj_resultado = new Resultado();

    $arreglo_almacenamiento = array("tipo_documento" => $tipo_documento,
        "numero_documento" => $numero_documento,
        "id_solicitud" => $id_solicitud,
        "nombre_archivo" => $nombre_archivo,
        "archivo_resultado" => $archivo_resultado,
        "codigo" => $codigo,
        "valor_resultado" => $valor_resultado);

    $retorno = $obj_resultado->RegistrarResultado($arreglo_almacenamiento);


    return $retorno;
}

$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : '';
$servicio->service(file_get_contents("php://input"));
?>
