<?php

require_once '../clase/Gestion.php';
require_once '../clase/Cliente.php';

$gestion = new Gestion();
$cliente = new Cliente();

$tipo = $_POST["tipo"];


if ($tipo == 1) { //BUSQUEDA DE REGISTRO
    $documento = $_POST["documento"];

    $resultado = $gestion->id_cliente($documento);

    $datos_busqueda = $gestion->buscar_registro($resultado);
    echo $datos_busqueda;
} else if ($tipo == 2) { //INGRESO NUEVO CLIENTE
    $tipo_documento = $_POST["tipo_documento"];
    $numero_documento = $_POST["numero_documento"];
    $nombre = $_POST["nombre"];
    $apellido = $_POST["apellido"];
    $fecha_nacimiento = $_POST["fecha_nacimiento"];
    $estado_civil = $_POST["estado_civil"];
    $telefono_uno = $_POST["telefono_uno"];
    $telefono_dos = $_POST["telefono_dos"];
    $email = $_POST["email"];
    $ciudad = $_POST["ciudad"];
    $barrio = $_POST["barrio"];
    $direccion = $_POST["direccion"];
    $sexo = $_POST["sexo"];
    $estrato = $_POST["estrato"];
    $tipo_cliente = $_POST["tipo_cliente"];
    $usuario_id = $_POST["usuario"];
    $edad = $_POST['edad'];  
    //$firma = $_POST['firma'];  

    //perfilamiento

     //$pregunta_1 = $_POST["pregunta_1"];
    //$pregunta_2 = $_POST["pregunta_2"];
    /*$pregunta_3 = $_POST["pregunta_3"];
    $pregunta_4 = $_POST["pregunta_4"];
    $pregunta_5 = $_POST["pregunta_5"];
    $pregunta_6 = $_POST["pregunta_6"];
    $pregunta_7 = $_POST["pregunta_7"];
    $pregunta_8 = $_POST["pregunta_8"];
    $pregunta_9 = $_POST["pregunta_9"];
    $pregunta_10 = $_POST["pregunta_10"];
    $pregunta_11 = $_POST["pregunta_11"];
    $pregunta_12 = $_POST["pregunta_12"];
    $pregunta_13 = $_POST["pregunta_13"];
    $pregunta_14 = $_POST["pregunta_14"];
    $pregunta_15 = $_POST["pregunta_15"];
    $pregunta_16 = $_POST["pregunta_16"];
    $pregunta_17 = $_POST["pregunta_17"];
    $pregunta_18 = $_POST["pregunta_18"];
    $pregunta_19 = $_POST["pregunta_19"];
    $pregunta_20 = $_POST["pregunta_20"];
    $pregunta_21 = $_POST["pregunta_21"];*/
    $pregunta_22 = $_POST["pregunta_22"];
    $pregunta_23 = $_POST["pregunta_23"];
    $clasificacion = $_POST["clasificacion"];

    $registro = $gestion->id_cliente($numero_documento);


    if ($registro == 0) { //NO EXISTEN REGISTROS
        $gestion->crear_cliente($tipo_documento, $numero_documento, $nombre, $apellido, $telefono_uno, $telefono_dos, $email, $fecha_nacimiento, $ciudad, $barrio, $direccion, $estado_civil, $sexo, $estrato, $tipo_cliente, $edad, $pregunta_22, $clasificacion, $pregunta_23);

        $registro_titular = $gestion->id_cliente($numero_documento);


        if ($tipo_cliente == "Tercero") { //EXTRAER INFORMACION DE TABLA TEMPORAL
            $informacion_terceros = $cliente->consultar_terceros_temp($numero_documento);

            $titular_id = $gestion->id_cliente($numero_documento);

            if (!empty($informacion_terceros)) {
                foreach ($informacion_terceros as $dato) {
                    $gestion->crear_tercero($dato["tipo_documento_id"], $dato["documento"], $dato["nombre"], $dato["apellido"], $dato["fecha_nacimiento"], $dato["sexo"], $dato["parentesco_id"], $titular_id);

                    $cliente->eliminar_tercero_temp($dato["id"]);
                }
            }
        }

        $gestion->ingreso_gestion_tipificacion($registro_titular, 84, $usuario_id);
        $gestion->ingresar_gestion($registro_titular, $usuario_id);
        $gestion_id = $gestion->gestion_id($registro_titular, $usuario_id, 0);

        if ($clasificacion == "") {
            $clasificacion = 1;
        }
        $gestion->actulizar_cliente_clasisficacion($registro_titular, $clasificacion);


        //$gestion->gurdar_repuesta_clasificacion(1, $pregunta_1, $registro_titular);
        //$gestion->gurdar_repuesta_clasificacion(2, $pregunta_2, $registro_titular);
        /*$gestion->gurdar_repuesta_clasificacion(3, $pregunta_3, $registro_titular);
        $gestion->gurdar_repuesta_clasificacion(4, $pregunta_4, $registro_titular);
        $gestion->gurdar_repuesta_clasificacion(5, $pregunta_5, $registro_titular);
        $gestion->gurdar_repuesta_clasificacion(6, $pregunta_6, $registro_titular);
        $gestion->gurdar_repuesta_clasificacion(7, $pregunta_7, $registro_titular);
        $gestion->gurdar_repuesta_clasificacion(8, $pregunta_8, $registro_titular);
        $gestion->gurdar_repuesta_clasificacion(9, $pregunta_9, $registro_titular);
        $gestion->gurdar_repuesta_clasificacion(10, $pregunta_10, $registro_titular);
        $gestion->gurdar_repuesta_clasificacion(11, $pregunta_11, $registro_titular);
        $gestion->gurdar_repuesta_clasificacion(12, $pregunta_12, $registro_titular);
        $gestion->gurdar_repuesta_clasificacion(13, $pregunta_13, $registro_titular);
        $gestion->gurdar_repuesta_clasificacion(14, $pregunta_14, $registro_titular);
        $gestion->gurdar_repuesta_clasificacion(15, $pregunta_15, $registro_titular);
        $gestion->gurdar_repuesta_clasificacion(16, $pregunta_16, $registro_titular);
        $gestion->gurdar_repuesta_clasificacion(17, $pregunta_17, $registro_titular);
        $gestion->gurdar_repuesta_clasificacion(18, $pregunta_18, $registro_titular);
        $gestion->gurdar_repuesta_clasificacion(19, $pregunta_19, $registro_titular);
        $gestion->gurdar_repuesta_clasificacion(20, $pregunta_20, $registro_titular);
        $gestion->gurdar_repuesta_clasificacion(21, $pregunta_21, $registro_titular);*/
        
        $gestion->gurdar_repuesta_clasificacion(22, $pregunta_22, $registro_titular);
        $gestion->gurdar_repuesta_clasificacion(23, $pregunta_23, $registro_titular);


        $id = base64_encode($gestion_id);
    } else { // EXISTE UN REGISTRO CON ESE NUMERO DE DOCUMENTO
        $id = 0;
    }

    echo $id;
} else if ($tipo == 3) {
    $medios_comunicacion = $gestion->medios_comunicacion();
    echo $medios_comunicacion;
} else if ($tipo == 4) {
    $id_cliente = $_POST["id_cliente"];
    $datos_cliente = $gestion->buscar_registro($id_cliente);
    echo $datos_cliente;
} else if ($tipo == 5) {
    $laboratorio = $gestion->laboratorio();
    echo $laboratorio;
} else if ($tipo == 6) {
    $examen = $gestion->examen();
    echo $examen;
} else if ($tipo == 7) {
    $examen_id = $_POST["examen_id"];
    $detalles_examen = $gestion->detalles_examen($examen_id);
    echo $detalles_examen;
} else if ($tipo == 8) {
    $cliente_id = $_POST["id_cliente"];
    $notas = $gestion->notas_cliente($cliente_id);
    echo $notas;
} else if ($tipo == 9) {
    $cliente_id = $_POST["id_cliente"];
    $usuario = $_POST["usuario"];
    $nota_textarea = $_POST["nota_textarea"];
    $gestion_id = $_POST["gestion_id"];

    $gestion->ingresar_nota($nota_textarea, $cliente_id, $usuario, $gestion_id);

    $notas = $gestion->notas_cliente($cliente_id);
    echo $notas;
} else if ($tipo == 11) { /* REDIGIR Y GUARDAR GESTION */
    $cliente_id = $_POST["cliente_id"];
    $usuario_id = $_POST["usuario"];

    //consultar si se encuentra ocupado
    $registro_ocupado = $gestion->consulta_registro_ocupacion(date('Y-m-d'), $cliente_id);

    if ($registro_ocupado == 0) {
        $gestion->ingresar_registro_ocupacion($usuario_id, $cliente_id);
        $gestion_id = $gestion->gestion_id($cliente_id, $usuario_id, 0);

        if ($gestion_id == 0) {
            $gestion->ingresar_gestion($cliente_id, $usuario_id);
            $gestion_id = $gestion->gestion_id($cliente_id, $usuario_id, 0);
        }

        $gestion_id = base64_encode($gestion_id);
        echo $gestion_id;
    } else {
        //ocupado
        echo "O";
    }
} else if ($tipo == 12) {
    $medio_comunicacion_id = $_POST["medio_comunicacion_id"];

    $imagen = $gestion->imagen_medio_comunicacion($medio_comunicacion_id);
    echo $imagen;
} else if ($tipo == 13) {

    $categoria_examen = $gestion->obtenerCategoriaExamen();
    echo $categoria_examen;
} else if ($tipo == 14) {
    $categora_id = $_POST["categoria_id"];
    $examenes = $gestion->obtenerExamen($categora_id);
    echo $examenes;
} else if ($tipo == 15) { /* INGRESAR  Y LISTAR COTIZACION */
    $examen_id = $_POST["examen_descripcion"];
    $gestion_id = $_POST["gestion_id"];
    $cliente_id = $_POST["id_cliente"];

    $cotizacion_temporal = $gestion->cotizacion_temporal($examen_id, $cliente_id, $gestion_id);

    $examenes_cotizacion_temp = $gestion->consultar_cotizacion_temp($cliente_id, $gestion_id);
    echo $examenes_cotizacion_temp;
} else if ($tipo == 17) { /* LISTAR COTIZACION */

    $gestion_id = $_POST["gestion_id"];
    $cliente_id = $_POST["id_cliente"];

    $examenes_cotizacion_temp = $gestion->consultar_cotizacion_temp($cliente_id, $gestion_id);
    echo $examenes_cotizacion_temp;
} else if ($tipo == 18) { /* INGRESAR Y LISTAR CITA */
    $examen_id = $_POST["examen_descripcion"];
    $gestion_id = $_POST["gestion_id"];
    $cliente_id = $_POST["id_cliente"];

    $cita_temporal = $gestion->cita_temporal($examen_id, $cliente_id, $gestion_id);

    $examenes_cita_temp = $gestion->consultar_cita_temp($cliente_id, $gestion_id);
    echo $examenes_cita_temp;
} else if ($tipo == 16) { /* ELIMINAR Y LISTAR COTIZACION */
    $examen_id = $_POST["examen_id"];
    $eliminar = $gestion->eliminar_cotizacion_temp($examen_id);

    $gestion_id = $_POST["gestion_id"];
    $cliente_id = $_POST["id_cliente"];

    $examenes_cotizacion_temp = $gestion->consultar_cotizacion_temp($cliente_id, $gestion_id);
    echo $examenes_cotizacion_temp;
} else if ($tipo == 19) { /* ELIMINAR Y LISTAR CITA */
    $examen_id = $_POST["examen_id"];
    $eliminar = $gestion->eliminar_cita_temp($examen_id);

    $gestion_id = $_POST["gestion_id"];
    $cliente_id = $_POST["id_cliente"];

    $examenes_cita_temp = $gestion->consultar_cita_temp($cliente_id, $gestion_id);
    echo $examenes_cita_temp;
} else if ($tipo == 20) { /* LISTAR COTIZACION */

    $gestion_id = $_POST["gestion_id"];
    $cliente_id = $_POST["id_cliente"];

    $examenes_cita_temp = $gestion->consultar_cita_temp($cliente_id, $gestion_id);
    echo $examenes_cita_temp;
} elseif ($tipo == 22) {
    $cliente_id = $_POST["cliente_id"];
    $usuario_id = $_POST["usuario_id"];

    $gestion->ingresar_gestion($cliente_id, $usuario_id);
    $gestion_id = $gestion->gestion_id($cliente_id, $usuario_id, 0);


    $id = base64_encode($gestion_id);

    echo $id;
} else if ($tipo == 23) { // INGRESAR TERCERO
    $tipo_documento_tercero = $_POST["tipo_documento_tercero"];
    $numero_documento_tercero = $_POST["numero_documento_tercero"];
    $nombre_tercero = $_POST["nombre_tercero"];
    $apellido_tercero = $_POST["apellido_tercero"];
    $fecha_nacimiento_tercero = $_POST["fecha_nacimiento_tercero"];
    $sexo_tercero = $_POST["sexo_tercero"];
    $parentesco = $_POST["parentesco"];
    $numero_documento_titular = $_POST["numero_documento_titular"];

    //confimar si existe en los registros de terceros

    $respuesta = $cliente->consultar_documento_tercero($numero_documento_tercero);

    //si  no existen registro asociados al numero de documento del tercero en la tabla terceros y tercero temp se ingresa el registro
    if ($respuesta == 1) {
        $cliente->crear_terceros_temp($tipo_documento_tercero, $numero_documento_tercero, $nombre_tercero, $apellido_tercero, $fecha_nacimiento_tercero, $sexo_tercero, $parentesco, $numero_documento_titular);
    }

    $informacion_terceros = $cliente->consultar_terceros_temp($numero_documento_titular);

    if (!empty($informacion_terceros)) {
        ?>
        <script>

            $(".eliminar_tercero_temp").click(function () {


                var tercero = $(this).data();
                var tercero_id = tercero.id;
                var numero_documento_titular = tercero.documento;

                $.ajax({
                    url: '../controladores/Gestion.php',
                    data:
                            {
                                tipo: 25,
                                tercero_id: tercero_id,
                                numero_documento_titular: numero_documento_titular
                            },
                    type: 'post',
                    success: function (data)
                    {
                        $("#div_informacion_terceros").html(data);
                    }
                });
            });
        </script>

        <?php

        echo "<table  class='tinfo table table-striped'  style='width:100%;'>";
        echo "<thead>";
        echo "<tr style='background-color: #214761;'>";
        echo "<th style='color:white;'>Tipo Documento</th>";
        echo "<th style='color:white;'>Documento</th>";
        echo "<th style='color:white;'>Nombre</th>";
        echo "<th style='color:white;'>Fecha Nacimiento</th>";
        echo "<th style='color:white;'>Sexo</th>";
        echo "<th style='color:white;'>Parentesco</th>";
        echo "<th style='color:white;'></th>";
        echo "</tr>";
        echo "</thead>";

        echo "<tbody>";
        $i = 0;
        foreach ($informacion_terceros as $dato) {
            $i++;
            echo "<tr>";
            echo "<td data-label='Tipo Documento'>" . $dato["tipo_documento"] . "</td>";
            echo "<td data-label='Documento'>" . $dato["documento"] . "</td>";
            echo "<td data-label='Nombre'>" . $dato["nombre"] . " " . $dato["apellido"] . " </td>";
            echo "<td data-label='Fecha Nacimiento'>" . $dato["fecha_nacimiento"] . "</td>";
            echo "<td data-label='Sexo'>" . $dato["sexo"] . "</td>";
            echo "<td data-label='Parentesco'>" . $dato["parentesco"] . "</td>";
            echo "<td> <button data-id='" . $dato["id"] . "'' data-documento='" . $dato["documento_titular"] . "' class='eliminar_tercero_temp btn btn-default'> <img src='images/borrar.png'> </button></td>";
            echo "</tr>";
        }
        echo "</tbody></table> <input id='cantidad_tercero' type='hidden' value='" . $i . "'>";
    } else {
        echo 1;
    }
} else if ($tipo == 24) {

    $numero_documento_titular = $_POST["numero_documento_titular"];

    $informacion_terceros = $cliente->consultar_terceros_temp($numero_documento_titular);

    if (!empty($informacion_terceros)) {
        ?>
        <script>

            $(".eliminar_tercero_temp").click(function () {


                var tercero = $(this).data();
                var tercero_id = tercero.id;
                var numero_documento_titular = tercero.documento;


                $.ajax({
                    url: '../controladores/Gestion.php',
                    data:
                            {
                                tipo: 25,
                                tercero_id: tercero_id,
                                numero_documento_titular: numero_documento_titular
                            },
                    type: 'post',
                    success: function (data)
                    {
                        $("#div_informacion_terceros").html(data);
                    }
                });
            });
        </script>

        <?php

        echo "<table class='tinfo table table-striped'  style='width:100%;'>";
        echo "<thead>";
        echo "<tr style='background-color: #214761;'>";
        echo "<th style='color:white;'>Tipo Documento</th>";
        echo "<th style='color:white;'>Documento</th>";
        echo "<th style='color:white;'>Nombre</th>";
        echo "<th style='color:white;'>Fecha Nacimiento</th>";
        echo "<th style='color:white;'>Sexo</th>";
        echo "<th style='color:white;'>Parentesco</th>";
        echo "<th style='color:white;'>Eliminar</th>";
        echo "</tr>";
        echo "</thead>";

        echo "<tbody>";
        $i = 0;
        foreach ($informacion_terceros as $dato) {
            $i++;
            echo "<tr>";
            echo "<td data-label='Tipo Documento'>" . $dato["tipo_documento"] . "</td>";
            echo "<td data-label='Documento'>" . $dato["documento"] . "</td>";
            echo "<td data-label='Nombre'>" . $dato["nombre"] . " " . $dato["apellido"] . " </td>";
            echo "<td data-label='Fecha Nacimiento'>" . $dato["fecha_nacimiento"] . "</td>";
            echo "<td data-label='Sexo'>" . $dato["sexo"] . "</td>";
            echo "<td data-label='Parentesco'>" . $dato["parentesco"] . "</td>";
            echo "<td> <button data-id='" . $dato["id"] . "'' data-documento='" . $dato["documento_titular"] . "' class='eliminar_tercero_temp btn btn-default'> <img src='images/borrar.png'> </button></td>";
            echo "</tr>";
        }
        echo "</tbody></table> <input id='cantidad_tercero' type='hidden' value='" . $i . "'>";
    } else {
        echo 1;
    }
} else if ($tipo == 25) {
    $tercero_id = $_POST["tercero_id"];

    $cliente->eliminar_tercero_temp($tercero_id);

    $numero_documento_titular = $_POST["numero_documento_titular"];

    $informacion_terceros = $cliente->consultar_terceros_temp($numero_documento_titular);

    if (!empty($informacion_terceros)) {
        ?>
        <script>

            $(".eliminar_tercero_temp").click(function () {


                var tercero = $(this).data();
                var tercero_id = tercero.id;
                var numero_documento_titular = tercero.documento;


                $.ajax({
                    url: '../controladores/Gestion.php',
                    data:
                            {
                                tipo: 25,
                                tercero_id: tercero_id,
                                numero_documento_titular: numero_documento_titular
                            },
                    type: 'post',
                    success: function (data)
                    {
                        $("#div_informacion_terceros").html(data);
                    }
                });
            });
        </script>

        <?php

        echo "<table class='tinfo table table-striped'  style='width:100%;'>";
        echo "<thead>";
        echo "<tr style='background-color: #214761;'>";
        echo "<th style='color:white;'>Tipo Documento</th>";
        echo "<th style='color:white;'>Documento</th>";
        echo "<th style='color:white;'>Nombre</th>";
        echo "<th style='color:white;'>Fecha Nacimiento</th>";
        echo "<th style='color:white;'>Sexo</th>";
        echo "<th style='color:white;'>Parentesco</th>";
        echo "<th style='color:white;'></th>";
        echo "</tr>";
        echo "</thead>";

        echo "<tbody>";
        $i = 0;
        foreach ($informacion_terceros as $dato) {
            $i++;
            echo "<tr>";
            echo "<td data-label='Tipo Documento'>" . $dato["tipo_documento"] . "</td>";
            echo "<td data-label='Documento'>" . $dato["documento"] . "</td>";
            echo "<td data-label='Nombre'>" . $dato["nombre"] . " " . $dato["apellido"] . " </td>";
            echo "<td data-label='Fecha Nacimiento'>" . $dato["fecha_nacimiento"] . "</td>";
            echo "<td data-label='Sexo'>" . $dato["sexo"] . "</td>";
            echo "<td data-label='Parentesco'>" . $dato["parentesco"] . "</td>";
            echo "<td > <button data-id='" . $dato["id"] . "'' data-documento='" . $dato["documento_titular"] . "' class='eliminar_tercero_temp btn btn-default'> <img src='images/borrar.png'> </button></td>";
            echo "</tr>";
        }
        echo "</tbody></table> <input id='cantidad_tercero' type='hidden' value='" . $i . "'>";
    }
} else if ($tipo == 26) {

    $cliente_id = $_POST["cliente_id"];

    $informacion_terceros = $cliente->consultar_tercero_titular($cliente_id);

    if (!empty($informacion_terceros)) {

        echo "<table class='tinfo table table-striped'  style='width:100%;'>";
        echo "<thead>";
        echo "<tr style='background-color: #214761;'>";
        echo "<th style='color:white;'>Tipo Documento</th>";
        echo "<th style='color:white;'>Documento</th>";
        echo "<th style='color:white;'>Nombre</th>";
        echo "<th style='color:white;'>Fecha Nacimiento</th>";
        echo "<th style='color:white;'>Sexo</th>";
        echo "<th style='color:white;'>Parentesco</th>";
        echo "</tr>";
        echo "</thead>";

        echo "<tbody>";
        $i = 0;
        foreach ($informacion_terceros as $dato) {
            $i++;
            echo "<tr>";
            echo "<td data-label='Tipo Documento'>" . $dato["tipo_documento"] . "</td>";
            echo "<td data-label='Documento'>" . $dato["documento"] . "</td>";
            echo "<td data-label='Nombre'>" . $dato["nombre"] . " " . $dato["apellido"] . " </td>";
            echo "<td data-label='Fecha Nacimiento'>" . $dato["fecha_nacimiento"] . "</td>";
            echo "<td data-label='Sexo'>" . $dato["sexo"] . "</td>";
            echo "<td data-label='Parentesco'>" . $dato["parentesco"] . "</td>";
        }
        echo "</tbody></table> <input id='cantidad_tercero' type='hidden' value='" . $i . "'>";
    } else {
        echo 1;
    }
} else if ($tipo == 27) { //cancelar gestion
    $usuario_id = $_POST["usuario_id"];
    $cliente_id = $_POST["id_cliente"];
    $gestion_id = $_POST["gestion_id"];
    //cerrar gestion 
    $gestion->eliminar_gestion($gestion_id);

    //liberar registro:
    $gestion->liberar_registro($cliente_id, $usuario_id);
} else if ($tipo == 28) {
    $examen_no_perfil = $gestion->examen_no_perfil();
    echo $examen_no_perfil;
} else if ($tipo == 29) {
    $examen_no_perfil = $_POST["examen_no_perfil"];
    $examen_no_perfil = $gestion->examen_precio_no_perfil($examen_no_perfil);
    echo $examen_no_perfil;
}

if ($tipo == 31) {

  $documento = $_POST["documento"];

?><style type="text/css">
     @media screen and (max-width: 800px) {
    
    /* Desaparecer el header */
      table.tinfo thead, th {
         border: none;
         clip: rect(0, 0, 0, 0);
         height: 1px;
         margin: -1px;
         overflow: hidden;
         padding: 0;
         position: absolute;
         width: 1px;
      }

    table.tinfo tr{
     border-bottom: 3px solid; 
   }

   table.tinfo td {
    border-bottom: 1px solid #ddd;
    display: block;
    font-size: 1.2em;
    text-align: right;
    padding: 10px;
  }
  table.tinfo th {
    border-bottom: 1px solid #ddd;
    display: block;
    font-size: 1.2em;
    text-align: right;
    padding: 10px;
  }
  table.tinfo td:before{
    content: attr(data-label);
    float: left;
    color: #273b47;
    font-weight: bold;
    font-size: 1em;
    padding: 1px 5px;
  }
  

  /* Desaparecer el header */
      table.tabla_terceros thead, th {
         border: none;
         clip: rect(0, 0, 0, 0);
         height: 1px;
         margin: -1px;
         overflow: hidden;
         padding: 0;
         position: absolute;
         width: 1px;
      }

    table.tabla_terceros tr{
     border-bottom: 3px solid; 
   }

   table.tabla_terceros td {
    border-bottom: 1px solid #ddd;
    display: block;
    font-size: 1.2em;
    text-align: right;
    padding: 10px;
  }
  table.tabla_terceros th {
    border-bottom: 1px solid #ddd;
    display: block;
    font-size: 1.2em;
    text-align: right;
    padding: 10px;
  }
  table.tabla_terceros td:before{
    content: attr(data-label);
    float: left;
    color: #273b47;
    font-weight: bold;
    font-size: 1em;
    padding: 1px 5px;
  }
}

</style>
<script src="../ajax/Gestion.js" ></script>
<script src="../include/constante.js"></script>
<div class="row " style="padding: 20px; margin: 10px;">
                                <p style="font-size: 11pt;">
                                    <img src="images/info.png" alt=""/>
                                        Realice la validaci&oacute;n de los datos. Si es necesario actualice la informaci&oacute;n</p>

                                <div id="tabla_informacion_cliente">  </div>

                               
                                <a  href="javascript:VentanaCentrada('../web/actualizar_cliente.php?cliente_id=<?php echo "27" ?>','Examenes','','1024','768','true')" style="float: right; margin-right: 5px;" class="btn btn-default" >
                                
                                    <img src="images/refrescar.png" alt=""/>
                                    Actualizar Registro</a>
                                    <br> <br>
                                <!--informacion de terceros -->
                                <div style="padding: 10px;">

                                 <?php 
                                 if(!empty($informacion_terceros)){ ?>
                                   <fieldset>
                                    <legend style="color:#00c292; font-size: 15pt;">
                                        <img src="images/presencial.png" alt=""/>
                                        Terceros</legend>
                                    <table  class='tinfo table table-striped' id='tabla_terceros' style='width:100%;'>
                                        <thead>
                                            <tr style="background-color: #214761;">
                                                <th style="color:white">Parentesco</th>
                                                <th style="color:white">Tipo Documento</th>
                                                <th style="color:white">Documento</th>
                                                <th style="color:white">Nombre</th>
                                                <th style="color:white">Fecha Nacimiento</th>
                                                <th style="color:white">Actualizar</th>
                                            </tr>
                                        </thead>
                                        <tbody>    
                                           <?php  foreach ($informacion_terceros as $dato) { ?>
                                                <tr>
                                                    <td data-label='Parentesco'><?php echo $dato["parentesco"]?></td>
                                                    <td data-label='Tipo Documento'><?php echo $dato["tipo_documento"]?></td>
                                                    <td data-label='Documento'><?php echo $dato["documento"]?></td>
                                                    <td data-label='Nombre'><?php echo $dato["nombre"]." ".$dato["apellido"] ?></td>
                                                    <td data-label='Fecha Nacimiento'><?php echo $dato["fecha_nacimiento"]?></td>
                                                    <td data-label='Actualizar'> <a  href="javascript:VentanaCentrada('actualizar_tercero.php?tercero_id=<?php echo $dato['id_tercero']; ?>','Tercero','','824','568','true')"  class="btn btn-default" >
                                                    <img src="images/refrescar.png" alt=""/></a></td>
                                                </tr>
                                          <?php  } ?>
                                         </tbody>
                                         </table>  
                                    </fieldset>   
                                        <?php }
                                         ?>


                                </div>
                                <!-- fin informacion de terceros -->
                                 


                            </div>

                       <div class="row " style="padding: 20px; margin: 10px;">
                            <strong><p style="font-size: 11pt;">
                                <img src="images/info.png" alt=""/> Historial de procesos realizados</p> </strong>

                            <table class="table table-bordered">
                                <thead>
                                    <tr style=" background-color: #214761;" >
                                        <th style="color:white">Fecha gestion</th>
                                        <th style="color:white">Medio Comunicaci&oacute;n</th>
                                        <th style="color:white">Calificaci&oacute;n</th>
                                        <th style="color:white">Observacion</th>
                                        <th style="color:white">Detalle</th>
                                    </tr>
                                </thead>
                                <tbody>
  <?php $lista_gestiones = $gestion->consultar_gestiones_cliente_his($documento);
                                   foreach ($lista_gestiones as $datos_gestiones) {
                                     
                                 ?>
                                
                                    <tr>
                                        <td><?php echo $datos_gestiones["fecha_ingreso"] ?></td>
                                         <td><?php echo $datos_gestiones["medio"] ?></td>
                                        <td><?php echo $datos_gestiones["causal"] ?></td>
                                        <td><?php echo $datos_gestiones["observacion"] ?></td>
                                      
  <td> <center> <a  href="javascript:VentanaCentrada('../web/ver_gestion.php?gestion_id=<?php echo base64_encode($datos_gestiones["id"])?>','Examenes','','1024','768','true')" class="btn btn-default">
                                      <img src="../images/lupa.png" style="width: 20px;">  Consultar</a> </center></td>
                                    </tr>
                                <?php } ?>
								</tbody>
                            </table>
                        </div>
                  
	
 <?php
}else if ($tipo == 32) {
    $examen_no_perfil = $gestion->examen_no_perfil_bus($_POST);
    echo $examen_no_perfil;
}else if ($tipo == 33) {
    $categora_id = $_POST["categoria_id"];
    $id_plan = $_POST["id_plan"];
    $examenes = $gestion->obtenerExamen2($categora_id,$id_plan);
    echo $examenes;
} else if ($tipo == 34) {
    $examen_no_perfil = $_POST["examen_no_perfil"];
    $id_plan = $_POST["id_plan"];
    $examen_no_perfil = $gestion->examen_precio_no_perfil2($examen_no_perfil,$id_plan);
    echo $examen_no_perfil;
}
?>
	
