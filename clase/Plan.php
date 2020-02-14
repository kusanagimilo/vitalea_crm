<?php

require_once '../conexion/conexion_bd.php';

class Plan {

    public $conexion;

    function __construct() {
        $this->conexion = new Conexion();
    }

    function VerPlanes() {
        $query = $this->conexion->prepare("SELECT id_plan,codigo_plan,nombre_plan
                                           FROM plan WHERE activo = 1");
        $query->execute();

        $rows = $query->fetchAll(PDO::FETCH_ASSOC);

        return json_encode($rows);
    }

    function AlmacenarPlanTarifaSistema($data) {

        session_start();
        $id_usuario = $_SESSION["ID_USUARIO"];

        $query = $this->conexion->prepare("SELECT id_plan FROM plan WHERE codigo_plan = :codigo_plan");
        $query->execute(array(':codigo_plan' => $data['codigo_plan']));
        $rows = $query->fetchAll(PDO::FETCH_ASSOC);

        if (empty($rows)) {
            try {
                $sql_insert = "INSERT INTO plan(codigo_plan,nombre_plan,fecha_creacion,id_usr_creo,id_usr_modifico)
                        VALUES(:codigo_plan,:nombre_plan,NOW(),:id_usr_creo,:id_usr_modifico)";
                $query_insert = $this->conexion->prepare($sql_insert);
                $query_insert->execute(array(':codigo_plan' => $data['codigo_plan'],
                    ':nombre_plan' => $data['nombre_plan'],
                    ':id_usr_creo' => $id_usuario,
                    ':id_usr_modifico' => $id_usuario));

                $id_plan = $this->conexion->lastInsertId();

                $query_items_p = $this->conexion->prepare("SELECT * FROM examen WHERE grupo_id IS NOT NULL AND activo = 1");
                $query_items_p->execute();
                $rows_items_p = $query_items_p->fetchAll(PDO::FETCH_ASSOC);

                $query_items_e = $this->conexion->prepare("SELECT * FROM examenes_no_perfiles WHERE activo = 1");
                $query_items_e->execute();
                $rows_items_e = $query_items_e->fetchAll(PDO::FETCH_ASSOC);



                foreach ($rows_items_p as $key => $value) {
                    $sql_insert_plan_item = "INSERT INTO plan_item(id_item,id_plan,tipo_item,precio_regular,precio_plan)
                            VALUES(:id_item,:id_plan,:tipo_item,:precio_regular,:precio_plan)";
                    $query_insert_plan_item = $this->conexion->prepare($sql_insert_plan_item);
                    $query_insert_plan_item->execute(array(':id_item' => $value['id'],
                        ':id_plan' => $id_plan,
                        ':tipo_item' => 'chequeo',
                        ':precio_regular' => $value['precio'],
                        ':precio_plan' => $value['precio']));
                }

                foreach ($rows_items_e as $key2 => $value2) {
                    $sql_insert_plan_item_e = "INSERT INTO plan_item(id_item,id_plan,tipo_item,precio_regular,precio_plan)
                            VALUES(:id_item,:id_plan,:tipo_item,:precio_regular,:precio_plan)";
                    $query_insert_plan_item_e = $this->conexion->prepare($sql_insert_plan_item_e);
                    $query_insert_plan_item_e->execute(array(':id_item' => $value2['id'],
                        ':id_plan' => $id_plan,
                        ':tipo_item' => 'examen',
                        ':precio_regular' => $value2['precio'],
                        ':precio_plan' => $value2['precio']));
                }

                return 1;
            } catch (Exception $exc) {
                return 2;
            }
        } else {
            return 3;
        }
    }

}
