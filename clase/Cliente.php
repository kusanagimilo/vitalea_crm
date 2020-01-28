<?php

require_once '../conexion/conexion_bd.php';

class Cliente {

    public $conexion;

    function __construct() {
        $this->conexion = new Conexion();
    }

    public function consultar_tipo_documento() {
        $query = $this->conexion->prepare("SELECT * FROM tipo_documento WHERE activo=1 ");
        $query->execute();
        $rows = $query->fetchAll();
        foreach ($rows as $valor) {
            $opciones[] = array('id' => $valor["id"], 'nombre' => $valor["nombre"]);
        }
        return json_encode($opciones);
    }

    public function consultar_estado_civil() {
        $query = $this->conexion->prepare("SELECT id,nombre FROM estado_civil WHERE activo=1 ");
        $query->execute();
        $rows = $query->fetchAll();
        foreach ($rows as $valor) {
            $opciones[] = array('id' => $valor["id"], 'nombre' => $valor["nombre"]);
        }
        return json_encode($opciones);
    }

    public function barriosListados() {
        $query = $this->conexion->prepare("SELECT * FROM crm_preatencion_prod.barrios_bogota");
        $query->execute();
        $rows = $query->fetchAll();
        foreach ($rows as $valor) {
            $opciones[] = array('id' => $valor["id"], 'nombre' => $valor["nombre"]);
        }
        return json_encode($opciones);
    }

    public function consultar_departamento() {
        $query = $this->conexion->prepare(" SELECT id,nombre FROM departamento WHERE activo=1  order by nombre desc");
        $query->execute();
        $rows = $query->fetchAll();
        foreach ($rows as $valor) {
            $opciones[] = array('id' => $valor["id"], 'nombre' => $valor["nombre"]);
        }
        return json_encode($opciones);
    }

    public function consultar_ciudad($departamento_id) {
        $query = $this->conexion->prepare("SELECT id,nombre FROM ciudad where departamento_id = :departamento_id and activo=1 ");
        $query->execute(array(':departamento_id' => $departamento_id));

        $rows = $query->fetchAll(PDO::FETCH_ASSOC);
        foreach ($rows as $valor) {
            $opciones[] = array('id' => $valor["id"], 'nombre' => $valor["nombre"]);
        }
        return json_encode($opciones);
    }

    public function consultar_macro_tipificacion() {
        $query = $this->conexion->prepare("select id,nombre from tipificacion where grupo = 1 and activo= 1 order by nombre asc");
        $query->execute();
        $rows = $query->fetchAll();
        foreach ($rows as $valor) {
            $opciones[] = array('id' => $valor["id"], 'nombre' => $valor["nombre"]);
        }
        return json_encode($opciones);
    }

    //cliente_turno
    public function cliente_actual() {
        $query = $this->conexion->prepare("SELECT * FROM gestion_turno WHERE llamado=1 ORDER BY id_gestion_turno DESC LIMIT 0,1");
        $query->execute();

        if (empty($query)) {
            $cliente_id = 0;
        } else {
            foreach ($query as $datos) {
                $cliente_id = $datos["cliente_id"];
            }
        }
        return $cliente_id;
    }

    public function cliente_anterior() {
        $query = $this->conexion->prepare("SELECT * FROM gestion_turno WHERE llamado=1 ORDER BY id_gestion_turno DESC LIMIT 1,1");
        $query->execute();

        if (empty($query)) {
            $cliente_id = 0;
        } else {
            foreach ($query as $datos) {
                $cliente_id = $datos["cliente_id"];
            }
        }
        return $cliente_id;
    }

    public function cliente_anterior_2() {
        $query = $this->conexion->prepare("SELECT * FROM gestion_turno WHERE llamado=1 ORDER BY id_gestion_turno DESC LIMIT 2,1");
        $query->execute();

        if (empty($query)) {
            $cliente_id = 0;
        } else {
            foreach ($query as $datos) {
                $cliente_id = $datos["cliente_id"];
            }
        }
        return $cliente_id;
    }

    public function cliente_anterior_3() {
        $query = $this->conexion->prepare("SELECT * FROM gestion_turno WHERE llamado=1 ORDER BY id_gestion_turno DESC LIMIT 3,1");
        $query->execute();

        if (empty($query)) {
            $cliente_id = 0;
        } else {
            foreach ($query as $datos) {
                $cliente_id = $datos["cliente_id"];
            }
        }
        return $cliente_id;
    }

    //fin_cliente_turno

    public function consultar_tipificaciones($id_macro_proceso, $modulo) {
        $query = $this->conexion->prepare("select id,nombre from tipificacion where grupo = :id_macro_proceso and activo= 1  and modulo in ($modulo)order by nombre asc");
        $query->execute(array(':id_macro_proceso' => $id_macro_proceso));

        $rows = $query->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
    }

    public function direccion_seccion() {
        $query = $this->conexion->prepare("select abreviatura,nombre from direccion_seccion order by nombre asc");
        $query->execute();
        $rows = $query->fetchAll();
        foreach ($rows as $valor) {
            $opciones[] = array('id' => $valor["abreviatura"], 'nombre' => $valor["nombre"]);
        }
        return json_encode($opciones);
    }

    public function parentesco() {
        $query = $this->conexion->prepare("select  * FROM parentesco");
        $query->execute();
        $rows = $query->fetchAll();
        foreach ($rows as $valor) {
            $opciones[] = array('id' => $valor["id"], 'nombre' => $valor["nombre"]);
        }
        return json_encode($opciones);
    }

    public function listar_cliente() {
        $query = $this->conexion->prepare("SELECT c.id_cliente, t.nombre,c.documento, concat(c.nombre,' ',c.apellido) as 'nombre_completo',
            c.telefono_1,c.email,c.fecha_nacimiento,cd.nombre as ciudad,c.estrato, if(c.tipo_cliente IS NULL,'Titular','Titular') as tipo_cliente,(select nombre from clasificacion WHERE id = clasificacion) as clasificacion

            FROM cliente as c
            left join tipo_documento as t on t.id = c.tipo_documento
            left join ciudad as cd on cd.id = c.ciudad_id
            ");

        $query->execute();
        $rows = $query->fetchAll();
        return $rows;
    }

    public function nombre_paciente($cliente_id) {
        $query = $this->conexion->prepare("SELECT nombre FROM  cliente WHERE id_cliente= :cliente_id");
        $query->execute(array(':cliente_id' => $cliente_id));

        if (empty($query)) {
            $nombre = "";
        } else {
            foreach ($query as $valor) {
                $nombre = $valor["nombre"];
            }
        }

        return $nombre;
    }

    public function apellido_paciente($cliente_id) {
        $query = $this->conexion->prepare("SELECT apellido FROM  cliente WHERE id_cliente= :cliente_id");
        $query->execute(array(':cliente_id' => $cliente_id));

        if (empty($query)) {
            $apellido = "";
        } else {
            foreach ($query as $valor) {
                $apellido = $valor["apellido"];
            }
        }

        return $apellido;
    }

    public function documento_paciente($cliente_id) {
        $query = $this->conexion->prepare("SELECT documento FROM  cliente WHERE id_cliente= :cliente_id");
        $query->execute(array(':cliente_id' => $cliente_id));

        if (empty($query)) {
            $documento = "";
        } else {
            foreach ($query as $valor) {
                $documento = $valor["documento"];
            }
        }

        return $documento;
    }

    public function direccion_paciente($cliente_id) {
        $query = $this->conexion->prepare("SELECT direccion FROM  cliente WHERE id_cliente= :cliente_id");
        $query->execute(array(':cliente_id' => $cliente_id));

        if (empty($query)) {
            $direccion = "";
        } else {
            foreach ($query as $valor) {
                $direccion = $valor["direccion"];
            }
        }

        return $direccion;
    }

    public function telefono_paciente($cliente_id) {
        $query = $this->conexion->prepare("SELECT telefono_1 FROM  cliente WHERE id_cliente= :cliente_id");
        $query->execute(array(':cliente_id' => $cliente_id));

        if (empty($query)) {
            $telefono = "";
        } else {
            foreach ($query as $valor) {
                $telefono = $valor["telefono_1"];
            }
        }

        return $telefono;
    }

    public function ciudad_paciente($cliente_id) {
        $query = $this->conexion->prepare("
            SELECT C.nombre 
            FROM cliente AS CL 
            INNER JOIN ciudad AS C ON CL.ciudad_id=C.id 
            WHERE id_cliente=:cliente_id");

        $query->execute(array(':cliente_id' => $cliente_id));

        if (empty($query)) {
            $ciudad = "";
        } else {
            foreach ($query as $valor) {
                $ciudad = $valor["nombre"];
            }
        }
        return $ciudad;
    }

    public function correo_paciente($cliente_id) {
        $query = $this->conexion->prepare("SELECT email FROM  cliente WHERE id_cliente= :cliente_id");
        $query->execute(array(':cliente_id' => $cliente_id));
        $rows = $query->fetchAll();

        if (empty($rows)) {
            $email = "";
        } else {
            foreach ($rows as $valor) {
                $email = $valor["email"];
            }
        }

        return $email;
    }

    public function correos_paciente($cliente_id) {
        $query = $this->conexion->prepare("SELECT email FROM  cliente WHERE id_cliente in ($cliente_id)");
        $query->execute();
        $rows = $query->fetchAll();

        return $rows;
    }

    public function consultar_paciente($cliente_id) {
        $query = $this->conexion->prepare("SELECT
                        CONCAT(c.nombre,' ',c.apellido) as nombre,
                        (SELECT nombre FROM tipo_documento where id = c.tipo_documento) as tipo_documento,
                        c.documento,
                        c.telefono_1,
                        c.email,
                        c.barrio,
                        (SELECT nombre from ciudad where id = c.ciudad_id) as ciudad,
                        (SELECT descripcion from cliente_estado where cliente_estado_id = c.cliente_estado) as estado_cliente,
                        c.direccion,
                        c.estrato,
                        c.fecha_nacimiento,
                        c.sexo,
                        c.telefono_2,
                        c.tipo_cliente
                        FROM cliente AS c
                        WHERE c.id_cliente = :cliente_id ");
        $query->execute(array(':cliente_id' => $cliente_id));

        $rows = $query->fetchAll(PDO::FETCH_ASSOC);

        return $rows;
    }

    public function consultar_tercero_titular($id_titular) {
        $query = $this->conexion->prepare("SELECT 
                                        t.id_tercero,
                                        t.id_titular,
                                        t.tipo_documento as tipo_documento_id,
                                        (SELECT nombre FROM tipo_documento where id = t.tipo_documento) as tipo_documento,
                                        t.documento,
                                        t.nombre,
                                        t.apellido,
                                        t.fecha_nacimiento,
                                        t.sexo,
                                        t.parentesco as parentesco_id,
                                        (SELECT nombre FROM parentesco WHERE id = t.parentesco) as parentesco
                                        FROM terceros as t
                                        WHERE t.id_titular =:id_titular ");

        $query->execute(array(':id_titular' => $id_titular));

        $rows = $query->fetchAll();
        return $rows;
    }

    public function consultar_tercero($id_tercero) {
        $query = $this->conexion->prepare("SELECT 
                                        t.id_tercero,
                                        t.id_titular,
                                        t.tipo_documento as tipo_documento_id,
                                        (SELECT nombre FROM tipo_documento where id = t.tipo_documento) as tipo_documento,
                                        t.documento,
                                        t.nombre,
                                        t.apellido,
                                        t.fecha_nacimiento,
                                        t.sexo,
                                        t.parentesco as parentesco_id,
                                        (SELECT nombre FROM parentesco WHERE id = t.parentesco) as parentesco
                                        FROM terceros as t
                                        WHERE t.id_tercero =:id_tercero ");

        $query->execute(array(':id_tercero' => $id_tercero));

        $rows = $query->fetchAll();
        return $rows;
    }

    public function actualizar_cliente($tipo_documento, $documento, $nombre, $apellido, $telefono_1, $telefono_2, $email, $fecha_nacimiento, $ciudad_id, $barrio, $direccion, $estado_civil_id, $sexo, $estrato, $id_cliente) {
        $query = $this->conexion->prepare("UPDATE cliente 
            SET tipo_documento=:tipo_documento,
                documento=:documento,
                nombre=:nombre,
                apellido= :apellido,
                telefono_1= :telefono_1,
                telefono_2= :telefono_2,
                email=:email,
                fecha_nacimiento= :fecha_nacimiento,
                ciudad_id= :ciudad_id,
                barrio= :barrio,
                direccion=:direccion,
                estado_civil_id= :estado_civil_id,
                sexo=:sexo,
                estrato= :estrato
                WHERE id_cliente=  :id_cliente");
        $query->execute(array(':tipo_documento' => $tipo_documento,
            ':documento' => $documento,
            ':nombre' => $nombre,
            ':apellido' => $apellido,
            ':telefono_1' => $telefono_1,
            ':telefono_2' => $telefono_2,
            ':email' => $email,
            ':fecha_nacimiento' => $fecha_nacimiento,
            ':ciudad_id' => $ciudad_id,
            ':barrio' => $barrio,
            ':direccion' => $direccion,
            ':estado_civil_id' => $estado_civil_id,
            ':sexo' => $sexo,
            ':estrato' => $estrato,
            ':id_cliente' => $id_cliente
        ));
    }

    public function actualizar_tercero($tipo_documento, $documento, $nombre, $apellido, $fecha_nacimiento, $sexo, $parentesco, $id_tercero) {
        $query = $this->conexion->prepare("UPDATE terceros 
            SET tipo_documento=:tipo_documento,
            documento=:documento,
            nombre=:nombre,
            apellido= :apellido,
            fecha_nacimiento= :fecha_nacimiento,
            sexo=:sexo,
            parentesco= :parentesco
             WHERE id_tercero =:id_tercero ");

        $query->execute(array(':tipo_documento' => $tipo_documento,
            ':documento' => $documento,
            ':nombre' => $nombre,
            ':apellido' => $apellido,
            ':fecha_nacimiento' => $fecha_nacimiento,
            ':sexo' => $sexo,
            ':parentesco' => $parentesco,
            ':id_tercero' => $id_tercero
        ));
    }

    public function obtener_tipo_cliente($cliente_id) {
        $query = $this->conexion->prepare("SELECT tipo_cliente FROM cliente where id_cliente= :cliente_id");
        $query->execute(array(':cliente_id' => $cliente_id));

        $rows = $query->fetchAll(PDO::FETCH_ASSOC);


        foreach ($rows as $valor) {
            $tipo_cliente = $valor["tipo_cliente"];
        }


        return $tipo_cliente;
    }

    public function actualizar_tipo_cliente($tipo_cliente, $cliente_id) {
        $query = $this->conexion->prepare("UPDATE cliente SET tipo_cliente = :tipo_cliente WHERE id_cliente = :cliente_id");
        $query->execute(array(':tipo_cliente' => $tipo_cliente,
            ':cliente_id' => $cliente_id));
    }

    public function crear_terceros_temp($tipo_documento, $documento, $nombre, $apellido, $fecha_nacimiento, $sexo, $parentesco, $documento_titular) {
        $query = $this->conexion->prepare("INSERT INTO terceros_temp (tipo_documento, documento, nombre, apellido, fecha_nacimiento, sexo, parentesco, documento_titular) VALUES (:tipo_documento, :documento, :nombre, :apellido, :fecha_nacimiento, :sexo, :parentesco, :documento_titular)");
        $query->execute(array(':tipo_documento' => $tipo_documento,
            ':documento' => $documento,
            ':nombre' => $nombre,
            ':apellido' => $apellido,
            ':fecha_nacimiento' => $fecha_nacimiento,
            ':sexo' => $sexo,
            ':parentesco' => $parentesco,
            ':documento_titular' => $documento_titular
        ));
    }

    public function consultar_documento_tercero($documento) {
        $query = $this->conexion->prepare("SELECT COUNT(*) as conteo FROM terceros WHERE documento = :documento");
        $query->execute(array(':documento' => $documento));

        $rows = $query->fetchAll(PDO::FETCH_ASSOC);
        foreach ($rows as $valor) {
            $conteo_tercero = $valor["conteo"];
        }

        $query = $this->conexion->prepare("SELECT COUNT(*) as conteo_temp FROM terceros_temp WHERE documento = :documento");
        $query->execute(array(':documento' => $documento));

        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result as $dato) {
            $conteo_tercero_temp = $dato["conteo_temp"];
        }

        if ($conteo_tercero == 0 && $conteo_tercero_temp == 0) {
            $rta = 1;
        } else {
            $rta = 0;
        }

        return $rta;
    }

    public function consultar_terceros_temp($documento_titular) {
        $query = $this->conexion->prepare("SELECT 
                                        t.id,
                                        t.documento_titular,
                                        t.tipo_documento as tipo_documento_id,
                                        (SELECT nombre FROM tipo_documento where id = t.tipo_documento) as tipo_documento,
                                        t.documento,
                                        t.nombre,
                                        t.apellido,
                                        t.fecha_nacimiento,
                                        t.sexo,
                                        t.parentesco as parentesco_id,
                                        (SELECT nombre FROM parentesco WHERE id = t.parentesco) as parentesco
                                        FROM terceros_temp as t
                                        WHERE t.documento_titular = :documento_titular ");
        $query->execute(array(':documento_titular' => $documento_titular));

        $rows = $query->fetchAll();
        return $rows;
    }

    public function eliminar_tercero_temp($tercero_id) {
        $query = $this->conexion->prepare("DELETE FROM terceros_temp WHERE id = :tercero_id");
        $query->execute(array(':tercero_id' => $tercero_id));
    }

    public function listar_calificacion() {
        $query = $this->conexion->prepare("SELECT id,nombre FROM clasificacion WHERE activo = 1");
        $query->execute();
        $rows = $query->fetchAll();
        foreach ($rows as $valor) {
            $opciones[] = array('id' => $valor["id"], 'nombre' => $valor["nombre"]);
        }
        return json_encode($opciones);
    }

    public function listar_cliente_por_clasificacion($clasificacion) {
        $query = $this->conexion->prepare("SELECT c.id_cliente, c.documento as 'nombre_completo'
                FROM cliente as c
                WHERE clasificacion = :clasificacion AND activo = 1 ");
        $query->execute(array(':clasificacion' => $clasificacion));
        $rows = $query->fetchAll();
        foreach ($rows as $valor) {
            $opciones[] = array('id_cliente' => $valor["id_cliente"], 'nombre_completo' => $valor["nombre_completo"]);
        }
        return json_encode($opciones);
    }

    public function listar_cliente_bon() {
        $query = $this->conexion->prepare("SELECT id_cliente,documento,nombre,apellido FROM cliente WHERE activo = 1");
        $query->execute();
        $rows = $query->fetchAll();
        foreach ($rows as $valor) {
            $opciones[] = array('id_cliente' => $valor["id_cliente"],
                'documento' => $valor["documento"],
                'nombre' => $valor["nombre"],
                'apellido' => $valor["apellido"]);
        }
        return json_encode($opciones);
    }

}
