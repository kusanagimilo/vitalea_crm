<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once '../clase/Facturacion.php';

$Obj_Facturacion = new Facturacion();

$tipo = $_POST["tipo"];

if ($tipo == 1) {
    $retorno = $Obj_Facturacion->VerProspectosVentas($_POST);
    echo $retorno;
}if ($tipo == 2) {
    $retorno = $Obj_Facturacion->CambiarEstadoVenta($_POST);
    echo $retorno;
}
if ($tipo == 3) {
    $retorno = $Obj_Facturacion->InformacionVentaIndividual($_POST);
    echo $retorno;
}if ($tipo == 4) {
    $retorno = $Obj_Facturacion->VerDetalleVentaF($_POST);
    echo $retorno;
}if ($tipo == 5) {
    $retorno = $Obj_Facturacion->NoFactura($_POST);
    echo $retorno;
}if ($tipo == 6) {
    $retorno = $Obj_Facturacion->ModificarNoFacturacion($_POST);
    echo $retorno;
}if ($tipo == 7) {
    $retorno = $Obj_Facturacion->EstadoTurnoFacturacion($_POST);
    echo $retorno;
}if ($tipo == 8) {
    $retorno = $Obj_Facturacion->ListaArqueo($_POST);
    echo $retorno;
}if ($tipo == 9) {
    $retorno = $Obj_Facturacion->AsesoresConVentas();
    echo $retorno;
}if ($tipo == 10) {
    $retorno = $Obj_Facturacion->InformacionPerfil($_POST);
    echo $retorno;
}if ($tipo == 11) {
    $retorno = $Obj_Facturacion->InformacionExamen($_POST);
    echo $retorno;
}if ($tipo == 12) {

    $retorno = $Obj_Facturacion->AlmacenarPreCotizacion($_POST);
    if ($retorno != "mal") {
        include ('../controlador/email_venta.php');
        $retorno_correo = EnviarCorreoPrecotizacion($_POST['correo'], $retorno);
        echo $retorno_correo;
    } else {
        echo $retorno;
    }
}if ($tipo == 13) {
    $retorno = $Obj_Facturacion->ListaPrecotizaciones($_POST);
    echo $retorno;
}if ($tipo == 14) {
    $retorno = $Obj_Facturacion->listaDetallecotizaciones($_POST);
    echo $retorno;
}if ($tipo == 15) {
    $retorno = $Obj_Facturacion->btnVerMasDetallesPerfiles($_POST);
    echo $retorno;
}if ($tipo == 16) {
    $retorno = $Obj_Facturacion->btnVerMasDetallesExamenNoPerfiles($_POST);
    echo $retorno;
}if ($tipo == 17) {
    $retorno = $Obj_Facturacion->consultaCotizacionPdf($_POST);
    echo $retorno;
}if ($tipo == 18) {
    $retorno = $Obj_Facturacion->consultaModalPerfil($_POST);
    echo $retorno;
}if ($tipo == 19) {
    $firma = $_POST["firma"];
    $documento = $_POST["documento"];
    $retorno = $Obj_Facturacion->insercionFirma($firma, $documento);
    echo $retorno;
}if ($tipo == 20) {
    $inputIdValue = $_POST["inputIdValue"];
    $retorno = $Obj_Facturacion->consultarFirma($inputIdValue);
    echo $retorno;
}if ($tipo == 21) {
    $inputIdValue = $_POST["nombreChequeo"];
    $retorno = $Obj_Facturacion->consultarChequeosFacturacion($inputIdValue);
    echo $retorno;
}if ($tipo == 22) {
    $retorno = $Obj_Facturacion->AdicionarComprobante($_POST, $_FILES);
    echo $retorno;
}if ($tipo == 23) {
    $retorno = $Obj_Facturacion->InformacionDocVenta($_POST);
    echo $retorno;
}

