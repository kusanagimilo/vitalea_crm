<?PHP //require_once '../include/script.php';
require_once '../include/script.php';
require_once '../include/header_administrador.php';

$turno = $_GET["id"]; 
$numero_turno = $_GET["id_2"];


date_default_timezone_set('America/Bogota');
$fecha = date('d \d\e F \d\e Y.          g:i a');  

?>

<body style="background-color: #F6F8FA;">
     <input id="usuario" value="<?php echo $_SESSION['ID_USUARIO'] ?>" type="hidden" >

    <div class="main-menu-area mg-tb-40" style="min-height: 400px;">
        <div class="container" style="height:auto;">
            <div class="row">
                <center>
                    <?php if($turno==1){ ?>
                        <div class="col-md-12">
                            <div class="col-md-4"></div>
                            <div class="col-md-4" style="border: 3px solid black; border-top-left-radius: 25px; border-bottom-right-radius: 25px;">
                                <img src="../web/images/logo.png" width="30"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <label>BIENVENIDO(A)</label><br>
                                <label>SU TURNO</label>
                                <h5 style="font-size: 40px"><b>P_<?php printf('%03d', $numero_turno); ?></b></h5>
                                <?php echo $fecha ?>
                                <br><br>
                                
                            </div>
                            <div class="col-md-4"></div>
                        </div>
                    <?php  }elseif ($turno==2) { ?>
                        <div class="col-md-12">
                            <div class="col-md-4"></div>
                            <div class="col-md-4" style="border: 3px solid black; border-top-left-radius: 25px; border-bottom-right-radius: 25px;">
                                <img src="../web/images/logo.png" width="30"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <label>BIENVENIDO(A)</label><br>
                                <label>SU TURNO</label>
                                <h5 style="font-size: 40px"><b>T_<?php printf('%03d', $numero_turno); ?></b></h5>
                                <?php echo $fecha ?>
                            </div>
                            <div class="col-md-4"></div>
                        </div> <br><br><br><br><br><br>

                    <?php } ?>
                <div class="form-group">
                    <a class="fh5co-card" href="inicio_digiturno_generar_turno.php" style="padding-top: 10px;">
                        <button class="btn btn-info notika-btn-success waves-effect" id="regresar" style="width: 30%;">Regresar</button> 
                    </a>
                    <a class="fh5co-card" href="#" style="padding-top: 10px;">
                        <button class="btn btn-info notika-btn-success waves-effect" id="imprimir" style="width: 30%;">Imprimir</button> 
                    </a>
                </div>                  
                </center>
            </div>
        </div>
    </div>

</body>
<?php require_once '../include/footer.php'; ?>
</html>