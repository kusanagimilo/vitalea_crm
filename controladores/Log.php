<?php
header("Content-Type: text/html;charset=utf-8"); 

require '../clase/Sesion.php';
$sesion = new Sesion();

$tipo = $_POST["tipo"];

if($tipo == 1){ //INGRESO ALMUERZO
  $fecha_inicio_almuerzo = $_POST["fecha_inicio_almuerzo"];
  $fecha_fin_almuerzo = $_POST["fecha_fin_almuerzo"];
  $usuario_id = $_POST["usuario_id"];
  $proceso = $_POST["proceso"];
  $tiempo_corriendo = $_POST["tiempo_corriendo"];


  $ingreso = $sesion->ingreso_log_usuario($usuario_id,$fecha_inicio_almuerzo,$fecha_fin_almuerzo,$proceso,$tiempo_corriendo);
}

else if($tipo == 2){
  $busqueda = $_POST["busqueda"];	

  if($busqueda == 1){ // por usuario
  	$usuario = $_POST["usuario"];	
  	$where = " AND l.usuario_id =".$usuario;
  }
  else if($busqueda == 2){
  	$tiempos_gestion = $_POST["tiempos_gestion"];
  	$where = " AND proceso =".$tiempos_gestion;
  }
   else if($busqueda == 3){
  	$fecha_inicio = $_POST["fecha_inicio"];
  	$where = " AND DATE(fecha_inicio) ='".$fecha_inicio."'";
  }
  else if($busqueda == 4){
  	$usuario = $_POST["usuario"];
  	$fecha_inicio = $_POST["fecha_inicio"];
  	$where = "AND l.usuario_id =".$usuario ." AND DATE(fecha_inicio) ='".$fecha_inicio."'";
  }
  else if($busqueda == 5){
  	$usuario = $_POST["usuario"];
  	$fecha_inicio = $_POST["fecha_inicio"];
  	$tiempos_gestion = $_POST["tiempos_gestion"];
  	$where = " AND l.usuario_id =".$usuario." AND proceso =".$tiempos_gestion ." AND DATE(fecha_inicio) ='".$fecha_inicio."'";
  }
  else if($busqueda == 6){
  	$usuario = $_POST["usuario"];
  	$tiempos_gestion = $_POST["tiempos_gestion"];
  	$where = " AND l.usuario_id =".$usuario." AND proceso =".$tiempos_gestion;
  }


  $resultados = $sesion->busqueda_registro_procesos($where);

  if(!empty($resultados)){
  	echo ' <table id="lista_tiempos_resultados" class="table table-bordered">
            <thead>
                <tr style="background-color: #214761;">
                    <th style="color:white">Perfil</th>
                    <th style="color:white">Usuario</th>
                    <th style="color:white">Nombre </th>
                    <th style="color:white">Proceso</th>
                    <th style="color:white">Fecha Inicio</th>
                    <th style="color:white">Fecha Fin</th>
                    <th style="color:white">Tiempo</th>
                </tr>
            </thead>
            <tbody>';
                foreach($resultados as $datos_tiempos){
           echo '<tr>
                    <td>'.$datos_tiempos["perfil"] .'</td>
                    <td>'. $datos_tiempos["usuario_id"] .'</td>
                    <td>'. $datos_tiempos["nombre"] .'</td>
                    <td>'. $datos_tiempos["proceso"] .'</td>
                    <td>'. $datos_tiempos["fecha_inicio"] .'</td>
                    <td>'. $datos_tiempos["fecha_fin"] .'</td>
                    <td>'. $datos_tiempos["tiempo"] .'</td>
                 </tr>';
           }
          echo '</tbody>
        </table>';
  }else{
  	echo "<center><p> No hay resultados </p></center>";
  }
}
else if($tipo == 3){ //ingresar temporal

  $fecha_inicial = $_POST["fecha_inicio_almuerzo"];
  $usuario_id = $_POST["usuario_id"];
  $proceso_id = $_POST["proceso"];

  $sesion->ingreso_log_usuario_temp($fecha_inicial,$usuario_id,$proceso_id);

}

elseif ($tipo == 4) {
  $log_usuario = $sesion->lista_log_usuario_temp();
  echo $log_usuario;
}
