<?php
header("Content-Type: text/html;charset=utf-8"); ?>
<script type="text/javascript">
    $(document).ready(function() {
      

          $("#checkTodos").change(function () {
              $("input:checkbox").prop('checked', $(this).prop("checked"));

              var chkArray = [];
            $(".asignacion:checked").each(function() {
                chkArray.push($(this).val());
            });
             var selected;
            selected = chkArray.join(',') ;
            $("#cliente_seleccionado").val(selected);
          });  

          $('#lista_clientes').DataTable();

          $(".asignacion").click(function () {
          
            var chkArray = [];
            $(".asignacion:checked").each(function() {
                chkArray.push($(this).val());
            });
            
            var selected;
            selected = chkArray.join(',') ;
            $("#cliente_seleccionado").val(selected);
        }); 

});

</script>
<?php

require_once '../clase/Seguimiento.php';
require_once '../clase/Gestion.php';
require_once '../clase/Cliente.php';

$seguimiento = new Seguimiento();
$gestion = new Gestion();
$cliente = new Cliente();

$tipo = $_POST["tipo"];

if($tipo == 1){
    $tipificaciones = $_POST["tipificaciones"];
    $fecha_inicial  = $_POST["fecha_inicial"];
    $fecha_final    = $_POST["fecha_final"];
    $prospectos     = $_POST["prospectos"];

    if($prospectos == 1){
        $where = "AND c .cliente_estado = 1";
        $tipificaciones ='0,0';
    }
    else{
        $tipificaciones= implode(',', $tipificaciones);

        if($fecha_inicial != ""){
            $where = " AND g.tipificacion_id in (".$tipificaciones.") AND DATE(g.fecha_ingreso) BETWEEN '".$fecha_inicial."' AND '".$fecha_final."'";
        }
        else{
            $where = " AND g.tipificacion_id in (".$tipificaciones.")";
        }
    }
    echo "prospectos ".$prospectos;

    $resultado = $seguimiento->resultado_filtro($where);

    if(!empty($resultado)){
        echo '<table class="table table-striped" id="lista_clientes">
                                        <thead>
                                            <tr style="background-color: #214761;">
                                                <th  style="color:white"><input type="checkbox" id="checkTodos" /></th>
                                                <th  style="color:white"> Fecha Gestión </th>
                                                <th  style="color:white"> Usuario </th>
                                                <th  style="color:white"> Documento</th>
                                                <th  style="color:white"> Paciente</th>
                                                <th  style="color:white"> Telefono</th>
                                                <th  style="color:white"> Tipificacion</th>
                                            </tr>
                                        </thead>
                                        <tbody>';
            foreach ($resultado as $dato){
                    echo '<tr>
                            <td> <input class="asignacion" type="checkbox" name="asignacion[]" value="'.$dato["cliente_id"].'" id="seleccion"></td>
                            <td>'.$dato["fecha_ingreso"].'</td>
                            <td>'.$dato["usuario_id"].'</td>
                            <td>'.$dato["documento"].'</td>
                            <td>'.$dato["nombre"].'</td>
                            <td>'.$dato["telefono_1"].'</td>
                            <td>'.$dato["causal"].'</td>
                        </tr>';                       
            } 
        echo '</tbody></table>';        
    }else{
       echo "<center> <p><b> No hay resultados asociados a la búsqueda  </b></p>  </center>";
    }

   
}else if($tipo == 2) {
    $usuario_asignacion = $_POST["usuario_asignacion"];
    $clientes_asignacion = $_POST["selected"];

    $clientes_asignacion= explode(",", $clientes_asignacion);

    for($i = 0; $i < count($usuario_asignacion); $i++){
        for($j = 0; $j < count($clientes_asignacion); $j++){
           
                $seguimiento->ingresar_seguimiento($usuario_asignacion[$i],$clientes_asignacion[$j]);
        }

    }
}




?>
