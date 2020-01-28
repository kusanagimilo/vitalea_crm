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
require_once '../conexion/conexion_bd.php';

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
                                    return "Se Modifico correctamente el documento de resultado y se ingreso el valor de el resultado";
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
                                        return "Ingreso correctamente el resultado";
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
cli.documento,cli.nombre,cli.apellido
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
            $porcentaje = "0%";
            if ($value['estado'] == 2) {
                $retorno_p = $this->DetalleCompletoResultado($value['idventa'], $value['idresultado']);
                $porcentaje = $retorno_p['porcentaje'] . "%";
            }

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
            $arreglo_adicionado[$i]['porcentaje'] = $porcentaje;
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

}
