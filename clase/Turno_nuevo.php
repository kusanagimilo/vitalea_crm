<?php
/**
 * Descripción de Turno
 *
 * @author Federico Marin
 */
require_once '../conexion/conexion_bd.php';

class Turno_nuevo {
    public $conexion;
    
    function __construct() {
        $this->conexion = new Conexion();
    }

   	public function buscar_registro_1(){
        $query = $this->conexion->prepare("SELECT turno FROM gestion_turno WHERE tipo_turno='1' ORDER BY id_gestion_turno DESC LIMIT 1");
        $query->execute();

        $registro = 0;

        if(empty($query)){
          $registro = 0;
        }else {
          foreach ($query as $datos){
            $registro = $datos["turno"];
          }
        }
        return $registro;
        
    }

    public function buscar_registro_2(){
        $query = $this->conexion->prepare("SELECT turno FROM gestion_turno WHERE tipo_turno='2' ORDER BY id_gestion_turno DESC LIMIT 1");
        $query->execute();

        $registro = 0;

        if(empty($query)){
          $registro = 0;
        }else{
          foreach ($query as $datos){
            $registro = $datos["turno"];
          }
        }

        return $registro;
    }

    public function insert_gestion_en_cero($cliente_id,$usuario_id,$numero_turno,$tipo_turno){
  		$query = $this->conexion->prepare("INSERT INTO gestion_turno(cliente_id, usuario_id, turno,tipo_turno, fecha_registro, llamado,modulo) VALUES (:cliente_id,:usuario_id,:numero_turno,:tipo_turno,NOW(),'0','0')");
  		$query->execute(array(':cliente_id'=>$cliente_id,
                               ':usuario_id'=>$usuario_id,
                               ':numero_turno'=>$numero_turno,
                               ':tipo_turno'=>$tipo_turno
            				 ));

}



    public function ingresar_gestion($cliente_id,$usuario_id,$numero_turno,$tipo_turno){

        $query = $this->conexion->prepare("INSERT INTO gestion_turno(cliente_id,usuario_id,turno,tipo_turno,fecha_registro,llamado,modulo)VALUES(:cliente_id,:usuario_id,:numero_turno,:tipo_turno,NOW(),'0','0')");
         $query->execute(array(':cliente_id'=>$cliente_id,
                                ':usuario_id'=>$usuario_id,
                                ':numero_turno'=>$numero_turno,
                                ':tipo_turno'=>$tipo_turno
                                ));
    }

}
?>