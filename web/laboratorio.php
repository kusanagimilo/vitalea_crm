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
        $('#lista_laboratorios').DataTable();
} );
    </script>
<body style="background-color: #F6F8FA">

    <div class="main-menu-area mg-tb-40">
        <div class="container" style="height:auto;">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  

                    <div class="row pad-top" style="background-color: white;">
                         
                            <div id="laboratorios"  style="padding: 20px;">
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
                      
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- End Contact Info area-->
<?php require_once '../include/footer.php'; ?>

</body>

</html>