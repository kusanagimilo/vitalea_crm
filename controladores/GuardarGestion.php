<?php 
require_once '../clase/Cotizacion.php';
require_once '../clase/Cita.php';
require_once '../clase/Gestion.php';
require_once '../clase/Caja.php';
require_once '../clase/Seguimiento.php';


$cotizacion = new Cotizacion();
$cita = new Cita();
$gestion = new Gestion();
$caja = new Caja();
$seguimiento = new Seguimiento();

    $cliente_id = $_POST["id_cliente"];
    $gestion_id = $_POST["gestion_id"];
    $tipificacion_id = $_POST["tipificacion_id"];
    $usuario_id = $_POST["usuario_id"];
    $medios_comunicacion = $_POST["medios_comunicacion"];
    $observacion = $_POST["observacion"];
    $mensaje = $_POST["mensaje"];
    $fecha_programada = $_POST["fecha_programada"];
    $hora_programada = $_POST["hora_programada"];
    $callback = $_POST["callback"];
   
    /* INGRESAR MENSAJE DEL MEDIO DE COMUNICACION */

    if($medios_comunicacion < 8){
        $gestion->agregar_mensaje_medio_comunicacion($gestion_id,$medios_comunicacion,$mensaje);
    }


    /* ACTUALIZAR GESTION */                      
    $actualizar_gestion = $gestion->actualizar_gestion(0,0,$medios_comunicacion,$tipificacion_id,$usuario_id,$gestion_id);

    /* INGRESO NOTAS*/
      $gestion->ingresar_observacion($observacion,$gestion_id);

      //LIBERAR REGISTRO
      $gestion->liberar_registro($cliente_id,$usuario_id);

      //INGRESAR PROGRAMACION DE LLAMADA
      if($tipificacion_id == 76){
        if(!empty($fecha_programada)){
            $seguimiento->ingresar_programacion_llamada($cliente_id,$usuario_id,$fecha_programada,$hora_programada);
        }
        
      }

      //finalizar seguimiento
      if($callback != 0){
        $seguimiento->cerrar_programacion_llamada($callback);
      }

 

 ?>