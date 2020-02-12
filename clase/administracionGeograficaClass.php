<?php

require_once '../conexion/conexion_bd.php';
include 'WS.php';

/**
 * Description of Administracion de regionales
 *
 * @author Alexander Pineda
 */
class Geografia {

    public $conexion;

    function __construct() {
        $this->conexion = new Conexion();
    }


    public function verPaises($data) {
        $query = $this->conexion->prepare("SELECT * FROM crm_preatencion_prod.paises");
        $query->execute();
        $rows = $query->fetchAll(PDO::FETCH_ASSOC);
        $json_retorno = json_encode($rows);
        return $json_retorno;
    }

    public function agregarPaises($data) {
        $query = $this->conexion->prepare("INSERT INTO crm_preatencion_prod.paises(nombre_pais)VALUES(:pais)");
        $query->execute(array(
            ':pais' => $data['pais']
        ));
        $rows = $query->fetchAll(PDO::FETCH_ASSOC);
        $json_retorno2 = json_encode($rows);
        return $json_retorno2;
    }
    public function consultarIdPais($data) {
        $query = $this->conexion->prepare("SELECT id FROM paises WHERE nombre_pais =:pais;");
        $query->execute(array(
            ':pais' => $data['muestraPais']
        ));
        $rows = $query->fetchAll(PDO::FETCH_ASSOC);
        $json_retorno2 = json_encode($rows);
        return $json_retorno2;
    }

    public function agregarEstado($data) {
        $query = $this->conexion->prepare("INSERT INTO estados_departamentos(estado, id_pais) VALUES (:estado, :idpais)");
        $query->execute(array(
            ':estado' => $data['pais'],
            ':idpais' => $data['idPais']
        ));
        $rows = $query->fetchAll(PDO::FETCH_ASSOC);
        $json_retorno2 = json_encode($rows);
        return $json_retorno2;
    }

    public function verEstados($data) {
        $query = $this->conexion->prepare("SELECT estado FROM crm_preatencion_prod.estados_departamentos WHERE id_pais = :idpais");
        $query->execute(array(
            ':idpais' => $data['idPais']
        ));
        $rows = $query->fetchAll(PDO::FETCH_ASSOC);
        $json_retorno = json_encode($rows);
        return $json_retorno;
    }

    public function verCiudad($data) {
        $query = $this->conexion->prepare("SELECT * FROM crm_preatencion_prod.paises");
        $query->execute();
        $rows = $query->fetchAll(PDO::FETCH_ASSOC);
        $json_retorno = json_encode($rows);
        return $json_retorno;
    }
    // public function AlmacenarPreCotizacion($data) {
    //     @session_start();
    //     $id_usuario = $_SESSION['ID_USUARIO'];
    //     $query = $this->conexion->prepare("INSERT INTO precotizacion(nombre_cliente,correo,telefono,valor,descuento,id_usr_creo,direccion,observacion,contactado,firma)VALUES
    //               (:nombre_cliente,:correo,:telefono,:valor,:descuento,:id_usr_creo,:direccion,:observacion,:contactado,:firma)");
    //     $query->execute(array(
    //         ':nombre_cliente' => $data['nombre_cliente'],
    //         ':correo' => $data['correo'],
    //         ':telefono' => $data['telefono'],
    //         ':valor' => $data['valor'],
    //         ':descuento' => 'NO',
    //         ':id_usr_creo' => $id_usuario,
    //         ':direccion' => $data['direccion'],
    //         ':observacion' => $data['observacion'],
    //         ':contactado' => $data['contactado'],
    //         ':firma' => $data['imagenBase64']
    //     ));

    //     if ($query) {
    //         $id_precotizacion = $this->conexion->lastInsertId();

    //         for ($index = 0; $index < count($data['items']); $index++) {

    //             $sql_items = "INSERT INTO precotizacion_items(id_precotizacion,id_item,tipo_item)VALUES
    //                           (:id_precotizacion,:id_item,:tipo_item)";
    //             $query_item = $this->conexion->prepare($sql_items);
    //             $query_item->execute(array(
    //                 ':id_precotizacion' => $id_precotizacion,
    //                 ':id_item' => $data['items'][$index],
    //                 ':tipo_item' => $data['tipo_items'][$index]
    //             ));
    //         }
    //         if ($query_item) {
    //             return $id_precotizacion;
    //         } else {
    //             return "mal";
    //         }
    //     } else {
    //         return "mal";
    //     }
    // }   

    // function VerDetalleVentaF($data) {

    //     $arreglo_retorno = array();

    //     $query = $this->conexion->prepare("SELECT ven.id as id_venta,cli.id_cliente,tpd.nombre as tipo_doc,cli.documento,ges.observacion,
    //     mdp.medio_pago,CONCAT(cli.nombre,' ',cli.apellido) as cliente,
    //     SUM(vei.valor) as total_venta,ven.fecha_creacion,ven.fecha_pago,ven.estado,mdp.id as id_medio_pago
    //     FROM venta ven
    //     INNER JOIN gestion ges ON ges.id = ven.gestion_id
    //     INNER JOIN cliente cli ON cli.id_cliente = ven.cliente_id
    //     INNER JOIN tipo_documento tpd ON tpd.id = cli.tipo_documento
    //     INNER JOIN medio_pago mdp ON mdp.id = ven.medio_pago
    //     INNER JOIN venta_items vei ON vei.venta_id = ven.id 
    //     WHERE ven.id=:id
    //     GROUP BY ven.id");
    //     $query->execute(array(':id' => $data['id']));
    //     $rows_fact_d = $query->fetchAll(PDO::FETCH_ASSOC);

    //     $arreglo_retorno["informacion_factura"] = $rows_fact_d[0];

    //     $query_items_examen = $this->conexion->prepare("select id,examen_id,valor,descuento,tipo_examen from venta_items where venta_id = :id_venta");
    //     $query_items_examen->execute(array(':id_venta' => $data['id']));


    //     $rows_items = $query_items_examen->fetchAll(PDO::FETCH_ASSOC);


    //     $arreglo_items = array();
    //     $i = 0;

    //     foreach ($rows_items as $key => $value) {

    //         $sql = "";
    //         if ($value['tipo_examen'] == 2) {
    //             $sql = "SELECT * FROM examenes_no_perfiles WHERE id=:id_examen";
    //         } else if ($value['tipo_examen'] == 1) {
    //             $sql = "SELECT * FROM examen WHERE id=:id_examen";
    //         }
    //         $query_detalle_examen = $this->conexion->prepare($sql);
    //         $query_detalle_examen->execute(array(':id_examen' => $value['examen_id']));
    //         $row_item = $query_detalle_examen->fetchAll(PDO::FETCH_ASSOC);

    //         $arreglo_items[$i]["id_venta_item"] = $value["id"];
    //         $arreglo_items[$i]["examen_id"] = $value["examen_id"];
    //         $arreglo_items[$i]["valor"] = $value["valor"];
    //         $arreglo_items[$i]["descuento"] = $value["descuento"];
    //         $arreglo_items[$i]["nombre_examen"] = $row_item[0]["nombre"];
    //         $i++;
    //     }

    //     $arreglo_retorno["items"] = $arreglo_items;
    //     $json_retorno = json_encode($arreglo_retorno);

    //     return $json_retorno;
    // }

    // public function NoFactura($data) {
    //     $query = $this->conexion->prepare("SELECT no_factura FROM venta WHERE id=:id_venta");
    //     $query->execute(array(":id_venta" => $data["id_venta"]));
    //     $rows = $query->fetchAll(PDO::FETCH_ASSOC);

    //     //return var_dump($rows);

    //     if (!empty($rows)) {
    //         if ($rows[0]["no_factura"] == null || $rows[0]["no_factura"] == "") {
    //             return "sin_factura";
    //         } else {
    //             return $rows[0]["no_factura"];
    //         }
    //     } else {
    //         return "sin_factura";
    //     }
    // }

    // public function ModificarNoFacturacion($data) {
    //     $query_up = $this->conexion->prepare("UPDATE venta SET no_factura =:no_factura WHERE id=:id_venta");
    //     $query_up->execute(array(':no_factura' => $data["no_factura"],
    //         ':id_venta' => $data["id_venta"]));

    //     if ($query_up) {
    //         return 1;
    //     } else {
    //         return 2;
    //     }
    // }

    // public function EstadoTurnoFacturacion($id_venta) {
    //     $query = $this->conexion->prepare("SELECT * FROM turno WHERE tipo_turno = 'TOMA_MUESTRA' AND id_venta =:id_venta 
    //                                        ORDER BY fecha_creacion DESC LIMIT 1");
    //     $query->execute(array(":id_venta" => $id_venta));
    //     $rows = $query->fetchAll(PDO::FETCH_ASSOC);


    //     if (empty($rows)) {
    //         return "permite_turno";
    //     } else {
    //         if ($rows[0]["estado"] == "CANCELADO") {
    //             return "permite_turno";
    //         } else {
    //             return "ya_existe_turno";
    //         }
    //     }
    // }

    // public function btnVerMasDetallesExamenNoPerfiles($data) {
    //     $query = $this->conexion->prepare("SELECT * FROM crm_preatencion_prod.examen WHERE id= :idExamen");
    //     $query->execute(array(
    //         ':idExamen' => $data['idExamen']
    //     ));
    //     $rows = $query->fetchAll(PDO::FETCH_ASSOC);
    //     $json_retorno2 = json_encode($rows);
    //     return $json_retorno2;
    // }

    // public function btnVerMasDetallesPerfiles($data) {
    //     $query = $this->conexion->prepare("SELECT * FROM crm_preatencion_prod.examenes_no_perfiles WHERE id= :idExamen");
    //     $query->execute(array(
    //         ':idExamen' => $data['idExamen']
    //     ));
    //     $rows = $query->fetchAll(PDO::FETCH_ASSOC);
    //     $json_retorno2 = json_encode($rows);
    //     return $json_retorno2;
    // }

    // public function consultaCotizacionPdf($data) {
    //     $query = $this->conexion->prepare("SELECT * FROM crm_preatencion_prod.precotizacion WHERE id_precotizacion = :idExamen");
    //     $query->execute(array(
    //         ':idExamen' => $data['cotizId']
    //     ));
    //     $rows = $query->fetchAll(PDO::FETCH_ASSOC);
    //     $json_retorno2 = json_encode($rows);
    //     return $json_retorno2;
    // }
}
