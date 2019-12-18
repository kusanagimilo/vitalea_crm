<?php

    class db{
        // Variables de conexión
        private $host = 'localhost';
        private $usuario = 'root';
        private $password = 'bi2f5Oav2806*';
        private $base = 'crm_preatencion';
        

        // Conectar a BD
        public function conectar(){
            $conexion_mysql = "mysql:host=$this->host;dbname=$this->base";
            $conexionDB = new PDO($conexion_mysql, $this->usuario, $this->password);
            $conexionDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            //Esta linea arregla la codificacion sino no aparecen en la salida en JSON quedan NULL
            $conexionDB -> exec("set names utf8");
            return $conexionDB;
           
        }
    }
  


    

