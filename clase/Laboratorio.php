<?php

require_once '../conexion/conexion_bd.php';

class Laboratorio {

    public $conexion;

    function __construct() {
        $this->conexion = new Conexion();
    }

    public function listar_laboratorio() {
        $query = $this->conexion->prepare("SELECT id,codigo,codigo_cups,nombre,precio, if(activo = 1,'Activo','Inactivo') as activo FROM examen");
        $query->execute();
        $rows = $query->fetchAll();
        return $rows;
    }

    public function listar_tipificacion() {
        $query = $this->conexion->prepare("select
            case grupo  
            when 1 then 'Informacion'  
            when 2 then 'Informacion General'  
            when 4 then 'Cotizacion'  
            when 6 then 'Soporte'
            when 7 then 'Soporte de Página'
            when 25 then 'Llamada Ociosa'
            when 28 then 'Quejas'
            when 36 then 'Reclamos'
            when 37 then 'Pago de Recarga No Visualizado'
            when 40 then 'Pago Mal Liquidado'
            when 44 then 'Pagos'
            when 50 then 'Problemas de Saldo'
            when 53 then  'Soliticud'
            when 54 then 'Facturacion'
            when 58 then 'Presencial'
            when 60 then 'Virtual'
            end as grupo,
            nombre
            from tipificacion
            where grupo is not null");
        
        $query->execute();
        $rows = $query->fetchAll();
        return $rows;
    }

    public function listarExamenes(){
        $query = $this->conexion->prepare("SELECT
            (select nombre FROM examen where id= e.grupo_id ) as 'categoria',
            e.nombre,
            e.precio,
            e.precio_menos_cinco,
            e.precio_menos_diez,
            e.precio_menos_quince
            FROM examen as e
            WHERE activo = 1 AND e.precio is not null");
        $query->execute();
        $rows = $query->fetchAll();
        return $rows;
    }

}
