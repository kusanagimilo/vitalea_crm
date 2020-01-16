<?php

error_reporting(E_ALL & ~E_DEPRECATED);
include_once '../clase/Resultado.php';
include_once '../clase/Examen.php';
include_once 'nusoap-0.9.5/lib/nusoap.php';
$servicio = new nusoap_server();
$name_space = "urn:serviciocrmwsdl";
$servicio->configureWSDL("ServicioWEBCRM", $name_space);


$servicio->register("RegistrarResultado", array(
    "tipo_documento" => "xsd:string",
    "numero_documento" => "xsd:string",
    "id_solicitud" => "xsd:string",
    "nombre_archivo_resultado" => "xsd:string",
    "archivo_resultado" => "xsd:string",
    "codigo" => "xsd:string",
    "valor_resultado" => "xsd:string"), array("return" => "xsd:string"), $name_space);

$servicio->register("AlmacenarChequeoWS", array(
    "id_categoria" => "xsd:string",
    "nombre_chequeo" => "xsd:string",
    "codigo_chequeo" => "xsd:string",
    "preparacion" => "xsd:string",
    "recomendaciones" => "xsd:string",
    "precio" => "xsd:string"), array("return" => "xsd:string"), $name_space);

$servicio->register("AlmacenarExamenWS", array(
    "codigo_examen" => "xsd:string",
    "nombre_examen" => "xsd:string",
    "precio" => "xsd:string"), array("return" => "xsd:string"), $name_space);

$servicio->register("AlmacenarSubExamenWS", array(
    "codigo_examen" => "xsd:string",
    "codigo_sub_examen" => "xsd:string",
    "nombre_sub_examen" => "xsd:string"), array("return" => "xsd:string"), $name_space);

$servicio->register("AdicionarExamenChequeo", array(
    "codigo_chequeo" => "xsd:string",
    "codigo_examen" => "xsd:string"), array("return" => "xsd:string"), $name_space);

$servicio->register("ModificarChequeoWS", array(
    "id_categoria" => "xsd:string",
    "nombre_chequeo" => "xsd:string",
    "codigo_chequeo" => "xsd:string",
    "preparacion" => "xsd:string",
    "recomendaciones" => "xsd:string",
    "precio" => "xsd:string"), array("return" => "xsd:string"), $name_space);


$servicio->register("ModificarExamenWS", array(
    "codigo_examen" => "xsd:string",
    "nombre_examen" => "xsd:string",
    "precio" => "xsd:string"), array("return" => "xsd:string"), $name_space);

$servicio->register("ModificarSubExamenWS", array(
    "codigo_examen" => "xsd:string",
    "codigo_sub_examen" => "xsd:string",
    "nombre_sub_examen" => "xsd:string"), array("return" => "xsd:string"), $name_space);

function ModificarSubExamenWS($codigo_examen, $codigo_sub_examen, $nombre_sub_examen) {
    return "en construccion";
}

function ModificarExamenWS($codigo_examen, $nombre_examen, $precio) {
    return "en construccion";
}

function ModificarChequeoWS($id_categoria, $nombre_chequeo, $codigo_chequeo, $preparacion, $recomendaciones, $precio) {
    return "en construccion";
}

function AdicionarExamenChequeo($codigo_chequeo, $codigo_examen) {
    return "en construccion";
}

function AlmacenarSubExamenWS($codigo_examen, $codigo_sub_examen, $nombre_sub_examen) {
    $obj_examen = new Examen();
    $arreglo_almacenamiento = array("codigo_examen" => $codigo_examen,
        "codigo_sub_examen" => $codigo_sub_examen,
        "nombre_sub_examen" => $nombre_sub_examen);

    $retorno = $obj_examen->AdicionarSubExamenW($arreglo_almacenamiento);

    if ($retorno == 1) {
        return "Se ingreso correctamente el sub examen : " . $codigo_sub_examen;
    } else if ($retorno == 2) {
        return "Error al tratar de almacenar el sub examen";
    } else if ($retorno == 3) {
        return "Ya existe el sub examen : " . $codigo_sub_examen;
    } else if ($retorno == 4) {
        return "El examen : " . $codigo_examen . " no existe";
    }
}

function AlmacenarChequeoWS($id_categoria, $nombre_chequeo, $codigo_chequeo, $preparacion, $recomendaciones, $precio) {
    $obj_examen = new Examen();

    $arreglo_almacenamiento = array("grupo_id" => $id_categoria,
        "nombre" => $nombre_chequeo,
        "codigo_crm" => $codigo_chequeo,
        "preparacion" => $preparacion,
        "recomendaciones" => $recomendaciones,
        "precio" => $precio);

    $retorno = $obj_examen->AlmacenarPerfil($arreglo_almacenamiento);

    if ($retorno == 1) {
        return "Se ingreso correctamente el chequeo : " . $codigo_chequeo;
    } else if ($retorno == 2) {
        return "Error al tratar de almacenar el chequeo";
    } else if ($retorno == 3) {
        return "Ya existe el chequeo : " . $codigo_chequeo;
    }
}

function AlmacenarExamenWS($codigo_examen, $nombre_examen, $precio) {
    $obj_examen = new Examen();
    $arreglo_almacenamiento = array("codigo" => $codigo_examen,
        "nombre" => $nombre_examen,
        "precio" => $precio);

    $retorno = $obj_examen->AlmacenarExamen($arreglo_almacenamiento);

    if ($retorno == 1) {
        return "Se ingreso correctamente el chequeo : " . $codigo_examen;
    } else if ($retorno == 2) {
        return "Error al tratar de almacenar el chequeo";
    } else if ($retorno == 3) {
        return "Ya existe el chequeo : " . $codigo_examen;
    }
}

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
