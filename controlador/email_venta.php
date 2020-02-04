<?php

//error_reporting(E_ALL);
error_reporting(E_STRICT);
require_once '../conexion/conexion_bd.php';
date_default_timezone_set('America/Bogota');

require_once('class.phpmailer.php');
include("class.smtp.php"); // optional, gets called from within class.phpmailer.php if not already loaded

function EnviarCorreoVenta($id_venta, $correo_cliente) {
    $mail = new PHPMailer();
    $mail->charSet = "UTF-8";
    $mail->IsSMTP();
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = "tls";
    $mail->Host = "smtp.gmail.com";
    $mail->Username = "infovivelab@gmail.com";
    $mail->Password = "vivelab_info2018**++";
    $mail->Port = 587;
//Luego tenemos que iniciar la validación por SMTP:
    /*
      $mail->SMTPAuth = true;
      $mail->Host = "arcoscontactcenter.com.co"; // A RELLENAR. Aquí pondremos el SMTP a utilizar. Por ej. mail.midominio.com
      $mail->Username = "colcanpruebas@arcoscontactcenter.com.co"; // A RELLENAR. Email de la cuenta de correo. ej.info@midominio.com La cuenta de correo debe ser creada previamente.
      $mail->Password = "Colombia2018*"; // A RELLENAR. Aqui pondremos la contraseña de la cuenta de correo
      $mail->Port = 465; // Puerto de conexión al servidor de envio. */
    $mail->From = "infovivelab@gmail.com"; // A RELLENARDesde donde enviamos (Para mostrar). Puede ser el mismo que el email creado previamente.
    $mail->FromName = "Vitalea"; //A RELLENAR Nombre a mostrar del remitente. 
    $mail->AddAddress($correo_cliente); // Esta es la dirección a donde enviamos 
    $mail->IsHTML(true); // El correo se envía como HTML 
    $mail->Subject = "Codigo de Confirmacion Vitalea"; // Este es el titulo del email. 


    $body = "<b style='font-size: 14px;'>Bienvenido a Vitălea</b>
            <br><br>
            <span style='font-size: 14px;'>Estas a un paso de ser parte del primer laboratorio  de salud proactiva a tu alcance.<br><br>
            Presenta este ticket en nuestras instalaciones para continuar el proceso.<br>
            Es momento de tomar la iniciativa , anticiparte y empoderarte. La decisión esta en tus manos.</span><br><br>
            <center><b>Salud proactiva</b></center>";
    $body .= "";
    $mail->Body = $body; // Mensaje a enviar. 

    $url = 'TICKET_VENTA_' . $id_venta . '.pdf';
    $fichero = file_get_contents($url);
    $mail->addStringAttachment($fichero, 'Codigo de Confirmacion.pdf');

    $exito = $mail->Send(); // Envía el correo.

    if ($exito) {
        $correo_e = 1;
    } else {
        $correo_e = 3;
    }

    return $correo_e;
}

function EnviarCorreoPrecotizacion($correo, $id_cotizacion) {

    $conexion = new Conexion();

    $query = $conexion->prepare("SELECT pre.*,us.nombre_completo
                                 FROM precotizacion pre
                                 INNER JOIN usuario us ON us.id = pre.id_usr_creo
                                 WHERE pre.id_precotizacion =:id_precotizacion");
    $query->execute(array(':id_precotizacion' => $id_cotizacion));
    $rows = $query->fetchAll(PDO::FETCH_ASSOC);
    $nombre_cliente = $rows[0]['nombre_cliente'];
    $telefono_cliente = $rows[0]['telefono'];
    $fecha = $rows[0]['fecha_creacion'];
    $total = $rows[0]['valor'];
    $id_cot = $rows[0]['id_precotizacion'];
    $nombre_asesor = $rows[0]['nombre_completo'];
    $direccion = $rows[0]['direccion'];

    $sql_items = "SELECT * FROM precotizacion_items WHERE id_precotizacion = :id_precotizacion";
    $query_items = $conexion->prepare($sql_items);
    $query_items->execute(array(':id_precotizacion' => $id_cotizacion));
    $rows2 = $query_items->fetchAll(PDO::FETCH_ASSOC);

    $html_items = "";


    foreach ($rows2 as $key => $value) {
        $sql_info = "";
        $html_complemento = "";
        if ($value['tipo_item'] == 'perfil') {
            $sql_info = "select nombre,precio,codigo_crm as codigo from examen where id =:id";
            $sql_complemento = "select exam.codigo,exam.nombre
from perfil_examen pex
inner join examenes_no_perfiles exam on exam.id = pex.id_examen
where pex.id_perfil = :id_perfil";
            $query_complemento = $conexion->prepare($sql_complemento);
            $query_complemento->execute(array(':id_perfil' => $value['id_item']));
            $rows_complemento = $query_complemento->fetchAll(PDO::FETCH_ASSOC);
            $html_complemento = '</br><ul style="font-size: 11px;">';
            foreach ($rows_complemento as $key3 => $value3) {
                $html_complemento .= "<li>" . $value3['codigo'] . " " . $value3['nombre'] . "</li>";
            }
            $html_complemento .= '</ul>';
        }if ($value['tipo_item'] == 'examen') {
            $sql_info = "select nombre,precio,codigo from examenes_no_perfiles where id =:id";
            $html_complemento = "";
        }
        $query_info = $conexion->prepare($sql_info);
        $query_info->execute(array(':id' => $value['id_item']));
        $rows3 = $query_info->fetchAll(PDO::FETCH_ASSOC);

        /*
         * <ul style="font-size: 12px;">
          <li>dsadsa</li>
          <li>dsadsa</li>
          </ul>
         */


        $nombre_item = $rows3[0]['nombre'];
        $precio_item = $rows3[0]['precio'];
        $codigo_item = $rows3[0]['codigo'];

        $html_items .= ' <tr>
                                    <td valign="top">
                                        <table width="100%" align="center" border="0" cellspacing="0" cellpadding="0" style="background-color: #ffffff; margin: 0px auto; min-width: 100%;" role="presentation" bgcolor="#ffffff">
                                            <tr>
                                                <td valign="top" style="padding-left: 20px; padding-right: 20px;">
                                                    <table width="100%" align="center" border="0" cellspacing="0" cellpadding="0" style="border-bottom: 1px solid rgb(232, 232, 232); background-color: #ffffff; margin: 0px auto; min-width: 100%;" role="presentation" bgcolor="#ffffff">
                                                        <tr>
                                                            <td valign="top" height="1" style="height: 1px; font-size: 0px; line-height: 0;" aria-hidden="true">&nbsp;</td>
                                                        </tr>
                                                        <tr>
                                                            <td valign="top" height="25" width="300" style="font-size: 14px; color: #888888; font-weight: normal; font-family: Open Sans, Arial, Helvetica, sans-serif; word-break: break-word; line-height: 1;" align="left"><span style="font-style: normal; text-align: left; color: #888888; line-height: 24px; font-size: 14px; font-weight: 400; font-family: Montserrat, arial, sans-serif;"><span style="font-style: normal; text-align: left; color: #888888; line-height: 24px; font-size: 14px; font-weight: 400; font-family: Montserrat, arial, sans-serif;">' . $codigo_item . ' ' . $nombre_item . ' '.$html_complemento.'</span></span><br></td>
                                                            <td valign="top">
                                                                <table width="100%" align="center" border="0" cellspacing="0" cellpadding="0" style="height: 100%; margin: 0px auto; min-width: 100%;" role="presentation">
                                                                    <tr>
                                                                        <td valign="top" style="font-size: 14px; color: #333333; font-weight: normal; font-family: Open Sans, Arial, Helvetica, sans-serif; word-break: break-word; line-height: 1;" align="right"><span style="color: #808080; font-style: normal; text-align: right; line-height: 24px; font-size: 14px; font-weight: 400; font-family: Open Sans, Arial, Helvetica, sans-serif;"><span style="color: #808080; font-style: normal; text-align: right; line-height: 24px; font-size: 14px; font-weight: 400; font-family: Montserrat, arial, sans-serif;"><span style="font-style: normal; text-align: right; color: #808080; line-height: 24px; font-size: 14px; font-weight: 400; font-family: Montserrat, arial, sans-serif;"> $' . $precio_item . '</span></span> </span></td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td valign="top" height="1" style="height: 1px; font-size: 0px; line-height: 0;" aria-hidden="true">&nbsp;</td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>';
    }





    $mail = new PHPMailer();
    $mail->charSet = "UTF-8";
    $mail->IsSMTP();
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = "tls";
    $mail->Host = "smtp.gmail.com";
    $mail->Username = "infovivelab@gmail.com";
    $mail->Password = "vivelab_info2018**++";
    $mail->Port = 587;
//Luego tenemos que iniciar la validación por SMTP:
    /*
      $mail->SMTPAuth = true;
      $mail->Host = "arcoscontactcenter.com.co"; // A RELLENAR. Aquí pondremos el SMTP a utilizar. Por ej. mail.midominio.com
      $mail->Username = "colcanpruebas@arcoscontactcenter.com.co"; // A RELLENAR. Email de la cuenta de correo. ej.info@midominio.com La cuenta de correo debe ser creada previamente.
      $mail->Password = "Colombia2018*"; // A RELLENAR. Aqui pondremos la contraseña de la cuenta de correo
      $mail->Port = 465; // Puerto de conexión al servidor de envio. */
    $mail->From = "hola@vitalea.com.co"; // A RELLENARDesde donde enviamos (Para mostrar). Puede ser el mismo que el email creado previamente.
    $mail->FromName = "Vitalea"; //A RELLENAR Nombre a mostrar del remitente. 
    $mail->AddAddress($correo); // Esta es la dirección a donde enviamos 
    $mail->IsHTML(true); // El correo se envía como HTML 
    $mail->Subject = "Cotizacion servicios vitalea"; // Este es el titulo del email. 


    $body = <<<ini
<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700,300|Montserrat:400,700&subset=latin,cyrillic,greek" rel="stylesheet" type="text/css">
<style type="text/css">
    .ReadMsgBody { width: 100%; background-color: #ffffff;}
    .ExternalClass {width: 100%; background-color: #ffffff;}
    .ExternalClass, .ExternalClass p, .ExternalClass span,
    .ExternalClass font, .ExternalClass td, .ExternalClass tbody {line-height:100%;}
    #outlook a { padding:0;}
    html,body {margin: 0 auto !important; padding: 0 !important; height: 100% !important; width: 100% !important;}
    * {-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;}
    table,td {mso-table-lspace: 0pt !important; mso-table-rspace: 0pt !important;}
    table {border-spacing: 0 !important;}
    table table table {table-layout: auto;}
    a,span a{text-decoration: none !important;}
    .yshortcuts, .yshortcuts a, .yshortcuts a:link,.yshortcuts a:visited,
    .yshortcuts a:hover, .yshortcuts a span { text-decoration: none !important; border-bottom: none !important;}

    /*mailChimp class*/
    ul{padding-left:10px; margin:0;}
    .default-edit-image{height:20px;}
    .tpl-repeatblock {padding: 0px !important; border: 1px dotted rgba(0,0,0,0.2);}
    .tpl-content {padding:0px !important;}

    /* Start Old CSS */
    @media only screen and (max-width: 640px){
        .container{width:95%!important; max-width:95%!important; min-width:95%!important;
                   padding-left:15px!important; padding-right:15px!important; text-align: center!important; clear: both;}
        .full-width{width:100%!important; max-width:100%!important; min-width:100%!important; clear: both;}
        .full-width-center {width: 100%!important; max-width:100%!important;  text-align: center!important; clear: both; margin:0 auto; float:none;}
        .force-240-center{width:240px !important; clear: both; margin:0 auto; float:none;}
        .auto-center {width: auto!important; max-width:100%!important;  text-align: center!important; clear: both; margin:0 auto; float:none;}
        .auto-center-all{width: auto!important; max-width:75%!important;  text-align: center!important; clear: both; margin:0 auto; float:none;}
        .auto-center-all * {width: auto!important; max-width:100%!important;  text-align: center!important; clear: both; margin:0 auto; float:none;}
        .col-3,.col-3-not-full{width:30.35%!important; max-width:100%!important;}
        .col-2{width:47.3%!important; max-width:100%!important;}
        .full-block{display:block !important; clear: both;}
        /* image */
        .image-full-width img{width:100% !important; height:auto !important; max-width:100% !important;}
        /* helper */
        .space-w-20{width:3.57%!important; max-width:20px!important; min-width:3.5% !important;}
        .space-w-20 td:first-child{width:3.5%!important; max-width:20px!important; min-width:3.5% !important;}
        .space-w-25{width:4.45%!important; max-width:25px!important; min-width:4.45% !important;}
        .space-w-25 td:first-child{width:4.45%!important; max-width:25px!important; min-width:4.45% !important;}
        .space-w-30 td:first-child{width:5.35%!important; max-width:30px!important; min-width:5.35% !important;}
        .fix-w-20{width:20px!important; max-width:20px!important; min-width:20px!important;}
        .fix-w-20 td:first-child{width:20px!important; max-width:20px!important; min-width:20px !important;}
        .h-10{display:block !important;  height:10px !important;}
        .h-20{display:block !important;  height:20px !important;}
        .h-30{display:block !important; height:30px !important;}
        .h-40{display:block !important;  height:40px !important;}
        .remove-640{display:none !important;}
        .text-left{text-align:left !important;}
        .clear-pad{padding:0 !important;}
    }
    @media only screen and (max-width: 479px){
        .container{width:95%!important; max-width:95%!important; min-width:124px!important;
                   padding-left:15px!important; padding-right:15px!important; text-align: center!important; clear: both;}
        .full-width,.full-width-479{width:100%!important; max-width:100%!important; min-width:124px!important; clear: both;}
        .full-width-center {width: 100%!important; max-width:100%!important; min-width:124px!important; text-align: center!important; clear: both; margin:0 auto; float:none;}
        .auto-center-all{width: 100%!important; max-width:100%!important;  text-align: center!important; clear: both; margin:0 auto; float:none;}
        .auto-center-all * {width: auto!important; max-width:100%!important;  text-align: center!important; clear: both; margin:0 auto; float:none;}
        .col-3{width:100%!important; max-width:100%!important; text-align: center!important; clear: both;}
        .col-3-not-full{width:30.35%!important; max-width:100%!important; }
        .col-2{width:100%!important; max-width:100%!important; text-align: center!important; clear: both;}
        .full-block-479{display:block !important; clear: both; padding-top:10px; padding-bottom:10px; }
        /* image */
        .image-full-width img{width:100% !important; height:auto !important; max-width:100% !important; min-width:124px !important;}
        .image-min-80 img{width:100% !important; height:auto !important; max-width:100% !important; min-width:80px !important;}
        .image-min-100 img{width:100% !important; height:auto !important; max-width:100% !important; min-width:100px !important;}
        /* halper */
        .space-w-20{width:100%!important; max-width:100%!important; min-width:100% !important;}
        .space-w-20 td:first-child{width:100%!important; max-width:100%!important; min-width:100% !important;}
        .space-w-25{width:100%!important; max-width:100%!important; min-width:100% !important;}
        .space-w-25 td:first-child{width:100%!important; max-width:100%!important; min-width:100% !important;}
        .space-w-30{width:100%!important; max-width:100%!important; min-width:100% !important;}
        .space-w-30 td:first-child{width:100%!important; max-width:100%!important; min-width:100% !important;}
        .remove-479{display:none !important;}
        img{max-width:280px !important;}
        .resize-font, .resize-font *{font-size: 37px !important; line-height: 48px !important;}
    }
    /* End Old CSS */

    @media only screen and (max-width:640px){
        .full-width,.container{width:95%!important; float:none!important; min-width:95%!important; max-width:95%!important; margin:0 auto!important; padding-left:15px; padding-right:15px; text-align: center!important; clear: both;}
        #mainStructure, #mainStructure .full-width .full-width,table .full-width .full-width, .container .full-width{width:100%!important; float:none!important; min-width:100%!important; max-width:100%!important; margin:0 auto!important; clear: both; padding-left:0; padding-right:0;}
        .no-pad{padding:0!important;}
        .full-block{display:block!important;}
        .image-full-width,
        .image-full-width img{width:100%!important; height:auto!important; max-width:100%!important; min-width: 100px !important;}
        .full-width.fix-800{min-width:auto!important;}
        .remove-block{display:none !important; padding-top:0px; padding-bottom:0px;}
        .pad-lr-20{padding-left:20px!important; padding-right:20px!important;}
        .row{display:table-row!important;}
    }

    @media only screen and (max-width:480px){
        .full-width,.container{width:95%!important; float:none!important; min-width:95%!important; max-width:95%!important; margin:0 auto!important; padding-left:15px; padding-right:15px; text-align: center!important; clear: both;}
        #mainStructure, #mainStructure .full-width .full-width,table .full-width .full-width,.container .full-width{width:100%!important; float:none!important; min-width:100%!important; max-width:100%!important; margin:0 auto!important; clear: both; padding-left:0; padding-right:0;}
        .no-pad{padding:0!important;}
        .full-block{display:block!important;}
        .image-full-width,
        .image-full-width img{width:100%!important; height:auto!important; max-width:100%!important; min-width: 100px !important;}
        .full-width.fix-800{min-width:auto!important;}
        .remove-block{display:none !important; padding-top:0px; padding-bottom:0px;}
        .pad-lr-20{padding-left:20px!important; padding-right:20px!important;}
        .row{display:table-row!important;}
    }

    td ul{list-style: initial; margin:0; padding-left:20px;}

    body{background-color:#ffffff; margin: 0 auto !important; height:auto!important;} #preview-template #mainStructure{padding:20px 0px 60px 0px!important;} .default-edit-image{height:20px;} tr.tpl-repeatblock , tr.tpl-repeatblock > td{ display:block !important;} .tpl-repeatblock {padding: 0px !important;border: 1px dotted rgba(0,0,0,0.2); }

    @media only screen and (max-width: 640px){ .full-block{display:table !important; padding-top:0px; padding-bottom:0px;} .row{display:table-row!important;} .image-100-percent img{ width:100%!important; height: auto !important; max-width: 100% !important; min-width: 124px !important;}}

    @media only screen and (max-width: 480px){ .full-block{display:table !important; padding-top:0px; padding-bottom:0px;} .row{display:table-row!important;}}


    *[x-apple-data-detectors], .unstyle-auto-detected-links *,

    .aBn{border-bottom: 0 !important; cursor: default !important;color: inherit !important; text-decoration: none !important;font-size: inherit !important; font-family: inherit !important; font-weight: inherit !important;line-height: inherit !important;}

    .im {color: inherit !important;}

    .a6S {display: none !important; opacity: 0.01 !important;}

    img.g-img + div {display: none !important;}

    img {height: auto !important; line-height: 100%; outline: none; text-decoration: none !important; -ms-interpolation-mode:bicubic;}

    a img{ border: 0 !important;}

    a:active{color:initial } a:visited{color:initial }

    span a ,a {color:inherit; text-decoration: none !important;}

    .tpl-content{padding:0 !important;}

    table td {border-collapse:unset;}

    table p {margin:0;}

    #mainStructure table,#mainStructure img{min-width:0!important;}

    #mainStructure{padding:0 !important;}

    .row th{display:table-cell;}

    .row{display:flex;}

</style>
<body  style="font-size:12px; width:100%; height:100%;">
    <table id="mainStructure" class="full-width" width="800" align="center" border="0" cellspacing="0" cellpadding="0" style="background-color: #ffffff; max-width: 800px; outline: rgb(239, 239, 239) solid 1px; box-shadow: rgb(224, 224, 224) 0px 0px 30px 5px; margin: 0px auto;" bgcolor="#ffffff">
        <!--START LAYOUT-1 ( LOGO / MENU )-->
        <tr>
            <td align="center" valign="top" class="full-width" style="background-color: #ffffff;" bgcolor="#ffffff">
                <!-- start container -->
                <table width="600" align="center" border="0" cellspacing="0" cellpadding="0" class="full-width" style="background-color: #ffffff; margin: 0px auto; width: 600px; min-width: 320px; max-width: 90%;" role="presentation" bgcolor="#ffffff">
                    <tr>
                        <td valign="top">
                            <table width="560" border="0" cellspacing="0" cellpadding="0" align="center" class="full-width" style="margin: 0px auto; width: 560px; min-width: 280px; max-width: 90%;" role="presentation">
                                <!-- start space -->
                                <tr>
                                    <td valign="top" height="30" style="height: 30px; font-size: 0px; line-height: 0;" aria-hidden="true">&nbsp;</td>
                                </tr><!-- end space -->
                                <tr>
                                    <td valign="top">
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" style="margin: 0px auto; min-width: 100%;" role="presentation">
                                            <tr class="row" style="display: flex; text-align: center;">
                                                <th valign="middle" class="full-block" style="display: inline !important;">
                                                    <table width="auto" align="left" border="0" cellspacing="0" cellpadding="0" class="full-width left" role="presentation" style="min-width: 100%;">
                                                        <tr>
                                                            <td align="center" valign="top" style="padding-bottom: 5px; padding-top: 5px; width: 136px; line-height: 0px;" width="136"> <a href="#" style="text-decoration: none !important; font-size: inherit; border-style: none;" border="0"> <img src="https://mailbuild.rookiewebstudio.com/customers/v3iyZTIS/user_upload/20190824050732_logo-vitalea.png" width="136" style="max-width: 240px; display: block !important; width: 136px; height: auto;" alt="logo-top" border="0" hspace="0" vspace="0" height="auto"></a> </td>
                                                        </tr>
                                                    </table>
                                                </th>
                                                <th valign="middle" class="full-block" style="display: inline !important; margin: auto;">
                                                    <table width="25" border="0" cellpadding="0" cellspacing="0" align="left" class="full-width left" style="max-width: 25px; border-spacing: 0px; min-width: 100%;" role="presentation">
                                                        <tr>
                                                            <td height="20" width="25" style="border-collapse: collapse; height: 20px; font-size: 0px; line-height: 0;" aria-hidden="true">&nbsp;</td>
                                                        </tr>
                                                    </table>
                                                </th>
                                                <th valign="middle" class="full-block" style="display: inline !important;">
                                                    <table width="auto" align="right" border="0" cellpadding="0" cellspacing="0" class="full-width right" role="presentation" style="min-width: 100%;">
                                                        <tr>
                                                            <td valign="top" align="center">
                                                                <table width="auto" align="center" border="0" cellpadding="0" cellspacing="0" style="margin: 0px auto;mso-table-lspace:0pt; mso-table-rspace:0pt;" role="presentation">
                                                                    <tr class="row" style="display: flex; text-align: center;">
                                                                        <th valign="top" align="center" class="full-block" style="margin: 0px auto; display: inline !important;">
                                                                            <table width="auto" align="center" border="0" cellpadding="0" cellspacing="0" style="margin: 0px auto; min-width: 100%;" class="full-width" role="presentation">
                                                                                <tr>
                                                                                    <td style="padding: 5px 10px;">
                                                                                        <table width="100%" border="0" cellpadding="0" cellspacing="0" style="margin: 0px auto; min-width: 100%;" align="center" role="presentation">
                                                                                            <tr>
                                                                                                <td align="left" valign="middle" width="auto">
                                                                                                    <table width="auto" align="left" border="0" cellpadding="0" cellspacing="0" style="vertical-align:middle;mso-table-lspace:0pt; mso-table-rspace:0pt;" role="presentation">
                                                                                                        <tr>
                                                                                                            <td align="left" valign="top" style="padding-right: 10px; width: 16px; line-height: 0px;" width="16"> <img src="https://mailbuild.rookiewebstudio.com/customers/v3iyZTIS/user_upload/20191030002428_whatsapp-button.png" width="16" style="max-width: 16px; display: block !important; width: 16px; height: auto;" vspace="0" hspace="0" alt="icon-phone" height="auto"></td>
                                                                                                        </tr>
                                                                                                    </table>
                                                                                                </td>
                                                                                                <td align="left" style="font-size: 14px; color: #333333; font-weight: normal; font-family: 'Open Sans', Arial, Helvetica, sans-serif; word-break: break-word; line-height: 1;"><span style="color: #333333; font-style: normal; text-align: left; line-height: 24px; font-size: 14px; font-weight: 400; font-family: Montserrat, arial, sans-serif;"><a href="https://api.whatsapp.com/send?phone=573187120062" data-mce-href="https://api.whatsapp.com/send?phone=573187120062" target="_blank" style="border-style: none; text-decoration: none !important; line-height: 24px; font-size: 14px; font-weight: 400; font-family: Montserrat, arial, sans-serif;" border="0"><span style="color: #333333; font-style: normal; text-align: left; line-height: 24px; font-size: 14px; font-weight: 400; font-family: Montserrat, arial, sans-serif;"><span style="font-style: normal; text-align: left; color: #333333; line-height: 24px; font-size: 14px; font-weight: 400; font-family: Montserrat, arial, sans-serif;">WhatsApp</span></span></a></span></td>
                                                                                            </tr>
                                                                                        </table>
                                                                                    </td>
                                                                                </tr>
                                                                            </table>
                                                                        </th>
                                                                        <th valign="top" align="center" class="full-block" style="margin: 0px auto; display: inline !important;">
                                                                            <table width="auto" align="center" border="0" cellpadding="0" cellspacing="0" style="margin: 0px auto; min-width: 100%;" class="full-width" role="presentation">
                                                                                <tr>
                                                                                    <td style="padding: 5px 10px;">
                                                                                        <table width="100%" border="0" cellpadding="0" cellspacing="0" style="margin: 0px auto; min-width: 100%;" align="center" role="presentation">
                                                                                            <tr>
                                                                                                <td align="left" valign="middle" width="auto">
                                                                                                    <table width="auto" align="left" border="0" cellpadding="0" cellspacing="0" style="vertical-align:middle;mso-table-lspace:0pt; mso-table-rspace:0pt;" role="presentation">
                                                                                                        <tr>
                                                                                                            <td align="left" valign="top" style="padding-right: 10px; width: 16px; line-height: 0px;" width="16"> <img src="https://mailbuild.rookiewebstudio.com/customers/v3iyZTIS/user_upload/20190916210242_ico_cell.png" width="16" style="max-width: 16px; display: block !important; width: 16px; height: auto;" vspace="0" hspace="0" alt="icon-phone" height="auto"></td>
                                                                                                        </tr>
                                                                                                    </table>
                                                                                                </td>
                                                                                                <td align="left" style="font-size: 14px; color: #333333; font-weight: normal; font-family: 'Open Sans', Arial, Helvetica, sans-serif; word-break: break-word; line-height: 1;"><a href="tel://+5718051348" data-mce-href="tel://+5718051348" title="Teléfono Vitalea" style="border-style: none; text-decoration: none !important; line-height: 24px; font-size: 14px; font-weight: 400; font-family: 'Open Sans', Arial, Helvetica, sans-serif;" border="0"><span style="color: #333333; font-style: normal; text-align: left; line-height: 24px; font-size: 14px; font-weight: 400; font-family: Montserrat, arial, sans-serif;"><span style="font-style: normal; text-align: left; color: #333333; line-height: 24px; font-size: 14px; font-weight: 400; font-family: Montserrat, arial, sans-serif;">8051348</span></span></a></td>
                                                                                            </tr>
                                                                                        </table>
                                                                                    </td>
                                                                                </tr>
                                                                            </table>
                                                                        </th>
                                                                        <th valign="top" align="center" class="full-block" style="margin: 0px auto; display: inline !important;">
                                                                            <table width="auto" align="center" border="0" cellpadding="0" cellspacing="0" style="margin: 0px auto; min-width: 100%;" class="full-width" role="presentation">
                                                                                <tr>
                                                                                    <td style="padding: 5px 10px;">
                                                                                        <table width="100%" border="0" cellpadding="0" cellspacing="0" style="margin: 0px auto; min-width: 100%;" align="center" role="presentation">
                                                                                            <tr>
                                                                                                <td align="left" valign="middle" width="auto">
                                                                                                    <table width="auto" align="left" border="0" cellpadding="0" cellspacing="0" style="vertical-align:middle;mso-table-lspace:0pt; mso-table-rspace:0pt;" role="presentation">
                                                                                                        <tr>
                                                                                                            <td align="left" valign="top" style="padding-right: 10px; width: 15px; line-height: 0px;" width="15"> <img src="https://mailbuild.rookiewebstudio.com/customers/v3iyZTIS/user_upload/20190916210242_ico_web.png" width="15" style="max-width: 15px; display: block !important; width: 15px; height: auto;" vspace="0" hspace="0" alt="icon-world" height="auto"></td>
                                                                                                        </tr>
                                                                                                    </table>
                                                                                                </td>
                                                                                                <td align="left" style="font-size: 14px; color: #333333; font-weight: normal; font-family: 'Open Sans', Arial, Helvetica, sans-serif; word-break: break-word; line-height: 1;"><span style="color: #333333; font-style: normal; text-align: left; line-height: 24px; font-size: 14px; font-weight: 400; font-family: Montserrat, arial, sans-serif;"><a data-mce-href="https://www.vitalea.co/" href="https://www.vitalea.co/" title="Sitio web Vitalea" style="border-style: none; text-decoration: none !important; line-height: 24px; font-size: 14px; font-weight: 400; font-family: Montserrat, arial, sans-serif;" target="_blank" border="0"><span style="color: #333333; font-style: normal; text-align: left; line-height: 24px; font-size: 14px; font-weight: 400; font-family: Montserrat, arial, sans-serif;">www.vitalea.co</span></a></span></td>
                                                                                            </tr>
                                                                                        </table>
                                                                                    </td>
                                                                                </tr>
                                                                            </table>
                                                                        </th>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </th>
                                            </tr>
                                        </table>
                                    </td>
                                </tr><!-- start space -->
                                <tr>
                                    <td valign="top" height="30" style="height: 30px; font-size: 0px; line-height: 0;" aria-hidden="true">&nbsp;</td>
                                </tr><!-- end space -->
                            </table>
                        </td>
                    </tr>
                </table><!-- end container -->
            </td>
        </tr>
        <!--END LAYOUT-1 ( LOGO / MENU )-->
        <!-- START LAYOUT-8 ( 2-COL CONTENT / LIST / BUTTON ) -->
        <tr>
            <td align="center" valign="top" style="background-color: #fff;" bgcolor="#ffffff">
                <!-- start container -->
                <table width="600" align="center" border="0" cellspacing="0" cellpadding="0" class="full-width" style="background-color: #ffffff; margin: 0px auto; width: 600px; min-width: 320px; max-width: 90%;" role="presentation" bgcolor="#ffffff">
                    <tr>
                        <td valign="top" align="center">
                            <table width="560" align="center" border="0" cellspacing="0" cellpadding="0" class="full-width" style="margin: 0px auto; width: 560px; min-width: 280px; max-width: 90%;" role="presentation">
                                <!-- start space -->
                                <tr>
                                    <td valign="top" height="23" style="height: 23px; font-size: 0px; line-height: 0;" aria-hidden="true">&nbsp;</td>
                                </tr><!-- end space -->
                                <tr>
                                    <td valign="top" align="center">
                                        <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0" style="margin: 0px auto; min-width: 100%;" role="presentation">
                                            <tr class="row" style="display: flex; text-align: center;">
                                                <th valign="top" class="full-block" style="display: inline !important; margin: 0px auto;">
                                                    <table width="265" align="left" border="0" cellspacing="0" cellpadding="0" class="full-width left" style="max-width: 265px; min-width: 100%;" role="presentation">
                                                        <tr>
                                                            <td valign="top">
                                                                <table width="100%" align="center" border="0" cellspacing="0" cellpadding="0" style="margin: 0px auto; min-width: 100%;" role="presentation">
                                                                    <!-- start title -->
                                                                    <!-- end title -->
                                                                    <!-- start content -->
                                                                    <tr>
                                                                        <td valign="top">
                                                                            <table width="100%" align="center" border="0" cellspacing="0" cellpadding="0" style="margin: 0px auto; min-width: 100%;" role="presentation">
                                                                                <tr>
                                                                                    <td align="left" style="font-size: 14px; color: #888888; font-weight: normal; font-family: 'Open Sans', Arial, Helvetica, sans-serif; word-break: break-word; line-height: 1;"><span style="font-style: normal; text-align: left; color: #888888; line-height: 24px; font-size: 14px; font-weight: 400; font-family: Montserrat, arial, sans-serif;"><span style="font-style: normal; text-align: left; color: #888888; line-height: 24px; font-size: 14px; font-weight: 400; font-family: Montserrat, arial, sans-serif;">Crr. 15 # 81- 30 <br></span></span></td>
                                                                                </tr><!-- start space -->
                                                                                <tr>
                                                                                    <td valign="top" height="1" style="height: 1px; font-size: 0px; line-height: 0;" aria-hidden="true">&nbsp;</td>
                                                                                </tr><!-- end space -->
                                                                            </table>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td valign="top">
                                                                            <table width="100%" align="center" border="0" cellspacing="0" cellpadding="0" style="margin: 0px auto; min-width: 100%;" role="presentation">
                                                                                <tr>
                                                                                    <td align="left" style="font-size: 14px; color: #888888; font-weight: normal; font-family: 'Open Sans', Arial, Helvetica, sans-serif; word-break: break-word; line-height: 1;"><span style="color: #888888; font-style: normal; text-align: left; line-height: 24px; font-size: 14px; font-weight: 400; font-family: Montserrat, arial, sans-serif;"><span style="font-style: normal; text-align: left; color: #888888; line-height: 24px; font-size: 14px; font-weight: 400; font-family: Montserrat, arial, sans-serif;">Tel: 805 13 48 <br></span></span></td>
                                                                                </tr><!-- start space -->
                                                                                <tr>
                                                                                    <td valign="top" height="1" style="height: 1px; font-size: 0px; line-height: 0;" aria-hidden="true">&nbsp;</td>
                                                                                </tr><!-- end space -->
                                                                            </table>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td valign="top">
                                                                            <table width="100%" align="center" border="0" cellspacing="0" cellpadding="0" style="margin: 0px auto; min-width: 100%;" role="presentation">
                                                                                <tr>
                                                                                    <td align="left" style="font-size: 14px; color: #888888; font-weight: normal; font-family: 'Open Sans', Arial, Helvetica, sans-serif; word-break: break-word; line-height: 1;"><span style="color: #888888; font-style: normal; text-align: left; line-height: 24px; font-size: 14px; font-weight: 400; font-family: Montserrat, arial, sans-serif;"><span style="font-style: normal; text-align: left; color: #888888; line-height: 24px; font-size: 14px; font-weight: 400; font-family: Montserrat, arial, sans-serif;">hola@vitalea.com.co</span></span></td>
                                                                                </tr><!-- start space -->
                                                                                <tr>
                                                                                    <td valign="top" height="1" style="height: 1px; font-size: 0px; line-height: 0;" aria-hidden="true">&nbsp;</td>
                                                                                </tr><!-- end space -->
                                                                            </table>
                                                                        </td>
                                                                    </tr><!-- start content -->
                                                                    <!-- start group list -->
                                                                    <tr>
                                                                        <td valign="top" align="center">
                                                                            <table width="100%" align="left" border="0" cellpadding="0" cellspacing="0" role="presentation" style="min-width: 100%;">
                                                                                <!-- start check list -->
                                                                                <!-- end check list -->
                                                                                <!-- start check list -->
                                                                                <!-- end check list -->
                                                                                <!-- start check list -->
                                                                                <!-- end check list -->
                                                                                <!-- start space -->
                                                                                <tr>
                                                                                    <td valign="top" height="15" style="height: 15px; font-size: 0px; line-height: 0;" aria-hidden="true">&nbsp;</td>
                                                                                </tr><!-- end space -->
                                                                            </table>
                                                                        </td>
                                                                    </tr><!-- end group list -->
                                                                    <!--start button-->
                                                                    <!--end button-->
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </th>
                                                <th valign="top" class="full-block" style="display: inline !important; margin: 0px auto;">
                                                    <table width="30" border="0" cellpadding="0" cellspacing="0" align="left" class="full-width left" style="max-width: 30px; border-spacing: 0px; min-width: 100%;" role="presentation">
                                                        <tr>
                                                            <td height="30" width="30" style="border-collapse: collapse; height: 30px; font-size: 0px; line-height: 0;" aria-hidden="true">&nbsp;</td>
                                                        </tr>
                                                    </table>
                                                </th>
                                                <th valign="top" class="full-block" style="display: inline !important; margin: 0px auto;">
                                                    <table width="265" align="right" border="0" cellspacing="0" cellpadding="0" class="full-width right" style="max-width: 265px; min-width: 100%;" role="presentation">
                                                        <tr>
                                                            <td valign="top">
                                                                <table width="100%" align="center" border="0" cellspacing="0" cellpadding="0" style="margin: 0px auto; min-width: 100%;" role="presentation">
                                                                    <!-- start title -->
                                                                    <!-- end title -->
                                                                    <!-- start content -->
                                                                    <tr>
                                                                        <td valign="top">
                                                                            <table width="100%" align="center" border="0" cellspacing="0" cellpadding="0" style="margin: 0px auto; min-width: 100%;" role="presentation">
                                                                                <tr>
                                                                                    <td align="left" style="font-size: 14px; color: #888888; font-weight: normal; font-family: 'Open Sans', Arial, Helvetica, sans-serif; word-break: break-word; line-height: 1;">
                                                                                        <div style="text-align: right; font-size: 14px; font-weight: 400; font-family: 'Open Sans', Arial, Helvetica, sans-serif;"><span style="color: #888888; font-style: normal; text-align: left; line-height: 24px; font-size: 14px; font-weight: 400; font-family: Montserrat, arial, sans-serif;"><span style="font-style: normal; text-align: left; color: #888888; line-height: 24px; font-size: 14px; font-weight: 400; font-family: Montserrat, arial, sans-serif;">Fecha: $fecha</span></span></div>
                                                                                    </td>
                                                                                </tr><!-- start space -->
                                                                                <tr>
                                                                                    <td valign="top" height="1" style="height: 1px; font-size: 0px; line-height: 0;" aria-hidden="true">&nbsp;</td>
                                                                                </tr><!-- end space -->
                                                                            </table>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td valign="top">
                                                                            <table width="100%" align="center" border="0" cellspacing="0" cellpadding="0" style="margin: 0px auto; min-width: 100%;" role="presentation">
                                                                                <tr>
                                                                                    <td align="left" style="font-size: 14px; color: #888888; font-weight: normal; font-family: 'Open Sans', Arial, Helvetica, sans-serif; word-break: break-word; line-height: 1;">
                                                                                        <div style="text-align: right; font-size: 14px; font-weight: 400; font-family: 'Open Sans', Arial, Helvetica, sans-serif;"><span style="color: #888888; font-style: normal; text-align: left; line-height: 24px; font-size: 14px; font-weight: 400; font-family: Montserrat, arial, sans-serif;"><span style="font-style: normal; text-align: left; color: #888888; line-height: 24px; font-size: 14px; font-weight: 400; font-family: Montserrat, arial, sans-serif;">Cotización No:&nbsp;$id_cot</span></span></div><br>
                                                                                    </td>
                                                                                </tr><!-- start space -->
                                                                                <tr>
                                                                                    <td valign="top" height="1" style="height: 1px; font-size: 0px; line-height: 0;" aria-hidden="true">&nbsp;</td>
                                                                                </tr><!-- end space -->
                                                                            </table>
                                                                        </td>
                                                                    </tr><!-- start content -->
                                                                    <!-- start group list -->
                                                                    <tr>
                                                                        <td valign="top" align="center">
                                                                            <table width="100%" align="left" border="0" cellpadding="0" cellspacing="0" role="presentation" style="min-width: 100%;">
                                                                                <!-- start check list -->
                                                                                <!-- end check list -->
                                                                                <!-- start check list -->
                                                                                <!-- end check list -->
                                                                                <!-- start check list -->
                                                                                <!-- end check list -->
                                                                                <!-- start space -->
                                                                                <tr>
                                                                                    <td valign="top" height="15" style="height: 15px; font-size: 0px; line-height: 0;" aria-hidden="true">&nbsp;</td>
                                                                                </tr><!-- end space -->
                                                                            </table>
                                                                        </td>
                                                                    </tr><!-- end group list -->
                                                                    <!--start button-->
                                                                    <!--end button-->
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </th>
                                            </tr>
                                        </table>
                                    </td>
                                </tr><!-- start space -->
                                <tr>
                                    <td valign="top" height="5" style="height: 5px; font-size: 0px; line-height: 0;" aria-hidden="true">&nbsp;</td>
                                </tr><!-- end space -->
                            </table>
                        </td>
                    </tr>
                </table><!-- end container -->
            </td>
        </tr>
        <!--END LAYOUT-8 ( 2-COL CONTENT / LIST / BUTTON ) -->
        <!--START LAYOUT-11 ( 2-COL TABLE PRICE ) -->
        <tr>
            <td align="center" valign="top" style="background-color: #ffffff;" bgcolor="#ffffff">
                <!-- start container -->
                <table width="600" align="center" border="0" cellspacing="0" cellpadding="0" class="full-width" style="background-color: #ffffff; margin: 0px auto; width: 600px; min-width: 320px; max-width: 90%;" role="presentation" bgcolor="#ffffff">
                    <tr>
                        <td valign="top" align="center">
                            <!-- start col left -->
                            <table width="560" align="center" border="0" cellpadding="0" cellspacing="0" class="full-width" style="margin: 0px auto; width: 560px; min-width: 280px; max-width: 90%;" role="presentation">
                                <!-- start space -->
                                <tr>
                                    <td valign="top" height="10" style="height: 10px; font-size: 0px; line-height: 0;" aria-hidden="true">&nbsp;</td>
                                </tr><!-- end space -->
                                <!-- start group heading -->
                                <tr>
                                    <td valign="top">
                                        <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0" style="margin: 0px auto; min-width: 100%;" role="presentation">
                                            <!-- start title -->
                                            <!-- end title -->
                                            <!-- start content -->
                                            <tr>
                                                <td valign="top">
                                                    <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0" style="margin: 0px auto; min-width: 100%;" role="presentation">
                                                        <tr>
                                                            <td align="center" style="font-size: 14px; color: #888888; font-weight: 300; font-family: 'Open Sans', Arial, Helvetica, sans-serif; word-break: break-word; line-height: 1;"><span style="color: #888888; font-style: normal; text-align: center; line-height: 24px; font-size: 14px; font-weight: 300; font-family: Montserrat, arial, sans-serif;">En Vitălea puedes monitorear tu estado general de salud, sin órdenes ni autorizaciones, de manera rápida, confiable y en el momento que tú lo decidas.<br><br><span style="color: #888888; font-style: normal; text-align: center; line-height: 24px; font-size: 14px; font-weight: 400; font-family: Montserrat, arial, sans-serif;"><span style="font-style: normal; text-align: center; color: #888888; line-height: 24px; font-size: 14px; font-weight: 400; font-family: Montserrat, arial, sans-serif;">Somos una guía para que junto con tu médico realicen el correcto seguimiento de tu salud.</span></span></span></td>
                                                        </tr><!-- start space -->
                                                        <tr>
                                                            <td valign="top" height="28" style="height: 28px; font-size: 0px; line-height: 0;" aria-hidden="true">&nbsp;</td>
                                                        </tr><!-- end space -->
                                                    </table>
                                                </td>
                                            </tr><!-- end content -->
                                        </table>
                                    </td>
                                </tr><!-- end group heading -->
                                <!-- start group 2-col -->
                                <tr>
                                    <td valign="top">
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" style="margin: 0px auto; min-width: 100%;" role="presentation">
                                            <tr class="row" style="display: flex; text-align: center;">
                                                <th valign="top" class="full-block" style="display: inline !important; margin: 0px auto;">
                                                    <table width="263" align="left" border="0" cellpadding="0" cellspacing="0" style="max-width: 263px; background-color: #fff; min-width: 100%;" class="full-width left" role="presentation" bgcolor="#000000">
                                                        <tr>
                                                            <td valign="top" align="left" style="border: 0px; border-radius: 10px; background-color: #eb1f81;" bgcolor="#eb1f81">
                                                                <table width="100%" align="left" border="0" cellpadding="0" cellspacing="0" role="presentation" style="min-width: 100%;">
                                                                    <!-- start icon + title -->
                                                                    <tr>
                                                                        <td valign="top" align="left">
                                                                            <table width="100%" align="left" border="0" cellpadding="0" cellspacing="0" style="border-bottom: 0px ; min-width: 100%;" role="presentation">
                                                                                <!-- start space -->
                                                                                <tr>
                                                                                    <td valign="top" height="1" style="height: 1px; font-size: 0px; line-height: 0;" aria-hidden="true">&nbsp;</td>
                                                                                </tr><!-- end space -->
                                                                                <tr>
                                                                                    <td valign="top" style="padding-left:15px; padding-right:15px;">
                                                                                        <table width="auto" align="left" border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace:0pt; mso-table-rspace:0pt;">
                                                                                            <tr>
                                                                                                <td align="left" style="font-size: 16px; color: #fff; font-weight: normal; font-family: 'Open Sans', Arial, Helvetica, sans-serif; word-break: break-word; line-height: 1;"><span style="color: #333333; text-decoration: none; font-style: normal; text-align: left; line-height: 24px; font-size: 16px; font-weight: 700; font-family: 'Open Sans', Arial, Helvetica, sans-serif;"><span style="color: #ffffff; font-style: normal; text-align: left; line-height: 24px; font-size: 16px; font-weight: 400; font-family: Montserrat, arial, sans-serif;"><span style="font-style: normal; text-align: left; color: #ffffff; line-height: 24px; font-size: 16px; font-weight: 400; font-family: Montserrat, arial, sans-serif;">Cliente</span></span><br></span></td>
                                                                                            </tr>
                                                                                        </table>
                                                                                    </td>
                                                                                </tr><!-- start space -->
                                                                                <tr>
                                                                                    <td valign="top" height="2" style="height: 2px; font-size: 0px; line-height: 0;" aria-hidden="true">&nbsp;</td>
                                                                                </tr><!-- end space -->
                                                                            </table>
                                                                        </td>
                                                                    </tr><!-- end icon + title -->
                                                                    <!-- end group list -->
                                                                    <!-- end group list -->
                                                                    <!-- start content -->
                                                                    <tr>
                                                                        <td valign="top" align="left">
                                                                            <table width="100%" align="left" border="0" cellpadding="0" cellspacing="0" style="background-color: #ffffff; min-width: 100%;" role="presentation" bgcolor="#ffffff">
                                                                                <!-- start space -->
                                                                                <tr>
                                                                                    <td valign="top" height="15" style="height: 15px; font-size: 0px; line-height: 0;" aria-hidden="true">&nbsp;</td>
                                                                                </tr><!-- end space -->
                                                                                <tr>
                                                                                    <td valign="top" style="padding-left:15px; padding-right:15px;">
                                                                                        <table width="100%" align="left" border="0" cellpadding="0" cellspacing="0" role="presentation" style="min-width: 100%;">
                                                                                            <tr>
                                                                                                <td align="left" style="font-size: 14px; color: #888888; font-weight: 300; font-family: 'Open Sans', Arial, Helvetica, sans-serif; word-break: break-word; line-height: 1;"><span style="font-style: normal; text-align: left; color: #888888; line-height: 24px; font-size: 14px; font-weight: 300; font-family: Montserrat, arial, sans-serif;"><span style="font-style: normal; text-align: left; color: #888888; line-height: 24px; font-size: 14px; font-weight: 300; font-family: Montserrat, arial, sans-serif;">$nombre_cliente</span></span><br><span style="font-style: normal; text-align: left; color: #888888; line-height: 24px; font-size: 14px; font-weight: 300; font-family: Montserrat, arial, sans-serif;"><span style="font-style: normal; text-align: left; color: #888888; line-height: 24px; font-size: 14px; font-weight: 300; font-family: Montserrat, arial, sans-serif;">$telefono_cliente</span></span></td>
                                                                                            </tr>
                                                                                        </table>
                                                                                    </td>
                                                                                </tr><!-- start space -->
                                                                                <tr>
                                                                                    <td valign="top" height="15" style="height: 15px; font-size: 0px; line-height: 0;" aria-hidden="true">&nbsp;</td>
                                                                                </tr><!-- end space -->
                                                                            </table>
                                                                        </td>
                                                                    </tr><!-- end content -->
                                                                    <!-- start price -->
                                                                    <!-- end price -->
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </th>
                                                <th valign="top" class="full-block" style="display: inline !important; margin: auto;">
                                                    <table width="30" border="0" cellpadding="0" cellspacing="0" align="left" class="full-width left" style="max-width: 30px; border-spacing: 0px; min-width: 100%;" role="presentation">
                                                        <tr>
                                                            <td height="30" width="30" style="border-collapse: collapse; height: 30px; font-size: 0px; line-height: 0;" aria-hidden="true">&nbsp;</td>
                                                        </tr>
                                                    </table>
                                                </th>
                                                <th valign="top" class="full-block" style="display: inline !important; margin: 0px auto;">
                                                    <table width="263" align="right" border="0" cellpadding="0" cellspacing="0" style="max-width: 263px; background-color: #fff; min-width: 100%;" class="full-width right" role="presentation" bgcolor="#fff">
                                                        <tr>
                                                            <td valign="top" align="left" style="border: 0px; border-radius: 10px; background-color: #7bbadb;" bgcolor="#7bbadb">
                                                                <table width="100%" align="left" border="0" cellpadding="0" cellspacing="0" role="presentation" style="min-width: 100%;">
                                                                    <!-- start icon + title -->
                                                                    <tr>
                                                                        <td valign="top" align="left">
                                                                            <table width="100%" align="left" border="0" cellpadding="0" cellspacing="0" style="min-width: 100%;" role="presentation">
                                                                                <!-- start space -->
                                                                                <tr>
                                                                                    <td valign="top" height="1" style="height: 1px; font-size: 0px; line-height: 0;" aria-hidden="true">&nbsp;</td>
                                                                                </tr><!-- end space -->
                                                                                <tr>
                                                                                    <td valign="top" style="padding-left:15px; padding-right:15px;">
                                                                                        <table width="auto" align="left" border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace:0pt; mso-table-rspace:0pt;">
                                                                                            <tr>
                                                                                                <td align="left" style="font-size: 16px; color: #333333; font-weight: normal; font-family: 'Open Sans', Arial, Helvetica, sans-serif; word-break: break-word; line-height: 1;"><span style="color: #ffffff; font-style: normal; text-align: left; line-height: 24px; font-size: 16px; font-weight: 400; font-family: Montserrat, arial, sans-serif;"><span style="font-style: normal; text-align: left; color: #ffffff; line-height: 24px; font-size: 16px; font-weight: 400; font-family: Montserrat, arial, sans-serif;">Asesor</span></span><br></td>
                                                                                            </tr>
                                                                                        </table>
                                                                                    </td>
                                                                                </tr><!-- start space -->
                                                                                <tr>
                                                                                    <td valign="top" height="1" style="height: 1px; font-size: 0px; line-height: 0;" aria-hidden="true">&nbsp;</td>
                                                                                </tr><!-- end space -->
                                                                            </table>
                                                                        </td>
                                                                    </tr><!-- end icon + title -->
                                                                    <!-- end group list -->
                                                                    <!-- end group list -->
                                                                    <!-- start content -->
                                                                    <tr>
                                                                        <td valign="top" align="left">
                                                                            <table width="100%" align="left" border="0" cellpadding="0" cellspacing="0" style="border-bottom: 0px; background-color: #fff; min-width: 100%;" role="presentation" bgcolor="#ffffff">
                                                                                <!-- start space -->
                                                                                <tr>
                                                                                    <td valign="top" height="15" style="height: 15px; font-size: 0px; line-height: 0;" aria-hidden="true">&nbsp;</td>
                                                                                </tr><!-- end space -->
                                                                                <tr>
                                                                                    <td valign="top" style="padding-left:15px; padding-right:15px;">
                                                                                        <table width="100%" align="left" border="0" cellpadding="0" cellspacing="0" role="presentation" style="min-width: 100%;">
                                                                                            <tr>
                                                                                                <td align="left" style="font-size: 14px; color: #888888; font-weight: 300; font-family: 'Open Sans', Arial, Helvetica, sans-serif; word-break: break-word; line-height: 1;"><span style="font-style: normal; text-align: left; color: #888888; line-height: 24px; font-size: 14px; font-weight: 300; font-family: Montserrat, arial, sans-serif;"><span style="font-style: normal; text-align: left; color: #888888; line-height: 24px; font-size: 14px; font-weight: 300; font-family: Montserrat, arial, sans-serif;">$nombre_asesor</span></span><br></td>
                                                                                            </tr>
                                                                                        </table>
                                                                                    </td>
                                                                                </tr><!-- start space -->
                                                                                <tr>
                                                                                    <td valign="top" height="15" style="height: 15px; font-size: 0px; line-height: 0;" aria-hidden="true">&nbsp;</td>
                                                                                </tr><!-- end space -->
                                                                            </table>
                                                                        </td>
                                                                    </tr><!-- end content -->
                                                                    <!-- start price -->
                                                                    <!-- end price -->
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </th>
                                            </tr><!-- start space -->
                                            <tr>
                                                <td valign="top" height="14" style="height: 14px; font-size: 0px; line-height: 0;" aria-hidden="true">&nbsp;</td>
                                            </tr><!-- end space -->
                                        </table>
                                    </td>
                                </tr><!-- end group 2-col -->
                            </table>
                        </td>
                    </tr>
                </table><!-- end container -->
            </td>
        </tr>

        <tr>
            <td valign="top" align="center" style="background-color: #fff;" bgcolor="#ffffff">
                <table width="600" align="center" border="0" cellspacing="0" cellpadding="0" class="full-width" style="background-color: #ffffff; margin: 0px auto; width: 600px; min-width: 320px; max-width: 90%;" role="presentation" bgcolor="#ffffff">
                    <tr>
                        <td valign="top" align="center">
                            <table width="560" align="center" border="0" cellspacing="0" cellpadding="0" class="full-width" style="margin: 0px auto; width: 560px; min-width: 280px; max-width: 90%;" role="presentation">
                                <!-- inicia productos -->
                                $html_items
                                <!-- finaliza productos -->

                                <tr>
                                    <td valign="top">
                                        <table width="100%" align="center" border="0" cellspacing="0" cellpadding="0" style="background-color: #ffffff; border-bottom: 2px solid rgb(232, 232, 232); margin: 0px auto; min-width: 100%;" role="presentation" bgcolor="#ffffff">
                                            <tr>
                                                <td valign="top" style="padding-left: 20px; padding-right: 20px;">
                                                    <table width="100%" align="center" border="0" cellspacing="0" cellpadding="0" style="background-color: #ffffff; margin: 0px auto; min-width: 100%;" role="presentation" bgcolor="#ffffff">
                                                        <!-- start space -->
                                                        <tr>
                                                            <td valign="top" height="20" style="height: 20px; font-size: 0px; line-height: 0;" aria-hidden="true">&nbsp;</td>
                                                        </tr><!-- end space -->
                                                        <tr>
                                                            <td valign="top" height="25" width="100" style="font-size: 18px; color: #333333; font-weight: bold; font-family: 'Open Sans', Arial, Helvetica, sans-serif; word-break: break-word; line-height: 1;" align="left"><span style="color: #333333; font-style: normal; text-align: left; line-height: 24px; font-size: 18px; font-weight: 700; font-family: 'Open Sans', Arial, Helvetica, sans-serif;"><span style="color: #333333; font-style: normal; text-align: left; line-height: 24px; font-size: 18px; font-weight: 700; font-family: Montserrat, arial, sans-serif;"><span style="font-style: normal; text-align: left; color: #333333; line-height: 24px; font-size: 18px; font-weight: 700; font-family: Montserrat, arial, sans-serif;"> Total</span></span> </span></td>
                                                            <td valign="top">
                                                                <table width="100%" align="center" border="0" cellspacing="0" cellpadding="0" style="height: 100%; margin: 0px auto; min-width: 100%;" role="presentation">
                                                                    <tr>
                                                                        <td valign="top" style="font-size: 14px; color: #009f64; font-weight: bold; font-family: 'Open Sans', Arial, Helvetica, sans-serif; word-break: break-word; line-height: 1;" align="right"><span style="color: #eb1f81; font-style: normal; text-align: right; line-height: 24px; font-size: 14px; font-weight: 700; font-family: Montserrat, arial, sans-serif;"><span style="color: #eb1f81; font-style: normal; text-align: right; line-height: 24px; font-size: 14px; font-weight: 700; font-family: Montserrat, arial, sans-serif;"> $ $total</span> </span></td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr><!-- start space -->
                                                        <tr>
                                                            <td valign="top" height="20" style="height: 20px; font-size: 0px; line-height: 0;" aria-hidden="true">&nbsp;</td>
                                                        </tr><!-- end space -->
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr><!-- END LAYOUT-3 ( PRICE LIST ) -->
        <!--START LAYOUT-9 ( 2-COL RIGHT-CONTENT / LEFT-IMAGE )-->
        <tr>
            <td align="center" valign="top" style="background-color: #ffffff;" bgcolor="#ffffff">
                <!-- start container -->
                <table width="600" align="center" border="0" cellspacing="0" cellpadding="0" class="full-width" style="background-color: #ffffff; margin: 0px auto; width: 600px; min-width: 320px; max-width: 90%;" role="presentation" bgcolor="#ffffff">
                    <tr>
                        <td valign="top">
                            <table width="560" align="center" border="0" cellspacing="0" cellpadding="0" style="margin: 0px auto; width: 560px; min-width: 280px; max-width: 90%;" class="full-width" role="presentation">
                                <!-- start space -->
                                <tr>
                                    <td valign="top" height="50" style="height: 50px; font-size: 0px; line-height: 0;" aria-hidden="true">&nbsp;</td>
                                </tr><!-- end space -->
                                <!-- start image heading -->
                                <!-- end image heading -->
                                <!-- start content container1-->
                                <!-- end content container1-->
                                <!-- start content -->
                                <tr>
                                    <td valign="top" align="center">
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" style="margin: 0px auto; min-width: 100%;" role="presentation">
                                            <!-- start title -->
                                            <tr>
                                                <td valign="top" align="left">
                                                    <table width="100%" align="left" border="0" cellspacing="0" cellpadding="0" style="margin: 0px auto; min-width: 100%;" role="presentation">
                                                        <tr>
                                                            <td align="left" style="font-size: 24px; color: #333333; font-weight: normal; font-family: 'Open Sans', Arial, Helvetica, sans-serif; word-break: break-word; line-height: 1;"><span style="color: #333333; font-style: normal; text-align: left; line-height: 24px; font-size: 12px; font-weight: 400; font-family: Montserrat, arial, sans-serif;"><span style="font-style: normal; text-align: left; color: #333333; line-height: 24px; font-size: 12px; font-weight: 400; font-family: Montserrat, arial, sans-serif;">Términos y condiciones:</span></span><br></td>
                                                        </tr><!-- start space -->
                                                        <tr>
                                                            <td valign="top" height="15" style="height: 15px; font-size: 0px; line-height: 0;" aria-hidden="true">&nbsp;</td>
                                                        </tr><!-- end space -->
                                                    </table>
                                                </td>
                                            </tr><!-- end title -->
                                            <!-- start content -->
                                            <tr>
                                                <td valign="top">
                                                    <table width="100%" align="left" border="0" cellpadding="0" cellspacing="0" role="presentation" style="min-width: 100%;">
                                                        <tr>
                                                            <td align="left" style="font-size: 14px; color: #888888; font-weight: 300; font-family: 'Open Sans', Arial, Helvetica, sans-serif; word-break: break-word; line-height: 1;"><span style="color: #888888; font-style: normal; text-align: left; line-height: 24px; font-size: 12px; font-weight: 300; font-family: Montserrat, arial, sans-serif;"><span style="font-style: normal; text-align: left; color: #888888; line-height: 24px; font-size: 12px; font-weight: 300; font-family: Montserrat, arial, sans-serif;">Recuerda previamente consultar con nuestros asesores para conocer si los exámenes a realizar tienen unas recomendaciones importantes para la realización de la prueba.</span></span></td>
                                                        </tr><!-- start space -->
                                                        <tr>
                                                            <td valign="top" height="20" style="height: 20px; font-size: 0px; line-height: 0;" aria-hidden="true">&nbsp;</td>
                                                        </tr><!-- end space -->
                                                    </table>
                                                </td>
                                            </tr><!-- end content -->
                                        </table>
                                    </td>
                                </tr><!-- end content -->
                                <!-- start space -->
                                <tr>
                                    <td valign="top" height="30" style="height: 30px; font-size: 0px; line-height: 0;" aria-hidden="true">&nbsp;</td>
                                </tr><!-- end space -->
                            </table>
                        </td>
                    </tr>
                </table><!-- end container -->
            </td>
        </tr>
        <!--END LAYOUT-9 ( 2-COL RIGHT-CONTENT / LEFT-IMAGE )-->
        <!-- START LAYOUT-13 ( FULL-IMAGE / TEXT ) -->
        <tr>
            <td valign="top" align="center" style="background-color:#ffffff;" bgcolor="#ffffff">
                <!-- start container -->
                <table width="600" align="center" border="0" cellspacing="0" cellpadding="0" class="full-width" style="background-color: #ffffff; margin: 0px auto; width: 600px; min-width: 320px; max-width: 90%;" role="presentation" bgcolor="#ffffff">
                    <tr>
                        <td valign="top" align="center">
                            <table width="560" border="0" cellspacing="0" cellpadding="0" align="center" class="full-width" style="margin: 0px auto; width: 560px; min-width: 280px; max-width: 90%;" role="presentation">
                                <!-- start space -->
                                <tr>
                                    <td valign="top" height="50" style="height: 50px; font-size: 0px; line-height: 0;" aria-hidden="true">&nbsp;</td>
                                </tr><!-- end space -->
                                <tr>
                                    <td valign="top" align="center">
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" style="margin: 0px auto; min-width: 100%;" role="presentation">
                                            <!-- start image -->
                                            <tr>
                                                <td valign="top" align="center">
                                                    <table width="100%" align="center" border="0" cellspacing="0" cellpadding="0" style="margin: 0px auto; min-width: 100%;" role="presentation">
                                                        <tr>
                                                            <td align="center" valign="top" class="image-full-width" width="300" style="width: 300px;"> <img src="https://mailbuild.rookiewebstudio.com/customers/v3iyZTIS/user_upload/20190928034927_barra_con_logo_vitalea.jpg" width="300" style="max-width: 300px; height: auto; display: block !important; min-width: 100%;" alt="image" border="0" hspace="0" vspace="0" height="auto"></td>
                                                        </tr><!-- start space -->
                                                        <tr>
                                                            <td valign="top" height="20" style="height: 20px; font-size: 0px; line-height: 0;" aria-hidden="true">&nbsp;</td>
                                                        </tr><!-- end space -->
                                                    </table>
                                                </td>
                                            </tr><!-- end image -->
                                            <!-- start title -->
                                            <!-- end title -->
                                        </table>
                                    </td>
                                </tr><!-- start space -->
                                <tr>
                                    <td valign="top" height="30" style="height: 30px; font-size: 0px; line-height: 0;" aria-hidden="true">&nbsp;</td>
                                </tr><!-- end space -->
                            </table>
                        </td>
                    </tr>
                </table><!-- end container -->
            </td>
        </tr><!-- END LAYOUT-13 ( FULL-IMAGE / TEXT ) -->
        <!-- START LAYOUT-5 ( CONTENT/SOCIAL ) -->
        <tr>
            <td valign="top" align="center" style="background-color: #fff;" bgcolor="#ffffff">
                <table width="600" align="center" border="0" cellspacing="0" cellpadding="0" class="full-width" style="background-color: #ffffff; margin: 0px auto; width: 600px; min-width: 320px; max-width: 90%;" role="presentation" bgcolor="#ffffff">
                    <!-- start space -->
                    <tr>
                        <td valign="top" height="10" style="height: 10px; font-size: 0px; line-height: 0;" aria-hidden="true">&nbsp;</td>
                    </tr><!-- end space -->
                    <!-- start width 600px -->
                    <tr>
                        <td valign="top">
                            <table width="560" align="center" class="full-width" border="0" cellpadding="0" cellspacing="0" style="margin: 0px auto; width: 560px; min-width: 280px; max-width: 90%;" role="presentation">
                                <!-- start content -->
                                <tr>
                                    <td valign="top">
                                        <table width="80%" align="center" border="0" cellspacing="0" cellpadding="0" style="margin: 0px auto;mso-table-lspace:0pt; mso-table-rspace:0pt;" role="presentation">
                                            <tr>
                                                <td align="center" style="font-size: 14px; color: #888888; font-weight: 300; font-family: 'Open Sans', Arial, Helvetica, sans-serif; word-break: break-word; line-height: 1;"><span style="font-style: normal; text-align: center; color: #888888; line-height: 24px; font-size: 12px; font-weight: 300; font-family: Montserrat, arial, sans-serif;"><span style="font-style: normal; text-align: center; color: #888888; line-height: 24px; font-size: 12px; font-weight: 300; font-family: Montserrat, arial, sans-serif;">Recibiste este mail porque estás suscrito al newsletter de Vitălea&nbsp;<a href="http://www.vitalea.co/" data-mce-href="http://www.vitalea.co/" style="border-style: none; text-decoration: none !important; line-height: 24px; font-size: 12px; font-weight: 300; font-family: Montserrat, arial, sans-serif;" border="0">www.vitalea.co</a>&nbsp;&nbsp;Si no deseas recibir nuestro mensaje, puedes darte de baja en este&nbsp;<a href="http://link.email.linio.com.co/u/nrd.php?p=EYxR5KpJwZ_752435_786255_1_47&amp;ems_l=1062935&amp;i=1&amp;d=ZGMwYjEzMjEtNzAyNC0xMWU5LThiNzItMGEyYWM4NjhjNzBj%7CODUzMjY0ODM%3D%7CRVl4UjVLcEp3Wg%3D%3D%7CZ2VuZXJhbC11bnN1YnNjcmliZS10ZXh0bw%3D%3D%7CQ08tb3BlbmVycy0ybmQtMjAxOTA2MTc%3D%7CZ2VuZXJhbC11bnN1YnNjcmliZS10ZXh0bw%3D%3D%7CZ2VuZXJhbC1jeWJlcmx1bmVz%7CQ08tb3BlbmVycy0ybmQtMjAxOTA2MTc%3D%7C%7CZjAyMzU3OWE3M2I5Mzk1NDE%3D%7CZ2VuZXJhbC1jeWJlcmx1bmVz%7C" data-mce-href="http://link.email.linio.com.co/u/nrd.php?p=EYxR5KpJwZ_752435_786255_1_47&amp;ems_l=1062935&amp;i=1&amp;d=ZGMwYjEzMjEtNzAyNC0xMWU5LThiNzItMGEyYWM4NjhjNzBj%7CODUzMjY0ODM%3D%7CRVl4UjVLcEp3Wg%3D%3D%7CZ2VuZXJhbC11bnN1YnNjcmliZS10ZXh0bw%3D%3D%7CQ08tb3BlbmVycy0ybmQtMjAxOTA2MTc%3D%7CZ2VuZXJhbC11bnN1YnNjcmliZS10ZXh0bw%3D%3D%7CZ2VuZXJhbC1jeWJlcmx1bmVz%7CQ08tb3BlbmVycy0ybmQtMjAxOTA2MTc%3D%7C%7CZjAyMzU3OWE3M2I5Mzk1NDE%3D%7CZ2VuZXJhbC1jeWJlcmx1bmVz%7C" style="border-style: none; text-decoration: none !important; line-height: 24px; font-size: 12px; font-weight: 300; font-family: Montserrat, arial, sans-serif;" border="0">link</a>&nbsp;para cancelar tu suscripción (El proceso puede demorar hasta 2 días hábiles.</span></span></td>
                                            </tr><!-- start space -->
                                            <tr>
                                                <td valign="top" height="30" style="height: 30px; font-size: 0px; line-height: 0;" aria-hidden="true">&nbsp;</td>
                                            </tr><!-- end space -->
                                        </table>
                                    </td>
                                </tr><!-- end content -->
                                <!-- start icon/text -->
                                <tr>
                                    <td valign="top">
                                        <table width="auto" border="0" cellspacing="0" cellpadding="0" align="center" style="table-layout: fixed; margin: 0px auto;mso-table-lspace:0pt; mso-table-rspace:0pt;" role="presentation">
                                            <tr class="row" style="display: flex; text-align: center;">
                                                <!-- start duplicate icon -->
                                                <th valign="top" class="full-block" style="padding-bottom: 10px; padding-left: 8px; padding-right: 8px; margin: 0px auto; display: inline !important;">
                                                    <table width="auto" align="left" border="0" cellpadding="0" cellspacing="0" style="margin: 0px auto; min-width: 100%;" class="full-width" role="presentation">
                                                        <tr>
                                                            <td align="left" valign="middle" style="padding-right: 8px; width: 18px; line-height: 0px;" width="18"> <img src="https://mailbuild.rookiewebstudio.com/item/64lm4Q4e/images/set16-icon-Fb.png" width="18" style="max-width:18px; display:block !important;" alt="set16-icon-Fb" border="0" hspace="0" vspace="0"></td>
                                                            <td align="left" style="font-size: 14px; color: #888888; font-weight: 300; font-family: 'Open Sans', Arial, Helvetica, sans-serif; word-break: break-word; line-height: 1;"><span style="color: #888888; font-style: normal; text-align: left; line-height: 24px; font-size: 14px; font-weight: 300; font-family: Montserrat, arial, sans-serif;"><span style="font-style: normal; text-align: left; color: #888888; line-height: 24px; font-size: 14px; font-weight: 300; font-family: Montserrat, arial, sans-serif;"><a href="https://www.facebook.com/Vitălea-560092204505370/" data-mce-href="https://www.facebook.com/Vit%C4%83lea-560092204505370/" style="color: #888888; text-decoration: none !important; border-style: none; line-height: 24px; font-size: 14px; font-weight: 300; font-family: Montserrat, arial, sans-serif;" border="0">vitalesalud</a></span></span></td>
                                                        </tr>
                                                    </table>
                                                </th>
                                                <th valign="top" class="full-block" style="padding-bottom: 10px; padding-left: 8px; padding-right: 8px; margin: 0px auto; display: inline !important;">
                                                    <table width="auto" align="left" border="0" cellpadding="0" cellspacing="0" style="margin: 0px auto; min-width: 100%;" class="full-width" role="presentation">
                                                        <tr>
                                                            <td align="left" valign="middle" style="padding-right: 8px; width: 18px; line-height: 0px;" width="18"> <img src="https://mailbuild.rookiewebstudio.com/item/64lm4Q4e/images/set16-icon-In.png" width="18" style="max-width:18px; display:block !important;" alt="set16-icon-In" border="0" hspace="0" vspace="0"></td>
                                                            <td align="left" style="font-size: 14px; color: #888888; font-weight: 300; font-family: 'Open Sans', Arial, Helvetica, sans-serif; word-break: break-word; line-height: 1;"><span style="color: #888888; text-decoration: none; font-style: normal; text-align: left; line-height: 24px; font-size: 14px; font-weight: 300; font-family: Montserrat, arial, sans-serif;"><span style="font-style: normal; text-align: left; color: #888888; line-height: 24px; font-size: 14px; font-weight: 300; font-family: Montserrat, arial, sans-serif;"> <a href="http://instagram.com/vitaleasalud" style="color: #888888; text-decoration: none !important; border-style: none; line-height: 24px; font-size: 14px; font-weight: 300; font-family: Montserrat, arial, sans-serif;" data-mce-href="http://instagram.com/vitaleasalud" target="_blank" border="0">vitaleasalud</a> </span></span></td>
                                                        </tr>
                                                    </table>
                                                </th> <!-- end duplicate icon -->
                                            </tr><!-- start space -->
                                            <tr>
                                                <td valign="top" height="20" style="height: 20px; font-size: 0px; line-height: 0;" aria-hidden="true">&nbsp;</td>
                                            </tr><!-- end space -->
                                        </table>
                                    </td>
                                </tr><!-- end icon/text -->
                            </table>
                        </td>
                    </tr><!-- end width 600px -->
                    <!-- start space -->
                    <tr>
                        <td valign="top" height="20" style="height: 20px; font-size: 0px; line-height: 0;" aria-hidden="true">&nbsp;</td>
                    </tr><!-- end space -->
                </table>
            </td>
        </tr><!-- END LAYOUT-5 ( CONTENT/SOCIAL ) -->
    </table>
</body>
            
ini;

    $mail->Body = $body; // Mensaje a enviar. 



    $exito = $mail->Send(); // Envía el correo.

    if ($exito) {
        $correo_e = 1;
    } else {
        $correo_e = 2;
    }

    return $correo_e;
}

/* $hola = EnviarCorreoPrueba('kusanagimilo@gmail.com', 23);
  var_dump($hola); */
?>

