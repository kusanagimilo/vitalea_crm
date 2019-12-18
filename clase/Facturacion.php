<?php

require_once '../conexion/conexion_bd.php';
include 'WS.php';

/**
 * Description of Facturacion
 *
 * @author JuanCamilo
 */
class Facturacion {

    public $conexion;

    function __construct() {
        $this->conexion = new Conexion();
    }

    function VerProspectosVentas($data) {


        $filtro_n_documento = "";
        $filtro_medio_pago = "";
        $filtro_estado = "";

        if ($_POST['n_documento'] != "" || $_POST['n_documento'] != NULL) {
            $filtro_n_documento = " AND cli.documento LIKE '%" . $_POST['n_documento'] . "%' ";
        }

        if ($_POST['medio_pago'] != "" || $_POST['medio_pago'] != NULL) {
            $filtro_medio_pago = " AND mdp.id = '" . $_POST['medio_pago'] . "' ";
        }

        if ($_POST['estado'] != "" || $_POST['estado'] != NULL) {
            $filtro_estado = " AND ven.estado = '" . $_POST['estado'] . "' ";
        }


        $arreglo_retorno = array();

        $query = $this->conexion->prepare("SELECT ven.id as id_venta,cli.id_cliente,tpd.nombre as tipo_doc,cli.documento,ges.observacion,
mdp.medio_pago,CONCAT(cli.nombre,' ',cli.apellido) as cliente,
SUM(vei.valor) as total_venta,ven.fecha_creacion,ven.fecha_pago,ven.estado,
mdp.id AS medio_pago_id,ven.codigo_venta,ven.numero_factura
FROM venta ven
INNER JOIN gestion ges ON ges.id = ven.gestion_id
INNER JOIN cliente cli ON cli.id_cliente = ven.cliente_id
INNER JOIN tipo_documento tpd ON tpd.id = cli.tipo_documento
INNER JOIN medio_pago mdp ON mdp.id = ven.medio_pago
INNER JOIN venta_items vei ON vei.venta_id = ven.id
$filtro_n_documento
$filtro_medio_pago
$filtro_estado
GROUP BY ven.id");
        $query->execute();

        $rows = $query->fetchAll(PDO::FETCH_ASSOC);

        $i = 0;
        foreach ($rows as $key => $value) {


            $arreglo_retorno[$i]["id_venta"] = $value["id_venta"];
            $arreglo_retorno[$i]["id_cliente"] = $value["id_cliente"];
            $arreglo_retorno[$i]["tipo_doc"] = $value["tipo_doc"];
            $arreglo_retorno[$i]["documento"] = $value["documento"];
            $arreglo_retorno[$i]["observacion"] = $value["observacion"];
            $arreglo_retorno[$i]["medio_pago"] = $value["medio_pago"];
            $arreglo_retorno[$i]["cliente"] = $value["cliente"];
            $arreglo_retorno[$i]["total_venta"] = $value["total_venta"];
            $arreglo_retorno[$i]["fecha_creacion"] = $value["fecha_creacion"];
            $arreglo_retorno[$i]["fecha_pago"] = $value["fecha_pago"];
            $arreglo_retorno[$i]["estado"] = $value["estado"];
            $arreglo_retorno[$i]["medio_pago_id"] = $value["medio_pago_id"];
            $arreglo_retorno[$i]["codigo_venta"] = $value["codigo_venta"];
            $arreglo_retorno[$i]["numero_factura"] = $value["numero_factura"];
            $turno = "";
            if ($value["estado"] == 2) {
                $turno = $this->EstadoTurnoFacturacion($value["id_venta"]);
            } else {
                $turno = "no_aplica";
            }
            $arreglo_retorno[$i]["turno_facturacion"] = $turno;

            $i++;
        }



        return json_encode($arreglo_retorno);
    }

    function CambiarEstadoVenta($data) {
        $query = $this->conexion->prepare("UPDATE venta SET estado =:estado,fecha_pago=NOW() WHERE id =:id");
        $query->execute(array(':estado' => $data["estado"],
            ':id' => $data['id']));

        if ($query) {

            if ($data["estado"] == 2) {
                $obj_ws = new WS("AtheneaWS", "4th3n3a*");
                $retorno = $obj_ws->CrearPaciente($data['id']);

                if ($retorno["xml"]->bolvalido == 0) {
                    return 2;
                } else if ($retorno["xml"]->bolvalido == 1) {
                    $athenea = $this->RevisaIdPacienteAthenea($retorno["xml"]->intid, $retorno['id_paciente']);

                    if ($athenea == 1) {
                        $retorno_factura = $obj_ws->AlmacenarFactura($data['id']);
                        if ($retorno_factura == "error") {
                            return 2;
                        } else {
                            $query2 = $this->conexion->prepare("UPDATE venta SET 
                                            id_solicitud_athenea=:id_solicitud_athenea,
                                            numero_factura=:numero_factura,
                                            valor_athenea=:valor_athenea,
                                            factura_athenea=:factura_athenea
                                            WHERE id=:id");
                            $query2->execute(array(':id_solicitud_athenea' => $retorno_factura["Id_Solicitud"],
                                ':numero_factura' => $retorno_factura['NumeroFactura'],
                                ':valor_athenea' => $retorno_factura['ValorAthenea'],
                                ':factura_athenea' => $retorno_factura['Facturado'],
                                ':id' => $data['id']));


                            if ($query2) {

                                $sql_almacenar_resultado = "INSERT INTO resultado(idventa,idcliente,id_solicitud_athenea,
                                    estado,fecha_creacion,fecha_modificacion)
                          VALUES(:idventa,:idcliente,:id_solicitud_athenea,:estado,NOW(),NOW())";


                                $query2 = $this->conexion->prepare($sql_almacenar_resultado);

                                $query2->execute(array(':idventa' => $data['id'],
                                    ':idcliente' => $retorno['id_paciente'],
                                    ':id_solicitud_athenea' => $retorno_factura["Id_Solicitud"],
                                    ':estado' => 1));
                                if ($query2) {
                                    return 1;
                                } else {
                                    return 2;
                                }
                            } else {
                                return 2;
                            }
                        }
                    } else if ($athenea == 2) {
                        return 2;
                    }

                    /* $sql_almacenar_resultado = "";
                      return $athenea; */
                }
            }
        }if (!$query) {
            return 2;
        }
    }

    function InformacionVentaIndividual($data) {

        $query = $this->conexion->prepare("SELECT ven.id as id_venta,cli.id_cliente,tpd.nombre as tipo_doc,cli.documento,ges.observacion,
mdp.medio_pago,CONCAT(cli.nombre,' ',cli.apellido) as cliente,
SUM(vei.valor) as total_venta,ven.fecha_creacion,ven.fecha_pago,ven.estado,mdp.id as id_medio_pago,ven.codigo_venta,ven.numero_factura
FROM venta ven
INNER JOIN gestion ges ON ges.id = ven.gestion_id
INNER JOIN cliente cli ON cli.id_cliente = ven.cliente_id
INNER JOIN tipo_documento tpd ON tpd.id = cli.tipo_documento
INNER JOIN medio_pago mdp ON mdp.id = ven.medio_pago
INNER JOIN venta_items vei ON vei.venta_id = ven.id 
WHERE ven.id=:id
GROUP BY ven.id");
        $query->execute(array(':id' => $data['id']));

        $rows = $query->fetchAll(PDO::FETCH_ASSOC);

        if (empty($rows)) {
            return "no_existe";
        } else {

            $arreglo_retorno = array();
            $i = 0;
            foreach ($rows as $key => $value) {


                $arreglo_retorno[$i]["id_venta"] = $value["id_venta"];
                $arreglo_retorno[$i]["id_cliente"] = $value["id_cliente"];
                $arreglo_retorno[$i]["tipo_doc"] = $value["tipo_doc"];
                $arreglo_retorno[$i]["documento"] = $value["documento"];
                $arreglo_retorno[$i]["observacion"] = $value["observacion"];
                $arreglo_retorno[$i]["medio_pago"] = $value["medio_pago"];
                $arreglo_retorno[$i]["cliente"] = $value["cliente"];
                $arreglo_retorno[$i]["total_venta"] = $value["total_venta"];
                $arreglo_retorno[$i]["fecha_creacion"] = $value["fecha_creacion"];
                $arreglo_retorno[$i]["fecha_pago"] = $value["fecha_pago"];
                $arreglo_retorno[$i]["estado"] = $value["estado"];
                $arreglo_retorno[$i]["medio_pago_id"] = $value["id_medio_pago"];
                $arreglo_retorno[$i]["codigo_venta"] = $value["codigo_venta"];
                $arreglo_retorno[$i]["numero_factura"] = $value["numero_factura"];
                $turno = "";
                if ($value["estado"] == 2) {
                    $turno = $this->EstadoTurnoFacturacion($value["id_venta"]);
                } else {
                    $turno = "no_aplica";
                }
                $arreglo_retorno[$i]["turno_facturacion"] = $turno;

                $i++;
            }
            return json_encode($arreglo_retorno);
        }
    }

    function RevisaIdPacienteAthenea($id_athenea, $id_paciente) {

        $query = $this->conexion->prepare("SELECT id_cliente FROM cliente WHERE id_cliente_athenea =:id_cliente_athenea");
        $query->execute(array(":id_cliente_athenea" => $id_athenea));
        $rows = $query->fetchAll(PDO::FETCH_ASSOC);

        if (empty($rows)) {
            $query_up = $this->conexion->prepare("UPDATE cliente SET id_cliente_athenea =:id_cliente_athenea WHERE id_cliente =:id_cliente");
            $query_up->execute(array(':id_cliente_athenea' => $id_athenea,
                ':id_cliente' => $id_paciente));

            if ($query) {
                return 1;
            } else {
                return 2;
            }
        } else {
            return 1;
        }
    }

    function VerDetalleVentaF($data) {

        $arreglo_retorno = array();

        $query = $this->conexion->prepare("SELECT ven.id as id_venta,cli.id_cliente,tpd.nombre as tipo_doc,cli.documento,ges.observacion,
mdp.medio_pago,CONCAT(cli.nombre,' ',cli.apellido) as cliente,
SUM(vei.valor) as total_venta,ven.fecha_creacion,ven.fecha_pago,ven.estado,mdp.id as id_medio_pago
FROM venta ven
INNER JOIN gestion ges ON ges.id = ven.gestion_id
INNER JOIN cliente cli ON cli.id_cliente = ven.cliente_id
INNER JOIN tipo_documento tpd ON tpd.id = cli.tipo_documento
INNER JOIN medio_pago mdp ON mdp.id = ven.medio_pago
INNER JOIN venta_items vei ON vei.venta_id = ven.id 
WHERE ven.id=:id
GROUP BY ven.id");
        $query->execute(array(':id' => $data['id']));
        $rows_fact_d = $query->fetchAll(PDO::FETCH_ASSOC);

        $arreglo_retorno["informacion_factura"] = $rows_fact_d[0];

        $query_items_examen = $this->conexion->prepare("select id,examen_id,valor,descuento,tipo_examen from venta_items where venta_id = :id_venta");
        $query_items_examen->execute(array(':id_venta' => $data['id']));


        $rows_items = $query_items_examen->fetchAll(PDO::FETCH_ASSOC);


        $arreglo_items = array();
        $i = 0;

        foreach ($rows_items as $key => $value) {

            $sql = "";
            if ($value['tipo_examen'] == 2) {
                $sql = "SELECT * FROM examenes_no_perfiles WHERE id=:id_examen";
            } else if ($value['tipo_examen'] == 1) {
                $sql = "SELECT * FROM examen WHERE id=:id_examen";
            }
            $query_detalle_examen = $this->conexion->prepare($sql);
            $query_detalle_examen->execute(array(':id_examen' => $value['examen_id']));
            $row_item = $query_detalle_examen->fetchAll(PDO::FETCH_ASSOC);

            $arreglo_items[$i]["id_venta_item"] = $value["id"];
            $arreglo_items[$i]["examen_id"] = $value["examen_id"];
            $arreglo_items[$i]["valor"] = $value["valor"];
            $arreglo_items[$i]["descuento"] = $value["descuento"];
            $arreglo_items[$i]["nombre_examen"] = $row_item[0]["nombre"];
            $i++;
        }

        $arreglo_retorno["items"] = $arreglo_items;
        $json_retorno = json_encode($arreglo_retorno);

        return $json_retorno;
    }

    public function NoFactura($data) {
        $query = $this->conexion->prepare("SELECT no_factura FROM venta WHERE id=:id_venta");
        $query->execute(array(":id_venta" => $data["id_venta"]));
        $rows = $query->fetchAll(PDO::FETCH_ASSOC);

        //return var_dump($rows);

        if (!empty($rows)) {
            if ($rows[0]["no_factura"] == null || $rows[0]["no_factura"] == "") {
                return "sin_factura";
            } else {
                return $rows[0]["no_factura"];
            }
        } else {
            return "sin_factura";
        }
    }

    public function ModificarNoFacturacion($data) {
        $query_up = $this->conexion->prepare("UPDATE venta SET no_factura =:no_factura WHERE id=:id_venta");
        $query_up->execute(array(':no_factura' => $data["no_factura"],
            ':id_venta' => $data["id_venta"]));

        if ($query_up) {
            return 1;
        } else {
            return 2;
        }
    }

    public function EstadoTurnoFacturacion($id_venta) {
        $query = $this->conexion->prepare("SELECT * FROM turno WHERE tipo_turno = 'TOMA_MUESTRA' AND id_venta =:id_venta 
                                           ORDER BY fecha_creacion DESC LIMIT 1");
        $query->execute(array(":id_venta" => $id_venta));
        $rows = $query->fetchAll(PDO::FETCH_ASSOC);


        if (empty($rows)) {
            return "permite_turno";
        } else {
            if ($rows[0]["estado"] == "CANCELADO") {
                return "permite_turno";
            } else {
                return "ya_existe_turno";
            }
        }
    }

    public function ListaArqueo($data) {


        $filtro_asesor = "";
        $filtro_fecha = "";

        if ($data['asesor'] != "" || $data['asesor'] != NULL) {
            $filtro_asesor = " AND ven.usuario_id  = " . $data['asesor'] . "";
        }

        if ($data['fecha_inicial'] != "" || $data['fecha_inicial'] != NULL) {
            $filtro_fecha = " AND ven.fecha_pago BETWEEN '" . $data['fecha_inicial'] . "' AND '" . $data['fecha_final'] . "'";
        }

        $arreglo_retorno = array();

        $query = $this->conexion->prepare("select ven.*,usr.nombre_completo as nombre_atendio,usr.documento as documento_atendio,
cli.documento as documento_paciente,cli.nombre as paciente_nombre,cli.apellido as apellido_paciente
from venta ven 
inner join usuario usr ON ven.usuario_id = usr.id
inner join cliente cli on ven.cliente_id = cli.id_cliente
INNER JOIN gestion ges ON ges.id = ven.gestion_id 
where numero_factura is not null
and factura_athenea = 'SI'
and ven.estado = 2
$filtro_asesor 
$filtro_fecha");

        $query->execute();

        $rows = $query->fetchAll(PDO::FETCH_ASSOC);

        $i = 0;
        foreach ($rows as $key => $value) {


            $arreglo_retorno[$i]["id_venta"] = $value["id"];
            $arreglo_retorno[$i]["id_cliente"] = $value["cliente_id"];
            $arreglo_retorno[$i]["fecha_pago"] = $value["fecha_pago"];

            $medio_pago = "";

            if ($value["medio_pago"] == 1) {
                $medio_pago = "PSE";
            } else if ($value["medio_pago"] == 2) {
                $medio_pago = "EFECTIVO";
            } else if ($value["medio_pago"] == 3) {
                $medio_pago = "TARJETA";
            }

            $sql_valor = "select SUM(valor) as venta_total from venta_items where venta_id = '" . $value["id"] . "'";


            $query2 = $this->conexion->prepare($sql_valor);
            $query2->execute();
            $rows2 = $query2->fetchAll(PDO::FETCH_ASSOC);



            $arreglo_retorno[$i]["medio_pago"] = $medio_pago;
            $arreglo_retorno[$i]["numero_factura"] = $value["numero_factura"];
            $arreglo_retorno[$i]["nombre_atendio"] = $value["nombre_atendio"];
            $arreglo_retorno[$i]["documento_atendio"] = $value["documento_atendio"];
            $arreglo_retorno[$i]["documento_paciente"] = $value["documento_paciente"];
            $arreglo_retorno[$i]["paciente"] = $value["paciente_nombre"] . " " . $value["apellido_paciente"];
            $arreglo_retorno[$i]["valor_total"] = $rows2[0]['venta_total'];

            $i++;
        }



        return json_encode($arreglo_retorno);
    }

    public function AsesoresConVentas() {

        $query = $this->conexion->prepare("select ven.usuario_id,us.documento,us.nombre_completo
from venta ven
inner join usuario us on us.id = ven.usuario_id
where ven.numero_factura is not null
and ven.estado = 2
and factura_athenea = 'SI'
group by ven.usuario_id");
        $query->execute();
        $rows = $query->fetchAll(PDO::FETCH_ASSOC);
        $json_retorno = json_encode($rows);

        return $json_retorno;
    }

    public function InformacionPerfil($data) {
        $query = $this->conexion->prepare("SELECT * FROM examen WHERE id =:id");
        $query->execute(array(
            'id' => $data['id']
        ));
        $rows = $query->fetchAll(PDO::FETCH_ASSOC);
        $json_retorno = json_encode($rows);

        return $json_retorno;
    }

    public function InformacionExamen($data) {
        $query = $this->conexion->prepare("SELECT * FROM examenes_no_perfiles WHERE id =:id");
        $query->execute(array(
            'id' => $data['id']
        ));
        $rows = $query->fetchAll(PDO::FETCH_ASSOC);
        $json_retorno = json_encode($rows);

        return $json_retorno;
    }

    public function AlmacenarPreCotizacion($data) {
        @session_start();
        $id_usuario = $_SESSION['ID_USUARIO'];
        $query = $this->conexion->prepare("INSERT INTO precotizacion(nombre_cliente,correo,telefono,valor,descuento,id_usr_creo,direccion)VALUES
                  (:nombre_cliente,:correo,:telefono,:valor,:descuento,:id_usr_creo,:direccion)");
        $query->execute(array(
            ':nombre_cliente' => $data['nombre_cliente'],
            ':correo' => $data['correo'],
            ':telefono' => $data['telefono'],
            ':valor' => $data['valor'],
            ':descuento' => 'NO',
            ':id_usr_creo' => $id_usuario,
            ':direccion' => $data['direccion']
        ));

        if ($query) {
            $id_precotizacion = $this->conexion->lastInsertId();

            for ($index = 0; $index < count($data['items']); $index++) {

                $sql_items = "INSERT INTO precotizacion_items(id_precotizacion,id_item,tipo_item)VALUES
                              (:id_precotizacion,:id_item,:tipo_item)";
                $query_item = $this->conexion->prepare($sql_items);
                $query_item->execute(array(
                    ':id_precotizacion' => $id_precotizacion,
                    ':id_item' => $data['items'][$index],
                    ':tipo_item' => $data['tipo_items'][$index]
                ));
            }
            if ($query_item) {
                return $id_precotizacion;
            } else {
                return "mal";
            }
        } else {
            return "mal";
        }
    }

    public function ListaPrecotizaciones($data) {
        $query = $this->conexion->prepare("SELECT pre.*,us.nombre_completo
                                           FROM precotizacion pre
                                           INNER JOIN usuario us ON us.id = pre.id_usr_creo");
        $query->execute();
        $rows = $query->fetchAll(PDO::FETCH_ASSOC);
        $json_retorno = json_encode($rows);
        return $json_retorno;
    }

}
