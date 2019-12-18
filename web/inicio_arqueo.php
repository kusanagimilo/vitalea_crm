<?php
require_once '../include/script_inicio.php';
//require_once '../include/script.php';
require_once '../include/header_administrador.php';
$array_permisos = explode(",", $_SESSION['PERMISOS']);
$conteo = count($array_permisos);
?>


<body>
    <div class="container-fluid">

        <div id="fh5co-hero">
            <div id="fh5co-main">

                <div class="fh5co-cards">
                    <div class="col-lg-4 col-md-6 col-sm-6 animate-box">
                        <a class="fh5co-card" href="Arqueo.php" style="padding-top: 10px;">
                            <center>
                                <img class="rounded-circle img-fluid d-block mx-auto" src="images/arqueo.png" height="100" width="100" alt="">
                                <div class="fh5co-card-body">
                                    <h3>Arqueo</h3>
                                </div>
                            </center>
                        </a>
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
