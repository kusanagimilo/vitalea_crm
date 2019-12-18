<?php 
/**
 * Description of Gestion
 *
 * @author Paola Cotrina
 */
require_once '../conexion/conexion_bd.php';

class Seguimiento {
    public $conexion;
    
    function __construct() {
        $this->conexion = new Conexion();
    }

     public function lista_usuarios($permiso){
        $query = $this->conexion->prepare("SELECT 
                usuario_id,
                (SELECT nombre_completo from usuario where id = usuario_id) as nombre
                FROM `permisos_usuarios` WHERE permisos_id = :permiso and activo = 1");

        $query->execute(array(':permiso'=>$permiso));

        $rows = $query->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
     }

     public function listar_tipificaciones(){
      $query = $this->conexion->prepare("SELECT t.id, 
          (SELECT nombre from tipificacion where id = t.grupo) as macro_proceso, 
          lower(t.nombre) as nombre
          from tipificacion as t 
          where t.grupo is not null AND activo = 1");
      $query->execute();

        $rows = $query->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
     }

     public function resultado_filtro($where){
        $query = $this->conexion->prepare("SELECT
                                    g.cliente_id,
                                    g.fecha_ingreso,
                                    g.usuario_id,
                                    c.documento,
                                    concat(c.nombre,' ',c.apellido) as nombre,
                                    c.telefono_1,
                                    concat((SELECT nombre from tipificacion where id = t.grupo),' - ',t.nombre) as causal,
                                    g.id

                                    FROM gestion as g
                                    INNER JOIN cliente as c on c.id_cliente = g.cliente_id
                                    LEFT JOIN tipificacion as t on t.id = g.tipificacion_id
                                    WHERE NOT EXISTS (select cliente_id from seguimiento where cliente_id = g.cliente_id ) $where 
                                    GROUP by c.id_cliente");
        $query->execute();

        $rows = $query->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
     }

     public function ingresar_seguimiento($usuario_id,$cliente_id){
      $query = $this->conexion->prepare("INSERT INTO seguimiento(usuario_id, cliente_id, estado, fecha_asignacion ,activo) VALUES (:usuario_id, :cliente_id, 1, NOW() ,1)");
       $query->execute(array(':usuario_id'=>$usuario_id,
                              ':cliente_id'=>$cliente_id
                          ));
     }

     public function consultar_seguimiento($usuario_id){
      $query= $this->conexion->prepare("SELECT
                            c.id_cliente,
                            c.documento,
                            concat(c.nombre, c.apellido) as nombre,
                            c.telefono_1, c.telefono_2,
                            c.email,
                            c.tipo_cliente,
                            (SELECT descripcion FROM cliente_estado WHERE cliente_estado_id=  c.cliente_estado) as estado,
                            s.fecha_asignacion
                            FROM seguimiento as s
                            INNER JOIN cliente as c on (c.id_cliente = s.cliente_id)
                            WHERE s.usuario_id = :usuario_id and s.activo = 1 and s.estado= 1");
      $query->execute(array(':usuario_id'=>$usuario_id));
       $rows = $query->fetchAll(PDO::FETCH_ASSOC);
        return $rows;

     }

     public function listar_seguimientos_programados($usuario_id){
      $query = $this->conexion->prepare("SELECT 
                          c.documento,
                          CONCAT(c.nombre,' ',c.apellido) as nombre_paciente,
                          CONCAT(c.telefono_1,' - ',c.telefono_2) as telefonos,
                          c.email,
                          p.fecha_programada,
                          p.hora_programada,
                          p.usuario_id,
                          p.activo,
                          c.id_cliente,
                          p.id
                          FROM programacion as p
                          INNER JOIN cliente as c on p.cliente_id = c.id_cliente
                          WHERE p.usuario_id = :usuario_id");
      $query->execute(array(':usuario_id'=>$usuario_id));

      $rows = $query->fetchAll();
        return $rows;
     }


     public function listar_seguimientos_programados_usuario_estado($usuario_id,$fecha_programada,$estado){
      $query = $this->conexion->prepare("SELECT 
                    c.documento,
                    CONCAT(c.nombre,' ',c.apellido) as nombre_paciente,
                    CONCAT(c.telefono_1,' - ',c.telefono_2) as telefonos,
                    c.email,
                    p.fecha_programada,
                    p.hora_programada,
                    p.usuario_id,
                    p.activo,
                    c.id_cliente,
                    p.id
                    FROM programacion as p
                    INNER JOIN cliente as c on p.cliente_id = c.id_cliente
                    WHERE p.usuario_id =:usuario_id and DATE(p.fecha_programada) = :fecha_programada and p.activo= :estado");
      $query->execute(array(':usuario_id'=>$usuario_id,
                            ':fecha_programada'=>$fecha_programada,
                            ':estado'=>$estado
                    ));

      $rows = $query->fetchAll();
        return $rows;
     }



     public function listar_seguimientos_programados_calendario($usuario_id){
      $query = $this->conexion->prepare("SELECT 
                          c.documento,
                          CONCAT(c.nombre,' ',c.apellido) as nombre_paciente,
                          CONCAT(c.telefono_1,' - ',c.telefono_2) as telefonos,
                          c.email,
                          p.fecha_programada,
                          p.hora_programada,
                          p.usuario_id,
                          p.activo,
                          c.id_cliente,
                          p.id
                          FROM programacion as p
                          INNER JOIN cliente as c on p.cliente_id = c.id_cliente
                          WHERE p.usuario_id = :usuario_id and p.activo=1
                          limit 3");
      $query->execute(array(':usuario_id'=>$usuario_id));

      $rows = $query->fetchAll();
        return $rows;
     }

     public function calendario_admin(){
       $query = $this->conexion->prepare(" SELECT 
                        count(*) as conteo,
                       (select nombre_completo from usuario where id=  p.usuario_id) as usuario_id,
                        p.fecha_programada,
                        p.activo
                        FROM programacion as p
                        where p.activo <> 0
                        group by  p.fecha_programada, p.usuario_id,p.activo");
      $query->execute();
      $rows = $query->fetchAll();
        return $rows;

     }

     public function listar_seguimientos_programados_calendario_admin(){
      $query = $this->conexion->prepare("SELECT 
                    count(*) as conteo,
                    p.usuario_id,
                   (select nombre_completo from usuario where id=  p.usuario_id) as nombre,
                    p.fecha_programada,
                    p.activo
                    FROM programacion as p
                    group by  p.fecha_programada, p.usuario_id,p.activo");
      $query->execute();

      $rows = $query->fetchAll();
        return $rows;
     }
     public function ingresar_programacion_llamada($cliente_id,$usuario_id,$fecha_programada,$hora_programada){
      $query = $this->conexion->prepare("INSERT INTO programacion(cliente_id, usuario_id,fecha_programada,hora_programada,fecha_programacion,activo) VALUES (:cliente_id,:usuario_id,:fecha_programada,:hora_programada,NOW(),1) ");
      $query->execute(array(':cliente_id'=>$cliente_id,
                            ':usuario_id'=>$usuario_id,
                            ':fecha_programada'=>$fecha_programada,
                            ':hora_programada'=>$hora_programada
                      ));
     }

     public function cerrar_programacion_llamada($programacion_id){
        $query = $this->conexion->prepare("UPDATE programacion SET activo=0, fecha_callback=NOW() WHERE id= :programacion_id");
        $query->execute(array(':programacion_id'=>$programacion_id));
     }



    


}
?>