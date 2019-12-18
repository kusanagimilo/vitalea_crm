<?php

require_once '../clase/Turno_nuevo.php';
require_once '../clase/Turno.php';

$turno_nuevo = new Turno_nuevo();
$cant_turno = new Turno();

$cliente_id=$_POST["cliente_id"]; 
$usuario_id=$_POST["usuario"];
$turno=$_POST["turno"]; 

if($turno == 1){

	$registro = $turno_nuevo->buscar_registro_1();

	if ($registro == 0) {
		$numero_turno = 1;
		$tipo_turno=1;
		$turno_nuevo->insert_gestion_en_cero($cliente_id,$usuario_id,$numero_turno,$tipo_turno);
		$registro_2 = $turno_nuevo->buscar_registro_1();
		echo $turno;
		echo "&id_2=".$registro_2;
	}else if($registro != 0){
		$registro = $turno_nuevo->buscar_registro_1();
		$numero_turno = $registro+1;
		$tipo_turno=1;
		$turno_nuevo->ingresar_gestion($cliente_id,$usuario_id,$numero_turno,$tipo_turno);
		$registro_2 = $turno_nuevo->buscar_registro_1();
		echo $turno;
		echo "&id_2=".$registro_2;
	}
	
}else if ($turno == 2) {
		$registro = $turno_nuevo->buscar_registro_2();

	if ($registro == 0) {
		$registro = 1;
		$var_tipo_turno=2;
		$turno_nuevo->ingresar_gestion_cero($cliente_id,$usuario_id,$registro,$var_tipo_turno);
		$registro_2 = $turno_nuevo->buscar_registro_2();
		echo $turno;
		echo "&id_2=".$registro_2;
	}else if($registro != 0){
		$registro = $turno_nuevo->buscar_registro_2();
		$numero_turno = $registro+1;
		$tipo_turno=2;
		$turno_nuevo->ingresar_gestion($cliente_id,$usuario_id,$numero_turno,$tipo_turno);
		$registro_2 = $turno_nuevo->buscar_registro_2();
		echo $turno;
		echo "&id_2=".$registro_2;
	}
}


if ($turno == 1 || $turno ==2) {
	$modulo1 = 0;
	$modulo2 = 0;
	$modulo3 = 0;
	$modulo4 = 0;
	
	$cantidad_turnos = $cant_turno->cant_turnos();

for ($i = 0; $i <= $cantidad_turnos; $i++) {
    
    $turno_modulo = $cant_turno->cant_modulo($i);

    if ($turnos_modulo == 1) {
    	$modulo1 = $modulo1 + 1 ;
    }elseif ($turnos_modulo == 2) {
    	$modulo2 = $modulo2 + 1 ;
    }elseif ($turnos_modulo == 3) {
    	$modulo3 = $modulo3 + 1 ;
    }elseif ($turnos_modulo == 4) {
    	$modulo4 = $modulo4 + 1 ;
    }
}

if ($modulo1 > $modulo2 && $modulo1 > $modulo3 && $modulo1 > $modulo4) {
	$agregar_madulo = $cant_turno->asignar_modulo();
}

}
?>