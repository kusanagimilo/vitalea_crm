<?php 

$url = 'https://arcos-crm.com/crm_colcan/public/result';
/*$fields = array(
	'archivo' => "https://arcos-crm.com/crm_colcan/web/images/agregar-usuario.png",
	'numero' => "3204043662"
);

$fields_string = http_build_query($fields);*/

//open connection
$ch = curl_init();

//set the url, number of POST vars, POST data
curl_setopt($ch,CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch,CURLOPT_POSTFIELDS, "archivo=https://arcos-crm.com/crm_colcan/controlador/Cotizacion_111.pdf&numero=1022969477");

//execute post
$result = curl_exec($ch);

//close connection
curl_close($ch);

?>