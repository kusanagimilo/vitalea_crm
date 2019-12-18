<?php

$conexion=mysqli_connect('localhost','root','bi2f5Oav2806*','crm_preatencion')or die ("no se pudo");
mysqli_select_db($conexion,'crm_preatencion') or die ("no se puede conectar a la database"); 

$codigo_ini = substr(md5(uniqid(rand())),0,1);
$hora = date("M j, Y, g:i a"); 
$codigo_hora = md5($hora) ;
$codigo_inicial = $codigo_ini."".$codigo_hora;


date_default_timezone_set('America/Bogota');
$today = date("Y-m-d");
$time = date ("G:i:h") ;
$mail_to = "mailto:info_pagos@vitalea.com";
$subject = "Voucher"; 
$usuario = "soporte@peoplecontact.cc";
$mensaje_usuario = "<html><head>

</head>
<body>
<blockquote>
<h3>Datos Datafono</h3>
<p>
<table>
<tr height='20'>
    <td height='20' width='250'>Fecha y Hora de la transacci&oacute;n $today y $time </td>
  </tr>
  <tr height='20'>
    <td height='20'>Hash 0000 .</td>
  </tr>
  <tr height='20'>
    <td height='20'>C&oacute;digo &Uacute;nico comercio 0004477745885.</td>
  </tr>
  <tr height='20'>
    <td height='20'>Direcci&oacute;n Comercio Cr 00 # 00- 00 prueba.</td>
  </tr>
  <tr height='20'>
    <td height='20'>Terminal AVFP.</td>
  </tr>
  <tr height='20'>
    <td height='20'>Franquicia N/A.</td>
  </tr>
  <tr height='20'>
    <td height='20'>Tipo de Cuenta .</td>
  </tr>
  <tr height='20'>
    <td height='20'>&Uacute;ltimos 4 D&iacute;gitos Tarjeta 8726.</td>
  </tr>
  <tr height='20'>
    <td height='20'>RRN 001224.</td>
  </tr>
  <tr height='20'>
    <td height='20'>Recibo 054.</td>
  </tr>
  <tr height='20'>
    <td height='20'>Autorizaci&oacute;n Acepto.</td>
  </tr>
  <tr height='20'>
    <td height='20'>Monto Compra: $280.000</td>
  </tr>
  <tr height='20'>
    <td height='20'>IVA &ldquo;Si aplica&rdquo; N/A.</td>
  </tr>
  <tr height='20'>
    <td height='20'>IAC &ldquo;Si aplica&rdquo; N/A.</td>
  </tr>
  <tr height='20'>
    <td height='20'>Propina &ldquo;Si aplica&rdquo; N/A.</td>
  </tr>
  <tr height='20'>
    <td height='20'>Identificaci&oacute;n Cliente 1012345678.</td>
  </tr>
  <tr height='20'>
    <td height='20'>Criptograma $codigo_inicial</td>
  </tr>
  <tr height='20'>
    <td height='20'>TVR (95).</td>
  </tr>
  <tr height='20'>
    <td height='20'>TSI (9B).</td>
  </tr>
  <tr height='20'>
    <td height='20'>AID (4F).</td>
  </tr>
  <tr height='20'>
    <td height='20'>Cajero 1.</td>
  </tr>
  <tr height='20'>
    <td height='20'>Numero Caja 1.</td>
  </tr>
  <tr height='20'>
    <td height='20'>Numero Transacci&oacute;n 01100145.</td>
  </tr>
  <tr height='20'>
    <td height='20'><img src=''/></td>
  </tr>
  <tr height='20'>
    <td height='20'>Cuotas 1.</td>
  </tr>
  <tr height='20'>
    <td height='20'>Nombre Comercio COLCAN</td>
  </tr></table>

</p>

</blockquote>

</body>

</html>";

//*** Uniqid Session ***//  

//cargar archivos a la carpeta seleccionada

// Para enviar un correo HTML mail, la cabecera Content-type debe fijarse

$cabeceras  = 'MIME-Version: 1.0' . "\r\n";

$cabeceras .= 'Content-type: text/html; charset=utf-8' . "\r\n";

//cabeceras adicionales<br />

$cabeceras .= 'From:  Pago Vitalea<info_pagos@vitalea.com>'."\r\n";

//con esto guardamos la URL en la variable enlace....

//ahora bien esta URL es la que toma por defecto en la pagina que corre este mismo script

//espero se entienda puedes hacer una prueba poniendo

mail($usuario,$subject,$mensaje_usuario,$cabeceras);

header('Location: ' . $_SERVER['HTTP_REFERER']);


/*
sql = mysqli_query($conexion,"");
*/
?>


