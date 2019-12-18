<?PHP require_once '../include/script.php';
require_once '../include/header_administrador.php';
require_once '../clase/Seguimiento.php';

$seguimiento = new Seguimiento();
 $lista_seguimientos = $seguimiento->consultar_seguimiento($_SESSION['ID_USUARIO']);
?>
<script type="text/javascript">
	$(document).ready(function() {
		 $('select').select2();

		  $("#checkTodos").change(function () {
		      $("input:checkbox").prop('checked', $(this).prop("checked"));
		  });

		  $('#lista_clientes').DataTable();

          $(".btn_seguimiento").click(function () {
               var cliente = $(this).data();
                var cliente_id = cliente.id;

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
                        console.log(data);
                             window.location.href = "gestion.php?id="+data;
                        
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
                    <ol class="breadcrumb">
                        <li><a href="inicio_usuario.php" title="Volver atras"><img src="images/atras.png"></a></li>
                       
                        <li><a href="inicio_usuario.php" title="Inicio">Inicio</a></li>
                        <li class="active">Seguimiento</li>
                    </ol>

                    <div class="panel panel-default">
                        <div class="panel-heading " style="height: 50px;">
                            <h3 class="panel-title"> 
                                <b  style="float: left">  <img src="images/seguimiento_p.png" alt=""/> 
                                  Registros para seguimiento y reventa</b> </h3> 
                        </div>
                        <div class="panel-body" >
                       
                            <div id="examenes" style="padding: 20px;">
                            	<table class="table table-striped" id="lista_clientes">
                            		<thead>
                            			<tr style="background-color: #214761;">
                                            <th  style="color:white"></th>
                            				<th  style="color:white"> Fecha Asignación</th>
                            				<th  style="color:white"> Documento </th>
                            				<th  style="color:white"> Paciente </th>
                            				<th  style="color:white"> Telefonos</th>
                            				<th  style="color:white"> Email</th>
                            				<th  style="color:white"> Tipo</th>
                            			</tr>
                            		</thead>
                            		<tbody>
                            			<?php 
                                            foreach ($lista_seguimientos as $datos) { ?>
                                               <tr>
                                                    <td> <button class="btn btn-default btn_seguimiento" data-id="<?php echo $datos["id_cliente"]?>" > <img src="images/calificacion.png"> Gestionar</button></td>
                                                    <td> <?php echo $datos["fecha_asignacion"] ?></td>
                                                    <td> <?php echo $datos["documento"] ?></td>
                                                    <td> <?php echo $datos["nombre"] ?></td>
                                                    <td> <?php echo $datos["telefono_1"]." , ".$datos["telefono_2"] ?></td>
                                                    <td> <?php echo $datos["email"] ?></td>
                                                    <td> <?php echo $datos["tipo_cliente"] ?></td>
                                                   
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