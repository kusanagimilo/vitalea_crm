
<?php
//Agregamos la libreria para genera códigos QR
	require "../web/phpqrcode/qrlib.php";  
	
	//Declaramos una carpeta temporal para guardar la imagenes generadas
	$dir = 'codigo_qr/';
	
	//Si no existe la carpeta la creamos
	if (!file_exists($dir))
        mkdir($dir);
	
        //Declaramos la ruta y nombre del archivo a generar
	$filename = $dir.'codigo_venta_'.$venta_id.".png";
 
        //Parametros de Condiguración
	
	$tamaño = 10; //Tamaño de Pixel
	$level = 'H'; //Precisión Baja
	$framSize = 3; //Tamaño en blanco

	$contenido = "documento = ".$documento.", nombre = ".$nombre;
	$datos_venta = $caja->consultar_examenes_venta($cliente_id,$venta_id);
        foreach($datos_venta as $valores){
        	
            $contenido .=", examen = ". $valores["nombre"].", valor =".$valores["valor"]; //Texto
        }
	
	
        //Enviamos los parametros a la Función para generar código QR 
	QRcode::png($contenido, $filename, $level, $tamaño, $framSize); 
	
   
?>