<?php

require_once '../clase/Gestion.php';
require_once '../clase/Cliente.php';

$gestion = new Gestion();
$cliente = new Cliente();

$tipo = $_POST["tipo"];


if($tipo==1){
    $documento = $_POST["documento"];
    
    $resultado = $gestion->id_cliente($documento);
    
        $datos_busqueda = $gestion->buscar_registro($resultado);
        echo $datos_busqueda;
   
}
else if($tipo==2){
    $tipo_documento     = $_POST["tipo_documento"];
    $numero_documento   = $_POST["numero_documento"];
    $nombre             = $_POST["nombre"];
    $apellido           = $_POST["apellido"];
    $fecha_nacimiento   = $_POST["fecha_nacimiento"];
    $estado_civil       = $_POST["estado_civil"];
    $telefono_uno       = $_POST["telefono_uno"];
    $telefono_dos       = $_POST["telefono_dos"];
    $email              = $_POST["email"];
    $ciudad             = $_POST["ciudad"];
    $barrio             = $_POST["barrio"];
    $direccion          = $_POST["direccion"];
    $sexo               = $_POST["sexo"];
    $estrato            = $_POST["estrato"];
    $tipo_cliente       = $_POST["tipo_cliente"];
    $usuario_id            = $_POST["usuario"];

    //perfilamiento

    $pregunta_1        = $_POST["pregunta_1"];
    $pregunta_2        = $_POST["pregunta_2"];
    $pregunta_3        = $_POST["pregunta_3"];
    $pregunta_4        = $_POST["pregunta_4"];
    $pregunta_5        = $_POST["pregunta_5"];
    $pregunta_6        = $_POST["pregunta_6"];
    $pregunta_7        = $_POST["pregunta_7"];
    $pregunta_8        = $_POST["pregunta_8"];
    $pregunta_9        = $_POST["pregunta_9"];
    $pregunta_10        = $_POST["pregunta_10"];
    $pregunta_11        = $_POST["pregunta_11"];
    $pregunta_12       = $_POST["pregunta_12"];
    $pregunta_13       = $_POST["pregunta_13"];
    $pregunta_14       = $_POST["pregunta_14"];
    $pregunta_15        = $_POST["pregunta_15"];
    $pregunta_16        = $_POST["pregunta_16"];
    $pregunta_17        = $_POST["pregunta_17"];
    $pregunta_18        = $_POST["pregunta_18"];
    $pregunta_19        = $_POST["pregunta_19"];
    $pregunta_20        = $_POST["pregunta_20"];
    $pregunta_21        = $_POST["pregunta_21"];
    $clasificacion       = $_POST["clasificacion"];

    echo $pregunta_16; 
    
    $registro = $gestion->id_cliente($numero_documento);

  
    if($registro == 0){ //NO EXISTEN REGISTROS
      
        $gestion->crear_cliente($tipo_documento, $numero_documento, $nombre, $apellido, $telefono_uno, $telefono_dos, $email, $fecha_nacimiento, $ciudad, $barrio, $direccion, $estado_civil,$sexo,$estrato,$tipo_cliente);

        $registro_titular = $gestion->id_cliente($numero_documento);
      

            if($tipo_cliente == "Tercero"){

                $tipo_documento_tercero     = $_POST["tipo_documento_tercero"];
                $numero_documento_tercero   = $_POST["numero_documento_tercero"];
                $nombre_tercero             = $_POST["nombre_tercero"];
                $apellido_tercero           = $_POST["apellido_tercero"];
                $fecha_nacimiento_tercero   = $_POST["fecha_nacimiento_tercero"];
                $sexo_tercero               = $_POST["sexo_tercero"];
                $parentesco                 = $_POST["parentesco"];

                
                $gestion->crear_tercero($tipo_documento_tercero, $numero_documento_tercero, $nombre_tercero, $apellido_tercero, $fecha_nacimiento_tercero, $sexo_tercero, $parentesco, $registro_titular); 
            }
           

            $gestion->ingresar_gestion($registro_titular,$usuario_id);
            $gestion_id = $gestion->gestion_id($registro_titular,$usuario_id,0);
       
            if($clasificacion==""){
                $clasificacion= 1;
            }
           $gestion->actulizar_cliente_clasisficacion($registro_titular,$clasificacion);


              $gestion->gurdar_repuesta_clasificacion(1,$pregunta_1,$registro_titular);
               $gestion->gurdar_repuesta_clasificacion(2,$pregunta_2,$registro_titular);
               $gestion->gurdar_repuesta_clasificacion(3,$pregunta_3,$registro_titular);
               $gestion->gurdar_repuesta_clasificacion(4,$pregunta_4,$registro_titular);
               $gestion->gurdar_repuesta_clasificacion(5,$pregunta_5,$registro_titular);
               $gestion->gurdar_repuesta_clasificacion(6,$pregunta_6,$registro_titular);
               $gestion->gurdar_repuesta_clasificacion(7,$pregunta_7,$registro_titular);
               $gestion->gurdar_repuesta_clasificacion(8,$pregunta_8,$registro_titular);
               $gestion->gurdar_repuesta_clasificacion(9,$pregunta_9,$registro_titular);
               $gestion->gurdar_repuesta_clasificacion(10,$pregunta_10,$registro_titular);
               $gestion->gurdar_repuesta_clasificacion(11,$pregunta_11,$registro_titular);
               $gestion->gurdar_repuesta_clasificacion(12,$pregunta_12,$registro_titular);
               $gestion->gurdar_repuesta_clasificacion(13,$pregunta_13,$registro_titular);
               $gestion->gurdar_repuesta_clasificacion(14,$pregunta_14,$registro_titular);
               $gestion->gurdar_repuesta_clasificacion(15,$pregunta_15,$registro_titular);
               $gestion->gurdar_repuesta_clasificacion(16,$pregunta_16,$registro_titular);
               $gestion->gurdar_repuesta_clasificacion(17,$pregunta_17,$registro_titular);
               $gestion->gurdar_repuesta_clasificacion(18,$pregunta_18,$registro_titular);
               $gestion->gurdar_repuesta_clasificacion(19,$pregunta_19,$registro_titular);
               $gestion->gurdar_repuesta_clasificacion(20,$pregunta_20,$registro_titular);
               $gestion->gurdar_repuesta_clasificacion(21,$pregunta_21,$registro_titular); 


             $id = base64_encode($gestion_id); 
    } 
    else{ // EXISTE UN REGISTRO CON ESE NUMERO DE DOCUMENTO
        $id = 0;
    }    

    echo $id;
    
}
else if($tipo==3){
    $medios_comunicacion = $gestion->medios_comunicacion();
    echo $medios_comunicacion;
}
else if($tipo==4){
    $id_cliente     = $_POST["id_cliente"];
    $datos_cliente = $gestion->buscar_registro($id_cliente);
    echo $datos_cliente;
}
else if($tipo==5){
    $laboratorio = $gestion->laboratorio();
    echo $laboratorio;
}
else if($tipo==6){
    $examen = $gestion->examen();
    echo $examen;
}
else if($tipo==7){
    $examen_id = $_POST["examen_id"];
    $detalles_examen = $gestion->detalles_examen($examen_id);
    echo $detalles_examen;
}
else if($tipo == 8){
    $cliente_id = $_POST["id_cliente"];
    $notas = $gestion->notas_cliente($cliente_id);
    echo $notas;
}
else if($tipo==9){
    $cliente_id = $_POST["id_cliente"];
    $usuario = $_POST["usuario"];
    $nota_textarea = $_POST["nota_textarea"];
    $gestion_id = $_POST["gestion_id"];

  $gestion->ingresar_nota($nota_textarea, $cliente_id, $usuario,$gestion_id);
    
   $notas = $gestion->notas_cliente($cliente_id);
    echo $notas;
   
}


else if($tipo==11){ /* REDIGIR Y GUARDAR GESTION */
    $cliente_id = $_POST["cliente_id"];
    $usuario_id = $_POST["usuario"];

    $gestion_id = $gestion->gestion_id($cliente_id,$usuario_id,0);

    if($gestion_id == 0){
        $gestion->ingresar_gestion($cliente_id,$usuario_id);
        $gestion_id = $gestion->gestion_id($cliente_id,$usuario_id,0);
    }
    
    $gestion_id = base64_encode($gestion_id);
    echo $gestion_id;
    
}
else if($tipo == 12){
    $medio_comunicacion_id = $_POST["medio_comunicacion_id"];

    $imagen = $gestion->imagen_medio_comunicacion($medio_comunicacion_id);
    echo $imagen;
}
else if($tipo == 13){

    $categoria_examen = $gestion->obtenerCategoriaExamen();
    echo $categoria_examen;
}

else if($tipo == 14){
    $categora_id = $_POST["categoria_id"];
    $examenes = $gestion->obtenerExamen($categora_id);
    echo $examenes;
}
else if($tipo == 15){ /* INGRESAR  Y LISTAR COTIZACION*/
    $examen_id          = $_POST["examen_descripcion"];
    $gestion_id         = $_POST["gestion_id"];
    $cliente_id         = $_POST["id_cliente"];
  
    $cotizacion_temporal = $gestion->cotizacion_temporal($examen_id,$cliente_id,$gestion_id);

    $examenes_cotizacion_temp = $gestion->consultar_cotizacion_temp($cliente_id,$gestion_id);
    echo $examenes_cotizacion_temp;

}


else if($tipo == 17){ /*LISTAR COTIZACION */

    $gestion_id         = $_POST["gestion_id"];
    $cliente_id         = $_POST["id_cliente"];
    
    $examenes_cotizacion_temp = $gestion->consultar_cotizacion_temp($cliente_id,$gestion_id);
    echo $examenes_cotizacion_temp;
}

else if($tipo == 18){ /* INGRESAR Y LISTAR CITA */
    $examen_id          = $_POST["examen_descripcion"];
    $gestion_id         = $_POST["gestion_id"];
    $cliente_id         = $_POST["id_cliente"];
  
    $cita_temporal = $gestion->cita_temporal($examen_id,$cliente_id,$gestion_id);

    $examenes_cita_temp = $gestion->consultar_cita_temp($cliente_id,$gestion_id);
    echo $examenes_cita_temp;

}

else if($tipo == 16){ /* ELIMINAR Y LISTAR COTIZACION */
    $examen_id      = $_POST["examen_id"];
    $eliminar = $gestion->eliminar_cotizacion_temp($examen_id);

    $gestion_id         = $_POST["gestion_id"];
    $cliente_id         = $_POST["id_cliente"];
    
    $examenes_cotizacion_temp = $gestion->consultar_cotizacion_temp($cliente_id,$gestion_id);
    echo $examenes_cotizacion_temp;
}
else if($tipo == 19){ /* ELIMINAR Y LISTAR CITA */
    $examen_id      = $_POST["examen_id"];
    $eliminar = $gestion->eliminar_cita_temp($examen_id);

    $gestion_id         = $_POST["gestion_id"];
    $cliente_id         = $_POST["id_cliente"];
    
    $examenes_cita_temp = $gestion->consultar_cita_temp($cliente_id,$gestion_id);
    echo $examenes_cita_temp;
}
else if($tipo == 20){ /*LISTAR COTIZACION */

    $gestion_id         = $_POST["gestion_id"];
    $cliente_id         = $_POST["id_cliente"];
    
    $examenes_cita_temp = $gestion->consultar_cita_temp($cliente_id,$gestion_id);
    echo $examenes_cita_temp;
}

else if($tipo == 21){ /*listar tercero*/
   $cliente_id         = $_POST["id_cliente"];

   $datos_tercero = $cliente->consultar_tercero($cliente_id);
   echo $datos_tercero;
   

}
elseif($tipo== 22){
    $cliente_id = $_POST["cliente_id"];
    $usuario_id = $_POST["usuario_id"];

    $gestion->ingresar_gestion($cliente_id,$usuario_id);
    $gestion_id = $gestion->gestion_id($cliente_id,$usuario_id,0);
         

     $id = base64_encode($gestion_id); 

     echo $id;
}


