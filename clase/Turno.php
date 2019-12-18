<?php
/**
 * Descripción de Turno
 *
 * @author Federico Marin
 */
require_once '../conexion/conexion_bd.php';

class Turno {
    public $conexion;
    
    function __construct() {
        $this->conexion = new Conexion();
    }

    public function llamar_cliente_nuevo(){
        $query = $this->conexion->prepare("SELECT cliente_id FROM gestion_turno WHERE llamado='0' ORDER by fecha_registro ASC LIMIT 1");
        $query->execute();

        if(empty($query)){
          $llamado = 0;
        }else{
          foreach ($query as $datos){
            $cliente = $datos["cliente_id"];
          }
        }
        return $cliente;
    }

    public function id_gestion(){
        $query = $this->conexion->prepare("SELECT id_gestion_turno FROM gestion_turno WHERE llamado='0' ORDER by fecha_registro ASC LIMIT 1");
        $query->execute();

        if(empty($query)){
          $gestion_id = 0;
        }else{
          foreach ($query as $datos){
            $gestion_id = $datos["id_gestion_turno"];
          }
        }
        return $gestion_id;
    }

    public function modificar_llamdo($gestion_id,$modulo){

        $query = $this->conexion->prepare("UPDATE gestion_turno SET llamado=1, modulo= :modulo WHERE id_gestion_turno=:gestion_id");
         $query->execute(array(':gestion_id'=>$gestion_id,':modulo'=>$modulo));
    }

    //tipo de turno
    public function modulo_actual_t(){
        $query = $this->conexion->prepare("SELECT * FROM gestion_turno WHERE llamado=1 ORDER BY id_gestion_turno DESC LIMIT 0,1");
        $query->execute();

        if(empty($query)){
          $tipo_turno = 0;
        }else{
          foreach ($query as $datos){
            $tipo_turno = $datos["tipo_turno"];
          }
        }
        return $tipo_turno;
    }

    public function modulo_anterior_t(){
        $query = $this->conexion->prepare("SELECT * FROM gestion_turno WHERE llamado=1 ORDER BY id_gestion_turno DESC LIMIT 1,1");
        $query->execute();

        if(empty($query)){
          $tipo_turno = 0;
        }else{
          foreach ($query as $datos){
            $tipo_turno = $datos["tipo_turno"];
          }
        }
        return $tipo_turno;
    }

    public function modulo_anterior_2_t(){
        $query = $this->conexion->prepare("SELECT * FROM gestion_turno WHERE llamado=1 ORDER BY id_gestion_turno DESC LIMIT 2,1");
        $query->execute();

        if(empty($query)){
          $tipo_turno = 0;
        }else{
          foreach ($query as $datos){
            $tipo_turno = $datos["tipo_turno"];
          }
        }
        return $tipo_turno;
    }

    public function modulo_anterior_3_t(){
        $query = $this->conexion->prepare("SELECT * FROM gestion_turno WHERE llamado=1 ORDER BY id_gestion_turno DESC LIMIT 3,1");
        $query->execute();

        if(empty($query)){
          $tipo_turno = 0;
        }else{
          foreach ($query as $datos){
            $tipo_turno = $datos["tipo_turno"];
          }
        }
        return $tipo_turno;
    }
    //fin tipo turno

    //numero de turno
    public function llamar_turno_actual(){
        $query = $this->conexion->prepare("SELECT turno FROM gestion_turno WHERE llamado=1 ORDER BY id_gestion_turno DESC LIMIT 0,1");
        $query->execute();

        if(empty($query)){
          $turno = 0;
        }else{
          foreach ($query as $datos){
            $turno = $datos["turno"];
          }
        }
        return $turno;
    }

    public function llamar_turno_anterior(){
        $query = $this->conexion->prepare("SELECT turno FROM gestion_turno WHERE llamado=1 ORDER BY id_gestion_turno DESC LIMIT 1,1");
        $query->execute();

        if(empty($query)){
          $turno = 0;
        }else{
          foreach ($query as $datos){
            $turno = $datos["turno"];
          }
        }
        return $turno;
    }

    public function llamar_turno_anterior_2(){
        $query = $this->conexion->prepare("SELECT turno FROM gestion_turno WHERE llamado=1 ORDER BY id_gestion_turno DESC LIMIT 2,1");
        $query->execute();

        if(empty($query)){
          $turno = 0;
        }else{
          foreach ($query as $datos){
            $turno = $datos["turno"];
          }
        }
        return $turno;
    }

    public function llamar_turno_anterior_3(){
        $query = $this->conexion->prepare("SELECT turno FROM gestion_turno WHERE llamado=1 ORDER BY id_gestion_turno DESC LIMIT 3,1");
        $query->execute();

        if(empty($query)){
          $turno = 0;
        }else{
          foreach ($query as $datos){
            $turno = $datos["turno"];
          }
        }
        return $turno;
    }
    //fin de numero tueno

    //numero de modulo
    public function modulo_actual(){
        $query = $this->conexion->prepare("SELECT * FROM gestion_turno WHERE llamado=1 ORDER BY id_gestion_turno DESC LIMIT 0,1");
        $query->execute();

        if(empty($query)){
          $modulo = 0;
        }else{
          foreach ($query as $datos){
            $modulo = $datos["modulo"];
          }
        }
        return $modulo;
    }

    public function modulo_anterior(){
        $query = $this->conexion->prepare("SELECT * FROM gestion_turno WHERE llamado=1 ORDER BY id_gestion_turno DESC LIMIT 1,1");
        $query->execute();

        if(empty($query)){
          $modulo = 0;
        }else{
          foreach ($query as $datos){
            $modulo = $datos["modulo"];
          }
        }
        return $modulo;
    }

    public function modulo_anterior_2(){
        $query = $this->conexion->prepare("SELECT * FROM gestion_turno WHERE llamado=1 ORDER BY id_gestion_turno DESC LIMIT 2,1");
        $query->execute();

        if(empty($query)){
          $modulo = 0;
        }else{
          foreach ($query as $datos){
            $modulo = $datos["modulo"];
          }
        }
        return $modulo;
    }

    public function modulo_anterior_3(){
        $query = $this->conexion->prepare("SELECT * FROM gestion_turno WHERE llamado=1 ORDER BY id_gestion_turno DESC LIMIT 3,1");
        $query->execute();

        if(empty($query)){
          $modulo = 0;
        }else{
          foreach ($query as $datos){
            $modulo = $datos["modulo"];
          }
        }
        return $modulo;
    }
    //fin de numero modulo

    public function cant_turnos(){
        $query = $this->conexion->prepare("SELECT count(*) FROM gestion_turno ");
        $query->execute();

        if(empty($query)){
          $llamado = 0;
        }else{
          foreach ($query as $datos){
            $cantidad_turnos = $datos["count(*)"];
          }
        }
        return $cantidad_turnos;
    }

    public function cant_modulo($i){
        $query = $this->conexion->prepare("SELECT modulo FROM gestion_turno WHERE id_gestion_turno=:i and modulo <> 0 and llamado = 0 ");
        $query->execute(array(':i'=>$i));

        if(empty($query)){
          $llamado = 0;
        }else{
          foreach ($query as $datos){
            $turno_modulo = $datos["modulo"];
          }
        }
        return $turno_modulo;
    }

    public function asignar_modulo(){

        $query = $this->conexion->prepare("UPDATE gestion_turno SET modulo=2 WHERE llamado='0' ORDER by fecha_registro ASC LIMIT 1");
         $query->execute();
    }
}