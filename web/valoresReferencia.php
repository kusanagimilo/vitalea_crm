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
                        <li><a href="inicio_administrador.php" title="Volver atras"><img src="images/atras.png"></a></li>
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
                                                <button data-toggle="modal" data-target="#myValoresRef" class="btn btn-primary" id="btnModal" style="width: 40%; margin-right: 40px; ">Crear valor de referencia</button>
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

    <div class="modal" id="myValoresRef"  role="dialog" aria-labelledby="myModalLabel" >
        <div class="modal-dialog" style="width: 80%;">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #214761; color: white" >
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">
                        <img src="images/examen_venta.png" alt=""/>Adicionar valor de referencia</h4>
                </div>
                <div class="modal-body col-md-12" style="height: 400px; overflow : auto;" id="cuerpo_modal">

                    <!-- formulario -->

                    <div class="form-group">
                        <label for="inputselect">* Seleccione el examen</label>
                        <select class="form-control" id="ref_examen">
                            <option value="seleccione">--seleccione--</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="inputtext">* Ingrese la medida</label>
                        <input type="text" class="form-control" id="ref_medida" placeholder="Medida">
                    </div>
                    <div class="form-group">
                        <label for="inputtext">* Ingrese la unidad</label>
                        <input type="text" class="form-control" id="ref_unidad" placeholder="Unidad">
                    </div>
                    <div class="form-group">
                        <label for="inputtext">* Ingrese valor critico inferior</label>
                        <input type="text" class="form-control" id="ref_unidad" placeholder="valor critico inferior">
                    </div>
                    <div class="form-group">
                        <label for="inputtext">* Ingrese valor critico superior</label>
                        <input type="text" class="form-control" id="ref_unidad" placeholder="valor critico superior">
                    </div>
                    <div class="form-group">
                        <label for="inputtext">* Ingrese anormal disminuido minimo</label>
                        <input type="text" class="form-control" id="ref_unidad" placeholder="anormal disminuido minimo">
                    </div>
                    <div class="form-group">
                        <label for="inputtext">* Ingrese anormal disminuido maximo</label>
                        <input type="text" class="form-control" id="ref_unidad" placeholder="anormal disminuido maximo">
                    </div>
                    <div class="form-group">
                        <label for="inputtext">* Ingrese rango normal minimo</label>
                        <input type="text" class="form-control" id="ref_unidad" placeholder="rango normal minimo">
                    </div>
                    <div class="form-group">
                        <label for="inputtext">* Ingrese rango normal maximo</label>
                        <input type="text" class="form-control" id="ref_unidad" placeholder="rango normal maximo">
                    </div>
                    <div class="form-group">
                        <label for="inputtext">* Ingrese anormal incrementado minimo</label>
                        <input type="text" class="form-control" id="ref_unidad" placeholder="anormal incrementado minimo">
                    </div>
                    <div class="form-group">
                        <label for="inputtext">* Ingrese anormal incrementado maximo</label>
                        <input type="text" class="form-control" id="ref_unidad" placeholder="anormal incrementado maximo">
                    </div>
                    <div class="form-group">
                        <label for="inputselect">* Seleccione la unidad de edad</label>
                        <select class="form-control" id="ref_examen">
                            <option value="">--seleccione--</option>
                            <option value="ANIOS">ANIOS</option>
                            <option value="MESES">MESES</option>
                            <option value="DIAS">DIAS</option>
                            <option value="DIAS">N/A</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="inputtext">* Ingrese edad minima</label>
                        <input type="text" class="form-control" id="ref_unidad" placeholder="edad minima">
                    </div>
                    <div class="form-group">
                        <label for="inputtext">* Ingrese edad maxima</label>
                        <input type="text" class="form-control" id="ref_unidad" placeholder="edad maxima">
                    </div>
                    <div class="form-group">
                        <label for="inputselect">* Seleccione el sexo</label>
                        <select class="form-control" id="ref_examen">
                            <option value="">--seleccione--</option>
                            <option value="Maculino">Maculino</option>
                            <option value="Femenino">Femenino</option>
                            <option value="Ambos">Ambos</option>
                            <option value="N/A">N/A</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <button  type="button" class="btn btn-primary btn-lg btn-block">Crear valor de referencia</button>
                    </div>


                </div>          
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal" style="font-size: 11pt;"><img src="images/cerrar_dos.png"> Cerrar</button>
                </div>
            </div>                            
        </div>
    </div>



    <script>

        //Llamamos la Funcion que nos trae todos los valores de referencia a mostrar.
        verValoresReferencia();
    </script>
    <?php require_once '../include/footer.php'; ?>
</body>
