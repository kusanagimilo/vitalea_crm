<?php

require_once '../clase/Cliente.php';
require_once '../clase/Bono.php';

$cliente = new Cliente();
$Bono = new Bono();

$tipo = $_POST["tipo"];

if ($tipo == 1) {
    $clasificacion = $cliente->listar_calificacion();
    echo $clasificacion;
} else if ($tipo == 2) {
    $clasificacion_id = $_POST["clasificacion_id"];

    $clientes = $cliente->listar_cliente_por_clasificacion($clasificacion_id);
    echo $clientes;
} else if ($tipo == 3) {
    $clientes = $cliente->listar_cliente_bon();
    echo $clientes;
} else if ($tipo == 4) {
    $retorno = $Bono->BonosPersona($_POST);
    echo $retorno;
}
?>