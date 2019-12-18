<?PHP require_once '../include/script.php';
require_once '../include/header_administrador.php';
require_once '../clase/Sesion.php';
require_once '../clase/Usuario.php';

$sesion = new Sesion();
$usuario = new Usuario();                             
?>

<script>
    
    $(document).ready(function() {
     
        $('#lista_tiempos').DataTable();
        $('#lista_tiempos_resultados').DataTable();
        $('select').select2();

        
        $("#lista_usuarios").change(function(){
            var tiempos_gestion = $("#tiempos_gestion").val();
            var fecha_inicio = $("#fecha_inicio").val();
            var lista_usuarios = $("#lista_usuarios").val();

            if(lista_usuarios.length != 0 && fecha_inicio.length == 0 && tiempos_gestion.length == 0 ){
                busqueda_por_usuario();
            }
            else if(lista_usuarios.length != 0 && fecha_inicio.length != '' && tiempos_gestion.length == 0 ){
                busqueda_por_usuario_fecha();
            }
            else if(lista_usuarios.length != 0 && fecha_inicio.length != '' && tiempos_gestion.length != 0 ){
                busqueda_por_usuario_fecha_proceso();
            }
            
        });

        $("#tiempos_gestion").change(function(){
            var tiempos_gestion = $("#tiempos_gestion").val();
            var fecha_inicio = $("#fecha_inicio").val();
            var lista_usuarios = $("#lista_usuarios").val();

            if(lista_usuarios.length == 0 && fecha_inicio.length == 0 && tiempos_gestion.length != 0 ){
               busqueda_por_gestion();
            }
            else if(lista_usuarios.length != 0 && fecha_inicio.length == '' && tiempos_gestion.length != 0 ){
        
                busqueda_por_usuario_proceso();
            }
            else if(lista_usuarios.length != 0 && fecha_inicio.length != '' && tiempos_gestion.length != 0 ){
                busqueda_por_usuario_fecha_proceso();
            }
        });

        $("#fecha_inicio").change(function(){
            var tiempos_gestion = $("#tiempos_gestion").val();
            var fecha_inicio = $("#fecha_inicio").val();
            var lista_usuarios = $("#lista_usuarios").val();

            if(lista_usuarios.length == 0 && fecha_inicio.length != '' && tiempos_gestion.length == 0 ){
               busqueda_por_fecha();
            }
            else if(lista_usuarios.length != 0 && fecha_inicio.length != '' && tiempos_gestion.length == 0 ){
                busqueda_por_usuario_fecha();
            }
            else if(lista_usuarios.length != 0 && fecha_inicio.length != '' && tiempos_gestion.length != 0 ){
                busqueda_por_usuario_fecha_proceso();
            }
        });

        $("#btn_limpiar_filtro").click(function(){
            $("#tiempos_gestion").empty();
            $("#fecha_inicio").val("");
            $("#lista_usuarios").empty();

         
            $("#tabla_resultado").css("display","none");
            $("#tabla_inicial").css("display","block");
        });



} );
    </script>
<script src="../ajax/log_usuario.js" ></script>
<body style="background-color: #F6F8FA">

    <div class="main-menu-area mg-tb-40">
        <div class="container" style="height:auto;">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <ol class="breadcrumb">
                        <li><a href="inicio_administrador.php" title="Volver atras"><img src="images/atras.png"></a></li>
                       
                        <li><a href="inicio_administrador.php" title="Inicio">Inicio</a></li>
                        <li class="active">Tiempos de Gestión</li>
                    </ol>

                    <div class="row pad-top" style="background-color: white;">
      
                       
                            <div id="examenes" style="padding: 20px;">
                                    <div class="row">  
                                            <div class="panel panel-default">
                                                <div class="panel-heading " style="height: 50px;">
                                                    <h3 class="panel-title"> 
                                                        <b  style="float: left">  <img src="images/tiempos_gestion.png" alt=""/> 
                                                        Tiempos de gestion</b> </h3> 
                                                </div>

                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding: 5px;">
                                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                                    <label> <img src="images/usuario.png" alt=""/>  Usuarios</label>
                                                    <select class="form-control" id="lista_usuarios">
                                                        <option value=""> - </option>
                                                        <?php 
                                                        $lista_usuarios = $usuario->listar_usuarios();
                                                        foreach ($lista_usuarios as $datos_usuarios) { ?>
                                                            <option value="<?php echo $datos_usuarios["id"] ?>"><?php echo $datos_usuarios["id"] ?></option>
                                                       <?php  } ?>
                                                    </select>
                                                </div>

                                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                                    <label> <img src="images/item.png" alt=""/> Tiempos Gestión</label>
                                                    <select class="form-control" id="tiempos_gestion">
                                                        <option value=""> - </option>
                                                        <?php $lista_procesos = $sesion->procesos();
                                                        foreach ($lista_procesos as $datos_proceso) { ?>
                                                            <option value="<?php echo $datos_proceso["id"] ?>"><?php echo $datos_proceso["descripcion"] ?></option>
                                                       <?php  } ?>
                                                    </select>
                                                </div> 
                                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                                    <label> <img src="images/fecha.png" alt=""/> Fecha Inicio</label>
                                                    <input type="date" id="fecha_inicio" class="form-control"max="<?php echo date("Y-m-d"); ?>">
                                                </div>
                                                 <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3" style="text-align: right;">
                                                    <br>
                                                    <button class="btn btn-primary" id="btn_limpiar_filtro"><img src="images/actualizando.png"> 
                                                    Limpiar Filtros</button>
                                                 </div> 
                                                <br>
                                            </div> 

                                            <hr style="width: 100%;margin-top: 10px;">
                                            <div class="panel-body" >
                                                <div id="tabla_inicial">
                                                    <table id="lista_tiempos" class="table table-bordered">
                                                        <thead>
                                                            <tr style="background-color: #214761;">
                                                                <th style="color:white">Perfil</th>
                                                                <th style="color:white">Usuario</th>
                                                                <th style="color:white">Nombre </th>
                                                                <th style="color:white">Proceso</th>
                                                                <th style="color:white">Fecha Inicio</th>
                                                                <th style="color:white">Fecha Fin</th>
                                                                <th style="color:white">Tiempo</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $lista_tiempos_gestion = $sesion->registro_procesos();
                                                            foreach($lista_tiempos_gestion as $datos_tiempos){?>
                                                            <tr>
                                                                <td><?php echo $datos_tiempos["perfil"] ?></td>
                                                                <td><?php echo $datos_tiempos["usuario_id"] ?></td>
                                                                <td><?php echo $datos_tiempos["nombre"] ?></td>
                                                                <td><?php echo $datos_tiempos["proceso"] ?></td>
                                                                <td><?php echo $datos_tiempos["fecha_inicio"] ?></td>
                                                                <td><?php echo $datos_tiempos["fecha_fin"] ?></td>
                                                                <td><?php echo $datos_tiempos["tiempo"] ?></td>
                                                               
                                                            </tr>
                                                           <?php }  ?>
                                                        </tbody>
                                                    </table>
                                                </div> 
                                                <div id="tabla_resultado">
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

    <!-- End Contact Info area-->
<?php require_once '../include/footer.php'; ?>

</body>

</html>