<?php
require_once '../clase/Gestion.php';
require_once '../PHPExcel/Classes/PHPExcel.php';

$reporte = $_POST["reporte"];


if ($reporte == 1) {
$reportes = new Gestion();
$gestion = $reportes->todas_gestiones();

$fila = 2;

$objPHPExcel  = new PHPExcel();
	
	//Propiedades de Documento
	$objPHPExcel->getProperties()->setCreator("desarrollador")->setDescription("Reporte de gestiones");
	
	//Establecemos la pestaña activa y nombre a la pestaña
	$objPHPExcel->setActiveSheetIndex(0);
	$objPHPExcel->getActiveSheet()->setTitle("gestion");
	

	
	$objPHPExcel->getActiveSheet()->setCellValue('A1', 'ID GESTION');
	$objPHPExcel->getActiveSheet()->setCellValue('B1', 'NOMBRE');

$objPHPExcel->getActiveSheet()->setCellValue('C1', 'APELLIDO');

$objPHPExcel->getActiveSheet()->setCellValue('D1', 'MEDIO DE COMUNICACION');

$objPHPExcel->getActiveSheet()->setCellValue('E1', 'TIPIFICACION');

$objPHPExcel->getActiveSheet()->setCellValue('F1', 'USUARIO');

$objPHPExcel->getActiveSheet()->setCellValue('G1', 'FECHA INGRESO');

$objPHPExcel->getActiveSheet()->setCellValue('H1', 'COTIZACION');

$objPHPExcel->getActiveSheet()->setCellValue('I1', 'VENTA');

foreach($gestion as $datos){

$objPHPExcel->getActiveSheet()->setCellValue('A'.$fila,  $datos["id_gestion"]);
$objPHPExcel->getActiveSheet()->setCellValue('B'.$fila,  $datos["nombre"]);
$objPHPExcel->getActiveSheet()->setCellValue('C'.$fila,  $datos["apellido"]);
$objPHPExcel->getActiveSheet()->setCellValue('D'.$fila,  $datos["medio_comunicacion"]);
$objPHPExcel->getActiveSheet()->setCellValue('E'.$fila,  $datos["tipificacion"]);
$objPHPExcel->getActiveSheet()->setCellValue('F'.$fila,  $datos["usuario_id"]);
$objPHPExcel->getActiveSheet()->setCellValue('G'.$fila,  $datos["fecha_ingreso"]);
$objPHPExcel->getActiveSheet()->setCellValue('H'.$fila,  $datos["cotizacion"]);
$objPHPExcel->getActiveSheet()->setCellValue('I'.$fila,  $datos["venta"]);

$fila = $fila +1;
}


	header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
	header('Content-Disposition: attachment;filename="gestiones.xlsx"');
	header('Cache-Control: max-age=0');

$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
$objWriter->save('php://output');


}elseif ($reporte == 2) {
	
$reportes = new Gestion();
$clientes = $reportes->todos_clientes();

$fila = 2;

$objPHPExcel  = new PHPExcel();
	
	//Propiedades de Documento
	$objPHPExcel->getProperties()->setCreator("desarrollador")->setDescription("Reporte de clientes");
	
	//Establecemos la pestaña activa y nombre a la pestaña
	$objPHPExcel->setActiveSheetIndex(0);
	$objPHPExcel->getActiveSheet()->setTitle("clientes");
	

	
	$objPHPExcel->getActiveSheet()->setCellValue('A1', 'ID CLIENTE');
	$objPHPExcel->getActiveSheet()->setCellValue('B1', 'TIPO DOCUMENTO');

$objPHPExcel->getActiveSheet()->setCellValue('C1', 'DOCUMENTO');

$objPHPExcel->getActiveSheet()->setCellValue('D1', 'NOMBRE');

$objPHPExcel->getActiveSheet()->setCellValue('E1', 'APELLIDO');

$objPHPExcel->getActiveSheet()->setCellValue('F1', 'TELEFONO 1');

$objPHPExcel->getActiveSheet()->setCellValue('G1', 'TELEFONO 2');

$objPHPExcel->getActiveSheet()->setCellValue('H1', 'EMAIL');

$objPHPExcel->getActiveSheet()->setCellValue('I1', 'FECHA NACIMIENTO');

$objPHPExcel->getActiveSheet()->setCellValue('J1', 'CIUDAD');

$objPHPExcel->getActiveSheet()->setCellValue('K1', 'BARRIO');

$objPHPExcel->getActiveSheet()->setCellValue('L1', 'DIRECCION');

$objPHPExcel->getActiveSheet()->setCellValue('M1', 'ESTADO CIVIL');

$objPHPExcel->getActiveSheet()->setCellValue('N1', 'SEXO');

$objPHPExcel->getActiveSheet()->setCellValue('O1', 'ESTRATO');

$objPHPExcel->getActiveSheet()->setCellValue('P1', 'TIPO CLIENTE');

$objPHPExcel->getActiveSheet()->setCellValue('Q1', 'CLIENTE ESTADO');

$objPHPExcel->getActiveSheet()->setCellValue('R1', 'CLASIFICACION');


$objPHPExcel->getActiveSheet()->setCellValue('S1', 'EDAD');


foreach($clientes as $datos){

$objPHPExcel->getActiveSheet()->setCellValue('A'.$fila,  $datos["id_cliente"]);
$objPHPExcel->getActiveSheet()->setCellValue('B'.$fila,  $datos["tipo_documento"]);
$objPHPExcel->getActiveSheet()->setCellValue('C'.$fila,  $datos["documento"]);
$objPHPExcel->getActiveSheet()->setCellValue('D'.$fila,  $datos["nombre"]);
$objPHPExcel->getActiveSheet()->setCellValue('E'.$fila,  $datos["apellido"]);
$objPHPExcel->getActiveSheet()->setCellValue('F'.$fila,  $datos["telefono_1"]);
$objPHPExcel->getActiveSheet()->setCellValue('G'.$fila,  $datos["telefono_2"]);
$objPHPExcel->getActiveSheet()->setCellValue('H'.$fila,  $datos["email"]);
$objPHPExcel->getActiveSheet()->setCellValue('I'.$fila,  $datos["fecha_nacimiento"]);
$objPHPExcel->getActiveSheet()->setCellValue('J'.$fila,  $datos["ciudad"]);
$objPHPExcel->getActiveSheet()->setCellValue('K'.$fila,  $datos["barrio"]);
$objPHPExcel->getActiveSheet()->setCellValue('L'.$fila,  $datos["direccion"]);
$objPHPExcel->getActiveSheet()->setCellValue('M'.$fila,  $datos["estado_civil"]);
$objPHPExcel->getActiveSheet()->setCellValue('N'.$fila,  $datos["sexo"]);
$objPHPExcel->getActiveSheet()->setCellValue('O'.$fila,  $datos["estrato"]);
$objPHPExcel->getActiveSheet()->setCellValue('P'.$fila,  $datos["tipo_cliente"]);
$objPHPExcel->getActiveSheet()->setCellValue('Q'.$fila,  $datos["cliente_estado"]);
$objPHPExcel->getActiveSheet()->setCellValue('R'.$fila,  $datos["clasificacion"]);
$objPHPExcel->getActiveSheet()->setCellValue('S'.$fila,  $datos["edad"]);

$fila = $fila +1;
}


	header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
	header('Content-Disposition: attachment;filename="clientes.xlsx"');
	header('Cache-Control: max-age=0');

$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
$objWriter->save('php://output');

}elseif ($reporte == 3) {
	
$reportes = new Gestion();
$clientes = $reportes->todos_clientes_prospecto();

$fila = 2;

$objPHPExcel  = new PHPExcel();
	
	//Propiedades de Documento
	$objPHPExcel->getProperties()->setCreator("desarrollador")->setDescription("Reporte de clientes prospectos");
	
	//Establecemos la pestaña activa y nombre a la pestaña
	$objPHPExcel->setActiveSheetIndex(0);
	$objPHPExcel->getActiveSheet()->setTitle("clientes prospectos");
	

	
	$objPHPExcel->getActiveSheet()->setCellValue('A1', 'ID CLIENTE');
	$objPHPExcel->getActiveSheet()->setCellValue('B1', 'TIPO DOCUMENTO');

$objPHPExcel->getActiveSheet()->setCellValue('C1', 'DOCUMENTO');

$objPHPExcel->getActiveSheet()->setCellValue('D1', 'NOMBRE');

$objPHPExcel->getActiveSheet()->setCellValue('E1', 'APELLIDO');

$objPHPExcel->getActiveSheet()->setCellValue('F1', 'TELEFONO 1');

$objPHPExcel->getActiveSheet()->setCellValue('G1', 'TELEFONO 2');

$objPHPExcel->getActiveSheet()->setCellValue('H1', 'EMAIL');

$objPHPExcel->getActiveSheet()->setCellValue('I1', 'FECHA NACIMIENTO');

$objPHPExcel->getActiveSheet()->setCellValue('J1', 'CIUDAD');

$objPHPExcel->getActiveSheet()->setCellValue('K1', 'BARRIO');

$objPHPExcel->getActiveSheet()->setCellValue('L1', 'DIRECCION');

$objPHPExcel->getActiveSheet()->setCellValue('M1', 'ESTADO CIVIL');

$objPHPExcel->getActiveSheet()->setCellValue('N1', 'SEXO');

$objPHPExcel->getActiveSheet()->setCellValue('O1', 'ESTRATO');

$objPHPExcel->getActiveSheet()->setCellValue('P1', 'TIPO CLIENTE');

$objPHPExcel->getActiveSheet()->setCellValue('Q1', 'CLIENTE ESTADO');

$objPHPExcel->getActiveSheet()->setCellValue('R1', 'CLASIFICACION');


$objPHPExcel->getActiveSheet()->setCellValue('S1', 'EDAD');


foreach($clientes as $datos){

$objPHPExcel->getActiveSheet()->setCellValue('A'.$fila,  $datos["id_cliente"]);
$objPHPExcel->getActiveSheet()->setCellValue('B'.$fila,  $datos["tipo_documento"]);
$objPHPExcel->getActiveSheet()->setCellValue('C'.$fila,  $datos["documento"]);
$objPHPExcel->getActiveSheet()->setCellValue('D'.$fila,  $datos["nombre"]);
$objPHPExcel->getActiveSheet()->setCellValue('E'.$fila,  $datos["apellido"]);
$objPHPExcel->getActiveSheet()->setCellValue('F'.$fila,  $datos["telefono_1"]);
$objPHPExcel->getActiveSheet()->setCellValue('G'.$fila,  $datos["telefono_2"]);
$objPHPExcel->getActiveSheet()->setCellValue('H'.$fila,  $datos["email"]);
$objPHPExcel->getActiveSheet()->setCellValue('I'.$fila,  $datos["fecha_nacimiento"]);
$objPHPExcel->getActiveSheet()->setCellValue('J'.$fila,  $datos["ciudad"]);
$objPHPExcel->getActiveSheet()->setCellValue('K'.$fila,  $datos["barrio"]);
$objPHPExcel->getActiveSheet()->setCellValue('L'.$fila,  $datos["direccion"]);
$objPHPExcel->getActiveSheet()->setCellValue('M'.$fila,  $datos["estado_civil"]);
$objPHPExcel->getActiveSheet()->setCellValue('N'.$fila,  $datos["sexo"]);
$objPHPExcel->getActiveSheet()->setCellValue('O'.$fila,  $datos["estrato"]);
$objPHPExcel->getActiveSheet()->setCellValue('P'.$fila,  $datos["tipo_cliente"]);
$objPHPExcel->getActiveSheet()->setCellValue('Q'.$fila,  $datos["cliente_estado"]);
$objPHPExcel->getActiveSheet()->setCellValue('R'.$fila,  $datos["clasificacion"]);
$objPHPExcel->getActiveSheet()->setCellValue('S'.$fila,  $datos["edad"]);

$fila = $fila +1;
}


	header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
	header('Content-Disposition: attachment;filename="clientes_prospectos.xlsx"');
	header('Cache-Control: max-age=0');

$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
$objWriter->save('php://output');

}elseif ($reporte == 4) {
	
$reportes = new Gestion();
$cotizacion = $reportes->cotizacion();

$fila = 2;

$objPHPExcel  = new PHPExcel();
	
	//Propiedades de Documento
	$objPHPExcel->getProperties()->setCreator("desarrollador")->setDescription("Reporte de cotizaciones");
	
	//Establecemos la pestaña activa y nombre a la pestaña
	$objPHPExcel->setActiveSheetIndex(0);
	$objPHPExcel->getActiveSheet()->setTitle("cotizaciones");
	

	
	$objPHPExcel->getActiveSheet()->setCellValue('A1', 'ID COTIZACION');
	$objPHPExcel->getActiveSheet()->setCellValue('B1', 'ID GESTION');

$objPHPExcel->getActiveSheet()->setCellValue('C1', 'NOMBRE');

$objPHPExcel->getActiveSheet()->setCellValue('D1', 'APELLIDO');

$objPHPExcel->getActiveSheet()->setCellValue('E1', 'DOCUMENTO');

$objPHPExcel->getActiveSheet()->setCellValue('F1', 'TELEFONO 1');

$objPHPExcel->getActiveSheet()->setCellValue('G1', 'TELEFONO 2');

$objPHPExcel->getActiveSheet()->setCellValue('H1', 'EMAIL');

$objPHPExcel->getActiveSheet()->setCellValue('I1', 'CIUDAD');

$objPHPExcel->getActiveSheet()->setCellValue('J1', 'CLIENTE ACTIVO');

$objPHPExcel->getActiveSheet()->setCellValue('K1', 'ESTRATO');

$objPHPExcel->getActiveSheet()->setCellValue('L1', 'CLASIFICACION');

$objPHPExcel->getActiveSheet()->setCellValue('M1', 'TIPO CLIENTE');

$objPHPExcel->getActiveSheet()->setCellValue('N1', 'USUARIO ID');

$objPHPExcel->getActiveSheet()->setCellValue('O1', 'FECHA COTIZACION');




foreach($cotizacion as $datos){

$objPHPExcel->getActiveSheet()->setCellValue('A'.$fila,  $datos["id"]);
$objPHPExcel->getActiveSheet()->setCellValue('B'.$fila,  $datos["gestion_id"]);
$objPHPExcel->getActiveSheet()->setCellValue('C'.$fila,  $datos["nombre"]);
$objPHPExcel->getActiveSheet()->setCellValue('D'.$fila,  $datos["apellido"]);
$objPHPExcel->getActiveSheet()->setCellValue('E'.$fila,  $datos["documento"]);
$objPHPExcel->getActiveSheet()->setCellValue('F'.$fila,  $datos["telefono_1"]);
$objPHPExcel->getActiveSheet()->setCellValue('G'.$fila,  $datos["telefono_2"]);
$objPHPExcel->getActiveSheet()->setCellValue('H'.$fila,  $datos["email"]);
$objPHPExcel->getActiveSheet()->setCellValue('I'.$fila,  $datos["ciudad"]);
$objPHPExcel->getActiveSheet()->setCellValue('J'.$fila,  $datos["activo"]);
$objPHPExcel->getActiveSheet()->setCellValue('K'.$fila,  $datos["estrato"]);
$objPHPExcel->getActiveSheet()->setCellValue('L'.$fila,  $datos["descripcion"]);
$objPHPExcel->getActiveSheet()->setCellValue('M'.$fila,  $datos["tipo_cliente"]);

$objPHPExcel->getActiveSheet()->setCellValue('N'.$fila,  $datos["usuario_id"]);
$objPHPExcel->getActiveSheet()->setCellValue('O'.$fila,  $datos["fecha_cotizacion"]);


$fila = $fila +1;
}


	header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
	header('Content-Disposition: attachment;filename="cotizaciones.xlsx"');
	header('Cache-Control: max-age=0');

$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
$objWriter->save('php://output');

}


?>