<?php

date_default_timezone_set('America/Bogota');
require_once '../conexion/conexion_bd.php';

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DgTurno
 *
 * @author JuanCamilo
 */
class DgTurno {

    public $conexion;

    function __construct() {
        $this->conexion = new Conexion();
    }

    public function CrearTurno($data) {

        $numero_turno = $this->EntregaNumeroTurno($data['tipo_turno']) + 1;
        $turno = "";

        if ($data['tipo_turno'] == 'PAGO') {
            $turno = "P_" . $numero_turno;
        } else if ($data['tipo_turno'] == 'TOMA_MUESTRA') {
            $turno = "TM_" . $numero_turno;
        }


        $modulo_usuario = $this->ModuloUsuario($data['tipo_turno']);
        $query = $this->conexion->prepare("INSERT INTO turno(id_cliente,id_venta,estado,tipo_turno,turno,fecha_creacion,numero_turno,id_modulo_usuario)
                                           VALUES (:id_cliente,:id_venta,:estado,:tipo_turno,:turno,NOW(),:numero_turno,:id_modulo_usuario)");
        $query->execute(array(':id_cliente' => $data["id_cliente"],
            ':id_venta' => $data['id_venta'],
            ':estado' => 'INICIADO',
            ':tipo_turno' => $data['tipo_turno'],
            ':turno' => $turno,
            ':numero_turno' => $numero_turno,
            ':id_modulo_usuario' => $modulo_usuario));

        $arreglo_retorno = array();

        if ($query) {
            $arreglo_retorno["retorno"] = 1;
            $arreglo_retorno["turno"] = $turno;
        } else {
            $arreglo_retorno["retorno"] = 2;
        }

        return json_encode($arreglo_retorno);
    }

    public function EntregaNumeroTurno($tipo_turno) {

        $anio = date("Y");
        $mes = date("m");
        $dia = date("d");


        $query = $this->conexion->prepare("SELECT max(numero_turno) as numero_turno
FROM turno
WHERE tipo_turno =:tipo_turno
AND YEAR(fecha_creacion) =:anio
AND MONTH(fecha_creacion) =:mes
AND DAY(fecha_creacion) =:dia");

        $query->execute(array(':tipo_turno' => $tipo_turno,
            ':anio' => $anio,
            ':mes' => $mes,
            ':dia' => $dia));

        $rows = $query->fetchAll(PDO::FETCH_ASSOC);


        if ($rows[0]['numero_turno'] == NULL) {
            return 0;
        } else {
            return $rows[0]['numero_turno'];
        }
    }

    public function ModuloUsuario($tipo_atencion) {
        $anio = date("Y");
        $mes = date("m");
        $dia = date("d");

        $query = $this->conexion->prepare("SELECT id_modulo_usuario,id_modulo,tipo_atencion FROM modulo_usuario 
                                           WHERE estado =:estado AND tipo_atencion =:tipo_atencion");
        $query->execute(array(':estado' => 'ACTIVO',
            ':tipo_atencion' => $tipo_atencion));

        $rows = $query->fetchAll(PDO::FETCH_ASSOC);

        $arreglo_modulos = array();

        foreach ($rows as $key => $value) {
            $query2 = $this->conexion->prepare("SELECT mdu.id_modulo_usuario,COUNT(mdu.id_modulo_usuario) AS conteo
FROM modulo_usuario mdu
INNER JOIN turno tur ON tur.id_modulo_usuario = mdu.id_modulo_usuario
WHERE mdu.id_modulo_usuario =:id_modulo_usuario
AND YEAR(tur.fecha_creacion) =:anio
AND MONTH(tur.fecha_creacion) =:mes
AND DAY(tur.fecha_creacion) =:dia
GROUP BY mdu.id_modulo_usuario");
            $query2->execute(array(':id_modulo_usuario' => $value['id_modulo_usuario'],
                ':anio' => $anio,
                ':mes' => $mes,
                ':dia' => $dia));
            $rows2 = $query2->fetchAll(PDO::FETCH_ASSOC);

            if (empty($rows2)) {
                $valor = 0;
            } else {
                $valor = $rows2[0]['conteo'];
            }

            $arreglo_modulos[$value['id_modulo_usuario']] = $valor;
        }

        $valor = min($arreglo_modulos);
        $indice = array_search($valor, $arreglo_modulos);

        return $indice;
    }

    public function DatosTurno($data) {
        $query = $this->conexion->prepare("SELECT id_turno,estado,tipo_turno,turno,numero_turno,id_modulo_usuario
                                           FROM turno
                                           WHERE id_venta =:venta AND tipo_turno =:tipo_turno
                                           ORDER BY id_turno DESC LIMIT 1");
        $query->execute(array(':venta' => $data['venta'],
            ':tipo_turno' => $data['tipo_turno']));

        $rows = $query->fetchAll(PDO::FETCH_ASSOC);
        if (empty($rows)) {
            return json_encode("sin_turno");
        } else {
            return json_encode($rows);
        }
    }

    public function TurnosAsignados($data) {



        $sql = "";
        if ($data['tp_usuario'] == 'PAGO') {

            $sql = "SELECT tur.id_turno,cli.documento,cli.nombre,cli.apellido,tur.estado,tur.tipo_turno,
tur.turno,mdu.id_modulo,mdu.id_usuario,tur.fecha_creacion,tur.fecha_atencion,md.modulo,tur.id_venta
FROM turno tur
INNER JOIN cliente cli ON cli.id_cliente = tur.id_cliente
INNER JOIN modulo_usuario mdu ON mdu.id_modulo_usuario = tur.id_modulo_usuario
INNER JOIN modulo md ON md.id_modulo = mdu.id_modulo
WHERE mdu.estado = 'ACTIVO'
AND mdu.id_usuario = :id_usuario
AND tur.estado IN ('INICIADO','ACEPTADO')
AND YEAR(tur.fecha_creacion) = :anio
AND MONTH(tur.fecha_creacion) = :mes
AND DAY(tur.fecha_creacion) = :dia
AND tipo_turno = 'PAGO'
ORDER BY fecha_creacion ASC";
        } else if ($data['tp_usuario'] == 'TOMA') {

            $sql = "SELECT tur.id_turno,cli.documento,cli.nombre,cli.apellido,tur.estado,tur.tipo_turno,
tur.turno,mdu.id_modulo,mdu.id_usuario,tur.fecha_creacion,tur.fecha_atencion,md.modulo,tur.id_venta
FROM turno tur
INNER JOIN cliente cli ON cli.id_cliente = tur.id_cliente
INNER JOIN modulo_usuario mdu ON mdu.id_modulo_usuario = tur.id_modulo_usuario
INNER JOIN modulo md ON md.id_modulo = mdu.id_modulo
WHERE mdu.estado = 'ACTIVO'
AND mdu.id_usuario = :id_usuario
AND tur.estado IN ('INICIADO','ACEPTADO')
AND YEAR(tur.fecha_creacion) = :anio
AND MONTH(tur.fecha_creacion) = :mes
AND DAY(tur.fecha_creacion) = :dia
AND tipo_turno = 'TOMA_MUESTRA'
ORDER BY fecha_creacion ASC";
        }




        $query = $this->conexion->prepare($sql);
        $query->execute(array(':id_usuario' => $data['id_usuario'],
            ':anio' => date("Y"),
            ':mes' => date("m"),
            'dia' => date("d")));
        $rows = $query->fetchAll(PDO::FETCH_ASSOC);

        return json_encode($rows);
    }

    public function AceptarCancelarTurno($data) {

        $sql = "";
        if ($data['estado'] == 'ACEPTADO') {
            $sql = "UPDATE turno SET estado=:estado,fecha_atencion=NOW() WHERE id_turno=:id_turno";
        } else if ($data['estado'] == 'CANCELADO' || $data['estado'] == 'TERMINADO') {
            $sql = "UPDATE turno SET estado=:estado,fecha_atencion=NOW(),fecha_cierre=NOW() WHERE id_turno=:id_turno";
        }
        $query = $this->conexion->prepare($sql);
        $query->execute(array(':id_turno' => $data["id_turno"],
            ':estado' => $data['estado']));

        if ($query) {
            return 1;
        } else {
            return 2;
        }
    }

    public function TurnosModulos($data) {

        $arreglo_retorno = array();

        $anio = date("Y");
        $mes = date("m");
        $dia = date("d");

        $query = $this->conexion->prepare("SELECT mdu.id_modulo_usuario,mdu.id_modulo,mdu.estado,modu.modulo,mdu.tipo_atencion
FROM modulo_usuario mdu
INNER JOIN modulo modu ON modu.id_modulo = mdu.id_modulo
WHERE mdu.estado = 'ACTIVO'");
        $query->execute();
        $rows = $query->fetchAll(PDO::FETCH_ASSOC);

        foreach ($rows as $key => $value) {

            $query2 = $this->conexion->prepare("SELECT turn.id_turno,turn.id_cliente,turn.estado,turn.turno,cli.nombre,
cli.apellido,turn.fecha_creacion
FROM turno turn
INNER JOIN cliente cli ON cli.id_cliente = turn.id_cliente
WHERE turn.id_modulo_usuario = :id_modulo_usuario
AND YEAR(fecha_creacion) =:anio
AND MONTH(fecha_creacion) =:mes
AND DAY(fecha_creacion) =:dia
AND ESTADO IN('INICIADO','ACEPTADO')
ORDER BY id_turno ASC
LIMIT 1");
            $query2->execute(array(':id_modulo_usuario' => $value["id_modulo_usuario"],
                ':anio' => $anio,
                ':mes' => $mes,
                ':dia' => $dia));

            $arreglo_turno = $query2->fetchAll(PDO::FETCH_ASSOC);

            //return var_dump($arreglo_turno);

            if (!empty($arreglo_turno)) {
                $arreglo_turno[0]["modulo"] = $value["modulo"];
                array_push($arreglo_retorno, $arreglo_turno[0]);
            }
        }

        return json_encode($arreglo_retorno);
    }

    public function SeleccionTurnosToma($data) {
        $query = $this->conexion->prepare("SELECT tur.id_turno,cli.documento,cli.nombre,cli.apellido,tur.estado,tur.tipo_turno,
tur.turno,mdu.id_modulo,mdu.id_usuario,tur.fecha_creacion,tur.fecha_atencion,md.modulo,tur.id_venta,cli.id_cliente
FROM turno tur
INNER JOIN cliente cli ON cli.id_cliente = tur.id_cliente
INNER JOIN modulo_usuario mdu ON mdu.id_modulo_usuario = tur.id_modulo_usuario
INNER JOIN modulo md ON md.id_modulo = mdu.id_modulo
WHERE mdu.estado = 'ACTIVO'
AND mdu.id_usuario = :id_usuario
AND tur.estado IN ('TERMINADO')
AND YEAR(tur.fecha_creacion) = :anio
AND MONTH(tur.fecha_creacion) = :mes
AND DAY(tur.fecha_creacion) = :dia
AND tipo_turno = 'PAGO'
ORDER BY fecha_creacion ASC");
        $query->execute(array(':id_usuario' => $data['id_usuario'],
            ':anio' => date("Y"),
            ':mes' => date("m"),
            'dia' => date("d")));
        $rows = $query->fetchAll(PDO::FETCH_ASSOC);

        $arreglo_retorno = [];

        foreach ($rows as $key => $value) {


            $query1 = $this->conexion->prepare("SELECT id_turno FROM turno WHERE tipo_turno = 'TOMA_MUESTRA' AND id_venta = :id_venta");



            $query1->execute(array(':id_venta' => $value['id_venta']));
            $rows1 = $query1->fetchAll(PDO::FETCH_ASSOC);
            if (empty($rows1)) {
                array_push($arreglo_retorno, $value);
            }
        }

        return json_encode($arreglo_retorno);
    }

    public function BusquedaTurnosDisponibles($data) {

        $arreglo_retorno = array();

        $sql_ventas = "SELECT ven.*,cli.id_cliente,cli.nombre,cli.apellido,documento 
                       FROM venta ven
                       INNER JOIN cliente cli ON cli.id_cliente = ven.cliente_id
                       WHERE cli.documento =:documento
                       ORDER BY ven.fecha_creacion DESC";

        $query_ventas = $this->conexion->prepare($sql_ventas);
        $query_ventas->execute(array(':documento' => $data['documento']));
        $rows_ventas = $query_ventas->fetchAll(PDO::FETCH_ASSOC);




        if (!empty($rows_ventas)) {

            $arreglo_retorno["nombre_completo"] = $rows_ventas[0]["nombre"] . " " . $rows_ventas[0]["apellido"];
            $arreglo_retorno["id_cliente"] = $rows_ventas[0]["id_cliente"];
            $arreglo_retorno["documento"] = $rows_ventas[0]["documento"];



            $i = 0;
            $arreglo_turno = array();
            foreach ($rows_ventas as $key => $value) {

                $tipo_turno = "";

                if ($value["estado"] == 1) {
                    $tipo_turno = "PAGO";
                } else if ($value["estado"] == 2) {
                    $tipo_turno = "TOMA_MUESTRA";
                }

                $query_turno = $this->conexion->prepare("SELECT id_turno,estado,tipo_turno,turno,numero_turno,id_modulo_usuario
                  FROM turno
                  WHERE id_venta =:venta AND tipo_turno =:tipo_turno
                  ORDER BY id_turno DESC LIMIT 1");
                $query_turno->execute(array(':venta' => $value['id'],
                    ':tipo_turno' => $tipo_turno));

                $rows_turno = $query_turno->fetchAll(PDO::FETCH_ASSOC);

                if (empty($rows_turno)) {
                    /* tipo_turno, id_cliente, id_venta */
                    $arreglo_turno[$i]["tipo_turno"] = $tipo_turno;
                    $arreglo_turno[$i]["id_cliente"] = $rows_ventas[0]["id_cliente"];
                    $arreglo_turno[$i]["id_venta"] = $value['id'];
                    if ($value["estado"] == 1) {
                        $arreglo_turno[$i]["fecha_generacion"] = $value["fecha_creacion"];
                    } else if ($value["estado"] == 2) {
                        $arreglo_turno[$i]["fecha_generacion"] = $value["fecha_pago"];
                    }
                    $arreglo_turno[$i]["id_solicitud"] = $value["codigo_venta"];
                    $i++;
                } else if ($rows_turno[0]["estado"] == "CANCELADO") {
                    $arreglo_turno[$i]["tipo_turno"] = $tipo_turno;
                    $arreglo_turno[$i]["id_cliente"] = $rows_ventas[0]["id_cliente"];
                    $arreglo_turno[$i]["id_venta"] = $value['id'];
                    if ($value["estado"] == 1) {
                        $arreglo_turno[$i]["fecha_generacion"] = $value["fecha_creacion"];
                    } else if ($value["estado"] == 2) {
                        $arreglo_turno[$i]["fecha_generacion"] = $value["fecha_pago"];
                    }
                    $arreglo_turno[$i]["id_solicitud"] = $value["codigo_venta"];
                    $i++;
                }
            }

            $arreglo_retorno["turnos_disponibles"] = $arreglo_turno;
            return json_encode($arreglo_retorno);
        } else {
            return json_encode("sin_informacion");
        }
    }

   public function DetalleExamenesSolicitud($data) {
        $arreglo_retorno = array();

        $sql_perfiles = "SELECT exm.id,exm.nombre,exm.codigo_crm,exm.nombre
                         FROM venta_items veni
                         INNER JOIN examen exm ON exm.id = veni.examen_id 
                         WHERE  veni.venta_id =:venta_id AND veni.tipo_examen = :tipo_examen";


        $query_perfiles = $this->conexion->prepare($sql_perfiles);
        $query_perfiles->execute(array(":venta_id" => $data['venta_id'],
            ":tipo_examen" => 1));
        $rows_perfiles = $query_perfiles->fetchAll(PDO::FETCH_ASSOC);


        if (!empty($rows_perfiles)) {
            $arreglo_perfiles = array();
            $i = 0;
            foreach ($rows_perfiles as $key => $value) {

                //die();
                $arreglo_perfiles[$i]["id"] = $value["id"];
                $arreglo_perfiles[$i]["nombre"] = $value["nombre"];
                $arreglo_perfiles[$i]["codigo"] = $value["codigo_crm"];

                $sql_examenes_per = "SELECT exam.id,exam.codigo,exam.nombre FROM perfil_examen per
                                     INNER JOIN examenes_no_perfiles exam ON exam.id = per.id_examen
                                     WHERE id_perfil =:id_perfil";
                $query_examenes_per = $this->conexion->prepare($sql_examenes_per);
                $query_examenes_per->execute(array(":id_perfil" => $value["id"]));
                $rows_examenes_per = $query_examenes_per->fetchAll(PDO::FETCH_ASSOC);




                if (!empty($rows_examenes_per)) {
                    $a = 0;
                    $arreglo_inter_per = array();
                    foreach ($rows_examenes_per as $key2 => $value2) {

                        /* $sql_sub_examen = "SELECT codigo_sub_examen,nombre_sub_examen FROM sub_examen where id_examen = :id_examen";
                          $query_sub_examen = $this->conexion->prepare($sql_sub_examen);
                          $query_sub_examen->execute(array(":id_examen" => $value2["id"]));
                          $rows_sub_examen = $query_sub_examen->fetchAll(PDO::FETCH_ASSOC); */

                        //if (empty($rows_sub_examen)) {
                        $arreglo_inter_per[$a]["codigo"] = $value2["codigo"];
                        $arreglo_inter_per[$a]["nombre"] = $value2["nombre"];
                        //}


                        $a++;
                    }
                    $arreglo_perfiles[$i]["examenes"] = $arreglo_inter_per;
                }

                $i++;
            }

            $arreglo_retorno["perfiles"] = $arreglo_perfiles;
        }

        $sql_no_perfiles = "SELECT exm.id,exm.nombre,exm.codigo
                         FROM venta_items veni
                         INNER JOIN examenes_no_perfiles exm ON exm.id = veni.examen_id 
                         WHERE  veni.venta_id =:venta_id AND veni.tipo_examen = :tipo_examen";


        $query_no_perfiles = $this->conexion->prepare($sql_no_perfiles);
        $query_no_perfiles->execute(array(":venta_id" => $data['venta_id'],
            ":tipo_examen" => 2));
        $rows_no_perfiles = $query_no_perfiles->fetchAll(PDO::FETCH_ASSOC);

        if (!empty($rows_no_perfiles)) {
            $arreglo_no_perfiles = array();
            $h = 0;
            foreach ($rows_no_perfiles as $key3 => $value3) {

                /* $sql_sub_examen = "SELECT codigo_sub_examen,nombre_sub_examen FROM sub_examen where id_examen = :id_examen";
                  $query_sub_examen = $this->conexion->prepare($sql_sub_examen);
                  $query_sub_examen->execute(array(":id_examen" => $value3["id"]));
                  $rows_sub_examen = $query_sub_examen->fetchAll(PDO::FETCH_ASSOC); */

                // if (empty($rows_sub_examen)) {

                $arreglo_no_perfiles[$h]["id"] = $value3["id"];
                $arreglo_no_perfiles[$h]["nombre"] = $value3["nombre"];
                $arreglo_no_perfiles[$h]["codigo"] = $value3["codigo"];
                //}
            	$h++;
            }

            $arreglo_retorno["no_perfiles"] = $arreglo_no_perfiles;
        }



        return json_encode($arreglo_retorno);
    }

}
