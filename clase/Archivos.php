<?php 
/**
 * Description of Gestion
 *
 * @author Paola Cotrina
 */
require_once '../conexion/conexion_bd.php';

class ArchivoBD {
    public $conexion;
    
    function __construct() {
        $this->conexion = new Conexion();
    }

     public function cargar_archivo($ruta_archivo,$documento,$fecha){
        $query = $this->conexion->prepare("INSERT INTO archivos_resultados(ruta_archivo,documento,fecha,fecha_cargue) VALUES (:ruta_archivo,:documento,:fecha,NOW())");

        $query->execute(array(':ruta_archivo'=>$ruta_archivo,
                              ':documento'=>$documento,
                              ':fecha'=>$fecha
                          ));
     }

     public function archivos_existentes($ruta_archivo,$documento){
        $query = $this->conexion->prepare("SELECT COUNT(*) as conteo from archivos_resultados WHERE ruta_archivo= :ruta_archivo and documento= :documento;");

        $query->execute(array(':ruta_archivo'=>$ruta_archivo, ':documento'=>$documento));

        $rows = $query->fetchAll();
        foreach ($rows as $valor){
          $conteo = $valor["conteo"]; 
        }
        return $conteo;
     }

   

   


    


}
?>