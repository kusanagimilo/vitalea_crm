<?php
require_once '../include/script.php';
require_once '../include/header_administrador.php';
?>
<link rel="stylesheet" href="../web/css/estilosForzados.css">
<body style="background-color: #F6F8FA;">
     <input id="usuario" value="<?php echo $_SESSION['ID_USUARIO'] ?>" type="hidden" >

    <div class="main-menu-area mg-tb-40" style="min-height: 450px;">
        <div class="container" style="height:auto;">
            <div class="row">
            	
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <ol class="breadcrumb">
                        
                        <li><a href="inicio_administrador.php" title="Volver atras"><img src="images/atras.png"></a></li>
                        <li><a href="inicio_administrador.php" title="Inicio">Inicio</a></li>
                        
                        <li class="active">Valores de Referencia</li>
                    </ol>

                    <div class="panel panel-default">
                        <div class="panel-heading " style="height: 50px;">
                            <h3 class="panel-title"> 
                                <b  style="float: left">  <img src="images/agregar-usuario.png" alt=""/> 
                                Valores de Referencia</b> </h3> 
                        </div>
                        <table class="table table-bordered"> 
                            <tr id="p2">
                                <th>¿Realizas visitas periódicas al médico?</th>
                                <td><select id="pregunta_2" style="width: 100%">
                                        <option value="">Seleccione</option>
                                        <option value="Si">Si</option>
                                        <option value="No">No</option>
                                    </select></td>
                            </tr>
                            <tr>
                                <label for="" class="labelCrearCliente">¿Como conociste Vitalea?</label>
                                <select name="" id="">
                                    <option value="">Instagram</option>
                                    <option value="">Facebook</option>
                                    <option value="">Pagina Web</option>
                                    <option value="">Un Amigo</option>
                                    <option value="">Vi el local</option>
                                </select>
                            </tr>
                        </table>    
                    </div>
                </div>
            </div>
        </div>

        <div class="table-responsive col-lg-10 col-md-offset-1" style="overflow: auto; height: 260px;" >
            <div class="dataTables_wrapper">
                <table class="table table-bordered dataTable no-footer" role="grid">
                    <thead>
                        <tr class="headerTabla">
                            <th>Id</th>
                            <th>Id Examen</th>
                            <th>Tipo de Medida</th>
                            <th>Unidad</th>
                            <th>Valor Critico Inferior</th>
                            <th>Valor Critico Superior</th>
                            <th>Anormal disminuido Minimo</th>
                            <th>Anormal disminuido Maximo</th>
                            <th>Rango normal Minimo</th>
                            <th>Rango normal Maximo</th>
                            <th>Anormal incrementado Minimo</th>
                            <th>Anormal incrementado Maximo</th>
                            <th>Edad Minima</th>
                            <th>Edad Maxima</th>
                            <th>Sexo</th>
                            <th>Otros</th>
                        </tr>
                    </thead>
                    <tbody id="filasCuerpoTabla">
                    </tbody>
                </table>
            </div>
            
        </div>

        
    </div>    
    <?php require_once '../include/footer.php'; ?>
    <script src="../ajax/valoresRef.js"></script>
</body>
