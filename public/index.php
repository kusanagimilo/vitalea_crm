<?php
error_reporting(-1);
require_once "../clase/Archivos.php";
/**
 * Step 1: Require the Slim Framework
 *
 * If you are not using Composer, you need to require the
 * Slim Framework and register its PSR-0 autoloader.
 *
 * If you are using Composer, you can skip this step.
 */
require 'Slim/Slim.php';

\Slim\Slim::registerAutoloader();

/**
 * Step 2: Instantiate a Slim application
 *
 * This example instantiates a Slim application using
 * its default settings. However, you will usually configure
 * your Slim application now by passing an associative array
 * of setting names and values into the application constructor.
 */
$app = new \Slim\Slim();

/**
 * Step 3: Define the Slim application routes
 *
 * Here we define several Slim application routes that respond
 * to appropriate HTTP request methods. In this example, the second
 * argument for `Slim::get`, `Slim::post`, `Slim::put`, `Slim::patch`, and `Slim::delete`
 * is an anonymous function.
 */

// GET route
$app->get( '/comentarios', function () {
       echo "Colcan Bienvenidos";
    }
);

$app->post('/result',function () use ($app) {
    $archivo_bd = new ArchivoBD();

    $data = $app->request()->getBody();
  

    $limpiar = explode("&",$data);

    $archivo_parte = $limpiar[0];
    $paciente_parte = $limpiar[1];

    $limpiar_archivo = explode("=", $archivo_parte);
    $archivo = $limpiar_archivo[1];

    $limpiar_paciente = explode("=", $paciente_parte);
    $cedula_paciente = $limpiar_paciente[1];


    $url  = $archivo;

    $info = new SplFileInfo($archivo);
    $extension = $info->getExtension();

    if($extension != "pdf"){
        echo "Solo archivos en PDF. Archivo Invalido";
    }
    else if($extension == "pdf"){
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
        $output = curl_exec($ch);
        //Guardamos la imagen en un archivo
       
        $fechaActual = date('Y-m-d');
        $carpeta = 'resultados/'.$cedula_paciente;
        if (!file_exists($carpeta)) {
            mkdir($carpeta, 0777, true);
        }

        $ruta_archivo = $carpeta."/resultado_".$fechaActual.".pdf";

        $archivos_existente = $archivo_bd->archivos_existentes($ruta_archivo,$cedula_paciente);

        if($archivos_existente > 0){
            $version= $archivos_existente + 1;
            $ruta_archivo = $carpeta."/resultado_".$fechaActual."_".$version.".pdf";
        }

     
        $miarchivo = fopen($ruta_archivo, "w+");
     
        fputs($miarchivo, $output);
     
        fclose($miarchivo);

        $archivo_bd->cargar_archivo($ruta_archivo,$cedula_paciente,$fechaActual);

        echo "Archivo cargado";
    }

    
});


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
