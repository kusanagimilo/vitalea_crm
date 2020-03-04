<?PHP
require_once '../include/script.php';
require_once '../include/header_administrador.php';
$array_permisos = explode(",", $_SESSION['PERMISOS']);
?>

<script src="../ajax/Plan.js" type="text/javascript"></script>
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
                        <li class="active">Administrar planes</li>
                    </ol>

                    <div class="row pad-top" style="background-color: white;">

                        <div id="clientes" style="padding: 20px;">
                            <div class="row">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h3 class="panel-title"> 
                                            <img src="images/lista.png" alt=""/> 
                                            <b> Lista de planes</b></h3>
                                    </div>
                                    <div class="panel-body">

                                        <p style="font-size: 11pt;">
                                            <img src="images/info.png" alt="">
                                            Esta opcion permite la administracion de los planes
                                        </p>

                                        <div class="row">
                                            <div class="col-md-4">
                                                <br>
                                                <button  data-toggle="modal" data-target="#myModalPlanes" class="btn btn-primary" id="btn_filtro" style="width: 100%">  <img src="images/lupa.png" style="width: 20px;">Crear plan</button>
                                            </div>
                                        </div>

                                        <br>

                                        <div id="tabla_planes" class="table-responsive">

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

    <div class="modal" id="myModalPlanes"  role="dialog" aria-labelledby="myModalLabel" >
        <div class="modal-dialog" style="width: 80%;">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #214761; color: white" >
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">
                        <img src="images/examen_venta.png" alt=""/>Nuevo plan</h4>
                </div>
                <div class="modal-body col-md-12" style="height: 400px; overflow : auto;" id="cuerpo_modal">
                    <form enctype='multipart/form-data' method='post' name='fileinfo' id='frm_forms'> 
                        <!-- formulario -->
                        <div class="form-group">
                            <label for="inputtext">* Ingrese el codigo para el plan</label>
                            <input type="text" class="form-control" id="codigo_plan" placeholder="Codigo plan" name="codigo_plan">
                        </div>
                        <div class="form-group">
                            <label for="inputtext">* Ingrese el nombre de el plan</label>
                            <input type="text" class="form-control" id="nombre_plan" placeholder="Nombre plan" name="nombre_plan">
                        </div>

                        <div class="form-group">
                            <label for="inputtext">* Seleccione la opcion de carga de tarifas</label>
                            <div class="radio">
                                <label><input type="radio"  name="opcion_tarifa" value="1">Cargar tarifas actuales de el sistema</label>
                            </div>
                            <div class="radio">
                                <label><input type="radio"  name="opcion_tarifa" value="2">Carga tarifa mediante archivo CSV</label>
                            </div>
                        </div>

                        <div class="form-group" id="desicion">
                        </div>
                        <div class="form-group">
                            <button onclick="AlmacenarPlan()" type="button" class="btn btn-primary btn-lg btn-block">Crear plan</button>
                        </div>
                    </form>



                </div>          
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal" style="font-size: 11pt;"><img src="images/cerrar_dos.png"> Cerrar</button>
                </div>
            </div>                            
        </div>
    </div>


    <div class="modal" id="myModalPlanesItems"  role="dialog" aria-labelledby="myModalLabel" >
        <div class="modal-dialog" style="width: 80%;">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #214761; color: white" >
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">
                        <img src="images/examen_venta.png" alt=""/>Items por plan</h4>
                </div>
                <div class="modal-body col-md-12" style="height: 400px; overflow : auto;" id="cuerpo_modal">

                    <!-- formulario -->
                    <div class="form-group">
                        <div class="col-md-12"><label for="inputtext">Seleccione el tipo de item a mostrar</label></div>
                        <div class="col-md-6">
                            <select id="tipo_item" class="form-control">
                                <option value="">--seleccione--</option>
                                <option value="chequeo">ITEMS-CHEQUEOS</option>
                                <option value="examen">ITEMS-EXAMENES</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <button id="ver_itm_pl" type="button" class="btn btn-primary btn-lg btn-block">Ver items</button>
                        </div>
                    </div>

                    <div id="tabla_items_int">

                    </div>



                </div>          
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal" style="font-size: 11pt;"><img src="images/cerrar_dos.png"> Cerrar</button>
                </div>
            </div>                            
        </div>
    </div>


    <div class="modal" id="myModalEdtPlan"  role="dialog" aria-labelledby="myModalLabel" >
        <div class="modal-dialog" style="width: 80%;">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #214761; color: white" >
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">
                        <img src="images/examen_venta.png" alt=""/>Editar información plan</h4>
                </div>
                <div class="modal-body col-md-12" style="height: 400px; overflow : auto;" id="cuerpo_modal">
                    <form enctype='multipart/form-data' method='post' name='fileinfo' id='frm_forms_edt'> 
                        <!-- formulario -->
                        <div class="form-group">
                            <label for="inputtext">* Ingrese el codigo para el plan</label>
                            <input type="text" class="form-control" id="edt_codigo_plan" placeholder="Codigo plan" name="edt_codigo_plan">
                        </div>
                        <div class="form-group">
                            <label for="inputtext">* Ingrese el nombre de el plan</label>
                            <input type="text" class="form-control" id="edt_nombre_plan" placeholder="Nombre plan" name="edt_nombre_plan">
                        </div>
                        <div class="form-group">
                            <label for="inputtext">Seleccione el archivo csv de tarifas para anexar nuevas o modificar las existentes</label>
                            <input type="file" class="custom-file-input" id="archivo_edt" name="archivo_edt">
                        </div>
                        <div class="form-group">
                            <button onclick="" type="button" id="edt_btn_plan" class="btn btn-primary btn-lg btn-block">Editar plan</button>
                        </div>
                    </form>
                </div>          
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal" style="font-size: 11pt;"><img src="images/cerrar_dos.png"> Cerrar</button>
                </div>
            </div>                            
        </div>
    </div>



    <script>
        VerPlanes();
    </script>

    <!-- End Contact Info area-->
    <?php require_once '../include/footer.php'; ?>

</body>
