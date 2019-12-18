<?PHP //require_once '../include/script.php';
require_once '../include/script.php';
require_once '../include/header_administrador.php';


$vista = $_REQUEST["v"];

$array_permisos = explode(",", $_SESSION['PERMISOS']);
$conteo = count($array_permisos);

if ($conteo == 1) {
    if (in_array("1", $array_permisos)) { // PERMISO CALL CENTER
        $permiso = 1;

    } else if (in_array("2", $array_permisos)) { //PERMISO PRESENCIAL
        $permiso = 2;
    }
}

?>


<script>
    $(document).ready(function ()
    {
    
        $('select').select2();

        $("#buscar").click(function () {
            var documento = $("#documento").val();

            $.ajax({
                url: '../controladores/Gestion.php',
                data:
                        {
                            tipo: 1,
                            documento: documento
                        },
                type: 'post',
                dataType: 'json',
                success: function (data)
                {


                    $.each(data, function (i, cliente) {
                        if (cliente.id == 0) {
                            alertify.alert("Registro no encontrado");
                        } else {
                            $("#div_informacion_cliente").empty();
                            $("#myModal").modal();
                          
                     var newRow  = '<table  border="1" style="width:60%; height:20px;" class="table table-condensed table-bordered table-responsive">';

                            newRow += "<tr class='success'><th>Tipo de documento</th><td style='white-space: nowrap; overflow: hidden;text-overflow: ellipsis;'>" + cliente.tipo_documento + "</td> </tr><tr><th>N° Documento</th><td style='white-space: nowrap; overflow: hidden;text-overflow: ellipsis;'>" + cliente.documento + "</td>  </tr>";
                            newRow += "<tr><th>Nombres</th><td style='white-space: nowrap; overflow: hidden;text-overflow: ellipsis;'>" + cliente.nombre_cliente + "</td></tr><tr><th>Apellidos</th><td style='white-space: nowrap; overflow: hidden;text-overflow: ellipsis;'>" + cliente.apellido_cliente + "</td></tr>";
                            newRow += "<tr class='success'><th>Fecha de Nacimiento</th><td style='white-space: nowrap; overflow: hidden;text-overflow: ellipsis;'>" + cliente.fecha_nacimiento + "</td></tr><tr><th >Email</th><td style='white-space: nowrap; overflow: hidden;text-overflow: ellipsis;'>" + cliente.id + "</td></tr>";
                            newRow += "<tr><th>Telefono 1</th><td style='white-space: nowrap; overflow: hidden;text-overflow: ellipsis;'>" + cliente.telefono_1 + "</td></tr><tr><th>Telefono 2</th><td style='white-space: nowrap; overflow: hidden;text-overflow: ellipsis;'>" + cliente.telefono_2 + "</td></tr>";
                            newRow += "<tr class='success'><th>Departamento</th><td style='white-space: nowrap; overflow: hidden;text-overflow: ellipsis;'>" + cliente.departamento + "</td></tr><tr><th>Ciudad</th><td style='white-space: nowrap; overflow: hidden;text-overflow: ellipsis;'>" + cliente.id + "</td></tr>";
                            newRow += "<tr><th>Barrio</th><td style='white-space: nowrap; overflow: hidden;text-overflow: ellipsis;'>" + cliente.barrio + "</td></tr><tr><th>Dirección</th><td style='white-space: nowrap; overflow: hidden;text-overflow: ellipsis;'>" + cliente.id + "</td></tr>";
                            newRow += "<tr class='success'><th>Estado civil</th><td style='white-space: nowrap; overflow: hidden;text-overflow: ellipsis;'>" + cliente.estado_civil + "</td></tr><tr><th>Sexo</th><td style='white-space: nowrap; overflow: hidden;text-overflow: ellipsis;'>" + cliente.sexo + "</td></tr>";
                            newRow += "<tr><th>Estrato</th><td style='white-space: nowrap; overflow: hidden;text-overflow: ellipsis;'>" + cliente.estrato + "</td></tr><tr><th>Estado</th><td style='white-space: nowrap; overflow: hidden;text-overflow: ellipsis;'>" + cliente.estado_cliente + "</td></tr>";
                            newRow += "<tr><th>Clasificación</th><td style='white-space: nowrap; overflow: hidden;text-overflow: ellipsis;'>" + cliente.clasificacion + "</td></tr></table>";
                            newRow += "<input id='cliente_id' value='" + cliente.id + "' type='hidden'>";
                            $(newRow).appendTo("#div_informacion_cliente");

                        }
                    });

                }
            });
        });

        $("#btn_gestionar_registro").click(function () {
            var cliente_id = $("#cliente_id").val();

            //alert(cliente_id);
            //return false;
            var usuario = $("#usuario").val();
            
            $.ajax({
                url: '../controladores/Gestion.php',
                data:
                        {
                            tipo: 11,
                            cliente_id: cliente_id,
                            usuario:usuario
                        },
                type: 'post',
                success: function (data)
                {

                   // console.log(data);
                    //return false;

                    if(data=="O"){
                        alertify.alert("Registro Ocupado \n El paciente esta siendo gestionado por otro asesor");
                    }else{
                        window.location.href = "gestion.php?id=" + data;
                    }
                    
                }
            });
        });

        $("#btn_ir_caja").click(function () {
            var cliente_id = $("#cliente_id").val();
            var usuario = $("#usuario").val();
            
            $.ajax({
                url: '../controlador/Caja.php',
                data:
                        {
                            tipo: 1,
                            cliente_id: cliente_id,
                            usuario:usuario
                        },
                type: 'post',
                success: function (data)
                {

                    if(data=="O"){
                        alertify.alert("Registro Ocupado \n El paciente esta siendo gestionado por otro asesor");
                    }else{
                        window.location.href = "ventas.php?id=" + data;
                    }
                   
                }
            });
        });

        //digiTurno
        $("#btn_pagar").click(function () {
            var cliente_id = $("#cliente_id").val();
            var usuario = $("#usuario").val();
            
            $.ajax({
                url: '../controladores/Generar_turno.php',
                data:
                        {
                            turno: 1,
                            cliente_id: cliente_id,
                            usuario:usuario
                        },
                type: 'post',
                success: function (data)
                {
                    window.location.href = "vista_turno.php?id=" + data;
                }
            });
        });
        $("#btn_toma_muestra").click(function () {
            var cliente_id = $("#cliente_id").val();
            var usuario = $("#usuario").val();
            
            $.ajax({
                url: '../controladores/Generar_turno.php',
                data:
                        {
                            turno: 2,
                            cliente_id: cliente_id,
                            usuario:usuario
                        },
                type: 'post',
                success: function (data)
                {
                    window.location.href = "vista_turno.php?id=" + data;
                }
            });
        });
        
  
    $("#js_up").slideDown(300);

    
});

</script>
<body style="background-color: #F6F8FA;">
     <input id="usuario" value="<?php echo $_SESSION['ID_USUARIO'] ?>" type="hidden" >

    <div class="main-menu-area mg-tb-40" style="min-height: 450px;">
        <div class="container" style="height:auto;">
            <div class="row">
            	
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <ol class="breadcrumb">
                        <?php if ($vista==3) {?>
                            <li><a href="inicio_digiturno_generar_turno.php" title="Volver atras"><img src="images/atras.png"></a></li>
                            <li><a href="inicio_digiturno.php" title="Inicio">Inicio</a></li>
                            <li><a href="inicio_digiturno_generar_turno.php" title="Inicio">Generar Turno</a></li>
                        <?php }else{ ?>
                        <li><a href="inicio_usuario.php" title="Volver atras"><img src="images/atras.png"></a></li>
                        <li><a href="inicio_usuario.php" title="Inicio">Inicio</a></li>
                        <?php } ?>
                        <li class="active">Buscar Paciente</li>
                    </ol>

                    <div class="panel panel-default">
                        <div class="panel-heading " style="height: 50px;">
                            <h3 class="panel-title"> 
                                <b  style="float: left">  <img src="images/buscar_cliente_1.png" alt=""/> 
                                Busqueda de paciente</b> </h3> 
                        </div>
                        <div class="panel-body" >
                            <div class="row pad-top" style="background-color: white; padding: 20px;">
                                      <p style=" font-size: 11pt;">
                                        <img src="images/info.png" alt=""/>
                                        Solicite el n&uacute;mero de documento y digitelo sin puntos. De clic en buscar.
                                </p><br>
                        
                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                        <div class="form-group">
                                            <span class="input-group-addon nk-ic-st-pro" style="float: left; width: 20%">
                                                <img src="images/cliente_1.png" alt="" style="width: 30px;"/>
                                            </span>
                                            <div class="nk-int-st"  style="float: left; width: 80%">
                                                <input name="documento" id="documento" class="form-control" type="text" placeholder=" Numero de documento"> 

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                        <div class="form-group">
                                             <button class="btn btn-info notika-btn-success waves-effect" id="buscar" style="width: 100%;">
                                    
                                                <img src="images/lupa.png" alt="" style="width: 20px;"/>
                                                Buscar</button> 
                                        </div>
                                    </div>    
                                </div>  
                        
                        </div>    
                    </div>
                </div>
            </div>
        </div>
    </div>    

<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header" style=" background-color: white;border-bottom: 1px solid #00c292;">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" style=" font-size: 15pt;">
                      <img src="images/cliente_1.png" alt="" style="width: 30px;"/> Informaci&oacute;n del cliente</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div id="div_informacion_cliente">
                        
                    </div>
                </div>
           
            </div>
            <div class="modal-footer">

                <h4><b> Seleccione una opcion </b></h4>
                   
            <?php if($vista == 1){?>
                <button type="button" class="btn btn-default" data-dismiss="modal" style="float: right;background-color: #ccc;border-color: #00c292;border:0px solid #ccc;outline:none;box-shadow:none;color:black">
                    <img src="images/cerrar.png" alt="" style="width: 20px"/>
                    Cancelar</button>
                <button class="btn btn-primary" id="btn_gestionar_registro" style="float: right;
                        background-image:linear-gradient(to bottom,#337ab7 0,#265a88 100%)">
                    <img src="images/finalizar.png" alt="" style="width: 20px"/>
                    Calificar Gestion</button>  
            <?php } ?>
            <?php if($vista == 2){?>
                    <button class="btn btn-success" id="btn_ir_caja" style="float: right;
                     ">
                    <img src="images/pago.png" alt="" style="width: 20px"/>
                    Generar Venta o Cotizacion</button>  
            <?php } 
            if($vista == 3){//digiturno?>
                    <button type="button" class="btn btn-default" data-dismiss="modal" style="float: right;background-color: #ccc;border-color: #00c292;border:0px solid #ccc;outline:none;box-shadow:none;color:black">
                    <img src="images/cerrar.png" alt="" style="width: 20px"/>
                    Cancelar</button>
                    <button class="btn btn-primary" id="btn_pagar" style="float: right;
                        background-image:linear-gradient(to bottom,#337ab7 0,#265a88 100%)">
                    <img src="images/finalizar.png" style="width: 20px"/>
                    Pagar</button>
                    <button class="btn btn-primary" id="btn_toma_muestra" style="float: right;
                        background-image:linear-gradient(to bottom,#337ab7 0,#265a88 100%)">
                    <img src="images/finalizar.png" style="width: 20px"/>
                    Tomar muestra</button>
            <?php } ?>  

            </div>
        </div>

    </div>
</div>  

</body>
<?php require_once '../include/footer.php'; ?>
</html>