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
    public function ingresarNuevaSede($nombre_sede,$ciudad,$direccion,$barrio,$telefono){
        $query= $this->conexion->prepare("INSERT INTO crm_preatencion.sedes_vitalea (nombre_sede,ciudad,direccion,barrio,telefono) VALUES (:nombre_sede,:ciudad,:direccion,:barrio,:telefono)");
  
         $query->execute(array(':nombre_sede'=>$nombre_sede,
                                ':ciudad'=>$ciudad,
                                ':direccion'=>$direccion,
                                ':barrio'=>$barrio,
                                ':telefono'=>$telefono
                            ));
      }
}