<?php

//error_reporting(E_ALL);
error_reporting(E_STRICT);
date_default_timezone_set('America/Bogota');

require_once('class.phpmailer.php');
include("class.smtp.php"); // optional, gets called from within class.phpmailer.php if not already loaded


$mail = new PHPMailer();
$mail->charSet = "UTF-8";
$mail->IsSMTP();
$mail->SMTPAuth = true;
$mail->SMTPSecure = "tls";
$mail->Host = "smtp.gmail.com";
$mail->Username = "hola@vitalea.com.co";
$mail->Password = "vitaleah2019*";
$mail->Port = 587;

$correo = $_POST['correo'];
$nombre = $_POST['nombre'];

$mail->From = "hola@vitalea.com.co";
$mail->FromName = "Vitalea";
$mail->AddAddress($correo);
$mail->IsHTML(true);
$mail->Subject = "Bienvenido a vitalea";


$body = <<<ini
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700,300|Montserrat:400,700&subset=latin,cyrillic,greek" rel="stylesheet" type="text/css" />
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
</head>
<body  style="font-size:12px; width:100%; height:100%;">
    <table id="mainStructure" class="full-width" width="800" align="center" border="0" cellspacing="0" cellpadding="0" style="background-color: #ffffff; max-width: 800px; outline: rgb(239, 239, 239) solid 1px; box-shadow: rgb(224, 224, 224) 0px 0px 30px 5px; margin: 0px auto;" bgcolor="#ffffff">
        <!--START LAYOUT-1 ( LOGO / MENU )-->
        <tr>
            <td align="center" valign="top" class="full-width" style="background-color: #fff;" bgcolor="#ffffff">
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
                                                            <td align="center" valign="top" style="padding-bottom: 5px; padding-top: 5px; width: 136px; line-height: 0px;" width="136"> <a href="#" style="text-decoration: none !important; font-size: inherit; border-style: none;" border="0"> <img src="http://vitalea.com.co/images/20190824050732_logo-vitalea.png" width="136" style="max-width: 240px; display: block !important; width: 136px; height: auto;" alt="logo-top" border="0" hspace="0" vspace="0" height="auto"></a> </td>
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
                                                                                                            <td align="left" valign="top" style="padding-right: 10px; width: 18px; line-height: 0px;" width="18"> <img src="http://vitalea.com.co/images/20190916210242_ico_cell.png" width="18" style="max-width: 18px; display: block !important; width: 18px; height: auto;" vspace="0" hspace="0" alt="icon-phone" height="auto"></td>
                                                                                                        </tr>
                                                                                                    </table>
                                                                                                </td>
                                                                                                <td align="left" style="font-size: 14px; color: #333333; font-weight: normal; font-family: 'Open Sans', Arial, Helvetica, sans-serif; word-break: break-word; line-height: 1;"><a href="https://api.whatsapp.com/send?phone=573187120062" data-mce-href="https://api.whatsapp.com/send?phone=573187120062" target="_blank" style="border-style: none; text-decoration: none !important; line-height: 24px; font-size: 14px; font-weight: 400; font-family: 'Open Sans', Arial, Helvetica, sans-serif;" border="0"><span style="color: #333333; font-style: normal; text-align: left; line-height: 24px; font-size: 14px; font-weight: 400; font-family: 'Open Sans', Arial, Helvetica, sans-serif;"><span style="font-style: normal; text-align: left; color: #333333; line-height: 24px; font-size: 14px; font-weight: 400; font-family: 'Open Sans', Arial, Helvetica, sans-serif;">WhatsApp</span></span></a></td>
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
                                                                                                            <td align="left" valign="top" style="padding-right: 10px; width: 18px; line-height: 0px;" width="18"> <img src="http://vitalea.com.co/images/20190916210242_ico_cell.png" width="18" style="max-width: 18px; display: block !important; width: 18px; height: auto;" vspace="0" hspace="0" alt="icon-phone" height="auto"></td>
                                                                                                        </tr>
                                                                                                    </table>
                                                                                                </td>
                                                                                                <td align="left" style="font-size: 14px; color: #333333; font-weight: normal; font-family: 'Open Sans', Arial, Helvetica, sans-serif; word-break: break-word; line-height: 1;"><span style="font-style: normal; text-align: left; color: #333333; line-height: 24px; font-size: 14px; font-weight: 400; font-family: Montserrat, arial, sans-serif;"><span style="font-style: normal; text-align: left; color: #333333; line-height: 24px; font-size: 14px; font-weight: 400; font-family: Montserrat, arial, sans-serif;">8051348</span></span></td>
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
                                                                                                            <td align="left" valign="top" style="padding-right: 10px; width: 18px; line-height: 0px;" width="18"> <img src="http://vitalea.com.co/images/20190916210242_ico_web.png" width="18" style="max-width: 18px; display: block !important; width: 18px; height: auto;" vspace="0" hspace="0" alt="icon-world" height="auto"></td>
                                                                                                        </tr>
                                                                                                    </table>
                                                                                                </td>
                                                                                                <td align="left" style="font-size: 14px; color: #333333; font-weight: normal; font-family: 'Open Sans', Arial, Helvetica, sans-serif; word-break: break-word; line-height: 1;"><a data-mce-href="https://www.vitalea.co/" href="https://www.vitalea.co/" title="Sitio web Vitalea" style="border-style: none; text-decoration: none !important; line-height: 24px; font-size: 14px; font-weight: 400; font-family: 'Open Sans', Arial, Helvetica, sans-serif;" target="_blank" border="0"><span style="color: #333333; font-style: normal; text-align: left; line-height: 24px; font-size: 14px; font-weight: 400; font-family: 'Open Sans', Arial, Helvetica, sans-serif;">www.vitalea.co</span></a></td>
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
                                    <td valign="top" height="20" style="height: 20px; font-size: 0px; line-height: 0;" aria-hidden="true">&nbsp;</td>
                                </tr><!-- end space -->
                            </table>
                        </td>
                    </tr>
                </table><!-- end container -->
            </td>
        </tr>
        <!--END LAYOUT-1 ( LOGO / MENU )-->
        <!-- START LAYOUT-2 ( Heading/Content ) -->
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
                                <!-- start heading -->
                                <!-- end heading -->
                                <!-- start content -->
                                <tr>
                                    <td valign="top">
                                        <table width="80%" align="center" border="0" cellspacing="0" cellpadding="0" style="margin: 0px auto;mso-table-lspace:0pt; mso-table-rspace:0pt;" role="presentation">
                                            <tr>
                                                <td align="center" style="font-size: 14px; color: #888888; font-weight: 300; font-family: 'Open Sans', Arial, Helvetica, sans-serif; word-break: break-word; line-height: 1;"><span style="color: #888888; font-style: normal; text-align: center; line-height: 24px; font-size: 16px; font-weight: 400; font-family: Montserrat, arial, sans-serif;"><span style="color: #888888; font-style: normal; text-align: center; line-height: 24px; font-size: 16px; font-weight: 400; font-family: Montserrat, arial, sans-serif;"><span style="font-style: normal; text-align: center; color: #888888; line-height: 24px; font-size: 16px; font-weight: 400; font-family: Montserrat, arial, sans-serif;">Hola $nombre<br></span></span></span>
                                                    <p style="font-size: 14px; font-weight: 300; font-family: 'Open Sans', Arial, Helvetica, sans-serif;">Te damos la bienvenida a <strong style="font-size: 14px; font-weight: 700; font-family: 'Open Sans', Arial, Helvetica, sans-serif;">Vitălea</strong></p>
                                                    <p style="font-size: 14px; font-weight: 300; font-family: 'Open Sans', Arial, Helvetica, sans-serif;">Somos la nueva generación de laboratorios clínicos,</p>
                                                    <p style="font-size: 14px; font-weight: 300; font-family: 'Open Sans', Arial, Helvetica, sans-serif;">enfocados en prevención<br></p>
                                                </td>
                                            </tr><!-- start space -->
                                            <tr>
                                                <td valign="top" height="20" style="height: 20px; font-size: 0px; line-height: 0;" aria-hidden="true">&nbsp;</td>
                                            </tr><!-- end space -->
                                        </table>
                                    </td>
                                </tr><!-- end content -->
                                
                                 <!-- start content -->
                                <tr>
                                    <td valign="top">
                                        <table width="80%" align="center" border="0" cellspacing="0" cellpadding="0" style="margin: 0px auto;mso-table-lspace:0pt; mso-table-rspace:0pt;" role="presentation">
                                            <tr>
                                                <td align="center" style="font-size: 14px; color: #888888; font-weight: 300; font-family: 'Open Sans', Arial, Helvetica, sans-serif; word-break: break-word; line-height: 1;"><span style="color: #888888; font-style: normal; text-align: center; line-height: 24px; font-size: 16px; font-weight: 400; font-family: Montserrat, arial, sans-serif;"><span style="color: #888888; font-style: normal; text-align: center; line-height: 24px; font-size: 16px; font-weight: 400; font-family: Montserrat, arial, sans-serif;"><span style="font-style: normal; text-align: center; color: #888888; line-height: 24px; font-size: 16px; font-weight: 400; font-family: Montserrat, arial, sans-serif;">Tus datos de acceso son<br></span></span></span>
                                                    <p style="font-size: 14px; font-weight: 300; font-family: 'Open Sans', Arial, Helvetica, sans-serif;"><b>Usuario</b> : $correo</p>
                                                    <p style="font-size: 14px; color: #ec1481; font-weight: 300; font-family: 'Open Sans', Arial, Helvetica, sans-serif;">Recuerda cambiar tu clave en el momento que ingreses a la pagina, dirígete a la zona de inicio de sesión y oprime el link olvide la contraseña e ingresa tu correo.<br></p>
                                                </td>
                                            </tr><!-- start space -->
                                            <tr>
                                                <td valign="top" height="20" style="height: 20px; font-size: 0px; line-height: 0;" aria-hidden="true">&nbsp;</td>
                                            </tr><!-- end space -->
                                        </table>
                                    </td>
                                </tr><!-- end content -->
                                
                                <!--start button-->
                                <tr>
                                    <td valign="top">
                                        <table width="auto" border="0" align="center" cellpadding="0" cellspacing="0" style="margin: 0px auto;mso-table-lspace:0pt; mso-table-rspace:0pt;" role="presentation">
                                            <tr>
                                                <!-- start duplicate button -->
                                                <!-- end duplicate button -->
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <!--end button-->
                            </table>
                        </td>
                    </tr><!-- end width 600px -->
                    <!-- start space -->
                    <tr>
                        <td valign="top" height="20" style="height: 20px; font-size: 0px; line-height: 0;" aria-hidden="true">&nbsp;</td>
                    </tr><!-- end space -->
                </table>
            </td>
        </tr><!-- END LAYOUT-2 ( Heading/Content ) -->
        <!-- START LAYOUT-2 ( BIG IMAGE ) -->
        <tr>
            <td align="center" valign="top" style="background-color: #fff;" bgcolor="#ffffff">
                <!-- start container -->
                <table width="600" align="center" border="0" cellspacing="0" cellpadding="0" class="full-width clear-pad" style="background-color: #ffffff; margin: 0px auto; width: 600px; min-width: 320px; max-width: 90%;" role="presentation" bgcolor="#ffffff">
                    <!-- start big image -->
                    <tr>
                        <td valign="top">
                            <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0" style="margin: 0px auto; min-width: 100%;" role="presentation">
                                <tr>
                                    <td align="center" valign="middle" class="image-full-width" width="600" style="width: 600px; line-height: 0px;"> <img src="http://vitalea.com.co/images/20190824050147_bg.png" width="600" style="height: auto; display: block !important; width: 100%; max-width: 600px; min-width: 100%;" alt="image" border="0" hspace="0" vspace="0" height="auto"></td>
                                </tr>
                            </table>
                        </td>
                    </tr><!-- end big image -->
                </table><!-- end container -->
            </td>
        </tr><!-- END LAYOUT-2 ( BIG IMAGE ) -->
        <!-- END LAYOUT-3 ( TITLE-CONTENT / BUTTON ) -->
        <tr>
            <td align="center" valign="top" style="background-color: #fff;" bgcolor="#ffffff">
                <!-- start container -->
                <table width="600" align="center" border="0" cellspacing="0" cellpadding="0" class="full-width" style="background-color: #ffffff; margin: 0px auto; width: 600px; min-width: 320px; max-width: 90%;" role="presentation" bgcolor="#ffffff">
                    <tr>
                        <td valign="top" align="center">
                            <table width="560" border="0" cellspacing="0" cellpadding="0" align="center" class="full-width" style="margin: 0px auto; width: 560px; min-width: 280px; max-width: 90%;" role="presentation">
                                <!-- start space -->
                                <tr>
                                    <td valign="top" height="45" style="height: 45px; font-size: 0px; line-height: 0;" aria-hidden="true">&nbsp;</td>
                                </tr><!-- end space -->
                                <tr>
                                    <td valign="top" align="center">
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" style="margin: 0px auto; min-width: 100%;" role="presentation">
                                            <!-- start title -->
                                            <tr>
                                                <td valign="top" align="center">
                                                    <table width="100%" align="center" border="0" cellspacing="0" cellpadding="0" style="margin: 0px auto; min-width: 100%;" role="presentation">
                                                        <tr>
                                                            <td align="center" style="font-size: 20px; color: #333333; font-weight: bold; font-family: 'Open Sans', Arial, Helvetica, sans-serif; word-break: break-word; line-height: 24px;"></td>
                                                        </tr><!-- start space -->
                                                        <tr>
                                                            <td valign="top" height="15" style="height: 15px; font-size: 0px; line-height: 0;" aria-hidden="true">&nbsp;</td>
                                                        </tr><!-- end space -->
                                                        <tr>
                                                            <td align="center" style="font-size: 28px; color: #333333; font-weight: 300; font-family: 'Open Sans', Arial, Helvetica, sans-serif; word-break: break-word; line-height: 1;">
                                                                <p style="font-size: 28px; font-weight: 300; font-family: 'Open Sans', Arial, Helvetica, sans-serif;"><span style="color: #ec1481; font-style: normal; text-align: center; line-height: 24px; font-size: 18px; font-weight: 300; font-family: Montserrat, arial, sans-serif;"><span style="font-style: normal; text-align: center; color: #ec1481; line-height: 24px; font-size: 18px; font-weight: 300; font-family: Montserrat, arial, sans-serif;">¡Te invitamos a entender tu salud de otra manera!</span></span></p>
                                                            </td>
                                                        </tr><!-- start space -->
                                                        <tr>
                                                            <td valign="top" height="13" style="height: 13px; font-size: 0px; line-height: 0;" aria-hidden="true">&nbsp;</td>
                                                        </tr><!-- end space -->
                                                    </table>
                                                </td>
                                            </tr><!-- end title -->
                                            <!-- start content -->
                                            <tr>
                                                <td valign="top">
                                                    <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0" style="margin: 0px auto; min-width: 100%;" role="presentation">
                                                        <tr>
                                                            <td align="center" style="font-size: 14px; color: #888888; font-weight: normal; font-family: 'Open Sans', Arial, Helvetica, sans-serif; word-break: break-word; line-height: 1;">
                                                                <p style="font-size: 14px; font-weight: 400; font-family: 'Open Sans', Arial, Helvetica, sans-serif;"><span style="color: #888888; font-style: normal; text-align: center; line-height: 24px; font-size: 14px; font-weight: 400; font-family: Montserrat, arial, sans-serif;"><span style="font-style: normal; text-align: center; color: #888888; line-height: 24px; font-size: 14px; font-weight: 400; font-family: Montserrat, arial, sans-serif;">Por primera vez accede a más de 2000 pruebas de exámenes y más de 41 chequeos especializados, en el momento que tú lo decidas.</span></span><br><span style="color: #888888; font-style: normal; text-align: center; line-height: 24px; font-size: 10px; font-weight: 400; font-family: Montserrat, arial, sans-serif;"><span style="font-style: normal; text-align: center; color: #888888; line-height: 24px; font-size: 10px; font-weight: 400; font-family: Montserrat, arial, sans-serif;">(paquetes de exámenes enfocados en diferentes especialidades)</span></span></p>
                                                            </td>
                                                        </tr><!-- start space -->
                                                        <tr>
                                                            <td valign="top" height="30" style="height: 30px; font-size: 0px; line-height: 0;" aria-hidden="true">&nbsp;</td>
                                                        </tr><!-- end space -->
                                                    </table>
                                                </td>
                                            </tr><!-- end content -->
                                            <!--start button-->
                                            <tr>
                                                <td valign="top" align="center">
                                                    <table width="auto" align="center" border="0" cellspacing="0" cellpadding="0" style="margin: 0px auto;mso-table-lspace:0pt; mso-table-rspace:0pt;" role="presentation">
                                                        <tr>
                                                            <!-- start duplicate button -->
                                                            <td valign="top" class="full-block">
                                                                <table width="auto" border="0" align="center" cellpadding="0" cellspacing="0" style="margin: 0px auto;mso-table-lspace:0pt; mso-table-rspace:0pt;" role="presentation">
                                                                    <tr>
                                                                        <td valign="top" style="padding-top:5px; padding-bottom:5px; padding-left:5px; padding-right:5px;">
                                                                            <table width="auto" border="0" align="center" cellpadding="0" cellspacing="0" style="border-radius: 5px; background-color: #ec1481; margin: 0px auto;mso-table-lspace:0pt; mso-table-rspace:0pt;" role="presentation" bgcolor="#ec1481">
                                                                                <tr>
                                                                                    <td width="auto" align="center" valign="middle" height="45" style="font-size: 14px; color: #ffffff; font-weight: normal; font-family: 'Open Sans', Arial, Helvetica, sans-serif; word-break: break-word; background-clip: padding-box; padding-left: 25px; padding-right: 25px; line-height: 1;"><span style="color: #ffffff; font-style: normal; text-align: center; line-height: 24px; font-size: 14px; font-weight: 400; font-family: Montserrat, arial, sans-serif;"><a href=" https://www.vitalea.co/" target="_blank" title="Vitalea " data-mce-href=" https://www.vitalea.co/" style="border-style: none; text-decoration: none !important; line-height: 24px; font-size: 14px; font-weight: 400; font-family: Montserrat, arial, sans-serif;" border="0"><span style="color: #ffffff; font-style: normal; text-align: center; line-height: 24px; font-size: 14px; font-weight: 400; font-family: Montserrat, arial, sans-serif;">&nbsp;Exámenes y Chequeos especializados</span></a></span></td>
                                                                                </tr>
                                                                            </table>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </td> <!-- end duplicate button -->
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <!--end button-->
                                        </table>
                                    </td>
                                </tr><!-- start space -->
                                <tr>
                                    <td valign="top" height="14" style="height: 14px; font-size: 0px; line-height: 0;" aria-hidden="true">&nbsp;</td>
                                </tr><!-- end space -->
                            </table>
                        </td>
                    </tr>
                </table><!-- end container -->
            </td>
        </tr><!-- END LAYOUT-3 ( TITLE-CONTENT / BUTTON ) -->
        <!-- START LAYOUT-11 ( 2-COL IMAGE / TEXT / BUTTON ) -->
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
                                    <td valign="top" height="31" style="height: 31px; font-size: 0px; line-height: 0;" aria-hidden="true">&nbsp;</td>
                                </tr><!-- end space -->
                                <!-- start group heading -->
                                <tr>
                                    <td valign="top">
                                        <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0" style="margin: 0px auto; min-width: 100%;" role="presentation">
                                            <tr>
                                                <td align="center" style="font-size: 26px; color: #333333; font-weight: normal; font-family: 'Open Sans', Arial, Helvetica, sans-serif; word-break: break-word; line-height: 1;"><span style="font-style: normal; text-align: center; color: #333333; line-height: 32px; font-size: 26px; font-weight: 400; font-family: Montserrat, arial, sans-serif;"><span style="font-style: normal; text-align: center; color: #333333; line-height: 32px; font-size: 26px; font-weight: 400; font-family: Montserrat, arial, sans-serif;">Sigue estos pasos</span></span><br></td>
                                            </tr>
                                            <tr>
                                                <td valign="top" height="20" style="height: 20px; font-size: 0px; line-height: 0;" aria-hidden="true">&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td align="center" style="font-size: 14px; color: #888888; font-weight: normal; font-family: 'Open Sans', Arial, Helvetica, sans-serif; word-break: break-word; line-height: 24px;"></td>
                                            </tr>
                                            <tr>
                                                <td valign="top" height="9" style="height: 9px; font-size: 0px; line-height: 0;" aria-hidden="true">&nbsp;</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr><!-- end group heading -->
                                <!-- start group 2-col -->
                                <!-- end group 2-col -->
                            </table>
                        </td>
                    </tr>
                </table><!-- end container -->
            </td>
        </tr>
        <!--END LAYOUT-11 ( 2-COL IMAGE / TEXT / BUTTON ) -->
        <!--START LAYOUT-9 ( 2-COL / 2-ROW / IMAGE ICON / TEXT ) -->
        <tr>
            <td align="center" valign="top" style="background-color: #fff;" bgcolor="#ffffff">
                <!-- start container -->
                <table width="600" align="center" border="0" cellspacing="0" cellpadding="0" class="full-width" style="background-color: #ffffff; margin: 0px auto; width: 600px; min-width: 320px; max-width: 90%;" role="presentation" bgcolor="#ffffff">
                    <tr>
                        <td valign="top">
                            <table width="560" border="0" cellspacing="0" cellpadding="0" align="center" class="full-width" style="margin: 0px auto; width: 560px; min-width: 280px; max-width: 90%;" role="presentation">
                                <!-- start space -->
                                <tr>
                                    <td valign="top" height="1" style="height: 1px; font-size: 0px; line-height: 0;" aria-hidden="true">&nbsp;</td>
                                </tr><!-- end space -->
                                <!-- start row 1 -->
                                <tr>
                                    <td valign="top" align="center">
                                        <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0" style="margin: 0px auto; min-width: 100%;" role="presentation">
                                            <tr class="row" style="display: flex; text-align: center;">
                                                <th valign="top" class="full-block" style="display: inline !important; margin: 0px auto;">
                                                    <table width="265" align="left" border="0" cellpadding="0" cellspacing="0" class="full-width left" style="max-width: 265px; min-width: 100%;" role="presentation">
                                                        <tr>
                                                            <td align="left" valign="top" width="40" style="padding-right:15px;">
                                                                <table width="40" align="left" border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace:0pt; mso-table-rspace:0pt;">
                                                                    <tr>
                                                                        <td align="left" valign="top" style="padding-bottom: 10px; width: 64px; line-height: 0px;" width="64"> <img src="http://vitalea.com.co/images/20191206220101_paso-a-paso-1visitanos.png" width="64" style="max-width: 64px; display: block !important; width: 64px; height: auto;" vspace="0" hspace="0" alt="icon-expand" height="auto"></td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                            <td valign="top">
                                                                <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0" style="margin: 0px auto; min-width: 100%;" role="presentation">
                                                                    <!-- start title -->
                                                                    <tr>
                                                                        <td valign="top">
                                                                            <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0" style="margin: 0px auto; min-width: 100%;" role="presentation">
                                                                                <tr>
                                                                                    <td align="left" style="font-size: 18px; color: #333333; font-weight: normal; font-family: 'Open Sans', Arial, Helvetica, sans-serif; word-break: break-word; line-height: 1;"><span style="color: #333333; font-style: normal; text-align: left; line-height: 24px; font-size: 18px; font-weight: 400; font-family: 'Open Sans', Arial, Helvetica, sans-serif;"><span style="color: #333333; font-style: normal; text-align: left; line-height: 24px; font-size: 18px; font-weight: 700; font-family: Montserrat, arial, sans-serif;"><span style="font-style: normal; text-align: left; color: #333333; line-height: 24px; font-size: 18px; font-weight: 700; font-family: Montserrat, arial, sans-serif;">Visítanos</span></span><br></span></td>
                                                                                </tr><!-- start space -->
                                                                                <tr>
                                                                                    <td valign="top" height="15" style="height: 15px; font-size: 0px; line-height: 0;" aria-hidden="true">&nbsp;</td>
                                                                                </tr><!-- end space -->
                                                                            </table>
                                                                        </td>
                                                                    </tr><!-- end title -->
                                                                    <!-- start content -->
                                                                    <tr>
                                                                        <td align="left" style="font-size: 14px; color: #888888; font-weight: normal; font-family: 'Open Sans', Arial, Helvetica, sans-serif; word-break: break-word; line-height: 1;">
                                                                            <p style="font-size: 14px; font-weight: 400; font-family: 'Open Sans', Arial, Helvetica, sans-serif;"><span style="font-style: normal; text-align: left; color: #888888; line-height: 24px; font-size: 14px; font-weight: 400; font-family: Montserrat, arial, sans-serif;"><span style="font-style: normal; text-align: left; color: #888888; line-height: 24px; font-size: 14px; font-weight: 400; font-family: Montserrat, arial, sans-serif;">Sin cita previa, sin esperas, ni largas filas.</span></span></p>
                                                                        </td>
                                                                    </tr><!-- end content -->
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </th>
                                                <th valign="top" class="full-block" style="display: inline !important; margin: 0px auto;">
                                                    <table width="30" border="0" cellpadding="0" cellspacing="0" align="left" class="full-width left" style="border-spacing: 0px; max-width: 30px; min-width: 100%;" role="presentation">
                                                        <tr>
                                                            <td height="20" width="30" style="border-collapse: collapse; display: block; height: 20px; font-size: 0px; line-height: 0;" aria-hidden="true">&nbsp;</td>
                                                        </tr>
                                                    </table>
                                                </th>
                                                <th valign="top" class="full-block" style="display: inline !important; margin: 0px auto;">
                                                    <table width="265" align="right" border="0" cellpadding="0" cellspacing="0" class="full-width right" style="max-width: 265px; min-width: 100%;" role="presentation">
                                                        <tr>
                                                            <td align="left" valign="top" width="40" style="padding-right:15px;">
                                                                <table width="40" align="left" border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace:0pt; mso-table-rspace:0pt;">
                                                                    <tr>
                                                                        <td align="left" valign="top" style="padding-bottom: 10px; width: 64px; line-height: 0px;" width="64"> <img src="http://vitalea.com.co/images/20191206220101_paso-a-paso-2cotizacion.png" width="64" style="max-width: 64px; display: block !important; width: 64px; height: auto;" vspace="0" hspace="0" alt="icon-cellphone" height="auto"></td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                            <td valign="top">
                                                                <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0" style="margin: 0px auto; min-width: 100%;" role="presentation">
                                                                    <!-- start title -->
                                                                    <tr>
                                                                        <td valign="top">
                                                                            <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0" style="margin: 0px auto; min-width: 100%;" role="presentation">
                                                                                <tr>
                                                                                    <td align="left" style="font-size: 18px; color: #333333; font-weight: normal; font-family: 'Open Sans', Arial, Helvetica, sans-serif; word-break: break-word; line-height: 1;"><span style="font-style: normal; text-align: left; color: #333333; line-height: 24px; font-size: 18px; font-weight: 700; font-family: Montserrat, arial, sans-serif;"><span style="font-style: normal; text-align: left; color: #333333; line-height: 24px; font-size: 18px; font-weight: 700; font-family: Montserrat, arial, sans-serif;">Solicita cotización</span></span><br></td>
                                                                                </tr><!-- start space -->
                                                                                <tr>
                                                                                    <td valign="top" height="15" style="height: 15px; font-size: 0px; line-height: 0;" aria-hidden="true">&nbsp;</td>
                                                                                </tr><!-- end space -->
                                                                            </table>
                                                                        </td>
                                                                    </tr><!-- end title -->
                                                                    <!-- start content -->
                                                                    <tr>
                                                                        <td align="left" style="font-size: 14px; color: #888888; font-weight: normal; font-family: 'Open Sans', Arial, Helvetica, sans-serif; word-break: break-word; line-height: 1;">
                                                                            <p style="font-size: 14px; font-weight: 400; font-family: 'Open Sans', Arial, Helvetica, sans-serif;"><span style="font-style: normal; text-align: left; color: #888888; line-height: 24px; font-size: 14px; font-weight: 400; font-family: Montserrat, arial, sans-serif;"><span style="font-style: normal; text-align: left; color: #888888; line-height: 24px; font-size: 14px; font-weight: 400; font-family: Montserrat, arial, sans-serif;">Nuestros asesores te guiarán en todo el proceso.</span></span></p>
                                                                        </td>
                                                                    </tr><!-- end content -->
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </th>
                                            </tr><!-- start space -->
                                            <tr>
                                                <td valign="top" height="30" style="height: 30px; font-size: 0px; line-height: 0;" aria-hidden="true">&nbsp;</td>
                                            </tr><!-- end space -->
                                        </table>
                                    </td>
                                </tr><!-- end row 1 -->
                                <!-- start row 2 -->
                                <tr>
                                    <td valign="top" align="center">
                                        <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0" style="margin: 0px auto; min-width: 100%;" role="presentation">
                                            <tr class="row" style="display: flex; text-align: center;">
                                                <th valign="top" class="full-block" style="display: inline !important; margin: 0px auto;">
                                                    <table width="265" align="left" border="0" cellpadding="0" cellspacing="0" class="full-width left" style="max-width: 265px; min-width: 100%;" role="presentation">
                                                        <tr>
                                                            <td align="left" valign="top" width="40" style="padding-right:15px;">
                                                                <table width="40" align="left" border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace:0pt; mso-table-rspace:0pt;">
                                                                    <tr>
                                                                        <td align="left" valign="top" style="padding-bottom: 10px; width: 64px; line-height: 0px;" width="64"> <img src="http://vitalea.com.co/images/20191206220114_paso-a-paso-3prueba.png" width="64" style="max-width: 64px; display: block !important; width: 64px; height: auto;" vspace="0" hspace="0" alt="icon-coffee" height="auto"></td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                            <td valign="top">
                                                                <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0" style="margin: 0px auto; min-width: 100%;" role="presentation">
                                                                    <!-- start title -->
                                                                    <tr>
                                                                        <td valign="top">
                                                                            <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0" style="margin: 0px auto; min-width: 100%;" role="presentation">
                                                                                <tr>
                                                                                    <td align="left" style="font-size: 18px; color: #333333; font-weight: normal; font-family: 'Open Sans', Arial, Helvetica, sans-serif; word-break: break-word; line-height: 1;"><span style="font-style: normal; text-align: left; color: #333333; line-height: 24px; font-size: 18px; font-weight: 700; font-family: Montserrat, arial, sans-serif;"><span style="font-style: normal; text-align: left; color: #333333; line-height: 24px; font-size: 18px; font-weight: 700; font-family: Montserrat, arial, sans-serif;">Haz la prueba</span></span><br></td>
                                                                                </tr><!-- start space -->
                                                                                <tr>
                                                                                    <td valign="top" height="15" style="height: 15px; font-size: 0px; line-height: 0;" aria-hidden="true">&nbsp;</td>
                                                                                </tr><!-- end space -->
                                                                            </table>
                                                                        </td>
                                                                    </tr><!-- end title -->
                                                                    <!-- start content -->
                                                                    <tr>
                                                                        <td align="left" style="font-size: 14px; color: #888888; font-weight: normal; font-family: 'Open Sans', Arial, Helvetica, sans-serif; word-break: break-word; line-height: 1;">
                                                                            <p style="font-size: 14px; font-weight: 400; font-family: 'Open Sans', Arial, Helvetica, sans-serif;"><span style="font-style: normal; text-align: left; color: #888888; line-height: 24px; font-size: 14px; font-weight: 400; font-family: Montserrat, arial, sans-serif;"><span style="font-style: normal; text-align: left; color: #888888; line-height: 24px; font-size: 14px; font-weight: 400; font-family: Montserrat, arial, sans-serif;">Contamos con la más avanzada tecnología y el apoyo de profesionales altamente calificados.</span></span></p>
                                                                        </td>
                                                                    </tr><!-- end content -->
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </th>
                                                <th valign="top" class="full-block" style="display: inline !important; margin: 0px auto;">
                                                    <table width="30" border="0" cellpadding="0" cellspacing="0" align="left" class="full-width left" style="border-spacing: 0px; max-width: 30px; min-width: 100%;" role="presentation">
                                                        <tr>
                                                            <td height="30" width="30" style="border-collapse: collapse; display: block; height: 30px; font-size: 0px; line-height: 0;" aria-hidden="true">&nbsp;</td>
                                                        </tr>
                                                    </table>
                                                </th>
                                                <th valign="top" class="full-block" style="display: inline !important; margin: 0px auto;">
                                                    <table width="265" align="right" border="0" cellpadding="0" cellspacing="0" class="full-width right" style="max-width: 265px; min-width: 100%;" role="presentation">
                                                        <tr>
                                                            <td align="left" valign="top" width="40" style="padding-right:15px;">
                                                                <table width="40" align="left" border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace:0pt; mso-table-rspace:0pt;">
                                                                    <tr>
                                                                        <td align="left" valign="top" style="padding-bottom: 10px; width: 64px; line-height: 0px;" width="64"> <img src="http://vitalea.com.co/images/20191206220114_paso-a-paso-4resultados.png" width="64" style="max-width: 64px; display: block !important; width: 64px; height: auto;" vspace="0" hspace="0" alt="icon-clock" height="auto"></td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                            <td valign="top">
                                                                <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0" style="margin: 0px auto; min-width: 100%;" role="presentation">
                                                                    <!-- start title -->
                                                                    <tr>
                                                                        <td valign="top">
                                                                            <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0" style="margin: 0px auto; min-width: 100%;" role="presentation">
                                                                                <tr>
                                                                                    <td align="left" style="font-size: 18px; color: #333333; font-weight: normal; font-family: 'Open Sans', Arial, Helvetica, sans-serif; word-break: break-word; line-height: 1;"><span style="font-style: normal; text-align: left; color: #333333; line-height: 24px; font-size: 18px; font-weight: 700; font-family: Montserrat, arial, sans-serif;"><span style="font-style: normal; text-align: left; color: #333333; line-height: 24px; font-size: 18px; font-weight: 700; font-family: Montserrat, arial, sans-serif;">Resultados a tu alcance</span></span><br></td>
                                                                                </tr><!-- start space -->
                                                                                <tr>
                                                                                    <td valign="top" height="15" style="height: 15px; font-size: 0px; line-height: 0;" aria-hidden="true">&nbsp;</td>
                                                                                </tr><!-- end space -->
                                                                            </table>
                                                                        </td>
                                                                    </tr><!-- end title -->
                                                                    <!-- start content -->
                                                                    <tr>
                                                                        <td align="left" style="font-size: 14px; color: #888888; font-weight: normal; font-family: 'Open Sans', Arial, Helvetica, sans-serif; word-break: break-word; line-height: 1;">
                                                                            <p style="font-size: 14px; font-weight: 400; font-family: 'Open Sans', Arial, Helvetica, sans-serif;"><span style="font-style: normal; text-align: left; color: #888888; line-height: 24px; font-size: 14px; font-weight: 400; font-family: Montserrat, arial, sans-serif;"><span style="font-style: normal; text-align: left; color: #888888; line-height: 24px; font-size: 14px; font-weight: 400; font-family: Montserrat, arial, sans-serif;">Consulta tus resultados en tiempo record, descárgalos en la web o retíralos en el lab.</span></span></p>
                                                                        </td>
                                                                    </tr><!-- end content -->
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </th>
                                            </tr><!-- start space -->
                                            <tr>
                                                <td valign="top" height="30" style="height: 30px; font-size: 0px; line-height: 0;" aria-hidden="true">&nbsp;</td>
                                            </tr><!-- end space -->
                                        </table>
                                    </td>
                                </tr><!-- end row 2 -->
                                <!-- start space -->
                                <tr>
                                    <td valign="top" height="20" style="height: 20px; font-size: 0px; line-height: 0;" aria-hidden="true">&nbsp;</td>
                                </tr><!-- end space -->
                            </table>
                        </td>
                    </tr>
                </table><!-- end container -->
            </td>
        </tr>
        <!--END LAYOUT-9 ( 2-COL / 2-ROW / IMAGE ICON / TEXT ) -->
        <!-- END LAYOUT-3 ( TITLE-CONTENT / BUTTON ) -->
        <tr>
            <td align="center" valign="top" style="background-color: #fff;" bgcolor="#ffffff">
                <!-- start container -->
                <table width="600" align="center" border="0" cellspacing="0" cellpadding="0" class="full-width" style="background-color: #ffffff; margin: 0px auto; width: 600px; min-width: 320px; max-width: 90%;" role="presentation" bgcolor="#ffffff">
                    <tr>
                        <td valign="top" align="center">
                            <table width="560" border="0" cellspacing="0" cellpadding="0" align="center" class="full-width" style="margin: 0px auto; width: 560px; min-width: 280px; max-width: 90%;" role="presentation">
                                <!-- start space -->
                                <tr>
                                    <td valign="top" height="20" style="height: 20px; font-size: 0px; line-height: 0;" aria-hidden="true">&nbsp;</td>
                                </tr><!-- end space -->
                                <tr>
                                    <td valign="top" align="center">
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" style="margin: 0px auto; min-width: 100%;" role="presentation">
                                            <!-- start title -->
                                            <!-- end title -->
                                            <!-- start content -->
                                            <tr>
                                                <td valign="top">
                                                    <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0" style="margin: 0px auto; min-width: 100%;" role="presentation">
                                                        <tr>
                                                            <td align="center" style="font-size: 14px; color: #888888; font-weight: normal; font-family: 'Open Sans', Arial, Helvetica, sans-serif; word-break: break-word; line-height: 1;">
                                                                <p style="font-size: 14px; font-weight: 400; font-family: 'Open Sans', Arial, Helvetica, sans-serif;"><span style="font-style: normal; text-align: center; color: #888888; line-height: 24px; font-size: 14px; font-weight: 400; font-family: Montserrat, arial, sans-serif;"><span style="font-style: normal; text-align: center; color: #888888; line-height: 24px; font-size: 14px; font-weight: 400; font-family: Montserrat, arial, sans-serif;">Aprende a conocer, evaluar y entender que ocurre con tu cuerpo.</span></span></p>
                                                                <p style="font-size: 14px; font-weight: 400; font-family: 'Open Sans', Arial, Helvetica, sans-serif;"><span style="font-style: normal; text-align: center; color: #888888; line-height: 24px; font-size: 14px; font-weight: 400; font-family: Montserrat, arial, sans-serif;"><span style="font-style: normal; text-align: center; color: #888888; line-height: 24px; font-size: 14px; font-weight: 400; font-family: Montserrat, arial, sans-serif;"><strong style="font-size: 14px; font-weight: 700; font-family: Montserrat, arial, sans-serif;">Somos una guía para que junto con tu médico</strong></span></span></p>
                                                                <p style="font-size: 14px; font-weight: 400; font-family: 'Open Sans', Arial, Helvetica, sans-serif;"><span style="font-style: normal; text-align: center; color: #888888; line-height: 24px; font-size: 14px; font-weight: 400; font-family: Montserrat, arial, sans-serif;"><span style="font-style: normal; text-align: center; color: #888888; line-height: 24px; font-size: 14px; font-weight: 400; font-family: Montserrat, arial, sans-serif;"><strong style="font-size: 14px; font-weight: 700; font-family: Montserrat, arial, sans-serif;">realices el correcto seguimiento de tu salud.</strong></span></span></p>
                                                            </td>
                                                        </tr><!-- start space -->
                                                        <tr>
                                                            <td valign="top" height="3" style="height: 3px; font-size: 0px; line-height: 0;" aria-hidden="true">&nbsp;</td>
                                                        </tr><!-- end space -->
                                                    </table>
                                                </td>
                                            </tr><!-- end content -->
                                            <!--start button-->
                                            <tr>
                                                <td valign="top" align="center">
                                                    <table width="auto" align="center" border="0" cellspacing="0" cellpadding="0" style="margin: 0px auto;mso-table-lspace:0pt; mso-table-rspace:0pt;" role="presentation">
                                                        <tr>
                                                            <!-- start duplicate button -->
                                                            <!-- end duplicate button -->
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <!--end button-->
                                        </table>
                                    </td>
                                </tr><!-- start space -->
                                <tr>
                                    <td valign="top" height="2" style="height: 2px; font-size: 0px; line-height: 0;" aria-hidden="true">&nbsp;</td>
                                </tr><!-- end space -->
                            </table>
                        </td>
                    </tr>
                </table><!-- end container -->
            </td>
        </tr><!-- END LAYOUT-3 ( TITLE-CONTENT / BUTTON ) -->
        <!-- END LAYOUT-3 ( TITLE-CONTENT / BUTTON ) -->
        <tr>
            <td align="center" valign="top" style="background-color: #fff;" bgcolor="#ffffff">
                <!-- start container -->
                <table width="600" align="center" border="0" cellspacing="0" cellpadding="0" class="full-width" style="background-color: #ffffff; margin: 0px auto; width: 600px; min-width: 320px; max-width: 90%;" role="presentation" bgcolor="#ffffff">
                    <tr>
                        <td valign="top" align="center">
                            <table width="560" border="0" cellspacing="0" cellpadding="0" align="center" class="full-width" style="margin: 0px auto; width: 560px; min-width: 280px; max-width: 90%;" role="presentation">
                                <!-- start space -->
                                <tr>
                                    <td valign="top" height="4" style="height: 4px; font-size: 0px; line-height: 0;" aria-hidden="true">&nbsp;</td>
                                </tr><!-- end space -->
                                <tr>
                                    <td valign="top" align="center">
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" style="margin: 0px auto; min-width: 100%;" role="presentation">
                                            <!-- start title -->
                                            <tr>
                                                <td valign="top" align="center">
                                                    <table width="100%" align="center" border="0" cellspacing="0" cellpadding="0" style="margin: 0px auto; min-width: 100%;" role="presentation">
                                                        <tr>
                                                            <td align="center" style="font-size: 20px; color: #333333; font-weight: bold; font-family: 'Open Sans', Arial, Helvetica, sans-serif; word-break: break-word; line-height: 24px;"></td>
                                                        </tr><!-- start space -->
                                                        <tr>
                                                            <td valign="top" height="2" style="height: 2px; font-size: 0px; line-height: 0;" aria-hidden="true">&nbsp;</td>
                                                        </tr><!-- end space -->
                                                        <tr>
                                                            <td align="center" style="font-size: 28px; color: #333333; font-weight: 300; font-family: 'Open Sans', Arial, Helvetica, sans-serif; word-break: break-word; line-height: 1;">
                                                                <p style="font-size: 28px; font-weight: 300; font-family: 'Open Sans', Arial, Helvetica, sans-serif;"><span style="color: #ec1481; font-style: normal; text-align: center; line-height: 24px; font-size: 18px; font-weight: 300; font-family: Montserrat, arial, sans-serif;"><span style="font-style: normal; text-align: center; color: #ec1481; line-height: 24px; font-size: 18px; font-weight: 300; font-family: Montserrat, arial, sans-serif;">¡Tenemos uno ideal para tus necesidades!</span></span></p>
                                                            </td>
                                                        </tr><!-- start space -->
                                                        <tr>
                                                            <td valign="top" height="13" style="height: 13px; font-size: 0px; line-height: 0;" aria-hidden="true">&nbsp;</td>
                                                        </tr><!-- end space -->
                                                    </table>
                                                </td>
                                            </tr><!-- end title -->
                                            <!-- start content -->
                                            <tr>
                                                <td valign="top">
                                                    <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0" style="margin: 0px auto; min-width: 100%;" role="presentation">
                                                        <tr>
                                                            <td align="center" style="font-size: 14px; color: #888888; font-weight: normal; font-family: 'Open Sans', Arial, Helvetica, sans-serif; word-break: break-word; line-height: 1;">
                                                                <p style="font-size: 14px; font-weight: 400; font-family: 'Open Sans', Arial, Helvetica, sans-serif;"><span style="font-style: normal; text-align: center; color: #888888; line-height: 24px; font-size: 14px; font-weight: 400; font-family: Montserrat, arial, sans-serif;"><span style="font-style: normal; text-align: center; color: #888888; line-height: 24px; font-size: 14px; font-weight: 400; font-family: Montserrat, arial, sans-serif;">¿Dudas adicionales?</span></span></p>
                                                            </td>
                                                        </tr><!-- start space -->
                                                        <tr>
                                                            <td valign="top" height="10" style="height: 10px; font-size: 0px; line-height: 0;" aria-hidden="true">&nbsp;</td>
                                                        </tr><!-- end space -->
                                                    </table>
                                                </td>
                                            </tr><!-- end content -->
                                            <!--start button-->
                                            <tr>
                                                <td valign="top" align="center">
                                                    <table width="auto" align="center" border="0" cellspacing="0" cellpadding="0" style="margin: 0px auto;mso-table-lspace:0pt; mso-table-rspace:0pt;" role="presentation">
                                                        <tr>
                                                            <!-- start duplicate button -->
                                                            <td valign="top" class="full-block">
                                                                <table width="auto" border="0" align="center" cellpadding="0" cellspacing="0" style="margin: 0px auto;mso-table-lspace:0pt; mso-table-rspace:0pt;" role="presentation">
                                                                    <tr>
                                                                        <td valign="top" style="padding-top:5px; padding-bottom:5px; padding-left:5px; padding-right:5px;">
                                                                            <table width="auto" border="0" align="center" cellpadding="0" cellspacing="0" style="border-radius: 5px; background-color: #ec1481; margin: 0px auto;mso-table-lspace:0pt; mso-table-rspace:0pt;" role="presentation" bgcolor="#ec1481">
                                                                                <tr>
                                                                                    <td width="auto" align="center" valign="middle" height="45" style="font-size: 14px; color: #ffffff; font-weight: normal; font-family: 'Open Sans', Arial, Helvetica, sans-serif; word-break: break-word; background-clip: padding-box; padding-left: 25px; padding-right: 25px; line-height: 1;"><span style="color: #ffffff; font-style: normal; text-align: center; line-height: 24px; font-size: 14px; font-weight: 400; font-family: Montserrat, arial, sans-serif;"><a href="https://api.whatsapp.com/send?phone=573187120062" target="_blank" data-mce-href="https://api.whatsapp.com/send?phone=573187120062" style="border-style: none; text-decoration: none !important; line-height: 24px; font-size: 14px; font-weight: 400; font-family: Montserrat, arial, sans-serif;" border="0"><span style="color: #ffffff; font-style: normal; text-align: center; line-height: 24px; font-size: 14px; font-weight: 400; font-family: Montserrat, arial, sans-serif;">Contáctanos ya por WhatsApp</span></a><span id="_mce_caret" data-mce-bogus="1" style="color: #ffffff; font-style: normal; text-align: center; line-height: 24px; font-size: 14px; font-weight: 400; font-family: Montserrat, arial, sans-serif;"><span data-mce-bogus="1" style="color: #ffffff; font-style: normal; text-align: center; line-height: 24px; font-size: 14px; font-weight: 400; font-family: Montserrat, arial, sans-serif;">﻿</span></span></span></td>
                                                                                </tr>
                                                                            </table>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </td> <!-- end duplicate button -->
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <!--end button-->
                                        </table>
                                    </td>
                                </tr><!-- start space -->
                                <tr>
                                    <td valign="top" height="14" style="height: 14px; font-size: 0px; line-height: 0;" aria-hidden="true">&nbsp;</td>
                                </tr><!-- end space -->
                            </table>
                        </td>
                    </tr>
                </table><!-- end container -->
            </td>
        </tr><!-- END LAYOUT-3 ( TITLE-CONTENT / BUTTON ) -->
        <!-- START LAYOUT-8 ( ICON-CENTRE / HEADING / TEXT ) -->
        <tr>
            <td valign="top" align="center" style="background-color: #ffffff;" bgcolor="#ffffff">
                <!-- start container -->
                <table width="600" align="center" border="0" cellspacing="0" cellpadding="0" class="full-width" style="background-color: #ffffff; margin: 0px auto; width: 600px; min-width: 320px; max-width: 90%;" role="presentation" bgcolor="#ffffff">
                    <!-- start heading text -->
                    <tr>
                        <td valign="top" align="center">
                            <table width="560" align="center" border="0" cellpadding="0" cellspacing="0" class="full-width" style="margin: 0px auto; width: 560px; min-width: 280px; max-width: 90%;" role="presentation">
                                <!-- start space -->
                                <tr>
                                    <td valign="top" height="32" style="height: 32px; font-size: 0px; line-height: 0;" aria-hidden="true">&nbsp;</td>
                                </tr><!-- end space -->
                                <!-- start image -->
                                <tr>
                                    <td valign="top">
                                        <table width="auto" align="center" border="0" cellspacing="0" cellpadding="0" style="margin: 0px auto;mso-table-lspace:0pt; mso-table-rspace:0pt;" role="presentation">
                                            <tr>
                                                <td align="center" valign="top" class="image-full-width" width="400" style="width: 400px;"> <a href="#" style="text-decoration: none !important; font-size: inherit; border-style: none;" border="0"> <img src="http://vitalea.com.co/images/20190730001053_logo.jpg" width="400" style="height: auto; display: block !important; width: 100%; max-width: 400px; min-width: 100%;" vspace="0" hspace="0" alt="image" height="auto"></a> </td>
                                            </tr><!-- start space -->
                                            <tr>
                                                <td valign="top" height="10" style="height: 10px; font-size: 0px; line-height: 0;" aria-hidden="true">&nbsp;</td>
                                            </tr><!-- end space -->
                                        </table>
                                    </td>
                                </tr><!-- end image -->
                                <!-- start title -->
                                <!-- end title -->
                                <!-- start image -->
                                <!-- end image -->
                            </table>
                        </td>
                    </tr><!-- end heading text -->
                </table><!-- end container -->
            </td>
        </tr><!-- END LAYOUT-8 ( ICON-CENTRE / HEADING / TEXT ) -->
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
                                                <td align="center" style="font-size: 14px; color: #888888; font-weight: 300; font-family: 'Open Sans', Arial, Helvetica, sans-serif; word-break: break-word; line-height: 1;"><span style="color: #888888; font-style: normal; text-align: center; line-height: 24px; font-size: 11px; font-weight: 300; font-family: 'Open Sans', Arial, Helvetica, sans-serif;"><span style="font-style: normal; text-align: center; color: #888888; line-height: 24px; font-size: 11px; font-weight: 300; font-family: 'Open Sans', Arial, Helvetica, sans-serif;">Recibiste este mail porque estás suscrito al newsletter de Vitălea <a href="https://www.vitalea.co/" data-mce-href="https://www.vitalea.co/" style="border-style: none; text-decoration: none !important; line-height: 24px; font-size: 11px; font-weight: 300; font-family: 'Open Sans', Arial, Helvetica, sans-serif;" border="0">www.vitalea.co</a> &nbsp;Si no deseas recibir nuestro mensaje, puedes darte de baja en este&nbsp;link&nbsp;para cancelar tu suscripción (El proceso puede demorar hasta 2 días hábiles.</span></span></td>
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
                                                            <td align="left" valign="middle" style="padding-right: 8px; width: 18px; line-height: 0px;" width="18"> <img src="http://vitalea.com.co/images/set16-icon-Fb.png" width="18" style="max-width:18px; display:block !important;" alt="set16-icon-Fb" border="0" hspace="0" vspace="0"></td>
                                                            <td align="left" style="font-size: 14px; color: #888888; font-weight: 300; font-family: 'Open Sans', Arial, Helvetica, sans-serif; word-break: break-word; line-height: 1;"> <span style="text-decoration: none; color: #888888; font-style: normal; text-align: left; line-height: 24px; font-size: 14px; font-weight: 300; font-family: 'Open Sans', Arial, Helvetica, sans-serif;"> <a href="#" style="color: #888888; text-decoration: none !important; border-style: none; line-height: 24px; font-size: 14px; font-weight: 300; font-family: 'Open Sans', Arial, Helvetica, sans-serif;" border="0">Facebook</a> </span> </td>
                                                        </tr>
                                                    </table>
                                                </th>
                                                <th valign="top" class="full-block" style="padding-bottom: 10px; padding-left: 8px; padding-right: 8px; margin: 0px auto; display: inline !important;">
                                                    <table width="auto" align="left" border="0" cellpadding="0" cellspacing="0" style="margin: 0px auto; min-width: 100%;" class="full-width" role="presentation">
                                                        <tr>
                                                            <td align="left" valign="middle" style="padding-right: 8px; width: 18px; line-height: 0px;" width="18"> <img src="http://vitalea.com.co/images/set16-icon-Tw.png" width="18" style="max-width:18px; display:block !important;" alt="set16-icon-Tw" border="0" hspace="0" vspace="0"></td>
                                                            <td align="left" style="font-size: 14px; color: #888888; font-weight: 300; font-family: 'Open Sans', Arial, Helvetica, sans-serif; word-break: break-word; line-height: 1;"> <span style="text-decoration: none; color: #888888; font-style: normal; text-align: left; line-height: 24px; font-size: 14px; font-weight: 300; font-family: 'Open Sans', Arial, Helvetica, sans-serif;"> <a href="#" style="color: #888888; text-decoration: none !important; border-style: none; line-height: 24px; font-size: 14px; font-weight: 300; font-family: 'Open Sans', Arial, Helvetica, sans-serif;" border="0">Twitter</a> </span> </td>
                                                        </tr>
                                                    </table>
                                                </th>
                                                <th valign="top" class="full-block" style="padding-bottom: 10px; padding-left: 8px; padding-right: 8px; margin: 0px auto; display: inline !important;">
                                                    <table width="auto" align="left" border="0" cellpadding="0" cellspacing="0" style="margin: 0px auto; min-width: 100%;" class="full-width" role="presentation">
                                                        <tr>
                                                            <td align="left" valign="middle" style="padding-right: 8px; width: 18px; line-height: 0px;" width="18"> <img src="http://vitalea.com.co/images/set16-icon-In.png" width="18" style="max-width:18px; display:block !important;" alt="set16-icon-In" border="0" hspace="0" vspace="0"></td>
                                                            <td align="left" style="font-size: 14px; color: #888888; font-weight: 300; font-family: 'Open Sans', Arial, Helvetica, sans-serif; word-break: break-word; line-height: 1;"> <span style="text-decoration: none; color: #888888; font-style: normal; text-align: left; line-height: 24px; font-size: 14px; font-weight: 300; font-family: 'Open Sans', Arial, Helvetica, sans-serif;"> <a href="#" style="color: #888888; text-decoration: none !important; border-style: none; line-height: 24px; font-size: 14px; font-weight: 300; font-family: 'Open Sans', Arial, Helvetica, sans-serif;" border="0">Instagram</a> </span> </td>
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
    echo 1;
} else {
    echo 2;
}