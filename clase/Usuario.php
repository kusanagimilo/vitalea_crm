<?php

require_once '../conexion/conexion_bd.php';

class Usuario {

    public $conexion;

    function __construct() {
        $this->conexion = new Conexion();
    }

    function listar_usuarios() {
        $query = $this->conexion->prepare("SELECT u.id,u.documento,u.nombre_completo,
        u.correo, if(pu.activo =1,'Activo','Inactivo') as 'estado',p.nombre as 'perfil',pu.activo,u.nombre_usuario
        FROM usuario as u
        INNER JOIN permisos_usuarios as pu on pu.usuario_id = u.id
        INNER JOIN permisos as p on p.id = pu.permisos_id "
        );
        $query->execute();
        $rows = $query->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
    }

    function listar_usuarios_digiturno() {
        $query = $this->conexion->prepare("SELECT u.id,u.documento,u.nombre_completo,
        u.correo, IF(pu.activo =1,'Activo','Inactivo') AS 'estado',p.nombre AS 'perfil',pu.activo,u.nombre_usuario,u.permisos_digiturno,pd.descripcion_permiso
        FROM usuario AS u
        INNER JOIN permisos_usuarios AS pu ON pu.usuario_id = u.id
        INNER JOIN permisos AS p ON p.id = pu.permisos_id
    INNER JOIN permisos_digiturno AS pd ON pd.id_permisos_digiturno = u.permisos_digiturno "
        );
        $query->execute();
        $rows = $query->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
    }

    function habilitar_usuarios_digiturno() {
        $query = $this->conexion->prepare("SELECT u.id,u.documento,u.nombre_completo,
        u.correo, IF(pu.activo =1,'Activo','Inactivo') AS 'estado',p.nombre AS 'perfil',pu.activo,u.nombre_usuario
        FROM usuario AS u
        INNER JOIN permisos_usuarios AS pu ON pu.usuario_id = u.id
        INNER JOIN permisos AS p ON p.id = pu.permisos_id "
        );
        $query->execute();
        $rows = $query->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
    }

    function numero_usuarios($perfil) {
        $query = $this->conexion->prepare("SELECT COUNT(usuario_id) AS conteo FROM permisos_usuarios WHERE permisos_id= :perfil");
        $query->execute(array(':perfil' => $perfil));

        $rows = $query->fetchAll(PDO::FETCH_ASSOC);
        foreach ($rows as $valor) {
            $opciones[] = array('conteo' => $valor["conteo"]);
        }
        return json_encode($opciones);
    }

    function usuarios_activos($fecha, $tipo_gestion, $permiso) {
        $query = $this->conexion->prepare(" SELECT  COUNT(DISTINCT t.usuario_id) as cantidad FROM tiempo_gestion AS t
        INNER JOIN permisos_usuarios AS p on p.usuario_id= t.usuario_id
        WHERE date(fecha_inicio) =:fecha AND gestion_id = :tipo_gestion AND p.permisos_id=:permiso");
        $query->execute(array(':fecha' => $fecha,
            ':tipo_gestion' => $tipo_gestion,
            ':permiso' => $permiso));

        $rows = $query->fetchAll(PDO::FETCH_ASSOC);
        foreach ($rows as $valor) {
            $opciones[] = array('cantidad' => $valor["cantidad"]);
        }
        return json_encode($opciones);
    }

    public function lista_perfil() {
        $query = $this->conexion->prepare("SELECT id,nombre FROM permisos WHERE id not in (3,4)");
        $query->execute();
        $rows = $query->fetchAll(PDO::FETCH_ASSOC);
        foreach ($rows as $valor) {
            $opciones[] = array('id' => $valor["id"],
                'nombre' => $valor["nombre"]);
        }
        return json_encode($opciones);
    }

    public function crear_usuario($documento, $nombre_completo, $clave, $correo, $nombre_usuario) {
        $query = $this->conexion->prepare("INSERT INTO usuario (documento,nombre_completo,clave,correo,activo,nombre_usuario)
        VALUES (:documento,:nombre_completo,SHA(:clave),:correo,1,:nombre_usuario)");
        $query->execute(array(':documento' => $documento,
            ':nombre_completo' => $nombre_completo,
            ':clave' => $clave,
            ':correo' => $correo,
            ':nombre_usuario' => $nombre_usuario));
    }

    public function consultar_usuario($documento) {
        $query = $this->conexion->prepare("SELECT id FROM usuario WHERE documento = :documento");
        $query->execute(array(":documento" => $documento));
        $rows = $query->fetchAll(PDO::FETCH_ASSOC);

        if (empty($rows)) {
            $id = 0;
        } else {
            foreach ($rows as $valor) {
                $id = $valor["id"];
            }
        }
        return $id;
    }

    public function asignar_permiso($usuario_id, $permisos_id) {
        $query = $this->conexion->prepare("INSERT INTO permisos_usuarios (usuario_id,permisos_id,activo)
        VALUES (:usuario_id,:permisos_id,1)");
        $query->execute(array(':usuario_id' => $usuario_id,
            ':permisos_id' => $permisos_id));
    }

    public function actualizar_estado($estado_id, $usuario_id) {
        $query = $this->conexion->prepare("UPDATE permisos_usuarios SET activo=:estado_id WHERE usuario_id= :usuario_id");
        $query->execute(array(':estado_id' => $estado_id,
            ':usuario_id' => $usuario_id));
    }

    public function actualizar_estado_digiturno($estado_id_digiturno, $usuario_id_digiturno) {
        $query = $this->conexion->prepare("UPDATE usuario SET permisos_digiturno=:estado_id_digiturno WHERE id= :usuario_id_digiturno");
        $query->execute(array(':estado_id_digiturno' => $estado_id_digiturno,
            ':usuario_id_digiturno' => $usuario_id_digiturno));
    }

    public function ValidaExisteUsuario($documento, $nom_usuario) {
        $query = $this->conexion->prepare("SELECT id FROM usuario WHERE documento=:documento OR nombre_usuario=:nombre_usuario");
        $query->execute(array(":documento" => $documento, ":nombre_usuario" => $nom_usuario));
        $rows = $query->fetchAll(PDO::FETCH_ASSOC);
        $retorno = 0;

        if (empty($rows)) {
            $retorno = 0;
        } else {
            $retorno = 1;
        }
        return $retorno;
    }

    public function cantidad_turnos_atendidos($id) {
        $query = $this->conexion->prepare(" SELECT COUNT(*) FROM gestion_turno WHERE usuario_id = :id ");
        $query->execute(array(":id" => $id));
        $rows = $query->fetchAll(PDO::FETCH_ASSOC);

        if (empty($rows)) {
            $cantidad_turnos = 0;
        } else {
            foreach ($rows as $valor) {
                $cantidad_turnos = $valor["COUNT(*)"];
            }
        }
        return $cantidad_turnos;
    }

    public function usuario_digiturno() {
        $query = $this->conexion->prepare("SELECT b.documento,b.nombre_completo from permisos_usuarios as a LEFT JOIN usuario as b on b.id = a.usuario_id WHERE permisos_id = '6'");
        $query->execute();
        $rows = $query->fetchAll(PDO::FETCH_ASSOC);
        foreach ($rows as $valor) {
            $opciones[] = array('documento' => $valor["documento"],
                'nombre_completo' => $valor["nombre_completo"]);
        }
        return json_encode($opciones);
    }

public function nombre_completo($id) {
        $query = $this->conexion->prepare("SELECT nombre_completo FROM usuario WHERE id = :id");
        $query->execute(array(":id" => $id));
        $rows = $query->fetchAll(PDO::FETCH_ASSOC);

        if (empty($rows)) {
            $nombre_completo = 'No tiene nombre';
        } else {
            foreach ($rows as $valor) {
                $nombre_completo = $valor["nombre_completo"];
            }
        }
        return $nombre_completo;
    }

     public function cantidad_turnos_modulo1($id,$modulo1) {
        $query = $this->conexion->prepare("SELECT COUNT(*) FROM gestion_turno WHERE usuario_id = :id and modulo = :modulo1 and llamado = '1' ");
        $query->execute(array(":id" => $id,":modulo1" => $modulo1));
        $rows = $query->fetchAll(PDO::FETCH_ASSOC);

        if (empty($rows)) {
            $cant_modulo1 = 0;
        } else {
            foreach ($rows as $valor) {
               $cant_modulo1 = $valor["COUNT(*)"];
            }
        }
        return $cant_modulo1;
    }
     public function cantidad_turnos_modulo2($id,$modulo2) {
        $query = $this->conexion->prepare("SELECT COUNT(*) FROM gestion_turno WHERE usuario_id = :id and modulo = :modulo2 and llamado = '1' ");
        $query->execute(array(":id" => $id,":modulo2" => $modulo2));
        $rows = $query->fetchAll(PDO::FETCH_ASSOC);

        if (empty($rows)) {
            $cant_modulo2 = 0;
        } else {
            foreach ($rows as $valor) {
               $cant_modulo2 = $valor["COUNT(*)"];
            }
        }
        return $cant_modulo2;
    }
    public function cantidad_turnos_modulo3($id,$modulo3) {
        $query = $this->conexion->prepare("SELECT COUNT(*) FROM gestion_turno WHERE usuario_id = :id and modulo = :modulo3 and llamado = '1' ");
        $query->execute(array(":id" => $id,":modulo3" => $modulo3));
        $rows = $query->fetchAll(PDO::FETCH_ASSOC);

        if (empty($rows)) {
            $cant_modulo3 = 0;
        } else {
            foreach ($rows as $valor) {
               $cant_modulo3 = $valor["COUNT(*)"];
            }
        }
        return $cant_modulo3;
    }
    public function cantidad_turnos_modulo4($id,$modulo4) {
        $query = $this->conexion->prepare("SELECT COUNT(*) FROM gestion_turno WHERE usuario_id = :id and modulo = :modulo4 and llamado = '1' ");
        $query->execute(array(":id" => $id,":modulo4" => $modulo4));
        $rows = $query->fetchAll(PDO::FETCH_ASSOC);

        if (empty($rows)) {
            $cant_modulo4 = 0;
        } else {
            foreach ($rows as $valor) {
               $cant_modulo4 = $valor["COUNT(*)"];
            }
        }
        return $cant_modulo4;
    }

      public function cantidad_cotizaciones() {
        $query = $this->conexion->prepare("SELECT COUNT(*) FROM cotizacion");
        $query->execute();
        $rows = $query->fetchAll(PDO::FETCH_ASSOC);

        if (empty($rows)) {
            $cantidad = 0;
        } else {
            foreach ($rows as $valor) {
               $cantidad = $valor["COUNT(*)"];
            }
        }
        return $cantidad;
    }


public function filtro_cotizacion() {
        $query = $this->conexion->prepare("SELECT * FROM cotizacion WHERE fecha_cotizacion like '% 2018-12-12 %' ");
        $query->execute();
        $rows = $query->fetchAll(PDO::FETCH_ASSOC);

        return $rows;
    }

}
