<?php  
require_once '../clase/Usuario.php';

$cotizacion = new Usuario();
$cantidad_cotizaciones = $cotizacion->cantidad_cotizaciones();


$tipo= $_POST["tipo"];
$tipo2= $_POST["tipo2"];
$fecha= $_POST["fecha"];


?>	
<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">   
 <div class="color-single nk-teal">
 <?php
echo "La cantidad de cotizaciones realizadas es : <span class='badge' id='cantida_cotizacion'><b>".$cantidad_cotizaciones."</b></span>" ;
?>
</div>
</div>
<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12"></div>
<br><br><br><br>
<center>
<div id="highcharts-46231b53-12e2-4b4a-903a-3c29c7544f7c"></div><script>
(function(){ var files = ["https://code.highcharts.com/stock/highstock.js","https://code.highcharts.com/highcharts-more.js","https://code.highcharts.com/highcharts-3d.js","https://code.highcharts.com/modules/data.js","https://code.highcharts.com/modules/exporting.js","https://code.highcharts.com/modules/funnel.js","https://code.highcharts.com/6.0.2/modules/annotations.js","https://code.highcharts.com/modules/solid-gauge.js"],loaded = 0; if (typeof window["HighchartsEditor"] === "undefined") {window.HighchartsEditor = {ondone: [cl],hasWrapped: false,hasLoaded: false};include(files[0]);} else {if (window.HighchartsEditor.hasLoaded) {cl();} else {window.HighchartsEditor.ondone.push(cl);}}function isScriptAlreadyIncluded(src){var scripts = document.getElementsByTagName("script");for (var i = 0; i < scripts.length; i++) {if (scripts[i].hasAttribute("src")) {if ((scripts[i].getAttribute("src") || "").indexOf(src) >= 0 || (scripts[i].getAttribute("src") === "http://code.highcharts.com/highcharts.js" && src === "https://code.highcharts.com/stock/highstock.js")) {return true;}}}return false;}function check() {if (loaded === files.length) {for (var i = 0; i < window.HighchartsEditor.ondone.length; i++) {try {window.HighchartsEditor.ondone[i]();} catch(e) {console.error(e);}}window.HighchartsEditor.hasLoaded = true;}}function include(script) {function next() {++loaded;if (loaded < files.length) {include(files[loaded]);}check();}if (isScriptAlreadyIncluded(script)) {return next();}var sc=document.createElement("script");sc.src = script;sc.type="text/javascript";sc.onload=function() { next(); };document.head.appendChild(sc);}function each(a, fn){if (typeof a.forEach !== "undefined"){a.forEach(fn);}else{for (var i = 0; i < a.length; i++){if (fn) {fn(a[i]);}}}}var inc = {},incl=[]; each(document.querySelectorAll("script"), function(t) {inc[t.src.substr(0, t.src.indexOf("?"))] = 1; }); function cl() {if(typeof window["Highcharts"] !== "undefined"){Highcharts.setOptions({lang:{"downloadPNG":"Download PNG image","downloadJPEG":"Download JPEG imaged PNG image"}});var options={"chart":{"inverted":true,"polar":false,"type":"column","width":1080,"height":370,"borderColor":"#f5f5f5","backgroundColor":"#f5f5f5","borderWidth":0,"borderRadius":0,"plotBackgroundColor":"#fafafa","plotBorderColor":"#f5f5f5"},"plotOptions":{"series":{"stacking":"normal","dataLabels":{"enabled":true},"animation":true}},"series":[{"turboThreshold":0,"_colorIndex":0,"_symbolIndex":0,"type":"column","marker":{}},{"turboThreshold":0,"_colorIndex":1,"_symbolIndex":0}],"xAxis":[{"type":"category","uniqueNames":false,"title":{},"labels":{}}],"data":{"csv":"\"<font style=\"vertical-align: inherit;\"><font style=\"vertical-align: inherit;\">modulos</font></font>\";\"<font style=\"vertical-align: inherit;\"><font style=\"vertical-align: inherit;\">usuario</font></font>\";\"<font style=\"vertical-align: inherit;\"><font style=\"vertical-align: inherit;\">Columna 3</font></font>\"\n\"modulo 1\";10;\n\"modulo 2\";45\n\"modulo 3\";54\n\" modulo 4\";23","googleSpreadsheetKey":false,"googleSpreadsheetWorksheet":false},"title":{"text":"<?php echo'<b>COTIZACIONES</b>';?>","style":{"fontFamily":"Monaco","color":"#333333","fontSize":"18px","fontWeight":"normal","fontStyle":"normal"}},"yAxis":[{"allowDecimals":false,"title":{"text":"Units"},"labels":{}}],"subtitle":{"text":"usuario :   ?>","style":{"fontFamily":"Monospace","color":"#666666","fontSize":"12px","fontWeight":"normal","fontStyle":"normal"}},"colors":["#F67E46","#434348","#ad1457","#00e676"],"lang":{"downloadPNG":"Download PNG image","downloadJPEG":"Download JPEG imaged PNG image"},"exporting":{"sourceWidth":10,"scale":4},"chartarea":{},"plotarea":{},"tooltip":{"enabled":true},"credits":{},"legend":{"enabled":false,"layout":"horizontal","align":"center","verticalAlign":"bottom","floating":false}};/*
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
*/new Highcharts.Chart("highcharts-46231b53-12e2-4b4a-903a-3c29c7544f7c", options);}}})();
</script>
</center>


<?php


if ($tipo2 == 2) {
	
	$filtro = $cotizacion->filtro_cotizacion($fecha);

	if(!empty($filtro)){
        echo '<table class="table table-striped" id="lista_clientes">
                                        <thead>
                                            <tr style="background-color: #214761;">
                                                <th  style="color:white"><input type="checkbox" id="checkTodos" /></th>
                                                <th  style="color:white"> Fecha Gestión </th>
                                                <th  style="color:white"> Usuario </th>
                                                <th  style="color:white"> Documento</th>
                                                <th  style="color:white"> Paciente</th>
                                         
                                            </tr>
                                        </thead>
                                        <tbody>';
            foreach ($resultado as $dato){
                    echo '<tr>
                            <td> <input class="asignacion" type="checkbox" name="asignacion[]" value="'.$dato["id"].'" id="seleccion"></td>
                            <td>'.$dato["gestion_id"].'</td>
                            <td>'.$dato["cliente_id"].'</td>
                            <td>'.$dato["usuario_id"].'</td>
                            <td>'.$dato["fecha_cotizacion"].'</td>
                          
                        </tr>';                       
            } 
        echo '</tbody></table>';        
    }else{
       echo "<center> <p><b> No hay resultados asociados a la búsqueda  </b></p>  </center>";
    }
}

?>