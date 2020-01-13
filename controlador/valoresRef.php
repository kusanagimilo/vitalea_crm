<?php

header ("Content-Type: application/json; charset=UTF-8");
require "../conexion/conexionBasica.php";

$db = mysqli_select_db( $conn, $bbdd);

$sql = mysqli_query($conn, "SELECT * FROM valor_referencia");

$salida = array();
$salida = $sql->fetch_all(MYSQLI_ASSOC);

$sqlJson = json_encode($salida);
  
echo $sqlJson;


mysqli_close($conn);
?>