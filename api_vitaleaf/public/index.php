<?php
header('Access-Control-Allow-Origin: *');
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

require '../vendor/autoload.php';
require '../src/config/db.php';
require '../src/config/funciones.php';
require '../src/config/WS_API.php';
$app = new \Slim\App;
$app->get('/hello/{name}', function (Request $request, Response $response, array $args) {
    $name = $args['name'];
    $response->getBody()->write("Prueba vitalea, $name");

    return $response;
});
//require "../src/rutas/clientes.php";
//require "../src/rutas/examenes.php";
require "../src/rutas/api.php";
$app->run();
