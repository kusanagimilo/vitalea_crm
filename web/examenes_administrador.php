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
     
        $('#lista_examenes').DataTable();
} );
    </script>
<body style="background-color: #F6F8FA">

    <div class="main-menu-area mg-tb-40">
        <div class="container" style="height:auto;">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <ol class="breadcrumb">
                        <li><a  onclick="window.close()" title="Volver atras"><img src="images/atras.png"></a></li>
                       
                        <li><a onclick="window.close()" title="Inicio">Ventas y/o Cotizaciones</a></li>
                        <li class="active">Lista de Examenes </li>
                    </ol>

                    <div class="row pad-top" style="background-color: white;">
                      
                       
                            <div id="examenes" style="padding: 20px;">
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
                                                    <th style="color:#214761">Categoria</th>
                                                    <th style="color:#214761">Examen </th>
                                                    <th style="color:#214761">Precio Full</th>
                                                    <th style="color:#214761">Dto 5%</th>
                                                    <th style="color:#214761">Dto 10%</th>
                                                    <th style="color:#214761">Dto 15%</th>
                                                    <th style="color:#214761">Estado</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $lista_examenes = $laboratorio->listarExamenes();
                                                foreach ($lista_examenes as $datos_examenes){?>
                                                <tr>
                                                    <td><?php echo $datos_examenes["categoria"] ?></td>
                                                    <td><?php echo $datos_examenes["nombre"] ?></td>
                                                   
                                                    <td><?php echo number_format($datos_examenes["precio"],0,",",".") ?></td>
                                                    <td><?php echo number_format($datos_examenes["precio_menos_cinco"],0,",",".") ?></td>
                                                    <td><?php echo number_format($datos_examenes["precio_menos_diez"],0,",",".") ?></td>
                                                    <td><?php echo number_format($datos_examenes["precio_menos_quince"],0,",",".") ?></td>
                                                    <td>Activo</td>
                                                   
                                                    
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

    <!-- End Contact Info area-->
<?php require_once '../include/footer.php'; ?>

</body>

</html>