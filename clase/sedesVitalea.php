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
}