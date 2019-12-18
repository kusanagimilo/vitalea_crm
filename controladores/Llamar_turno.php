<?php

require_once '../clase/Turno.php';
require_once '../clase/Cliente.php';

$gestion = new Turno();
$cliente = new Cliente();

$tipo = $_POST['tipo'];
if ($tipo == 1) {
	$llamar_cliente = $gestion->llamar_cliente_nuevo();
	echo $llamar_cliente;
	if (empty($llamar_cliente)) {
		echo  '0';
	//}else{
	//	$datos_cliente = $cliente->datos_cliente($llamar_cliente);
	//	echo $datos_cliente;
	}
}	
?>