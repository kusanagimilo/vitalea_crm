<?PHP require_once '../include/script.php';
require_once '../include/header_administrador.php';
require_once '../clase/Seguimiento.php';

$seguimiento = new Seguimiento();

?>
<script type="text/javascript">
    $(document).ready(function() {
        $('select').select2();
       

        $("#prospectos").click(function () {
            if( $('#prospectos').prop('checked') ) {
                $("#tipificaciones").prop( "disabled", true );
                $("#fecha_inicial").prop( "disabled", true );
                $("#fecha_final").prop( "disabled", true );
            }else{
                $("#tipificaciones").prop( "disabled", false );
                $("#fecha_inicial").prop( "disabled", false );
                $("#fecha_final").prop( "disabled", false );
            }
        });

        $("#checkTodos").change(function () {
            $("input:checkbox").prop('checked', $(this).prop("checked"));
        });  

        $("#btn_filtro").click(function () {
            filtro_seguimiento();
        });

        $('#lista_clientes').DataTable();

        $("#btn_asignar").click(function () {
            asignacion();
               
        });

});

</script>
<script type="text/javascript" src="../ajax/seguimiento.js"></script>
<body style="background-color: #F6F8FA">

<div class="main-menu-area mg-tb-40">
    <div class="container" style="height:auto;">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <ol class="breadcrumb">
                    <li><a href="inicio_administrador.php" title="Volver atras"><img src="images/atras.png"></a></li>
                   
                    <li><a href="inicio_administrador.php" title="Inicio">Inicio</a></li>
                    <li class="active">Seguimiento</li>
                </ol>

                <div class="row pad-top" style="background-color: white;">
                    <div id="examenes" style="padding: 20px;">
                        <div class="row">
                            <div class="panel panel-default">
                                <div class="panel-heading " style="height: 50px;">
                                    <h3 class="panel-title"> 
                                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                            <b  style="float: left">  <img src="images/seguimiento_p.png" alt=""/> Asignar Seguimiento</b>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4" style="text-align: right;">
                                            <a href="envio_datos_correo.php" class="btn btn-default"> <img src="images/email_correo.png" alt=""/> Envío de Correos Masivos </a>
                                        </div> </h3>
                                </div>
                                <div class="panel-body" >
                                   <p style="font-size: 11pt;">
                                        <img src="images/info.png" alt=""/>
                                        Seleccione las tipificaciones y rangos de fecha para realizar la busqueda de gestiones</p> 

                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                            <label> <img src="images/item.png"> Tipificaciones</label>
                                            <select class="mdb-select md-form colorful-select dropdown-primary" multiple id="tipificaciones" style="width: 100%">
                                                <?php 
                                                    $lista_tipificaciones = $seguimiento->listar_tipificaciones();

                                                    foreach ($lista_tipificaciones as $value) { ?>
                                                    <option value="<?php echo $value["id"] ?>"><?php echo $value["macro_proceso"]." - ".$value["nombre"] ?></option>
                                                <?php }?>
                                            </select>
                                        </div>

                                    
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                        
                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                                <label> <img src="images/fecha.png"> Fecha Inicial</label>
                                                <input name="fecha_inicial" id="fecha_inicial" type="date" class="form-control" placeholder="Fecha Inicial">
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                                <label> <img src="images/fecha.png"> Seleccione Fecha Final</label>
                                                <input name="fecha_final" id="fecha_final" type="date" class="form-control" placeholder="Fecha Final">
                                            </div>
                                         
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6"> <br>
                                                    <input type="checkbox" id="prospectos" > Prospectos
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                                    <br>
                                                    <button class="btn btn-primary" id="btn_filtro" style="width: 100%">  <img src="images/lupa.png" style="width: 20px;"> Iniciar Búsqueda</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div> 
                                </div>
                                    <div id="div_usuarios" style="display: none;padding: 5px;">   
                                        <div class="panel panel-default">
                                            <div class="panel-heading " style="height: 50px;">
                                                <h3 class="panel-title"> 
                                                    <b  style="float: left">  <img src="images/lupa.png" style="width: 20px;">
                                                    Resultados de la busqueda</b> </h3>
                                            </div>
                                            <div class="panel-body" >
                                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                                        <label> <img src="images/agregar-usuario.png"> Seleccione usuario(s)</label>
                                                        <select class="mdb-select md-form colorful-select dropdown-primary" multiple searchable="Search here.."  id="usuario_asignacion" style="width: 100%">
                                                            <?php 
                                                                $lista_seguimientos = $seguimiento->lista_usuarios(1);

                                                                foreach ($lista_seguimientos as $dato) { ?>
                                                                <option value="<?php echo $dato["usuario_id"] ?>"><?php echo $dato["usuario_id"]." - ".$dato["nombre"] ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6"><br>
                                                        <button class="btn btn-primary" style="float: right;" id="btn_asignar"> <img src="images/anadir_dos.png"> Asignar seguimiento </button>
                                                    </div>
                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-top: 10px;">    
                                                        <div id="resultados"></div> 
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
        </div>                     
    </div> 
</div> 

<?php require_once '../include/footer.php'; ?>

</body>

</html>