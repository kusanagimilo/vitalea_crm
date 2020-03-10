<?PHP
require_once '../include/script.php';
require_once '../include/header_administrador.php';
$array_permisos = explode(",", $_SESSION['PERMISOS']);
?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<script src="../ajax/examen.js" type="text/javascript"></script>
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
                        <li><a href="sub_menu_examenes.php" title="Volver atras"><img src="images/atras.png"></a></li>
                        <li class="active">Examenes</li>
                    </ol>

                    <div class="row pad-top" style="background-color: white;">

                        <div id="clientes" style="padding: 20px;">
                            <div class="row">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h3 class="panel-title"> 
                                            <img src="images/lista.png" alt=""/> 
                                            <b> Lista de examenes</b></h3>
                                    </div>
                                    <div class="panel-body">

                                        <p style="font-size: 11pt;">
                                            <img src="images/info.png" alt="">
                                            En esta opcion se podra crear examenes y adicionar sub examenes a estos
                                        </p>

                                        <div class="row">
                                            <div class="col-md-4">
                                                <br>
                                                <button onclick="LimpiarExamen()" data-toggle="modal" data-target="#myModalExamen" class="btn btn-primary" id="btn_filtro" style="width: 100%">  <img src="images/lupa.png" style="width: 20px;">Crear examen</button>
                                            </div>
                                        </div>

                                        <br>

                                        <div id="tabla_examen" class="table-responsive">

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

    <!--<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" style="text-align: right;">                 
        <button type="button" id="openBtn" class="btn btn-default" data-toggle="modal" data-target="#myModalResultados"> <img src="images/anadir_dos.png"> Agregar examen</button>
    </div> -->
    <div class="modal" id="myModalResultados"  role="dialog" aria-labelledby="myModalLabel" >
        <div class="modal-dialog" style="width: 80%;">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #214761; color: white" >
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">
                        <img src="images/examen_venta.png" alt=""/>Ver y/o adicionar sub examenes</h4>
                </div>
                <div class="modal-body col-md-12" style="height: 400px; overflow : auto;" id="cuerpo_modal">
                    <div class="col-md-12">
                        <div class="col-md-2">
                            <label><img src="images/item.png">Adicionar examen</label>
                        </div>
                        <div class="col-md-4">
                            <input style="width:100%" id="codigo_sub_examen" type="text" placeholder="codigo sub examen">
                        </div>
                        <div class="col-md-4">
                            <input style="width:100%" id="nombre_sub_examen" type="text" placeholder="nombre sub examen">
                        </div>
                        <div class="col-md-2">
                            <input id="boton_add_subexa" type="button" value="Adicionar" class="btn btn-default">
                        </div>
                    </div>
                    <br>
                    <br>
                    <div class="col-md-12" id="cont_modal_subexamen">


                    </div>
                </div>          
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal" style="font-size: 11pt;"><img src="images/cerrar_dos.png"> Cerrar</button>
                </div>
            </div>                            
        </div>
    </div>

    <div class="modal" id="modalEditarExamen"  role="dialog" aria-labelledby="myModalLabel" >
        <div class="modal-dialog" style="width: 80%;">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #214761; color: white" >
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">
                        <img src="images/examen_venta.png" alt=""/> Editar examenes</h4>
                </div>
                <div class="modal-body col-8" style="height: 400px; overflow : auto;" id="cuerpo_modal">
                    <div class="col-8">
                        
                            <label><img src="images/item.png"> Estos son los parametros que podras modificar.</label><br>
                       
                            <input style="width:100%" id="codigoExamen" type="text" placeholder="Código" class="form-control"><br><br>                         
                            <input style="width:100%" id="nombreExamen" type="text" placeholder="Nombre" class="form-control"><br><br>                        
                            <input style="width:100%; display: none" id="precioExamen" type="text" placeholder="Precio" class="form-control"><br><br>                        
                            <input id="btnModificarExam" type="button" value="Modificar" class="btn btn-info">
                        
                    </div>
                    <br>
                    <br>
                    <div class="col-md-12" id="cont_modal_subexamen">


                    </div>
                </div>          
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal" style="font-size: 11pt;"><img src="images/cerrar_dos.png"> Cerrar</button>
                </div>
            </div>                            
        </div>
    </div>

    <div class="modal" id="myModalExamen"  role="dialog" aria-labelledby="myModalLabel" >
        <div class="modal-dialog" style="width: 80%;">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #214761; color: white" >
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">
                        <img src="images/examen_venta.png" alt=""/>Adicionar Examen</h4>
                </div>
                <div class="modal-body col-md-12" style="height: 400px; overflow : auto;" id="cuerpo_modal_exam">

                    <!-- formulario -->

                    <div class="form-group">
                        <label for="inputtext">* Ingrese el codigo (athenea) para el examen</label>
                        <input type="text" class="form-control" id="codigo_examen" placeholder="Codigo examen">
                    </div>
                    <div class="form-group">
                        <label for="inputtext">* Ingrese el nombre para el examen</label>
                        <input type="text" class="form-control" id="nombre_examen" placeholder="Nombre examen">
                    </div>
                    <div class="form-group">
                        <label for="inputtext">* Ingrese el precio para el examen</label>
                        <input type="number" class="form-control" id="precio_examen" placeholder="Precio examen">
                    </div>
                    <div class="form-group">
                        <button onclick="AlmacenarExamen()" type="button" class="btn btn-primary btn-lg btn-block">Crear examen</button>
                    </div>


                </div>          
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal" style="font-size: 11pt;"><img src="images/cerrar_dos.png"> Cerrar</button>
                </div>
            </div>                            
        </div>
    </div>




    <script src="sweetalert2.all.min.js"></script>
    <!-- Optional: include a polyfill for ES6 Promises for IE11 -->
    <script src="https://cdn.jsdelivr.net/npm/promise-polyfill"></script>
    <script>
        ListaExamenes();
    </script>

    <!-- End Contact Info area-->
    <?php require_once '../include/footer.php'; ?>

</body>
