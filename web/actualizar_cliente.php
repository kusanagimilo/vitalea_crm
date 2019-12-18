<?php
require_once '../include/script.php';
require_once '../include/header.php';
require_once '../clase/Gestion.php';
require_once '../clase/Cliente.php';

$gestion = new Gestion();
$cliente = new Cliente();

$cliente_id = $_REQUEST["cliente_id"];

$registro_cliente = $gestion->buscar_registro($cliente_id);
   $array = json_decode($registro_cliente);
   
   foreach($array as $obj){
    $tipo_documento     =  $obj->tipo_documento;
    $documento          =  $obj->documento;
    $nombre_cliente     =  $obj->nombre_cliente;
    $apellido_cliente   =  $obj->apellido_cliente;
    $telefono_1         =  $obj->telefono_1;
    $telefono_2         =  $obj->telefono_2;
    $email              =  $obj->email;
    $fecha_nacimiento   =  $obj->fecha_nacimiento;
    $ciudad             =  $obj->ciudad;
    $departamento       =  $obj->departamento;
    $barrio             =  $obj->barrio;
    $direccion          =  $obj->direccion;
    $estado_civil       =  $obj->estado_civil;
    $estrato            =  $obj->estrato;
    $sexo               =  $obj->sexo;
    $id_tipo_documento  =  $obj->id_tipo_documento;
    $ciudad_id          =  $obj->ciudad_id;
    $id_departamento    =  $obj->id_departamento;
    $estado_civil_id    =  $obj->estado_civil_id;
    $activo_id          =  $obj->estado_cliente;
                                   
   }

$tipo_cliente = $cliente->obtener_tipo_cliente($cliente_id);


if($tipo_cliente == "Tercero"){
    $seleccionado_tercero = "checked";
    $seleccionado_titular = "";
}
else if($tipo_cliente == "Titular"){
    $seleccionado_titular = "checked";
    $seleccionado_tercero = ""; 
}



   
?>
<script >
$(document).ready(function (){
        alertify.set({labels:  {
                        ok: "Entendido",
                        cancel: "Consultar anteriores"
                    },color:{
                        ok:"rgb(124, 35, 16)"
                    }
       });
        
        cargar_tercero();
        listar_tipo_documento();
        listar_estado_civil();
        listar_departamento();
        listar_seccion_direccion();
        listar_parentesco();

        $("#departamento").change(function () {
            listar_ciudad();
        });
    
        $( '.i-checks' ).on( 'click', function() {
        if( $(this).is(':checked') ){
                var valor = $(this).val();
                 if(valor == "Tercero"){
                     $("#panel_terceros").css("display","block");
                 }
                 else{
                     $("#panel_terceros").css("display","none");
                 }
               
            } 
        });

        if( $( '.i-checks' ).is(':checked') ){
             var valor = $('.i-checks').val();

            if(valor == "Tercero"){
                         $("#panel_terceros").css("display","none");
            }
            else{
                 $("#panel_terceros").css("display","block");
            }

     }
        
        
        $('select').select2();


        $("#colapsible_basico").click(function () {
    
            var isVisible = $("#collapse1").is(":visible");
            
            if(isVisible){
                $("#collapse1").css("display","none");
            }
            else{
                $("#collapse1").css("display","block");
            }
            
        });

        $("#colapsible_ubicacion").click(function () {
            
            
            var isVisible = $("#collapse2").is(":visible");
            
            if(isVisible){
                $("#collapse2").css("display","none");
            }
            else{
                $("#collapse2").css("display","block");
            }
            
        });

        $("#colapsible_terceros").click(function () {
            
            
            var isVisible = $("#collapse4").is(":visible");
            
            if(isVisible){
                $("#collapse4").css("display","none");
            }
            else{
                $("#collapse4").css("display","block");
            }
            
        });

        $("#colapsible_clasificacion").click(function () {
            
            
            var isVisible = $("#collapse3").is(":visible");
            
            if(isVisible){
                $("#collapse3").css("display","none");
            }
            else{
                $("#collapse3").css("display","block");
            }
            
        });



    //agregar tercero temporal 
    $("#btn_agregar_tercero").click(function () {
        agregar_tercero();
    });    

    $("#btn_actulizar_registro").click(function () {
       actualizar_paciente();
    });

});



</script>

<script src="../ajax/Crear_usuario.js" ></script>
<script src="../ajax/actualizar_paciente.js" ></script>

<input type="hidden" name="usuario_id" id="usuario_id" value="<?php echo $_SESSION['ID_USUARIO'] ?>">
<input type="hidden" name="cliente_id" id="cliente_id" value="<?php echo $cliente_id ?>">


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
  
}

</style>

<meta name="viewport" content="width=device-width, initial-scale=1">

    <div id="carga">
            
        <div id="crear_cliente_mostrar">

            <div class="form-element-list mg-t-30">
                <div class="panel-group" id="accordion" role="tablist">

                    <div class="panel panel-default">
                        <div style="height: 50px;border-bottom:1px solid #00c292;padding: 10px; ">
                            <a  href="#collapse1" id="colapsible_basico" style=" text-decoration: none; color: black;">
                                 <h4 style="color:#00c292;">
                                   
                                     <img src="images/basico.png" alt="" style="width: 20px;"/>  Datos básicos 
                                     <span style="float:right"><img src="images/sort_desc.png" alt=""/></span></h4> 
                                 
                                </a>
                        </div>
                        <div id="collapse1" class="panel-collapse collapse" style="display: block;">
                            <div class="panel-body">
                                <div class="cta-desc">

                        <!--  Adicionales-->
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            
                                            <div class="nk-int-st">
                                                <input name="tipo_cliente" type="radio" value="Titular" class="i-checks" <?php echo  $seleccionado_titular ;?> > Titular
                                                <input name="tipo_cliente" type="radio" value="Tercero" class="i-checks" <?php echo  $seleccionado_tercero ;?>  > Tercero
                                            </div>
                                        </div>
                                    </div>
                                                    
                                      
                                <!-- Adicionales -->
                                         <p style=" font-size: 11pt;"><img src="images/info.png" alt=""/>
                                                      Informacion del Titular</p> 

                              
                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                        <div class="form-group">
                                            <label>Tipo de documento</label>
                                            <div class="nk-int-st">
                                                <select id="tipo_documento" style="width: 100%;"  class="form-control">
                                                    <optgroup label="Actual">
                                                        <option value="<?php echo $id_tipo_documento ?>"><?php echo $tipo_documento ?></option>
                                                    </optgroup>
                                                </select>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                        <div class="form-group">
                                             <label>Numero documento</label>
                                            <div class="nk-int-st">
                                                <input type="text" class="form-control"  id="numero_documento" value="<?php echo $documento; ?>">
                                              </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                        <div class="form-group">
                                             <label>Nombres</label>
                                            <div class="nk-int-st">
                                                <input type="text" class="form-control"  id="nombre" value="<?php echo $nombre_cliente ?>">
                                             </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                        <div class="form-group">
                                             <label>Apellidos</label>
                                            <div class="nk-int-st">
                                                <input type="text" class="form-control" id="apellido" value="<?php echo $apellido_cliente ?>">
                                            </div>
                                        </div>
                                    </div>
          

                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                        <div class="form-group">
                                             <label>Fecha de nacimiento</label>
                                            <div class="nk-int-st">
                                                <input type="date" class="form-control"  id="fecha_nacimiento" value="<?php echo $fecha_nacimiento; ?>">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                        <div class="form-group">
                                             <label>Telefono 1</label>
                                            <div class="nk-int-st">
                                                <input name="telefono_uno" id="telefono_uno" class="form-control" type="text" value="<?php echo $telefono_1; ?>">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                        <div class="form-group">
                                            <label>Telefono 2</label>
                                            <div class="nk-int-st">
                                                <input name="telefono_dos" id="telefono_dos" class="form-control" type="text" value="<?php echo $telefono_2 ?>">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                        <div class="form-group">
                                            <label>Correo electr&oacute;nico</label>
                                            <div class="nk-int-st">
                                                <input name="email" id="email" class="form-control" type="text" value="<?php echo $email ?>">
                                             </div>
                                        </div>
                                    </div>
                                </div>
                                       
                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                        <div class="form-group">
                                            <label>G&eacute;nero</label>
                                            <div class="nk-int-st">
                                                <select id="sexo" style="width: 100%;" class="form-control">
                                                    <optgroup label="Actual">
                                                        <option value="<?php echo $sexo ?>"><?php echo $sexo ?></option>
                                                    </optgroup>
                                                    <optgroup label="Actualizar">
                                                        <option value="Femenino">Femenino</option>
                                                        <option value="Masculino">Masculino</option>
                                                    </optgroup>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                        <div class="form-group">
                                            <label>Estado civil</label>
                                            <div class="nk-int-st">
                                                <select id="estado_civil" style="width: 100%;" class="form-control">
                                                    <optgroup label="Actual">
                                                        <option value="<?php echo $estado_civil_id ?>"><?php echo $estado_civil ?></option>
                                                    </optgroup>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                            </div> 
                        </div>
                    </div> 
                </div>
                
                <div class="panel panel-default" id="panel_terceros" style="display: none">
                    <div style="height: 50px;border-bottom:1px solid #00c292;padding: 10px; ">
                             <a href="#collapse4" id="colapsible_terceros" style=" text-decoration: none; color: black;">
                                 <h4 style="color:#00c292;">
                                     <img src="images/ubicacion.png" alt=""/>
                                    Informacion de Terceros
                                     <span style="float:right"><img src="images/sort_desc.png" alt=""/></span></h4> 
                                 
                                </a>
                            
                        </div>
                   
                    <div id="collapse4" class="panel-collapse collapse" style="display: block">
                        <div class="panel-body">
                            <div class="cta-desc">
                                 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="text-align: right;">
                                 <button type="button" class="btn btn-default" data-toggle="modal" data-target="#myModalResultados"> <img src="images/anadir_dos.png"> Agregar Tercero</button>
                             </div>
                                 <div id="div_informacion_terceros"></div>
                            </div>
                        </div>
                    </div>
                </div>   

                
                              

                <div class="panel panel-default">
                    <div style="height: 50px;border-bottom:1px solid #00c292;padding: 10px; ">
                             <a href="#collapse2" id="colapsible_ubicacion" style=" text-decoration: none; color: black;">
                                 <h4 style="color:#00c292;">
                                     <img src="images/ubicacion.png" alt=""/>
                                    Datos de ubicacion 
                                     <span style="float:right"><img src="images/sort_desc.png" alt=""/></span></h4> 
                                 
                                </a>
                            
                    </div>
                   
                    <div id="collapse2" class="panel-collapse collapse" style="display: block">
                        <div class="panel-body">
                            <div class="cta-desc">

                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                    <div class="form-group">
                                        <label>Departamento</label>
                                        <div class="nk-int-st">
                                            <select id="departamento" style="width: 100%;" class="form-control" >
                                                <optgroup label="Actual">
                                                    <option value="<?php echo $id_departamento ?>"><?php echo $departamento ?></option>
                                                </optgroup>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                    <div class="form-group">
                                         <label>Ciudad</label>
                                        <div class="nk-int-st">
                                            <select id="ciudad" style="width: 100%;" class="form-control">
                                                <optgroup label="Actual">
                                                    <option value="<?php echo $ciudad_id ?>"><?php echo $ciudad ?></option>
                                                </optgroup>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                    <div class="form-group">
                                        <label>Barrio</label>
                                        <div class="nk-int-st">
                                            <input name="barrio" id="barrio" class="form-control" type="text" value="<?php echo $barrio ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                    <div class="form-group">
                                         <label>Estrato</label>
                                        <div class="nk-int-st">
                                            <select id="estrato" style="width: 100%;" class="form-control">
                                                <optgroup label="Actual">
                                                    <option value="<?php echo $estrato ?>"><?php echo $estrato ?></option>
                                                </optgroup>
                                               <optgroup label="Actualizar">
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="4">4</option>
                                                    <option value="5">5</option>
                                                    <option value="6">6</option>
                                                </optgroup>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                
                             <div class="col-lg-12 col-md-12 col-sm-12 col-xs-8">
                                <div class="cmp-tb-hd">
                                 <p style="color:#00c292; font-size: 15pt;">Dirección actual</p> 
                                </div> 
                                <div class="form-group">
                                    <label>Direcci&oacute;n:</label>
                                    <div class="nk-int-st">
                                        <input name="direccion_actual" id="direccion_actual" class="form-control" type="text" readonly="true" value="<?php echo $direccion; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <p style=" font-size: 11pt;">
                                        <img src="images/info.png" alt=""/>
                                        Seleccione cada seccion para armar la direccion</p> 
                            </div>

                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                <div class="form-group">
                                     <label>Seccion 1:</label>
                                    <div class="nk-int-st">
                                        <select id="seccion_uno" style="width: 100%;" class="form-control seccion" onchange="armar_direccion()">
                                            <option value=''> -- </option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                <div class="form-group">
                                     <label>N&uacute;mero:</label>
                                    <div class="nk-int-st">
                                        <input name="numero_uno" id="numero_uno" class="form-control" type="text" onchange="armar_direccion()">
                                     </div>
                                </div>
                            </div>

                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                <div class="form-group">
                                    <label>Seccion 2:</label>
                                    <div class="nk-int-st">
                                        <select id="seccion_dos" style="width: 100%;" class="form-control seccion" onchange="armar_direccion()">
                                            <option value=''> -- </option>
                                       </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                <div class="form-group">
                                  <labeL>N&uacute;mero:</label>
                                    <div class="nk-int-st">
                                        <input name="numero_dos" id="numero_dos" class="form-control" type="text" onchange="armar_direccion()" >
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                <div class="form-group">
                                     <label>Seccion 3:</label>
                                    <div class="nk-int-st">
                                        <select id="seccion_tres" style="width: 100%;"  class="form-control seccion" onchange="armar_direccion()">
                                            <option value=''> -- </option>
                                       </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                <div class="form-group">
                                    <label>Adicional:</label>
                                    <div class="nk-int-st">
                                        <input name="adicional" id="adicional" class="form-control" type="text" onchange="armar_direccion()">
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-8">
                                <div class="form-group">
                                    <label>Direcci&oacute;n:</label>
                                    <div class="nk-int-st">
                                        <input name="direccion" id="direccion" class="form-control" type="text" readonly="true">
                                    </div>
                                </div>
                            </div>
             
                        </div>
                    </div>
                </div>
           <button id="btn_actulizar_registro" class="btn btn-primary notika-btn-success waves-effect" style="width: 30%;float: right">
               <img src="images/actualizar.png" alt="" style="width: 20px"/>
               Actualizar registro</button>
            </div>
   
              
        </div>
</div>

<!-- modal terceros -->
  <div class="modal" id="myModalResultados" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" >
    <div class="modal-dialog" style="width: 80%;">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #214761; color: white" >
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">
                        <img src="images/examen_venta.png" alt=""/>
                       Seleccione examen</h4>
            </div>
            <div class="modal-body col-md-12" style="height: auto">
                   
                <div id="tercero_datos"  >
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <h4 style="color:#00c292;">
                           <img src="images/cliente_1.png" alt="" style="width: 20px;"/>  Tercero 
                        </h4> 
                        <p style=" font-size: 11pt;">
                            <img src="images/info.png" alt=""/>
                            Solicite los datos de la persona a la cual representa.

                        </p>    
                                                
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                        <div class="form-group">
                            <label>Tipo de documento</label>
                            <div class="nk-int-st">
                                <select id="tipo_documento_tercero" style="width: 100%;"  class="form-control tipo_documento">
                                    <option value=''> -- </option>
                                </select>

                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                        <div class="form-group">
                            <label>Numero documento</label>
                            <div class="nk-int-st">
                                <input type="text" class="form-control"  id="numero_documento_tercero" >
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                        <div class="form-group">
                            <label>Nombres</label>
                            <div class="nk-int-st">
                                <input type="text" class="form-control"  id="nombre_tercero">
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                        <div class="form-group">
                            <label>Apellidos</label>
                            <div class="nk-int-st">
                                <input type="text" class="form-control" id="apellido_tercero">
                            </div>
                        </div>
                    </div>


                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                        <div class="form-group">
                            <label>Fecha de nacimiento</label>
                            <div class="nk-int-st">
                                <input type="date" class="form-control" max="<?php echo date("YYYY-MM-DD"); ?>"  id="fecha_nacimiento_tercero">
                            </div>
                        </div>
                    </div>
                        
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                        <div class="form-group">
                            <label>G&eacute;nero</label>
                            <div class="nk-int-st">
                                <select id="sexo_tercero" style="width: 100%;" class="form-control">
                                    <option value=''> - </option>
                                    <option value="Femenino">Femenino</option>
                                    <option value="Masculino">Masculino</option>
                                </select>
                            </div>
                        </div>
                    </div>
                                                        
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                        <div class="form-group">
                            <label>Parentesco</label>
                            <div class="nk-int-st">
                                <select id="parentesco" style="width: 100%;" class="form-control">
                                  
                                </select>
                            </div>
                        </div>
                    </div>

                </div>
            </div>          
            <div class="modal-footer">
                <button type="button" id="btn_agregar_tercero" class="btn btn-primary" style="font-size: 11pt;">  <img src="images/anadir_dos.png"> Agregar Tercero</button>
                <button type="button" class="btn btn-default" data-dismiss="modal" style="font-size: 11pt;"><img src="images/cerrar_dos.png"> Cerrar</button>
            </div>
        </div>                            
    </div>
</div>
<?php
require_once '../include/formulario.php'; ?>