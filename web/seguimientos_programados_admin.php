<?php 
require_once '../include/script.php';
require_once '../include/header_administrador.php';
require_once '../clase/Seguimiento.php';

$seguimiento = new Seguimiento();
$listar_seguimientos = $seguimiento->listar_seguimientos_programados_calendario_admin();
?>
<script type="text/javascript">
	$(document).ready(function() {

		  $('#lista_seguimientos').DataTable({
                responsive: true,
                columnDefs: [
                    { responsivePriority: 1, targets: 0 },
                    { responsivePriority: 2, targets: -1 }
                ]
          });

          $
    });
</script>
<script src="../include/constante.js" ></script>
<body style="background-color: #F6F8FA">

    <div class="main-menu-area mg-tb-40">
        <div class="container" style="height:auto;">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <ol class="breadcrumb">
                        <li><a href="calendario.php" title="Volver atras"><img src="images/atras.png"></a></li>
                       
                        <li><a href="inicio_administrador.php" title="Inicio">Inicio</a></li>
                        <li><a href="calendario_administrador.php" title="Inicio">Calendario</a></li>
                        <li class="active">Seguimiento Programados</li>
                    </ol>

                    <div class="panel panel-default">
                        <div class="panel-heading " style="height: 50px;">
                            <h3 class="panel-title"> 
                                <b  style="float: left">  <img src="images/seguimiento_p.png" alt=""/> 
                                  Seguimientos programados para volver a llamar</b> </h3> 
                        </div>
                        <div class="panel-body" >
                       
                            <div id="examenes" style="padding: 20px;" class="table table-responsive">

                                <table class="table table-striped" id="lista_seguimientos">
                                		<thead>
                                			<tr style="background-color: #214761;">
                                                <th data-priority="1" style="color:white"></th>
                                				<th data-priority="2" style="color:white"> N° Seguimientos </th>
                                				<th  style="color:white"> Usuario </th>
                                				<th  style="color:white"> Fecha Programada</th>
                                				<th data-priority="3" style="color:white"> Estado</th>
                                			</tr>
                                		</thead>
                                		<tbody>
                                			<?php 
                                                foreach ($listar_seguimientos as $datos) { 
                                         
                                                    if($datos["activo"]== 1){
                                                       $color = "blue"; 
                                                       $estado = "Inicial";        
                                                    }
                                                    else if($datos["activo"]==0){
                                                        $color = "#56B338";
                                                        $estado = "Realizado"; 
                                                    }
                                                    else if($datos["activo"]==2){
                                                        $color = "red";
                                                        $estado = "Pendiente"; 
                                                    }
                                                    ?>
                                                   <tr>
                                                        <td> 
<a  href="javascript:VentanaCentrada('lista_programados.php?usuario_id=<?php echo $datos["usuario_id"] ?>&fecha=<?php echo $datos["fecha_programada"] ?>&estado=<?php echo $datos["activo"] ?>','Ventas','','1024','768','true')" >
                                                             <img src="images/historico.png" alt="" width="30px" /> Detalle
                                                          </a>      
                                                        
                                                          </td>
                                                        <td><b> <?php echo $datos["conteo"] ?></b></td>
                                                        <td> <?php echo $datos["nombre"] ?></td>
                                                        <td> <?php echo $datos["fecha_programada"] ?></td>
                                                       
                                                        <td style="color: <?php echo $color; ?>;"><b> <?php echo $estado ?></b></td>
                                                
                                                       
                                                    </tr>

                                              <?php  }  ?>
                                			
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

