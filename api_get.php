<?php 

//datos a enviar
 //$data = array("a" => "a");
 //url contra la que atacamos
 $ch = curl_init("https://arcos-crm.com/crm_colcan/public/comentarios");
 //a true, obtendremos una respuesta de la url, en otro caso, 
 //true si es correcto, false si no lo es
 curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 //establecemos el verbo http que queremos utilizar para la petición
 curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
 //enviamos el array data
 //curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($data));
 //obtenemos la respuesta
 $response = curl_exec($ch);
 // Se cierra el recurso CURL y se liberan los recursos del sistema
 curl_close($ch);

 echo $response;

?>