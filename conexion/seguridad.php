<?php 
ini_set("session.cookie_lifetime","9000");
ini_set("session.gc_maxlifetime","9000");
//Reanudamos la sesión 
@session_start(); 
//Validamos si existe realmente una sesión activa o no 
if($_SESSION["autentica"] != "SIP")
{ 
  //Si no hay sesión activa, lo direccionamos al index.php (inicio de sesión) 
  header("Location: ../index.php"); 
  exit(); 
} 
?>
