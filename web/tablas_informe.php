<?PHP require_once '../include/script.php';
require_once '../include/header_administrador.php';

?>

<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/series-label.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<!--
<script type="text/javascript">

   $(document).ready(function ()
{
     
   $("#Gestiones").click(function () {


 $.ajax({
                url: 'descargar_reporte.php',
                data:
                        {
                            reporte:1
                        },
                type: 'post',
                success: function()
      {
        document.location.href='descargar_reporte.php';
      }
            });
});

});
</script>
-->
<style type="text/css">
    #container ,#container_tres {
    height: 300px;width: 50%;
    float: left;
    padding: 20px;
    background-color: #F6F8FA;
}

 #container_dos,#container_cuatro {
    height: 300px;
    width: 50%;
    float: right;
    padding: 20px;
    background-color: #F6F8FA;
}
  #container_principal{
    /* F6F8FA*/
    background-color: #F6F8FA;
     padding: 20px;
  }

  nav {
  display: block;
}
</style>
<body style="background-color: #F6F8FA">
<nav class="navbar navbar-default">
     <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <ol class="breadcrumb">
    <li><a  href="inicio_administrador.php"  class="nounderline"  title="Volver atras"><img src="images/atras.png"></a></li>
    <li><a href="inicio_administrador.php"  title="Inicio" style=" color: #337ab7;
    text-decoration: none; font-family: 'Open Sans', sans-serif; font-size:15px;
    line-height: 30px;">Inicio</a></li>
    <li class="active" style="font-family: 'Open Sans', sans-serif; font-size:15px;">Tablas</li>
    </ol></div>   
    
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#">
          <img src="images/graficos.png">
      </a>
    </div>
    <ul class="nav navbar-nav">
       <li><a href="reportes/reportes.php"><img src="images/icon_report.png" style="height:24px; width:24px;"><b>Reportes digiturno</b></a></li>
      <li><a href="tablas_informe.php"><img src="images/tablas.png" style="height:24px; width:24px;"><b>Tablas</b></a></li>
      <li><a href="reportes/reportes_cotizaciones.php"><img src="images/cotizacion.png"><b>Cotizaciones</b></a></li>
      <li><a href="#"> <img src="images/seguimiento_chart.png"><b>Seguimientos </b></a></li>
      <li><a href="#"><img src="images/venta_chart.png"> <b>Ventas</b></a></li>
    </ul>
  </div>
</nav>

    <!--<div class="main-menu-area mg-tb-40">
        <div class="container" style="height:auto;">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                   <iframe style="width:100%; height:100%" src="http://172.16.20.133:8081/scriptcase/app/crm_colcan/menu/?nmgp_outra_jan=true&nmgp_start=SC&script_case_session=83mpraf2kh5ek2pmhr5i88q5a2&5916#"></iframe>
                </div>   
            </div>
        </div>
    </div>  -->
<div class="main-menu-area mg-tb-40" style="min-height: 400px;">
<div class="container" style="height:auto;">
<div class="panel panel-default">

 <div class="panel-heading " style="height: 50px;">
<p style=" font-size: 11pt;">&nbsp;&nbsp;&nbsp;<img src="images/info.png" alt=""/>De clic en el boton para descargar el reporte </p>
 </div> 
<br>
<CENTER><label><H3><b>Reporte tablas para descarga<b></H3></label></CENTER>
<br>
<nav class="navbar navbar-default">
<ul class="nav navbar-nav">
<li class="active">
<form action="descargar_reporte.php" method="post">
<input type="hidden" name="reporte" id="reporte" value="1">
<button class="btn btn-success" id="gestiones" style="float: right;"><img src="images/excel.png">  &nbsp; &nbsp;Gestiones</button>
</form>
</li>
<li class="active">
 &nbsp; &nbsp;
</li>
<li class="active">
 <form action="descargar_reporte.php" method="post">
<input type="hidden" name="reporte" id="reporte" value="2">
<button class="btn btn-success" id="gestiones" style="float: right;"><img src="images/excel.png">  &nbsp; &nbsp;Clientes</button>
</form> 
</li>
<li class="active">
 &nbsp; &nbsp;
</li>
<li class="active">
<form action="descargar_reporte.php" method="post">
<input type="hidden" name="reporte" id="reporte" value="3">
<button class="btn btn-success" id="gestiones" style="float: right;"><img src="images/excel.png">  &nbsp; &nbsp;Clientes prospecto</button>
</form>    
</li>
<li class="active">
 &nbsp; &nbsp;
</li>
<li class="active">
<form action="descargar_reporte.php" method="post">
<input type="hidden" name="reporte" id="reporte" value="4">
<button class="btn btn-success" id="gestiones" style="float: right;"><img src="images/excel.png">  &nbsp; &nbsp;Cotizaciones</button>
</form>
</li>
<li class="active"></li>
<li class="active"></li>
</ul>
</nav>
</div>
</div>
</div>
<?php require_once '../include/footer.php'; ?>

</body>

</html>