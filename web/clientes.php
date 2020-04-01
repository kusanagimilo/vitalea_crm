<?PHP require_once '../include/script.php';
require_once '../include/header_administrador.php';
require_once '../clase/Usuario.php';
require_once '../clase/Cliente.php';
require_once '../clase/Laboratorio.php';

$usuario = new Usuario();
$cliente = new Cliente();
$laboratorio = new Laboratorio();
?>
<script src="../ajax/gestion_usuario.js" type="text/javascript"></script>
<script>
    $(document).ready(function() {
        $('#lista_cliente').DataTable();
        $('#lista_laboratorios').DataTable();
        $('#lista_examenes').DataTable();
        $('#lista_tipificacion').DataTable();
    });
</script>

<body style="background-color: #F6F8FA">

    <div class="main-menu-area mg-tb-40">
        <div class="container" style="height:auto;">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <ol class="breadcrumb">
                        <li><a href="inicio_administrador.php" title="Volver atras"><img src="images/atras.png"></a></li>

                        <li><a href="inicio_administrador.php" title="Inicio">Inicio</a></li>
                        <li class="active">Lista de Clientes</li>
                    </ol>

                    <div class="row pad-top" style="background-color: white;">

                        <div id="clientes" style="padding: 20px;">
                            <div class="row">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">
                                            <img src="images/lista.png" alt="" />
                                            <b> Lista de Clientes</b></h3>
                                    </div>
                                    <div class="panel-body">
                                        <table id="lista_cliente" class="table table-bordered">
                                            <thead>
                                                <tr style="background-color: #214761;">
                                                    <th style="color:white">Tipo de Documento</th>
                                                    <th style="color:white">No. Documento</th>
                                                    <th style="color:white">Nombre Completo</th>
                                                    <th style="color:white">Telefono 1</th>
                                                    <th style="color:white">Ciudad</th>
                                                    <th style="color:white">Perfil</th>
                                                    <th style="color:white">Tipo</th>
                                                    <th style="color:white">Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $lista_cliente = $cliente->listar_cliente();
                                                foreach ($lista_cliente as $datos_cliente) { ?>
                                                    <tr>
                                                        <td><?php echo $datos_cliente["nombre"] ?></td>
                                                        <td><?php echo $datos_cliente["documento"] ?></td>
                                                        <td><?php echo $datos_cliente["nombre_completo"] ?></td>
                                                        <td><?php echo $datos_cliente["telefono_1"] ?></td>
                                                        <td><?php echo $datos_cliente["ciudad"] ?></td>

                                                        <td><?php echo $datos_cliente["clasificacion"] ?></td>
                                                        <td><?php echo $datos_cliente["tipo_cliente"] ?></td>
                                                        <td><a href="ver_detalle_cliente.php?cliente_id=<?php echo $datos_cliente["id_cliente"] ?>">
                                                                <button class="btn btn-default"> <img src="images/lupa.png" style="width: 20px;"> Ver</button>
                                                            </a>
                                                            <a href="ver_detalle_cliente2.php?cliente_id=<?php echo $datos_cliente["id_cliente"] ?>">
                                                                <button class="btn btn-danger"><i class="fas fa-edit"></i> Editar</button>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                <?php }

                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- End Contact Info area-->
    <?php require_once '../include/footer.php'; ?>

</body>

</html>