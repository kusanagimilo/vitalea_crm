<?PHP //require_once '../include/script.php';
require_once '../include/script.php';
require_once '../include/header_administrador.php';

require_once '../clase/Bono.php';
$bono = new Bono();


$listado_bono_redimidos = $bono->lista_bonos_redimidos();
?>
<script type="text/javascript">
  $(document).ready(function() {
    $('#table_bono_redimidos').DataTable();
  });
</script>

<script type="text/javascript" src="../ajax/bono.js"></script>

<body style="background-color: #F6F8FA">
<input type="hidden" id="usuario_id" value="<?php echo $_SESSION['ID_USUARIO'] ?>">
    <div class="main-menu-area mg-tb-40">
        <div class="container" style="height:auto;">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <ol class="breadcrumb">
                        <li><a href="calendario.php" title="Volver atras"><img src="images/atras.png"></a></li>
                       
                        <li><a href="inicio_administrador.php" title="Inicio">Inicio</a></li>
                        <li><a href="comisiones_referencias.php" title="Inicio">Comisiones y referencias</a></li>
                        <li class="active">Bonos Redimidos</li>
                    </ol>

                    <div class="panel panel-default">
                        <div class="panel-heading " style="height: 50px;">
                            <h3 class="panel-title"> 
                              <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                  <b  style="float: left">  <img src="images/codigo-qr.png" alt=""/>Bonos Redimidos</b>
                              </div>

                              <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4" style="text-align: right;">
                                  <a href="comisiones_referencias.php"  style="color:white; font-style: bold" ><button type="button" class="btn btn-default" ><img src="../web/images/codigo-qr.png" alt="Bonos Redimidos" title="Bonos Redimidos" /> Asignar Bonos</button>
                                   </a>
                              </div> 
                              </h3>    
                        </div>
                        <div class="panel-body" >
                           <table class="table table-striped" id="table_bono_redimidos">
                              <thead>
                                <tr style="background-color: #214761;">
                                  <th style="color:white">Código QR</th>
                                  <th style="color:white">Codigo Dto.</th>
                                  <th style="color:white">Cliente</th>
                                  <th style="color:white">Fecha Redimidos</th>
                                  <th style="color:white">Activo</th>
                                </tr>
                              </thead>
                              <tbody>
                              <?php
                                foreach ($listado_bono_redimidos as $datos) { ?>
                                  <tr>
                                    <td> <img src="https://arcos-crm.com/crm_colcan/controladores/bonos/<?php echo $datos["url"] ?>" style="width: 30px;"></td>
                                    <td><?php echo $datos["codigo_bono"] ?></td>
                                    <td><?php echo $datos["cliente"] ?></td>
                                    <td><?php echo $datos["fecha_redencion"] ?></td>
                                    <td><?php echo $datos["activo"] ?></td>
                                  </tr>  
                                  
                               <?php } ?>
                               </tbody>
                            </table>
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

