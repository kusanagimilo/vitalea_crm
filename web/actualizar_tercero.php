<?php
require_once '../include/script.php';
require_once '../include/header.php';
require_once '../clase/Gestion.php';
require_once '../clase/Cliente.php';

$gestion = new Gestion();
$cliente = new Cliente();

$tercero_id = $_REQUEST["tercero_id"];


$informacion_tercero = $cliente->consultar_tercero($tercero_id);


foreach ($informacion_tercero as $dato) {
    $tipo_documento_id  = $dato["tipo_documento_id"];
    $tipo_documento     = $dato["tipo_documento"];
    $documento          = $dato["documento"];
    $nombre             = $dato["nombre"];
    $apellido           = $dato["apellido"];
    $fecha_nacimiento   = $dato["fecha_nacimiento"];
    $sexo               = $dato["sexo"];
    $parentesco_id      = $dato["parentesco_id"];
    $parentesco         = $dato["parentesco"];

}

?>
<script >
$(document).ready(function (){
        
      alertify.set({labels: 
             {
                ok: "Entendido",
                cancel: "Consultar anteriores"
            },color:{
                ok:"rgb(124, 35, 16)"
        }
       });  
        
        listar_tipo_documento();
        listar_estado_civil();
   
        listar_parentesco();
     


    $("#btn_actulizar_registro").click(function () {
       actualizar_tercero();
    });

});



</script>

<script src="../ajax/Crear_usuario.js" ></script>
<script src="../ajax/actualizar_paciente.js" ></script>

<input type="hidden" name="usuario_id" id="usuario_id" value="<?php echo $_SESSION['ID_USUARIO'] ?>">
<input type="hidden" name="tercero_id" id="tercero_id" value="<?php echo $tercero_id ?>">


 <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

        <div id="carga">
            
            <div id="crear_cliente_mostrar">

                            <div class="form-element-list mg-t-30">
                               <div class="panel-group" id="accordion" role="tablist">

                                    <div class="panel panel-default">
                                        <div style="height: 50px;border-bottom:1px solid #00c292;padding: 10px; ">
                                            <a  href="#collapse1" id="colapsible_basico" style=" text-decoration: none; color: black;">
                                                 <h4 style="color:#00c292;">
                                                   
                                                     <img src="images/basico.png" alt="" style="width: 20px;"/>  Informacion Tercero
                                                     </h4> 
                                                 
                                                </a>
                                        </div>
                                        <div id="collapse1" class="panel-collapse collapse" style="display: block;">
                                            <div class="panel-body">
                                                <div class="cta-desc">

                                                    
                                                    <div id="tercero_datos"  >
                                                  
                                                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                        <div class="form-group">
                                                            <label>Tipo de documento</label>
                                                            <div class="nk-int-st">
                                                                <select id="tipo_documento_tercero" style="width: 100%;"  class="form-control tipo_documento">
                                                                    <option value='<?php echo $tipo_documento_id; ?>'>  <?php echo $tipo_documento?> </option>
                                                                </select>

                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                        <div class="form-group">
                                                            <label>Numero documento</label>
                                                            <div class="nk-int-st">
                                                                <input type="text" class="form-control"  id="numero_documento_tercero" value="<?php echo $documento?>">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                        <div class="form-group">
                                                            <label>Nombres</label>
                                                            <div class="nk-int-st">
                                                                <input type="text" class="form-control"  id="nombre_tercero" value="<?php echo $nombre ?>">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                        <div class="form-group">
                                                            <label>Apellidos</label>
                                                            <div class="nk-int-st">
                                                                <input type="text" class="form-control" id="apellido_tercero" value="<?php echo $apellido?>">
                                                            </div>
                                                        </div>
                                                    </div>


                                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                        <div class="form-group">
                                                            <label>Fecha de nacimiento</label>
                                                            <div class="nk-int-st">
                                                                <input type="date" class="form-control" max="<?php echo date("YYYY-MM-DD"); ?>"  id="fecha_nacimiento_tercero" value="<?php echo $fecha_nacimiento?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                        
                                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                        <div class="form-group">
                                                            <label>G&eacute;nero</label>
                                                            <div class="nk-int-st">
                                                                <select id="sexo_tercero" style="width: 100%;" class="form-control">
                                                                
                                                                    <optgroup label="Actual">
                                                                        <option value="<?php echo $sexo ?>"><?php echo $sexo?></option>
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
                                                            <label>Parentesco con el titular</label>
                                                            <div class="nk-int-st">
                                                                <select id="parentesco" style="width: 100%;" class="form-control">
                                                                    <option value="<?php echo $parentesco_id; ?>"> <?php echo $parentesco; ?></option>
                                                                  
                                                                </select>
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
<?php
require_once '../include/formulario.php'; ?>