<?php

require '../clase/valorReferencia.php';

$objetoValorReferencia = new valorReferencia();

$tipo = $_POST["tipo"];
if ($tipo == 1) {
    $retorno = $objetoValorReferencia->verValoresReferencia($_POST);
    echo $retorno;
}
?>