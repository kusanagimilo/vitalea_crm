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

    public function ItemsPorPlan($data) {

        if ($data['tipo_item'] == "examen") {
            $sql = "SELECT pli.id_plan_item,pli.precio_plan,pli.precio_regular,exam.codigo,exam.nombre
FROM plan_item pli 
INNER JOIN plan ON pli.id_plan = plan.id_plan
INNER JOIN examenes_no_perfiles exam ON exam.id = pli.id_item
WHERE pli.id_plan = :id_plan
AND tipo_item = 'examen'";
        } else {
            $sql = "SELECT pli.id_plan_item,pli.precio_plan,pli.precio_regular,exam.codigo_crm AS codigo,exam.nombre
FROM plan_item pli 
INNER JOIN plan ON pli.id_plan = plan.id_plan
INNER JOIN examen exam ON exam.id = pli.id_item
WHERE pli.id_plan = :id_plan
AND tipo_item = 'chequeo'";
        }

        $query = $this->conexion->prepare($sql);
        $query->execute(array(':id_plan' => $data['id_plan']));
        $rows = $query->fetchAll(PDO::FETCH_ASSOC);

        return json_encode($rows);
    }

    public function EditarPrecioItem($data) {
        try {
            $sql_editar_plan = "UPDATE plan_item SET precio_plan = :precio_plan WHERE id_plan_item=:id_plan_item";
            $query_editar = $this->conexion->prepare($sql_editar_plan);
            $query_editar->execute(array(':precio_plan' => $data['precio'],
                ':id_plan_item' => $data['id_plan_item']));

            return 1;
        } catch (Exception $exc) {
            return 2;
        }
    }

    public function AlmacenarPlanTarifaCsv($data, $files_data) {
        /* $fp = fopen($files_data['archivo']['tmp_name'], "r");
          $i = 0;
          while ($data = fgetcsv($fp, 1000000, ";")) {
          if ($i > 0) {

          $sql_explora_chequeo = "SELECT * FROM examen WHERE codigo_crm = :codigo";
          $query_explora_chequeo = $this->conexion->prepare($sql_explora_chequeo);
          $query_explora_chequeo->execute(array(':codigo' => $data[1]));
          $rows_chequeo = $query_explora_chequeo->fetchAll(PDO::FETCH_ASSOC);

          if (empty($rows_chequeo)) {

          } else {
          return var_dump($rows_chequeo);
          }
          }
          $i++;
          }
          die(); */



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


                $fp = fopen($files_data['archivo']['tmp_name'], "r");
                $i = 0;
                while ($data_ex = fgetcsv($fp, 1000000, ";")) {
                    if ($i > 0) {

                        $sql_explora_chequeo = "SELECT * FROM examen WHERE codigo_crm = :codigo";
                        $query_explora_chequeo = $this->conexion->prepare($sql_explora_chequeo);
                        $query_explora_chequeo->execute(array(':codigo' => trim($data_ex[1])));
                        $rows_chequeo = $query_explora_chequeo->fetchAll(PDO::FETCH_ASSOC);

                        if (empty($rows_chequeo)) {
                            $sql_explora_examen = "SELECT * FROM examenes_no_perfiles WHERE codigo = :codigo";
                            $query_explora_examen = $this->conexion->prepare($sql_explora_examen);
                            $query_explora_examen->execute(array(':codigo' => trim($data_ex[1])));
                            $rows_examen = $query_explora_examen->fetchAll(PDO::FETCH_ASSOC);
                            if (!empty($rows_examen)) {

                                $sql_insert_plan_item = "INSERT INTO plan_item(id_item,id_plan,tipo_item,precio_regular,precio_plan)
                            VALUES(:id_item,:id_plan,:tipo_item,:precio_regular,:precio_plan)";
                                $query_insert_plan_item = $this->conexion->prepare($sql_insert_plan_item);
                                $query_insert_plan_item->execute(array(':id_item' => $rows_examen[0]['id'],
                                    ':id_plan' => $id_plan,
                                    ':tipo_item' => 'examen',
                                    ':precio_regular' => $rows_examen[0]['precio'],
                                    ':precio_plan' => trim($data_ex[3])));
                            }
                        } else {
                            $sql_insert_plan_item = "INSERT INTO plan_item(id_item,id_plan,tipo_item,precio_regular,precio_plan)
                            VALUES(:id_item,:id_plan,:tipo_item,:precio_regular,:precio_plan)";
                            $query_insert_plan_item = $this->conexion->prepare($sql_insert_plan_item);
                            $query_insert_plan_item->execute(array(':id_item' => $rows_chequeo[0]['id'],
                                ':id_plan' => $id_plan,
                                ':tipo_item' => 'chequeo',
                                ':precio_regular' => $rows_chequeo[0]['precio'],
                                ':precio_plan' => trim($data_ex[3])));
                        }
                    }
                    $i++;
                }

                return 1;
            } catch (Exception $exc) {
                return 2;
            }
        } else {
            return 3;
        }
    }

    public function EditarInfoPlan($data, $files_data) {
        session_start();
        $id_usuario = $_SESSION["ID_USUARIO"];
        $query = $this->conexion->prepare("SELECT id_plan FROM plan WHERE codigo_plan = :codigo_plan");
        $query->execute(array(':codigo_plan' => $data['codigo_plan']));
        $rows = $query->fetchAll(PDO::FETCH_ASSOC);

        $query_cod_id = $this->conexion->prepare("SELECT id_plan FROM plan WHERE codigo_plan = :codigo_plan AND id_plan=:id_plan");
        $query_cod_id->execute(array(':codigo_plan' => $data['codigo_plan'], ':id_plan' => $data['id_plan']));
        $rows_cod_id = $query_cod_id->fetchAll(PDO::FETCH_ASSOC);


        if (empty($rows) || !empty($rows_cod_id)) {
            try {
                $sql_update = "UPDATE plan SET codigo_plan=:codigo_plan,
                              nombre_plan=:nombre_plan,
                              id_usr_modifico=:id_usr_modifico
                              WHERE id_plan=:id_plan";
                $query_update = $this->conexion->prepare($sql_update);
                $query_update->execute(array(':codigo_plan' => $data['codigo_plan'],
                    ':nombre_plan' => $data['nombre_plan'],
                    ':id_usr_modifico' => $id_usuario,
                    ':id_plan' => $data['id_plan']));



                if ($files_data['archivo_edt']['tmp_name'] != NULL || $files_data['archivo_edt']['tmp_name'] != "" || $files_data['archivo_edt']['tmp_name'] != 0) {

                    $fp = fopen($files_data['archivo_edt']['tmp_name'], "r");
                    $i = 0;
                    while ($data_ex = fgetcsv($fp, 1000000, ";")) {
                        if ($i > 0) {

                            $sql_explora_chequeo = "SELECT * FROM examen WHERE codigo_crm = :codigo";
                            $query_explora_chequeo = $this->conexion->prepare($sql_explora_chequeo);
                            $query_explora_chequeo->execute(array(':codigo' => trim($data_ex[1])));
                            $rows_chequeo = $query_explora_chequeo->fetchAll(PDO::FETCH_ASSOC);

                            if (empty($rows_chequeo)) {
                                $sql_explora_examen = "SELECT * FROM examenes_no_perfiles WHERE codigo = :codigo";
                                $query_explora_examen = $this->conexion->prepare($sql_explora_examen);
                                $query_explora_examen->execute(array(':codigo' => trim($data_ex[1])));
                                $rows_examen = $query_explora_examen->fetchAll(PDO::FETCH_ASSOC);
                                if (!empty($rows_examen)) {

                                    /* Explora si existe el item plan para modificarlo */

                                    $sql_explora_item = "SELECT * FROM plan_item WHERE id_plan=:id_plan AND id_item=:id_item AND tipo_item = 'examen'";
                                    $query_explora_item = $this->conexion->prepare($sql_explora_item);
                                    $query_explora_item->execute(array(':id_plan' => $data['id_plan'],
                                        ':id_item' => $rows_examen[0]['id']));
                                    $rows_item = $query_explora_item->fetchAll(PDO::FETCH_ASSOC);

                                    if (!empty($rows_item)) {

                                        /* Edita el precio de los items de los planes */

                                        $sql_update_item = "UPDATE plan_item SET precio_plan =:precio_plan WHERE id_plan_item=:id_plan_item";
                                        $query_update_plan_item = $this->conexion->prepare($sql_update_item);
                                        $query_update_plan_item->execute(array(':id_plan_item' => $rows_item[0]['id_plan_item'],
                                            ':precio_plan' => trim($data_ex[3])));
                                    } else {

                                        /* si no esta el item lo agrega */

                                        $sql_insert_plan_item = "INSERT INTO plan_item(id_item,id_plan,tipo_item,precio_regular,precio_plan)
                            VALUES(:id_item,:id_plan,:tipo_item,:precio_regular,:precio_plan)";
                                        $query_insert_plan_item = $this->conexion->prepare($sql_insert_plan_item);
                                        $query_insert_plan_item->execute(array(':id_item' => $rows_examen[0]['id'],
                                            ':id_plan' => $data['id_plan'],
                                            ':tipo_item' => 'examen',
                                            ':precio_regular' => $rows_examen[0]['precio'],
                                            ':precio_plan' => trim($data_ex[3])));
                                    }
                                }
                            } else {
                                /* Explora si existe el item plan para modificarlo */

                                $sql_explora_item = "SELECT * FROM plan_item WHERE id_plan=:id_plan AND id_item=:id_item AND tipo_item = 'chequeo'";
                                $query_explora_item = $this->conexion->prepare($sql_explora_item);
                                $query_explora_item->execute(array(':id_plan' => $data['id_plan'],
                                    ':id_item' => $rows_chequeo[0]['id']));
                                $rows_item = $query_explora_item->fetchAll(PDO::FETCH_ASSOC);

                                if (!empty($rows_item)) {

                                    $sql_update_item = "UPDATE plan_item SET precio_plan =:precio_plan WHERE id_plan_item=:id_plan_item";
                                    $query_update_plan_item = $this->conexion->prepare($sql_update_item);
                                    $query_update_plan_item->execute(array(':id_plan_item' => $rows_item[0]['id_plan_item'],
                                        ':precio_plan' => trim($data_ex[3])));
                                } else {
                                    $sql_insert_plan_item = "INSERT INTO plan_item(id_item,id_plan,tipo_item,precio_regular,precio_plan)
                                  VALUES(:id_item,:id_plan,:tipo_item,:precio_regular,:precio_plan)";
                                    $query_insert_plan_item = $this->conexion->prepare($sql_insert_plan_item);
                                    $query_insert_plan_item->execute(array(':id_item' => $rows_chequeo[0]['id'],
                                        ':id_plan' => $data['id_plan'],
                                        ':tipo_item' => 'chequeo',
                                        ':precio_regular' => $rows_chequeo[0]['precio'],
                                        ':precio_plan' => trim($data_ex[3])));
                                }
                            }
                        }
                        $i++;
                    }
                }
                return 1;
            } catch (Exception $exc) {
                return 2;
            }
        } else {
            return 3;
        }
    }

    function InfoPlan($data) {
        $query = $this->conexion->prepare("SELECT * FROM plan WHERE activo = 1 AND id_plan=:id_plan");
        $query->execute(array(':id_plan' => $data['id_plan']));
        $rows = $query->fetchAll(PDO::FETCH_ASSOC);
        return json_encode($rows[0]);
    }

}
