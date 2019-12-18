<?php

date_default_timezone_set('America/Bogota');



$today = date("Y-m-d");

$time = date ("G:i:h");



$mail_to = "mailto:info_pagos@vitalea.com";

$subject = "Purchase Document from Nestle_3300139385"; 

$usuario = "soporte@peoplecontact.cc";

$mensaje_usuario = "<html><head>

</head>

<body>

 

<blockquote>
<h3>Datos Datafono</h3>


<p>


<table>
<tr height='20'>
    <td height='20' width='250'>Fecha y Hora de la    transacci&oacute;n (9A) y (9F21).</td>
  </tr>
  <tr height='20'>
    <td height='20'>Hash (DFFE01).</td>
  </tr>
  <tr height='20'>
    <td height='20'>C&oacute;digo &Uacute;nico comercio (DFFE77).</td>
  </tr>
  <tr height='20'>
    <td height='20'>Direcci&oacute;n Comercio (DFFE78).</td>
  </tr>
  <tr height='20'>
    <td height='20'>Terminal (DFFE45).</td>
  </tr>
  <tr height='20'>
    <td height='20'>Franquicia (DFFE49).</td>
  </tr>
  <tr height='20'>
    <td height='20'>Tipo de Cuenta (DFFE50).</td>
  </tr>
  <tr height='20'>
    <td height='20'>&Uacute;ltimos 4 D&iacute;gitos Tarjeta (DFFE54).</td>
  </tr>
  <tr height='20'>
    <td height='20'>RRN (DFFF14).</td>
  </tr>
  <tr height='20'>
    <td height='20'>Recibo (DFFF29).</td>
  </tr>
  <tr height='20'>
    <td height='20'>Autorizaci&oacute;n (DFFF2D).</td>
  </tr>
  <tr height='20'>
    <td height='20'>Monto Compra (DFFE40).</td>
  </tr>
  <tr height='20'>
    <td height='20'>IVA &ldquo;Si aplica&rdquo; (DFFF22).</td>
  </tr>
  <tr height='20'>
    <td height='20'>IAC &ldquo;Si aplica&rdquo; (DFFF23).</td>
  </tr>
  <tr height='20'>
    <td height='20'>Propina &ldquo;Si aplica&rdquo; (DFFF21).</td>
  </tr>
  <tr height='20'>
    <td height='20'>Identificaci&oacute;n Cliente (DFFE02).</td>
  </tr>
  <tr height='20'>
    <td height='20'>Criptograma (9F26).</td>
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
    <td height='20'>Cajero (DFFF2B).</td>
  </tr>
  <tr height='20'>
    <td height='20'>Numero Caja (DFFF25).</td>
  </tr>
  <tr height='20'>
    <td height='20'>Numero Transacci&oacute;n (DFFE53).</td>
  </tr>
  <tr height='20'>
    <td height='20'>Bloque de Firma &ldquo;Debe aparecer cuando la    transacci&oacute;n es con tarjeta cr&eacute;dito y/o d&eacute;bito autom&aacute;tico&rdquo; (DFFE03).</td>
  </tr>
  <tr height='20'>
    <td height='20'>Cuotas (DFFF26).</td>
  </tr>
  <tr height='20'>
    <td height='20'>Nombre Comercio (DFFF32)</td>
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

?>


