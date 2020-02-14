<?php

/**
 * Description of Gestion
 *
 * @author Paola Cotrina
 */
require_once '../conexion/conexion_bd.php';

class Caja {

    public $conexion;

    function __construct() {
        $this->conexion = new Conexion();
    }

// LISTAR PRECIOS DEL EXAMEN
    public function listar_precios_examenes($examen_id) {
        $query = $this->conexion->prepare("SELECT preparacion,precio,precio_menos_cinco,precio_menos_diez,precio_menos_quince FROM examen WHERE id = :examen_id AND activo=1");
        $query->execute(array(':examen_id' => $examen_id));
        $rows = $query->fetchAll();
        foreach ($rows as $valor) {
            $opciones[] = array('precio' => $valor["precio"],
                'preparacion' => $valor["preparacion"],
                'precio_menos_cinco' => $valor["precio_menos_cinco"],
                'precio_menos_diez' => $valor["precio_menos_diez"],
                'precio_menos_quince' => $valor["precio_menos_quince"]
            );
        }
        return json_encode($opciones);
    }

    /* INGRESAR VENTA TEMP */

    public function venta_temporal($examen_id, $cliente_id, $gestion_id, $precio_tipo, $valor, $tipo_examen) {
        $query = $this->conexion->prepare("INSERT INTO venta_temp (examen_id,cliente_id,gestion_id,precio_tipo,valor,tipo_examen) 
                VALUES (:examen_id,:cliente_id,:gestion_id,:precio_tipo, :valor,:tipo_examen)");
        $query->execute(array(':examen_id' => $examen_id,
            ':cliente_id' => $cliente_id,
            ':gestion_id' => $gestion_id,
            ':precio_tipo' => $precio_tipo,
            ':valor' => $valor,
            ':tipo_examen' => $tipo_examen
        ));
    }

    /*  CONSULTAR TABLA TEMPORAL */

    public function tabla_temporal($cliente_id, $gestion_id) {
        $query = $this->conexion->prepare("SELECT  v.id,v.examen_id, 
                   if(v.tipo_examen=1,(SELECT nombre FROM examen WHERE id= v.examen_id), (SELECT nombre FROM examenes_no_perfiles WHERE id= v.examen_id)) AS examen,
                   if(v.tipo_examen=1,(SELECT codigo_crm FROM examen WHERE id= v.examen_id), (SELECT codigo FROM examenes_no_perfiles WHERE id= v.examen_id)) AS codigo,
                   if(v.tipo_examen=1 , 'perfil','no_perfil') as tipo_examen,
                    v.precio_tipo,
                    v.valor
                    FROM venta_temp AS v
                    WHERE v.cliente_id =:cliente_id AND v.gestion_id = :gestion_id");
        $query->execute(array(':cliente_id' => $cliente_id,
            ':gestion_id' => $gestion_id
        ));

        $rows = $query->fetchAll();

        if (!empty($rows)) {

            $tabla = "<table class='table table-hover'>";
            $tabla .= "</thead><tr>";
            $tabla .= "<td style='color:#0C4F5A;background-color:#03605D'></td>";
            $tabla .= "<td style='color:white; background-color:#03605D' >Examen</td>";
            $tabla .= "<td style='color:white; background-color:#03605D'>Descuento</td>";
            $tabla .= "<td style='color:white; background-color:#03605D'>Valor</td>";


            $tabla .= "</tr> </thead><tbody id='examenes_agregados'>";

            foreach ($rows as $valor) {

                $tabla .= "<tr>";
                $tabla .= "<td > <center><button class='btn btn-default eliminar_examen'  id='" . $valor["id"] . "' onclick='eliminar(this.id)' style='background-color:transparent;' title='Eliminar'><img src='https://arcos-crm.com/crm_colcan/web/images/borrar.png'> </button></center></td>";
                $tabla .= "<td >" . $valor["examen"] . "</td>";
                $tabla .= "<td >" . $valor["precio_tipo"] . "</td>";
                $tabla .= "<td > $ " . number_format($valor["valor"], 0, ",", ".") . "</td>";


                $tabla .= "</tr>";
            }
        } else {
            $tabla = "";
        }

        return $tabla;
    }

    /* SUMA TEMPORAL */

    public function sumaVentaTempExamenes($cliente_id, $gestion_id) {
        $query = $this->conexion->prepare("SELECT SUM(c.valor) AS suma FROM venta_temp AS c
                   WHERE c.cliente_id  = :cliente_id and c.gestion_id = :gestion_id ");
        $query->execute(array(':cliente_id' => $cliente_id,
            ':gestion_id' => $gestion_id));
        $rows = $query->fetchAll(PDO::FETCH_ASSOC);

        if (!empty($rows)) {
            foreach ($rows as $valor) {
                $suma = $valor["suma"];
            }
            $tabla_suma = "</tbody><tfooter><tr> <td colspan='3' style='color:#0C4F5A;text-align:right'><b>Total<b></td><td style='color:#0C4F5A'><b> $ " . number_format($suma, 0, ",", ".") . "</b> </td></tr><tfooter></table>";
        } else {
            $suma = 0;
            $tabla_suma = "";
        }


        return $tabla_suma;
    }

    /* ELIMINAR TEMPORAL VENTA */

    public function eliminar_cita_temp($examen_id) {
        $query = $this->conexion->prepare("DELETE FROM venta_temp where id= :examen_id");
        $query->execute(array(':examen_id' => $examen_id));
    }

    /* INGRESAR ITEMS DE VENTA  */

    public function ingresar_venta_items($examen_id, $cliente_id, $gestion_id, $descuento, $venta_id, $valor, $tipo_examen) {
        $query = $this->conexion->prepare("INSERT INTO venta_items (examen_id,cliente_id,gestion_id,descuento,venta_id,valor,tipo_examen) VALUES (:examen_id,:cliente_id,:gestion_id,:descuento,:venta_id,:valor,:tipo_examen)");

        $query->execute(array(':examen_id' => $examen_id,
            ':cliente_id' => $cliente_id,
            ':gestion_id' => $gestion_id,
            ':descuento' => $descuento,
            ':venta_id' => $venta_id,
            ':valor' => $valor,
            ':tipo_examen' => $tipo_examen
        ));
    }

// LISTA DE PRODCTOS TEMPORALES

    public function consultar_items_examenes_temp($cliente_id, $gestion_id) {
        $query = $this->conexion->prepare("SELECT v.id,v.examen_id,v.precio_tipo,v.valor,v.tipo_examen 
                  FROM venta_temp AS v
                  WHERE v.cliente_id  = :cliente_id and v.gestion_id = :gestion_id ");
        $query->execute(array(':cliente_id' => $cliente_id,
            ':gestion_id' => $gestion_id));
        $rows = $query->fetchAll(PDO::FETCH_ASSOC);

        return $rows;
    }

// INGRESA A TABLA VENTA
    public function ingresar_gestion_pago($cliente_id, $usuario_id, $gestion_id, $medio_pago, $plan) {

        $codigo = $this->generarCodigo(9);

        /*if ($bono != "NO") {
            $arr_bono = explode("-", $bono);
            $bono = $arr_bono[0];

            $sql_bono = "UPDATE bono SET fecha_redencion = NOW(),estado=:estado WHERE id=:id_bono";
            $query_b = $this->conexion->prepare($sql_bono);
            $query_b->execute(array(':id_bono' => $bono,
                ':estado' => 2
            ));
        }*/

        $query = $this->conexion->prepare("INSERT INTO venta (cliente_id,usuario_id, gestion_id,medio_pago,fecha_creacion,activo,estado,codigo_venta,id_plan) VALUES (:cliente_id,:usuario_id,:gestion_id,:medio_pago,NOW(),1,1,:codigo_venta,:id_plan)");
        $query->execute(array(':cliente_id' => $cliente_id,
            ':usuario_id' => $usuario_id,
            ':gestion_id' => $gestion_id,
            ':medio_pago' => $medio_pago,
            ':codigo_venta' => $codigo,
            ':id_plan' => $plan
        ));

        // ID DE VENTA INGRESADA
        $venta_id = $this->conexion->lastInsertId();


        $ventas_items_examenes = $this->consultar_items_examenes_temp($cliente_id, $gestion_id);


        foreach ($ventas_items_examenes as $datos_venta_examenes) {
            //INGRESAR ITEMS DE VENTA
            $this->ingresar_venta_items($datos_venta_examenes["examen_id"], $cliente_id, $gestion_id, $datos_venta_examenes["precio_tipo"], $venta_id, $datos_venta_examenes["valor"], $datos_venta_examenes["tipo_examen"]
            );

            //ELIMINAR ITEMS VENTAS 
            $this->eliminar_venta_temp($datos_venta_examenes["id"]);
        }

        return $venta_id;
    }

    /* ELIMINAR TEMPORAL VENTAS */

    public function eliminar_venta_temp($examen_id) {
        $query = $this->conexion->prepare("DELETE FROM venta_temp WHERE id = :examen_id");
        $query->execute(array(':examen_id' => $examen_id));
    }

    /* ELIMINAR VENTA TOTAL */

    public function eliminar_venta_temp_gestion($cliente_id, $gestion_id) {
        $query = $this->conexion->prepare("DELETE FROM venta_temp WHERE cliente_id =:cliente_id AND gestion_id= :gestion_id");
        $query->execute(array(':cliente_id' => $cliente_id, ':gestion_id' => $gestion_id));
    }

    public function consultar_examenes_venta($cliente_id, $venta_id) {
        $query = $this->conexion->prepare("SELECT
              if(vi.tipo_examen=1,(SELECT nombre FROM examen WHERE id= vi.examen_id), (SELECT nombre FROM examenes_no_perfiles WHERE id= vi.examen_id)) as nombre,
              vi.descuento,vi.valor,vi.cliente_id
              FROM venta as v
              INNER JOIN venta_items as vi on (vi.venta_id = v.id and v.cliente_id = vi.cliente_id and v.gestion_id = vi.gestion_id)
              INNER JOIN examen AS e on (e.id = vi.examen_id)
              WHERE v.cliente_id =:cliente_id AND v.id = :venta_id");
        $query->execute(array(':cliente_id' => $cliente_id, ':venta_id' => $venta_id));

        $rows = $query->fetchAll(PDO::FETCH_ASSOC);

        return $rows;
    }

    public function consultar_ventas_cotizaciones($cliente_id, $campo, $tabla_principal, $tabla_inner, $id) {
        $query = $this->conexion->prepare("SELECT
                            $campo, usuario_id, SUM(vi.valor) as valor,v.id
                            FROM $tabla_principal as v
                            INNER JOIN $tabla_inner as vi on (vi.$id = v.id and v.cliente_id = vi.cliente_id and v.gestion_id = vi.gestion_id)
                            WHERE v.cliente_id =:cliente_id
                            GROUP BY v.id ");
        $query->execute(array(':cliente_id' => $cliente_id));

        $rows = $query->fetchAll(PDO::FETCH_ASSOC);

        return $rows;
    }

    public function detalles_venta($cliente_id, $venta_id) {
        $query = $this->conexion->prepare("SELECT
                               v.id,
                               v.fecha_pago,
                               (select nombre_completo from usuario where id = v.usuario_id) as vendedor,
                               (select medio_pago from medio_pago where id = v.medio_pago) as medio_pago
                             FROM venta as v
                             WHERE v.cliente_id = :cliente_id and v.id = :venta_id");
        $query->execute(array(':cliente_id' => $cliente_id, ':venta_id' => $venta_id));

        $rows = $query->fetchAll(PDO::FETCH_ASSOC);

        return $rows;
    }

    public function suma_venta($venta_id) {
        $query = $this->conexion->prepare("SELECT
                                           sum(valor) as valor
                                         FROM venta_items
                                         WHERE venta_id = :venta_id");
        $query->execute(array(':venta_id' => $venta_id));
        $rows = $query->fetchAll();

        if (empty($rows)) {
            $suma = "";
        } else {
            foreach ($rows as $valor) {
                $suma = $valor["valor"];
            }
        }

        return $suma;
    }

    function generarCodigo($longitud) {

        $key = '';
        $pattern = '1234567890abcdefghijklmnopqrstuvwxyz';
        $max = strlen($pattern) - 1;
        for ($i = 0; $i < $longitud; $i++)
            $key .= $pattern{mt_rand(0, $max)};

        $query = $this->conexion->prepare("SELECT id FROM venta WHERE codigo_venta =:codigo_venta");
        $query->execute(array(':codigo_venta' => $key));
        $rows = $query->fetchAll();

        if (empty($rows)) {
            return $key;
        } else {
            generarCodigo($longitud);
        }
    }

    public function listar_precios_examenes2($examen_id, $id_plan) {
        $query = $this->conexion->prepare("select plai.id_item,plai.id_plan_item,chq.preparacion,plai.precio_regular,plai.precio_plan,chq.codigo_crm
from plan_item plai 
inner join examen chq on chq.id = plai.id_item
where plai.id_plan = :id_plan
and plai.id_item = :examen_id
and tipo_item = 'chequeo'");
        $query->execute(array(':examen_id' => $examen_id,
            ':id_plan' => $id_plan));
        $rows = $query->fetchAll();
        foreach ($rows as $valor) {
            $opciones[] = array('precio' => $valor["precio_plan"],
                'preparacion' => $valor["preparacion"],
                'precio_regular' => $valor["precio_regular"]
            );
        }
        return json_encode($opciones);
    }

}

?>