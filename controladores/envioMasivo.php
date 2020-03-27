<?php

require_once '../clase/Seguimiento.php';
require_once '../clase/Gestion.php';
require_once '../clase/Cliente.php';

$seguimiento = new Seguimiento();
$gestion = new Gestion();
$cliente = new Cliente();

$tipo=$_POST['tipo'];
echo $tipo;
    if($tipo=='222'){
    $textarea               = $_POST['textarea'];
    $cliente_seleccionado   = $_POST['cliente_seleccionado'];
    $adjuntos_doc           = $_POST['adjuntos_doc'];
    $file                   = $_FILES['archivo']['name'];
    $mensaje                = $_POST["mensaje"];
    $cliente_seleccionado   = $_POST["cliente_seleccionado"];

    echo "textarea: ".$textarea;."<br>";
    echo "cliente_seleccionado: ".$cliente_seleccionado;."<br>";
    echo "adjuntos_doc: ".$adjuntos_doc;."<br>";
    die();
    }
    $dir = '../web/email/adjuntos/';

    $nombre_archivo=str_replace(" ","_",$_FILES['archivo']['name']);

    $fichero_subido = $dir.$nombre_archivo;
    
    move_uploaded_file($_FILES['archivo']['tmp_name'], $fichero_subido);
        
        require_once('../web/email/class.phpmailer.php');
        include("../web/email/class.smtp.php"); // optional, gets called from within class.phpmailer.php if not already loaded

        $mail = new PHPMailer();

        $mail->IsSMTP();
        $mail->SMTPAuth   = true;
        $mail->SMTPSecure = "tls";
        $mail->Host       = "smtp.gmail.com";
        $mail->Username   = "hola@vitalea.com.co";
        $mail->Password   = "vitaleah2019*";
        $mail->Port       = 587;

        $mail->From = "hola@vitalea.com.co"; // A RELLENARDesde donde enviamos (Para mostrar). Puede ser el mismo que el email creado previamente.
        $mail->FromName = "Vive + Lab"; //A RELLENAR Nombre a mostrar del remitente. 
         // Esta es la dirección a donde enviamos 
        $mail->AddCC("colcanpruebas@arcoscontactcenter.com.co");
        $mail->IsHTML(true); // El correo se envía como HTML 
        $mail->Subject = "Cotizacion Vive + Lab"; // Este es el titulo del email. 

        $body = $mensaje; 
        $mail->Body = $body; 

        $lista_email = $cliente->correos_paciente($cliente_seleccionado);

        foreach ($lista_email as $email) {
            if($email["email"] != ""){
                $mail->AddAddress($email["email"]);
                $url = 'https://arcos-crm.com/crm_colcan/web/email/adjuntos/'.$nombre_archivo;
                $fichero = file_get_contents($url);
                $mail->addStringAttachment($fichero, $file);

                $mail->send();
                $mail->clearAddresses();
                $mail->clearAttachments();
            }
        }

        echo 1;


    


?>
