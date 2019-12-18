<?php 
require_once '../include/script.php';
require_once '../include/header_sin_menu.php';
require_once '../clase/Seguimiento.php';

$seguimiento = new Seguimiento();

$usuario_id = $_REQUEST["usuario_id"];
$fecha_programada = $_REQUEST["fecha"];
$estado = $_REQUEST["estado"];
$listar_seguimientos = $seguimiento->listar_seguimientos_programados_usuario_estado($usuario_id,$fecha_programada,$estado);
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

          $(".btn_seguimiento").click(function () {
                var cliente = $(this).data();
                var cliente_id = cliente.id;
                var programacion_id  = cliente.programacion;

                var usuario_id  = $("#usuario_id").val();            
                $.ajax({
                    url: '../controladores/Gestion.php',
                    data:
                            {
                                tipo: 22,
                                cliente_id:cliente_id,
                                usuario_id:usuario_id
                            },
                    type: 'post',
                    success: function (data)
                    {
                        window.location.href = "gestion.php?id="+data+"&callback="+programacion_id;
                        
                    }
                });
        });
    });
</script>
<body style="background-color: #F6F8FA">
<input type="hidden" id="usuario_id" value="<?php echo $_SESSION['ID_USUARIO'] ?>">
    <div class="main-menu-area mg-tb-40">
        <div class="container" style="height:auto;">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                    <div class="panel panel-default">
                        <div class="panel-heading " style="height: 50px;">
                            <h3 class="panel-title"> 
                                <b  style="float: left">  <img src="images/seguimiento_p.png" alt=""/> 
                                  Pacientes en seguimiento Volver a llamar</b> </h3> 
                        </div>
                        <div class="panel-body" >
                       
                            <div id="examenes" style="padding: 20px;" class="table table-responsive">
                                 <p style="font-size: 11pt;">
                                <img src="images/fecha.png" alt=""/> Fecha: <b><?php echo $fecha_programada; ?></b> </p> 


                                <table class="table table-striped" id="lista_seguimientos">
                                		<thead>
                                			<tr style="background-color: #214761;">
                                				<th data-priority="2" style="color:white"> Documento </th>
                                				<th  style="color:white"> Paciente </th>
                                				<th  style="color:white"> Telefonos</th>
                                				<th  style="color:white"> Email</th>
                                                <th  style="color:white"> Fecha Programada</th>
                                                <th  style="color:white"> Hora Programada</th>
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
                                                        <td> <?php echo $datos["documento"] ?></td>
                                                        <td> <?php echo $datos["nombre_paciente"] ?></td>
                                                        <td> <?php echo $datos["telefonos"] ?></td>
                                                        <td> <?php echo $datos["email"] ?></td>
                                                        <td> <?php echo $datos["fecha_programada"] ?></td>
                                                        <td> <?php echo $datos["hora_programada"] ?></td>
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