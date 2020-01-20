<?php

require_once '../conexion/conexion_bd.php';

class sedesVitalea {
    
    public $conexion;
    
    function __construct() {
        $this->conexion = new Conexion();
    }
    
    public function sedesVitaleaFuncion($data) {
        
        $query = $this->conexion->prepare("SELECT * FROM crm_preatencion.sedes_vitalea");
        $query->execute();

        $rows = $query->fetchAll(PDO::FETCH_ASSOC);

        return json_encode($rows);
    }

    // INGRESAR ITEM DE COTIZACION
    public function ingresarNuevaSede($examen_id,$cliente_id,$gestion_id,$descuento,$cotizacion_id,$valor,$tipo_examen){
        $query= $this->conexion->prepare("INSERT INTO crm_preatencion.sedes_vitalea (nombre_sede,ciudad,direccion,barrio,telefono) VALUES (:examen_id,:cliente_id,:gestion_id,:descuento,:cotizacion_id,:valor,:tipo_examen)");
  
         $query->execute(array(':examen_id'=>$examen_id,
                                ':cliente_id'=>$cliente_id,
                                ':gestion_id'=>$gestion_id,
                                ':descuento'=>$descuento,
                                ':cotizacion_id'=>$cotizacion_id,
                                ':valor'=>$valor,
                                ':tipo_examen'=>$tipo_examen
                            ));
      }
}