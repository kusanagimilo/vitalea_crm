<?php

//error_reporting(E_ALL);
error_reporting(E_STRICT);

date_default_timezone_set('America/Bogota');

require_once('class.phpmailer.php');
include("class.smtp.php"); // optional, gets called from within class.phpmailer.php if not already loaded

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
$mail->FromName = "Vitalea"; //A RELLENAR Nombre a mostrar del remitente. 
$mail->AddAddress($email); // Esta es la dirección a donde enviamos 
$mail->IsHTML(true); // El correo se envía como HTML 
$mail->Subject = "Cotizacion Vitalea"; // Este es el titulo del email. 


$body = "Envio de Cotizacion solicitada <br> "; 
$body .= "";
$mail->Body = $body; // Mensaje a enviar. 

$url = 'http://vitalea.com.co/controlador/Cotizacion_'.$cotizacion_id.'.pdf';
$fichero = file_get_contents($url);
$mail->addStringAttachment($fichero, 'Cotizacion_Vitalea.pdf');


$exito = $mail->Send(); // Envía el correo.
?>

