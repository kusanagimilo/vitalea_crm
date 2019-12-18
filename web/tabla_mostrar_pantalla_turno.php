<!DOCTYPE html>
<html>
<head>
	<title></title>
	 <link rel="stylesheet" type="text/css" href="css_inicio/style_mostrar_turno.css">
</head>
<?php                                       
require_once '../include/script_inicio.php';


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

    require_once '../clase/Turno.php';
    require_once '../clase/Cliente.php';

    $turno = new Turno();
    $cliente = new Cliente();

    $turno_actual_t        = $turno->modulo_actual_t();
    $turno_anterior_t      = $turno->modulo_anterior_t();
    $turno_anterior_2_t    = $turno->modulo_anterior_2_t();
    $turno_anterior_3_t    = $turno->modulo_anterior_3_t();

    $modulo_actual          = $turno->modulo_actual();
    $modulo_anterior        = $turno->modulo_anterior();
    $modulo_anterior_2      = $turno->modulo_anterior_2();
    $modulo_anterior_3      = $turno->modulo_anterior_3();

    $llamar_turno_actual    = $turno->llamar_turno_actual();
    $llamar_turno_anterior  = $turno->llamar_turno_anterior();
    $llamar_turno_anterior_2= $turno->llamar_turno_anterior_2();
    $llamar_turno_anterior_3= $turno->llamar_turno_anterior_3();

    $cliente_actual         = $cliente->cliente_actual();
    $cliente_anterior       = $cliente->cliente_anterior();
    $cliente_anterior_2     = $cliente->cliente_anterior_2();
    $cliente_anterior_3     = $cliente->cliente_anterior_3();

    $nombre_actual          = $cliente->nombre_paciente($cliente_actual);
    $apellido_actual        = $cliente->apellido_paciente($cliente_actual);

    $nombre_anterior        = $cliente->nombre_paciente($cliente_anterior);
    $apellido_anterior      = $cliente->apellido_paciente($cliente_anterior);

    $nombre_anterior_2      = $cliente->nombre_paciente($cliente_anterior_2);
    $apellido_anterior_2    = $cliente->apellido_paciente($cliente_anterior_2);

    $nombre_anterior_3      = $cliente->nombre_paciente($cliente_anterior_3);
    $apellido_anterior_3    = $cliente->apellido_paciente($cliente_anterior_3);


    if($turno_actual_t=='1'){
        $turno_actual_t='P_';
    }else if($turno_actual_t=='2'){
        $turno_actual_t='T_';
    }
    if($turno_anterior_t=='1'){
        $turno_anterior_t='P_';
    }else if($turno_anterior_t=='2'){
        $turno_anterior_t='T_';
    }
    if($turno_anterior_2_t=='1'){
        $turno_anterior_2_t='P_';
    }else if($turno_anterior_2_t=='2'){
        $turno_anterior_2_t='T_';
    }
    if($turno_anterior_3_t=='1'){
        $turno_anterior_3_t='P_';
    }else if($turno_anterior_3_t=='2'){
        $turno_anterior_3_t='T_';
    }

?>
<body>
<div class="row">
<div class="col-md-7">
<br>
<table class="redTable">
    <thead>
        <tr>
            <th>TURNO</th>
            <th>CLIENTE</th>
            <th>MODULO</th>
        </tr>
    </thead>
    <tbody>
        <tr style="border-color: #B900FF;">
            <td style="font-size:40px;color:#000;"><b><?php echo $turno_actual_t;?><?php printf('%03d', $llamar_turno_actual); ?></b></td>
            <td style="font-size: 40px;color:#000;"><b><?php echo ($nombre_actual." ".$apellido_actual);?></b></td>
            <td style="font-size: 40px;color:#000;"><b><?php echo $modulo_actual;?></b></td>
        </tr>
        <tr>
            <td><?php echo $turno_anterior_t;?><?php printf('%03d', $llamar_turno_anterior); ?></td>
            <td><?php echo ($nombre_anterior." ".$apellido_anterior);?></td>
            <td><?php echo $modulo_anterior;?></td>
        </tr>
        <tr>
            <td><?php echo $turno_anterior_2_t;?><?php printf('%03d', $llamar_turno_anterior_2); ?></td>
            <td><?php echo ($nombre_anterior_2." ".$apellido_anterior_2);?></td>
            <td><?php echo $modulo_anterior_2;?></td>
        </tr>
        <tr>
            <td><?php echo $turno_anterior_3_t;?><?php printf('%03d', $llamar_turno_anterior_3); ?></td>
            <td><?php echo ($nombre_anterior_3." ".$apellido_anterior_3);?></td>
            <td><?php echo $modulo_anterior_3;?></td>
        </tr>
    </tbody>
</table>
</div>  
<div class="col-md-4">
 <img src="../images/vitalea_logo.png" style="text-align: center; margin-top: 100px">
</div>
</div>
</body>
</html>