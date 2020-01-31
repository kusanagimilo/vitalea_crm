<?PHP //require_once '../include/script.php';
require_once '../include/script.php';
require_once '../include/header_administrador.php';

require_once '../clase/Gestion.php';
require_once '../clase/Cliente.php';

$gestion = new Gestion();
$cliente = new Cliente();

$gestion_id = base64_decode($_REQUEST["id"]);

$id_cliente = $gestion->gestion_cliente_id($gestion_id);


$clasificacion_id = $gestion->clasificacion_paciente($id_cliente);
$guion = $gestion->guion($clasificacion_id);

$informacion_terceros = $cliente->consultar_tercero_titular($id_cliente);

$array_permisos = explode(",", $_SESSION['PERMISOS']);
$conteo = count($array_permisos);

if ($conteo == 1) {
    if (in_array("1", $array_permisos)) { // PERMISO CALL CENTER
        $permiso = 1;

    } else if (in_array("2", $array_permisos)) { //PERMISO PRESENCIAL
        $permiso = 2;
    }
    else if (in_array("5", $array_permisos)) { //PERMISO ADMINISTRADOR
        $permiso = 5;
    }

}

 $registro_nuevo = $gestion->gestion_cliente_nuevo(date('Y-m-d'),$id_cliente);

 $callback = $_REQUEST["callback"];

if (isset($callback)) {
   $callback = $_REQUEST["callback"];
}
else{
     $callback = 0;
}

?>
<style type="text/css">
     @media screen and (max-width: 800px) {
    
    /* Desaparecer el header */
      table.tinfo thead, th {
         border: none;
         clip: rect(0, 0, 0, 0);
         height: 1px;
         margin: -1px;
         overflow: hidden;
         padding: 0;
         position: absolute;
         width: 1px;
      }

    table.tinfo tr{
     border-bottom: 3px solid; 
   }

   table.tinfo td {
    border-bottom: 1px solid #ddd;
    display: block;
    font-size: 1.2em;
    text-align: right;
    padding: 10px;
  }
  table.tinfo th {
    border-bottom: 1px solid #ddd;
    display: block;
    font-size: 1.2em;
    text-align: right;
    padding: 10px;
  }
  table.tinfo td:before{
    content: attr(data-label);
    float: left;
    color: #273b47;
    font-weight: bold;
    font-size: 1em;
    padding: 1px 5px;
  }
  

  /* Desaparecer el header */
      table.tabla_terceros thead, th {
         border: none;
         clip: rect(0, 0, 0, 0);
         height: 1px;
         margin: -1px;
         overflow: hidden;
         padding: 0;
         position: absolute;
         width: 1px;
      }

    table.tabla_terceros tr{
     border-bottom: 3px solid; 
   }

   table.tabla_terceros td {
    border-bottom: 1px solid #ddd;
    display: block;
    font-size: 1.2em;
    text-align: right;
    padding: 10px;
  }
  table.tabla_terceros th {
    border-bottom: 1px solid #ddd;
    display: block;
    font-size: 1.2em;
    text-align: right;
    padding: 10px;
  }
  table.tabla_terceros td:before{
    content: attr(data-label);
    float: left;
    color: #273b47;
    font-weight: bold;
    font-size: 1em;
    padding: 1px 5px;
  }
}

</style>
<script>
    $(document).ready(function ()
    {
        window.location.hash="no-back-button";
        window.location.hash="Again-No-back-button";//esta linea es necesaria para chrome
        window.onhashchange=function(){window.location.hash="no-back-button";}

        $('#info').DataTable( {
                responsive: true
            } );

    $('select').select2();
    listar_macro_proceso();
     medios_comunicacion();
    informacion_cliente();
   

    $('#historico').DataTable();

    $("#macro_proceso").change(function () {
        listar_tipificaciones();
    });
    
    $("#tipificaciones").change(function () {
        var tipificacion_id = $("#tipificaciones").val();

        if(tipificacion_id == 76){
            $.blockUI({ message: $('#myModalProgramarLlamada') });
        }
    });
    
    $("#medios_comunicacion").change(function () {
        div_medio_comunicacion();
    });

    $("#btn_ir_caja").click(function () {
        var gestion_id = $("#gestion_id_encode").val();
       
        window.location.href = "ventas.php?id=" + gestion_id;
    });
   
        $('select').select2();
        $(".atras").click(function () {
            var usuario_id = $("#usuario").val();
            var id_cliente = $("#id_cliente").val();
            var gestion_id = $("#gestion_id").val(); 

            $.ajax({
                url: '../controladores/Gestion.php',
                data:
                        {
                            tipo:27,
                            gestion_id:gestion_id,
                            id_cliente: id_cliente,
                            usuario_id: usuario_id
                        },
                type: 'post',
                success: function (data)
                { 
                   window.location.href = "../web/inicio_usuario.php";
                }
            });
        });
        //Programar llamada

        $("#btn_programar_llamada").click(function () {
                var fecha_programada = $("#fecha_programada").val();
                var hora_programada = $("#hora_programada").val();

                $("#fecha_programada_copia").val(fecha_programada);
                $("#hora_programada_copia").val(hora_programada);

                $('#myModalProgramarLlamada').modal('hide');
                $.unblockUI();

        });

        $(".guardar_gestion").click(function () {
            var macro_proceso = $("#macro_proceso").val();
            var tipificacion_id = $("#tipificaciones").val();
            var callback = $("#callback").val();
            
            var gestion_id = $("#gestion_id").val(); 
            var usuario_id = $("#usuario").val();
            var id_cliente = $("#id_cliente").val();
            
            var observacion = $("#observacion").val();

            var permiso = $("#permiso").val();

            var medios_comunicacion = "";
            var mensaje = "";
            var fecha_programada = "";
            var hora_programada = "";
           
            if(permiso == 1){
                medios_comunicacion = $("#medios_comunicacion").val();

                if(medios_comunicacion.length == 0){
                    alertify.alert("Seleccione el medio de comunicacion");
                    return false;
                }
                if(medios_comunicacion < 8){
                        mensaje = $("#mensaje").val();
                }
            }else{
                medios_comunicacion= 11;
            }

            if(tipificacion_id == ""){
                alertify.alert("Realice la calificacion antes de guardar la gestión");
                    return false;
            }
            if(macro_proceso == ""){
                alertify.alert("Realice la calificacion antes de guardar la gestión");
                    return false;
            }

            if(tipificacion_id == 76 ){
                fecha_programada = $("#fecha_programada_copia").val();

                hora_programada = $("#hora_programada_copia").val();

                if(fecha_programada == ""){
                    alertify.alert("Ingrese la fecha y hora para volver a llamar");
                    return false;
                }

            }

            $.ajax({
                url: '../controladores/GuardarGestion.php',
                data:
                        {
                            id_cliente: id_cliente,
                            tipificacion_id: tipificacion_id,
                            medios_comunicacion: medios_comunicacion,
                            gestion_id:gestion_id,
                            usuario_id: usuario_id,
                            observacion:observacion,
                            mensaje:mensaje,
                            fecha_programada:fecha_programada,
                            hora_programada:hora_programada,
                            callback:callback
                        },
                type: 'post',
                success: function (data)
                {
                    alertify.alert('Gestion ingresada',
                            function () {
                                window.location.href = "../web/inicio_usuario.php";
                            });
                }
            });
        });
        
        
         VerListaResultados($("#id_cliente").val());

    });

</script>
<script src="https://malsup.github.io/jquery.blockUI.js"></script>
<script src="../ajax/Gestion.js" ></script>
<script src="../include/constante.js" ></script>
<script src="../ajax/Resultado.js" ></script>
<!-- <script src="../ajax/venta.js" ></script>-->
<body style="background-color: #F6F8FA; " >
<input type="hidden" id="callback" value="<?php echo $callback ?>">
<input type="hidden" id="permiso" value="<?php echo $permiso ?>">
<input type="hidden" id="gestion_id" value="<?php echo $gestion_id ?>">
<input name="id_cliente" id="id_cliente" value="<?php echo $id_cliente; ?>" type="hidden">
<input id="gestion_id_encode" value="<?php echo base64_encode($gestion_id) ?>" type="hidden">

<!-- Campos programar llamada-->
<input type="hidden" id="fecha_programada_copia">
<input type="hidden" id="hora_programada_copia">


    <div class="main-menu-area mg-tb-40" style="height:auto; min-height: 1900px;">

        <div class="container" style="height:auto;">
            <div class="row">
                <ol class="breadcrumb">
                        <li><a class="atras" title="Volver atras"><img src="images/atras.png"></a></li>
                       
                        <li><a class="atras"  title="Inicio">Inicio</a></li>
                        <li class="active">Gestión</li>

                     
                    </ol>
                
                <div class="panel panel-default">

                <div class="panel-heading ">
                    <div class="row">
                         <?php  if($registro_nuevo== 1){ ?>
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12" style="float: right;margin-right: 5px;">      
                           <button class="btn btn-primary"  id="btn_ir_caja" >
                                <img src="images/pdf_pequenio.png" alt="" style="width: 20px;"/>
                                Generar Cotizaci&oacute;n o Venta</button>
                         </div>       
                       <?php  } ?>  
                    </div>    
                </div>    

                <div class="panel-heading ">
                    <div class="row">
                         <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12"> 
                              <h3 class="panel-title">
                            <b  style="float: left">  <img src="images/gestion_llamada.png" alt=""/> 
                            Gestión</b> </h3>
                        </div>
                        
                        
                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <button class="btn btn-primary guardar_gestion"  style="float: right;margin-right: 5px;">
                                <img src="images/guardar.png" alt="" style="width: 20px;"/>
                                Guardar gesti&oacute;n</button>
                       
                            <a class="atras" style="float: right;margin-right: 5px;" >
                                <button class="btn btn-default">
                                <img src="images/cerrar.png" alt="" style="width: 20px;"/> Cancelar
                                </button>
                            </a>
                        </div>
                               

                        </div>  
                        </div>  
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  

                    <div class="row pad-top" style="background-color: white;">

                        
                            <input id="usuario" value="<?php echo $_SESSION['ID_USUARIO'] ?>" type="hidden" >
                            <!-- saludo -->
                            <div class="row " style="padding: 20px; margin: 10px;border:1px solid #DEDFE6;">
                                <fieldset>
                                    <legend style="color:#00c292; font-size: 15pt;">
                                        <img src="images/saludo.png" alt=""/>
                                        Saludo</legend>
                                        <?php echo $guion;  ?>
                                 
                                </fieldset>
                            </div>
                            <!-- fin saludo -->
                        

                        <div class="row " style="padding: 20px; margin: 10px;border:1px solid #DEDFE6;">
                            <fieldset>
                            <legend style="color:#00c292; font-size: 15pt;">
                                <img src="images/gestion.png" alt=""/>
                                Información del Paciente</legend>
                        <div class="row text-center pad-top">

                            <ul class="nav nav-tabs">
                                <li class="active">
                                    <a data-toggle="tab" href="#home"  style="color:#136453;">
                                        <button class="btn btn-light">     <img src="images/basico.png" alt="" style="width: 20px;"/>       Informaci&oacute;n
                                        </button>
                                    </a>
                                </li>
                                 <li>
                                     <a data-toggle="tab" href="#menu4" style="color:#136453;">
                                       <button class="btn btn-light">  <img src="images/historial-medico.png" alt=""/>
                                           Historico de Gestiónes</button> 
                                       </a>
                                </li>
                                <li>
                                    <a data-toggle="tab" href="#resultados_tab" style="color:#136453;">
                                       <button class="btn btn-light">  <img src="images/resultados-medicos.png" alt=""/>
                                           Ver resultados de laboratorio</button> 
                                       </a>
                                </li>
                                
                               
                            </ul>

                        </div>

                <div class="row pad-top" style="padding: 20px;">
                    <div class="tab-content">
                        <!-- PANEL DE INFORMACION DEL PACIENTE -->
                        <div id="home" class="tab-pane fade in active">
                            <div class="row " style="padding: 20px; margin: 10px;">
                                <p style="font-size: 11pt;">
                                    <img src="images/info.png" alt=""/>
                                        Realice la validaci&oacute;n de los datos. Si es necesario actualice la informaci&oacute;n</p>

                                <div id="tabla_informacion_cliente">  </div>

                               
                                <a  href="javascript:VentanaCentrada('actualizar_cliente.php?cliente_id=<?php echo $id_cliente; ?>','Examenes','','1024','768','true')" style="float: right; margin-right: 5px;" class="btn btn-default" >
                                
                                    <img src="images/refrescar.png" alt=""/>
                                    Actualizar Registro</a>
                                    <br> <br>
                                <!--informacion de terceros -->
                                <div style="padding: 10px;">

                                 <?php 
                                 if(!empty($informacion_terceros)){ ?>
                                   <fieldset>
                                    <legend style="color:#00c292; font-size: 15pt;">
                                        <img src="images/presencial.png" alt=""/>
                                        Terceros</legend>
                                    <table  class='tinfo table table-striped' id='tabla_terceros' style='width:100%;'>
                                        <thead>
                                            <tr style="background-color: #214761;">
                                                <th style="color:white">Parentesco</th>
                                                <th style="color:white">Tipo Documento</th>
                                                <th style="color:white">Documento</th>
                                                <th style="color:white">Nombre</th>
                                                <th style="color:white">Fecha Nacimiento</th>
                                                <th style="color:white">Actualizar</th>
                                            </tr>
                                        </thead>
                                        <tbody>    
                                           <?php  foreach ($informacion_terceros as $dato) { ?>
                                                <tr>
                                                    <td data-label='Parentesco'><?php echo $dato["parentesco"]?></td>
                                                    <td data-label='Tipo Documento'><?php echo $dato["tipo_documento"]?></td>
                                                    <td data-label='Documento'><?php echo $dato["documento"]?></td>
                                                    <td data-label='Nombre'><?php echo $dato["nombre"]." ".$dato["apellido"] ?></td>
                                                    <td data-label='Fecha Nacimiento'><?php echo $dato["fecha_nacimiento"]?></td>
                                                    <td data-label='Actualizar'> <a  href="javascript:VentanaCentrada('actualizar_tercero.php?tercero_id=<?php echo $dato['id_tercero']; ?>','Tercero','','824','568','true')"  class="btn btn-default" >
                                                    <img src="images/refrescar.png" alt=""/></a></td>
                                                </tr>
                                          <?php  } ?>
                                         </tbody>
                                         </table>  
                                    </fieldset>   
                                        <?php }
                                         ?>


                                </div>
                                <!-- fin informacion de terceros -->
                                 


                            </div>
                        </div>    
                   
                   
                    <!-- PANEL DE HISTORIAL DE GESTONES-->
                    <div id="menu4" class="tab-pane fade" >
                        <div class="row " style="padding: 20px; margin: 10px;">
                            <p style="font-size: 11pt;">
                                <img src="images/info.png" alt=""/> Historial de procesos realizados</p> 

                            <table class="table table-bordered" id="historico">
                                <thead>
                                    <tr style=" background-color: #214761;" >
                                        <th style="color:white">Fecha gestión</th>
                                        <th style="color:white">Medio Comunicación</th>
                                        <th style="color:white">Calificación</th>
                                        <th style="color:white">Observacion</th>
                                        <th style="color:white">Detalle</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php $lista_gestiones = $gestion->consultar_gestiones_cliente($id_cliente);
                                   foreach ($lista_gestiones as $datos_gestiones) {
                                     
                                 ?>
                                
                                    <tr>
                                        <td><?php echo $datos_gestiones["fecha_ingreso"] ?></td>
                                         <td><?php echo $datos_gestiones["medio"] ?></td>
                                        <td><?php echo $datos_gestiones["causal"] ?></td>
                                        <td><?php echo $datos_gestiones["observacion"] ?></td>
                                      
                                        <td> <center> <a  href="javascript:VentanaCentrada('ver_gestion.php?gestion_id=<?php echo base64_encode($datos_gestiones["id"]) ?>','Examenes','','1024','768','true')" class="btn btn-default">
                                      <img src="images/lupa.png" style="width: 20px;">  Consultar</a> </center></td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div id="resultados_tab" class="tab-pane fade">

                        <div id="tabla_resul">

                        </div>
                    </div>
                 
                </div>
            </div>
        </fieldset>
    </div>


           <!-- Seleccion medio de comunicacion -->
                    <?php if($permiso==1){ ?>
                            <div class="row " style="padding: 20px; margin: 10px;border:1px solid #DEDFE6;">
                                <fieldset>
                                    <legend style="color:#00c292; font-size: 15pt;">
                                        <img src="images/medio_comunicacion.png" alt=""/>
                                        Seleccione el medio de comunicación por el cual el paciente se comunica</legend>


                                <select id="medios_comunicacion" style="width: 100%">
                                    <option value=''>Seleccione</option>
                                </select>
                                <br> <br>
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                                    <div id="imagen_medio_comunicacion" class="col-lg-1 col-md-1 col-sm-1 col-xs-12" ></div>
                                    <div  class="col-lg-10 col-md-10 col-sm-10 col-xs-12">
                                    <p id="texto_comunicacion" ></p>
                                   </div>
                                </div>

                            <div id="medio_chat" class="col-md-12" style="display: none" >
                            
                                <textarea class="form-control" id="mensaje" style="width: 95%; float: right;" rows="10" ></textarea>
                            </div>
                          
                      
                                    
                                </fieldset>
                            </div>
                     <?php } ?>       
                            <!-- fin seleccion medio de comunicacion  -->


    <div class="row " style="padding: 20px; margin: 10px;border:1px solid #DEDFE6;">
        <legend style="color:#00c292; font-size: 15pt;">
            <img src="images/calificacion.png" alt=""/>
            Tipificaci&oacute;n de la Gestión</legend>
    
            <p style="font-size: 11pt;">
                                <img src="images/info.png" alt=""/>
                Califique la gestión  </p> 

            <div class="row pad-top">
                <div class="col-md-12" style="margin-bottom: 15px;">
                    <div class="col-md-4">
                        <label>Macro proceso</label>
                        <select id="macro_proceso" style="width: 100%;">
                            <option value="">Seleccione</option>
                        </select>
                    </div>
                    <div class="col-md-8">
                        <label>Tipificaciones</label>
                        <select id="tipificaciones" style="width: 100%;">
                            <option value="">Seleccione</option>
                        </select>
                    </div>

                    <div class="col-md-12">
                            <label>Observaciones</label>
                         <textarea class="form-control" id="observacion" rows="8" style="width: 100%;"></textarea><br>
                    </div>
                    <div class="col-md-12">
                        <br>
                        <button class="btn btn-primary guardar_gestion">
                            <img src="images/guardar.png" alt="" style="width: 20px;"/> Guardar gesti&oacute;n</button>
                    </div>
                </div>
            </div>

    </div>
</div>  
</div>  
<!-- /. ROW  -->   

<!-- Modal -->
                    <div class="modal" id="myModalResultados" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" >
                        <div class="modal-dialog" style="width: 80%;">
                            <div class="modal-content">
                                <div class="modal-header" style="background-color: #214761; color: white" >
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">
                                        <img src="images/actualizando.png" alt=""/>
                                       Resultados</h4>
                                </div>
                                <div class="modal-body">
                                    <table class="table table-bordered">
                                        <tr>
                                            <th>Examen</th>
                                             <th>Resultados</th>
                                             <th>Unidades</th>
                                        </tr>
                                        <tr>
                                            <td>MANGANESO EN SANGRE</td>
                                            <td>30</td>
                                            <td>%</td>
                                        </tr>
                                        <tr>
                                            <td>VIH,  PRUEBA DE TROPISMO</td>
                                            <td>4.5</td>
                                            <td>Fl</td>
                                        </tr>
                                        <tr>
                                            <td>ZINC EN ORINA</td>
                                            <td> -</td>
                                            <td>g/dll</td>
                                        </tr>
                                        
                                    </table>
                                  
                                </div>          
                                <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal" style="font-size: 11pt;">Cancelar</button>
                                 </div>
                            </div>                            
                        </div>
                    </div> 

                    <!-- Modal callback--->

                    <div class="modal" id="myModalProgramarLlamada" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" >
                        <div class="modal-dialog" style="width: 30%;">
                            <div class="modal-content">
                                <div class="modal-header" style="background-color: #214761; color: white" >
                                       <h4 class="modal-title">
                                            <img src="images/call-center.png" alt=""/>
                                          Volver a Llamar</h4>
                                </div>
                                <div class="modal-body col-md-12" style="height: auto">
                                     <p style="font-size: 12pt;color:#00c292"> 
                                      <img src="images/info.png" alt=""/>
                                  Seleccione fecha y hora</p>
                                    <div id="timer">
                                       
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                             <input type="date" class="form-control" id="fecha_programada">
                                        </div>     
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                            <input type="time" id="hora_programada" class="form-control">
                                        </div>
                                    
                                    </div>
                                </div>          
                                <div class="modal-footer">
                                 
                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                        <button type="button" id="btn_programar_llamada" class="btn btn-primary btn-detener" style="font-size: 11pt;">  <img src="images/anadir_dos.png">Programar llamada</button>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                        <button type="button" id="btn_cerrar_callback" class="btn btn-default" data-dismiss="modal" style="font-size: 11pt;"><img src="images/cerrar_dos.png"> Cerrar</button>
                                  </div>  
                                </div>
                            </div>                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>





</body>
<?php require_once '../include/footer.php'; ?>
</html>