<?php

class Conexion extends PDO {

    public function __construct() {

        /* pruebas */
        /* $servidor="localhost"; 
          $usuario="annar";
          $password="4nn4r*2019";
          $base = "crm_preatencion"; */

        /* produccion */
        $servidor = "localhost";
        $usuario = "root";
        $password = "";
        $base = "crm_preatencion";

        try {
            parent::__construct('mysql:host=' . $servidor . ';dbname=' . $base, $usuario, $password, array(
                PDO::ATTR_EMULATE_PREPARES => false,
                PDO::MYSQL_ATTR_LOCAL_INFILE => 1,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
                    )
            );
        } catch (PDOException $e) {
            print "Error:" . $e->getMessage() . "";
            die();
        }
    }

}
