<?php
require_once '../../include/script2.php';
require_once '../../include/header_administrador2.php';


$array_permisos = explode(",", $_SESSION['PERMISOS']);
$conteo = count($array_permisos);

if ($conteo == 1) {
    if (in_array("1", $array_permisos)) { // PERMISO CALL CENTER
        $permiso = 1;
    } else if (in_array("2", $array_permisos)) { //PERMISO PRESENCIAL
        $permiso = 2;
    } else if (in_array("6", $array_permisos)) { //PERMISO DIGITURNO
        $permiso = 3;
    }
}?>


<script type="text/javascript">

   $(document).ready(function ()
{
     
  
  

        $.ajax(
  {
    url:'../../controladores/cotizacion.php',

    data:
      {
        tipo:1             
      },
    type: 'post',
    
    beforeSend: function ()
      {
        $("#tablas").html("Procesando, espere por favor");
      },
    success: function(data)
      {
        $('#tablas').html(data);
      }
  });


   $("#buscar").click(function () {
    
      var fecha = $("#fecha").val();
      alert(fecha);
  

        $.ajax(
  {
    url:'../../controladores/cotizacion.php',

    data:
      {
        tipo2:2,
       fecha:fecha           
      },
    type: 'post',
    
    beforeSend: function ()
      {
        $("#tablas").html("Procesando, espere por favor");
      },
    success: function(data)
      {
        $('#tablas').html(data);
      }
  });
});

});
</script>

<body style="background-color: #f5f5f5;">
<nav class="navbar navbar-default">
     <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <ol class="breadcrumb">
    <li><a  href="../inicio_administrador.php"  class="nounderline"  title="Volver atras"><img src="../images/atras.png"></a></li>
    <li><a href="../inicio_administrador.php"  title="Inicio" style=" color: #337ab7;
    text-decoration: none; font-family: 'Open Sans', sans-serif; font-size:15px;
    line-height: 30px;">Inicio</a></li>
    <li class="active" style="font-family: 'Open Sans', sans-serif; font-size:15px;">Cotizaciones</li>
    </ol></div>   
    
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#">
          <img src="../images/graficos.png">
      </a>
    </div>
    <ul class="nav navbar-nav">
      <li><a href="reportes.php"><img src="../images/icon_report.png" style="height:24px; width:24px;"><b>Reportes digiturno</b></a></li>
      <li><a href="../tablas_informe.php"><img src="../images/tablas.png" style="height:24px; width:24px;"><b>Tablas</b></a></li>
      <li><a href="reportes_cotizaciones.php"><img src="../images/cotizacion.png"><b>Cotizaciones</b></a></li>
      <li><a href="#"> <img src="../images/seguimiento_chart.png"><b>Seguimientos </b></a></li>
      <li><a href="#"><img src="../images/venta_chart.png"> <b>Ventas</b></a></li>
     
      
    </ul>
  </div>
</nav>
<div class="main-menu-area mg-tb-40" style="min-height: 400px;">
<div class="container" style="height:auto;">
<div class="panel panel-default">
<div class="panel-heading " style="height: 50px;">
<p style=" font-size: 11pt;">&nbsp;&nbsp;&nbsp;<img src="../images/info.png" alt=""/> Busqueda de cotzaciones por fecha</p>
 </div>
 <br>
 <CENTER><label><H3><b>Reporte cotizaciones<b></H3></label></CENTER>
<br>
&nbsp;&nbsp;&nbsp;<label> <img src="../images/fecha.png">Busqueda por fecha</label>
<br>
<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">   
<input name="fecha" id="fecha" type="date" class="form-control" placeholder="Fecha">
</div>
<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12"> 
 
<button class="btn btn-primary" id="buscar" name="buscar" style="width: 100%">  <img src="../images/lupa.png" style="width: 20px;"> Iniciar Búsqueda</button>
</div>
<br>
<br><br>
<table style="width:99%; margin:auto auto;" rules="none" id="tablas" class="table table-striped"></table>
<br>
</div>
</div>
</div>
<br>
</body>
<?php require_once '../../include/footer.php'; ?>
</html>