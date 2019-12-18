<?php
require_once '../clase/Usuario.php';

$documento = $_POST["documento"];

$Usuario = new Usuario();

$id = $Usuario->consultar_usuario($documento);
$cantidad_turnos = $Usuario->cantidad_turnos_atendidos($id);
$nombre_completo = $Usuario->nombre_completo($id);

if ($cantidad_turnos >0) {

$modulo1 ='1';
$modulo2 ='2';
$modulo3 ='3';
$modulo4 ='4';

$cant_modulo1 = $Usuario->cantidad_turnos_modulo1($id,$modulo1);

$cant_modulo2 = $Usuario->cantidad_turnos_modulo2($id,$modulo2);

$cant_modulo3 = $Usuario->cantidad_turnos_modulo3($id,$modulo3);

$cant_modulo4 = $Usuario->cantidad_turnos_modulo4($id,$modulo4);

?>
<center>
<div id="highcharts-46231b53-12e2-4b4a-903a-3c29c7544f7c"></div><script>
(function(){ var files = ["https://code.highcharts.com/stock/highstock.js","https://code.highcharts.com/highcharts-more.js","https://code.highcharts.com/highcharts-3d.js","https://code.highcharts.com/modules/data.js","https://code.highcharts.com/modules/exporting.js","https://code.highcharts.com/modules/funnel.js","https://code.highcharts.com/6.0.2/modules/annotations.js","https://code.highcharts.com/modules/solid-gauge.js"],loaded = 0; if (typeof window["HighchartsEditor"] === "undefined") {window.HighchartsEditor = {ondone: [cl],hasWrapped: false,hasLoaded: false};include(files[0]);} else {if (window.HighchartsEditor.hasLoaded) {cl();} else {window.HighchartsEditor.ondone.push(cl);}}function isScriptAlreadyIncluded(src){var scripts = document.getElementsByTagName("script");for (var i = 0; i < scripts.length; i++) {if (scripts[i].hasAttribute("src")) {if ((scripts[i].getAttribute("src") || "").indexOf(src) >= 0 || (scripts[i].getAttribute("src") === "http://code.highcharts.com/highcharts.js" && src === "https://code.highcharts.com/stock/highstock.js")) {return true;}}}return false;}function check() {if (loaded === files.length) {for (var i = 0; i < window.HighchartsEditor.ondone.length; i++) {try {window.HighchartsEditor.ondone[i]();} catch(e) {console.error(e);}}window.HighchartsEditor.hasLoaded = true;}}function include(script) {function next() {++loaded;if (loaded < files.length) {include(files[loaded]);}check();}if (isScriptAlreadyIncluded(script)) {return next();}var sc=document.createElement("script");sc.src = script;sc.type="text/javascript";sc.onload=function() { next(); };document.head.appendChild(sc);}function each(a, fn){if (typeof a.forEach !== "undefined"){a.forEach(fn);}else{for (var i = 0; i < a.length; i++){if (fn) {fn(a[i]);}}}}var inc = {},incl=[]; each(document.querySelectorAll("script"), function(t) {inc[t.src.substr(0, t.src.indexOf("?"))] = 1; }); function cl() {if(typeof window["Highcharts"] !== "undefined"){Highcharts.setOptions({lang:{"downloadPNG":"Download PNG image","downloadJPEG":"Download JPEG imaged PNG image"}});var options={"chart":{"inverted":true,"polar":false,"type":"column","width":1080,"height":370,"borderColor":"#f5f5f5","backgroundColor":"#f5f5f5","borderWidth":0,"borderRadius":0,"plotBackgroundColor":"#fafafa","plotBorderColor":"#f5f5f5"},"plotOptions":{"series":{"stacking":"normal","dataLabels":{"enabled":true},"animation":true}},"series":[{"turboThreshold":0,"_colorIndex":0,"_symbolIndex":0,"type":"column","marker":{}},{"turboThreshold":0,"_colorIndex":1,"_symbolIndex":0}],"xAxis":[{"type":"category","uniqueNames":false,"title":{},"labels":{}}],"data":{"csv":"\"<font style=\"vertical-align: inherit;\"><font style=\"vertical-align: inherit;\">modulos</font></font>\";\"<font style=\"vertical-align: inherit;\"><font style=\"vertical-align: inherit;\">usuario</font></font>\";\"<font style=\"vertical-align: inherit;\"><font style=\"vertical-align: inherit;\">Columna 3</font></font>\"\n\"modulo 1\";<?php echo $cant_modulo1 ;  ?>;\n\"modulo 2\";<?php echo $cant_modulo2 ;  ?>;\n\"modulo 3\";<?php echo $cant_modulo3 ;  ?>;\n\" modulo 4\";<?php echo $cant_modulo4 ;  ?>;","googleSpreadsheetKey":false,"googleSpreadsheetWorksheet":false},"title":{"text":"<?php echo'<b>TURNOS ATENDIDOS POR MODULO</b>';?>","style":{"fontFamily":"Monaco","color":"#333333","fontSize":"18px","fontWeight":"normal","fontStyle":"normal"}},"yAxis":[{"allowDecimals":false,"title":{"text":"Units"},"labels":{}}],"subtitle":{"text":"usuario : <?php echo $nombre_completo ;  ?>","style":{"fontFamily":"Monospace","color":"#666666","fontSize":"12px","fontWeight":"normal","fontStyle":"normal"}},"colors":["#81d4fa","#434348","#ad1457","#00e676"],"lang":{"downloadPNG":"Download PNG image","downloadJPEG":"Download JPEG imaged PNG image"},"exporting":{"sourceWidth":10,"scale":4},"chartarea":{},"plotarea":{},"tooltip":{"enabled":true},"credits":{},"legend":{"enabled":false,"layout":"horizontal","align":"center","verticalAlign":"bottom","floating":false}};/*
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
<br>
<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">   
 <div class="color-single nk-teal">
 <?php
echo "La cantidad total de turnos atendidos por ".$nombre_completo." es : <span class='badge' id='conteo_call_center'><b>".$cantidad_turnos."</b></span>" ;
?>
</div>
</div>
<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12"></div>
<br><br><br><br>


<div class="panel panel-default">
                        <div style="height: 50px;border-bottom:1px solid #00c292;padding: 10px; ">
                            <a href="#collapse1" id="colapsible_basico" style=" text-decoration: none; color: black;">
                                 <h4 style="color:#00c292;">
                                   
                                     <img src="../images/basico.png" alt="" style="width: 20px;">  Datos básicos 
                                     </h4> 
                                 
                                </a>
                        </div>
                        <div id="collapse1" class="panel-collapse collapse" style="display: block;">
                            <div class="panel-body">
                                <div class="cta-desc">

                      
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            
                                            <div class="nk-int-st">
                                                <input name="tipo_cliente" type="radio" value="Titular" class="i-checks" checked=""> Titular
                                                <input name="tipo_cliente" type="radio" value="Tercero" class="i-checks"> Tercero
                                            </div>
                                        </div>
                                    </div>
                                                    
                                      
                              
                                         <p style=" font-size: 11pt;"><img src="images/info.png" alt="">
                                                      Informacion del Titular</p> 

                              
                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                        <div class="form-group">
                                            <label>Tipo de documento</label>
                                            <div class="nk-int-st">
                                                <select id="tipo_documento" style="width: 100%;" class="form-control select2-hidden-accessible" data-select2-id="tipo_documento" tabindex="-1" aria-hidden="true">
                                                    <optgroup label="Actual">
                                                        <option value="1" data-select2-id="2">Cédula de Ciudadania</option>
                                                    </optgroup>
                                                </select><span class="select2 select2-container select2-container--default" dir="ltr" data-select2-id="1" style="width: 100%;"><span class="selection"><span class="select2-selection select2-selection--single" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-labelledby="select2-tipo_documento-container"><span class="select2-selection__rendered" id="select2-tipo_documento-container" role="textbox" aria-readonly="true" title="Cédula de Ciudadania">Cédula de Ciudadania</span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                        <div class="form-group">
                                             <label>Numero documento</label>
                                            <div class="nk-int-st">
                                                <input type="text" class="form-control" id="numero_documento" value="101121211">
                                              </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                        <div class="form-group">
                                             <label>Nombres</label>
                                            <div class="nk-int-st">
                                                <input type="text" class="form-control" id="nombre" value="prueba25">
                                             </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                        <div class="form-group">
                                             <label>Apellidos</label>
                                            <div class="nk-int-st">
                                                <input type="text" class="form-control" id="apellido" value="prueba25">
                                            </div>
                                        </div>
                                    </div>
          

                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                        <div class="form-group">
                                             <label>Fecha de nacimiento</label>
                                            <div class="nk-int-st">
                                                <input type="date" class="form-control" id="fecha_nacimiento" value="1990-03-26">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                        <div class="form-group">
                                             <label>Telefono 1</label>
                                            <div class="nk-int-st">
                                                <input name="telefono_uno" id="telefono_uno" class="form-control" type="text" value="7212121">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                        <div class="form-group">
                                            <label>Telefono 2</label>
                                            <div class="nk-int-st">
                                                <input name="telefono_dos" id="telefono_dos" class="form-control" type="text" value="">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                        <div class="form-group">
                                            <label>Correo electrónico</label>
                                            <div class="nk-int-st">
                                                <input name="email" id="email" class="form-control" type="text" value="soporte@peoplecontact.cc">
                                             </div>
                                        </div>
                                    </div>
                                </div>
                                       
                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                        <div class="form-group">
                                            <label>Género</label>
                                            <div class="nk-int-st">
                                                <select id="sexo" style="width: 100%;" class="form-control select2-hidden-accessible" data-select2-id="sexo" tabindex="-1" aria-hidden="true">
                                                    <optgroup label="Actual">
                                                        <option value="Masculino" data-select2-id="4">Masculino</option>
                                                    </optgroup>
                                                    <optgroup label="Actualizar">
                                                        <option value="Femenino">Femenino</option>
                                                        <option value="Masculino">Masculino</option>
                                                    </optgroup>
                                                </select><span class="select2 select2-container select2-container--default" dir="ltr" data-select2-id="3" style="width: 100%;"><span class="selection"><span class="select2-selection select2-selection--single" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-labelledby="select2-sexo-container"><span class="select2-selection__rendered" id="select2-sexo-container" role="textbox" aria-readonly="true" title="Masculino">Masculino</span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                        <div class="form-group">
                                            <label>Estado civil</label>
                                            <div class="nk-int-st">
                                                <select id="estado_civil" style="width: 100%;" class="form-control select2-hidden-accessible" data-select2-id="estado_civil" tabindex="-1" aria-hidden="true">
                                                    <optgroup label="Actual">
                                                        <option value="2" data-select2-id="6">Soltero</option>
                                                    </optgroup>
                                                <option value="1">Casado</option><option value="2">Soltero</option><option value="3">Viudo</option><option value="4">Union libre</option><option value="5">Divorciado</option><option value="6">No aplica</option></select><span class="select2 select2-container select2-container--default" dir="ltr" data-select2-id="5" style="width: 100%;"><span class="selection"><span class="select2-selection select2-selection--single" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-labelledby="select2-estado_civil-container"><span class="select2-selection__rendered" id="select2-estado_civil-container" role="textbox" aria-readonly="true" title="Soltero">Soltero</span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>
                                            </div>
                                        </div>
                                    </div>
                            </div> 
                        </div>
                    </div>
<?php
}elseif ($cantidad_turnos ==0) {
	echo "Este usuario no tiene turnos atendidos";
}
?>


