<?php
require_once '../include/script_inicio.php';
//require_once '../include/script.php';
require_once '../include/header_administrador.php';
$array_permisos = explode(",", $_SESSION['PERMISOS']);
?>

<body>
   <?php if ($array_permisos[0] == "12") { ?>
        <ol class="breadcrumb">
            <li><a href="inicio_doc.php" title="Volver atras"><img src="images/atras.png"></a></li>
            <li><a href="inicio_doc.php" title="Inicio">Inicio</a></li>
            <li class="active">Administracion de resultados</li>
        </ol>
    <?php } else { ?>
        <ol class="breadcrumb">
            <li><a href="inicio_administrador.php" title="Volver atras"><img src="images/atras.png"></a></li>
            <li><a href="inicio_administrador.php" title="Inicio">Inicio</a></li>
            <li class="active">Administracion de resultados</li>
        </ol>
    <?php } ?>
    <div class="container-fluid">
        <div id="fh5co-hero">
            <div id="fh5co-main">

                <div class="fh5co-cards">
                    <div class="row">
                        <div class="col-lg-4 col-md-6 col-sm-6 animate-box">
                            <a class="fh5co-card" href="resultado_individual.php" style="padding-top: 10px;">
                                <center>
                                    <img class="rounded-circle img-fluid d-block mx-auto" src="images/ver_resu.png" height="100" width="100" alt="">
                                    <div class="fh5co-card-body">
                                        <h3>Ver resultados por paciente</h3>
                                    </div>
                                </center>
                            </a>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-6 animate-box">
                            <a class="fh5co-card" href="log_resultados.php"style="padding-top: 10px;">
                                <center>
                                    <img class="rounded-circle img-fluid d-block mx-auto" src="images/log_resu.png" height="100" width="100" alt="">
                                    <div class="fh5co-card-body">
                                        <h3>Log carga resultados</h3>
                                    </div>
                                </center>
                            </a>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>

    <!-- /.container -->

    <!-- Footer -->
    <?php require_once '../include/footer.php'; ?>

</body>


</html>
