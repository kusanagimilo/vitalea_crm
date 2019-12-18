<?php
error_reporting(-1);

require 'Slim/Slim.php';

\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim();

$app->get( '/comentarios', function () {
       echo "Colcan Bienvenidos";
    }
);

$app->post('/resultados',function () use ($app) {

    $data = $app->request()->getBody();


    $limpiar = explode("&",$data);

    $archivo_parte = $limpiar[0];
    $paciente_parte = $limpiar[1];

    $limpiar_archivo = explode("=", $archivo_parte);
    $archivo = $limpiar_archivo[1];

    $limpiar_paciente = explode("=", $paciente_parte);
    $cedula_paciente = $limpiar_paciente[1];

    echo $archivo;

   
    $url  = $archivo;
    //El nombre del archivo donde se almacenara los datos descargados.
    $filePath = 'resultados/resultados_'.$cedula_paciente.'.pdf';
    //Inicializa Curl.
    $ch = curl_init();
 
        //Pasamos la url a donde debe ir.
    curl_setopt($ch, CURLOPT_URL, $url);
        //Si necesitamos el header del archivo, en este caso no.
    curl_setopt($ch, CURLOPT_HEADER, false);
        //Si necesitamos descargar el archivo.
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //Lee el header y se mueve a la siguiente localización.
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        //Cantidad de segundo de limite para conectarse.
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
        //Cantidad de segundos de limite para ejecutar curl. 0 significa indefinido.
    curl_setopt($ch, CURLOPT_TIMEOUT, 0);
        //Donde almacenaremos el archivo.
    curl_setopt($ch, CURLOPT_FILE, $filePath);
        //curl_exec ejecuta el script.
    $result = curl_exec($ch);
        //Dejamos de utilizar el archivo creado.
        fclose($fd);
        if($result){ //funciono ?
             echo "Descarga correcta.";
         }




    }
);


// PUT route
$app->put(
    '/put',
    function () {
        echo 'This is a PUT route';
    }
);

// PATCH route
$app->patch('/patch', function () {
    echo 'This is a PATCH route';
});

// DELETE route
$app->delete(
    '/delete',
    function () {
        echo 'This is a DELETE route';
    }
);

/**
 * Step 4: Run the Slim application
 *
 * This method should be called last. This executes the Slim application
 * and returns the HTTP response to the HTTP client.
 */
$app->run();
