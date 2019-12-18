<?php

require_once '../conexion/conexion_bd.php';
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Modulo
 *
 * @author JuanCamilo
 */
class Modulo {

    public $conexion;

    function __construct() {
        $this->conexion = new Conexion();
    }

    public function CrearModulo($data) {
        $query = $this->conexion->prepare("INSERT INTO modulo(modulo,fecha_creacion) VALUES (:modulo,NOW())");
        $query->execute(array(':modulo' => $data["modulo"]));

        if ($query) {
            return 1;
        } else {
            return 2;
        }
    }

    public function VerModulos($data) {

        $query = $this->conexion->prepare("SELECT * FROM modulo");
        $query->execute();

        $rows = $query->fetchAll(PDO::FETCH_ASSOC);

        return json_encode($rows);
    }

    public function UsuariosSelec($data) {
        $query = $this->conexion->prepare("SELECT id,nombre_completo FROM usuario WHERE activo = 1 AND permisos_digiturno <> 0");
        $query->execute();

        $rows = $query->fetchAll(PDO::FETCH_ASSOC);

        return json_encode($rows);
    }

    public function UsuarioAsignado($data) {

        $query = $this->conexion->prepare("SELECT us.nombre_completo,mdu.id_modulo_usuario,mdu.id_usuario,mdu.tipo_atencion,
mdu.estado,mdu.fecha_creacion,mdu.fecha_modificacion
FROM modulo_usuario mdu
INNER JOIN usuario us ON us.id = mdu.id_usuario
WHERE mdu.id_modulo =:modulo
AND mdu.estado =:estado");
        $query->execute(array(':modulo' => $data['modulo'],
            ':estado' => 'ACTIVO'));

        $rows = $query->fetchAll(PDO::FETCH_ASSOC);

        return json_encode($rows);
    }

    public function AsignarUsuarioModulo($data) {

        $query_up = $this->conexion->prepare("UPDATE modulo_usuario SET estado =:estado WHERE id_modulo =:modulo");
        $query_up->execute(array(':modulo' => $data["modulo"],
            ':estado' => "INACTIVO"));
        if ($query_up) {
            $query = $this->conexion->prepare("INSERT INTO modulo_usuario(id_usuario,id_modulo,tipo_atencion,estado,fecha_creacion)
             VALUES(:id_usuario,:id_modulo,:tipo_atencion,:estado,NOW())");
            $query->execute(array(':id_usuario' => $data["usuario"],
                ':id_modulo' => $data['modulo'],
                ':tipo_atencion' => $data['tipo_atencion'],
                ':estado' => 'ACTIVO'));
            if ($query) {
                return 1;
            } else {
                return 2;
            }
        } else {
            return 2;
        }
    }

}
