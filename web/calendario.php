<?php 
require_once '../include/script.php';
require_once '../include/header_administrador.php';

require_once '../clase/Seguimiento.php';

$seguimiento = new Seguimiento();
$listar_seguimientos = $seguimiento->listar_seguimientos_programados_calendario($_SESSION['ID_USUARIO']);
?>

<link href='css/fullcalendar.min.css' rel='stylesheet' />
<link href='css/fullcalendar.print.css' rel='stylesheet' media='print' />

<script src='js/moment.min.js'></script>

<script src='js/fullcalendar.min.js'></script>

<script src='js/es.js'></script>

<script type="text/javascript">
	$(document).ready(function() {
		$('#calendar').fullCalendar({
				locale: 'es',

				eventRender: function(eventObj, $el) {
		        $el.popover({
		          title: eventObj.title,
		          content: eventObj.description,
		          trigger: 'hover',
		          placement: 'right',
		          container: 'body'
		        });
		      },
			  events: [
				    <?php foreach ($listar_seguimientos as $datos) {  ?>	
	                    {
	                    	id: '<?php echo $datos["id_cliente"] ?>-<?php echo $datos["id"] ?>',
	                        title: '<?php echo $datos["nombre_paciente"] ?>' ,
	                        start: '<?php echo $datos["fecha_programada"] ?>',
	                        end: '<?php echo $datos["fecha_programada"] ?>',
	                        description: 'Hora: <?php echo $datos["hora_programada"] ?>'
	                                 
	                    },
                     <?php } ?>
				    // other events here
				  ],

				  eventClick: function(event) {
				  	
					 		var informacion_evento = event.id;
					 		var datos = informacion_evento.split('-');
					 		var cliente_id = datos[0];
					 		var programacion_id = datos[1];
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
			              
				  }


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
                        <li class="active">Seguimiento Programados</li>
                    </ol>

                    <div class="panel panel-default">
                        <div class="panel-heading " style="height: 50px;">
                            <h3 class="panel-title"> 
                            	<div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                            		<b  style="float: left">  <img src="images/fecha.png" alt=""/> Seguimientos activos que han sido programados para volver a llamar</b>
                            	</div>
                            	<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4" style="text-align: right;">
                            		<a href="seguimientos_programados.php" class="btn btn-default"> <img src="images/mas.png" alt=""/> Ver todos </a>
                            	</div>

                            </h3> 
                        </div>
                        <div class="panel-body" >
                       
                            <div id="examenes" style="padding: 10px;" class="table table-responsive">

                               <div class="table-responsive">
				                    <div id='wrap'>
				                        <div id='calendar' ></div>
				                           <div style='clear:both'></div>
				                      </div>  
				                </div>  
                               
                            </div>
                        </div>   
                    </div>
                </div>
            </div>                     
        </div>    
     </div>   
</body>

<?php require_once '../include/footer.php'; ?>