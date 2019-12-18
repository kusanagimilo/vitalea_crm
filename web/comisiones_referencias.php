<?PHP
//require_once '../include/script.php';
require_once '../include/script.php';
require_once '../include/header_administrador.php';

require_once '../clase/Bono.php';
$bono = new Bono();

$listado_bono = $bono->lista_bonos_asignados();
$listado_bono_redimidos = $bono->lista_bonos_redimidos();
?>
<script type="text/javascript">
    $(document).ready(function () {

        $('#table_bono').DataTable();
        ListaPacientesBon();

        //lista_clasificacion();

        /* $("#lista_clasificacion").change(function () {
         var lista_clasificacion = $("#lista_clasificacion").val();
         lista_pacientes();
         });*/

        $("#bonos_redimidos").click(function () {
            $.blockUI({message: $('#myModalBonosRedimidos')});
        });


        $("#generar_codigo").click(function () {
            var cliente_id = $("#lista_paciente").val();
            var codigo_descuento = $("#codigo_descuento").val();
            var fecha_inicio = $("#fecha_inicio").val();
            var fecha_final = $("#fecha_final").val();
            var cantidad_descuento = $("#cantidad_descuento").val();

            if (cliente_id.length == 0) {
                alertify.alert("Seleccione el Paciente");
                return false;
            } else if (codigo_descuento.length == 0) {
                alertify.alert("Ingrese el Código de descuento");
                return false;
            } else if (fecha_inicio == "" || fecha_final == "") {
                alertify.alert("Ingrese la fecha de Vigencia");
                return false;
            } else if (cantidad_descuento.lenght == 0) {
                alertify.alert("Ingrese la cantidad de el descuento")
            }


            $.ajax({
                url: '../controladores/generar_codigo.php',
                data:
                        {
                            codigo_descuento: codigo_descuento,
                            cliente_id: cliente_id,
                            fecha_inicio: fecha_inicio,
                            fecha_final: fecha_final,
                            cantidad_descuento: cantidad_descuento
                        },
                type: 'post',
                success: function (data)
                {
                    if (data == 1) {
                        alertify.alert("El codigo ya existe no es posible generar codigo QR");
                    } else {
                        //$("#imagen").html("<img src='https://arcos-crm.com/crm_colcan/controladores/bonos/" + data + "'>");
                        alertify.alert("Codigo generado", function () {
                            location.reload();
                        });
                        //$("#table_bono").load(" #table_bono");

                    }

                }
            });
        });
    });

</script>
<script type="text/javascript" src="../ajax/bono.js"></script>

<body style="background-color: #F6F8FA">
    <input type="hidden" id="usuario_id" value="<?php echo $_SESSION['ID_USUARIO'] ?>">
    <div class="main-menu-area mg-tb-40">
        <div class="container" style="height:auto;">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <ol class="breadcrumb">
                        <li><a href="calendario.php" title="Volver atras"><img src="images/atras.png"></a></li>

                        <li><a href="inicio_administrador.php" title="Inicio">Inicio</a></li>
                        <li class="active">Comisiones y referencias</li>
                    </ol>

                    <div class="panel panel-default">
                        <div class="panel-heading " style="height: 50px;">
                            <h3 class="panel-title"> 
                                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                    <b  style="float: left">  <img src="images/codigo-qr.png" alt=""/> Comisiones y referencias</b>
                                </div>

                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4" style="text-align: right;">
                                    <a href="bonos_redimidos.php" style="color:white; font-style: bold" ><button type="button" class="btn btn-default" ><img src="../web/images/codigo-qr.png" alt="Bonos Redimidos" title="Bonos Redimidos" /> Bonos Redimidos</button>
                                    </a>
                                </div> 
                            </h3>    
                        </div>
                        <div class="panel-body" >
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                                <!--                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                                                    <label>Clasificacion Paciente</label>
                                                                    <select id="lista_clasificacion" class="form-control" style="width: 100%"></select>
                                                                </div>-->
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                    <label>Paciente</label>
                                    <select id="lista_paciente" class="form-control" style="width: 100%"></select>
                                </div>

                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                    <label>Fecha Inicio</label>
                                    <input type="date" min="<?php echo date("Y-m-d") ?>" id="fecha_inicio" class="form-control">
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                    <label>Fecha Final</label>
                                    <input type="date" min="<?php echo date("Y-m-d") ?>" id="fecha_final" class="form-control">
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                    <label>Ingresar codigo de descuento</label>
                                    <input type="text" id="codigo_descuento" class="form-control">
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                    <label>Cantidad de descuento del bono</label>
                                    <select id="cantidad_descuento" style="width: 100%" class="form-control">
                                        <option value="">--seleccione--</option>
                                        <option value="5000">-$5.000</option>
                                        <option value="10000">-$10.000</option>
                                    </select>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6"> <br>
                                    <button class="btn btn-primary" id="generar_codigo" style="width: 100%"><img src="images/finalizar_tres.png">Almacenar bono</button>
                                </div>
                            </div>

                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div id="imagen"></div>
                            </div>    
                        </div>
                    </div> 

                    <div class="panel panel-default">
                        <div class="panel-heading " style="height: 50px;">
                            <h3 class="panel-title"> 
                                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                    <b  style="float: left">  <img src="images/codigo-qr.png" alt=""/> Bonos Asignados</b>
                                </div>

                            </h3> 
                        </div>
                        <div class="panel-body" >
                            <div id="div_bono">
                                <table class="table table-striped" id="table_bono">
                                    <thead>

                                        <tr style="background-color: #214761;">

                                            <th style="color:white">Codigo Dto.</th>
                                            <th style="color:white">Dcoumento</th>
                                            <th style="color:white">Cliente</th>
                                            <th style="color:white">Fecha Incio</th>
                                            <th style="color:white">Fecha Final</th>
                                            <th style="color:white">Fecha Asignación</th>
                                            <th style="color:white">Valor descuento</th>
                                            <th style="color:white">Estado</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($listado_bono as $datos) { ?>
                                            <tr>

                                                <td><?php echo $datos["codigo_bono"] ?></td>
                                                <td><?php echo $datos["documento"] ?></td>
                                                <td><?php echo $datos["nombre"] . " " . $datos["apellido"] ?></td>
                                                <td><?php echo $datos["fecha_inicio"] ?></td>
                                                <td><?php echo $datos["fecha_final"] ?></td>
                                                <td><?php echo $datos["fecha_asignacion"] ?></td>
                                                <td> -$<?php echo $datos["cantidad_descuento"] ?></td>
                                                <td><?php
                                                    if ($datos["estado"] == 1) {
                                                        echo "Iniciado";
                                                    } else if ($datos["estado"] == 2) {
                                                        echo "Usado";
                                                    }
                                                    ?></td>
                                            </tr>  

                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>                     
    </div>    
</div>  

</body>

<?php require_once '../include/footer.php'; ?>
</html>

