<?php

$servidor = "localhost";
$usuario = "root";
$password = "";
$bbdd = "crm_preatencion";

$conn = mysqli_connect($servidor, $usuario, $password, $bbdd);

if (!$conn) {
    die("Conexion fallida: " . mysqli_connect_error());
} 
else {
// echo "Conexion exitosa";
}