<?php 
/**
 * Description of Gestion
 *
 * @author Paola Cotrina
 */
require_once '../conexion/conexion_bd.php';
require_once '../clase/Caja.php';

class Cotizacion {
    public $conexion;
    
    function __construct() {
        $this->conexion = new Conexion();
    }

  //INGRESAR COTIZACION
     public function ingresar_cotizacion($usuario_id,$cliente_id,$gestion_id){
        //INSTANCIAR OBJETO -- CAJA
        $caja = new Caja();

        $query= $this->conexion->prepare("INSERT INTO cotizacion (usuario_id,cliente_id,gestion_id,fecha_cotizacion) 
            VALUES (:usuario_id,:cliente_id,:gestion_id,NOW())");
        $query->execute(array(':usuario_id'=>$usuario_id,
                              ':cliente_id'=>$cliente_id,
                              ':gestion_id'=>$gestion_id));

        $cotizacion_id = $this->conexion->lastInsertId();


        $items_cotizacion = $caja->consultar_items_examenes_temp($cliente_id,$gestion_id);

        if(!empty($items_cotizacion)){
             foreach ($items_cotizacion as $datos_venta_examenes) {
          //INGRESAR ITEMS DE VENTA
          $this->ingresar_cotizacion_items($datos_venta_examenes["examen_id"],
            $cliente_id,
            $gestion_id,
            $datos_venta_examenes["precio_tipo"],
            $cotizacion_id,
            $datos_venta_examenes["valor"],
            $datos_venta_examenes["tipo_examen"]);

          //ELIMINAR ITEMS VENTAS 
            $caja->eliminar_venta_temp($datos_venta_examenes["id"]);
           }
        }

        return $cotizacion_id;

    }

    // INGRESAR ITEM DE COTIZACION
    public function ingresar_cotizacion_items($examen_id,$cliente_id,$gestion_id,$descuento,$cotizacion_id,$valor,$tipo_examen){
      $query= $this->conexion->prepare("INSERT INTO cotizacion_items (examen_id,cliente_id,gestion_id,descuento,cotizacion_id,valor,tipo_examen) VALUES (:examen_id,:cliente_id,:gestion_id,:descuento,:cotizacion_id,:valor,:tipo_examen)");

       $query->execute(array(':examen_id'=>$examen_id,
                              ':cliente_id'=>$cliente_id,
                              ':gestion_id'=>$gestion_id,
                              ':descuento'=>$descuento,
                              ':cotizacion_id'=>$cotizacion_id,
                              ':valor'=>$valor,
                              ':tipo_examen'=>$tipo_examen
                          ));
    }

    //CONSULTAR ITEMS DE COTIZACION

    public function consultar_items_cotizacion($cotizacion_id){
        $query = $this->conexion->prepare("SELECT
                                c.id,
                                if(c.tipo_examen=1,(SELECT nombre FROM examen WHERE id= c.examen_id), (SELECT nombre FROM examenes_no_perfiles WHERE id= c.examen_id)) as examen,
                                descuento,
                                valor
                                FROM cotizacion_items as c
                                WHERE c.cotizacion_id = :cotizacion_id");

        $query->execute(array(':cotizacion_id'=>$cotizacion_id));

         $rows = $query->fetchAll(PDO::FETCH_ASSOC);

        return $rows;
    }

    //SUMA TOTAL COTIZACION 

    public function suma_cotizacion($cotizacion_id){
        $query = $this->conexion->prepare("SELECT SUM(valor) as suma
                            FROM cotizacion_items
                            WHERE cotizacion_id = :cotizacion_id");
         $query->execute(array(':cotizacion_id'=>$cotizacion_id));

         $rows = $query->fetchAll(PDO::FETCH_ASSOC);

         if(!empty($rows)){
             foreach ($rows as $valor) {
                 $suma = $valor["suma"];
             }

         }else{
            $suma = 0;
         }
            

        return $suma;
    }
   

    public function consultar_cotizacion_temp($cliente_id,$gestion_id){
        $query = $this->conexion->prepare("SELECT c.id,c.examen_id,e.precio FROM cotizacion_temp AS c
                  INNER JOIN examen AS e ON c.examen_id = e.id
                  WHERE c.cliente_id  = :cliente_id and c.gestion_id = :gestion_id ");
        $query->execute(array(':cliente_id'=>$cliente_id,
                              ':gestion_id'=>$gestion_id));
        $rows = $query->fetchAll(PDO::FETCH_ASSOC);

        return $rows;

    }

   

   

    public function eliminar_cotizacion_temp($cliente_id,$gestion_id){
        $query = $this->conexion->prepare("DELETE FROM cotizacion_temp where cliente_id =:cliente_id and gestion_id=:gestion_id");
        $query->execute(array(':cliente_id'=>$cliente_id,
                              ':gestion_id'=>$gestion_id));
    }

}





  

?>