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

<script src="../../ajax/gestion_usuario2.js" type="text/javascript"></script>

<script type="text/javascript">

   $(document).ready(function ()
{
		 
	 $("#buscar").click(function () {
	
     	var documento = $("#usuario_digiturno").val();

        $.ajax(
	{
		url:'../../controladores/consultas_usuario.php',

		data:
			{
				documento:documento             
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
    <li class="active" style="font-family: 'Open Sans', sans-serif; font-size:15px;">Reportes digiturno</li>
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
<p style=" font-size: 11pt;">&nbsp;&nbsp;&nbsp;<img src="../images/info.png" alt=""/>Seccione el usuario y de clic en buscar </p>
 </div>
<br>
<CENTER><label><H3><b>Reporte digiturno por modulos<b></H3></label></CENTER>
 <br>

 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label> <img src="../images/report.png"> Buscar usuario</label><br>
 <center>
 <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
<div class="form-group">
<div class="nk-int-st">
<select id="usuario_digiturno" style="width: 100%;" class="form-control" >
<option value=''> -- </option>
 </select>
</div>
  </div>
</div>
<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
    <div class="form-group" >
<button type="submit" class="btn btn-info notika-btn-success waves-effect" id="buscar" name="buscar" style="width: 100%;">
                                    
<img src="../images/lupa.png" alt="" style="width: 15px;"/>
Buscar</button> 
 </div>
</div>
</center>
    <br>
    <br>
    <br>
<center>

<div id="highcharts-9622e79c-4090-4c88-ab44-68dfcf60d353"></div><script>
(function(){ var files = ["https://code.highcharts.com/stock/highstock.js","https://code.highcharts.com/highcharts-more.js","https://code.highcharts.com/highcharts-3d.js","https://code.highcharts.com/modules/data.js","https://code.highcharts.com/modules/exporting.js","https://code.highcharts.com/modules/funnel.js","https://code.highcharts.com/6.0.2/modules/annotations.js","https://code.highcharts.com/modules/solid-gauge.js"],loaded = 0; if (typeof window["HighchartsEditor"] === "undefined") {window.HighchartsEditor = {ondone: [cl],hasWrapped: false,hasLoaded: false};include(files[0]);} else {if (window.HighchartsEditor.hasLoaded) {cl();} else {window.HighchartsEditor.ondone.push(cl);}}function isScriptAlreadyIncluded(src){var scripts = document.getElementsByTagName("script");for (var i = 0; i < scripts.length; i++) {if (scripts[i].hasAttribute("src")) {if ((scripts[i].getAttribute("src") || "").indexOf(src) >= 0 || (scripts[i].getAttribute("src") === "http://code.highcharts.com/highcharts.js" && src === "https://code.highcharts.com/stock/highstock.js")) {return true;}}}return false;}function check() {if (loaded === files.length) {for (var i = 0; i < window.HighchartsEditor.ondone.length; i++) {try {window.HighchartsEditor.ondone[i]();} catch(e) {console.error(e);}}window.HighchartsEditor.hasLoaded = true;}}function include(script) {function next() {++loaded;if (loaded < files.length) {include(files[loaded]);}check();}if (isScriptAlreadyIncluded(script)) {return next();}var sc=document.createElement("script");sc.src = script;sc.type="text/javascript";sc.onload=function() { next(); };document.head.appendChild(sc);}function each(a, fn){if (typeof a.forEach !== "undefined"){a.forEach(fn);}else{for (var i = 0; i < a.length; i++){if (fn) {fn(a[i]);}}}}var inc = {},incl=[]; each(document.querySelectorAll("script"), function(t) {inc[t.src.substr(0, t.src.indexOf("?"))] = 1; }); function cl() {if(typeof window["Highcharts"] !== "undefined"){var options={"chart":{"type":"pie","options3d":{"enabled":true,"alpha":45}},"title":{"text":"Turnos atendidos"},"subtitle":{"text":""},"plotOptions":{"pie":{"innerSize":100,"depth":45},"series":{"animation":false}},"series":[{"turboThreshold":0,"_colorIndex":0,"_symbolIndex":0}],"data":{"csv":"\"<font style=\"vertical-align: inherit;\"><font style=\"vertical-align: inherit;\">usuario</font></font>\";\"<font style=\"vertical-align: inherit;\"><font style=\"vertical-align: inherit;\">porcentaje</font></font>\"\n\"uno\";35\n\"dos\";15\n\"tres\";40\n\"cuatro\";10","googleSpreadsheetKey":false,"googleSpreadsheetWorksheet":false}};/*
// Sample of extending options:
Highcharts.merge(true, options, {
    chart: {
        backgroundColor: "#bada55"
    },
    plotOptions: {
        series: {
            cursor: "pointer",
            events: {
                click: function(event) {
                    alert(this.name + " clicked\n" +
                          "Alt: " + event.altKey + "\n" +
                          "Control: " + event.ctrlKey + "\n" +
                          "Shift: " + event.shiftKey + "\n");
                }
            }
        }
    }
});
*/new Highcharts.Chart("highcharts-9622e79c-4090-4c88-ab44-68dfcf60d353", options);}}})();
</script>
</center>
<br><br><table style="width:99%; margin:auto auto;" rules="none" id="tablas" class="table table-striped"></table>
</div>
</div>
</div>
<br><br>
</body>
<?php require_once '../../include/footer.php'; ?>
</html>
