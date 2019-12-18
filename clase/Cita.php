<?php 
/**
 * Description of Gestion
 *
 * @author Paola Cotrina
 */
require_once '../conexion/conexion_bd.php';

class Cita {
    public $conexion;
    
    function __construct() {
        $this->conexion = new Conexion();
    }

     public function consultar_cita_temp($cliente_id,$gestion_id){
        $query = $this->conexion->prepare("SELECT c.id,c.examen_id,e.precio FROM cita_temp AS c
                  INNER JOIN examen AS e ON c.examen_id = e.id
                  WHERE c.cliente_id  = :cliente_id and c.gestion_id = :gestion_id ");
        $query->execute(array(':cliente_id'=>$cliente_id,
                              ':gestion_id'=>$gestion_id));
        $rows = $query->fetchAll(PDO::FETCH_ASSOC);

        return $rows;
     }

     public function ingresar_agenda_item($cliente_id,$gestion_id,$laboratorio_id,$fecha_cita,$hora_cita,$usuario_id){
        $query = $this->conexion->prepare("INSERT INTO agenda (cliente_id,gestion_id,laboratorio_id,fecha_cita,hora_cita,usuario_id,fecha_asignacion,activo)
          VALUES (:cliente_id,:gestion_id,:laboratorio_id,:fecha_cita,:hora_cita,:usuario_id,NOW(),1)");
        $query->execute(array(':cliente_id'=>$cliente_id,
                              ':gestion_id'=>$gestion_id,
                              ':laboratorio_id'=>$laboratorio_id,
                              ':fecha_cita'=>$fecha_cita,
                              ':hora_cita'=>$hora_cita,
                              ':usuario_id'=>$usuario_id
                            ));
        $cita_id = $this->conexion->lastInsertId();

        $items_cita = $this->consultar_cita_temp($cliente_id,$gestion_id);

          foreach ($items_cita as $datos_cita) {
              $this->ingresar_items_cita($datos_cita["examen_id"],$datos_cita["precio"],$gestion_id,$cita_id);
          }

          $this->eliminar_cita_temp($cliente_id,$gestion_id);

     }

    public function ingresar_items_cita($examen_id,$valor,$gestion_id,$cita_id){
          $query  = $this->conexion->prepare("INSERT INTO agenda_items (examen_id,valor,gestion_id,agenda_id) VALUES (:examen_id,:valor,:gestion_id,:agenda_id)");
          $query->execute(array(':examen_id'=>$examen_id,
                                ':valor'=>$valor,
                                ':gestion_id'=>$gestion_id,
                                ':agenda_id'=>$cita_id));
    }

    public function eliminar_cita_temp($cliente_id,$gestion_id){
        $query = $this->conexion->prepare("DELETE FROM cita_temp where cliente_id =:cliente_id and gestion_id=:gestion_id");
        $query->execute(array(':cliente_id'=>$cliente_id,
                              ':gestion_id'=>$gestion_id));
    }


}
?>