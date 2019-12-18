<?php

class Funciones {

    function generarCodigo($longitud) {


        $db = new db();
        $db = $db->conectar();

        $key = '';
        $pattern = '1234567890abcdefghijklmnopqrstuvwxyz';
        $max = strlen($pattern) - 1;
        for ($i = 0; $i < $longitud; $i++)
            $key .= $pattern{mt_rand(0, $max)};

        $query = $db->prepare("SELECT id FROM venta WHERE codigo_venta =:codigo_venta");
        $query->execute(array(':codigo_venta' => $key));
        $rows = $query->fetchAll();

        if (empty($rows)) {
            return $key;
        } else {
            generarCodigo($longitud);
        }
    }

    function RevisaIdPacienteAthenea($id_athenea, $id_paciente) {

        $db = new db();
        $db = $db->conectar();

        $query = $db->prepare("SELECT id_cliente FROM cliente WHERE id_cliente_athenea =:id_cliente_athenea");
        $query->execute(array(":id_cliente_athenea" => $id_athenea));
        $rows = $query->fetchAll(PDO::FETCH_ASSOC);

        if (empty($rows)) {
            $query_up = $db->prepare("UPDATE cliente SET id_cliente_athenea =:id_cliente_athenea WHERE id_cliente =:id_cliente");
            $query_up->execute(array(':id_cliente_athenea' => $id_athenea,
                ':id_cliente' => $id_paciente));

            if ($query) {
                return 1;
            } else {
                return 2;
            }
        } else {
            return 1;
        }
    }

    public function EntregaNumeroTurno($tipo_turno) {

        $anio = date("Y");
        $mes = date("m");
        $dia = date("d");

        $db = new db();
        $db = $db->conectar();

        $query = $db->prepare("SELECT max(numero_turno) as numero_turno
FROM turno
WHERE tipo_turno =:tipo_turno
AND YEAR(fecha_creacion) =:anio
AND MONTH(fecha_creacion) =:mes
AND DAY(fecha_creacion) =:dia");

        $query->execute(array(':tipo_turno' => $tipo_turno,
            ':anio' => $anio,
            ':mes' => $mes,
            ':dia' => $dia));

        $rows = $query->fetchAll(PDO::FETCH_ASSOC);


        if ($rows[0]['numero_turno'] == NULL) {
            return 0;
        } else {
            return $rows[0]['numero_turno'];
        }
    }

    public function ModuloUsuario($tipo_atencion) {

        $db = new db();
        $db = $db->conectar();

        $anio = date("Y");
        $mes = date("m");
        $dia = date("d");

        $query = $db->prepare("SELECT id_modulo_usuario,id_modulo,tipo_atencion FROM modulo_usuario 
                                           WHERE estado =:estado AND tipo_atencion =:tipo_atencion");
        $query->execute(array(':estado' => 'ACTIVO',
            ':tipo_atencion' => $tipo_atencion));

        $rows = $query->fetchAll(PDO::FETCH_ASSOC);

        $arreglo_modulos = array();

        foreach ($rows as $key => $value) {
            $query2 = $db->prepare("SELECT mdu.id_modulo_usuario,COUNT(mdu.id_modulo_usuario) AS conteo
FROM modulo_usuario mdu
INNER JOIN turno tur ON tur.id_modulo_usuario = mdu.id_modulo_usuario
WHERE mdu.id_modulo_usuario =:id_modulo_usuario
AND YEAR(tur.fecha_creacion) =:anio
AND MONTH(tur.fecha_creacion) =:mes
AND DAY(tur.fecha_creacion) =:dia
GROUP BY mdu.id_modulo_usuario");
            $query2->execute(array(':id_modulo_usuario' => $value['id_modulo_usuario'],
                ':anio' => $anio,
                ':mes' => $mes,
                ':dia' => $dia));
            $rows2 = $query2->fetchAll(PDO::FETCH_ASSOC);

            if (empty($rows2)) {
                $valor = 0;
            } else {
                $valor = $rows2[0]['conteo'];
            }

            $arreglo_modulos[$value['id_modulo_usuario']] = $valor;
        }

        $valor = min($arreglo_modulos);
        $indice = array_search($valor, $arreglo_modulos);

        return $indice;
    }

}

?>