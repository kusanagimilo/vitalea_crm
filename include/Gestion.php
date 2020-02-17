<?php

/**
 * Description of Gestion
 *
 * @author Paola Cotrina
 */
require_once '../conexion/conexion_bd.php';

class Gestion {
    public $conexion;
    
    function __construct() {
        $this->conexion = new Conexion();
    }
    
    public function buscar_registro($id_cliente){
        $query = $this->conexion->prepare("SELECT c.id_cliente,c.tipo_documento AS id_tipo_documento,t.nombre as tipo_documento,c.documento, c.nombre as nombre_cliente,c.apellido as apellido_cliente,
            
            c.telefono_1,c.telefono_2,c.email,c.fecha_nacimiento,c.ciudad_id,cd.nombre as ciudad,
            c.barrio,c.direccion,e.nombre as estado_civil,if(c.activo=1,'Activo','Inactivo') as activo,d.id AS id_departamento,d.nombre as departamento,
            c.estrato,c.sexo,c.estado_civil_id,c.activo,c.tipo_cliente,
            (SELECT descripcion FROM cliente_estado where cliente_estado_id = cliente_estado) as estado_cliente
             FROM cliente as c
             inner join tipo_documento as t on t.id = c.tipo_documento
             inner join ciudad as cd on cd.id = c.ciudad_id
             inner join departamento as d on cd.departamento_id = d.id
             inner join estado_civil as e on e.id = c.estado_civil_id
             where c.id_cliente =:id_cliente");
        $query->execute(array(':id_cliente'=>$id_cliente));

        $rows = $query->fetchAll(PDO::FETCH_ASSOC);
        
        if(empty($rows)){
            $opciones[] = array('id'=> 0);
        }else{
            foreach ($rows as $valor){
                   $opciones[] = array('id'=> $valor["id_cliente"],
                                       'tipo_documento'=> $valor["tipo_documento"],
                                       'documento'=> $valor["documento"],
                                       'nombre_cliente'=> $valor["nombre_cliente"],
                                       'apellido_cliente'=> $valor["apellido_cliente"],
                                       'telefono_1'=> $valor["telefono_1"],
                                       'telefono_2'=> $valor["telefono_2"],
                                       'email'=> $valor["email"],
                                       'fecha_nacimiento'=> $valor["fecha_nacimiento"],
                                       'ciudad'=> $valor["ciudad"],
                                       'departamento'=> $valor["departamento"],
                                       'barrio'=> $valor["barrio"],
                                       'direccion'=> $valor["direccion"],
                                       'estado_civil'=> $valor["estado_civil"],
                                       'activo'=> $valor["activo"],
                                       'estrato'=>$valor["estrato"],
                                       'sexo'=>$valor["sexo"],
                                       'id_tipo_documento'=>$valor["id_tipo_documento"],
                                       'ciudad_id'=>$valor["ciudad_id"],
                                       'id_departamento'=>$valor["id_departamento"],
                                       'estado_civil_id'=>$valor["estado_civil_id"],
                                       'estado_cliente'=>$valor["estado_cliente"],
                                       'tipo_cliente'=>$valor["tipo_cliente"]
                                        );
            }
        }    
        return json_encode($opciones);
    }
    
    public function crear_cliente($tipo_documento,$documento,$nombre,$apellido,$telefono_1,$telefono_2,$email,$fecha_nacimiento,$ciudad_id,$barrio,$direccion,$estado_civil_id,$sexo,$estrato,$tipo_cliente){
        $query = $this->conexion->prepare("INSERT INTO cliente 
                                                (tipo_documento,
                                                documento,nombre,
                                                apellido,
                                                telefono_1,
                                                telefono_2,
                                                email,
                                                fecha_nacimiento,
                                                ciudad_id,
                                                barrio,
                                                direccion,
                                                estado_civil_id,
                                                sexo,
                                                estrato,
                                                tipo_cliente)
                                            VALUES 
                                                (:tipo_documento,
                                                :documento,
                                                :nombre,
                                                :apellido,
                                                :telefono_1,
                                                :telefono_2,
                                                :email,
                                                :fecha_nacimiento,
                                                :ciudad_id,
                                                :barrio,
                                                :direccion,
                                                :estado_civil_id,
                                                :sexo,
                                                :estrato,
                                                :tipo_cliente)");
        
        $query->execute(array(':tipo_documento'=>$tipo_documento,
                              ':documento'=>$documento,
                              ':nombre'=>$nombre,
                              ':apellido'=>$apellido,
                              ':telefono_1'=>$telefono_1,
                              ':telefono_2'=>$telefono_2,
                              ':email'=>$email,
                              ':fecha_nacimiento'=>$fecha_nacimiento,
                              ':ciudad_id'=>$ciudad_id,
                              ':barrio'=>$barrio,
                              ':direccion'=>$direccion,
                              ':estado_civil_id'=>$estado_civil_id,
                              ':sexo'=>$sexo,
                              ':estrato'=>$estrato,
                              ':tipo_cliente'=>$tipo_cliente
                             ));
        
      
    }
    
    public function crear_tercero($tipo_documento,$documento,$nombre,$apellido,$fecha_nacimiento,$sexo,$parentesco,$id_titular){
        $query = $this->conexion->prepare("INSERT INTO crm_preatencion.terceros(
                                            tipo_documento
                                           ,documento
                                           ,nombre
                                           ,apellido
                                           ,fecha_nacimiento
                                           ,sexo
                                           ,activo
                                           ,id_titular
                                           ,parentesco
                                         ) VALUES (
                                           :tipo_documento,
                                           :documento,
                                           :nombre,
                                           :apellido,
                                           :fecha_nacimiento,
                                           :sexo,
                                           1,
                                           :id_titular,
                                           :parentesco
                                         )");
         $query->execute(array(':tipo_documento'=>$tipo_documento,
                              ':documento'=>$documento,
                              ':nombre'=>$nombre,
                              ':apellido'=>$apellido,
                              ':fecha_nacimiento'=>$fecha_nacimiento,
                              ':sexo'=>$sexo,
                              ':id_titular'=>$id_titular,
                              ':parentesco'=>$parentesco
                              
                             ));
    }
    
    public function id_cliente($documento){
        $query = $this->conexion->prepare("SELECT id_cliente from cliente where documento = :documento ");
        $query->execute(array(':documento'=>$documento));
        $rows = $query->fetchAll(PDO::FETCH_ASSOC);
        
        if(empty($rows)){
            $id = 0;
        }else{
             foreach ($rows as $datos){
                $id = $datos["id_cliente"];
            }
            
        }
    
        return $id;
    }
    
    public function medios_comunicacion(){
        $query = $this->conexion->prepare("select id,nombre,imagen from medio_comunicacion where activo = 1");
        $query->execute();
        $rows = $query->fetchAll();
        foreach ($rows as $valor){
               $opciones[] = array('id'=> $valor["id"], 'nombre'=> $valor["nombre"],'imagen'=>$valor["imagen"]);
        }
        return json_encode($opciones);
    }

    public function imagen_medio_comunicacion($medio_comunicacion_id){
        $query = $this->conexion->prepare("select imagen,texto from medio_comunicacion where id = :id");
         $query->execute(array(':id'=>$medio_comunicacion_id));
        $rows = $query->fetchAll(PDO::FETCH_ASSOC);
         foreach ($rows as $valor){
               $opciones[] = array('imagen'=>$valor["imagen"],'texto'=>$valor["texto"]);
        }
        return json_encode($opciones);
    }
    
    public function laboratorio(){
        $query = $this->conexion->prepare("SELECT id,sede FROM laboratorio where activo=1");
        $query->execute();
        $rows = $query->fetchAll();
        foreach ($rows as $valor){
               $opciones[] = array('id'=> $valor["id"], 'nombre'=> $valor["sede"]);
        }
        return json_encode($opciones);
    }
    
    public function examen(){
        $query = $this->conexion->prepare("SELECT id,nombre,preparacion,precio FROM examen where activo=1");
        $query->execute();
        $rows = $query->fetchAll();
        foreach ($rows as $valor){
               $opciones[] = array('id'=> $valor["id"], 'nombre'=> $valor["nombre"]);
        }
        return json_encode($opciones);
        
    }

    
    public function detalles_examen($examen_id){
        $query = $this->conexion->prepare("SELECT id,nombre,preparacion,precio FROM examen where activo=1 and id=:examen_id");
        $query->execute(array(':examen_id'=>$examen_id));
        $rows = $query->fetchAll(PDO::FETCH_ASSOC);
        foreach ($rows as $valor){
               $opciones[] = array('id'=> $valor["id"], 'nombre'=> $valor["nombre"],'preparacion'=> $valor["preparacion"],'precio'=> $valor["precio"]);
        }
        return json_encode($opciones);
    }


    public function obtenerCategoriaExamen(){
        $query = $this->conexion->prepare("select id,nombre from examen where grupo_id is null");
        $query->execute();
        $rows = $query->fetchAll();
        foreach ($rows as $valor){
               $opciones[] = array('id'=> $valor["id"], 'nombre'=> $valor["nombre"]);
        }
        return json_encode($opciones);
    }

    public function obtenerExamen($categoria_id){
       $query = $this->conexion->prepare("select id,nombre from examen where grupo_id = :categoria_id");
        $query->execute(array(':categoria_id'=>$categoria_id));
        $rows = $query->fetchAll(PDO::FETCH_ASSOC);
        foreach ($rows as $valor){
               $opciones[] = array('id'=> $valor["id"], 'nombre'=> $valor["nombre"]);
        }
        return json_encode($opciones);

    }
    
    public function notas_cliente($cliente_id){
        $query = $this->conexion->prepare("SELECT n.id,n.nota,n.cliente_id,n.usuario_id as usuario,n.fecha 
        FROM nota_cliente as n
        where n.activo = 1 and n.cliente_id= :cliente_id
        order by n.fecha desc");
        $query->execute(array(':cliente_id'=>$cliente_id));
        $rows = $query->fetchAll(PDO::FETCH_ASSOC);
        foreach ($rows as $valor){
               $opciones[] = array('id'=> $valor["id"], 'nota'=> $valor["nota"],'cliente_id'=> $valor["cliente_id"],'usuario'=> $valor["usuario"],'fecha'=> $valor["fecha"]);
        }
       
        return json_encode($opciones);
    }
    
    public function ingresar_nota($nota,$cliente_id,$usuario_id,$gestion_id){
        $query = $this->conexion->prepare("INSERT INTO nota_cliente (nota,cliente_id,usuario_id,fecha,gestion_id) values (:nota,:cliente_id,:usuario_id,NOW(),:gestion_id)");
        $query->execute(array(':nota'=>$nota,
                              ':cliente_id'=>$cliente_id,
                              ':usuario_id'=>$usuario_id,
                              ':gestion_id'=>$gestion_id));
        
    }
     /* FUNCION PARA AGREGAR GESTION*/

    public function ingresar_gestion($cliente_id,$usuario_id){

        $query = $this->conexion->prepare("INSERT INTO gestion (cliente_id,usuario_id,fecha_ingreso)
                VALUES (:cliente_id,:usuario_id,NOW())");
         $query->execute(array(':cliente_id'=>$cliente_id,
                                 ':usuario_id'=>$usuario_id
             ));
         
    }

    /* FUNCION PARA ACTUALIZAR GESTION */

    public function actualizar_gestion($cotizacion,$venta,$medio_comunicacion,$tipificacion_id,$usuario_id,$gestion_id){
        $query = $this->conexion->prepare("UPDATE 
                                            gestion 
                                          SET cotizacion= :cotizacion, 
                                              venta=:venta , 
                                              medio_comunicacion= :medio_comunicacion , 
                                              tipificacion_id= :tipificacion_id, 
                                              usuario_id = :usuario_id ,
                                              fecha_ingreso= NOW() ,
                                              gestionado = 1
                                            WHERE id= :gestion_id");
        $query->execute(array(':cotizacion'=>$cotizacion,
                              ':venta'=>$venta,
                              ':medio_comunicacion'=>$medio_comunicacion,
                              ':tipificacion_id'=>$tipificacion_id,
                              ':usuario_id'=>$usuario_id,
                              ':gestion_id'=>$gestion_id
             ));
    }

    //FUNCION PARA INGRESAR LA OBSERVACION 

    public function ingresar_observacion($observacion,$gestion_id){
      $query = $this->conexion->prepare("UPDATE gestion SET observacion= :observacion WHERE id = :gestion_id");
      $query->execute(array(':observacion'=>$observacion , ':gestion_id'=>$gestion_id));
    }
 
  /* FUNCION PARA CONSULTAR EL GESTION _ID */

    public function gestion_id($cliente_id,$usuario_id,$gestionado){
        $query = $this->conexion->prepare("SELECT id FROM gestion WHERE cliente_id= :cliente_id AND usuario_id = :usuario_id AND gestionado= :gestionado");
        $query->execute(array(':cliente_id'=>$cliente_id,
                              ':usuario_id'=>$usuario_id,
                              ':gestionado'=>$gestionado));
        $rows = $query->fetchAll(PDO::FETCH_ASSOC);

        if(!empty($rows)){
            foreach ($rows as $valor){
                   $gestion_id = $valor["id"];
            }
        }else{
          $gestion_id = 0;
        }
          

        return $gestion_id;
        
    }

    /* FUNCION PARA CONSULTAR ID_CLIENTE --- DESDE GESTION_ID */

    public function gestion_cliente_id($gestion_id){
        $query = $this->conexion->prepare("SELECT cliente_id FROM gestion WHERE id= :gestion_id");
        $query->execute(array(':gestion_id'=>$gestion_id));
        
        $rows = $query->fetchAll(PDO::FETCH_ASSOC);
        foreach ($rows as $valor){
               $cliente_id = $valor["cliente_id"];
        }

        return $cliente_id;
    }


    public function cotizacion_temporal($examen_id,$cliente_id,$gestion_id){
        $query = $this->conexion->prepare("INSERT INTO cotizacion_temp (examen_id,cliente_id,gestion_id) 
                VALUES (:examen_id,:cliente_id,:gestion_id)");
         $query->execute(array(':examen_id'=>$examen_id,
                               ':cliente_id'=>$cliente_id,
                               ':gestion_id'=>$gestion_id
             ));

    }

    public function consultar_cotizacion_temp($cliente_id,$gestion_id){
        $query = $this->conexion->prepare("SELECT c.id, e.nombre,e.precio FROM cotizacion_temp AS c
                  INNER JOIN examen AS e ON c.examen_id = e.id
                  WHERE c.cliente_id  = :cliente_id and c.gestion_id = :gestion_id ");
        $query->execute(array(':cliente_id'=>$cliente_id,
                              ':gestion_id'=>$gestion_id));
        $rows = $query->fetchAll(PDO::FETCH_ASSOC);


        if(!empty($rows)){
            $tabla = "<table class='table table-striped' background-color:#EEF8F9;'>";
            $tabla .=  "<tr >";
            $tabla .=  "<td style='background-color:#0C4F5A; color:white;width:15px;' >Eliminar</td>";
            $tabla .=  "<td style='background-color:#0C4F5A; color:white'>Examen</td>";
            $tabla .=  "<td style='background-color:#0C4F5A; color:white;width:15px;'>Precio</td>";
           
            $tabla .=  "</tr>";

            foreach ($rows as $valor){


                $tabla .= "<tr>";
                $tabla .= "<td> <center><button class='btn btn-default eliminar_examen'  id='".$valor["id"]."' onclick='eliminar(this.id)'><img src='https://arcos-crm.com/crm_colcan/web/images/borrar.png'> </button></center></td>";
                $tabla .= "<td>". $valor["nombre"] ."</td>";
                $tabla .= "<td> $ ".number_format( $valor["precio"],0,",","." )."</td>";
             
                $tabla .= "</tr>";
                   
            }
            $tabla .= $this->sumaCotizacionTemp($cliente_id,$gestion_id);

            $tabla .= "</table>";

        }else{
          $tabla = "  ";
        }    
        return $tabla;
    }

    public function sumaCotizacionTemp($cliente_id,$gestion_id){
        $query = $this->conexion->prepare("SELECT SUM(e.precio) AS suma FROM cotizacion_temp AS c
                  INNER JOIN examen AS e ON c.examen_id = e.id
                  WHERE c.cliente_id  = :cliente_id and c.gestion_id = :gestion_id ");
        $query->execute(array(':cliente_id'=>$cliente_id,
                              ':gestion_id'=>$gestion_id));
        $rows = $query->fetchAll(PDO::FETCH_ASSOC);

        foreach ($rows as $valor){
            $suma =$valor["suma"];
        }

        $tabla_suma = "<tr> <td colspan='2' style='color:#0C4F5A;text-align:right'><b>Total<b></td><td style='background-color:#0C4F5A; color:white'><b> $ ".number_format( $suma,0,",","." )."</b> </td></tr>";
        return $tabla_suma;
    }

    public function eliminar_cotizacion_temp($examen_id){
        $query = $this->conexion->prepare("delete from cotizacion_temp where id= :examen_id");
        $query->execute(array(':examen_id'=>$examen_id));
    }

    /* COTIZACION */
    public function cita_temporal($examen_id,$cliente_id,$gestion_id){
        $query = $this->conexion->prepare("INSERT INTO cita_temp (examen_id,cliente_id,gestion_id) 
                VALUES (:examen_id,:cliente_id,:gestion_id)");
         $query->execute(array(':examen_id'=>$examen_id,
                               ':cliente_id'=>$cliente_id,
                               ':gestion_id'=>$gestion_id
             ));

    }


     public function consultar_cita_temp($cliente_id,$gestion_id){
        $query = $this->conexion->prepare("SELECT c.id, e.nombre,e.precio FROM cita_temp AS c
                  INNER JOIN examen AS e ON c.examen_id = e.id
                  WHERE c.cliente_id  = :cliente_id and c.gestion_id = :gestion_id ");
        $query->execute(array(':cliente_id'=>$cliente_id,
                              ':gestion_id'=>$gestion_id));
        $rows = $query->fetchAll(PDO::FETCH_ASSOC);

        if(!empty($rows)){

            $tabla = "<table class='table table-striped' style='background-color:#EEF8F9;'>";
            $tabla .=  "<tr >";
            $tabla .=  "<td style='background-color:#0C4F5A; color:white;width:15px;' >Eliminar</td>";
            $tabla .=  "<td style='background-color:#0C4F5A; color:white'>Examen</td>";
            $tabla .=  "<td style='background-color:#0C4F5A; color:white;width:15px;'>Precio</td>";
           
            $tabla .=  "</tr>";

            foreach ($rows as $valor){


                $tabla .= "<tr>";
                $tabla .= "<td> <center><button class='btn btn-default eliminar_examen'  id='".$valor["id"]."' onclick='eliminar_cita(this.id)'><img src='https://arcos-crm.com/crm_colcan/web/images/borrar.png'> </button></center></td>";
                $tabla .= "<td>". $valor["nombre"] ."</td>";
                $tabla .= "<td> $ ".number_format( $valor["precio"],0,",","." )."</td>";
             
                $tabla .= "</tr>";
                   
            }
            $tabla .= $this->sumaCitaTemp($cliente_id,$gestion_id);

            $tabla .= "</table>";

        }else{
            $tabla =""; 
        }    
        return $tabla;
    }


    public function sumaCitaTemp($cliente_id,$gestion_id){
        $query = $this->conexion->prepare("SELECT SUM(e.precio) AS suma FROM cita_temp AS c
                  INNER JOIN examen AS e ON c.examen_id = e.id
                  WHERE c.cliente_id  = :cliente_id and c.gestion_id = :gestion_id ");
        $query->execute(array(':cliente_id'=>$cliente_id,
                              ':gestion_id'=>$gestion_id));
        $rows = $query->fetchAll(PDO::FETCH_ASSOC);

        if(!empty($rows)){
            foreach ($rows as $valor){
              $suma =$valor["suma"];
            }
          }else{
              $suma = 0;
          }

        $tabla_suma = "<tr> <td colspan='2' style='color:#0C4F5A;text-align:right'><b>Total<b></td><td style='background-color:#0C4F5A; color:white'><b> $ ".number_format( $suma,0,",","." )."</b> </td></tr>";
        return $tabla_suma;
    }

    public function eliminar_cita_temp($examen_id){
        $query = $this->conexion->prepare("delete from cita_temp where id= :examen_id");
        $query->execute(array(':examen_id'=>$examen_id));
    }

    public function agregar_mensaje_medio_comunicacion($gestion_id,$medio_comunicacion_id,$mensaje){
       $query = $this->conexion->prepare("INSERT INTO mensaje_medio_comunicacion (gestion_id,medio_comunicacion_id,mensaje) VALUES (:gestion_id,:medio_comunicacion_id,:mensaje)");

       $query->execute(array(':gestion_id'=>$gestion_id,
                            ':medio_comunicacion_id'=>$medio_comunicacion_id,
                            ':mensaje'=>$mensaje
                          ));
    }

    public function consultar_gestiones_cliente($cliente_id){
        $query = $this->conexion->prepare("SELECT 
                                          g.id,
                                          g.observacion,
                                          (SELECT nombre FROM medio_comunicacion WHERE id = g.medio_comunicacion) AS medio,
                                          (SELECT nombre FROM tipificacion WHERE id= g.tipificacion_id) AS causal,
                                          g.fecha_ingreso
                                          FROM
                                          gestion AS g
                                          WHERE g.cliente_id =:cliente_id AND g.gestionado = 1 
                                          ORDER BY g.fecha_ingreso desc");
      $query->execute(array(':cliente_id'=>$cliente_id ));
       $rows = $query->fetchAll(PDO::FETCH_ASSOC);

       return $rows;


    }

    public function consultar_cantidad_ventas($cliente_id){
       $query = $this->conexion->prepare("SELECT 
                                      COUNT(*) AS conteo
                                    FROM 
                                      venta
                                    WHERE 
                                      cliente_id = :cliente_id");
      $query->execute(array(':cliente_id'=>$cliente_id ));
      $rows = $query->fetchAll(PDO::FETCH_ASSOC);

      foreach ($rows as $valores) {
        $conteo = $valores["conteo"];
      }

      return $conteo;
    }

    public function consultar_cantidad_cotizaciones($cliente_id){
       $query = $this->conexion->prepare("SELECT 
                                      COUNT(*) AS conteo
                                    FROM 
                                      cotizacion
                                    WHERE 
                                      cliente_id = :cliente_id");
      $query->execute(array(':cliente_id'=>$cliente_id ));
      $rows = $query->fetchAll(PDO::FETCH_ASSOC);

      foreach ($rows as $valores) {
        $conteo = $valores["conteo"];
      }

      return $conteo;
    }

    public function actualizar_estado_cliente($estado,$cliente_id){
       $update = $this->conexion->prepare("UPDATE cliente SET cliente_estado= :estado WHERE id_cliente = :cliente_id");
       $update->execute(array(':estado'=> $estado,
                              ':cliente_id'=>$cliente_id ));
    }

    public function detalle_gestion($gestion_id){
        $query= $this->conexion->prepare("SELECT 
                                g.fecha_ingreso,
                                (SELECT id from usuario where id = g.usuario_id) as usuario,
                                g.medio_comunicacion as medio_comunicacion_id,
                                (select nombre from medio_comunicacion where id = g.medio_comunicacion) as medio_comunicacion,
                                (select imagen from medio_comunicacion where id = g.medio_comunicacion) as imagen,
                                (SELECT nombre from tipificacion where id = t.grupo) as causal,
                                t.nombre,
                                g.cotizacion,
                                (select id from cotizacion where gestion_id= g.id) as cotizacion_id,
                                g.venta,
                                (SELECT id from venta where gestion_id = g.id) as venta_id,
                                g.cliente_id,
                                (SELECT nota from nota_cliente where gestion_id = g.id) as nota,
                                m.mensaje


                                FROM gestion as g
                                INNER JOIN tipificacion as t on (t.id = g.tipificacion_id)
                                LEFT JOIN mensaje_medio_comunicacion as m on m.gestion_id = g.id
                                WHERE g.id = :gestion_id");
         $query->execute(array(':gestion_id'=>$gestion_id ));

          $rows = $query->fetchAll(PDO::FETCH_ASSOC);

       return $rows;
    }

    public function gurdar_repuesta_clasificacion($pregunta_id,$respuesta,$cliente_id){
      $query= $this->conexion->prepare("INSERT INTO repuesta( pregunta_id, respuesta, cliente_id) VALUES (:pregunta_id,:respuesta,:cliente_id)");
    $query->execute(array(':pregunta_id'=>$pregunta_id ,
                           ':respuesta' => $respuesta,
                            'cliente_id'=> $cliente_id));
    }

    public function actulizar_cliente_clasisficacion($cliente_id,$clasificacion){
      $query = $this->conexion->prepare("UPDATE cliente SET clasificacion = :clasificacion where id_cliente = :cliente_id");
      $query->execute(array(':clasificacion'=>$clasificacion ,
                           ':cliente_id' => $cliente_id));

    }

    public function clasificacion_paciente($cliente_id){
      $query = $this->conexion->prepare("SELECT clasificacion from cliente where id_cliente = :cliente_id");
      $query->execute(array(':cliente_id'=>$cliente_id ));

       $rows = $query->fetchAll(PDO::FETCH_ASSOC);

       if(!empty($rows)){
          foreach ($rows as $value) {
            $clasificacion = $value["clasificacion"];
          }
       }
       else{
          $clasificacion = 1;
       }

       return $clasificacion;
       
    }

    public function guion($clasificacion_id){
      $query = $this->conexion->prepare("SELECT guion FROM guion WHERE clasificacion_id= :clasificacion_id");
       $query->execute(array(':clasificacion_id'=>$clasificacion_id ));

       $rows = $query->fetchAll(PDO::FETCH_ASSOC);

      
          foreach ($rows as $value) {
            $guion = $value["guion"];
          }
      

       return $guion;
    }

}


