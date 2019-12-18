<?PHP //require_once '../include/script.php';
require_once '../include/script.php';
require_once '../include/header_administrador.php';

?>


<script>
   $(document).ready(function ()
   
{
		  
	 $("#buscar").click(function () {
	 
            var documento = $("#documento").val();
	
        $.ajax(
	{
		url:'../controladores/Gestion.php',
		data:
		{
		                 tipo: 31,
                         documento: documento
		},
		type: 'post',
		contentType: "application/x-www-form-urlencoded;charset=utf-8",
		beforeSend: function ()
		{
				$("#tablas").html("Procesando, espere por favor");
		},
		success: function(data)
		{
			$('#tablas').html(data);
		}
	});
}); 

});
</script>
<body style="background-color: #F6F8FA;">
     <input id="usuario" value="<?php echo $_SESSION['ID_USUARIO'] ?>" type="hidden" >

    <div class="main-menu-area mg-tb-40" style="min-height: 450px;">
        <div class="container" style="height:auto;">
            <div class="row">
            	
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <ol class="breadcrumb">
                        
                        <li><a href="inicio_administrador.php" title="Volver atras"><img src="images/atras.png"></a></li>
                        <li><a href="inicio_administrador.php" title="Inicio">Inicio</a></li>
                     
                        <li class="active">Buscar Paciente</li>
                    </ol>
<!---------------/////////////--------->


                    <div class="panel panel-default">
                        <div class="panel-heading " style="height: 50px;">
                            <h3 class="panel-title"> 
                                <b  style="float: left">  <img src="images/buscar_cliente_1.png" alt=""/> 
                                Busqueda de paciente</b> </h3> 
                        </div>
                        <div class="panel-body" >
                            <div class="row pad-top" style="background-color: white; padding: 20px;">
                                      <p style=" font-size: 11pt;">
                                        <img src="images/info.png" alt=""/>
                                        Solicite el n&uacute;mero de documento y digitelo sin puntos. De clic en buscar.
                                </p><br>
                        
                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                        <div class="form-group">
                                            <span class="input-group-addon nk-ic-st-pro" style="float: left; width: 20%">
                                                <img src="images/cliente_1.png" alt="" style="width: 30px;"/>
                                            </span>
                                            <div class="nk-int-st"  style="float: left; width: 80%">
                                                <input name="documento" id="documento" class="form-control" type="text" placeholder=" Numero de documento"> 

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                        <div class="form-group">
                                             <button class="btn btn-info notika-btn-success waves-effect" id="buscar" style="width: 100%;">
                                    
                                                <img src="images/lupa.png" alt="" style="width: 20px;"/>
                                                Buscar</button> 
                                        </div>
                                    </div>    
                                </div>  
                        
                        </div>    
                    </div>
					
			
<!---------------/////////////--------->					
					<div>
					
					<table style="width:99%; margin:auto auto;" rules="none" id="tablas" class="table table-striped">
        <tr><th> <p style="font-size: 11pt;">
                                <img src="images/info.png" alt=""/> Historial de procesos realizados</p> 
</th></tr>
    </table>
					
					</div>
                </div>
            </div>
        </div>
    </div>    

  

</body>
<?php require_once '../include/footer.php'; ?>
</html>