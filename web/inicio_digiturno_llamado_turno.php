<html>
<head>
<link rel="stylesheet" type="text/css" href="css_inicio/style_llamar_turno.css">
</head>

<body>
<?php
require_once '../include/script_inicio.php';
require_once '../include/header_administrador.php';
?>
<ol class="breadcrumb">
 <li><a href="seleccion_modulos_digiturno.php" title="Volver atras"><img src="images/atras.png"></a></li>
 <li><a href="seleccion_modulos_digiturno.php" title="Inicio">Atras</a></li>
 <li class="active">Datos Paciente</li>
</ol>
<script type="text/javascript">
    $.ajax({
                url: 'inicio_digiturno_mostrar_pantalla_turno.php',
                data:
                        {
                            llamar:1
                        },
                type: 'post'
            });
</script>
<?php
$modulo = $_REQUEST["modulo"];

$array_permisos = explode(",", $_SESSION['PERMISOS']);
$conteo = count($array_permisos);

if ($conteo == 1) {
    if (in_array("1", $array_permisos)) { // PERMISO CALL CENTER
        $permiso = 1;
    } else if (in_array("2", $array_permisos)) { //PERMISO PRESENCIAL
        $permiso = 2;
    } else if (in_array("6", $array_permisos)) { //PERMISO DIGITURNO  
        $permiso = 3;
    }
}

    $nombre     = 'Llame turno';
    $apellido   = 'Llame turno';
    $documento  = 'Llame turno';
    $direccion  = 'Llame turno';
    $telefono   = 'Llame turno';
    $ciudad     = 'Llame turno';

if (isset($_POST['llamar_cliente'])) {
    

    require_once '../clase/Turno.php';
    require_once '../clase/Cliente.php';

    $turno = new Turno();
    $cliente = new Cliente();

    $cliente_id = $turno->llamar_cliente_nuevo();
    $gestion_id = $turno->id_gestion(); 
   
      $nombre       = $cliente->nombre_paciente($cliente_id);
      $apellido     = $cliente->apellido_paciente($cliente_id);
      $documento    = $cliente->documento_paciente($cliente_id);
      $direccion    = $cliente->direccion_paciente($cliente_id);
      $telefono     = $cliente->telefono_paciente($cliente_id);
      $ciudad       = $cliente->ciudad_paciente($cliente_id);

?>
 <div class="panel panel-default">
    <div class="panel-heading" style="height: 50px;">
        <h3 class="panel-title">
            <div style="position:absolute; top:140px; left:35px;">
                <img src="images/icon-icons.png" alt="" style="width: 30px;">
            </div>
            <div style="position:absolute; top:145px; left:80px;">
                <b style="float: left">Datos del paciente</b>
            </div>
        </h3>
    </div>
    <div class="panel-body">
        <div style="background-color:#eee">
            <CENTER><H2>MODULO <?php echo $modulo ?></H2></CENTER>
        </div>
        <div class="col-md-7"><br>

            <table class="tabla_1">
                <tbody>
                <tr>
                    <th>Nombres</th>
                    <td><?php echo $nombre; ?></td>
                </tr>
                <tr>
                    <th>Apellidos</th>
                    <td><?php echo $apellido; ?></td>
                </tr>
                <tr>
                    <th>Cedula</th>
                    <td><?php echo $documento; ?></td>
                </tr>
                <tr>
                    <th>Direccion</th>
                    <td><?php echo $direccion; ?></td>
                </tr>
                <tr>
                    <th>Telefono</th>
                    <td><?php echo $telefono; ?></td>
                </tr>
                <tr>
                    <th>Ciudad</th>
                    <td><?php echo $ciudad; ?></td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="col-md-4">
            <img src="../images/vitalea_logo.png" style="text-align: center; margin-top: 100px">
        </div>
        <!--<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <div class="form-group">
                <div style="position:absolute; top:160px; left:50px;">
                    <div class="round-button-circle">
                        <center><br><br>
                            <button type="submit" id="">
                                <img src="images/lupa.png" alt="" style="width: 40px;"><p style="color:#FFFFFF";>Siguiente paciente</p>
                            </button>
                        </center>
                    </div>
                </div>
            </div>
        </div>-->
    </div>
</div>
<br>
<?php
$llamdo_cambio_modulo = $turno->modificar_llamdo($gestion_id,$modulo);
} 
?>
<form method="POST" >
<div style="width:740px">
  <button  class="btn btn-primary" name="llamar_cliente" id="llamar_cliente" style="float:right; background-image:linear-gradient(to bottom,#337ab7 0,#265a88 100%)">
    <img src="images/finalizar.png" style="width: 20px">llamar turno
  </button>
</div>
</form>

</body>
<br><br>
    <?php require_once '../include/footer.php'; ?>
</html>
