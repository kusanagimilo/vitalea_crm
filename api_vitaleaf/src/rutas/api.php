<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app = new \Slim\App;

$app->get('/api/examenes_perfiles', function(Request $request, Response $response) {
    $consulta = "SELECT id,nombre FROM examen WHERE activo = 1 AND grupo_id IS NULL";
    try {
        // Instanciar la base de datos
        $db = new db();
        $arreglo_retorno = [];
        // Conexión
        $db = $db->conectar();
        $ejecutar = $db->query($consulta);
        $categorias = $ejecutar->fetchAll(PDO::FETCH_OBJ);

        $i = 0;
        foreach ($categorias as $key => $value) {

            $arreglo_interior = [];

            $consulta_2 = "SELECT id,grupo_id,nombre,codigo_crm,preparacion,recomendaciones,precio,precio_menos_cinco,
                           precio_menos_diez,precio_menos_quince FROM examen WHERE activo = 1 AND grupo_id = '" . $value->id . "'";

            $ejecutar2 = $db->query($consulta_2);
            $clientes2 = $ejecutar2->fetchAll(PDO::FETCH_OBJ);

            $a = 0;
            foreach ($clientes2 as $key => $value2) {
                $arreglo_interior[$a]['id_examen_perfil'] = $value2->id;
                $arreglo_interior[$a]['examen'] = $value2->nombre;
                $arreglo_interior[$a]['codigo_athenea'] = $value2->codigo_crm;
                $arreglo_interior[$a]['preparacion'] = $value2->preparacion;
                $arreglo_interior[$a]['recomendaciones'] = $value2->recomendaciones;
                $arreglo_interior[$a]['precio'] = $value2->precio;
                $arreglo_interior[$a]['precio_dto_5'] = $value2->precio_menos_cinco;
                $arreglo_interior[$a]['precio_dto_10'] = $value2->precio_menos_diez;
                $arreglo_interior[$a]['precio_dto_15'] = $value2->precio_menos_quince;
                $a++;
            }
            $a = 0;
            $arreglo_retorno[$i]['id_categoria'] = $value->id;
            $arreglo_retorno[$i]['categoria'] = $value->nombre;
            $arreglo_retorno[$i]['examenes'] = $arreglo_interior;

            $arreglo_interior = null;
            $i++;
        }
        $db = null;

        //Exportar y mostrar en formato JSON
        echo json_encode($arreglo_retorno);
    } catch (PDOException $e) {
        echo '{"error": {"text": error}';
    }
});

//buscar examenes perfiles por categoria
$app->get('/api/examenes_perfiles/{nombre_categoria}', function(Request $request, Response $response) {

    $categoria = $request->getAttribute('nombre_categoria');

    $consulta = "SELECT id,nombre FROM examen WHERE activo = 1 AND nombre LIKE '%" . $categoria . "%'AND grupo_id IS NULL";
    try {
        // Instanciar la base de datos
        $db = new db();

        // Conexión
        $db = $db->conectar();
        $ejecutar = $db->query($consulta);
        $categorias = $ejecutar->fetchAll(PDO::FETCH_OBJ);



        if (empty($categorias)) {
            echo json_encode("no_se_encuentran_datos");
        } else {



            $i = 0;
            foreach ($categorias as $key => $value) {

                $arreglo_interior = [];

                $consulta_2 = "SELECT id,grupo_id,nombre,codigo_crm,preparacion,recomendaciones,precio,precio_menos_cinco,
                               precio_menos_diez,precio_menos_quince FROM examen WHERE activo = 1 AND grupo_id = '" . $value->id . "'";

                $ejecutar2 = $db->query($consulta_2);
                $examen = $ejecutar2->fetchAll(PDO::FETCH_OBJ);

                $a = 0;
                foreach ($examen as $key => $value2) {
                    $arreglo_interior[$a]['id_examen_perfil'] = $value2->id;
                    $arreglo_interior[$a]['examen'] = $value2->nombre;
                    $arreglo_interior[$a]['codigo_athenea'] = $value2->codigo_crm;
                    $arreglo_interior[$a]['preparacion'] = $value2->preparacion;
                    $arreglo_interior[$a]['recomendaciones'] = $value2->recomendaciones;
                    $arreglo_interior[$a]['precio'] = $value2->precio;
                    $arreglo_interior[$a]['precio_dto_5'] = $value2->precio_menos_cinco;
                    $arreglo_interior[$a]['precio_dto_10'] = $value2->precio_menos_diez;
                    $arreglo_interior[$a]['precio_dto_15'] = $value2->precio_menos_quince;
                    $a++;
                }
                $a = 0;
                $arreglo_retorno[$i]['id_categoria'] = $value->id;
                $arreglo_retorno[$i]['categoria'] = $value->nombre;
                $arreglo_retorno[$i]['examenes'] = $arreglo_interior;

                $arreglo_interior = null;
                $i++;
            }

            $db = null;

            //Exportar y mostrar en formato JSON
            echo json_encode($arreglo_retorno);
        }
    } catch (PDOException $e) {
        echo '{"error": {"text": ' . $e->getMessage() . '}';
    }
});

$app->get('/api/examen_perfil_individual/{cod_athenea}', function(Request $request, Response $response) {

    $cod_athenea = $request->getAttribute('cod_athenea');

    $consulta = "SELECT id,grupo_id,nombre,codigo_crm,preparacion,recomendaciones,precio,precio_menos_cinco,
                 precio_menos_diez,precio_menos_quince FROM examen WHERE activo = 1 AND codigo_crm = '" . $cod_athenea . "'";
    try {
        $arreglo_retorno = [];
        // Instanciar la base de datos
        $db = new db();

        // Conexión
        $db = $db->conectar();
        $ejecutar = $db->query($consulta);
        $examen = $ejecutar->fetchAll(PDO::FETCH_OBJ);
        $db = null;



        if (empty($examen)) {
            echo json_encode("no_se_encuentran_datos");
        } else {
            $arreglo_retorno['id_examen_perfil'] = $examen[0]->id;
            $arreglo_retorno['examen'] = $examen[0]->nombre;
            $arreglo_retorno['codigo_athenea'] = $examen[0]->codigo_crm;
            $arreglo_retorno['preparacion'] = $examen[0]->preparacion;
            $arreglo_retorno['recomendaciones'] = $examen[0]->recomendaciones;
            $arreglo_retorno['precio'] = $examen[0]->precio;
            $arreglo_retorno['precio_dto_5'] = $examen[0]->precio_menos_cinco;
            $arreglo_retorno['precio_dto_10'] = $examen[0]->precio_menos_diez;
            $arreglo_retorno['precio_dto_15'] = $examen[0]->precio_menos_quince;
            echo json_encode($examen);
        }

        //Exportar y mostrar en formato JSON
    } catch (PDOException $e) {
        echo '{"error": {"text": ' . $e->getMessage() . '}';
    }
});

$app->get('/api/examenes_no_perfiles', function(Request $request, Response $response) {
    $consulta = "select id,codigo,nombre,precio from examenes_no_perfiles WHERE activo = 1";
    try {
        $arreglo_retorno = [];
        // Instanciar la base de datos
        $db = new db();
        // Conexión
        $db = $db->conectar();
        $ejecutar = $db->query($consulta);
        $examen = $ejecutar->fetchAll(PDO::FETCH_OBJ);
        $db = null;

        if (empty($examen)) {
            echo json_encode("no_se_encuentran_datos");
        } else {
            $arreglo_retorno['id_examen'] = $examen[0]->id;
            $arreglo_retorno['codigo_athenea'] = $examen[0]->codigo;
            $arreglo_retorno['examen'] = $examen[0]->nombre;
            $arreglo_retorno['precio'] = $examen[0]->precio;
            echo json_encode($examen);
        }

        //Exportar y mostrar en formato JSON
    } catch (PDOException $e) {
        echo '{"error": {"text": ' . $e->getMessage() . '}';
    }
});

$app->get('/api/examenes_no_perfiles/{nombre_examen}', function(Request $request, Response $response) {
    $nombre_examen = $request->getAttribute('nombre_examen');
    $consulta = "select id,codigo,nombre,precio from examenes_no_perfiles WHERE activo = 1 AND nombre LIKE '%" . $nombre_examen . "%'";
    try {
        $arreglo_retorno = [];
        // Instanciar la base de datos
        $db = new db();
        // Conexión
        $db = $db->conectar();
        $ejecutar = $db->query($consulta);
        $examen = $ejecutar->fetchAll(PDO::FETCH_OBJ);
        $db = null;

        if (empty($examen)) {
            echo json_encode("no_se_encuentran_datos");
        } else {
            $arreglo_retorno['id_examen'] = $examen[0]->id;
            $arreglo_retorno['codigo_athenea'] = $examen[0]->codigo;
            $arreglo_retorno['examen'] = $examen[0]->nombre;
            $arreglo_retorno['precio'] = $examen[0]->precio;
            echo json_encode($examen);
        }

        //Exportar y mostrar en formato JSON
    } catch (PDOException $e) {
        echo '{"error": {"text": ' . $e->getMessage() . '}';
    }
});
// Agregar Cliente
$app->post('/api/clientes/agregar', function(Request $request, Response $response) {

    /* --- Variables Request ----- */

    $tipo_documento = $request->getParam('tipo_documento');
    $documento = $request->getParam('documento');
    $nombre = $request->getParam('nombre');
    $apellido = $request->getParam('apellido');
    $telefono_1 = $request->getParam('telefono_1');
    $telefono_2 = $request->getParam('telefono_2');
    $email = $request->getParam('email');
    $fecha_nacimiento = $request->getParam('fecha_nacimiento');
    $ciudad_id = $request->getParam('ciudad_id');
    $barrio = $request->getParam('barrio');
    $direccion = $request->getParam('direccion');
    $estado_civil = $request->getParam('estado_civil');
    $sexo = $request->getParam('sexo');
    $estrato = $request->getParam('estrato');
    $tipo_cliente = $request->getParam('tipo_cliente');
    $edad = $request->getParam('edad');
    $clave = $request->getParam('clave');

    if ($tipo_documento == NULL || $documento == NULL || $nombre == NULL || $apellido == NULL || $email == NULL) {
        echo "estos datos son obligatorios: tipo_documento,documento,nombre,apellido,telefono_1,email,fecha_nacimiento,ciudad_id,direccion,estado_civil,sexo,estrato,edad";
    } else {

        try {

            $db = new db();
            $sql_existe = "SELECT documento FROM cliente WHERE documento='$documento'";
            $db = $db->conectar();
            $ejecutar = $db->query($sql_existe);
            $existe = $ejecutar->fetchAll(PDO::FETCH_OBJ);

            $sql_existe2 = "SELECT email FROM cliente WHERE email = '$email'";
            $ejecutar2 = $db->query($sql_existe2);
            $existe2 = $ejecutar2->fetchAll(PDO::FETCH_OBJ);

            if (!empty($existe) || !empty($existe2)) {
                echo "El documento : " . $documento . " o el correo " . $email . " ya existe, cambielo";
            } else {

                try {

                    $consulta = "INSERT INTO cliente (tipo_documento,documento,nombre,apellido,telefono_1,telefono_2,email, 
                                          fecha_nacimiento,ciudad_id,barrio,direccion,estado_civil_id,
                                          sexo, estrato,tipo_cliente,edad) VALUES
                                          (:tipo_documento,:documento,:nombre,:apellido,:telefono_1,:telefono_2,:email,
                                           :fecha_nacimiento,:ciudad_id,:barrio,:direccion,:estado_civil_id,
                                           :sexo,:estrato,:tipo_cliente,:edad)";

                    $stmt = $db->prepare($consulta);

                    $stmt->bindParam(':tipo_documento', $tipo_documento);
                    $stmt->bindParam(':documento', $documento);
                    $stmt->bindParam(':nombre', $nombre);
                    $stmt->bindParam(':apellido', $apellido);
                    $stmt->bindParam(':telefono_1', $telefono_1);
                    $stmt->bindParam(':telefono_2', $telefono_2);
                    $stmt->bindParam(':email', $email);
                    $stmt->bindParam(':fecha_nacimiento', $fecha_nacimiento);
                    $stmt->bindParam(':ciudad_id', $ciudad_id);
                    $stmt->bindParam(':barrio', $barrio);
                    $stmt->bindParam(':direccion', $direccion);
                    $stmt->bindParam(':estado_civil_id', $estado_civil);
                    $stmt->bindParam(':sexo', $sexo);
                    $stmt->bindParam(':estrato', $estrato);
                    $stmt->bindParam(':tipo_cliente', $tipo_cliente);
                    $stmt->bindParam(':edad', $edad);

                    $stmt->execute();

                    try {
                        $id_cliente = $db->lastInsertId();

                        $sql_usuario = "INSERT INTO usuario(documento,nombre_completo,clave,correo,activo,nombre_usuario,cliente) VALUES (:documento,:nombre_completo,SHA(:clave),:correo,:activo,:nombre_usuario,:cliente)";
                        $activo = 1;
                        $nombre_completo = $nombre . " " . $apellido;
                        $stmt1 = $db->prepare($sql_usuario);
                        $stmt1->bindParam(':documento', $documento);
                        $stmt1->bindParam(':nombre_completo', $nombre_completo);
                        $stmt1->bindParam(':clave', $clave);
                        $stmt1->bindParam(':correo', $email);
                        $stmt1->bindParam(':activo', $activo);
                        $stmt1->bindParam(':nombre_usuario', $email);
                        $stmt1->bindParam(':cliente', $id_cliente);


                        $stmt1->execute();

                        echo "CLIENTE REGISTRADO CORRECTAMENTE";
                    } catch (PDOException $e) {
                        echo '{"error": {"text": ' . $e->getMessage() . '}';
                    }
                } catch (PDOException $e) {
                    echo '{"error": {"text": ' . $e->getMessage() . '}';
                }
            }
        } catch (PDOException $e) {
            echo '{"error": {"text": ' . $e->getMessage() . '}';
        }
    }
});

$app->get('/api/login/{correo}/{pass}', function(Request $request, Response $response) {
    $correo = $request->getAttribute('correo');
    $pass = $request->getAttribute("pass");

    try {
        $db = new db();
        $db = $db->conectar();
        $sql_existe = "select id,cliente from usuario WHERE correo=:correo and clave =SHA(:clave)";

        $stmt = $db->prepare($sql_existe);
        $stmt->bindParam(':correo', $correo);
        $stmt->bindParam(':clave', $pass);
        $stmt->execute();

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (!empty($rows)) {
            try {
                $id_cliente = $rows[0]['cliente'];
                $sql_usuario = "select id_cliente,tipo_documento,documento,nombre,apellido,email from cliente where id_cliente =:id_cliente";
                $stmt1 = $db->prepare($sql_usuario);
                $stmt1->bindParam(':id_cliente', $id_cliente);
                $stmt1->execute();

                $infocliente = $stmt1->fetchAll(PDO::FETCH_ASSOC);

                $arreglo_retorno = array('id_usuario' => $rows[0]['id'],
                    'correo' => $correo,
                    'documento' => @$infocliente[0]['documento'],
                    'nombre' => @$infocliente[0]['nombre'],
                    'apellido' => @$infocliente[0]['apellido'],);

                echo json_encode($arreglo_retorno);
            } catch (PDOException $e) {
                echo '{"error": {"text": ' . $e->getMessage() . '}';
            }
        } else {
            echo "datos incorrectos revise la informacion";
        }
    } catch (PDOException $e) {
        echo '{"error": {"text": ' . $e->getMessage() . '}';
    }
});


$app->get('/api/departamentos', function(Request $request, Response $response) {
    try {
        $db = new db();
        $db = $db->conectar();
        $sql = "SELECT id,nombre FROM departamento WHERE activo = 1";

        $stmt = $db->prepare($sql);
        $stmt->execute();

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode($rows);
    } catch (PDOException $e) {
        echo '{"error": {"text": ' . $e->getMessage() . '}';
    }
});

$app->get('/api/municipios/{id_departamento}', function(Request $request, Response $response) {
    $id_departamento = $request->getAttribute('id_departamento');

    try {
        $db = new db();
        $db = $db->conectar();
        $sql = "SELECT id,nombre FROM ciudad WHERE departamento_id = :departamento_id";

        $stmt = $db->prepare($sql);
        $stmt->bindParam(':departamento_id', $id_departamento);
        $stmt->execute();

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode($rows);
    } catch (PDOException $e) {
        echo '{"error": {"text": ' . $e->getMessage() . '}';
    }
});

$app->get('/api/clientes', function(Request $request, Response $response) {
    try {
        $db = new db();
        $db = $db->conectar();
        $sql = "SELECT cli.nombre,cli.apellido,cli.telefono_1,cli.telefono_2,cli.email,cli.fecha_nacimiento,cli.direccion,
cli.sexo,cli.tipo_cliente,ci.nombre as ciudad,dpto.nombre as departamento,tpd.nombre as tipo_documento,cli.documento
FROM cliente cli
INNER JOIN ciudad ci ON ci.id = cli.ciudad_id
INNER JOIN departamento dpto on dpto.id = ci.departamento_id
INNER JOIN tipo_documento tpd on tpd.id = cli.tipo_documento";


        $stmt = $db->prepare($sql);
        $stmt->execute();

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode($rows);
    } catch (PDOException $e) {
        echo '{"error": {"text": ' . $e->getMessage() . '}';
    }
});

$app->get('/api/clientes/{documento}', function(Request $request, Response $response) {
    $documento = $request->getAttribute('documento');
    try {
        $db = new db();
        $db = $db->conectar();
        $sql = "SELECT cli.id_cliente,cli.nombre,cli.apellido,cli.telefono_1,cli.telefono_2,cli.email,cli.fecha_nacimiento,cli.direccion,
cli.sexo,cli.tipo_cliente,ci.nombre as ciudad,dpto.nombre as departamento,tpd.nombre as tipo_documento,cli.documento
FROM cliente cli
LEFT JOIN ciudad ci ON ci.id = cli.ciudad_id
LEFT JOIN departamento dpto on dpto.id = ci.departamento_id
INNER JOIN tipo_documento tpd on tpd.id = cli.tipo_documento
WHERE documento = :documento";


        $stmt = $db->prepare($sql);
        $stmt->bindParam(':documento', $documento);
        $stmt->execute();

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if (!empty($rows)) {
            echo json_encode($rows);
        } else {
            echo "no se encuentra la persona";
        }
    } catch (PDOException $e) {
        echo '{"error": {"text": ' . $e->getMessage() . '}';
    }
});

$app->put('/api/clientes/actualizar/{documento}', function(Request $request, Response $response) {
    $documento = $request->getAttribute('documento');
    $nombre = $request->getParam('nombre');
    $apellido = $request->getParam('apellido');
    $telefono_1 = $request->getParam('telefono_1');
    $telefono_2 = $request->getParam('telefono_2');
    $email = $request->getParam('email');
    $fecha_nacimiento = $request->getParam('fecha_nacimiento');
    $ciudad_id = $request->getParam('ciudad_id');
    $barrio = $request->getParam('barrio');
    $direccion = $request->getParam('direccion');
    $estado_civil = $request->getParam('estado_civil');
    $sexo = $request->getParam('sexo');
    $estrato = $request->getParam('estrato');
    $tipo_cliente = $request->getParam('tipo_cliente');
    $edad = $request->getParam('edad');
    $clave = $request->getParam('clave');

    try {
        $db = new db();
        $db = $db->conectar();

        $sql_existe_cliente = "select cli.id_cliente,us.id as id_usuario,us.documento,us.cliente 
                            from cliente cli 
                            INNER JOIN usuario us ON us.documento = cli.documento
                             WHERE cli.documento =:documento";

        $stmt = $db->prepare($sql_existe_cliente);
        $stmt->bindParam(':documento', $documento);
        $stmt->execute();

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (!empty($rows)) {
            $sql_modificar_cliente = "UPDATE cliente SET ";
            $sql_modificar_usuario = "UPDATE usuario SET ";
            $nombre_completo = "";
            $arreglo_cliente = array();
            $arreglo_usuario = array();

            if ($nombre != "" || $nombre != null) {
                $nombre_completo .= $nombre;
                $sql_modificar_cliente .= " nombre=:nombre,";
                $arreglo_cliente[":nombre"] = $nombre;
            }

            if ($apellido != "" || $apellido != NULL) {
                $nombre_completo .= " " . $apellido;
                $sql_modificar_cliente .= " apellido=:apellido,";
                $arreglo_cliente[":apellido"] = $apellido;
            }

            if ($telefono_1 != "" || $telefono_1 != NULL) {
                $sql_modificar_cliente .= " telefono_1=:telefono_1,";
                $arreglo_cliente[":telefono_1"] = $telefono_1;
            }

            if ($telefono_2 != "" || $telefono_2 != NULL) {
                $sql_modificar_cliente .= " telefono_2=:telefono_2,";
                $arreglo_cliente[":telefono_2"] = $telefono_2;
            }

            if ($email != "" || $email != NULL) {
                $sql_modificar_cliente .= " email=:email,";
                $sql_modificar_usuario .= " correo=:correo, nombre_usuario=:correo,";
                $arreglo_cliente[":email"] = $email;
                $arreglo_usuario[":correo"] = $email;
            }

            if ($fecha_nacimiento != "" || $fecha_nacimiento != NULL) {
                $sql_modificar_cliente .= " fecha_nacimiento=:fecha_nacimiento,";
                $arreglo_cliente[":fecha_nacimiento"] = $fecha_nacimiento;
            }
            if ($ciudad_id != "" || $ciudad_id != NULL) {
                $sql_modificar_cliente .= " ciudad_id=:ciudad_id,";
                $arreglo_cliente[":ciudad_id"] = $ciudad_id;
            }
            if ($barrio != "" || $barrio != NULL) {
                $sql_modificar_cliente .= " barrio=:barrio,";
                $arreglo_cliente[":barrio"] = $barrio;
            }
            if ($direccion != "" || $direccion != NULL) {
                $sql_modificar_cliente .= " direccion=:direccion,";
                $arreglo_cliente[":direccion"] = $direccion;
            }
            if ($estado_civil != "" || $estado_civil != NULL) {
                $sql_modificar_cliente .= " estado_civil_id=:estado_civil,";
                $arreglo_cliente[":estado_civil"] = $estado_civil;
            }
            if ($sexo != "" || $sexo != NULL) {
                $sql_modificar_cliente .= " sexo=:sexo,";
                $arreglo_cliente[":sexo"] = $sexo;
            }
            if ($tipo_cliente != "" || $tipo_cliente != NULL) {
                $sql_modificar_cliente .= " tipo_cliente=:tipo_cliente,";
                $arreglo_cliente[":tipo_cliente"] = $tipo_cliente;
            }
            if ($edad != "" || $edad != NULL) {
                $sql_modificar_cliente .= " edad=:edad,";
                $arreglo_cliente[":edad"] = $edad;
            }

            if ($nombre_completo != "" || $nombre_completo != NULL) {
                $sql_modificar_usuario .= " nombre_completo=:nombre_completo,";
                $arreglo_usuario[":nombre_completo"] = $nombre_completo;
            }
            if ($clave != "" || $clave != NULL) {
                $sql_modificar_usuario .= " clave=SHA(:clave),";
                $arreglo_usuario[":clave"] = $clave;
            }


            /* var_dump($arreglo_cliente);
              var_dump($arreglo_usuario);
              die(); */


            $sql_modificar_cliente = trim($sql_modificar_cliente, ',');
            $sql_modificar_cliente .= " WHERE id_cliente = :id_cliente";
            $arreglo_cliente[':id_cliente'] = $rows[0]['id_cliente'];
            $stmt_c = $db->prepare($sql_modificar_cliente);
            $stmt_c->execute($arreglo_cliente);



            $sql_modificar_usuario = trim($sql_modificar_usuario, ',');
            $sql_modificar_usuario .= " WHERE id = :id_usuario";
            $arreglo_usuario[':id_usuario'] = $rows[0]['id_usuario'];
            $stmt_u = $db->prepare($sql_modificar_usuario);
            $stmt_u->execute($arreglo_usuario);


            if ($stmt_u && $stmt_c) {
                echo "modificacion exitosa";
            } else {
                echo "Error al tratar de modificar la persona";
            }
        } else {
            echo "no se encuentra la persona";
        }
    } catch (PDOException $e) {
        echo '{"error": {"text": ' . $e->getMessage() . '}';
    }
});


$app->post('/api/ventas/crear_venta', function(Request $request, Response $response) {

    $documento_cliente = $request->getParam('documento_cliente');
    $id_usuario = $request->getParam('id_usuario_registra_venta');
    $examenes = $request->getParam('examenes');
    $observacion = $request->getParam('observacion');
    $medio_pago = $request->getParam('medio_pago');

    if ($documento_cliente == "" || $id_usuario == "" || $examenes == "" || $medio_pago == "") {
        echo "los siguientes campos son obligatorios : documento_cliente, id_usuario_registra_venta, examenes ,medio_pago";
    } else {
        try {

            $db = new db();
            $db = $db->conectar();

            $sql_existe_cliente = "SELECT * FROM cliente WHERE documento = :documento";
            $stmt = $db->prepare($sql_existe_cliente);
            $stmt->bindParam(':documento', $documento_cliente);
            $stmt->execute();
            $cliente_arr = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (!empty($cliente_arr)) {
                $examenes_explo = explode(",", $examenes);
                $examenes_persistencia_arreglo = [];
                $examenes_existentes = "";
                for ($i = 0; $i < count($examenes_explo); ++$i) {
                    $stmt_per = $db->prepare("SELECT * FROM examen WHERE codigo_crm=:codigo_crm");
                    $stmt_per->execute(array(":codigo_crm" => $examenes_explo[$i]));
                    $arreglo_examen_perfil_d = $stmt_per->fetchAll(PDO::FETCH_ASSOC);


                    if (!empty($arreglo_examen_perfil_d)) {
                        $examenes_persistencia_arreglo[$i]['id_examen'] = $arreglo_examen_perfil_d[0]['id'];
                        $examenes_persistencia_arreglo[$i]['nombre'] = $arreglo_examen_perfil_d[0]['nombre'];
                        $examenes_persistencia_arreglo[$i]['codigo_athenea'] = $arreglo_examen_perfil_d[0]['codigo_crm'];
                        $examenes_persistencia_arreglo[$i]['precio'] = $arreglo_examen_perfil_d[0]['precio'];
                        $examenes_persistencia_arreglo[$i]['precio_5'] = $arreglo_examen_perfil_d[0]['precio_menos_cinco'];
                        $examenes_persistencia_arreglo[$i]['precio_10'] = $arreglo_examen_perfil_d[0]['precio_menos_diez'];
                        $examenes_persistencia_arreglo[$i]['precio_15'] = $arreglo_examen_perfil_d[0]['precio_menos_quince'];
                        $examenes_persistencia_arreglo[$i]['tipo'] = 1;
                    } else {
                        $stmt_n_per = $db->prepare("SELECT * FROM examenes_no_perfiles where codigo =:codigo");
                        $stmt_n_per->execute(array(":codigo" => $examenes_explo[$i]));
                        $arreglo_examen_n_perfil = $stmt_n_per->fetchAll(PDO::FETCH_ASSOC);
                        if (!empty($arreglo_examen_n_perfil)) {
                            $examenes_persistencia_arreglo[$i]['id_examen'] = $arreglo_examen_n_perfil[0]['id'];
                            $examenes_persistencia_arreglo[$i]['nombre'] = $arreglo_examen_n_perfil[0]['nombre'];
                            $examenes_persistencia_arreglo[$i]['codigo_athenea'] = $arreglo_examen_n_perfil[0]['codigo'];
                            $examenes_persistencia_arreglo[$i]['precio'] = $arreglo_examen_n_perfil[0]['precio'];
                            $examenes_persistencia_arreglo[$i]['precio_5'] = "NA";
                            $examenes_persistencia_arreglo[$i]['precio_10'] = "NA";
                            $examenes_persistencia_arreglo[$i]['precio_15'] = "NA";
                            $examenes_persistencia_arreglo[$i]['tipo'] = 2;
                        } else {
                            $examenes_existentes .= $examenes_explo[$i] . ",";
                        }
                    }
                }

                //var_dump($examenes_persistencia_arreglo);
                //die();
                if ($examenes_existentes == "") {


                    $sql_existe_usuario = "SELECT * FROM usuario WHERE id=:id_usuario";
                    $stmt1 = $db->prepare($sql_existe_usuario);
                    $stmt1->bindParam(':id_usuario', $id_usuario);
                    $stmt1->execute();
                    $usuario_arr = $stmt1->fetchAll(PDO::FETCH_ASSOC);

                    if (!empty($usuario_arr)) {
                        $sql_insert_gestion = "INSERT INTO gestion (cliente_id,cotizacion,venta,medio_comunicacion,tipificacion_id,usuario_id,fecha_ingreso,gestionado,observacion)VALUES
                                                        (:cliente_id,:cotizacion,:venta,:medio_comunicacion,:tipificacion_id,:usuario_id,NOW(),:gestionado,:observacion)";
                        $stmt2 = $db->prepare($sql_insert_gestion);

                        $stmt2->execute(array(
                            ':cliente_id' => $cliente_arr[0]['id_cliente'],
                            ':cotizacion' => 0,
                            ':venta' => 1,
                            ':medio_comunicacion' => 11,
                            ':tipificacion_id' => 63,
                            ':usuario_id' => $id_usuario,
                            ':gestionado' => 1,
                            ':observacion' => $observacion
                        ));

                        if ($stmt2) {
                            $id_gestion = $db->lastInsertId();

                            $funciones = new Funciones();
                            $codigo = $funciones->generarCodigo(9);

                            $arreglo_venta = array(':cliente_id' => $cliente_arr[0]['id_cliente'],
                                ':usuario_id' => $id_usuario,
                                ':gestion_id' => $id_gestion,
                                ':medio_pago' => $medio_pago,
                                ':codigo_venta' => $codigo);



                            $sql_insert_venta = "INSERT INTO venta (cliente_id,usuario_id, gestion_id,medio_pago,fecha_creacion,activo,estado,codigo_venta) VALUES (:cliente_id,:usuario_id,:gestion_id,:medio_pago,NOW(),1,1,:codigo_venta)";
                            $stmt3 = $db->prepare($sql_insert_venta);
                            $stmt3->execute($arreglo_venta);

                            $id_venta = $db->lastInsertId();

                            if ($stmt3) {

                                $sql_inserta_itemas_v = "INSERT INTO venta_items(examen_id,cliente_id,gestion_id,descuento,venta_id,valor,tipo_examen)
                       VALUES(:examen_id,:cliente_id,:gestion_id,:descuento,:venta_id,:valor,:tipo_examen)";

                                for ($a = 0; $a < count($examenes_persistencia_arreglo); $a++) {
                                    $arreglo_itemas_venta[':examen_id'] = $examenes_persistencia_arreglo[$a]['id_examen'];
                                    $arreglo_itemas_venta[':cliente_id'] = $cliente_arr[0]['id_cliente'];
                                    $arreglo_itemas_venta[':gestion_id'] = $id_gestion;
                                    $arreglo_itemas_venta[':descuento'] = "-";
                                    $arreglo_itemas_venta[':venta_id'] = $id_venta;
                                    $arreglo_itemas_venta[':valor'] = $examenes_persistencia_arreglo[$a]['precio'];
                                    $arreglo_itemas_venta[':tipo_examen'] = $examenes_persistencia_arreglo[$a]['tipo'];


                                    $stmt4 = $db->prepare($sql_inserta_itemas_v);
                                    $stmt4->execute($arreglo_itemas_venta);
                                }

                                if ($stmt4) {
                                    echo "venta ingresada con exito , id venta = " . $id_venta;
                                } else {
                                    echo "error al tratar de almacenar la venta";
                                }
                            } else {
                                echo "error al tratar de almacenar la venta";
                            }
                        } else {
                            echo "error al tratar de almacenar la venta";
                        }
                    } else {
                        echo "El id usuario que esta tratando de ingresar no se encuentra registrado";
                    }
                } else {
                    echo "Los siguientes examenes que intento registrar no se encuentran en la base de datos : " . $examenes_existentes;
                }
            } else {
                echo "no se encuentra el cliente con el documento : " . $documento_cliente;
            }
        } catch (PDOException $e) {
            echo '{"error": {"text": ' . $e->getMessage() . '}';
        }
    }
});

$app->get('/api/ventas_cliente/{documento}', function(Request $request, Response $response) {
    $documento = $request->getAttribute('documento');
    try {
        $db = new db();
        $db = $db->conectar();
        $sql = "SELECT ven.id as id_venta,cli.id_cliente,tpd.nombre as tipo_doc,cli.documento,ges.observacion,
mdp.medio_pago,CONCAT(cli.nombre,' ',cli.apellido) as cliente,
SUM(vei.valor) as total_venta,ven.fecha_creacion,ven.fecha_pago,ven.estado,mdp.id as id_medio_pago,
ven.codigo_venta
FROM venta ven
INNER JOIN gestion ges ON ges.id = ven.gestion_id
INNER JOIN cliente cli ON cli.id_cliente = ven.cliente_id
INNER JOIN tipo_documento tpd ON tpd.id = cli.tipo_documento
INNER JOIN medio_pago mdp ON mdp.id = ven.medio_pago
INNER JOIN venta_items vei ON vei.venta_id = ven.id 
WHERE cli.documento = :documento
GROUP BY ven.id";


        $stmt = $db->prepare($sql);
        $stmt->bindParam(':documento', $documento);
        $stmt->execute();

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if (!empty($rows)) {

            $arreglo_retorno = [];
            $i = 0;
            foreach ($rows as $key => $value) {

                $estado = "";

                if ($value["estado"] == 1) {
                    $estado = "Por pagar";
                } else if ($value["estado"] == 2) {
                    $estado = "Pagado";
                } else if ($value["estado"] == 3) {
                    $estado = "Cancelado";
                }

                $arreglo_retorno[$i]["id_venta"] = $value["id_venta"];
                $arreglo_retorno[$i]["id_cliente"] = $value['id_cliente'];
                $arreglo_retorno[$i]["codigo_venta"] = $value["codigo_venta"];
                $arreglo_retorno[$i]["documento"] = $value["documento"];
                $arreglo_retorno[$i]["medio_pago"] = $value["medio_pago"];
                $arreglo_retorno[$i]["total_venta"] = $value["total_venta"];
                $arreglo_retorno[$i]["fecha_creacion"] = $value["fecha_creacion"];
                $arreglo_retorno[$i]["fecha_pago"] = $value["fecha_pago"];
                $arreglo_retorno[$i]["estado_venta"] = $estado;

                $sql_items = "select id,examen_id,valor,descuento,tipo_examen from venta_items where venta_id = :id_venta";
                $stmt1 = $db->prepare($sql_items);
                $stmt1->bindParam(':id_venta', $value["id_venta"]);
                $stmt1->execute();
                $rows_items = $stmt1->fetchAll(PDO::FETCH_ASSOC);
                if (!empty($rows_items)) {

                    $arreglo_items = array();
                    $e = 0;

                    foreach ($rows_items as $key => $value1) {

                        $sql = "";
                        if ($value1['tipo_examen'] == 2) {
                            $sql = "SELECT * FROM examenes_no_perfiles WHERE id=:id_examen";
                        } else if ($value1['tipo_examen'] == 1) {
                            $sql = "SELECT * FROM examen WHERE id=:id_examen";
                        }


                        $query_detalle_examen = $db->prepare($sql);
                        $query_detalle_examen->execute(array(':id_examen' => $value1['examen_id']));
                        $row_item = $query_detalle_examen->fetchAll(PDO::FETCH_ASSOC);



                        $arreglo_items[$e]["valor"] = trim($value1["valor"]);
                        $arreglo_items[$e]["descuento"] = $value1["descuento"];
                        @$arreglo_items[$e]["nombre_examen"] = $row_item[0]["nombre"];
                        $e++;
                    }


                    $arreglo_retorno[$i]["examenes"] = $arreglo_items;
                }
                $i++;
            }
            echo json_encode($arreglo_retorno);
        } else {
            echo "no se encuentra ventas para esta persona";
        }
    } catch (PDOException $e) {
        echo '{"error": {"text": ' . $e->getMessage() . '}';
    }
});

$app->get('/api/venta_individual/{id_venta}', function(Request $request, Response $response) {
    $id_venta = $request->getAttribute('id_venta');
    try {
        $db = new db();
        $db = $db->conectar();
        $sql = "SELECT ven.id as id_venta,cli.id_cliente,tpd.nombre as tipo_doc,cli.documento,ges.observacion,
mdp.medio_pago,CONCAT(cli.nombre,' ',cli.apellido) as cliente,
SUM(vei.valor) as total_venta,ven.fecha_creacion,ven.fecha_pago,ven.estado,mdp.id as id_medio_pago,
ven.codigo_venta
FROM venta ven
INNER JOIN gestion ges ON ges.id = ven.gestion_id
INNER JOIN cliente cli ON cli.id_cliente = ven.cliente_id
INNER JOIN tipo_documento tpd ON tpd.id = cli.tipo_documento
INNER JOIN medio_pago mdp ON mdp.id = ven.medio_pago
INNER JOIN venta_items vei ON vei.venta_id = ven.id 
WHERE ven.id = :id_venta
GROUP BY ven.id";


        $stmt = $db->prepare($sql);
        $stmt->bindParam(':id_venta', $id_venta);
        $stmt->execute();

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if (!empty($rows)) {

            $arreglo_retorno = [];
            $i = 0;
            foreach ($rows as $key => $value) {

                $estado = "";

                if ($value["estado"] == 1) {
                    $estado = "Por pagar";
                } else if ($value["estado"] == 2) {
                    $estado = "Pagado";
                } else if ($value["estado"] == 3) {
                    $estado = "Cancelado";
                }

                $arreglo_retorno[$i]["id_venta"] = $value["id_venta"];
                $arreglo_retorno[$i]["id_cliente"] = $value['id_cliente'];
                $arreglo_retorno[$i]["codigo_venta"] = $value["codigo_venta"];
                $arreglo_retorno[$i]["documento"] = $value["documento"];
                $arreglo_retorno[$i]["medio_pago"] = $value["medio_pago"];
                $arreglo_retorno[$i]["total_venta"] = $value["total_venta"];
                $arreglo_retorno[$i]["fecha_creacion"] = $value["fecha_creacion"];
                $arreglo_retorno[$i]["fecha_pago"] = $value["fecha_pago"];
                $arreglo_retorno[$i]["estado_venta"] = $estado;

                $sql_items = "select id,examen_id,valor,descuento,tipo_examen from venta_items where venta_id = :id_venta";
                $stmt1 = $db->prepare($sql_items);
                $stmt1->bindParam(':id_venta', $value["id_venta"]);
                $stmt1->execute();
                $rows_items = $stmt1->fetchAll(PDO::FETCH_ASSOC);
                if (!empty($rows_items)) {

                    $arreglo_items = array();
                    $e = 0;

                    foreach ($rows_items as $key => $value1) {

                        $sql = "";
                        if ($value1['tipo_examen'] == 2) {
                            $sql = "SELECT * FROM examenes_no_perfiles WHERE id=:id_examen";
                        } else if ($value1['tipo_examen'] == 1) {
                            $sql = "SELECT * FROM examen WHERE id=:id_examen";
                        }


                        $query_detalle_examen = $db->prepare($sql);
                        $query_detalle_examen->execute(array(':id_examen' => $value1['examen_id']));
                        $row_item = $query_detalle_examen->fetchAll(PDO::FETCH_ASSOC);



                        $arreglo_items[$e]["valor"] = trim($value1["valor"]);
                        $arreglo_items[$e]["descuento"] = $value1["descuento"];
                        @$arreglo_items[$e]["nombre_examen"] = $row_item[0]["nombre"];
                        $e++;
                    }


                    $arreglo_retorno[$i]["examenes"] = $arreglo_items;
                }
                $i++;
            }
            echo json_encode($arreglo_retorno);
        } else {
            echo "no se encuentra ventas para este id de venta";
        }
    } catch (PDOException $e) {
        echo '{"error": {"text": ' . $e->getMessage() . '}';
    }
});

$app->get('/api/solicitudes/{documento}', function(Request $request, Response $response) {
    $documento = $request->getAttribute('documento');
    try {

        $db = new db();
        $db = $db->conectar();
        $sql = "SELECT * FROM cliente WHERE documento=:documento";


        $stmt = $db->prepare($sql);
        $stmt->bindParam(':documento', $documento);
        $stmt->execute();

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $arreglo_retorno = array();

        if (!empty($rows)) {

            $arreglo_retorno["documento_cliente"] = $rows[0]['documento'];
            $arreglo_retorno["nombre"] = $rows[0]['nombre'];
            $arreglo_retorno["apellido"] = $rows[0]['apellido'];

            $sql_solicitudes = 'select id,id_solicitud_athenea
                             from venta
                             where estado =:estado
                             and cliente_id =:cliente_id
                             and id_solicitud_athenea <> ""';

            $stmt2 = $db->prepare($sql_solicitudes);
            $stmt2->execute(array(
                ":estado" => 2,
                ":cliente_id" => $rows[0]['id_cliente']
            ));
            $rows2 = $stmt2->fetchAll(PDO::FETCH_ASSOC);



            if (!empty($rows2)) {

                $i = 0;
                $arreglo_interior = [];
                foreach ($rows2 as $value) {

                    $arreglo_interior[$i]["id_solicitud_athenea"] = $value["id_solicitud_athenea"];

                    $sql_items = "select * from venta_items where venta_id =:venta_id";
                    $stmt3 = $db->prepare($sql_items);
                    $stmt3->execute(array(
                        ":venta_id" => $value['id']
                    ));
                    $rows3 = $stmt3->fetchAll(PDO::FETCH_ASSOC);

                    if (!empty($rows3)) {

                        $e = 0;
                        $arreglo_examenes = [];
                        foreach ($rows3 as $value) {


                            $sql_examenes = "";
                            if ($value['tipo_examen'] == "1") {
                                $tipo = true;
                                $sql_examenes = "SELECT id,codigo_crm as codigo,nombre FROM examen WHERE id =:id";
                            } else if ($value['tipo_examen'] == "2") {
                                $sql_examenes = "SELECT id,codigo,nombre FROM examenes_no_perfiles WHERE id =:id";
                                $tipo = false;
                            }

                            $stmt4 = $db->prepare($sql_examenes);
                            $stmt4->execute(array(
                                ":id" => $value['examen_id']
                            ));
                            $rows4 = $stmt4->fetchAll(PDO::FETCH_ASSOC);

                            if (!empty($rows4)) {
                                $arreglo_examenes[$e]["codigo_examen"] = $rows4[0]["codigo"];
                                $arreglo_examenes[$e]["nombre_examen"] = $rows4[0]["nombre"];
                                $arreglo_examenes[$e]["perfil"] = $tipo;
                            }

                            $e++;
                        }
                        $arreglo_interior[$i]["examenes"] = $arreglo_examenes;
                        $arreglo_examenes = "";
                    }



                    $i++;
                }
                $arreglo_retorno["solicitudes"] = $arreglo_interior;
                echo json_encode($arreglo_retorno);
            }
        } else {
            echo "no se encuentra el cliente con el documento " . $documento;
        }
    } catch (PDOException $e) {
        echo '{"error": {"text": ' . $e->getMessage() . '}';
    }
});


$app->get('/api/resultado/{id_solicitud}', function(Request $request, Response $response) {
    $id_solicitud = $request->getAttribute('id_solicitud');
    //var_dump($id_solicitud);
    //die();
    try {
        $db = new db();
        $db = $db->conectar();
        $sql = "SELECT res.idresultado,res.fecha_creacion,res.fecha_modificacion,res.estado,arc.nombre_archivo_sistema,
arc.fecha_creacion as fecha_creacion_doc, arc.fecha_modificacion as fecha_modificacion_doc,
ven.id_solicitud_athenea,cli.documento,cli.sexo,cli.edad,cli.nombre,cli.apellido
FROM resultado res
LEFT JOIN arch_res arc on arc.id_resultado = res.idresultado
INNER JOIN venta ven on ven.id = res.idventa
INNER JOIN cliente cli on cli.id_cliente = ven.cliente_id
WHERE ven.id_solicitud_athenea =:id_solicitud";

        //return $sql."+".$id_solicitud;

        $stmt = $db->prepare($sql);
        $stmt->bindParam(':id_solicitud', $id_solicitud);
        $stmt->execute();

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (!empty($rows)) {

            if ($rows[0]["estado"] == 2) {

                $arreglo_retorno = array();

                $arreglo_retorno["documento_cliente"] = $rows[0]["documento"];
                $arreglo_retorno["nombre"] = $rows[0]["nombre"];
                $arreglo_retorno["apellido"] = $rows[0]["apellido"];
                $arreglo_retorno["edad"] = $rows[0]["edad"];
                $arreglo_retorno["sexo"] = $rows[0]["sexo"];
                $arreglo_retorno["fecha_creacion_solicitud"] = $rows[0]["fecha_creacion"];
                $arreglo_retorno["ultima_fecha_modificacion_resultado"] = $rows[0]["fecha_modificacion"];
                $arreglo_retorno["fecha_adicion_documento"] = $rows[0]["fecha_creacion_doc"];
                $arreglo_retorno["ultima_fecha_modificacion_documento"] = $rows[0]["fecha_modificacion_doc"];
                $arreglo_retorno["id_solicitud_athenea"] = $rows[0]["id_solicitud_athenea"];
                $arreglo_retorno["url_documento_resultado"] = "http://vitalea.com.co/web/resultados/" . $rows[0]["nombre_archivo_sistema"];


                $sql_resultado_valor = "SELECT * FROM valor_resultado WHERE id_resultado =:id_resultado";
                $stmt2 = $db->prepare($sql_resultado_valor);
                $stmt2->execute(array(
                    ":id_resultado" => $rows[0]["idresultado"]
                ));
                $rows2 = $stmt2->fetchAll(PDO::FETCH_ASSOC);


                if (!empty($rows2)) {

                    $i = 0;
                    $arreglo_interior_resul_ex = [];
                    foreach ($rows2 as $value) {
                        $sql_info_examen = "";
                        if ($value["tipo_examen"] == "examen") {
                            $sql_info_examen = "select id as id_examen,nombre from examenes_no_perfiles where id =:id_examen";
                        } else if ($value["tipo_examen"] == "sub_examen") {
                            $sql_info_examen = "select id_sub_examen as id_examen,nombre_sub_examen as nombre from sub_examen where id_sub_examen =:id_examen";
                        }

                        $stmt3 = $db->prepare($sql_info_examen);
                        $stmt3->execute(array(
                            ":id_examen" => $value["id_examen"]
                        ));
                        $rows3 = $stmt3->fetchAll(PDO::FETCH_ASSOC);

                        if (!empty($rows3)) {

                            $sql_valores_referencia = "SELECT * FROM valor_referencia WHERE id_examen = :id_examen";
                            $stmt4 = $db->prepare($sql_valores_referencia);
                            $stmt4->execute(array(
                                ":id_examen" => $rows3[0]["id_examen"]
                            ));
                            $rows4 = $stmt4->fetchAll(PDO::FETCH_ASSOC);

                            if (!empty($rows4)) {

                                $arreglo_interior_resul_ex[$i]["codigo_examen"] = $value['codigo_examen'];
                                $arreglo_interior_resul_ex[$i]["fecha_creacion_resultado"] = $value['fecha_creacion'];
                                $arreglo_interior_resul_ex[$i]["valor_resultado"] = $value['resultado'];
                                $arreglo_interior_resul_ex[$i]["nombre_examen"] = trim($rows3[0]['nombre']);

                                $arreglo_referencia = [];
                                $r = 0;
                                foreach ($rows4 as $value) {

                                    if ($value['sexo'] == $rows[0]["sexo"]) {

                                        if ($value["unidad_edad"] == 'ANIOS') {
                                            if (intval($rows[0]["edad"]) >= intval($value["edad_minima"]) &&
                                                    intval($rows[0]["edad"]) <= intval($value["edad_maxima"])) {
                                                $arreglo_referencia[$r]["medida"] = $value["medida"];
                                                $arreglo_referencia[$r]["unidad"] = $value["unidad"];
                                                $arreglo_referencia[$r]["valor_critico_inferior"] = $value["valor_critico_inferior"];
                                                $arreglo_referencia[$r]["valor_critico_superior"] = $value["valor_critico_superior"];
                                                $arreglo_referencia[$r]["anormal_disminuido_minimo"] = $value["anormal_disminuido_minimo"];
                                                $arreglo_referencia[$r]["anormal_disminuido_maximo"] = $value["anormal_disminuido_maximo"];
                                                $arreglo_referencia[$r]["rango_normal_minimo"] = $value["rango_normal_minimo"];
                                                $arreglo_referencia[$r]["rango_normal_maximo"] = $value["rango_normal_maximo"];
                                                $arreglo_referencia[$r]["anormal_incrementado_minimo"] = $value["anormal_incrementado_minimo"];
                                                $arreglo_referencia[$r]["anormal_incrementado_maximo"] = $value["anormal_incrementado_maximo"];
                                                $arreglo_referencia[$r]["edad_minima"] = $value["edad_minima"];
                                                $arreglo_referencia[$r]["edad_maxima"] = $value["edad_maxima"];
                                                $arreglo_referencia[$r]["unidad_edad"] = $value["unidad_edad"];
                                                $arreglo_referencia[$r]["sexo"] = $value["sexo"];
                                                $r++;
                                            }
                                        }
                                    } else if ($value['sexo'] == "Ambos" || $value['sexo'] == "AMBOS") {
                                        if ($value["unidad_edad"] == 'ANIOS') {
                                            if (intval($rows[0]["edad"]) >= intval($value["edad_minima"]) &&
                                                    intval($rows[0]["edad"]) <= intval($value["edad_maxima"])) {
                                                $arreglo_referencia[$r]["medida"] = $value["medida"];
                                                $arreglo_referencia[$r]["unidad"] = $value["unidad"];
                                                $arreglo_referencia[$r]["valor_critico_inferior"] = $value["valor_critico_inferior"];
                                                $arreglo_referencia[$r]["valor_critico_superior"] = $value["valor_critico_superior"];
                                                $arreglo_referencia[$r]["anormal_disminuido_minimo"] = $value["anormal_disminuido_minimo"];
                                                $arreglo_referencia[$r]["anormal_disminuido_maximo"] = $value["anormal_disminuido_maximo"];
                                                $arreglo_referencia[$r]["rango_normal_minimo"] = $value["rango_normal_minimo"];
                                                $arreglo_referencia[$r]["rango_normal_maximo"] = $value["rango_normal_maximo"];
                                                $arreglo_referencia[$r]["anormal_incrementado_minimo"] = $value["anormal_incrementado_minimo"];
                                                $arreglo_referencia[$r]["anormal_incrementado_maximo"] = $value["anormal_incrementado_maximo"];
                                                $arreglo_referencia[$r]["edad_minima"] = $value["edad_minima"];
                                                $arreglo_referencia[$r]["edad_maxima"] = $value["edad_maxima"];
                                                $arreglo_referencia[$r]["unidad_edad"] = $value["unidad_edad"];
                                                $arreglo_referencia[$r]["sexo"] = $value["sexo"];
                                                $r++;
                                            }
                                        }
                                    }
                                }
                                $arreglo_interior_resul_ex[$i]["valores_referencia"] = $arreglo_referencia[0];
                                $arreglo_referencia = "";
                                 $i++;
                            }
                        }
                       
                    }
                    $arreglo_retorno["resultados_examenes"] = $arreglo_interior_resul_ex;
                }




                echo json_encode($arreglo_retorno, JSON_UNESCAPED_SLASHES);
            } else {
                echo "No se ha realizado el cargue de nungun dato de resultado para esta solicitud";
            }
        } else {
            echo "No se encontraron resultados para esta solicitud";
        }
    } catch (PDOException $e) {
        echo '{"error": {"text": ' . $e->getMessage() . '}';
    }
});


$app->get('/api/descripcion_perfil/{codigo_perfil}', function(Request $request, Response $response) {
    $codigo_perfil = $request->getAttribute('codigo_perfil');
    try {
        $db = new db();
        $db = $db->conectar();
        $sql = "select exa.codigo_crm as codigo_perfil,exa.nombre as nombre_perfil,
exap.nombre as nombre_examen,exap.codigo as codigo_examen
from perfil_examen exp
inner join examen exa on exa.id = exp.id_perfil
inner join examenes_no_perfiles exap on exap.id = exp.id_examen
where exa.codigo_crm = :codigo_perfil";

        //return $sql."+".$id_solicitud;

        $stmt = $db->prepare($sql);
        $stmt->bindParam(':codigo_perfil', $codigo_perfil);
        $stmt->execute();

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($rows);
    } catch (PDOException $e) {
        echo '{"error": {"text": ' . $e->getMessage() . '}';
    }
});

$app->get('/api/turnos_asignados/{id_usuario}', function(Request $request, Response $response) {
    $id_usuario = $request->getAttribute('id_usuario');
    //echo $id_usuario;
    //die();
    try {
        $db = new db();
        $db = $db->conectar();
        $sql = "SELECT tur.id_turno,cli.documento,cli.nombre,cli.apellido,tur.estado,tur.tipo_turno,
tur.turno,mdu.id_modulo,mdu.id_usuario,tur.fecha_creacion,tur.fecha_atencion,md.modulo,tur.id_venta
FROM turno tur
INNER JOIN cliente cli ON cli.id_cliente = tur.id_cliente
INNER JOIN modulo_usuario mdu ON mdu.id_modulo_usuario = tur.id_modulo_usuario
INNER JOIN modulo md ON md.id_modulo = mdu.id_modulo
WHERE mdu.estado = 'ACTIVO'
AND mdu.id_usuario = :id_usuario
AND tur.estado IN ('INICIADO','ACEPTADO')
ORDER BY fecha_creacion ASC";

        //return $sql."+".$id_solicitud;

        $stmt = $db->prepare($sql);
        $stmt->bindParam(':id_usuario', $id_usuario);
        $stmt->execute();

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($rows);
    } catch (PDOException $e) {
        echo '{"error": {"text": ' . $e->getMessage() . '}';
    }
});

$app->post('/api/confirma_venta', function(Request $request, Response $response) {

    $estado = $request->getParam('estado');
    $id = $request->getParam('id');
    $id_turno = $request->getParam('turno');


    try {
        $db = new db();
        $db = $db->conectar();
        $query = $db->prepare("UPDATE venta SET estado =:estado,fecha_pago=NOW() WHERE id =:id");
        $query->execute(array(':estado' => $estado,
            ':id' => $id));


        if ($query) {

            if ($estado == 2) {
                $obj_ws = new WSAPI("AtheneaWS", "4th3n3a*");
                $funciones = new Funciones();

                $retorno = $obj_ws->CrearPaciente($id);

                //return var_dump($retorno);

                if ($retorno["xml"]->bolvalido == 0) {
                    echo 2;
                } else if ($retorno["xml"]->bolvalido == 1) {
                    $athenea = $funciones->RevisaIdPacienteAthenea($retorno["xml"]->intid, $retorno['id_paciente']);

                    if ($athenea == 1) {
                        $retorno_factura = $obj_ws->AlmacenarFactura($id);
                        if ($retorno_factura == "error") {
                            echo 2;
                        } else {
                            $query2 = $db->prepare("UPDATE venta SET 
                                            id_solicitud_athenea=:id_solicitud_athenea,
                                            numero_factura=:numero_factura,
                                            valor_athenea=:valor_athenea,
                                            factura_athenea=:factura_athenea
                                            WHERE id=:id");
                            $query2->execute(array(':id_solicitud_athenea' => $retorno_factura["Id_Solicitud"],
                                ':numero_factura' => $retorno_factura['NumeroFactura'],
                                ':valor_athenea' => $retorno_factura['ValorAthenea'],
                                ':factura_athenea' => $retorno_factura['Facturado'],
                                ':id' => $id));


                            if ($query2) {

                                $sql_almacenar_resultado = "INSERT INTO resultado(idventa,idcliente,id_solicitud_athenea,
                                    estado,fecha_creacion,fecha_modificacion)
                          VALUES(:idventa,:idcliente,:id_solicitud_athenea,:estado,NOW(),NOW())";


                                $query2 = $db->prepare($sql_almacenar_resultado);

                                $query2->execute(array(':idventa' => $id,
                                    ':idcliente' => $retorno['id_paciente'],
                                    ':id_solicitud_athenea' => $retorno_factura["Id_Solicitud"],
                                    ':estado' => 1));
                                if ($query2) {


                                    $sql_4 = "UPDATE turno SET estado=:estado,fecha_atencion=NOW(),fecha_cierre=NOW() WHERE id_turno=:id_turno";
                                    //var_dump($sql_4);
                                    //die();
                                    $query4 = $db->prepare($sql_4);
                                    $query4->execute(array(':id_turno' => $id_turno,
                                        ':estado' => "TERMINADO"));

                                    if ($query4) {
                                        echo 1;
                                    } else {
                                        echo 2;
                                    }
                                } else {
                                    echo 2;
                                }
                            } else {
                                echo 2;
                            }
                        }
                    } else if ($athenea == 2) {
                        echo 2;
                    }

                    /* $sql_almacenar_resultado = "";
                      return $athenea; */
                }
            }
        }if (!$query) {
            echo 2;
        }
    } catch (PDOException $e) {
        echo '{"error": {"text": ' . $e->getMessage() . '}';
    }
});

$app->post('/api/cambiar_estado_t', function(Request $request, Response $response) {
    $estado = $request->getParam('estado');
    $id_turno = $request->getParam('id_turno');

    try {

        $sql = "";
        if ($estado == 'ACEPTADO') {
            $sql = "UPDATE turno SET estado=:estado,fecha_atencion=NOW() WHERE id_turno=:id_turno";
        } else if ($estado == 'CANCELADO' || $estado == 'TERMINADO') {
            $sql = "UPDATE turno SET estado=:estado,fecha_atencion=NOW(),fecha_cierre=NOW() WHERE id_turno=:id_turno";
        }


        $db = new db();
        $db = $db->conectar();

        $query = $db->prepare($sql);
        $query->execute(array(':id_turno' => $id_turno,
            ':estado' => $estado));


        if ($query) {
            echo 1;
        } else {
            echo 2;
        }
    } catch (PDOException $e) {
        echo '{"error": {"text": ' . $e->getMessage() . '}';
    }
});

$app->get('/api/SeleccionTurnosToma/{id_usuario}', function(Request $request, Response $response) {
    $id_usuario = $request->getAttribute('id_usuario');
    //echo $id_usuario;
    //die();
    try {
        $db = new db();
        $db = $db->conectar();
        $sql = "SELECT tur.id_turno,cli.documento,cli.nombre,cli.apellido,tur.estado,tur.tipo_turno,
tur.turno,mdu.id_modulo,mdu.id_usuario,tur.fecha_creacion,tur.fecha_atencion,md.modulo,tur.id_venta,cli.id_cliente
FROM turno tur
INNER JOIN cliente cli ON cli.id_cliente = tur.id_cliente
INNER JOIN modulo_usuario mdu ON mdu.id_modulo_usuario = tur.id_modulo_usuario
INNER JOIN modulo md ON md.id_modulo = mdu.id_modulo
WHERE mdu.estado = 'ACTIVO'
AND mdu.id_usuario = :id_usuario
AND tur.estado IN ('TERMINADO')
AND YEAR(tur.fecha_creacion) = :anio
AND MONTH(tur.fecha_creacion) = :mes
AND DAY(tur.fecha_creacion) = :dia
AND tipo_turno = 'PAGO'
ORDER BY fecha_creacion ASC";

        //return $sql."+".$id_solicitud;

        $stmt = $db->prepare($sql);
        $stmt->execute(array(':id_usuario' => $id_usuario,
            ':anio' => date("Y"),
            ':mes' => date("m"),
            'dia' => date("d")));

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $arreglo_retorno = [];

        foreach ($rows as $key => $value) {
            $query1 = $db->prepare("SELECT id_turno FROM turno WHERE tipo_turno = 'TOMA_MUESTRA' AND id_venta = :id_venta");
            $query1->execute(array(':id_venta' => $value['id_venta']));
            $rows1 = $query1->fetchAll(PDO::FETCH_ASSOC);
            if (empty($rows1)) {
                array_push($arreglo_retorno, $value);
            }
        }

        return json_encode($arreglo_retorno);
    } catch (PDOException $e) {
        echo '{"error": {"text": ' . $e->getMessage() . '}';
    }
});

$app->post('/api/CrearTurno', function(Request $request, Response $response) {

    $tipo_turno = $request->getParam('tipo_turno');
    $id_cliente = $request->getParam('id_cliente');
    $id_venta = $request->getParam('id_venta');


    try {
        $db = new db();
        $db = $db->conectar();
        $funciones = new Funciones();

        $numero_turno = $funciones->EntregaNumeroTurno($tipo_turno) + 1;
        $turno = "";

        if ($tipo_turno == 'PAGO') {
            $turno = "P_" . $numero_turno;
        } else if ($tipo_turno == 'TOMA_MUESTRA') {
            $turno = "TM_" . $numero_turno;
        }


        $modulo_usuario = $funciones->ModuloUsuario($tipo_turno);
        $query = $db->prepare("INSERT INTO turno(id_cliente,id_venta,estado,tipo_turno,turno,fecha_creacion,numero_turno,id_modulo_usuario)
                                           VALUES (:id_cliente,:id_venta,:estado,:tipo_turno,:turno,NOW(),:numero_turno,:id_modulo_usuario)");
        $query->execute(array(':id_cliente' => $id_cliente,
            ':id_venta' => $id_venta,
            ':estado' => 'INICIADO',
            ':tipo_turno' => $tipo_turno,
            ':turno' => $turno,
            ':numero_turno' => $numero_turno,
            ':id_modulo_usuario' => $modulo_usuario));

        $arreglo_retorno = array();

        if ($query) {
            $arreglo_retorno["retorno"] = 1;
            $arreglo_retorno["turno"] = $turno;
        } else {
            $arreglo_retorno["retorno"] = 2;
        }

        echo json_encode($arreglo_retorno);
    } catch (PDOException $e) {
        echo '{"error": {"text": ' . $e->getMessage() . '}';
    }
});

