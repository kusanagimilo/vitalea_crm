<?php
require_once '../include/script_inicio.php';
//require_once '../include/script.php';
require_once '../include/header_administrador.php';
?>

<body>
    <div class="container-fluid">
        <div id="fh5co-hero">
            <div id="fh5co-main">

                <div class="fh5co-cards">
                    <div class="row">
                        <div class="col-lg-4 col-md-6 col-sm-6 animate-box">
                            <a class="fh5co-card" href="sub_menu_examenes.php" style="padding-top: 10px;">
                                <center>
                                    <img class="rounded-circle img-fluid d-block mx-auto" src="images/examenes_adm.png" height="100" width="100" alt="">
                                    <div class="fh5co-card-body">
                                        <h3>Administracion de examenes</h3>
                                    </div>
                                </center>
                            </a>
                        </div>

                        <div class="col-lg-4 col-md-6 col-sm-6 animate-box">
                            <a class="fh5co-card" href="sub_menu_resultados.php" style="padding-top: 10px;">
                                <center>
                                    <img class="rounded-circle img-fluid d-block mx-auto" src="images/ResulPr.png" height="100" width="100" alt="">
                                    <div class="fh5co-card-body">
                                        <h3>Resultados</h3>
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
