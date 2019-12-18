<?PHP //require_once '../include/script.php';
require_once '../include/script.php';
require_once '../include/header_administrador.php';

require_once '../clase/Gestion.php';

$gestion = new Gestion();

$gestion_id = base64_decode($_REQUEST["id"]);

$id_cliente = $gestion->gestion_cliente_id($gestion_id);


$array_permisos = explode(",", $_SESSION['PERMISOS']);
$conteo = count($array_permisos);

if ($conteo == 1) {
    if (in_array("1", $array_permisos)) { // PERMISO CALL CENTER
        $permiso = 1;

    } else if (in_array("2", $array_permisos)) { //PERMISO PRESENCIAL
        $permiso = 2;
    }
}


?>