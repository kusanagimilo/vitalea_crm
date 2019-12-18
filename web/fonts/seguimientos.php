



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>CRM - Call Center</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

  <meta http-equiv="Expires" content="0">
  <meta http-equiv="Last-Modified" content="0">
  <meta http-equiv="Cache-Control" content="no-cache, mustrevalidate">
  <meta http-equiv="Pragma" content="no-cache">

 <link href="../assets/css/style.css" rel="stylesheet" type="text/css"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />  

<link href="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.css" rel="stylesheet"/>
<link href="https://cdn.jsdelivr.net/alertify.js/0.3.11/themes/alertify.core.css" rel="stylesheet" type="text/css"/>
<link href="https://cdn.jsdelivr.net/alertify.js/0.3.11/themes/alertify.default.css" rel="stylesheet" type="text/css"/>
<link href="../assets/css/bootstrap.css" rel="stylesheet" />

<!-- CUSTOM STYLES-->
<link href="../assets/css/custom.css" rel="stylesheet" />
<!-- GOOGLE FONTS-->
<link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
<!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">-->
<link href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.css" rel="stylesheet"/>
<link rel="stylesheet" href="../web/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="../web/css/dropzone/dropzone.css">
<link rel="stylesheet" href="../web/css/summernote/summernote.css">


<!-- SCRIPT JS -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<!--<script src="../web/js/vendor/jquery-1.12.4.min.js" type="text/javascript"></script>-->

<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/alertify.js/0.3.11/alertify.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.15.2/moment.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>

 

<style type="text/css">
  
.dropdown-menu > li > a:hover, .dropdown-menu > li > a:focus {
    color: black;
    text-decoration: none;
    background-color: #ddd;
}
</style>









<body>
<nav class="navbar navbar-default" style="height: 90px; background-color: #214761;">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#" style="background-color: white; height: 90px; margin-left: 10px;">
       <img src="../web/images/logo.png" alt="" width="70" /></a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
  
      <ul class="nav navbar-nav navbar-right" >
 
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" style="font-size: 12pt;color:#00c292">
                          
            <span class="caret"></span></a>
          <ul class="dropdown-menu" style="background: #214761;">
                
            <li>
                <a href="#" style="color:white; font-style: bold" data-toggle="modal" data-target=".bs-example-modal-sm"> 
                    <img src="../web/images/almuerzo_1.png" alt="Almuerzo" title="Almuerzo" /> Almuerzo </a></li>
            <li><a href="#" style="color:white; font-style: bold"><img src="../web/images/cafe.png" alt="Break" title="Break"/> Break</a></li>
              
            <li><a href="#" style="color:white; font-style: bold">  <img src="../web/images/boton-de-encendido.png" alt="" alt="Cerrar sesion" title="Cerrar session"/> Cerrar sesion</a></li>
          </ul>
        </li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel">    <img src="../web/images/caja-de-almuerzo.png" alt="Almuerzo" title="Almuerzo" /> Inicio Almuerzo </h4>
      </div>
      <div class="modal-body">

          <p style="font-size: 12pt;color:#00c292"> 
            <img src="images/info.png" alt=""/>
        ¿Desea iniciar el tiempo de almuerzo?</p>
        <div id="timer">
            <div class="container"  style="align-content: center;">
                <div id="hour" style="float: left;">00</div>
                <div class="divider" style="float: left;">:</div>
                <div id="minute" style="float: left;">00</div>
                <div class="divider" style="float: left;">:</div>
                <div id="second" style="float: left;">00</div>
            </div>
        
         </div>
      </div>
      <div class="modal-footer">
        <button id="btn-comenzar" class="btn-primary">Comenzar</button>
        <button type="button" class="btn-default" data-dismiss="modal">Cancelar</button>
        
      </div>
    </div>
  </div>
</div>
<iframe height="1800px"  width="1500px" src="http://app-peoplemarketing.com/Geoline-MiJugada/presentacion/consulta_seguimientos_vista_asesor.php"></iframe>

</body>


</html>
