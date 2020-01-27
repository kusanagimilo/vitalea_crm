<?php

include_once 'conexion/conexion_bd.php';
$conexion = new Conexion();

class wsHeader {

    public $Username = '';
    public $Password = '';

    public function __construct($Username, $Password) {
        $this->Username = $Username;
        $this->Password = $Password;
    }

}

 $par = array();
$client = new SoapClient("http://192.168.50.134/WebServices/Laboratorio/DatosGenerales/WSIntegracionLaboratorio.asmx?WSDL", $par);
$headers = new SoapHeader("http://tempuri.org/", 'ServiceAuthHeader', new wsHeader("AtheneaWS", "4th3n3a*"));
$client->__setSoapHeaders($headers);




$datos = array("FacturarSolicitud" =>
    array(
        "intIdsolicitud" => 2039657,
        "intAnoSolicitud" => 2019,
        "formasPago" => array(
            "formaPago" => array(
                "idFormaPago" => 1,
                "valor" => 353000
            )),
        "totalFactura" => 353000,
        "intIdplan" => 11713));

$result = $client->__soapCall("FacturarSolicitud", $datos);

$xml = simplexml_load_string($result->FacturarSolicitudResult);

print_r($xml);