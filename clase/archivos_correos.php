<?php 
/**
 * Description of Gestion
 *
 * @author Paola Cotrina
 */
require_once '../conexion/conexion_bd.php';

class Archivos{  
    public $conexion;
    
    function __construct() {
        $this->conexion = new Conexion();
    }

     public function cargar_archivos_enlace($enlace,$codigo){
        $query = $this->conexion->prepare("INSERT INTO enlaces_archivos(fecha_insercion,enlace,codigo) VALUES (NOW(),:enlace,:codigo)");

        $query->execute(array(':enlace'=>$enlace,
                              ':codigo'=>$codigo
                              
                          ));
     }

      public function cargar_archivos_enlace2($enlace2,$codigo2){
        $query = $this->conexion->prepare("INSERT INTO enlaces_archivos(fecha_insercion,enlace,codigo) VALUES (NOW(),:enlace2,:codigo2)");

        $query->execute(array(':enlace2'=>$enlace2,
                              ':codigo2'=>$codigo2
                              
                          ));
     }

     public function llamar_archivo($codigo){
        $query = $this->conexion->prepare("SELECT enlace from enlaces_archivos WHERE codigo= :codigo");

        $query->execute(array(':codigo'=>$codigo));

        $rows = $query->fetchAll();
        foreach ($rows as $valor){
          $enlace = $valor["enlace"]; 
        }
        return $enlace;
     }

          public function llamar_archivo2($codigo2){
        $query = $this->conexion->prepare("SELECT enlace from enlaces_archivos WHERE codigo= :codigo2");

        $query->execute(array(':codigo2'=>$codigo2));

        $rows = $query->fetchAll();
        foreach ($rows as $valor){
          $enlace = $valor["enlace"]; 
        }
        return $enlace;
     }

               public function mostrar_correo($id){
        $query = $this->conexion->prepare("SELECT email FROM cliente WHERE id_cliente = :id ");

        $query->execute(array(':id'=>$id));

        $rows = $query->fetchAll();
        foreach ($rows as $valor){
          $correo = $valor["email"]; 
        }
        return $correo;
     }

}
?>