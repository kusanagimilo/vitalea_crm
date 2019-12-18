<?php

require_once '../include/script.php';
require_once '../include/header_administrador.php';
require_once '../clase/archivos_correos.php';

$archivos = new Archivos();

$cliente = $_POST['cliente_seleccionado'];
$mensaje = $_POST['mensaje'];
$replace1=str_replace("\r","<br>",$mensaje);
$replace2=str_replace("á","&aacute;",$replace1);
$replace3=str_replace("é","&eacute;",$replace2);
$replace4=str_replace("í","&iacute;",$replace3);
$replace5=str_replace("ó","&oacute;",$replace4);
$replace6=str_replace("ú","&uacute;",$replace5);
$replace7=str_replace("Á","&Aacute;",$replace6);
$replace8=str_replace("É","&Eacute;",$replace7);
$replace9=str_replace("Í","&Iacute;",$replace8);
$replace10=str_replace("Ó","&Oacute;",$replace9);
$replace11=str_replace("Ú","&Uacute;",$replace10);
$replace12=str_replace("ñ","&ntilde;",$replace11);
$replace=str_replace("Ñ","&Ntilde;",$replace12);


if (empty($cliente)) {
?>
<script language="JavaScript" type="text/javascript">
alertify.alert("Debe seleccionar un usuario para enviar el correo");

function redireccionarPagina() {
  window.location = "envio_datos_correo.php";
}
setTimeout("redireccionarPagina()", 2000);
</script>

<?php
}else{

$cliente ;
$porciones = explode(",", $cliente);



//guardar imagenes

if ($_FILES['file-upload']['name'] != null) {
    // obtenemos los datos del archivo
    $tamano = $_FILES["file-upload"]['size'];
    $tipo = $_FILES["file-upload"]['type'];
	$archivo1 = $_FILES["file-upload"]['name'];
	$archivo1 = str_replace(" ","_",$archivo1);
    $prefijo1 = substr(md5(uniqid(rand())),0,3);
    $destino =  "email/adjuntos/".$prefijo1."_".$archivo1;
    if ($archivo1 != "") {
	copy($_FILES['file-upload']['tmp_name'],$destino);
	}

$enlace = "https://arcos-crm.com/crm_colcan/web/email/adjuntos/".$prefijo1."_".$archivo1."";
$codigo = substr(md5(uniqid(rand())),0,20);


$guardar_enlace = $archivos->cargar_archivos_enlace($enlace,$codigo);

$mostrar_enlace = $archivos->llamar_archivo($codigo);

} 



// guardar archivos

if ($_FILES['file-upload-archivos']['name'] != null) {
    // obtenemos los datos del archivo
    $tamano2 = $_FILES["file-upload-archivos"]['size'];
    $tipo2 = $_FILES["file-upload-archivos"]['type'];
	$archivo2 = $_FILES["file-upload-archivos"]['name'];
	$archivo2 = str_replace(" ","_",$archivo2);
    $prefijo2 = substr(md5(uniqid(rand())),0,3);
    $destino2 =  "email/adjuntos/".$prefijo2."_".$archivo2;
    if ($archivo2 != "") {
	copy($_FILES['file-upload-archivos']['tmp_name'],$destino2);
	}

	$enlace2 = "https://arcos-crm.com/crm_colcan/web/email/adjuntos/".$prefijo2."_".$archivo2."";
$codigo2 = substr(md5(uniqid(rand())),0,20);


$guardar_enlace_archivos = $archivos->cargar_archivos_enlace2($enlace2,$codigo2);

$mostrar_enlace_archivos = $archivos->llamar_archivo2($codigo2);

$descarga_adjunto = "<a href=".$mostrar_enlace_archivos.">".$archivo2."</a><br />";
} 


if ($_FILES['file-upload']['name'] == null && $_FILES['file-upload-archivos']['name'] == null) {

	$message = "
<html>
<head>
<title>HTML</title>
</head>
<body>

<p>".$replace."</p>

<br>
<br>
</body>
</html>";
?>
<script language="JavaScript" type="text/javascript">
alertify.alert("Correos enviados correctamente");

function redireccionarPagina() {
  window.location = "envio_datos_correo.php";
}
setTimeout("redireccionarPagina()", 2000);
</script>

<?php
$i=0;
while ($porciones[$i] !=0) {

$correo[$i] = $archivos->mostrar_correo($porciones[$i]);
$i++;
}


  //error_reporting(E_ALL);
error_reporting(E_STRICT);

date_default_timezone_set('America/Bogota');

require_once('../controlador/class.phpmailer.php');
include("../controlador/class.smtp.php"); // optional, gets called from within class.phpmailer.php if not already loaded

$mail                = new PHPMailer();

$mail->IsSMTP();
$mail->SMTPAuth   = true;
$mail->SMTPSecure = "tls";
$mail->Host       = "smtp.gmail.com";
$mail->Username   = "infovivelab@gmail.com";
$mail->Password   = "vivelab_info2018**++";
$mail->Port       = 587;
//Luego tenemos que iniciar la validación por SMTP:
/*
$mail->SMTPAuth = true;
$mail->Host = "arcoscontactcenter.com.co"; // A RELLENAR. Aquí pondremos el SMTP a utilizar. Por ej. mail.midominio.com
$mail->Username = "colcanpruebas@arcoscontactcenter.com.co"; // A RELLENAR. Email de la cuenta de correo. ej.info@midominio.com La cuenta de correo debe ser creada previamente. 
$mail->Password = "Colombia2018*"; // A RELLENAR. Aqui pondremos la contraseña de la cuenta de correo
$mail->Port = 465; // Puerto de conexión al servidor de envio. */
$mail->From = "infovivelab@gmail.com"; // A RELLENARDesde donde enviamos (Para mostrar). Puede ser el mismo que el email creado previamente.
$mail->FromName = "Informacion vitalea"; //A RELLENAR Nombre a mostrar del remitente. 
foreach ($correo as $key => $value) {
$mail->AddAddress($value); // Esta es la dirección a donde enviamos 
}



$mail->AddCC("colcanpruebas@arcoscontactcenter.com.co");
$mail->IsHTML(true); // El correo se envía como HTML 
$mail->Subject = "Informacion vitalea"; // Este es el titulo del email. 


$body = "".$message." <br> "; 
$body .= "";
$mail->Body = $body; // Mensaje a enviar. 

//$url = 'https://arcos-crm.com/crm_colcan/controlador/Cotizacion_'.$cotizacion_id.'.pdf';



$exito = $mail->Send(); // Envía el correo.
 $mail->clearAddresses();
$mail->clearAttachments();
	
}else if ($_FILES['file-upload']['name'] != null &&  $_FILES['file-upload-archivos']['name'] == null) {
$message = "
<html>
<head>
<title>HTML</title>
</head>
<body>

<p>".$replace."</p>
<center><img width=700 height=500 src='".$mostrar_enlace."'/></center>
<br>
<br>
</body>
</html>";

?>
<script language="JavaScript" type="text/javascript">
alertify.alert("Correos enviados correctamente");

function redireccionarPagina() {
  window.location = "envio_datos_correo.php";
}
setTimeout("redireccionarPagina()", 2000);
</script>

<?php


$i=0;
while ($porciones[$i] !=0) {

$correo[$i] = $archivos->mostrar_correo($porciones[$i]);
$i++;
}


  //error_reporting(E_ALL);
error_reporting(E_STRICT);

date_default_timezone_set('America/Bogota');

require_once('../controlador/class.phpmailer.php');
include("../controlador/class.smtp.php"); // optional, gets called from within class.phpmailer.php if not already loaded

$mail                = new PHPMailer();

$mail->IsSMTP();
$mail->SMTPAuth   = true;
$mail->SMTPSecure = "tls";
$mail->Host       = "smtp.gmail.com";
$mail->Username   = "infovivelab@gmail.com";
$mail->Password   = "vivelab_info2018**++";
$mail->Port       = 587;
//Luego tenemos que iniciar la validación por SMTP:
/*
$mail->SMTPAuth = true;
$mail->Host = "arcoscontactcenter.com.co"; // A RELLENAR. Aquí pondremos el SMTP a utilizar. Por ej. mail.midominio.com
$mail->Username = "colcanpruebas@arcoscontactcenter.com.co"; // A RELLENAR. Email de la cuenta de correo. ej.info@midominio.com La cuenta de correo debe ser creada previamente. 
$mail->Password = "Colombia2018*"; // A RELLENAR. Aqui pondremos la contraseña de la cuenta de correo
$mail->Port = 465; // Puerto de conexión al servidor de envio. */
$mail->From = "infovivelab@gmail.com"; // A RELLENARDesde donde enviamos (Para mostrar). Puede ser el mismo que el email creado previamente.
$mail->FromName = "Informacion vitalea"; //A RELLENAR Nombre a mostrar del remitente. 
foreach ($correo as $key => $value) {
$mail->AddAddress($value); // Esta es la dirección a donde enviamos 
}



$mail->AddCC("colcanpruebas@arcoscontactcenter.com.co");
$mail->IsHTML(true); // El correo se envía como HTML 
$mail->Subject = "Informacion vitalea"; // Este es el titulo del email. 


$body = "".$message." <br> "; 
$body .= "";
$mail->Body = $body; // Mensaje a enviar. 

//$url = 'https://arcos-crm.com/crm_colcan/controlador/Cotizacion_'.$cotizacion_id.'.pdf';



$exito = $mail->Send(); // Envía el correo.
 $mail->clearAddresses();
$mail->clearAttachments();
}else if ($_FILES['file-upload']['name'] == null &&  $_FILES['file-upload-archivos']['name'] != null) {

$message = "
<html>
<head>
<title>HTML</title>
</head>
<body>
<label>".$descarga_adjunto."</label>
<p>".$replace."</p>
<br>
<br>
</body>
</html>";

?>
<script language="JavaScript" type="text/javascript">
alertify.alert("Correos enviados correctamente");

function redireccionarPagina() {
  window.location = "envio_datos_correo.php";
}
setTimeout("redireccionarPagina()", 2000);
</script>

<?php


$i=0;
while ($porciones[$i] !=0) {

$correo[$i] = $archivos->mostrar_correo($porciones[$i]);
$i++;
}


  //error_reporting(E_ALL);
error_reporting(E_STRICT);

date_default_timezone_set('America/Bogota');

require_once('../controlador/class.phpmailer.php');
include("../controlador/class.smtp.php"); // optional, gets called from within class.phpmailer.php if not already loaded

$mail                = new PHPMailer();

$mail->IsSMTP();
$mail->SMTPAuth   = true;
$mail->SMTPSecure = "tls";
$mail->Host       = "smtp.gmail.com";
$mail->Username   = "infovivelab@gmail.com";
$mail->Password   = "vivelab_info2018**++";
$mail->Port       = 587;
//Luego tenemos que iniciar la validación por SMTP:
/*
$mail->SMTPAuth = true;
$mail->Host = "arcoscontactcenter.com.co"; // A RELLENAR. Aquí pondremos el SMTP a utilizar. Por ej. mail.midominio.com
$mail->Username = "colcanpruebas@arcoscontactcenter.com.co"; // A RELLENAR. Email de la cuenta de correo. ej.info@midominio.com La cuenta de correo debe ser creada previamente. 
$mail->Password = "Colombia2018*"; // A RELLENAR. Aqui pondremos la contraseña de la cuenta de correo
$mail->Port = 465; // Puerto de conexión al servidor de envio. */
$mail->From = "infovivelab@gmail.com"; // A RELLENARDesde donde enviamos (Para mostrar). Puede ser el mismo que el email creado previamente.
$mail->FromName = "Informacion vitalea"; //A RELLENAR Nombre a mostrar del remitente. 
foreach ($correo as $key => $value) {
$mail->AddAddress($value); // Esta es la dirección a donde enviamos 
}



$mail->AddCC("colcanpruebas@arcoscontactcenter.com.co");
$mail->IsHTML(true); // El correo se envía como HTML 
$mail->Subject = "Informacion vitalea"; // Este es el titulo del email. 


$body = "".$message." <br> "; 
$body .= "";
$mail->Body = $body; // Mensaje a enviar. 

//$url = 'https://arcos-crm.com/crm_colcan/controlador/Cotizacion_'.$cotizacion_id.'.pdf';
//$fichero = file_get_contents($enlace2);
//$mail->addStringAttachment($fichero,'archivo adjunto');


$exito = $mail->Send(); // Envía el correo.
 $mail->clearAddresses();
$mail->clearAttachments();
}elseif ($_FILES['file-upload']['name'] != null &&  $_FILES['file-upload-archivos']['name'] != null) {

	$message = "
<html>
<head>
<title>HTML</title>
</head>
<body>
<label>".$descarga_adjunto."</label>
<p>".$replace."</p>
<center><img width=700 height=500 src='".$mostrar_enlace."'/></center>
<br>
<br>
</body>
</html>";

?>
<script language="JavaScript" type="text/javascript">
alertify.alert("Correos enviados correctamente");

function redireccionarPagina() {
  window.location = "envio_datos_correo.php";
}
setTimeout("redireccionarPagina()", 2000);
</script>

<?php


$i=0;
while ($porciones[$i] !=0) {

$correo[$i] = $archivos->mostrar_correo($porciones[$i]);
$i++;
}


  //error_reporting(E_ALL);
error_reporting(E_STRICT);

date_default_timezone_set('America/Bogota');

require_once('../controlador/class.phpmailer.php');
include("../controlador/class.smtp.php"); // optional, gets called from within class.phpmailer.php if not already loaded

$mail                = new PHPMailer();

$mail->IsSMTP();
$mail->SMTPAuth   = true;
$mail->SMTPSecure = "tls";
$mail->Host       = "smtp.gmail.com";
$mail->Username   = "infovivelab@gmail.com";
$mail->Password   = "vivelab_info2018**++";
$mail->Port       = 587;
//Luego tenemos que iniciar la validación por SMTP:
/*
$mail->SMTPAuth = true;
$mail->Host = "arcoscontactcenter.com.co"; // A RELLENAR. Aquí pondremos el SMTP a utilizar. Por ej. mail.midominio.com
$mail->Username = "colcanpruebas@arcoscontactcenter.com.co"; // A RELLENAR. Email de la cuenta de correo. ej.info@midominio.com La cuenta de correo debe ser creada previamente. 
$mail->Password = "Colombia2018*"; // A RELLENAR. Aqui pondremos la contraseña de la cuenta de correo
$mail->Port = 465; // Puerto de conexión al servidor de envio. */
$mail->From = "infovivelab@gmail.com"; // A RELLENARDesde donde enviamos (Para mostrar). Puede ser el mismo que el email creado previamente.
$mail->FromName = "Informacion vitalea"; //A RELLENAR Nombre a mostrar del remitente. 
foreach ($correo as $key => $value) {
$mail->AddAddress($value); // Esta es la dirección a donde enviamos 
}



$mail->AddCC("colcanpruebas@arcoscontactcenter.com.co");
$mail->IsHTML(true); // El correo se envía como HTML 
$mail->Subject = "Informacion vitalea"; // Este es el titulo del email. 


$body = "".$message." <br> "; 
$body .= "";
$mail->Body = $body; // Mensaje a enviar. 

//$url = 'https://arcos-crm.com/crm_colcan/controlador/Cotizacion_'.$cotizacion_id.'.pdf';
//$fichero = file_get_contents($mostrar_enlace);
//$mail->addStringAttachment($fichero,'archivo adjunto');


$exito = $mail->Send(); // Envía el correo.
 $mail->clearAddresses();
$mail->clearAttachments();
	
}

}

?>