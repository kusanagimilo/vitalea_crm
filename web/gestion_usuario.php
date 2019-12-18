<?PHP require_once '../include/script.php';
require_once '../include/header_administrador.php';
require_once '../clase/Usuario.php';
require_once '../clase/Cliente.php';
require_once '../clase/Laboratorio.php';

$usuario = new Usuario();
$cliente = new Cliente();
$laboratorio = new Laboratorio();
?>
<script src="../ajax/gestion_usuario.js" type="text/javascript"></script>

<body style="background-color: #F6F8FA">

    <div class="main-menu-area mg-tb-40">
        <div class="container" style="height:auto;">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <ol class="breadcrumb">
                        <li><a href="inicio_administrador.php" title="Volver atras"><img src="images/atras.png"></a></li>
                       
                        <li><a href="inicio_administrador.php" title="Inicio">Inicio</a></li>
                        <li class="active">Gestion de Usuarios</li>
                    </ol>

                    <div class="row pad-top" style="background-color: white;">
                          <div id="home"  style="padding: 20px;">
                                <div class="row">

                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" style="text-align: center;">

                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h3 class="panel-title"> 
                                                    <img src="images/usuarios_existentes.png" alt=""/>    
                                                    <b>Existentes</b></h3>
                                            </div>
                                            <div class="panel-body">
                                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="text-align: center;">
                                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                        <div class="color-single nk-teal">
                                                            Call Center:              
                                                            <span class="badge" id="conteo_call_center"></span>
                                                        </div>
                                                    </div>   
                                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">   
                                                        <div class="color-single nk-light-blue">
                                                            Presencial
                                                            <span class="badge"id="conteo_presencial"></span>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" style="text-align: center;">

                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h3 class="panel-title"> 
                                                    <img src="images/activos.png" alt=""/> 
                                                    <b> Activos</b></h3>
                                            </div>
                                            <div class="panel-body">
                                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="text-align: center;">
                                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                        <div class="color-single nk-teal">
                                                            Call Center
                                                            <span class="badge"id="activo_call_center"></span>

                                                        </div>
                                                    </div>   
                                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">   
                                                        <div class="color-single nk-light-blue">
                                                            Presencial
                                                            <span class="badge" id="activo_presencial"></span>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                 </div>
                                <br>

                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h3 class="panel-title"> 
                                            <img src="images/lista.png" alt=""/> 
                                            <b> Lista de usuarios</b></h3>
                                    </div>
                                    <div class="panel-body">
                                        <table id="data-table-basic" class="table table-bordered">
                                            <thead>
                                                <tr style="background-color: #214761;">
                                                    <th style="color:white">Usuario</th>
                                                    <th style="color:white">Perfil</th>
                                                    <th style="color:white">Documento</th>
                                                    <th style="color:white">Nombre</th>
                                                    <th style="color:white">Correo</th>
                                                    <th style="color:white">Estado</th>
                                                    <th style="color:white">Opciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $lista_usuario = $usuario->listar_usuarios();
                                                foreach ($lista_usuario as $datos){?>
                                                <tr>
                                                    <td><?php echo $datos["nombre_usuario"] ?></td>
                                                    <td><?php echo $datos["perfil"] ?></td>
                                                    <td><?php echo $datos["documento"] ?></td>
                                                    <td><?php echo $datos["nombre_completo"] ?></td>
                                                    <td><?php echo $datos["correo"] ?></td>
                                                    <td><?php echo $datos["estado"] ?></td>
                                                    <td style="text-align: center">
                                                       
                                                        <?php $activo = $datos["activo"];
                                                        if($activo== 1){ ?>
                                                        <button class="estado_usuario" data-id="<?php echo $datos["id"];?>" data-estado='<?php echo $datos["activo"] ?>' style="background-color: transparent;border: none;">
                                                            <img src="images/activo.png" alt="" title="Inactivar Usuario"/></button>
                                                        <?php }else{ ?>
                                                        <button class="estado_usuario" data-id="<?php echo $datos["id"];?>" data-estado='<?php echo $datos["activo"] ?>' style="background-color: transparent;border: none;">
                                                            <img src="images/inactivo.png" alt="" title="Activar Usuario"/> </button>
                                                       <?php } ?>
                                                    </td>
                                                    
                                                </tr>
                                               <?php }
                                                
                                                ?>
                                            </tbody>
                                        </table>
                                     </div>
                                </div>
                               
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h3 class="panel-title"> 
                                            <img src="images/agregar-usuario.png" alt=""/> 
                                            <b>Agregar usuario</b></h3>
                                    </div>
                                    <div class="panel-body">
                                        <div class="form-element-list" >
                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                <div class="form-group"><img src="images/usuario.png" style="width: 32px; height: 32px;" alt=""/>
                                                    <label>Perfil</label>
                                                    <div class="nk-int-st">
                                                        <select id="perfil" style="width: 100%;" class="form-control">
                                                            <option value=''> -- </option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            
                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                <div class="form-group">
                                                    <label> <img src="images/basico.png" style="width: 32px; height: 32px;" alt=""/> Numero documento</label>
                                                    <div class="nk-int-st">
                                                        <input type="text" class="form-control"  id="numero_documento" >
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                <div class="form-group">
                                                    <label> <img src="images/usuario.png" style="width: 32px; height: 32px;" alt=""/> Nombre completo</label>
                                                    <div class="nk-int-st">
                                                        <input type="text" class="form-control"  id="nombre_completo" >
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                <div class="form-group">
                                                    <label> <img src="images/arroba.png" style="width: 32px; height: 32px;" alt=""/> Correo electronico</label>
                                                    <div class="nk-int-st">
                                                        <input type="text" class="form-control"  id="correo" >
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                <div class="form-group">
                                                    <label> <img src="images/usuario.png" style="width: 32px; height: 32px;" alt=""/> Nombre usuario</label>
                                                    <div class="nk-int-st">
                                                        <input type="text" class="form-control"  id="nombre_usuario" >
                                                    </div>
                                                </div>
                                            </div>
                                            
											 <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                <div class="form-group">
                                                    <label> <img src="../images/calendario.png" style="width: 32px; height: 32px;" alt=""/> Fecha de Nacimiento</label>
                                                    <div class="nk-int-st">
                                                        <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" placeholder="Fecha de Nacimiento" class="form-control">
                                                    </div>
                                                </div>
                                            </div>
											 
											
											<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                <div class="form-group">
                                                    <label> <img src="../images/pregunta.png" style="width: 32px; height: 32px;" alt=""/> Pregunta de seguridad</label>
                                                    <div class="nk-int-st">
                                                        <select name="pregunta_respaldo" id="pregunta_respaldo" class="form-control">
                                            <option value="0">Seleccione una pregunta de seguridad</option>
                                            <option value="1">Color Favorito</option>
                                            <option value="2">Nombre de su Primera Mascota</option>
                                            <option value="3">Nombre de su amigo de Infancia</option>
                                            <option value="4">Nombre de Hermano Mayor</option>
                                      </select>
                                                    </div>
                                                </div>
                                            </div>
											
										
											
											<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                <div class="form-group">
                                                    <label> <img src="../images/etiqueta.png" style="width: 32px; height: 32px;" alt=""/> Respuesta</label>
                                                    <div class="nk-int-st">
                                                        <input type="text" id="respuesta" name="respuesta" placeholder="Respuesta" class="form-control">
                                                    </div>
                                                </div>
                                            </div>
											
                                            <button id="btn_usuario_nuevo" class="btn btn-primary" style="width: 30%;float: right; margin-top: 80px;">
                                                <img src="images/guardar.png" alt="" style="width: 20px"/>
                                                Guardar</button>
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