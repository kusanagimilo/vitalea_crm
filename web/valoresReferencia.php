<?PHP
require_once '../include/script.php';
require_once '../include/header_administrador.php';
$array_permisos = explode(",", $_SESSION['PERMISOS']);
?>
<script src="../ajax/valoresRef.js" type="text/javascript"></script>
<style>
    .loader {
        border: 16px solid #f3f3f3;
        border-radius: 50%;
        border-top: 16px solid #3498db;
        width: 250px;
        height: 250px;
        -webkit-animation: spin 2s linear infinite; /* Safari */
        animation: spin 2s linear infinite;
    }

    /* Safari */
    @-webkit-keyframes spin {
        0% { -webkit-transform: rotate(0deg); }
        100% { -webkit-transform: rotate(360deg); }
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>
<body>
    <div class="main-menu-area mg-tb-40">
        <div class="container" style="height:auto;">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <ol class="breadcrumb">
                        <li><a href="administrador.php" title="Volver atras"><img src="images/atras.png"></a></li>
                        <li class="active">Valores de referencia</li>
                    </ol>

                    <div class="row pad-top" style="background-color: white;">

                        <div id="clientes" style="padding: 20px;">
                            <div class="row">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h3 class="panel-title"> 
                                            <img src="images/lista.png" alt=""/> 
                                            <b> Lista de valores de referencia</b></h3>
                                    </div>
                                    <div class="panel-body">

                                        <p style="font-size: 11pt;">
                                            <img src="images/info.png" alt="">
                                            En esta opcion podras consultar y crear los valores de referencia.
                                        </p>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <br>
                                                <button data-toggle="modal" data-target="#myModalPerfiles" class="btn btn-primary" id="btnCrearValorRef" style="width: 40%; margin-right: 40px; ">  <img src="images/lupa.png" style="width: 20px;">Crear valor de referencia</button>
                                                <button data-toggle="modal" data-target="#myModalPerfiles" class="btn btn-danger" id="btnModificarValorRef">Modificar valor de referencia </button>
                                            </div>
                                        </div>

                                        <br>

                                        <div id="tabla_valor_referencia" class="table-responsive">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> 


                    </div>

                </div>
            </div>
        </div>
    </div>
    <script>
        verValoresReferencia();
    </script>
    <?php require_once '../include/footer.php'; ?>
</body>
