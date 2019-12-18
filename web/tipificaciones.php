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
        $('#lista_tipificacion').DataTable();
} );
    </script>
<body style="background-color: #F6F8FA">

    <div class="main-menu-area mg-tb-40">
        <div class="container" style="height:auto;">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                    <div class="row pad-top" style="background-color: white;">
                       
                     
                            
                              <div id="tipificaciones"  style="padding: 20px;">
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

    <!-- End Contact Info area-->
<?php require_once '../include/footer.php'; ?>

</body>

</html>