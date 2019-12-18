<?php

include_once 'nusoap-0.9.5/lib/nusoap.php';
$client = new nusoap_client('http://localhost/crm_colcan/web/WS-CRM.php?wsdl', true);

// Check for an error
$err = $client->getError();
if ($err) {
    // error if any
    echo '<h2>Constructor error</h2><pre>' . $err . '</pre>';
}
// Call mathod

$filepath = "images/arroba.png"; // example c:\images\mypic.jpg

$fileString = base64_encode(fread(fopen($filepath, "r"), filesize($filepath)));


var_dump($fileString);
die();


$result = $client->call('RegistrarResultado', array("tipo_documento" => "CC",
    "numero_documento" => "1019075739",
    "numero_solicitud" => "121221",
    "numero_factura" => "P87878",
    "nombre_archivo_resultado" => "camilo.png",
    "archivo_resultado" => $fileString));

// fault if any
if ($client->fault) {
    echo '<h2>Fault</h2><pre>';
    print_r($result);
    echo '</pre>';
} else {
    // Check for errors
    $err = $client->getError();
    if ($err) {
        // Display the error
        echo '<h2>Error</h2><pre>' . $err . '</pre>';
    } else {
        // Display the result
        echo '<h2>Result</h2><pre>';
        print_r($result);
        echo '</pre>';
    }
}
?>
