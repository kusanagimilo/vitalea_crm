<?php

require_once '../include/script.php';
require_once '../include/header_administrador.php';
require_once '../clase/Seguimiento.php';

$seguimiento = new Seguimiento();

?>

<script type="text/javascript">
    $(document).ready(function () {
        $('select').select2();


        $("#prospectos").click(function () {
            if ($('#prospectos').prop('checked')) {
                $("#tipificaciones").prop("disabled", true);
                $("#fecha_inicial").prop("disabled", true);
                $("#fecha_final").prop("disabled", true);
            } else {
                $("#tipificaciones").prop("disabled", false);
                $("#fecha_inicial").prop("disabled", false);
                $("#fecha_final").prop("disabled", false);
            }
        });



        $("#checkTodos").change(function () {
            $("input:checkbox").prop('checked', $(this).prop("checked"));
        });


        $("#btn_filtro").click(function () {
            filtro_seguimiento();
        });

        $('#lista_clientes').DataTable();

        $("#btn_envio_masivo").click(function () {
            envioMasivo();

        });

    });

</script>
<script type="text/javascript" src="../ajax/seguimiento.js"></script>
<style type="text/css">
    .rtf-box {
  width:400px;
  height:190px;
  border:1px solid gray;
  overflow:hidden;
}

.rtf-tools {
  height:40px;
  background:#f0f0f0;
}

.rtf-tools img {
  height:30px;
  width:30px;
  margin-top:5px;
  margin-left:5px;
  cursor:pointer;
  border:1px solid #f0f0f0;
}

.rtf-tools img:hover {
  border:1px solid #ffffff;
  background:#f8f8f8;
  opacity:0.8;
}

.rtf-text {
  height:150px;
  padding:12px;
  box-sizing:border-box;
}

.rtf-text .emoji {
  height:20px;
  width:20px;
  vertical-align:bottom;
}

.rtf-box textarea {
}
</style>
<script type="application/javascript">
jQuery('input[type=file]').change(function(){
 var filename = jQuery(this).val().split('\\').pop();
 var idname = jQuery(this).attr('id');
 console.log(jQuery(this));
 console.log(filename);
 console.log(idname);
 jQuery('span.'+idname).next().find('span').html(filename);
});

</script>


<body style="background-color: #F6F8FA">

<div class="main-menu-area mg-tb-40">
<div class="container" style="height:auto;">
<div class="row">
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
<ol class="breadcrumb">
     <li><a href="inicio_administrador.php" title="Volver atras"><img src="images/atras.png"></a></li>
<li><a href="inicio_administrador.php" title="Inicio">Inicio</a></li>
<li><a href="seguimiento.php" title="Inicio">Asignacion Seguimientos</a></li>
<li class="active">Envio de Correos Masivos</li>
</ol>


<div class="panel panel-default">
<div class="panel-heading " style="height: 50px;">
<h3 class="panel-title"> 

 <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
<b  style="float: left">  <img src="images/email_correo.png" alt=""/> Envio de Correos Masivos </b>
</div>
<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4" style="text-align: right;">
<a href="seguimiento.php" class="btn btn-default"> <img src="images/seguimiento_p.png" alt=""/> Asignar Seguimientos </a>
</div> 
</h3>
</div>

<div class="panel-body" >
<p style="font-size: 11pt;">
<img src="images/info.png" alt=""/>
Seleccione las tipificaciones y rangos de fecha para realizar la busqueda de gestiones</p> 

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
<label> <img src="images/item.png"> Tipificaciones</label>
<select class="mdb-select md-form colorful-select dropdown-primary" multiple id="tipificaciones" style="width: 100%">
<?php
$lista_tipificaciones = $seguimiento->listar_tipificaciones();

foreach ($lista_tipificaciones as $value) {
?>
<option value="<?php echo $value["id"] ?>"><?php echo $value["macro_proceso"] . " - " . $value["nombre"] ?></option>
<?php } ?>
</select>
</div>


<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">

<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
<label> <img src="images/fecha.png"> Fecha Inicial</label>
<input name="fecha_inicial" id="fecha_inicial" type="date" class="form-control" placeholder="Fecha Inicial">
</div>
<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
<label> <img src="images/fecha.png"> Seleccione Fecha Final</label>
<input name="fecha_final" id="fecha_final" type="date" class="form-control" placeholder="Fecha Final">
</div>

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
<br>
<button class="btn btn-primary" id="btn_filtro" style="width: 100%">  <img src="images/lupa.png" style="width: 20px;"> Iniciar Búsqueda</button>
</div>
</div>
</div>
</div> 
</div>



<div id="div_usuarios" style="display: none;padding: 5px;">   
<div class="panel panel-default">

<div class="panel-body" >
<div class="panel-heading " style="height: 50px;">
<h3 class="panel-title"> 
<b style="float: left"><img src="images/lupa.png" style="width: 20px;">
Resultados de la busqueda</b> </h3>
</div> 

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-top: 10px;">    
<div id="resultados"></div> 
</div>
</div>
</div>

</div>
<div>
                                   	

<form enctype="multipart/form-data" class="formulario" id="formuploadajax" method="post" action="prueba_correos.php">
<input type="hidden" id="cliente_seleccionado" name="cliente_seleccionado">

 <div class="rtf-box" style="width: 100%; height: 300px; overflow: auto;">
 	<div class="rtf-tools">
 <b>&nbsp;&nbsp;Cuerpo de Correo</b>
</div>
<div class="rtf-text" contenteditable="true">


<textarea name="mensaje" id="mensaje" cols="12" rows="12" style="border: none; margin: 0px; width: 1115px; height: 205px; overflow:hidden;">

Buenos días

Nos comunicamos de parte de la empresa....

Gracias.


</textarea>
<br>
<center><div id="file-preview-zone" style="width: 700px; height: 500px;"></div> </center>
</div>
</div>
<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6" > 
seleccione una imagen para agregarla al cuerpo de el correo:<input id="file-upload" type="file" accept="image/*"  name="file-upload" />


</div>
<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6" > 
adjunto archivos: <input id="file-upload-archivos" type="file"   name="file-upload-archivos" />
</div>
<br><br>
&nbsp;&nbsp;&nbsp;&nbsp;<input id="cancelar" type="button" value="Eliminar fotos" class="btn btn-danger btn-sm" onClick="eliminar()"></input>
<br><br>
<center><button class="btn btn-primary"> ENVIAR CORREO  <img src="images/mensajes.png" alt=""/></button></center>





</form>
</div>
</div>
</div>
</div>
</div>
</div>

</body>
<script type="text/javascript">

    function readFile(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
 
            reader.onload = function (e) {
                var filePreview = document.createElement('img');
                filePreview.id = 'file-preview';
                //e.target.result contents the base64 data from the image uploaded
                filePreview.src = e.target.result;
                console.log(e.target.result);
 
                var previewZone = document.getElementById('file-preview-zone');
                previewZone.appendChild(filePreview);
            }
 
            reader.readAsDataURL(input.files[0]);
        }
    }
 
    var fileUpload = document.getElementById('file-upload');
    fileUpload.onchange = function (e) {
        readFile(e.srcElement);
    }

    function eliminar() {
 document.getElementById('file-preview-zone').innerHTML='';
 
 input=document.getElementById("file-upload");
        input.value = ''
}

$("#file-upload").change(function(){

});	



</script>

