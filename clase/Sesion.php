<?php

require_once '../conexion/conexion_bd.php';
class Sesion {
    
    public $conexion;
    
    function __construct() {
        $this->conexion = new Conexion();
    }
    
    public function inicio_sesion($nombre_usuario,$clave){
        $query = $this->conexion->prepare("SELECT u.id,u.nombre_completo,u.activo,p.permisos_id,u.nombre_usuario
            FROM usuario as u
            INNER JOIN permisos_usuarios as p on u.id = p.usuario_id
            WHERE u.nombre_usuario= :nombre_usuario and u.clave =SHA(:clave);");
        $query->execute(array(':nombre_usuario'=>$nombre_usuario,':clave'=>$clave));

        $rows = $query->fetchAll(PDO::FETCH_ASSOC);
        
        
        if(!empty($rows)){
            foreach($rows as $datos_usuario){
               $activo          = $datos_usuario["activo"]; 
               $permisos_id     = $datos_usuario["permisos_id"]; 
               $id_usuario      = $datos_usuario["id"];
               $nombre_usuario  = $datos_usuario["nombre_completo"];
               $username = $datos_usuario["nombre_usuario"];
            }
        }else{
            $activo         = 3;
            $permisos_id    = 0;
            $id_usuario     = 0;
            $nombre_usuario = '';
         }
        
        return array($activo,$permisos_id,$id_usuario,$nombre_usuario,$username);
                       
    }
    
    public function log_usuario($usuario_id,$proceso){
        $query = $this->conexion->prepare("INSERT INTO log_usuario(usuario_id, fecha_inicio, proceso) VALUES(:usuario_id, NOW(), :proceso) ");
        $query->execute(array(':usuario_id'=>$usuario_id,':proceso'=>$proceso));
    
    }

    public function ingreso_log_usuario($usuario_id,$fecha_inicio,$fecha_fin,$proceso,$tiempo){
        $query = $this->conexion->prepare("INSERT INTO log_usuario(usuario_id, fecha_inicio,fecha_fin, proceso,tiempo) VALUES(:usuario_id, :fecha_inicio,:fecha_fin, :proceso,:tiempo) ");
        $query->execute(array(':usuario_id'=>$usuario_id,
                            ':fecha_inicio'=>$fecha_inicio,
                            ':fecha_fin'=>$fecha_fin,
                            ':proceso'=>$proceso,
                            ':tiempo'=>$tiempo));
    }

    public function registro_procesos(){
        $query = $this->conexion->prepare("SELECT 
            l.usuario_id,
            (SELECT nombre_completo FROM usuario WHERE id = l.usuario_id) as nombre,
            (SELECT nombre FROM permisos where id = p.permisos_id) as perfil,
            proceso as proceso_id,
            (SELECT descripcion FROM procesos where id = proceso) as proceso,
            fecha_inicio,
            fecha_fin,
            timediff(time(fecha_inicio),time(fecha_fin)) as tiempo
            FROM log_usuario as l
            INNER JOIN permisos_usuarios as p on (p.usuario_id = l.usuario_id)
            WHERE proceso not in (1,8)");
        $query->execute();
        $rows = $query->fetchAll(PDO::FETCH_ASSOC);
        return $rows;

    }

    public function procesos(){
        $query = $this->conexion->prepare("SELECT id,descripcion FROM procesos WHERE id NOT IN (1,8)");
        $query->execute();
        $rows = $query->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
    }

    public function busqueda_registro_procesos($where){
        $query = $this->conexion->prepare("SELECT 
            l.usuario_id,
            (SELECT nombre_completo FROM usuario WHERE id = l.usuario_id) as nombre,
            (SELECT nombre FROM permisos where id = p.permisos_id) as perfil,
            proceso as proceso_id,
            (SELECT descripcion FROM procesos where id = proceso) as proceso,
            fecha_inicio,
            fecha_fin,
            timediff(time(fecha_inicio),time(fecha_fin)) as tiempo
            FROM log_usuario as l
            INNER JOIN permisos_usuarios as p on (p.usuario_id = l.usuario_id)
            WHERE proceso not in (1,8) $where");
        $query->execute();
        $rows = $query->fetchAll(PDO::FETCH_ASSOC);
        return $rows;

    }

    public function ingreso_log_usuario_temp($fecha_inicial,$usuario_id,$proceso_id){
        $query = $this->conexion->prepare("INSERT INTO log_usuario_temp (fecha_inicial,usuario_id,proceso_id) VALUES (:fecha_inicial,:usuario_id,:proceso_id)");
        $query->execute(array(':fecha_inicial'=>$fecha_inicial,
                            ':usuario_id'=>$usuario_id,
                            ':proceso_id'=>$proceso_id));
    }

    public function lista_log_usuario_temp(){
        $query = $this->conexion->prepare("SELECT
        l.id, 
            l.usuario_id,
            (SELECT nombre_completo FROM usuario WHERE id = l.usuario_id) as nombre,
            (SELECT nombre FROM permisos where id = p.permisos_id) as perfil,
            proceso_id,
            (SELECT descripcion FROM procesos where id = proceso_id) as proceso,
            fecha_inicial,
            DATE(fecha_inicial) as fecha_inicio_proceso,
            hour(fecha_inicial) as hora,
            minute(fecha_inicial) as minuto,
            second(fecha_inicial) as segundo
            FROM log_usuario_temp as l
            INNER JOIN permisos_usuarios as p on (p.usuario_id = l.usuario_id)
            WHERE proceso_id not in (1,8);");
        $query->execute();

        $rows = $query->fetchAll(PDO::FETCH_ASSOC);
        
        if(empty($rows)){
            $opciones[] = array('id'=> 0);
        }else{
            foreach ($rows as $valor){
                   $opciones[] = array('id'=> $valor["id"],
                                       'usuario_id'=> $valor["usuario_id"],
                                       'nombre'=> $valor["nombre"],
                                       'perfil'=> $valor["perfil"],
                                       'proceso'=> $valor["proceso"],
                                       'fecha_inicial'=> $valor["fecha_inicial"],
                                       'fecha_inicio_proceso'=> $valor["fecha_inicio_proceso"],
                                       'hora'=> $valor["hora"],
                                       'minuto'=> $valor["minuto"],
                                       'segundo'=> $valor["segundo"]
                                        );
            }
        }    
        return json_encode($opciones);
    }


    
 
    
}
