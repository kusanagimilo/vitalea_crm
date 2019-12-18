<?php

require_once '../conexion/conexion_bd.php';

class Gestion {
    public $conexion;
    
    function __construct() {
        $this->conexion = new Conexion();
    }

    public function inicial_pago(){
          $inicial_p = "P_";
          return $inicial_p;
       }


  public function consultar_prueba() {
            $consultar = $this->conexion->prepare("SELECT * FROM `gestion_turno` GROUP BY `turno`='turno' DESC LIMIT 1");
            $consultar->execute();
            $r = $consultar->fetchAll();
            return $r;
            $this->conexion = null;
           }

    public function consultar_turno_pago(){
           $consultar = $this->conexion->prepare("SELECT * FROM `gestion_turno` GROUP BY `turno`='turno' DESC LIMIT 1");
           $consultar->execute();
           $numero_registros = $consultar->fetchAll();
           foreach ($numero_registros as $datos_registro){
               $conteo = $datos_registro["turno"];
           }
           return $conteo;
       }

    public function ticket($macro_proceso){
           $fecha = date('Ymd');
           $inicial = $this->inicial_macro_proceso($macro_proceso);
           $consecutivo = $this->consultar_consecutivo($inicial);
           $consecutivo_ticket = $consecutivo + 1;
           $ticket = $inicial.'_'.$consecutivo_ticket;
            return $ticket;
       }

     $id_gestion =  $_POST["id_gestion"];
   $consultar_ticket = $consultas_gestion->consultar_tickets_gestion($id_gestion);
   foreach($consultar_ticket as $datos_ticket){
       $ticket = $datos_ticket["ticket_gestion"];
   }
   echo $ticket;
   die();









    
    public function buscar_turno($id_cliente){
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
    
     /* FUNCION PARA AGREGAR GESTION*/

    public function ingresar_gestion($cliente_id,$usuario_id){

        $query = $this->conexion->prepare("INSERT INTO gestion (cliente_id,usuario_id,fecha_ingreso)
                VALUES (:cliente_id,:usuario_id,NOW())");
         $query->execute(array(':cliente_id'=>$cliente_id,
                                 ':usuario_id'=>$usuario_id
             ));

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

    public function consultar_gestiones_cliente($cliente_id){
        $query = $this->conexion->prepare("SELECT 
                                          g.id,
                                          g.observacion,
                                          (SELECT nombre FROM medio_comunicacion WHERE id = g.medio_comunicacion) AS medio,
                                          (SELECT nombre FROM tipificacion WHERE id= g.tipificacion_id) AS causal,
                                          g.fecha_ingreso
                                          FROM gestion AS g
                                          WHERE g.cliente_id =:cliente_id AND g.gestionado = 1 
                                          ORDER BY g.fecha_ingreso desc");
      $query->execute(array(':cliente_id'=>$cliente_id ));
       $rows = $query->fetchAll(PDO::FETCH_ASSOC);

       return $rows;

    }
}