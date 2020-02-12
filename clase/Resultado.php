<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Resultado
 *
 * @author JuanCamilo
 */
date_default_timezone_set('America/Bogota');
require_once '../conexion/conexion_bd.php';
require_once('../controlador/class.phpmailer.php');
include("../controlador/class.smtp.php");

class Resultado {

    public $conexion;

    function __construct() {
        $this->conexion = new Conexion();
    }

    public function RegistrarResultadoCRM1($data) {
        if ($data["estado_resultado"] == NULL || $data["tipo_documento"] == NULL || $data["numero_documento"] == NULL || $data["id_solicitud"] == NULL || $data["nombre_archivo"] == NULL || $data["archivo_resultado"] == NULL) {
            return "TODOS LOS PARAMETROS SON OBLIGATORIOS";
        } else {


            $query = $this->conexion->prepare("SELECT id_cliente FROM cliente WHERE documento =:documento");
            $query->execute(array(":documento" => $data['numero_documento']));
            $rows = $query->fetchAll(PDO::FETCH_ASSOC);

            if (empty($rows)) {
                return "El paciente no existe";
            } else {

                $sql_resultado = "SELECT idresultado,idventa,idcliente,id_solicitud_athenea,
                                  estado,fecha_creacion,fecha_modificacion
                                  FROM resultado WHERE idcliente=:id_cliente AND id_solicitud_athenea=:sol_athenea";



                $query1 = $this->conexion->prepare($sql_resultado);
                $query1->execute(array(":id_cliente" => $rows[0]['id_cliente'],
                    ":sol_athenea" => $data["id_solicitud"]));

                $rows1 = $query1->fetchAll(PDO::FETCH_ASSOC);



                if (empty($rows1)) {
                    return "El numero de solicitud y el paciente no se encuentran relacionados";
                } else {



                    if ($data["estado_resultado"] == "en_proceso" || $data["estado_resultado"] == "terminado") {




                        if ($rows1[0]["estado"] == 2) {

                            $sql_exam_res = "select * from arch_res where id_resultado =:id_resultado";
                            $query4 = $this->conexion->prepare($sql_exam_res);
                            $query4->execute(array(":id_resultado" => $rows1[0]['idresultado']));
                            $rows4 = $query4->fetchAll(PDO::FETCH_ASSOC);
                            $estado_archivo = "";

                            if (empty($rows4)) {
                                $estado_archivo = "nuevo";
                            } else {
                                $estado_archivo = "creado";
                            }


                            $estado;
                            if ($data["estado_resultado"] == "en_proceso") {
                                $estado = 2;
                            } else if ($data["estado_resultado"] == "terminado") {
                                $estado = 3;
                            }
                            $vars_archivo = explode(".", $data['nombre_archivo']);
                            $extension = end($vars_archivo);
                            $nombre_sistema = $rows1[0]['idresultado'] . "_" . date("YmdHis") . "." . $extension;



                            $decodeData = base64_decode($data['archivo_resultado']);
                            $fp = fopen("resultados/" . $nombre_sistema, 'w+');
                            fwrite($fp, $decodeData);
                            fclose($fp);

                            $sql_arch = "INSERT INTO arch_res(id_resultado,nombre_archivo,nombre_archivo_sistema,fecha_creacion,fecha_modificacion)
                                                   VALUES(:id_resultado,:nombre_archivo,:nombre_archivo_sistema,NOW(),NOW())";

                            $query5 = $this->conexion->prepare($sql_arch);
                            $query5->execute(array(":id_resultado" => $rows1[0]['idresultado'],
                                ":nombre_archivo" => $data['nombre_archivo'],
                                ":nombre_archivo_sistema" => $nombre_sistema));


                            if ($query5) {

                                $query_up = $this->conexion->prepare("UPDATE resultado SET fecha_modificacion=NOW(),
                                                          estado=:estado
                                                          WHERE idresultado =:id_resultado");
                                $query_up->execute(array(':estado' => $estado,
                                    ':id_resultado' => $rows1[0]['idresultado']));

                                if ($query_up) {
                                    if ($data["estado_resultado"] == "en_proceso") {
                                        return "Se ingreso correctamente el resultado";
                                    } else if ($data["estado_resultado"] == "terminado") {
                                        return "Se ingreso y termino le ingreso correctamente de el resultado";
                                    }
                                } else {
                                    return "Error al tratar de almacenar el resultado";
                                }
                                //return "Se ingreso con exito el resultado";
                            } else {
                                return "Error al tratar de adjuntar el documento";
                            }
                        } else if ($rows1[0]["estado"] == 3) {
                            return "Este proceso se encuentra en estado terminado , ya no se puede anexar mas documentos";
                        }
                    } else {
                        return "el estado no es un es un string valido debe ser : en_proceso o terminado";
                    }
                }
            }
        }

        /* $decodeData = base64_decode($archivo_resultado);
          $fp = fopen($nombre_archivo, 'w');
          fwrite($fp, $decodeData);
          fclose($fp); */
    }

    public function RegistrarResultadoCRM($data) {

        if ($data["tipo_documento"] == NULL || $data["numero_documento"] == NULL || $data["id_solicitud"] == NULL || $data["nombre_archivo"] == NULL || $data["archivo_resultado"] == NULL) {
            return "TODOS LOS PARAMETROS SON OBLIGATORIOS";
        } else {


            $query = $this->conexion->prepare("SELECT id_cliente FROM cliente WHERE documento =:documento");
            $query->execute(array(":documento" => $data['numero_documento']));
            $rows = $query->fetchAll(PDO::FETCH_ASSOC);

            if (empty($rows)) {
                return "El paciente no existe";
            } else {

                $sql_resultado = "SELECT idresultado,idventa,idcliente,id_solicitud_athenea,
                                  estado,fecha_creacion,fecha_modificacion
                                  FROM resultado WHERE idcliente=:id_cliente AND id_solicitud_athenea=:sol_athenea";



                $query1 = $this->conexion->prepare($sql_resultado);
                $query1->execute(array(":id_cliente" => $rows[0]['id_cliente'],
                    ":sol_athenea" => $data["id_solicitud"]));

                $rows1 = $query1->fetchAll(PDO::FETCH_ASSOC);



                if (empty($rows1)) {
                    return "El numero de solicitud y el paciente no se encuentran relacionados";
                } else {


                    $sql_revisa_examen = "select exm.id,exm.codigo
                                             from venta_items itm
                                             INNER JOIN examenes_no_perfiles exm ON exm.id = itm.examen_id
                                             where itm.venta_id =:id_venta
                                             and itm.tipo_examen =:tipo_examen
                                             and codigo =:codigo_examen";
                    $query3 = $this->conexion->prepare($sql_revisa_examen);
                    $query3->execute(array(":id_venta" => $rows1[0]['idventa'],
                        ":tipo_examen" => 2,
                        ":codigo_examen" => $data["codigo_examen"]));

                    $rows3 = $query3->fetchAll(PDO::FETCH_ASSOC);



                    if (empty($rows3)) {
                        return "El codigo de el examen que ingreso no esta relacionado con esta solicitud";
                    } else {

                        $sql_exam_res = "select * from arch_res_examen where id_resultado =:id_resultado and id_examen=:id_examen and sub_codigo_examen=:sub_codigo_examen";
                        $query4 = $this->conexion->prepare($sql_exam_res);
                        $query4->execute(array(":id_resultado" => $rows1[0]['idresultado'],
                            ":id_examen" => $rows3[0]["id"],
                            ":sub_codigo_examen" => $data["sub_codigo_examen"]));
                        $rows4 = $query4->fetchAll(PDO::FETCH_ASSOC);


                        if ($rows1[0]['estado'] == 2) {

                            $decodeData = base64_decode($data['archivo_resultado']);
                            $fp = fopen("resultados/" . $data['nombre_archivo'], 'w+');
                            fwrite($fp, $decodeData);
                            fclose($fp);

                            if (empty($rows4)) {



                                $sql_arch = "INSERT INTO arch_res_examen(id_resultado,id_examen,nombre_archivo,fecha_creacion,fecha_modificacion,sub_codigo_examen)
                                                   VALUES(:id_resultado,:id_examen,:nombre_archivo,NOW(),NOW(),:sub_codigo_examen)";

                                $query5 = $this->conexion->prepare($sql_arch);
                                $query5->execute(array(":id_resultado" => $rows1[0]['idresultado'],
                                    ":id_examen" => $rows3[0]["id"],
                                    ":nombre_archivo" => $data['nombre_archivo'],
                                    ":sub_codigo_examen" => $data['sub_codigo_examen']));

                                if ($query5) {
                                    return "Se ingreso con exito el resultado";
                                } else {
                                    return "Error al tratar de ingresar el resultado";
                                }
                            } else {
                                $sql_arch = "UPDATE arch_res_examen SET fecha_modificacion=NOW(),
                                                   nombre_archivo=:nombre_archivo
                                                   WHERE id_arch_res_examen=:id_arch_res_examen";
                                $query5 = $this->conexion->prepare($sql_arch);
                                $query5->execute(array(":id_arch_res_examen" => $rows4[0]["id_arch_res_examen"],
                                    ":nombre_archivo" => $data['nombre_archivo']));
                                if ($query5) {
                                    return "Se modifico con exito el resultado";
                                } else {
                                    return "Error al tratar de modificar el resultado";
                                }
                            }
                        } else {



                            $query_up = $this->conexion->prepare("UPDATE resultado SET fecha_modificacion=NOW(),
                                                          estado=:estado
                                                          WHERE idresultado =:id_resultado");
                            $query_up->execute(array(':estado' => 2,
                                ':id_resultado' => $rows1[0]['idresultado']));
                            if ($query_up) {

                                $decodeData = base64_decode($data['archivo_resultado']);
                                $fp = fopen("resultados/" . $data['nombre_archivo'], 'w+');
                                fwrite($fp, $decodeData);
                                fclose($fp);



                                if (empty($rows4)) {
                                    $sql_arch = "INSERT INTO arch_res_examen(id_resultado,id_examen,nombre_archivo,fecha_creacion,fecha_modificacion,sub_codigo_examen)
                                                   VALUES(:id_resultado,:id_examen,:nombre_archivo,NOW(),NOW(),:sub_codigo_examen)";

                                    $query5 = $this->conexion->prepare($sql_arch);
                                    $query5->execute(array(":id_resultado" => $rows1[0]['idresultado'],
                                        ":id_examen" => $rows3[0]["id"],
                                        ":nombre_archivo" => $data['nombre_archivo'],
                                        ":sub_codigo_examen" => $data["sub_codigo_examen"]));

                                    if ($query5) {
                                        return "Se ingreso con exito el resultado";
                                    } else {
                                        return "Error al tratar de ingresar el resultado";
                                    }
                                } else {
                                    $sql_arch = "UPDATE arch_res_examen SET fecha_modificacion=NOW(),
                                                   nombre_archivo=:nombre_archivo
                                                   WHERE id_arch_res_examen=:id_arch_res_examen";
                                    $query5 = $this->conexion->prepare($sql_arch);
                                    $query5->execute(array(":id_arch_res_examen" => $rows4[0]["id_arch_res_examen"],
                                        ":nombre_archivo" => $data['nombre_archivo']));
                                    if ($query5) {
                                        return "Se modifico con exito el resultado";
                                    } else {
                                        return "Error al tratar de modificar el resultado";
                                    }
                                }
                            } else {
                                return "Error al tratar de almacenar el resultado";
                            }
                        }



                        /* $decodeData = base64_decode($data['archivo_resultado']);
                          $fp = fopen("resultados/" . $data['nombre_archivo'], 'w');
                          fwrite($fp, $decodeData);
                          fclose($fp);

                          $query_up = $this->conexion->prepare("UPDATE resultado SET archivo = :archivo,
                          fecha_modificacion = NOW(),
                          estado = :estado
                          WHERE idresultado = :id_resultado");
                          $query_up->execute(array(':archivo' => $data['nombre_archivo'],
                          ':estado' => 2,
                          ':id_resultado' => $rows1[0]['idresultado']));/
                          if ($query_up) {
                          return "Se ingreso el resultado correctamente";
                          } else {
                          return "Error al tratar de almacenar el resultado";
                          } */
                    }
                }
            }
        }

        /* $decodeData = base64_decode($archivo_resultado);
          $fp = fopen($nombre_archivo, 'w');
          fwrite($fp, $decodeData);
          fclose($fp); */
    }

    public function VerListaResultados($data) {
        $query = $this->conexion->prepare("SELECT res.idresultado,res.idventa,res.id_solicitud_athenea,res.fecha_creacion,res.fecha_modificacion,
arc.nombre_archivo,arc.nombre_archivo_sistema,res.estado
FROM venta ven
INNER JOIN resultado res ON res.idventa = ven.id
LEFT JOIN arch_res arc ON arc.id_resultado = res.idresultado
WHERE ven.estado = 2
AND ven.cliente_id =:cliente");
        $query->execute(array(":cliente" => $data['id_cliente']));
        $rows = $query->fetchAll(PDO::FETCH_ASSOC);
        return json_encode($rows);
    }

    public function RegistrarResultado($data) {
        if ($data["tipo_documento"] == NULL || $data["numero_documento"] == NULL || $data["id_solicitud"] == NULL || $data["nombre_archivo"] == NULL || $data["archivo_resultado"] == NULL) {
            return "TODOS LOS PARAMETROS SON OBLIGATORIOS";
        } else {

            $query = $this->conexion->prepare("SELECT id_cliente,nombre,apellido,email FROM cliente WHERE documento =:documento");
            $query->execute(array(":documento" => $data['numero_documento']));
            $rows = $query->fetchAll(PDO::FETCH_ASSOC);

            if (empty($rows)) {
                return "El paciente no existe";
            } else {
                $sql_resultado = "SELECT idresultado,idventa,idcliente,id_solicitud_athenea,
                                  estado,fecha_creacion,fecha_modificacion
                                  FROM resultado WHERE idcliente=:id_cliente AND id_solicitud_athenea=:sol_athenea";



                $query1 = $this->conexion->prepare($sql_resultado);
                $query1->execute(array(":id_cliente" => $rows[0]['id_cliente'],
                    ":sol_athenea" => $data["id_solicitud"]));

                $rows1 = $query1->fetchAll(PDO::FETCH_ASSOC);



                if (empty($rows1)) {
                    return "El numero de solicitud y el paciente no se encuentran relacionados";
                } else {

                    $id_examen_fin = "";
                    $codigo_examen = "";
                    $tipo_examen = "";

                    /* 1 = perfil , 2=no_perfiles */
                    $sql_examenes_asignados = "select * from venta_items where venta_id =:venta_id";
                    $query_examen_asigna = $this->conexion->prepare($sql_examenes_asignados);
                    $query_examen_asigna->execute(array(":venta_id" => $rows1[0]["idventa"]));

                    $array_examen_as = $query_examen_asigna->fetchAll(PDO::FETCH_ASSOC);

                    $arreglo_examenes = array();
                    $i = 0;
                    foreach ($array_examen_as as $value) {
                        if ($value['tipo_examen'] == 1) {

                            $sql_examenes_perfiles = "select exm.id,exm.codigo
                                                  from perfil_examen pex
                                                  inner join examenes_no_perfiles exm on exm.id = pex.id_examen
                                                  where pex.id_perfil = :id_perfil";
                            $query_examen_per = $this->conexion->prepare($sql_examenes_perfiles);
                            $query_examen_per->execute(array(":id_perfil" => $value['examen_id']));

                            $array_examen_per = $query_examen_per->fetchAll(PDO::FETCH_ASSOC);

                            if (!empty($array_examen_per)) {

                                foreach ($array_examen_per as $key => $value2) {

                                    array_push($arreglo_examenes, $value2['codigo']);
                                }
                            }
                        } else if ($value['tipo_examen'] == 2) {
                            $sql_examenes_n_perfiles = "SELECT id,codigo FROM examenes_no_perfiles WHERE id=:id_examen";
                            $query_examen_n_per = $this->conexion->prepare($sql_examenes_n_perfiles);
                            $query_examen_n_per->execute(array(":id_examen" => $value['examen_id']));

                            $array_examen_n_per = $query_examen_n_per->fetchAll(PDO::FETCH_ASSOC);

                            if (!empty($array_examen_n_per)) {

                                array_push($arreglo_examenes, $array_examen_n_per[0]['codigo']);
                            }
                        }
                    }



                    $indice = in_array($data["codigo"], $arreglo_examenes);

                    if ($indice) {
                        $sql_examen = "select * from examenes_no_perfiles where codigo = :codigo";
                        $query_examen = $this->conexion->prepare($sql_examen);
                        $query_examen->execute(array(":codigo" => $data["codigo"]));

                        $array_examen = $query_examen->fetchAll(PDO::FETCH_ASSOC);

                        if (!empty($array_examen)) {
                            $id_examen_fin = $array_examen[0]['id'];
                            $codigo_examen = $array_examen[0]['codigo'];
                            $tipo_examen = "examen";
                        } else {

                            /* --- inserta error resultado para su posterior uso ----- */

                            $sql_insert_error = "INSERT INTO valor_resultado_error(id_solicitud_athenea,resultado,codigo_examen)
                                                 VALUES(:id_solicitud_athenea,:resultado,:codigo_examen)";

                            $query_insert_error = $this->conexion->prepare($sql_insert_error);
                            $query_insert_error->execute(array(
                                ":id_solicitud_athenea" => $data["id_solicitud"],
                                ":resultado" => $data['valor_resultado'],
                                ":codigo_examen" => $data["codigo"]
                            ));

                            /* --------- fin almacena resultado para su posterior uso ---- */

                            return "EL CODIGO " . $data["codigo"] . " DE EXAMEN NO ESTA ASOCIADO A ESTA SOLICITUD";
                        }
                    } else {
                        $sql_examenes_sub = "SELECT * FROM sub_examen WHERE codigo_sub_examen = :sub_examen";
                        $query_examen_sub = $this->conexion->prepare($sql_examenes_sub);
                        $query_examen_sub->execute(array(":sub_examen" => $data["codigo"]));

                        $array_examen_sub = $query_examen_sub->fetchAll(PDO::FETCH_ASSOC);

                        if (!empty($array_examen_sub)) {
                            $id_examen_fin = $array_examen_sub[0]['id_sub_examen'];
                            $codigo_examen = $array_examen_sub[0]['codigo_sub_examen'];
                            $tipo_examen = "sub_examen";
                        } else {

                            /* --- inserta error resultado para su posterior uso ----- */

                            $sql_insert_error = "INSERT INTO valor_resultado_error(id_solicitud_athenea,resultado,codigo_examen)
                                                 VALUES(:id_solicitud_athenea,:resultado,:codigo_examen)";

                            $query_insert_error = $this->conexion->prepare($sql_insert_error);
                            $query_insert_error->execute(array(
                                ":id_solicitud_athenea" => $data["id_solicitud"],
                                ":resultado" => $data['valor_resultado'],
                                ":codigo_examen" => $data["codigo"]
                            ));

                            /* --------- fin almacena resultado para su posterior uso ---- */

                            return "EL CODIGO " . $data["codigo"] . " DE EXAMEN NO ESTA ASOCIADO A ESTA SOLICITUD";
                        }
                    }

                    if ($id_examen_fin != "") {

                        $sql_archivos_resultado = "SELECT * FROM arch_res WHERE id_resultado=:id_resultado";
                        $query2 = $this->conexion->prepare($sql_archivos_resultado);
                        $query2->execute(array(":id_resultado" => $rows1[0]['idresultado']));

                        $rows2 = $query2->fetchAll(PDO::FETCH_ASSOC);

                        if (!empty($rows2)) {


                            //return var_dump($rows2);

                            foreach ($rows2 as $key => $value) {

                                $exists = is_file("resultados/" . $value['nombre_archivo_sistema']);

                                if ($exists) {
                                    $eliminacion_arr = unlink("resultados/" . $value['nombre_archivo_sistema']);
                                    if (!$eliminacion_arr) {
                                        return "error al modificar el resultado";
                                        die();
                                    }
                                }
                            }
                            $vars_archivo_res = explode(".", $data['nombre_archivo']);
                            $extension_res = end($vars_archivo_res);
                            $nombre_sistema_res = "resultado_" . $rows1[0]['idresultado'] . "." . $extension_res;





                            $decodeData_res = base64_decode($data['archivo_resultado']);
                            $fp_res = fopen("resultados/" . $nombre_sistema_res, 'w+');
                            $resul_archivo_res = fwrite($fp_res, $decodeData_res);
                            fclose($fp_res);

                            if (!$resul_archivo_res) {
                                return "el archivo de resultados no se cargo correctamente";
                                die();
                            }


                            foreach ($rows2 as $key => $value2) {
                                if ($value2['tipo'] == "resultado") {

                                    $query_up = $this->conexion->prepare("UPDATE arch_res SET fecha_modificacion=NOW(),
                                                          nombre_archivo=:nombre_archivo,
                                                          nombre_archivo_sistema=:nombre_archivo_sistema
                                                          WHERE id_arch_res =:id_arch_res");
                                    $query_up->execute(array(':nombre_archivo' => $data['nombre_archivo'],
                                        ':nombre_archivo_sistema' => $nombre_sistema_res,
                                        ':id_arch_res' => $value2['id_arch_res']));

                                    if (!$query_up) {
                                        return "error al tratar de modificar el archivo resultado";
                                        die();
                                    }
                                }
                            }

                            $query_up = $this->conexion->prepare("UPDATE resultado SET fecha_modificacion=NOW(),
                                                          estado=:estado
                                                          WHERE idresultado =:id_resultado");
                            $query_up->execute(array(':estado' => 2,
                                ':id_resultado' => $rows1[0]['idresultado']));

                            if ($query_up) {

                                $sql_insertar_valor_resultado = "INSERT INTO valor_resultado(id_examen,id_resultado,tipo_examen,resultado,codigo_examen)
                                        VALUES(:id_examen,:id_resultado,:tipo_examen,:resultado,:codigo_examen)";


                                $query_valor_resultado = $this->conexion->prepare($sql_insertar_valor_resultado);
                                $query_valor_resultado->execute(array(
                                    ":id_examen" => $id_examen_fin,
                                    ":id_resultado" => $rows1[0]['idresultado'],
                                    ":tipo_examen" => $tipo_examen,
                                    ":resultado" => $data['valor_resultado'],
                                    ":codigo_examen" => $codigo_examen
                                ));

                                if ($query_valor_resultado) {

                                    $completo = $this->DetalleCompletoResultado($rows1[0]["idventa"], $rows1[0]['idresultado']);

                                    if ($completo['completo'] == 'COMPLETO') {
                                        $nombre_cliente = $rows[0]['apellido'] . " " . $rows[0]['nombre'];
                                        $correo = $this->EnviarCorreo($rows[0]['email'], $nombre_cliente, $rows1[0]['idresultado'], 'auto');

                                        return "Se Modifico correctamente el documento de resultado y se ingreso el valor de el resultado";
                                    } else {
                                        return "Se Modifico correctamente el documento de resultado y se ingreso el valor de el resultado";
                                    }
                                } else {
                                    return "Error";
                                }
                            } else {
                                return "Error";
                            }
                            // return "lleno";
                        } else {

                            $vars_archivo_res = explode(".", $data['nombre_archivo']);
                            $extension_res = end($vars_archivo_res);
                            $nombre_sistema_res = "resultado_" . $rows1[0]['idresultado'] . "." . $extension_res;

                            $decodeData_res = base64_decode($data['archivo_resultado']);
                            $fp_res = fopen("resultados/" . $nombre_sistema_res, 'w+');
                            $resul_archivo_res = fwrite($fp_res, $decodeData_res);
                            fclose($fp_res);

                            if (!$resul_archivo_res) {
                                return "el archivo de resultados no se cargo correctamente";
                                die();
                            }


                            $sql_arch = "INSERT INTO arch_res(id_resultado,nombre_archivo,nombre_archivo_sistema,fecha_creacion,fecha_modificacion,tipo)
                                                   VALUES(:id_resultado,:nombre_archivo,:nombre_archivo_sistema,NOW(),NOW(),:tipo)";

                            $query5 = $this->conexion->prepare($sql_arch);
                            $query5->execute(array(":id_resultado" => $rows1[0]['idresultado'],
                                ":nombre_archivo" => $data['nombre_archivo'],
                                ":nombre_archivo_sistema" => $nombre_sistema_res,
                                ":tipo" => "resultado"));

                            if ($query5) {

                                $query_up = $this->conexion->prepare("UPDATE resultado SET fecha_modificacion=NOW(),
                                                          estado=:estado
                                                          WHERE idresultado =:id_resultado");
                                $query_up->execute(array(':estado' => 2,
                                    ':id_resultado' => $rows1[0]['idresultado']));

                                if ($query_up) {

                                    $sql_insertar_valor_resultado = "INSERT INTO valor_resultado(id_examen,id_resultado,tipo_examen,resultado,codigo_examen)
                                        VALUES(:id_examen,:id_resultado,:tipo_examen,:resultado,:codigo_examen)";


                                    $query_valor_resultado = $this->conexion->prepare($sql_insertar_valor_resultado);
                                    $query_valor_resultado->execute(array(
                                        ":id_examen" => $id_examen_fin,
                                        ":id_resultado" => $rows1[0]['idresultado'],
                                        ":tipo_examen" => $tipo_examen,
                                        ":resultado" => $data['valor_resultado'],
                                        ":codigo_examen" => $codigo_examen
                                    ));

                                    if ($query_valor_resultado) {
                                        $completo = $this->DetalleCompletoResultado($rows1[0]["idventa"], $rows1[0]['idresultado']);

                                        if ($completo['completo'] == 'COMPLETO') {
                                            $nombre_cliente = $rows[0]['apellido'] . " " . $$rows[0]['nombre'];
                                            $correo = $this->EnviarCorreo($rows[0]['email'], $nombre_cliente, $rows1[0]['idresultado'], 'auto');

                                            return "Ingreso correctamente el resultado";
                                        } else {
                                            return "Ingreso correctamente el resultado";
                                        }
                                    } else {
                                        return "Error al tratar de ingresar el resultado";
                                    }
                                } else {
                                    return "Error al tratar de ingresar el resultado";
                                }
                            } else {
                                return "No se creo correctamente el resultado";
                            }
                        }
                    }


                    /* $sql_revisa_examen = "SELECT * FROM examenes_no_perfiles WHERE codigo = :codigo";
                      $query_revisa_examen = $this->conexion->prepare($sql_revisa_examen);
                      $query_revisa_examen->execute(array(":codigo" => $data['codigo']));

                      $array_examen = $query_revisa_examen->fetchAll(PDO::FETCH_ASSOC); */
                }
            }
        }
    }

    public function ResultadosIndividual($data) {

        /* $sql_cliente = "SELECT * FROM cliente WHERE documento = :documento";
          $query_cliente = $this->conexion->prepare($sql_cliente);
          $query_cliente->execute(array(":documento" => $data['documento']));

          $rows2 = $query_cliente->fetchAll(PDO::FETCH_ASSOC);

          if (!empty($rows2)) { */

        $documento = $data["documento"];
        $id_solicitud = $data["id_solicitud"];
        $regi_resul = $data["regi_resul"];

        $adicion_documento = "";
        $adicion_solicitud = "";
        $adicion_regiresul = "";

        if ($documento != "" || $documento != null) {
            $adicion_documento = " AND cli.documento = '" . $documento . "' ";
        }

        if ($id_solicitud != "" || $id_solicitud != null) {
            $adicion_solicitud = " AND res.id_solicitud_athenea = '" . $id_solicitud . "' ";
        }

        if ($regi_resul != "" || $regi_resul != null) {
            if ($regi_resul == "si") {
                $adicion_regiresul = " AND res.estado = '2' ";
            } else {
                $adicion_regiresul = " AND res.estado = '1' ";
            }
        }


        $arreglo_retorno = array();


        $sql = "SELECT res.idresultado,res.idventa,res.id_solicitud_athenea,res.fecha_creacion,res.fecha_modificacion,
arc.nombre_archivo,arc.nombre_archivo_sistema,res.estado,ven.fecha_pago,
cli.documento,cli.nombre,cli.apellido,cli.email
FROM venta ven
INNER JOIN resultado res ON res.idventa = ven.id
INNER JOIN cliente cli ON cli.id_cliente = ven.cliente_id
LEFT JOIN arch_res arc ON arc.id_resultado = res.idresultado
WHERE ven.estado = 2
$adicion_documento
$adicion_solicitud
$adicion_regiresul";

        $query = $this->conexion->prepare($sql);
        //$query->execute(array(":cliente" => $rows2[0]['id_cliente']));
        $query->execute();
        $rows = $query->fetchAll(PDO::FETCH_ASSOC);

        $arreglo_adicionado = array();
        $i = 0;
        foreach ($rows as $key => $value) {
            /* $porcentaje = "0%";
              if ($value['estado'] == 2) {
              $retorno_p = $this->DetalleCompletoResultado($value['idventa'], $value['idresultado']);
              $porcentaje = $retorno_p['porcentaje'] . "%";
              } */

            $arreglo_adicionado[$i]['idresultado'] = $value['idresultado'];
            $arreglo_adicionado[$i]['idventa'] = $value['idventa'];
            $arreglo_adicionado[$i]['id_solicitud_athenea'] = $value['id_solicitud_athenea'];
            $arreglo_adicionado[$i]['fecha_creacion'] = $value['fecha_creacion'];
            $arreglo_adicionado[$i]['fecha_modificacion'] = $value['fecha_modificacion'];
            $arreglo_adicionado[$i]['nombre_archivo'] = $value['nombre_archivo'];
            $arreglo_adicionado[$i]['nombre_archivo_sistema'] = $value['nombre_archivo_sistema'];
            $arreglo_adicionado[$i]['estado'] = $value['estado'];
            $arreglo_adicionado[$i]['fecha_pago'] = $value['fecha_pago'];
            $arreglo_adicionado[$i]['documento'] = $value['documento'];
            $arreglo_adicionado[$i]['nombre'] = $value['nombre'];
            $arreglo_adicionado[$i]['apellido'] = $value['apellido'];
            $arreglo_adicionado[$i]['email'] = $value['email'];
            //$arreglo_adicionado[$i]['porcentaje'] = $porcentaje;
            $i++;
        }

        /* $arreglo_retorno["id_cliente"] = $rows2[0]["id_cliente"];
          $arreglo_retorno["documento"] = $rows2[0]["documento"];
          $arreglo_retorno["nombre"] = $rows2[0]["nombre"];
          $arreglo_retorno["apellido"] = $rows2[0]["apellido"];
          $arreglo_retorno["email"] = $rows2[0]["email"]; */

        $arreglo_retorno["resultados"] = $arreglo_adicionado;
        return json_encode($arreglo_retorno);
        /* } else {
          return 2;
          } */
    }

    public function ResultadosDetalle($data) {

        $arreglo_retorno = array();

        $sql_perfiles = "SELECT exm.id,exm.nombre,exm.codigo_crm,exm.nombre
                         FROM venta_items veni
                         INNER JOIN examen exm ON exm.id = veni.examen_id 
                         WHERE  veni.venta_id =:venta_id AND veni.tipo_examen = :tipo_examen";


        $query_perfiles = $this->conexion->prepare($sql_perfiles);
        $query_perfiles->execute(array(":venta_id" => $data['venta_id'],
            ":tipo_examen" => 1));
        $rows_perfiles = $query_perfiles->fetchAll(PDO::FETCH_ASSOC);


        if (!empty($rows_perfiles)) {
            $arreglo_perfiles = array();
            $i = 0;
            foreach ($rows_perfiles as $key => $value) {

                //die();
                $arreglo_perfiles[$i]["id"] = $value["id"];
                $arreglo_perfiles[$i]["nombre"] = $value["nombre"];
                $arreglo_perfiles[$i]["codigo"] = $value["codigo_crm"];

                $sql_examenes_per = "SELECT exam.id,exam.codigo,exam.nombre FROM perfil_examen per
                                     INNER JOIN examenes_no_perfiles exam ON exam.id = per.id_examen
                                     WHERE id_perfil =:id_perfil";
                $query_examenes_per = $this->conexion->prepare($sql_examenes_per);
                $query_examenes_per->execute(array(":id_perfil" => $value["id"]));
                $rows_examenes_per = $query_examenes_per->fetchAll(PDO::FETCH_ASSOC);




                if (!empty($rows_examenes_per)) {
                    $a = 0;
                    $arreglo_inter_per = array();
                    foreach ($rows_examenes_per as $key2 => $value2) {

                        $sql_sub_examen = "SELECT codigo_sub_examen,nombre_sub_examen FROM sub_examen where id_examen = :id_examen";
                        $query_sub_examen = $this->conexion->prepare($sql_sub_examen);
                        $query_sub_examen->execute(array(":id_examen" => $value2["id"]));
                        $rows_sub_examen = $query_sub_examen->fetchAll(PDO::FETCH_ASSOC);

                        if (empty($rows_sub_examen)) {

                            $sql_valor_resultado = "SELECT * FROM valor_resultado 
                                                    WHERE id_resultado =:id_resultado 
                                                    AND codigo_examen =:codigo_examen
                                                    ORDER BY id_valor_resultado DESC
                                                    LIMIT 1";
                            $query_valor_resul = $this->conexion->prepare($sql_valor_resultado);
                            $query_valor_resul->execute(array(":id_resultado" => $data["id_resultado"],
                                ":codigo_examen" => $value2["codigo"]));
                            $rows_valor_resul = $query_valor_resul->fetchAll(PDO::FETCH_ASSOC);

                            if (empty($rows_valor_resul)) {
                                $arreglo_inter_per[$a]["fecha"] = "no se ha ingresado";
                                $arreglo_inter_per[$a]["valor"] = "no se ha ingresado";
                            } else {
                                $arreglo_inter_per[$a]["fecha"] = $rows_valor_resul[0]["fecha_creacion"];
                                $arreglo_inter_per[$a]["valor"] = $rows_valor_resul[0]["resultado"];
                            }

                            $arreglo_inter_per[$a]["codigo"] = $value2["codigo"];
                            $arreglo_inter_per[$a]["nombre"] = $value2["nombre"];
                        } else {
                            $arreglo_inter_per[$a]["id_c"] = $value2["id"];
                            $arreglo_inter_per[$a]["fecha"] = "revisar_analitos";
                            $arreglo_inter_per[$a]["valor"] = "revisar_analitos";
                            $arreglo_inter_per[$a]["codigo"] = $value2["codigo"];
                            $arreglo_inter_per[$a]["nombre"] = $value2["nombre"];
                        }


                        $a++;
                    }
                    $arreglo_perfiles[$i]["examenes"] = $arreglo_inter_per;
                }

                $i++;
            }

            $arreglo_retorno["perfiles"] = $arreglo_perfiles;
        }

        $sql_no_perfiles = "SELECT exm.id,exm.nombre,exm.codigo
                         FROM venta_items veni
                         INNER JOIN examenes_no_perfiles exm ON exm.id = veni.examen_id 
                         WHERE  veni.venta_id =:venta_id AND veni.tipo_examen = :tipo_examen";


        $query_no_perfiles = $this->conexion->prepare($sql_no_perfiles);
        $query_no_perfiles->execute(array(":venta_id" => $data['venta_id'],
            ":tipo_examen" => 2));
        $rows_no_perfiles = $query_no_perfiles->fetchAll(PDO::FETCH_ASSOC);

        if (!empty($rows_no_perfiles)) {
            $arreglo_no_perfiles = array();
            $i = 0;
            foreach ($rows_no_perfiles as $key3 => $value3) {

                $sql_sub_examen = "SELECT codigo_sub_examen,nombre_sub_examen FROM sub_examen where id_examen = :id_examen";
                $query_sub_examen = $this->conexion->prepare($sql_sub_examen);
                $query_sub_examen->execute(array(":id_examen" => $value3["id"]));
                $rows_sub_examen = $query_sub_examen->fetchAll(PDO::FETCH_ASSOC);

                if (empty($rows_sub_examen)) {

                    $arreglo_no_perfiles[$i]["id"] = $value3["id"];
                    $arreglo_no_perfiles[$i]["nombre"] = $value3["nombre"];
                    $arreglo_no_perfiles[$i]["codigo"] = $value3["codigo"];

                    $sql_valor_resultado = "SELECT * FROM valor_resultado 
                                                    WHERE id_resultado =:id_resultado 
                                                    AND codigo_examen =:codigo_examen
                                                    ORDER BY id_valor_resultado DESC
                                                    LIMIT 1";
                    $query_valor_resul = $this->conexion->prepare($sql_valor_resultado);
                    $query_valor_resul->execute(array(":id_resultado" => $data["id_resultado"],
                        ":codigo_examen" => $value3["codigo"]));
                    $rows_valor_resul = $query_valor_resul->fetchAll(PDO::FETCH_ASSOC);

                    if (empty($rows_valor_resul)) {
                        $arreglo_no_perfiles[$i]["fecha"] = "no se ha ingresado";
                        $arreglo_no_perfiles[$i]["valor"] = "no se ha ingresado";
                    } else {
                        $arreglo_no_perfiles[$i]["fecha"] = $rows_valor_resul[0]["fecha_creacion"];
                        $arreglo_no_perfiles[$i]["valor"] = $rows_valor_resul[0]["resultado"];
                    }
                } else {
                    $arreglo_no_perfiles[$i]["id"] = $value3["id"];
                    $arreglo_no_perfiles[$i]["nombre"] = $value3["nombre"];
                    $arreglo_no_perfiles[$i]["codigo"] = $value3["codigo"];
                    $arreglo_no_perfiles[$i]["fecha"] = "revisar_analitos";
                    $arreglo_no_perfiles[$i]["valor"] = "revisar_analitos";
                }
                $i++;
            }

            $arreglo_retorno["no_perfiles"] = $arreglo_no_perfiles;
        }
        $arreglo_porcentaje = $this->DetalleCompletoResultado($data['venta_id'], $data['id_resultado']);
        $arreglo_retorno["porcentaje"] = $arreglo_porcentaje;


        return json_encode($arreglo_retorno);
    }

    public function VerLogsSolicitud($data) {
        $query = $this->conexion->prepare("SELECT * FROM valor_resultado_error WHERE id_solicitud_athenea =:id_solicitud_athenea
                                          AND estado =:estado");
        $query->execute(array(":id_solicitud_athenea" => $data['id_solicitud_athenea'],
            ":estado" => 1));
        $rows = $query->fetchAll(PDO::FETCH_ASSOC);
        if (empty($rows)) {
            return 2;
        } else {
            return json_encode($rows);
        }
    }

    public function VerAnalitos($data) {

        $arreglo_retorno = array();

        $sql_analitos = "select * from sub_examen where id_examen = :id_examen";
        $query_analitos = $this->conexion->prepare($sql_analitos);
        $query_analitos->execute(array(":id_examen" => $data['id_examen']));
        $rows_analitos = $query_analitos->fetchAll(PDO::FETCH_ASSOC);

        $a = 0;
        foreach ($rows_analitos as $key => $value) {

            $sql_valor_resultado = "SELECT * FROM valor_resultado 
                                                    WHERE id_resultado =:id_resultado 
                                                    AND codigo_examen =:codigo_examen
                                                    AND tipo_examen =:tipo_examen
                                                    ORDER BY id_valor_resultado DESC
                                                    LIMIT 1";
            $query_valor_resul = $this->conexion->prepare($sql_valor_resultado);
            $query_valor_resul->execute(array(":id_resultado" => $data["id_resultado"],
                ":codigo_examen" => $value["codigo_sub_examen"],
                ":tipo_examen" => "sub_examen"));
            $rows_valor_resul = $query_valor_resul->fetchAll(PDO::FETCH_ASSOC);

            if (empty($rows_valor_resul)) {
                $arreglo_retorno[$a]["fecha"] = "no se ha ingresado";
                $arreglo_retorno[$a]["valor"] = "no se ha ingresado";
            } else {
                $arreglo_retorno[$a]["fecha"] = $rows_valor_resul[0]["fecha_creacion"];
                $arreglo_retorno[$a]["valor"] = $rows_valor_resul[0]["resultado"];
            }

            $arreglo_retorno[$a]["codigo"] = $value["codigo_sub_examen"];
            $arreglo_retorno[$a]["nombre"] = $value["nombre_sub_examen"];

            $a++;
        }

        return json_encode($arreglo_retorno);
    }

    public function DetalleCompletoResultado($id_venta, $id_resultado) {
        $sql_items = "SELECT id,examen_id,venta_id,tipo_examen FROM venta_items
              WHERE venta_id = $id_venta";
        $query_items = $this->conexion->prepare($sql_items);
        $query_items->execute();
        $rows_items = $query_items->fetchAll(PDO::FETCH_ASSOC);

        $sub_examenes = array();
        $examenes = array();
        foreach ($rows_items as $key => $value) {

            /* ------ inicio perfil ------ */

            if ($value['tipo_examen'] == '1') {

                $sql_perfil_examen = "SELECT prf.id_perfil,exam.id,exam.codigo
FROM perfil_examen prf
INNER JOIN examenes_no_perfiles exam ON exam.id = prf.id_examen
WHERE prf.id_perfil = " . $value['examen_id'] . "";

                $query_perfil = $this->conexion->prepare($sql_perfil_examen);
                $query_perfil->execute();
                $rows_exam_perfil = $query_perfil->fetchAll(PDO::FETCH_ASSOC);

                if (!empty($rows_exam_perfil)) {

                    foreach ($rows_exam_perfil as $key2 => $value2) {
                        $sql_subperfil = "SELECT * FROM sub_examen WHERE id_examen = " . $value2['id'] . "";
                        $query_subperfil = $this->conexion->prepare($sql_subperfil);
                        $query_subperfil->execute();
                        $rows_subperfil = $query_subperfil->fetchAll(PDO::FETCH_ASSOC);

                        if (!empty($rows_subperfil)) {

                            foreach ($rows_subperfil as $key3 => $value3) {
                                if (!in_array($value3['codigo_sub_examen'], $sub_examenes)) {
                                    array_push($sub_examenes, $value3['codigo_sub_examen']);
                                }
                            }
                        } else {
                            if (!in_array($value2['codigo'], $examenes)) {
                                array_push($examenes, $value2['codigo']);
                            }
                        }
                    }
                }
                /* ------ inicio examen individual ------ */
            } else if ($value['tipo_examen'] == '2') {

                $sql_examen = "SELECT * FROM examenes_no_perfiles WHERE id = " . $value['examen_id'] . "";
                $query_examen = $this->conexion->prepare($sql_examen);
                $query_examen->execute();
                $rows_examen = $query_examen->fetchAll(PDO::FETCH_ASSOC);

                $sql_subperfil = "SELECT * FROM sub_examen WHERE id_examen = " . $rows_examen[0]['id'] . "";
                $query_subperfil = $this->conexion->prepare($sql_subperfil);
                $query_subperfil->execute();
                $rows_subperfil = $query_subperfil->fetchAll(PDO::FETCH_ASSOC);

                if (!empty($rows_subperfil)) {

                    foreach ($rows_subperfil as $key3 => $value3) {
                        if (!in_array($value3['codigo_sub_examen'], $sub_examenes)) {
                            array_push($sub_examenes, $value3['codigo_sub_examen']);
                        }
                    }
                } else {
                    if (!in_array($rows_examen[0]['codigo'], $examenes)) {
                        array_push($examenes, $rows_examen[0]['codigo']);
                    }
                }
            }
        }


        $conteo = 0;
        foreach ($sub_examenes as $key4 => $value4) {
            $sql_confirma1 = "SELECT id_valor_resultado,resultado FROM valor_resultado 
                     WHERE codigo_examen = '" . $value4 . "' AND id_resultado = '" . $id_resultado . "' AND tipo_examen = 'sub_examen'";
            $query_confirma1 = $this->conexion->prepare($sql_confirma1);
            $query_confirma1->execute();
            $rows_confirma1 = $query_confirma1->fetchAll(PDO::FETCH_ASSOC);

            if (!empty($rows_confirma1)) {
                $conteo++;
            }
        }

        foreach ($examenes as $key5 => $value5) {
            $sql_confirma2 = "SELECT id_valor_resultado,resultado FROM valor_resultado 
                     WHERE codigo_examen = '" . $value5 . "' AND id_resultado = '" . $id_resultado . "' AND tipo_examen = 'examen'";
            $query_confirma2 = $this->conexion->prepare($sql_confirma2);
            $query_confirma2->execute();
            $rows_confirma2 = $query_confirma2->fetchAll(PDO::FETCH_ASSOC);

            if (!empty($rows_confirma2)) {
                $conteo++;
            }
        }


        $items_totales = count($sub_examenes) + count($examenes);
        $porcentaje = round($conteo / $items_totales * 100);
        $completo = "";
        if ($items_totales == $conteo) {
            $completo = "COMPLETO";
        } else {
            $completo = "INCOMPLETO";
        }

        $arreglo_retorno["porcentaje"] = $porcentaje;
        $arreglo_retorno["completo"] = $completo;
        $arreglo_retorno["conteo"] = $conteo;
        $arreglo_retorno["items_totales"] = $items_totales;

        return $arreglo_retorno;
    }

    function EnviarCorreo($correo_cliente, $nombre_cliente, $id_resultado, $tipo_envio) {
        $id_usuario = 0;
        if ($tipo_envio == "auto") {
            $id_usuario = 0;
        } else {
            session_start();
            $id_usuario = $_SESSION["ID_USUARIO"];
        }

        $mail = new PHPMailer();
        $mail->charSet = "UTF-8";
        $mail->IsSMTP();
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = "tls";
        $mail->Host = "smtp.gmail.com";
        $mail->Username = "hola@vitalea.com.co";
        $mail->Password = "vitaleah2019*";
        $mail->Port = 587;

        $correo = $correo_cliente;


        $mail->From = "hola@vitalea.com.co";
        $mail->FromName = "Vitalea";
        $mail->AddAddress($correo);
        $mail->IsHTML(true);
        $mail->Subject = "RESULTADOS VITALEA";

        $body = <<<ini
        
        
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Vitalea Bienvenida</title>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700,300|Montserrat:400,700&subset=latin,cyrillic,greek" rel="stylesheet" type="text/css">
    <style type="text/css">
        .ReadMsgBody { width: 100%; background-color: #ffffff;}
        .ExternalClass {width: 100%; background-color: #ffffff;}
        .ExternalClass, .ExternalClass p, .ExternalClass span,
        .ExternalClass font, .ExternalClass td, .ExternalClass tbody {line-height:100%;}
        #outlook a { padding:0;}
        html,body {margin: 0 auto !important; padding: 0 !important; height: 100% !important; width: 100% !important;}
        * {-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;}
        table,td {mso-table-lspace: 0pt !important; mso-table-rspace: 0pt !important;}
        table {border-spacing: 0 !important;}
        table table table {table-layout: auto;}
        a,span a{text-decoration: none !important;}
        .yshortcuts, .yshortcuts a, .yshortcuts a:link,.yshortcuts a:visited,
        .yshortcuts a:hover, .yshortcuts a span { text-decoration: none !important; border-bottom: none !important;}

        /*mailChimp class*/
        ul{padding-left:10px; margin:0;}
        .default-edit-image{height:20px;}
        .tpl-repeatblock {padding: 0px !important; border: 1px dotted rgba(0,0,0,0.2);}
        .tpl-content {padding:0px !important;}

        /* Start Old CSS */
        @media only screen and (max-width: 640px){
            .container{width:95%!important; max-width:95%!important; min-width:95%!important;
                       padding-left:15px!important; padding-right:15px!important; text-align: center!important; clear: both;}
            .full-width{width:100%!important; max-width:100%!important; min-width:100%!important; clear: both;}
            .full-width-center {width: 100%!important; max-width:100%!important;  text-align: center!important; clear: both; margin:0 auto; float:none;}
            .force-240-center{width:240px !important; clear: both; margin:0 auto; float:none;}
            .auto-center {width: auto!important; max-width:100%!important;  text-align: center!important; clear: both; margin:0 auto; float:none;}
            .auto-center-all{width: auto!important; max-width:75%!important;  text-align: center!important; clear: both; margin:0 auto; float:none;}
            .auto-center-all * {width: auto!important; max-width:100%!important;  text-align: center!important; clear: both; margin:0 auto; float:none;}
            .col-3,.col-3-not-full{width:30.35%!important; max-width:100%!important;}
            .col-2{width:47.3%!important; max-width:100%!important;}
            .full-block{display:block !important; clear: both;}
            /* image */
            .image-full-width img{width:100% !important; height:auto !important; max-width:100% !important;}
            /* helper */
            .space-w-20{width:3.57%!important; max-width:20px!important; min-width:3.5% !important;}
            .space-w-20 td:first-child{width:3.5%!important; max-width:20px!important; min-width:3.5% !important;}
            .space-w-25{width:4.45%!important; max-width:25px!important; min-width:4.45% !important;}
            .space-w-25 td:first-child{width:4.45%!important; max-width:25px!important; min-width:4.45% !important;}
            .space-w-30 td:first-child{width:5.35%!important; max-width:30px!important; min-width:5.35% !important;}
            .fix-w-20{width:20px!important; max-width:20px!important; min-width:20px!important;}
            .fix-w-20 td:first-child{width:20px!important; max-width:20px!important; min-width:20px !important;}
            .h-10{display:block !important;  height:10px !important;}
            .h-20{display:block !important;  height:20px !important;}
            .h-30{display:block !important; height:30px !important;}
            .h-40{display:block !important;  height:40px !important;}
            .remove-640{display:none !important;}
            .text-left{text-align:left !important;}
            .clear-pad{padding:0 !important;}
        }
        @media only screen and (max-width: 479px){
            .container{width:95%!important; max-width:95%!important; min-width:124px!important;
                       padding-left:15px!important; padding-right:15px!important; text-align: center!important; clear: both;}
            .full-width,.full-width-479{width:100%!important; max-width:100%!important; min-width:124px!important; clear: both;}
            .full-width-center {width: 100%!important; max-width:100%!important; min-width:124px!important; text-align: center!important; clear: both; margin:0 auto; float:none;}
            .auto-center-all{width: 100%!important; max-width:100%!important;  text-align: center!important; clear: both; margin:0 auto; float:none;}
            .auto-center-all * {width: auto!important; max-width:100%!important;  text-align: center!important; clear: both; margin:0 auto; float:none;}
            .col-3{width:100%!important; max-width:100%!important; text-align: center!important; clear: both;}
            .col-3-not-full{width:30.35%!important; max-width:100%!important; }
            .col-2{width:100%!important; max-width:100%!important; text-align: center!important; clear: both;}
            .full-block-479{display:block !important; clear: both; padding-top:10px; padding-bottom:10px; }
            /* image */
            .image-full-width img{width:100% !important; height:auto !important; max-width:100% !important; min-width:124px !important;}
            .image-min-80 img{width:100% !important; height:auto !important; max-width:100% !important; min-width:80px !important;}
            .image-min-100 img{width:100% !important; height:auto !important; max-width:100% !important; min-width:100px !important;}
            /* halper */
            .space-w-20{width:100%!important; max-width:100%!important; min-width:100% !important;}
            .space-w-20 td:first-child{width:100%!important; max-width:100%!important; min-width:100% !important;}
            .space-w-25{width:100%!important; max-width:100%!important; min-width:100% !important;}
            .space-w-25 td:first-child{width:100%!important; max-width:100%!important; min-width:100% !important;}
            .space-w-30{width:100%!important; max-width:100%!important; min-width:100% !important;}
            .space-w-30 td:first-child{width:100%!important; max-width:100%!important; min-width:100% !important;}
            .remove-479{display:none !important;}
            img{max-width:280px !important;}
            .resize-font, .resize-font *{font-size: 37px !important; line-height: 48px !important;}
        }
        /* End Old CSS */

        @media only screen and (max-width:640px){
            .full-width,.container{width:95%!important; float:none!important; min-width:95%!important; max-width:95%!important; margin:0 auto!important; padding-left:15px; padding-right:15px; text-align: center!important; clear: both;}
            #mainStructure, #mainStructure .full-width .full-width,table .full-width .full-width, .container .full-width{width:100%!important; float:none!important; min-width:100%!important; max-width:100%!important; margin:0 auto!important; clear: both; padding-left:0; padding-right:0;}
            .no-pad{padding:0!important;}
            .full-block{display:block!important;}
            .image-full-width,
            .image-full-width img{width:100%!important; height:auto!important; max-width:100%!important; min-width: 100px !important;}
            .full-width.fix-800{min-width:auto!important;}
            .remove-block{display:none !important; padding-top:0px; padding-bottom:0px;}
            .pad-lr-20{padding-left:20px!important; padding-right:20px!important;}
            .row{display:table-row!important;}
        }

        @media only screen and (max-width:480px){
            .full-width,.container{width:95%!important; float:none!important; min-width:95%!important; max-width:95%!important; margin:0 auto!important; padding-left:15px; padding-right:15px; text-align: center!important; clear: both;}
            #mainStructure, #mainStructure .full-width .full-width,table .full-width .full-width,.container .full-width{width:100%!important; float:none!important; min-width:100%!important; max-width:100%!important; margin:0 auto!important; clear: both; padding-left:0; padding-right:0;}
            .no-pad{padding:0!important;}
            .full-block{display:block!important;}
            .image-full-width,
            .image-full-width img{width:100%!important; height:auto!important; max-width:100%!important; min-width: 100px !important;}
            .full-width.fix-800{min-width:auto!important;}
            .remove-block{display:none !important; padding-top:0px; padding-bottom:0px;}
            .pad-lr-20{padding-left:20px!important; padding-right:20px!important;}
            .row{display:table-row!important;}
        }

        td ul{list-style: initial; margin:0; padding-left:20px;}

        body{background-color:#ffffff; margin: 0 auto !important; height:auto!important;} #preview-template #mainStructure{padding:20px 0px 60px 0px!important;} .default-edit-image{height:20px;} tr.tpl-repeatblock , tr.tpl-repeatblock > td{ display:block !important;} .tpl-repeatblock {padding: 0px !important;border: 1px dotted rgba(0,0,0,0.2); }

        @media only screen and (max-width: 640px){ .full-block{display:table !important; padding-top:0px; padding-bottom:0px;} .row{display:table-row!important;} .image-100-percent img{ width:100%!important; height: auto !important; max-width: 100% !important; min-width: 124px !important;}}

        @media only screen and (max-width: 480px){ .full-block{display:table !important; padding-top:0px; padding-bottom:0px;} .row{display:table-row!important;}}


        *[x-apple-data-detectors], .unstyle-auto-detected-links *,

        .aBn{border-bottom: 0 !important; cursor: default !important;color: inherit !important; text-decoration: none !important;font-size: inherit !important; font-family: inherit !important; font-weight: inherit !important;line-height: inherit !important;}

        .im {color: inherit !important;}

        .a6S {display: none !important; opacity: 0.01 !important;}

        img.g-img + div {display: none !important;}

        img {height: auto !important; line-height: 100%; outline: none; text-decoration: none !important; -ms-interpolation-mode:bicubic;}

        a img{ border: 0 !important;}

        a:active{color:initial } a:visited{color:initial }

        span a ,a {color:inherit; text-decoration: none !important;}

        .tpl-content{padding:0 !important;}

        table td {border-collapse:unset;}

        table p {margin:0;}

        #mainStructure table,#mainStructure img{min-width:0!important;}

        #mainStructure{padding:0 !important;}

        .row th{display:table-cell;}

        .row{display:flex;}

    </style>
</head>
<body  style="font-size:12px; width:100%; height:100%;">
    <table id="mainStructure" class="full-width" width="800" align="center" border="0" cellspacing="0" cellpadding="0" style="background-color: #ffffff; max-width: 800px; outline: rgb(239, 239, 239) solid 1px; box-shadow: rgb(224, 224, 224) 0px 0px 30px 5px; margin: 0px auto;" bgcolor="#ffffff">
        <!--START LAYOUT-1 ( LOGO / MENU )-->
        <tr>
            <td align="center" valign="top" class="full-width" style="background-color: #fff;" bgcolor="#ffffff">
                <!-- start container -->
                <table width="600" align="center" border="0" cellspacing="0" cellpadding="0" class="full-width" style="background-color: #ffffff; margin: 0px auto; width: 600px; min-width: 320px; max-width: 90%;" role="presentation" bgcolor="#ffffff">
                    <tr>
                        <td valign="top">
                            <table width="560" border="0" cellspacing="0" cellpadding="0" align="center" class="full-width" style="margin: 0px auto; width: 560px; min-width: 280px; max-width: 90%;" role="presentation">
                                <!-- start space -->
                                <tr>
                                    <td valign="top" height="30" style="height: 30px; font-size: 0px; line-height: 0;" aria-hidden="true">&nbsp;</td>
                                </tr><!-- end space -->
                                <tr>
                                    <td valign="top">
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" style="margin: 0px auto; min-width: 100%;" role="presentation">
                                            <tr class="row" style="display: flex; text-align: center;">
                                                <th valign="middle" class="full-block" style="display: inline !important;">
                                                    <table width="auto" align="left" border="0" cellspacing="0" cellpadding="0" class="full-width left" role="presentation" style="min-width: 100%;">
                                                        <tr>
                                                            <td align="center" valign="top" style="padding-bottom: 5px; padding-top: 5px; width: 136px; line-height: 0px;" width="136"> <a href="#" style="text-decoration: none !important; font-size: inherit; border-style: none;" border="0"> <img src="http://vitalea.com.co/images/20190824050732_logo-vitalea.png" width="136" style="max-width: 240px; display: block !important; width: 136px; height: auto;" alt="logo-top" border="0" hspace="0" vspace="0" height="auto"></a> </td>
                                                        </tr>
                                                    </table>
                                                </th>
                                                <th valign="middle" class="full-block" style="display: inline !important; margin: auto;">
                                                    <table width="25" border="0" cellpadding="0" cellspacing="0" align="left" class="full-width left" style="max-width: 25px; border-spacing: 0px; min-width: 100%;" role="presentation">
                                                        <tr>
                                                            <td height="20" width="25" style="border-collapse: collapse; height: 20px; font-size: 0px; line-height: 0;" aria-hidden="true">&nbsp;</td>
                                                        </tr>
                                                    </table>
                                                </th>
                                                <th valign="middle" class="full-block" style="display: inline !important;">
                                                    <table width="auto" align="right" border="0" cellpadding="0" cellspacing="0" class="full-width right" role="presentation" style="min-width: 100%;">
                                                        <tr>
                                                            <td valign="top" align="center">
                                                                <table width="auto" align="center" border="0" cellpadding="0" cellspacing="0" style="margin: 0px auto;mso-table-lspace:0pt; mso-table-rspace:0pt;" role="presentation">
                                                                    <tr class="row" style="display: flex; text-align: center;">
                                                                        <th valign="top" align="center" class="full-block" style="margin: 0px auto; display: inline !important;">
                                                                            <table width="auto" align="center" border="0" cellpadding="0" cellspacing="0" style="margin: 0px auto; min-width: 100%;" class="full-width" role="presentation">
                                                                                <tr>
                                                                                    <td style="padding: 5px 10px;">
                                                                                        <table width="100%" border="0" cellpadding="0" cellspacing="0" style="margin: 0px auto; min-width: 100%;" align="center" role="presentation">
                                                                                            <tr>
                                                                                                <td align="left" valign="middle" width="auto">
                                                                                                    <table width="auto" align="left" border="0" cellpadding="0" cellspacing="0" style="vertical-align:middle;mso-table-lspace:0pt; mso-table-rspace:0pt;" role="presentation">
                                                                                                        <tr>
                                                                                                            <td align="left" valign="top" style="padding-right: 10px; width: 18px; line-height: 0px;" width="18"> <img src="http://vitalea.com.co/images/20190916210242_ico_cell.png" width="18" style="max-width: 18px; display: block !important; width: 18px; height: auto;" vspace="0" hspace="0" alt="icon-phone" height="auto"></td>
                                                                                                        </tr>
                                                                                                    </table>
                                                                                                </td>
                                                                                                <td align="left" style="font-size: 14px; color: #333333; font-weight: normal; font-family: 'Open Sans', Arial, Helvetica, sans-serif; word-break: break-word; line-height: 1;"><a href="https://api.whatsapp.com/send?phone=573187120062" data-mce-href="https://api.whatsapp.com/send?phone=573187120062" target="_blank" style="border-style: none; text-decoration: none !important; line-height: 24px; font-size: 14px; font-weight: 400; font-family: 'Open Sans', Arial, Helvetica, sans-serif;" border="0"><span style="color: #333333; font-style: normal; text-align: left; line-height: 24px; font-size: 14px; font-weight: 400; font-family: 'Open Sans', Arial, Helvetica, sans-serif;"><span style="font-style: normal; text-align: left; color: #333333; line-height: 24px; font-size: 14px; font-weight: 400; font-family: 'Open Sans', Arial, Helvetica, sans-serif;">WhatsApp</span></span></a></td>
                                                                                            </tr>
                                                                                        </table>
                                                                                    </td>
                                                                                </tr>
                                                                            </table>
                                                                        </th>
                                                                        <th valign="top" align="center" class="full-block" style="margin: 0px auto; display: inline !important;">
                                                                            <table width="auto" align="center" border="0" cellpadding="0" cellspacing="0" style="margin: 0px auto; min-width: 100%;" class="full-width" role="presentation">
                                                                                <tr>
                                                                                    <td style="padding: 5px 10px;">
                                                                                        <table width="100%" border="0" cellpadding="0" cellspacing="0" style="margin: 0px auto; min-width: 100%;" align="center" role="presentation">
                                                                                            <tr>
                                                                                                <td align="left" valign="middle" width="auto">
                                                                                                    <table width="auto" align="left" border="0" cellpadding="0" cellspacing="0" style="vertical-align:middle;mso-table-lspace:0pt; mso-table-rspace:0pt;" role="presentation">
                                                                                                        <tr>
                                                                                                            <td align="left" valign="top" style="padding-right: 10px; width: 18px; line-height: 0px;" width="18"> <img src="http://vitalea.com.co/images/20190916210242_ico_cell.png" width="18" style="max-width: 18px; display: block !important; width: 18px; height: auto;" vspace="0" hspace="0" alt="icon-phone" height="auto"></td>
                                                                                                        </tr>
                                                                                                    </table>
                                                                                                </td>
                                                                                                <td align="left" style="font-size: 14px; color: #333333; font-weight: normal; font-family: 'Open Sans', Arial, Helvetica, sans-serif; word-break: break-word; line-height: 1;"><span style="font-style: normal; text-align: left; color: #333333; line-height: 24px; font-size: 14px; font-weight: 400; font-family: Montserrat, arial, sans-serif;"><span style="font-style: normal; text-align: left; color: #333333; line-height: 24px; font-size: 14px; font-weight: 400; font-family: Montserrat, arial, sans-serif;">8051348</span></span></td>
                                                                                            </tr>
                                                                                        </table>
                                                                                    </td>
                                                                                </tr>
                                                                            </table>
                                                                        </th>
                                                                        <th valign="top" align="center" class="full-block" style="margin: 0px auto; display: inline !important;">
                                                                            <table width="auto" align="center" border="0" cellpadding="0" cellspacing="0" style="margin: 0px auto; min-width: 100%;" class="full-width" role="presentation">
                                                                                <tr>
                                                                                    <td style="padding: 5px 10px;">
                                                                                        <table width="100%" border="0" cellpadding="0" cellspacing="0" style="margin: 0px auto; min-width: 100%;" align="center" role="presentation">
                                                                                            <tr>
                                                                                                <td align="left" valign="middle" width="auto">
                                                                                                    <table width="auto" align="left" border="0" cellpadding="0" cellspacing="0" style="vertical-align:middle;mso-table-lspace:0pt; mso-table-rspace:0pt;" role="presentation">
                                                                                                        <tr>
                                                                                                            <td align="left" valign="top" style="padding-right: 10px; width: 18px; line-height: 0px;" width="18"> <img src="http://vitalea.com.co/images/20190916210242_ico_web.png" width="18" style="max-width: 18px; display: block !important; width: 18px; height: auto;" vspace="0" hspace="0" alt="icon-world" height="auto"></td>
                                                                                                        </tr>
                                                                                                    </table>
                                                                                                </td>
                                                                                                <td align="left" style="font-size: 14px; color: #333333; font-weight: normal; font-family: 'Open Sans', Arial, Helvetica, sans-serif; word-break: break-word; line-height: 1;"><a data-mce-href="https://www.vitalea.co/" href="https://www.vitalea.co/" title="Sitio web Vitalea" style="border-style: none; text-decoration: none !important; line-height: 24px; font-size: 14px; font-weight: 400; font-family: 'Open Sans', Arial, Helvetica, sans-serif;" target="_blank" border="0"><span style="color: #333333; font-style: normal; text-align: left; line-height: 24px; font-size: 14px; font-weight: 400; font-family: 'Open Sans', Arial, Helvetica, sans-serif;">www.vitalea.co</span></a></td>
                                                                                            </tr>
                                                                                        </table>
                                                                                    </td>
                                                                                </tr>
                                                                            </table>
                                                                        </th>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </th>
                                            </tr>
                                        </table>
                                    </td>
                                </tr><!-- start space -->
                                <tr>
                                    <td valign="top" height="20" style="height: 20px; font-size: 0px; line-height: 0;" aria-hidden="true">&nbsp;</td>
                                </tr><!-- end space -->
                            </table>
                        </td>
                    </tr>
                </table><!-- end container -->
            </td>
        </tr>
        <!--END LAYOUT-1 ( LOGO / MENU )-->
        <!-- START LAYOUT-2 ( BIG IMAGE ) -->
        <tr>
            <td align="center" valign="top" style="background-color: #fff;" bgcolor="#ffffff">
                <!-- start container -->
                <table width="600" align="center" border="0" cellspacing="0" cellpadding="0" class="full-width clear-pad" style="background-color: #ffffff; margin: 0px auto; width: 600px; min-width: 320px; max-width: 90%;" role="presentation" bgcolor="#ffffff">
                    <!-- start big image -->
                    <tr>
                        <td valign="top">
                            <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0" style="margin: 0px auto; min-width: 100%;" role="presentation">
                                <tr>
                                    <td align="center" valign="middle" class="image-full-width" width="600" style="width: 600px; line-height: 0px;"> <img src="http://vitalea.com.co/images/20190824050147_bg.png" width="600" style="height: auto; display: block !important; width: 100%; max-width: 600px; min-width: 100%;" alt="image" border="0" hspace="0" vspace="0" height="auto"></td>
                                </tr>
                            </table>
                        </td>
                    </tr><!-- end big image -->
                </table><!-- end container -->
            </td>
        </tr><!-- END LAYOUT-2 ( BIG IMAGE ) -->
        <!-- END LAYOUT-3 ( TITLE-CONTENT / BUTTON ) -->
        <tr>
            <td align="center" valign="top" style="background-color: #fff;" bgcolor="#ffffff">
                <!-- start container -->
                <table width="600" align="center" border="0" cellspacing="0" cellpadding="0" class="full-width" style="background-color: #ffffff; margin: 0px auto; width: 600px; min-width: 320px; max-width: 90%;" role="presentation" bgcolor="#ffffff">
                    <tr>
                        <td valign="top" align="center">
                            <table width="560" border="0" cellspacing="0" cellpadding="0" align="center" class="full-width" style="margin: 0px auto; width: 560px; min-width: 280px; max-width: 90%;" role="presentation">
                                <!-- start space -->
                                <tr>
                                    <td valign="top" height="45" style="height: 45px; font-size: 0px; line-height: 0;" aria-hidden="true">&nbsp;</td>
                                </tr><!-- end space -->
                                <tr>
                                    <td valign="top" align="center">
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" style="margin: 0px auto; min-width: 100%;" role="presentation">
                                            <!-- start title -->
                                            <tr>
                                                <td valign="top" align="center">
                                                    <table width="100%" align="center" border="0" cellspacing="0" cellpadding="0" style="margin: 0px auto; min-width: 100%;" role="presentation">
                                                        <tr>
                                                            <td align="center" style="font-size: 20px; color: #333333; font-weight: bold; font-family: 'Open Sans', Arial, Helvetica, sans-serif; word-break: break-word; line-height: 24px;"></td>
                                                        </tr><!-- start space -->
                                                        <tr>
                                                            <td valign="top" height="15" style="height: 15px; font-size: 0px; line-height: 0;" aria-hidden="true">&nbsp;</td>
                                                        </tr><!-- end space -->
                                                        <tr>
                                                            <td align="center" style="font-size: 28px; color: #333333; font-weight: 300; font-family: 'Open Sans', Arial, Helvetica, sans-serif; word-break: break-word; line-height: 1;">
                                                                <p style="font-size: 28px; font-weight: 300; font-family: 'Open Sans', Arial, Helvetica, sans-serif;"><span style="color: #ec1481; font-style: normal; text-align: center; line-height: 24px; font-size: 18px; font-weight: 300; font-family: Montserrat, arial, sans-serif;"><span style="font-style: normal; text-align: center; color: #ec1481; line-height: 24px; font-size: 18px; font-weight: 300; font-family: Montserrat, arial, sans-serif;">¡Hola $nombre_cliente, la información de tus resultados ya se encuentra lista.!</span></span></p>
                                                            </td>
                                                        </tr><!-- start space -->
                                                        <tr>
                                                            <td valign="top" height="13" style="height: 13px; font-size: 0px; line-height: 0;" aria-hidden="true">&nbsp;</td>
                                                        </tr><!-- end space -->
                                                    </table>
                                                </td>
                                            </tr><!-- end title -->
                                            <!-- start content -->
                                            <tr>
                                                <td valign="top">
                                                    <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0" style="margin: 0px auto; min-width: 100%;" role="presentation">
                                                        <tr>
                                                            <td align="center" style="font-size: 14px; color: #888888; font-weight: normal; font-family: 'Open Sans', Arial, Helvetica, sans-serif; word-break: break-word; line-height: 1;">
                                                                <p style="font-size: 14px; font-weight: 400; font-family: 'Open Sans', Arial, Helvetica, sans-serif;"><span style="color: #888888; font-style: normal; text-align: center; line-height: 24px; font-size: 14px; font-weight: 400; font-family: Montserrat, arial, sans-serif;"><span style="font-style: normal; text-align: center; color: #888888; line-height: 24px; font-size: 14px; font-weight: 400; font-family: Montserrat, arial, sans-serif;">Ingresa a la pagina de vitalea : <a href="https://vitalea.co/">vitalea.co</a> e ingresa a la sección de acceso a usuarios para ingresar y ver la información de tus resultados.</span></span><br><span style="color: #888888; font-style: normal; text-align: center; line-height: 24px; font-size: 10px; font-weight: 400; font-family: Montserrat, arial, sans-serif;"></span></p>
                                                            </td>
                                                        </tr><!-- start space -->
                                                        <tr>
                                                            <td valign="top" height="30" style="height: 30px; font-size: 0px; line-height: 0;" aria-hidden="true">&nbsp;</td>
                                                        </tr><!-- end space -->
                                                    </table>
                                                </td>
                                            </tr><!-- end content -->
                                            <!--start button-->
                                            <tr>
                                                <td valign="top" align="center">
                                                    <table width="auto" align="center" border="0" cellspacing="0" cellpadding="0" style="margin: 0px auto;mso-table-lspace:0pt; mso-table-rspace:0pt;" role="presentation">
                                                        <tr>
                                                            <!-- start duplicate button -->
                                                            <td valign="top" class="full-block">
                                                                <table width="auto" border="0" align="center" cellpadding="0" cellspacing="0" style="margin: 0px auto;mso-table-lspace:0pt; mso-table-rspace:0pt;" role="presentation">
                                                                    <tr>
                                                                        <td valign="top" style="padding-top:5px; padding-bottom:5px; padding-left:5px; padding-right:5px;">
                                                                            <table width="auto" border="0" align="center" cellpadding="0" cellspacing="0" style="border-radius: 5px; background-color: #ec1481; margin: 0px auto;mso-table-lspace:0pt; mso-table-rspace:0pt;" role="presentation" bgcolor="#ec1481">
                                                                                <tr>
                                                                                    <td width="auto" align="center" valign="middle" height="45" style="font-size: 14px; color: #ffffff; font-weight: normal; font-family: 'Open Sans', Arial, Helvetica, sans-serif; word-break: break-word; background-clip: padding-box; padding-left: 25px; padding-right: 25px; line-height: 1;"><span style="color: #ffffff; font-style: normal; text-align: center; line-height: 24px; font-size: 14px; font-weight: 400; font-family: Montserrat, arial, sans-serif;"><a href="https://vitalea.co/users/sign_in" target="_blank" title="Vitalea " data-mce-href="https://vitalea.co/users/sign_in" style="border-style: none; text-decoration: none !important; line-height: 24px; font-size: 14px; font-weight: 400; font-family: Montserrat, arial, sans-serif;" border="0"><span style="color: #ffffff; font-style: normal; text-align: center; line-height: 24px; font-size: 14px; font-weight: 400; font-family: Montserrat, arial, sans-serif;">&nbsp;Acceso de usuario a vitalea</span></a></span></td>
                                                                                </tr>
                                                                            </table>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </td> <!-- end duplicate button -->
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <!--end button-->
                                        </table>
                                    </td>
                                </tr><!-- start space -->
                                <tr>
                                    <td valign="top" height="14" style="height: 14px; font-size: 0px; line-height: 0;" aria-hidden="true">&nbsp;</td>
                                </tr><!-- end space -->
                            </table>
                        </td>
                    </tr>
                </table><!-- end container -->
            </td>
        </tr><!-- END LAYOUT-3 ( TITLE-CONTENT / BUTTON ) -->
       
      
        <!-- END LAYOUT-3 ( TITLE-CONTENT / BUTTON ) -->
        <tr>
            <td align="center" valign="top" style="background-color: #fff;" bgcolor="#ffffff">
                <!-- start container -->
                <table width="600" align="center" border="0" cellspacing="0" cellpadding="0" class="full-width" style="background-color: #ffffff; margin: 0px auto; width: 600px; min-width: 320px; max-width: 90%;" role="presentation" bgcolor="#ffffff">
                    <tr>
                        <td valign="top" align="center">
                            <table width="560" border="0" cellspacing="0" cellpadding="0" align="center" class="full-width" style="margin: 0px auto; width: 560px; min-width: 280px; max-width: 90%;" role="presentation">
                                <!-- start space -->
                                <tr>
                                    <td valign="top" height="20" style="height: 20px; font-size: 0px; line-height: 0;" aria-hidden="true">&nbsp;</td>
                                </tr><!-- end space -->
                                <tr>
                                    <td valign="top" align="center">
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" style="margin: 0px auto; min-width: 100%;" role="presentation">
                                            <!-- start title -->
                                            <!-- end title -->
                                            <!-- start content -->
                                            <tr>
                                                <td valign="top">
                                                    <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0" style="margin: 0px auto; min-width: 100%;" role="presentation">
                                                        <tr>
                                                            <td align="center" style="font-size: 14px; color: #888888; font-weight: normal; font-family: 'Open Sans', Arial, Helvetica, sans-serif; word-break: break-word; line-height: 1;">
                                                                <p style="font-size: 14px; font-weight: 400; font-family: 'Open Sans', Arial, Helvetica, sans-serif;"><span style="font-style: normal; text-align: center; color: #888888; line-height: 24px; font-size: 14px; font-weight: 400; font-family: Montserrat, arial, sans-serif;"><span style="font-style: normal; text-align: center; color: #888888; line-height: 24px; font-size: 14px; font-weight: 400; font-family: Montserrat, arial, sans-serif;">Aprende a conocer, evaluar y entender que ocurre con tu cuerpo.</span></span></p>
                                                                <p style="font-size: 14px; font-weight: 400; font-family: 'Open Sans', Arial, Helvetica, sans-serif;"><span style="font-style: normal; text-align: center; color: #888888; line-height: 24px; font-size: 14px; font-weight: 400; font-family: Montserrat, arial, sans-serif;"><span style="font-style: normal; text-align: center; color: #888888; line-height: 24px; font-size: 14px; font-weight: 400; font-family: Montserrat, arial, sans-serif;"><strong style="font-size: 14px; font-weight: 700; font-family: Montserrat, arial, sans-serif;">Somos una guía para que junto con tu médico</strong></span></span></p>
                                                                <p style="font-size: 14px; font-weight: 400; font-family: 'Open Sans', Arial, Helvetica, sans-serif;"><span style="font-style: normal; text-align: center; color: #888888; line-height: 24px; font-size: 14px; font-weight: 400; font-family: Montserrat, arial, sans-serif;"><span style="font-style: normal; text-align: center; color: #888888; line-height: 24px; font-size: 14px; font-weight: 400; font-family: Montserrat, arial, sans-serif;"><strong style="font-size: 14px; font-weight: 700; font-family: Montserrat, arial, sans-serif;">realices el correcto seguimiento de tu salud.</strong></span></span></p>
                                                            </td>
                                                        </tr><!-- start space -->
                                                        <tr>
                                                            <td valign="top" height="3" style="height: 3px; font-size: 0px; line-height: 0;" aria-hidden="true">&nbsp;</td>
                                                        </tr><!-- end space -->
                                                    </table>
                                                </td>
                                            </tr><!-- end content -->
                                            <!--start button-->
                                            <tr>
                                                <td valign="top" align="center">
                                                    <table width="auto" align="center" border="0" cellspacing="0" cellpadding="0" style="margin: 0px auto;mso-table-lspace:0pt; mso-table-rspace:0pt;" role="presentation">
                                                        <tr>
                                                            <!-- start duplicate button -->
                                                            <!-- end duplicate button -->
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <!--end button-->
                                        </table>
                                    </td>
                                </tr><!-- start space -->
                                <tr>
                                    <td valign="top" height="2" style="height: 2px; font-size: 0px; line-height: 0;" aria-hidden="true">&nbsp;</td>
                                </tr><!-- end space -->
                            </table>
                        </td>
                    </tr>
                </table><!-- end container -->
            </td>
        </tr><!-- END LAYOUT-3 ( TITLE-CONTENT / BUTTON ) -->
        <!-- END LAYOUT-3 ( TITLE-CONTENT / BUTTON ) -->
        <tr>
            <td align="center" valign="top" style="background-color: #fff;" bgcolor="#ffffff">
                <!-- start container -->
                <table width="600" align="center" border="0" cellspacing="0" cellpadding="0" class="full-width" style="background-color: #ffffff; margin: 0px auto; width: 600px; min-width: 320px; max-width: 90%;" role="presentation" bgcolor="#ffffff">
                    <tr>
                        <td valign="top" align="center">
                            <table width="560" border="0" cellspacing="0" cellpadding="0" align="center" class="full-width" style="margin: 0px auto; width: 560px; min-width: 280px; max-width: 90%;" role="presentation">
                                <!-- start space -->
                                <tr>
                                    <td valign="top" height="4" style="height: 4px; font-size: 0px; line-height: 0;" aria-hidden="true">&nbsp;</td>
                                </tr><!-- end space -->
                                <tr>
                                    <td valign="top" align="center">
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" style="margin: 0px auto; min-width: 100%;" role="presentation">
                                            <!-- start title -->
                                            <tr>
                                                <td valign="top" align="center">
                                                    <table width="100%" align="center" border="0" cellspacing="0" cellpadding="0" style="margin: 0px auto; min-width: 100%;" role="presentation">
                                                        <tr>
                                                            <td align="center" style="font-size: 20px; color: #333333; font-weight: bold; font-family: 'Open Sans', Arial, Helvetica, sans-serif; word-break: break-word; line-height: 24px;"></td>
                                                        </tr><!-- start space -->
                                                        <tr>
                                                            <td valign="top" height="2" style="height: 2px; font-size: 0px; line-height: 0;" aria-hidden="true">&nbsp;</td>
                                                        </tr><!-- end space -->
                                                        <tr>
                                                            <td align="center" style="font-size: 28px; color: #333333; font-weight: 300; font-family: 'Open Sans', Arial, Helvetica, sans-serif; word-break: break-word; line-height: 1;">
                                                                <p style="font-size: 28px; font-weight: 300; font-family: 'Open Sans', Arial, Helvetica, sans-serif;"><span style="color: #ec1481; font-style: normal; text-align: center; line-height: 24px; font-size: 18px; font-weight: 300; font-family: Montserrat, arial, sans-serif;"><span style="font-style: normal; text-align: center; color: #ec1481; line-height: 24px; font-size: 18px; font-weight: 300; font-family: Montserrat, arial, sans-serif;">¡Tenemos uno ideal para tus necesidades!</span></span></p>
                                                            </td>
                                                        </tr><!-- start space -->
                                                        <tr>
                                                            <td valign="top" height="13" style="height: 13px; font-size: 0px; line-height: 0;" aria-hidden="true">&nbsp;</td>
                                                        </tr><!-- end space -->
                                                    </table>
                                                </td>
                                            </tr><!-- end title -->
                                            <!-- start content -->
                                            <tr>
                                                <td valign="top">
                                                    <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0" style="margin: 0px auto; min-width: 100%;" role="presentation">
                                                        <tr>
                                                            <td align="center" style="font-size: 14px; color: #888888; font-weight: normal; font-family: 'Open Sans', Arial, Helvetica, sans-serif; word-break: break-word; line-height: 1;">
                                                                <p style="font-size: 14px; font-weight: 400; font-family: 'Open Sans', Arial, Helvetica, sans-serif;"><span style="font-style: normal; text-align: center; color: #888888; line-height: 24px; font-size: 14px; font-weight: 400; font-family: Montserrat, arial, sans-serif;"><span style="font-style: normal; text-align: center; color: #888888; line-height: 24px; font-size: 14px; font-weight: 400; font-family: Montserrat, arial, sans-serif;">¿Dudas adicionales?</span></span></p>
                                                            </td>
                                                        </tr><!-- start space -->
                                                        <tr>
                                                            <td valign="top" height="10" style="height: 10px; font-size: 0px; line-height: 0;" aria-hidden="true">&nbsp;</td>
                                                        </tr><!-- end space -->
                                                    </table>
                                                </td>
                                            </tr><!-- end content -->
                                            <!--start button-->
                                            <tr>
                                                <td valign="top" align="center">
                                                    <table width="auto" align="center" border="0" cellspacing="0" cellpadding="0" style="margin: 0px auto;mso-table-lspace:0pt; mso-table-rspace:0pt;" role="presentation">
                                                        <tr>
                                                            <!-- start duplicate button -->
                                                            <td valign="top" class="full-block">
                                                                <table width="auto" border="0" align="center" cellpadding="0" cellspacing="0" style="margin: 0px auto;mso-table-lspace:0pt; mso-table-rspace:0pt;" role="presentation">
                                                                    <tr>
                                                                        <td valign="top" style="padding-top:5px; padding-bottom:5px; padding-left:5px; padding-right:5px;">
                                                                            <table width="auto" border="0" align="center" cellpadding="0" cellspacing="0" style="border-radius: 5px; background-color: #ec1481; margin: 0px auto;mso-table-lspace:0pt; mso-table-rspace:0pt;" role="presentation" bgcolor="#ec1481">
                                                                                <tr>
                                                                                    <td width="auto" align="center" valign="middle" height="45" style="font-size: 14px; color: #ffffff; font-weight: normal; font-family: 'Open Sans', Arial, Helvetica, sans-serif; word-break: break-word; background-clip: padding-box; padding-left: 25px; padding-right: 25px; line-height: 1;"><span style="color: #ffffff; font-style: normal; text-align: center; line-height: 24px; font-size: 14px; font-weight: 400; font-family: Montserrat, arial, sans-serif;"><a href="https://api.whatsapp.com/send?phone=573187120062" target="_blank" data-mce-href="https://api.whatsapp.com/send?phone=573187120062" style="border-style: none; text-decoration: none !important; line-height: 24px; font-size: 14px; font-weight: 400; font-family: Montserrat, arial, sans-serif;" border="0"><span style="color: #ffffff; font-style: normal; text-align: center; line-height: 24px; font-size: 14px; font-weight: 400; font-family: Montserrat, arial, sans-serif;">Contáctanos ya por WhatsApp</span></a><span id="_mce_caret" data-mce-bogus="1" style="color: #ffffff; font-style: normal; text-align: center; line-height: 24px; font-size: 14px; font-weight: 400; font-family: Montserrat, arial, sans-serif;"><span data-mce-bogus="1" style="color: #ffffff; font-style: normal; text-align: center; line-height: 24px; font-size: 14px; font-weight: 400; font-family: Montserrat, arial, sans-serif;">﻿</span></span></span></td>
                                                                                </tr>
                                                                            </table>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </td> <!-- end duplicate button -->
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <!--end button-->
                                        </table>
                                    </td>
                                </tr><!-- start space -->
                                <tr>
                                    <td valign="top" height="14" style="height: 14px; font-size: 0px; line-height: 0;" aria-hidden="true">&nbsp;</td>
                                </tr><!-- end space -->
                            </table>
                        </td>
                    </tr>
                </table><!-- end container -->
            </td>
        </tr><!-- END LAYOUT-3 ( TITLE-CONTENT / BUTTON ) -->
        <!-- START LAYOUT-8 ( ICON-CENTRE / HEADING / TEXT ) -->
        <tr>
            <td valign="top" align="center" style="background-color: #ffffff;" bgcolor="#ffffff">
                <!-- start container -->
                <table width="600" align="center" border="0" cellspacing="0" cellpadding="0" class="full-width" style="background-color: #ffffff; margin: 0px auto; width: 600px; min-width: 320px; max-width: 90%;" role="presentation" bgcolor="#ffffff">
                    <!-- start heading text -->
                    <tr>
                        <td valign="top" align="center">
                            <table width="560" align="center" border="0" cellpadding="0" cellspacing="0" class="full-width" style="margin: 0px auto; width: 560px; min-width: 280px; max-width: 90%;" role="presentation">
                                <!-- start space -->
                                <tr>
                                    <td valign="top" height="32" style="height: 32px; font-size: 0px; line-height: 0;" aria-hidden="true">&nbsp;</td>
                                </tr><!-- end space -->
                                <!-- start image -->
                                <tr>
                                    <td valign="top">
                                        <table width="auto" align="center" border="0" cellspacing="0" cellpadding="0" style="margin: 0px auto;mso-table-lspace:0pt; mso-table-rspace:0pt;" role="presentation">
                                            <tr>
                                                <td align="center" valign="top" class="image-full-width" width="400" style="width: 400px;"> <a href="#" style="text-decoration: none !important; font-size: inherit; border-style: none;" border="0"> <img src="http://vitalea.com.co/images/20190730001053_logo.jpg" width="400" style="height: auto; display: block !important; width: 100%; max-width: 400px; min-width: 100%;" vspace="0" hspace="0" alt="image" height="auto"></a> </td>
                                            </tr><!-- start space -->
                                            <tr>
                                                <td valign="top" height="10" style="height: 10px; font-size: 0px; line-height: 0;" aria-hidden="true">&nbsp;</td>
                                            </tr><!-- end space -->
                                        </table>
                                    </td>
                                </tr><!-- end image -->
                                <!-- start title -->
                                <!-- end title -->
                                <!-- start image -->
                                <!-- end image -->
                            </table>
                        </td>
                    </tr><!-- end heading text -->
                </table><!-- end container -->
            </td>
        </tr><!-- END LAYOUT-8 ( ICON-CENTRE / HEADING / TEXT ) -->
        <!-- START LAYOUT-5 ( CONTENT/SOCIAL ) -->
        <tr>
            <td valign="top" align="center" style="background-color: #fff;" bgcolor="#ffffff">
                <table width="600" align="center" border="0" cellspacing="0" cellpadding="0" class="full-width" style="background-color: #ffffff; margin: 0px auto; width: 600px; min-width: 320px; max-width: 90%;" role="presentation" bgcolor="#ffffff">
                    <!-- start space -->
                    <tr>
                        <td valign="top" height="10" style="height: 10px; font-size: 0px; line-height: 0;" aria-hidden="true">&nbsp;</td>
                    </tr><!-- end space -->
                    <!-- start width 600px -->
                    <tr>
                        <td valign="top">
                            <table width="560" align="center" class="full-width" border="0" cellpadding="0" cellspacing="0" style="margin: 0px auto; width: 560px; min-width: 280px; max-width: 90%;" role="presentation">
                                <!-- start content -->
                                <tr>
                                    <td valign="top">
                                        <table width="80%" align="center" border="0" cellspacing="0" cellpadding="0" style="margin: 0px auto;mso-table-lspace:0pt; mso-table-rspace:0pt;" role="presentation">
                                            <tr>
                                                <td align="center" style="font-size: 14px; color: #888888; font-weight: 300; font-family: 'Open Sans', Arial, Helvetica, sans-serif; word-break: break-word; line-height: 1;"><span style="color: #888888; font-style: normal; text-align: center; line-height: 24px; font-size: 11px; font-weight: 300; font-family: 'Open Sans', Arial, Helvetica, sans-serif;"><span style="font-style: normal; text-align: center; color: #888888; line-height: 24px; font-size: 11px; font-weight: 300; font-family: 'Open Sans', Arial, Helvetica, sans-serif;">Recibiste este mail porque estás suscrito al newsletter de Vitălea <a href="https://www.vitalea.co/" data-mce-href="https://www.vitalea.co/" style="border-style: none; text-decoration: none !important; line-height: 24px; font-size: 11px; font-weight: 300; font-family: 'Open Sans', Arial, Helvetica, sans-serif;" border="0">www.vitalea.co</a> &nbsp;Si no deseas recibir nuestro mensaje, puedes darte de baja en este&nbsp;link&nbsp;para cancelar tu suscripción (El proceso puede demorar hasta 2 días hábiles.</span></span></td>
                                            </tr><!-- start space -->
                                            <tr>
                                                <td valign="top" height="30" style="height: 30px; font-size: 0px; line-height: 0;" aria-hidden="true">&nbsp;</td>
                                            </tr><!-- end space -->
                                        </table>
                                    </td>
                                </tr><!-- end content -->
                                <!-- start icon/text -->
                                <tr>
                                    <td valign="top">
                                        <table width="auto" border="0" cellspacing="0" cellpadding="0" align="center" style="table-layout: fixed; margin: 0px auto;mso-table-lspace:0pt; mso-table-rspace:0pt;" role="presentation">
                                            <tr class="row" style="display: flex; text-align: center;">
                                                <!-- start duplicate icon -->
                                                <th valign="top" class="full-block" style="padding-bottom: 10px; padding-left: 8px; padding-right: 8px; margin: 0px auto; display: inline !important;">
                                                    <table width="auto" align="left" border="0" cellpadding="0" cellspacing="0" style="margin: 0px auto; min-width: 100%;" class="full-width" role="presentation">
                                                        <tr>
                                                            <td align="left" valign="middle" style="padding-right: 8px; width: 18px; line-height: 0px;" width="18"> <img src="http://vitalea.com.co/images/set16-icon-Fb.png" width="18" style="max-width:18px; display:block !important;" alt="set16-icon-Fb" border="0" hspace="0" vspace="0"></td>
                                                            <td align="left" style="font-size: 14px; color: #888888; font-weight: 300; font-family: 'Open Sans', Arial, Helvetica, sans-serif; word-break: break-word; line-height: 1;"> <span style="text-decoration: none; color: #888888; font-style: normal; text-align: left; line-height: 24px; font-size: 14px; font-weight: 300; font-family: 'Open Sans', Arial, Helvetica, sans-serif;"> <a href="#" style="color: #888888; text-decoration: none !important; border-style: none; line-height: 24px; font-size: 14px; font-weight: 300; font-family: 'Open Sans', Arial, Helvetica, sans-serif;" border="0">Facebook</a> </span> </td>
                                                        </tr>
                                                    </table>
                                                </th>
                                                <th valign="top" class="full-block" style="padding-bottom: 10px; padding-left: 8px; padding-right: 8px; margin: 0px auto; display: inline !important;">
                                                    <table width="auto" align="left" border="0" cellpadding="0" cellspacing="0" style="margin: 0px auto; min-width: 100%;" class="full-width" role="presentation">
                                                        <tr>
                                                            <td align="left" valign="middle" style="padding-right: 8px; width: 18px; line-height: 0px;" width="18"> <img src="http://vitalea.com.co/images/set16-icon-Tw.png" width="18" style="max-width:18px; display:block !important;" alt="set16-icon-Tw" border="0" hspace="0" vspace="0"></td>
                                                            <td align="left" style="font-size: 14px; color: #888888; font-weight: 300; font-family: 'Open Sans', Arial, Helvetica, sans-serif; word-break: break-word; line-height: 1;"> <span style="text-decoration: none; color: #888888; font-style: normal; text-align: left; line-height: 24px; font-size: 14px; font-weight: 300; font-family: 'Open Sans', Arial, Helvetica, sans-serif;"> <a href="#" style="color: #888888; text-decoration: none !important; border-style: none; line-height: 24px; font-size: 14px; font-weight: 300; font-family: 'Open Sans', Arial, Helvetica, sans-serif;" border="0">Twitter</a> </span> </td>
                                                        </tr>
                                                    </table>
                                                </th>
                                                <th valign="top" class="full-block" style="padding-bottom: 10px; padding-left: 8px; padding-right: 8px; margin: 0px auto; display: inline !important;">
                                                    <table width="auto" align="left" border="0" cellpadding="0" cellspacing="0" style="margin: 0px auto; min-width: 100%;" class="full-width" role="presentation">
                                                        <tr>
                                                            <td align="left" valign="middle" style="padding-right: 8px; width: 18px; line-height: 0px;" width="18"> <img src="http://vitalea.com.co/images/set16-icon-In.png" width="18" style="max-width:18px; display:block !important;" alt="set16-icon-In" border="0" hspace="0" vspace="0"></td>
                                                            <td align="left" style="font-size: 14px; color: #888888; font-weight: 300; font-family: 'Open Sans', Arial, Helvetica, sans-serif; word-break: break-word; line-height: 1;"> <span style="text-decoration: none; color: #888888; font-style: normal; text-align: left; line-height: 24px; font-size: 14px; font-weight: 300; font-family: 'Open Sans', Arial, Helvetica, sans-serif;"> <a href="#" style="color: #888888; text-decoration: none !important; border-style: none; line-height: 24px; font-size: 14px; font-weight: 300; font-family: 'Open Sans', Arial, Helvetica, sans-serif;" border="0">Instagram</a> </span> </td>
                                                        </tr>
                                                    </table>
                                                </th> <!-- end duplicate icon -->
                                            </tr><!-- start space -->
                                            <tr>
                                                <td valign="top" height="20" style="height: 20px; font-size: 0px; line-height: 0;" aria-hidden="true">&nbsp;</td>
                                            </tr><!-- end space -->
                                        </table>
                                    </td>
                                </tr><!-- end icon/text -->
                            </table>
                        </td>
                    </tr><!-- end width 600px -->
                    <!-- start space -->
                    <tr>
                        <td valign="top" height="20" style="height: 20px; font-size: 0px; line-height: 0;" aria-hidden="true">&nbsp;</td>
                    </tr><!-- end space -->
                </table>
            </td>
        </tr><!-- END LAYOUT-5 ( CONTENT/SOCIAL ) -->
    </table>
</body>
        
ini;


        $mail->Body = $body; // Mensaje a enviar. 

        $exito = $mail->Send(); // Envía el correo.

        if ($exito) {

            $sql_insertarh_resultado = "INSERT INTO his_envio_resultado(id_resultado,id_usuario_envio,correo_envio)
                                        VALUES(:id_resultado,:id_usuario_envio,:correo_envio)";

            
            $query_hresultado = $this->conexion->prepare($sql_insertarh_resultado);
            $query_hresultado->execute(array(
                ":id_resultado" => $id_resultado,
                ":id_usuario_envio" => $id_usuario,
                ":correo_envio" => $correo_cliente
            ));



            return 1;
        } else {
            return 2;
        }
    }

}
