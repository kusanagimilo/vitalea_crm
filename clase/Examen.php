<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once '../conexion/conexion_bd.php';

/**
 * Description of Examen
 *
 * @author JuanCamilo
 */
class Examen {

    public $conexion;

    function __construct() {
        $this->conexion = new Conexion();
    }

    public function VerExamenesNoPerfiles($data) {

        $query = $this->conexion->prepare("SELECT id,codigo_crm,nombre,precio
                                           FROM examen WHERE grupo_id IS NOT NULL
                                           AND activo = 1");
        $query->execute();

        $rows = $query->fetchAll(PDO::FETCH_ASSOC);

        return json_encode($rows);
    }

    public function VerExamenesPorPerfil($data) {

        $query = $this->conexion->prepare("SELECT exa.id as id_examen_perfil,enp.id as id_no_perfil,pex.id_perfil_examen,exa.codigo_crm as codigo_perfil,
exa.nombre as nombre_perfil,enp.codigo as codigo_no_perfil,enp.nombre as nombre_no_perfil
FROM examen exa
INNER JOIN perfil_examen pex ON pex.id_perfil = exa.id
INNER JOIN examenes_no_perfiles enp ON enp.id = pex.id_examen
WHERE exa.id = :id");
        $query->execute(array(':id' => $data['id_perfil']));
        $rows = $query->fetchAll(PDO::FETCH_ASSOC);
        return json_encode($rows);
    }

    public function AdicionarExamenPorPerfil($data) {
        $sql = "INSERT INTO perfil_examen(id_perfil,id_examen)VALUES(:id_perfil,:id_examen)";
        $query = $this->conexion->prepare($sql);
        $query->execute(array(':id_perfil' => $data['id_perfil'],
            ':id_examen' => $data['id_examen']));
        if ($query) {
            return 1;
        } else {
            return 2;
        }
    }

    public function ListaExamenes($data) {

        $query = $this->conexion->prepare("SELECT id,codigo,nombre,precio FROM examenes_no_perfiles WHERE activo = 1");
        $query->execute();

        $rows = $query->fetchAll(PDO::FETCH_ASSOC);

        return json_encode($rows);
    }

    public function VerSubExamen($data) {
        $query = $this->conexion->prepare("SELECT * FROM sub_examen WHERE id_examen = :id_examen");
        $query->execute(array(':id_examen' => $data['id_examen']));
        $rows = $query->fetchAll(PDO::FETCH_ASSOC);
        return json_encode($rows);
    }

    public function AdicionarSubExamen($data) {

        $query = $this->conexion->prepare("SELECT * FROM sub_examen WHERE codigo_sub_examen = :codigo_sub_examen");
        $query->execute(array(':codigo_sub_examen' => $data['codigo_sub_examen']));
        $rows = $query->fetchAll(PDO::FETCH_ASSOC);

        if (empty($rows)) {

            try {
                $sql_insert = "INSERT INTO sub_examen(id_examen,codigo_sub_examen,nombre_sub_examen)VALUES(:id_examen,:codigo_sub_examen,:nombre_sub_examen)";
                $query_insert = $this->conexion->prepare($sql_insert);
                $query_insert->execute(array(':id_examen' => $data['id_examen'],
                    ':codigo_sub_examen' => $data['codigo_sub_examen'],
                    ':nombre_sub_examen' => $data['nombre_sub_examen']));
                return 1;
            } catch (Exception $exc) {
                return 2;
            }
        } else {
            return 3;
        }
    }

    public function EliminarExamenPorPerfil($data) {

        try {
            $sql_delete = "DELETE FROM perfil_examen WHERE id_perfil_examen = :id_perfil_examen";
            $query_delete = $this->conexion->prepare($sql_delete);
            $query_delete->execute(array(':id_perfil_examen' => $data['id_perfil_examen']));
            return 1;
        } catch (Exception $exc) {
            return 2;
        }
    }

    public function ListaGrupos($data) {
        $query = $this->conexion->prepare("SELECT * FROM examen WHERE grupo_id IS NULL");
        $query->execute();

        $rows = $query->fetchAll(PDO::FETCH_ASSOC);

        return json_encode($rows);
    }

    public function AlmacenarPerfil($data) {

        $sql_revisa = "SELECT id FROM examen WHERE codigo_crm =:codigo_crm";
        $query = $this->conexion->prepare($sql_revisa);
        $query->execute(array(':codigo_crm' => $data['codigo_crm']));
        $rows = $query->fetchAll(PDO::FETCH_ASSOC);

        if (empty($rows)) {

            $sql_almacenar = "INSERT INTO examen(grupo_id,nombre,codigo_crm,preparacion,recomendaciones,
                              precio,precio_menos_cinco,precio_menos_diez,precio_menos_quince)
                              VALUES(:grupo_id,:nombre,:codigo_crm,:preparacion,:recomendaciones,
                              :precio,:precio_menos_cinco,:precio_menos_diez,:precio_menos_quince)";

            $precio_menos_cinco = (int) $data['precio'] - 5000;
            $precio_menos_diez = (int) $data['precio'] - 10000;
            $precio_menos_quince = (int) $data['precio'] - 15000;

            $query_almacenar = $this->conexion->prepare($sql_almacenar);
            $query_almacenar->execute(array(':grupo_id' => $data['grupo_id'],
                ':nombre' => $data['nombre'],
                ':codigo_crm' => $data['codigo_crm'],
                ':preparacion' => $data['preparacion'],
                ':recomendaciones' => $data['recomendaciones'],
                ':precio' => $data['precio'],
                ':precio_menos_cinco' => $precio_menos_cinco,
                ':precio_menos_diez' => $precio_menos_diez,
                ':precio_menos_quince' => $precio_menos_quince));

            if ($query_almacenar) {
                return 1;
            } else {
                return 2;
            }
        } else {
            return 3;
        }
    }

    function AlmacenarExamen($data) {
        $sql_revisa = "SELECT id FROM examenes_no_perfiles WHERE codigo =:codigo";
        $query = $this->conexion->prepare($sql_revisa);
        $query->execute(array(':codigo' => $data['codigo']));
        $rows = $query->fetchAll(PDO::FETCH_ASSOC);

        if (empty($rows)) {

            $sql_almacenar = "INSERT INTO examenes_no_perfiles(codigo,nombre,validar_peru,precio,activo)
                              VALUES(:codigo,:nombre,:validar_peru,:precio,:activo)";

            $query_almacenar = $this->conexion->prepare($sql_almacenar);
            $query_almacenar->execute(array(':codigo' => $data['codigo'],
                ':nombre' => $data['nombre'],
                ':validar_peru' => "NO",
                ':precio' => $data['precio'],
                ':activo' => 1));

            if ($query_almacenar) {
                return 1;
            } else {
                return 2;
            }
        } else {
            return 3;
        }
    }

    function InformacionPerfil($data) {
        $query = $this->conexion->prepare("SELECT * FROM examen WHERE id = :id");
        $query->execute(array(':id' => $data['id_perfil']));
        $rows = $query->fetchAll(PDO::FETCH_ASSOC);
        return json_encode($rows);
    }

    function ModificarPerfil($data) {
        session_start();
        $id_usuario = $_SESSION["ID_USUARIO"];

        $precio_5 = intval($data['precio']) - 5000;
        $precio_10 = intval($data['precio']) - 10000;
        $precio_15 = intval($data['precio']) - 15000;

        $query_mod = $this->conexion->prepare("UPDATE examen SET 
                                               grupo_id =:grupo_id,
                                               nombre =:nombre,
                                               codigo_crm=:codigo,
                                               preparacion=:preparacion,
                                               recomendaciones=:recomendaciones,
                                               precio=:precio,
                                               precio_menos_cinco=:precio_menos_cinco,
                                               precio_menos_diez=:precio_menos_diez,
                                               precio_menos_quince=:precio_menos_quince,
                                               id_usuario_modifico=:id_usuario_modifico
                                               WHERE id=:id_perfil");


        $query_mod->execute(array(':grupo_id' => $data['grupo_id'],
            ':nombre' => $data['nombre'],
            ':codigo' => $data['codigo'],
            ':preparacion' => $data['preparacion'],
            ':recomendaciones' => $data['recomendaciones'],
            ':precio' => $data['precio'],
            ':precio_menos_cinco' => $precio_5,
            ':precio_menos_diez' => $precio_10,
            ':precio_menos_quince' => $precio_15,
            ':id_usuario_modifico' => $id_usuario,
            ':id_perfil' => $data['id_perfil']));

        if ($query_mod) {
            return 1;
        } else {
            return 2;
        }
    }

}
