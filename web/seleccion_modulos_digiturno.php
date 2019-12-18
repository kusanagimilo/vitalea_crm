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
}?>
<body style="background-color: #f5f5f5;">
    <div id="fh5co-hero">
      <div>
		<div class="fh5co-cards">
			<div class="container-fluid">
				<div class="row">
					<li style="margin-top: -80px"><a href="inicio_digiturno.php" title="Volver atras"><img src="images/atras.png"> Atras</a></li>
						<div class="col-lg-6 col-md-4 col-sm-6 animate-box">
		                	<a class="fh5co-card" href="inicio_digiturno_llamado_turno.php?modulo=1" style="padding-top: 10px;">
	                      		<center>
	                        		<img class="rounded-circle img-fluid d-block mx-auto" src="images/modulo.png" height="100" width="100" alt="">
			                            <div class="fh5co-card-body">
										    <h3>Modulo 1</h3>
			                            </div>
	                    		</center>
							</a>
						</div>
						<div class="col-lg-6 col-md-4 col-sm-6 animate-box">
			                <a class="fh5co-card" href="inicio_digiturno_llamado_turno.php?modulo=2" style="padding-top: 10px;">
			                    <center>
			                        <img class="rounded-circle img-fluid d-block mx-auto" src="images/modulo.png" height="100" width="100" alt="">
			                            <div class="fh5co-card-body">
											<h3>Modulo 2</h3>
			                            </div>
			                    </center>
							</a>
						</div>
						<div class="col-lg-6 col-md-4 col-sm-6 animate-box">
			                <a class="fh5co-card" href="inicio_digiturno_llamado_turno.php?modulo=3" style="padding-top: 10px;">
			                    <center>
			                        <img class="rounded-circle img-fluid d-block mx-auto" src="images/modulo.png" height="100" width="100" alt="">
			                            <div class="fh5co-card-body">
											<h3>Modulo 3</h3>
			                            </div>
			                    </center>
							</a>
						</div>
						<div class="col-lg-6 col-md-4 col-sm-6 animate-box">
			                <a class="fh5co-card" href="inicio_digiturno_llamado_turno.php?modulo=4" style="padding-top: 10px;">
			                    <center>
			                        <img class="rounded-circle img-fluid d-block mx-auto" src="images/modulo.png" height="100" width="100" alt="">
			                            <div class="fh5co-card-body">
											<h3>Modulo 4</h3>
			                            </div>
			                    </center>
							</a>
						</div>
					</div>
				</div>
			</div>
        </div>
    </div>
</body>
</html>