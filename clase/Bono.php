<?php

/**
 * Description of Gestion
 *
 * @author Paola Cotrina
 */
require_once '../conexion/conexion_bd.php';

class Bono {

    public $conexion;

    function __construct() {
        $this->conexion = new Conexion();
    }

    public function ingresar_bono($codigo_bono, $cliente_id, $fecha_inicio, $fecha_final, $cantidad_descuento) {
        $query = $this->conexion->prepare("INSERT INTO bono(codigo_bono,cliente_id,activo,fecha_asignacion,fecha_inicio,fecha_final,cantidad_descuento) VALUES (:codigo_bono,:cliente_id,1,NOW(),:fecha_inicio,:fecha_final,:cantidad_descuento) ");

        $query->execute(array(':codigo_bono' => $codigo_bono,
            ':cliente_id' => $cliente_id,
            ':fecha_inicio' => $fecha_inicio,
            ':fecha_final' => $fecha_final,
            ':cantidad_descuento' => $cantidad_descuento
        ));
    }

    public function existe_bono($codigo_bono) {
        $query = $this->conexion->prepare("SELECT COUNT(*) as conteo FROM bono WHERE codigo_bono= :codigo_bono");

        $query->execute(array(':codigo_bono' => $codigo_bono));

        $rows = $query->fetchAll();
        foreach ($rows as $valor) {
            $conteo = $valor["conteo"];
        }
        return $conteo;
    }

    public function lista_bonos_asignados() {
        $query = $this->conexion->prepare("SELECT bn.id,codigo_bono,bn.cliente_id,bn.fecha_inicio,
bn.fecha_final,bn.fecha_asignacion,bn.fecha_redencion,bn.estado,cantidad_descuento,
cli.documento,cli.nombre,cli.apellido
FROM bono bn 
INNER JOIN cliente cli ON cli.id_cliente = bn.cliente_id");
        $query->execute();
        $rows = $query->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
    }

    public function lista_bonos_redimidos() {
        $query = $this->conexion->prepare("SELECT b.cliente_id, (SELECT documento FROM cliente where id_cliente = b.cliente_id ) as cliente, b.url, b.codigo_bono, b.fecha_redencion, if(activo=1,'Activo','Inactivo') as activo ,b.fecha_inicio,b.fecha_final FROM bono as b
      where activo = 0 ");
        $query->execute();
        $rows = $query->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
    }

    public function BonosPersona($data) {

        $fecha_actual = date("Y-m-d");

        $query = $this->conexion->prepare("SELECT id,codigo_bono,cliente_id,fecha_inicio,fecha_final,activo,cantidad_descuento
                                           FROM bono WHERE cliente_id=:cliente_id AND estado=:activo
                                           AND fecha_inicio <=:fecha_actual");
        $query->execute(array(':cliente_id' => $data['cliente_id'],
            ':activo' => 1,
            ':fecha_actual' => $fecha_actual));

        $rows = $query->fetchAll(PDO::FETCH_ASSOC);
        if (empty($rows)) {
            return json_encode("sin_bonos");
        } else {
            return json_encode($rows);
        }
    }

}

?>