<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'Classes/PHPExcel.php';
include_once '../conexion/conexion_bd.php';

@$fecha_inicial = $_REQUEST["fecha_inicial"];
@$fecha_final = $_REQUEST["fecha_final"];
@$asesor = $_REQUEST["asesor"];

$fechas = "";
$asesor_seleccionado = "";
if ($fecha_inicial == null || $fecha_final == null) {
    $fechas = "N/A";
} else {
    $fechas = "inicio : " . $fecha_inicial . " fin : " . $fecha_final;
}


$filtro_asesor = "";
$filtro_fecha = "";

if ($asesor != "" || $asesor != NULL) {
    $filtro_asesor = " AND ven.usuario_id  = " . $asesor . "";
}

if ($fecha_inicial != "" || $fecha_inicial != NULL) {
    $filtro_fecha = " AND ven.fecha_pago BETWEEN '" . $fecha_inicial . "' AND '" . $fecha_final . "'";
}


$conexion = new Conexion();
$sql_p = "select ven.*,usr.nombre_completo as nombre_atendio,usr.documento as documento_atendio,
cli.documento as documento_paciente,cli.nombre as paciente_nombre,cli.apellido as apellido_paciente
from venta ven 
inner join usuario usr ON ven.usuario_id = usr.id
inner join cliente cli on ven.cliente_id = cli.id_cliente
INNER JOIN gestion ges ON ges.id = ven.gestion_id
where numero_factura is not null
and factura_athenea = 'SI'
and ven.estado = 2
$filtro_asesor 
$filtro_fecha";



$query = $conexion->prepare($sql_p);

$query->execute();

$rows = $query->fetchAll(PDO::FETCH_ASSOC);





if ($asesor == null) {
    $asesor_seleccionado = "TODOS";
} else {
    @$asesor_seleccionado = $rows[0]["nombre_atendio"];
}

$hoy = date("Y-m-d H:i:s");


$objPHPExcel = new PHPExcel();
// Estableciendo las propiedades del archivo
$objPHPExcel->getProperties()->setCreator("Vitalea")
        ->setLastModifiedBy("Vitalea")
        ->setTitle("Arqueo")
        ->setSubject("Arqueo")
        ->setDescription("Arqueo de ventas.")
        ->setKeywords("office 2007 openxml php")
        ->setCategory("Categoria -> Reportes");


$numero_filas = 4;
$objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A1', '')
        ->setCellValue('A4', 'Fecha generacion arqueo : ' . $hoy)
        ->setCellValue('A5', 'Rango de fechas : ' . $fechas)
        ->setCellValue('A6', 'Asesor : ' . $asesor_seleccionado);






$objPHPExcel->getActiveSheet()->getComment('A1')->getText()->createTextRun('Documento generado y creado Vitalea.com');
$objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(25); //Altura a la fila 1

$objPHPExcel->getActiveSheet()->getStyle("A1")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);


$objPHPExcel->getActiveSheet()->getStyle('A1:J3')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$objPHPExcel->getActiveSheet()->getStyle('A1:J3')->getFill()->getStartColor()->setARGB('ffffff'); //357320
$objPHPExcel->getActiveSheet()->mergeCells('A1:J3'); //Unir celdas

$objPHPExcel->getActiveSheet()->getStyle('A4:J6')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$objPHPExcel->getActiveSheet()->getStyle('A4:J6')->getFill()->getStartColor()->setARGB('71C6EA'); //357320
$objPHPExcel->getActiveSheet()->getStyle('A4:J6')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);



$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setName('Candara');
$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(20);
$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setUnderline(PHPExcel_Style_Font::UNDERLINE_SINGLE);
$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->getColor()->setARGB('71C6EA');
$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);


$objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A7', 'Fecha venta')
        ->setCellValue('B7', 'Factura')
        ->setCellValue('C7', 'Medio de pago')
        ->setCellValue('D7', 'Asesor')
        ->setCellValue('E7', 'Documento asesor')
        ->setCellValue('F7', 'Paciente')
        ->setCellValue('G7', 'Documento paciente')
        ->setCellValue('H7', 'Bono')
        ->setCellValue('I7', 'Valor descuento')
        ->setCellValue('J7', 'Total venta');

$objPHPExcel->getActiveSheet()->getStyle('A7:J7')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->setAutoFilter('A7:J7');
$i = 8;



foreach ($rows as $key => $value) {


    $medio_pago = "";

    if ($value["medio_pago"] == 1) {
        $medio_pago = "PSE";
    } else if ($value["medio_pago"] == 2) {
        $medio_pago = "EFECTIVO";
    } else if ($value["medio_pago"] == 3) {
        $medio_pago = "TARJETA";
    }

    $sql_valor = "select SUM(valor) as venta_total from venta_items where venta_id = '" . $value["id"] . "'";


    $query2 = $conexion->prepare($sql_valor);
    $query2->execute();
    $rows2 = $query2->fetchAll(PDO::FETCH_ASSOC);

    $bono_cant = "";
    $bono_str = "";

    if ($value['bono'] == 'NO') {
        $bono_cant = $value['bono'];
        $bono_str = "NO";
    } else {
        $sql_bono = "SELECT * FROM bono WHERE id = '" . $value["bono"] . "'";
        $query3 = $conexion->prepare($sql_bono);
        $query3->execute();
        $rows3 = $query3->fetchAll(PDO::FETCH_ASSOC);
        $bono_cant = $rows3[0]['cantidad_descuento'];
        $bono_str = "SI";
    }


    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $i, $value["fecha_pago"]);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B' . $i, $value["numero_factura"]);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C' . $i, $medio_pago);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D' . $i, utf8_decode($value["nombre_atendio"]));
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E' . $i, $value["documento_atendio"]);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F' . $i, utf8_decode($value["paciente_nombre"] . " " . $value["apellido_paciente"]));
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G' . $i, $value["documento_paciente"]);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H' . $i, $bono_str);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I' . $i, $bono_cant);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J' . $i, $rows2[0]['venta_total']);

    if ($i % 2 == 0) {
        $objPHPExcel->getActiveSheet()->getStyle('A' . $i . ':J' . $i)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
        $objPHPExcel->getActiveSheet()->getStyle('A' . $i . ':J' . $i)->getFill()->getStartColor()->setARGB('ffffff'); //357320
    } else {
        $objPHPExcel->getActiveSheet()->getStyle('A' . $i . ':J' . $i)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
        $objPHPExcel->getActiveSheet()->getStyle('A' . $i . ':J' . $i)->getFill()->getStartColor()->setARGB('ffffff'); //357320
    }
    $i += 1;
}
$objPHPExcel->getActiveSheet()->setTitle('Registro_de_ventas_arqueo');


$objDrawing = new PHPExcel_Worksheet_Drawing();
$objDrawing->setName('Logo');
$objDrawing->setDescription('Logo');
$objDrawing->setPath('../images/logo.png');

$objDrawing->setHeight(70);
$objDrawing->setCoordinates('A1');
$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());

// Establecer el índice de la hoja activa, Hoja que Excel abre como la primera hoja
$objPHPExcel->setActiveSheetIndex(0);

// Redireccionar salida al navegador
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Registro_de_atencion_de_casos.xlsx"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;




