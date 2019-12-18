<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" type="text/css" href="css_inicio/style_mostrar_turno.css">

</head>

<?php                                       
require_once '../include/script_inicio.php';
require_once '../include/header_administrador.php';


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

$llamar = $_REQUEST["llamar"];

if($llamar==1){ ?>   
<audio autoplay src="sonidos/aviso.mp3"></audio>
 <script>
$(document).ready(function() {
      var refreshId =  setInterval( function(){
    $('#tabla').load('tabla_mostrar_pantalla_turno.php');//actualizas el div
   }, 1000 );
});
</script>



<?php }else{ ?>
    <script>
$(document).ready(function() {
      var refreshId =  setInterval( function(){
    $('#tabla').load('tabla_mostrar_pantalla_turno.php');//actualizas el div
   }, 1000 );
});
</script>
<?php
}

?>
  
<body>
    <ol class="breadcrumb" >
    <li><a href="seleccion_modulos_digiturno.php" title="Volver atras"><img src="images/atras.png"></a></li>
    <li><a href="inicio_digiturno.php" title="Inicio">Atras</a></li>
    <li class="active">Turno en pantalla</li>
</ol>
<div id="tabla">

</div>

</body>
<br><br><br>
<?php require_once '../include/footer.php'; ?>
</html>