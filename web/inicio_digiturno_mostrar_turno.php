<?php
require_once '../include/script_inicio.php';
 require_once '../include/header_administrador.php';



$array_permisos = explode(",", $_SESSION['PERMISOS']);
$conteo = count($array_permisos);

if ($conteo == 1) {
    if (in_array("1", $array_permisos)) { // PERMISO CALL CENTER
        $permiso = 1;

    } else if (in_array("2", $array_permisos)) { //PERMISO PRESENCIAL
        $permiso = 2;
    } else if (in_array("6", $array_permisos)) { //PERMISO DIGITURNO
        $permiso = 3;
    }
}
?>
<body style="background-color: #f5f5f5;">
<div class="main-menu-area mg-tb-40" style="min-height: 450px;">
	<div class="container" style="height:auto;">
        <div id="fh5co-hero">
          <div  ><!--id="fh5co-main"-->
			<div class="fh5co-cards">
				<div class="container-fluid">
					<div class="row">
		                <li style="margin-top: -80px"><a href="inicio_digiturno.php" title="Volver atras"><img src="images/atras.png"> Atras</a></li>
		                <br>
						<div class="col-lg-4 col-md-6 col-sm-6 animate-box">
		                	<a class="fh5co-card" href="lectura_qr_digiturno.php" style="padding-top: 10px;">
	                      		<center>
	                        		<img class="rounded-circle img-fluid d-block mx-auto" src="images/codigo_qr.png" height="100" width="100" alt="">
			                            <div class="fh5co-card-body">
										    <h3>Buscar QR</h3>
			                            </div>
	                    		</center>
							</a>
						</div>
						<div class="col-lg-4 col-md-6 col-sm-6 animate-box">
			                <a class="fh5co-card" href="buscar_paciente.php?v=3" style="padding-top: 10px;">
			                    <center>
			                        <img class="rounded-circle img-fluid d-block mx-auto" src="images/equipo.png" height="100" width="100" alt="">
			                            <div class="fh5co-card-body">
											<h3>Buscar Paciente</h3>
			                            </div>
			                    </center>
							</a>
						</div>
					</div>
				</div>
			</div>
        </div>
    </div>
</div>
    <!-- /.container -->
    <!-- Footer -->
</body>
<?php require_once '../include/footer.php'; ?>
</html>