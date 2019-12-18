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
<script>
    
    $(document).ready(function() {
        $('#lista_cliente').DataTable();
        $('#lista_laboratorios').DataTable();
        $('#lista_examenes').DataTable();
        $('#lista_tipificacion').DataTable();
} );
    </script>
<body style="background-color: #F6F8FA">

    <div class="main-menu-area mg-tb-40">
        <div class="container" style="height:auto;">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="row text-center pad-top" style="padding: 20px;">

                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#home">
                                    <img src="images/buscar_cliente_1.png" alt=""/>Gestion de Usuarios</a>
                            </li>
                            <li><a data-toggle="tab" href="#clientes"> <img src="images/agregar-usuario.png" alt=""/> Gestion Clientes</a>
                            </li>
                            <li><a data-toggle="tab" href="#laboratorios"><img src="images/cotizar.png" alt=""/>  Laboratorios</a>
                            </li>
                            <li><a data-toggle="tab" href="#examenes"><img src="images/historial-medico.png" alt=""/>  Examenes</a>
                            </li>
                            <li><a data-toggle="tab" href="#tipificaciones"><img src="images/tipificaciones.png" alt=""/>  Tipificaciones</a>
                            </li>
                            <li>
                                <a href="https://app.klipfolio.com/apiAccount/trialRedirect?referralCode=45e9049e6824f1f82d31eb332b24af31" target="_blank">
                                    <img src="images/calificacion.png" alt=""/>  Reportes</a>
                            </li>
                        </ul>

                    </div>

                    <div class="row pad-top" style="background-color: white;">
                        <div class="tab-content  custom-menu-content">
                            <div id="home" class="tab-pane fade in active " style="padding: 20px;">
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
                                                <tr style="background-color: white;">
                                                    <th style="color:#214761">Usuario</th>
                                                    <th style="color:#214761">Perfil</th>
                                                    <th style="color:#214761">Documento</th>
                                                    <th style="color:#214761">Nombre</th>
                                                    <th style="color:#214761">Correo</th>
                                                    <th style="color:#214761">Estado</th>
                                                    <th style="color:#214761">Opciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $lista_usuario = $usuario->listar_usuarios();
                                                foreach ($lista_usuario as $datos){?>
                                                <tr>
                                                    <td><?php echo $datos["id"] ?></td>
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
                                                <div class="form-group">
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
                                                    <label>Numero documento</label>
                                                    <div class="nk-int-st">
                                                        <input type="text" class="form-control"  id="numero_documento" >
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                <div class="form-group">
                                                    <label>Nombre completo</label>
                                                    <div class="nk-int-st">
                                                        <input type="text" class="form-control"  id="nombre_completo" >
                                                    </div>
                                                </div>
                                            </div>
                                             <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                <div class="form-group">
                                                    <label>Correo electronico</label>
                                                    <div class="nk-int-st">
                                                        <input type="text" class="form-control"  id="correo" >
                                                    </div>
                                                </div>
                                            </div>
                                            <button id="btn_usuario_nuevo" class="btn btn-primary" style="width: 30%;float: right;">
                                                <img src="images/guardar.png" alt="" style="width: 20px"/>
                                                Guardar</button>
                                        </div>
                                     </div>
                                </div>
                                
                            </div>
                             <div id="clientes" class="tab-pane fade" style="padding: 20px;">
                                <div class="row">
                                     <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h3 class="panel-title"> 
                                            <img src="images/lista.png" alt=""/> 
                                            <b> Lista de Clientes</b></h3>
                                    </div>
                                    <div class="panel-body">
                                        <table id="lista_cliente" class="table table-bordered">
                                            <thead>
                                                <tr style="background-color: white;">
                                                    <th style="color:#214761">Tipo de Documento</th>
                                                    <th style="color:#214761">No. Documento</th>
                                                    <th style="color:#214761">Nombre Completo</th>
                                                    <th style="color:#214761">Telefono 1</th>
                                                    <th style="color:#214761">Correo</th>
                                                    <th style="color:#214761">Fecha Nacimiento</th>
                                                    <th style="color:#214761">Ciudad</th>
                                                    <th style="color:#214761">Estrato</th>
                                                    <th style="color:#214761">Tipo</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $lista_cliente = $cliente->listar_cliente();
                                                foreach ($lista_cliente as $datos_cliente){?>
                                                <tr>
                                                    <td><?php echo $datos_cliente["nombre"] ?></td>
                                                    <td><?php echo $datos_cliente["documento"] ?></td>
                                                    <td><?php echo $datos_cliente["nombre_completo"] ?></td>
                                                    <td><?php echo $datos_cliente["telefono_1"] ?></td>
                                                    <td><?php echo $datos_cliente["email"] ?></td>
                                                    <td><?php echo $datos_cliente["fecha_nacimiento"] ?></td>
                                                   <td><?php echo $datos_cliente["ciudad"] ?></td>
                                                   <td><?php echo $datos_cliente["estrato"] ?></td>
                                                   <td><?php echo $datos_cliente["tipo_cliente"] ?></td>
                                                 </tr>
                                               <?php }
                                                
                                                ?>
                                            </tbody>
                                        </table>
                                     </div>
                                </div>
                                </div>
                             </div> 
                            
                            <div id="laboratorios" class="tab-pane fade  " style="padding: 20px;">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" style="text-align: center;">
                                          <div class="panel panel-default">
                                              <div class="panel-heading" style="height: 50px;">
                                        <h3 class="panel-title"> 
                                           <b  style="float: left">  <img src="images/laboratorio.png" alt=""/> 
                                            Lista de Laboratorios</b>
                                            <img src="images/anadir.png" alt="" style="float: right" title="Agregar laboratorio"/> </h3>
                                    </div>
                                    <div class="panel-body">
                                        
                                        <table id="lista_laboratorios" class="table table-bordered">
                                    
                                                 <thead>
                                                <tr style="background-color: white;">
                                                        <th style="color:#214761">Nombre</th>
                                                        <th style="color:#214761">Direccion</th>
                                                        <th style="color:#214761">Localidad</th>
                                                        <th style="color:#214761">Telefono</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                        <td>Laboratorio 1</td>
                                                        <td>Calle 1 # 65</td>
                                                        <td>Chapinero</td>
                                                        <td>(625) 856-48</td>
                                                </tr>
                                                <tr>
                                                        <td>Laboratorio 2</td>
                                                        <td>Call 154 # 4 78</td>
                                                        <td>Usaquen</td>
                                                        <td>(786) 587-87</td>
                                                </tr>
                                                <tr>
                                                        <td>Laboratorio 3</td>
                                                        <td>Kra 1 # 67 90</td>
                                                        <td>Chico</td>
                                                        <td>(729) 840-66</td>
                                                </tr>
                                               
                                            </tbody>
                                        </table>
                                    </div>
                                    </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12" style="padding: 10px;">
                                        <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d63638.23427392857!2d-74.1179392!3d4.5236224!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1ses!2sco!4v1542166591587" width="550" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
                                    </div>
                                </div>
                            </div>
                            
                            <div id="examenes" class="tab-pane fade " style="padding: 20px;">
                                <div class="row">
                                    <button class="btn btn-default" style="float: right"> 
                                        <img src="images/excel.png" alt=""/> Importar
                                    </button>
                                     <button class="btn btn-default" style="float: right">    <img src="images/anadir.png" alt="" title="Agregar examen"/></button>
                                           
                                          <div class="panel panel-default">
                                              <div class="panel-heading" style="height: 50px;">
                                        <h3 class="panel-title"> 
                                            <b  style="float: left">  <img src="images/examenes.png" alt=""/> 
                                            Lista de Examenes</b> </h3>
                                                </div>
                                              <div class="panel-body">
                                                   <table id="lista_examenes" class="table table-bordered">
                                            <thead>
                                                <tr style="background-color: white;">
                                                    <th style="color:#214761">Código</th>
                                                    <th style="color:#214761">Código Cups   </th>
                                                    <th style="color:#214761">Examen</th>
                                                    <th style="color:#214761">Precio</th>
                                                    <th style="color:#214761">Estado</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $lista_examenes = $laboratorio->listar_laboratorio();
                                                foreach ($lista_examenes as $datos_examenes){?>
                                                <tr>
                                                    <td><?php echo $datos_examenes["codigo"] ?></td>
                                                    <td><?php echo $datos_examenes["codigo_cups"] ?></td>
                                                    <td><?php echo $datos_examenes["nombre"] ?></td>
                                                    <td><?php echo number_format($datos_examenes["precio"],0,",",".") ?></td>
                                                    <td><?php echo $datos_examenes["activo"] ?></td>
                                                   
                                                    
                                                </tr>
                                               <?php }
                                                
                                                ?>
                                            </tbody>
                                        </table>
                                              </div>
                                          </div>
                                </div>
                            </div>   
                            
                            
                              <div id="tipificaciones" class="tab-pane fade" style="padding: 20px;">
                                <div class="row">
                                    <button class="btn btn-default" style="float: right"> 
                                        <img src="images/excel.png" alt=""/> Importar
                                    </button>
                                     <button class="btn btn-default" style="float: right">    <img src="images/anadir.png" alt="" title="Agregar examen"/></button>
                                           
                                          <div class="panel panel-default">
                                              <div class="panel-heading" style="height: 50px;">
                                        <h3 class="panel-title"> 
                                            <b  style="float: left">  <img src="images/lista.png" alt=""/> 
                                           Tipificaciones</b> </h3>
                                                </div>
                                              <div class="panel-body">
                                                   <table id="lista_tipificacion" class="table table-bordered">
                                            <thead>
                                                <tr style="background-color: white;">
                                                    <th style="color:#214761">Grupo</th>
                                                    <th style="color:#214761">Nombre  </th>
                                                    
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $lista_tipificacion = $laboratorio->listar_tipificacion();
                                                foreach ($lista_tipificacion as $datos_tipificacion){?>
                                                <tr>
                                                    <td><?php echo $datos_tipificacion["grupo"] ?></td>
                                                    <td><?php echo $datos_tipificacion["nombre"] ?></td>
                                                    
                                                    
                                                </tr>
                                               <?php }
                                                
                                                ?>
                                            </tbody>
                                        </table>
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