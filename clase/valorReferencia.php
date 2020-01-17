<?php

require_once '../conexion/conexion_bd.php';

class valorReferencia {
    
    public $conexion;
    
    function __construct() {
        $this->conexion = new Conexion();
    }
    
    public function verValoresReferencia($data) {
        
        $query = $this->conexion->prepare("SELECT vlf.*,exam.codigo,exam.nombre FROM valor_referencia vlf
        inner join examenes_no_perfiles_2 exam on exam.id = vlf.id_examen");
        $query->execute();

        $rows = $query->fetchAll(PDO::FETCH_ASSOC);

        return json_encode($rows);
    }
}