<?php

phpinfo();

die();
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
//var_dump($client);
//die();
$headers = new SoapHeader("http://tempuri.org/", 'ServiceAuthHeader', new wsHeader("AtheneaWS", "4th3n3a*"));
$client->__setSoapHeaders($headers);


echo "<pre>";
var_dump($client->__getFunctions());
echo "</pre>";
die();
?>