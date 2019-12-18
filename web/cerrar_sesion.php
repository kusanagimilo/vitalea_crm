<?php
	require_once '../clase/Sesion.php';
   //Reanudamos la sesión 
	@session_start(); 

	$sesion = new Sesion();
	 $sesion->log_usuario($_SESSION['ID_USUARIO'],8);

    session_unset();
    session_destroy();
    header("Location: ../index.php");
?>