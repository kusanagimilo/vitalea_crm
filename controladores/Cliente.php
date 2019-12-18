<?php
//CONTROLADOR CREAR CLIENTE NUEVO

require_once '../clase/Cliente.php';
require_once '../clase/Gestion.php';

$cliente = new Cliente();
$gestion = new Gestion();

$tipo = $_POST["tipo"];
if($tipo ==1){ //CONSULTA EL TIPO DE DOCUMENTO
    $tipos_documento = $cliente->consultar_tipo_documento();
    echo $tipos_documento;
}
else if($tipo==2){ // CONSULTA LAS OPCIONES DE ESTADO CIVIL
    $estado_civil = $cliente->consultar_estado_civil();
    echo $estado_civil;
}
else if($tipo==3){ // CONSULTA LA LISTA DE DEPARTAMENTOS
    $departamento = $cliente->consultar_departamento();
    echo $departamento;
}
else if($tipo==4){// CONSULTA LA LISTA DE CIUDADES DE ACUERDO A LA SELECCION DEL DEPARTAMENTO
    $departamento_id = $_POST["departamento_id"];
    $ciudad = $cliente->consultar_ciudad($departamento_id);
    echo $ciudad;
}
else if($tipo ==5){
    $macro_proceso = $cliente->consultar_macro_tipificacion();
    echo $macro_proceso;
}
else if($tipo==6){ //LISTA DE TIPIFICACIONES DE ACUERDO A LA SELECCION DE MACRO PROCESO
    $macro_proceso_id = $_POST["macro_proceso"];
    $permiso= $_POST["permiso"];

    $modulo = '3,'.$permiso;


    $subprocesos = $cliente->consultar_tipificaciones($macro_proceso_id,$modulo);
    echo '<option value="">Seleccione</option>';
    foreach ($subprocesos as $dato){
        echo ' <optgroup label="'.$dato["nombre"].'" style="color:red">';
        $tipificaciones = $cliente->consultar_tipificaciones($dato["id"],$modulo);
            foreach ($tipificaciones as $datos){
                echo '<option value="'.$datos["id"].'">'.$datos["nombre"].'</option>';
            }
    }
}
else if($tipo==7){// CONSULTA LA LISTA DE LAS SECCIONES PARA ARMAR LA DIRECCION
    $seccion = $cliente->direccion_seccion();
    echo $seccion;
}
else if($tipo == 8){
    $parentesco = $cliente->parentesco();
    echo $parentesco;
    
}
else if($tipo == 9){ //actualizar datos Paciente y Tercero

    $tipo_documento             = $_POST["tipo_documento"];
    $nombre                     = $_POST["nombre"];
    $apellido                   = $_POST["apellido"];
    $numero_documento           = $_POST["numero_documento"];
    $telefono_uno               = $_POST["telefono_uno"];
    $telefono_dos               = $_POST["telefono_dos"];
    $email                      = $_POST["email"];
    $sexo                       = $_POST["sexo"];
    $fecha_nacimiento           = $_POST["fecha_nacimiento"];
    $estado_civil               = $_POST["estado_civil"];
    $departamento               = $_POST["departamento"];
    $ciudad                     = $_POST["ciudad"];
    $barrio                     = $_POST["barrio"];
    $estrato                    = $_POST["estrato"];
    $direccion_actualizar       = $_POST["direccion_actualizar"];
    $usuario_id                 = $_POST["usuario_id"];
    $cliente_id                 = $_POST["cliente_id"];
    $tipo_cliente               = $_POST["tipo_cliente"];


    //ESTABLECER SI ACTUALIZA O INGRESA NUEVOS DATOS DE TERCERO

    $tipo_cliente_actual = $cliente->obtener_tipo_cliente($cliente_id);


    if($tipo_cliente_actual != $tipo_cliente){ // INGRESAR NUEVO TERCERO

        //ACTUALIZAR TIPO DEL CLIENTE
        $cliente-> actualizar_tipo_cliente($tipo_cliente, $cliente_id);

    }

    if($tipo_cliente == "Tercero"){ //EXTRAER INFORMACION DE TABLA TEMPORAL

        $informacion_terceros= $cliente->consultar_terceros_temp($numero_documento);

        $titular_id = $gestion->id_cliente($numero_documento);

        if(!empty($informacion_terceros)){
            foreach ($informacion_terceros as $dato) {
                 $gestion->crear_tercero($dato["tipo_documento_id"], $dato["documento"], $dato["nombre"], $dato["apellido"], $dato["fecha_nacimiento"], $dato["sexo"], $dato["parentesco_id"], $titular_id); 

                 $cliente->eliminar_tercero_temp($dato["id"]);
            }
        }      
    }

    //ACTUALIZAR DATOS DEL TITULAR


    $cliente->actualizar_cliente($tipo_documento,$numero_documento,$nombre,$apellido,$telefono_uno,$telefono_dos,$email,$fecha_nacimiento,$ciudad,$barrio,$direccion_actualizar,$estado_civil,$sexo,$estrato,$cliente_id);


    echo 1;

}
 else if($tipo == 10){
    $tipo_documento_tercero     = $_POST["tipo_documento_tercero"];
    $numero_documento_tercero   = $_POST["numero_documento_tercero"];
    $nombre_tercero             = $_POST["nombre_tercero"];
    $apellido_tercero           = $_POST["apellido_tercero"];
    $fecha_nacimiento_tercero   = $_POST["fecha_nacimiento_tercero"];
    $sexo_tercero               = $_POST["sexo_tercero"];
    $parentesco                 = $_POST["parentesco"];
    $usuario_id                 = $_POST["usuario_id"];
    $tercero_id                 = $_POST["tercero_id"];

    $cliente->actualizar_tercero($tipo_documento_tercero,$numero_documento_tercero,$nombre_tercero,$apellido_tercero,$fecha_nacimiento_tercero,$sexo_tercero,$parentesco,$tercero_id);

    echo 1;
 }


