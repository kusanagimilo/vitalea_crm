<?PHP
require_once '../include/script.php';
require_once '../include/header_administrador.php';
$array_permisos = explode(",", $_SESSION['PERMISOS']);
?>

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
                        <li class="active">Examenes perfiles</li>
                    </ol>

                    <div class="row pad-top" style="background-color: white;">

                        <div id="clientes" style="padding: 20px;">
                            <div class="row">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h3 class="panel-title"> 
                                            <img src="images/lista.png" alt=""/> 
                                            <b> Lista de examenes perfiles</b></h3>
                                    </div>
                                    <div class="panel-body">

                                        <p style="font-size: 11pt;">
                                            <img src="images/info.png" alt="">
                                            En esta opcion podra crear examenes perfiles y adicionar examenes a estos
                                        </p>

                                        <div class="row">
                                            <div class="col-md-4">
                                                <br>
                                                <button onclick="LimpiarFormPerfil()" data-toggle="modal" data-target="#myModalPerfiles" class="btn btn-primary" id="btn_filtro" style="width: 100%">  <img src="images/lupa.png" style="width: 20px;">Crear examen perfil</button>
                                            </div>
                                        </div>

                                        <br>

                                        <div id="tabla_examen_perfil" class="table-responsive">

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
                        <img src="images/examen_venta.png" alt=""/>Ver y adicionar examenes</h4>
                </div>
                <div class="modal-body col-md-12" style="height: 400px; overflow : auto;" id="cuerpo_modal">
                    <div class="col-md-12">
                        <div class="col-md-3">
                            <label><img src="images/item.png"> Adicionar examen : </label>
                        </div>
                        <div class="col-md-6">
                            <select id="examen_no_perfil" style="width: 100%">
                                <option value=""> Seleccione</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <input id="boton_add_exam" type="button" value="Adicionar Examen" class="btn btn-default">
                        </div>

                    </div>
                    <br>
                    <div class="col-md-12" id="cont_modal_nexa">


                    </div>
                </div>          
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal" style="font-size: 11pt;"><img src="images/cerrar_dos.png"> Cerrar</button>
                </div>
            </div>                            
        </div>
    </div>

    <div class="modal" id="myModalPerfiles"  role="dialog" aria-labelledby="myModalLabel" >
        <div class="modal-dialog" style="width: 80%;">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #214761; color: white" >
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">
                        <img src="images/examen_venta.png" alt=""/>Adicionar perfil</h4>
                </div>
                <div class="modal-body col-md-12" style="height: 400px; overflow : auto;" id="cuerpo_modal">

                    <!-- formulario -->

                    <div class="form-group">
                        <label for="inputselect">* Seleccione el grupo para el perfil</label>
                        <select class="form-control" id="grupo_perfil">
                            <option value="seleccione">--seleccione--</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="inputtext">* Ingrese el nombre para el perfil</label>
                        <input type="text" class="form-control" id="nombre_perfil" placeholder="Nombre perfil">
                    </div>
                    <div class="form-group">
                        <label for="inputtext">* Ingrese el codigo (athenea) para el perfil</label>
                        <input type="text" class="form-control" id="codigo_perfil" placeholder="Codigo perfil">
                    </div>
                    <div class="form-group">
                        <label for="inputtext">* Ingrese el precio para el perfil</label>
                        <input type="number" class="form-control" id="precio_perfil" placeholder="Precio perfil">
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">Ingrese las recomendaciones para el perfil</label>
                        <textarea class="form-control" id="recomendaciones_perfil" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">Ingrese la preparacion para el perfil</label>
                        <textarea class="form-control" id="preparacion_perfil" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <button onclick="AlmacenarPerfil()" type="button" class="btn btn-primary btn-lg btn-block">Crear perfil</button>
                    </div>


                </div>          
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal" style="font-size: 11pt;"><img src="images/cerrar_dos.png"> Cerrar</button>
                </div>
            </div>                            
        </div>
    </div>


    <div class="modal" id="myModalPerfilesMod"  role="dialog" aria-labelledby="myModalLabel" >
        <div class="modal-dialog" style="width: 80%;">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #214761; color: white" >
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">
                        <img src="images/examen_venta.png" alt=""/>Modificar perfil</h4>
                </div>
                <div class="modal-body col-md-12" style="height: 400px; overflow : auto;" id="cuerpo_modal">

                    <!-- formulario -->

                    <div class="form-group">
                        <label for="inputselect">* Seleccione el grupo para el perfil</label>
                        <select class="form-control" id="grupo_perfil_mod">
                            <option value="seleccione">--seleccione--</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="inputtext">* Ingrese el nombre para el perfil</label>
                        <input type="text" class="form-control" id="nombre_perfil_mod" placeholder="Nombre perfil">
                    </div>
                    <div class="form-group">
                        <label for="inputtext">* Ingrese el codigo (athenea) para el perfil</label>
                        <input type="text" class="form-control" id="codigo_perfil_mod" placeholder="Codigo perfil">
                    </div>
                    <div class="form-group">
                        <label for="inputtext">* Ingrese el precio para el perfil</label>
                        <input type="number" class="form-control" id="precio_perfil_mod" placeholder="Precio perfil">
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">Ingrese las recomendaciones para el perfil</label>
                        <textarea class="form-control" id="recomendaciones_perfil_mod" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">Ingrese la preparacion para el perfil</label>
                        <textarea class="form-control" id="preparacion_perfil_mod" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <button onclick="" id="modi_perf" type="button" class="btn btn-primary btn-lg btn-block">Modificar perfil</button>
                    </div>


                </div>          
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal" style="font-size: 11pt;"><img src="images/cerrar_dos.png"> Cerrar</button>
                </div>
            </div>                            
        </div>
    </div>







    <script>
        VerExamenesNoPerfiles();
        //SelectExamenes();
        //$('#examen_no_perfil').select2();
        $("#examen_no_perfil").select2({
            ajax: {
                url: "../controladores/Gestion.php",
                type: "POST",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        searchTerm: params.term,
                        tipo: 32
                    };
                },
                processResults: function (response) {
                    return {
                        results: response
                    };
                },
                cache: true
            }
        });
        ListaGrupos();
    </script>

    <!-- End Contact Info area-->
    <?php require_once '../include/footer.php'; ?>

</body>
