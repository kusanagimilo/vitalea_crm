<?PHP
require_once '../include/script.php';
require_once '../include/header_administrador.php';
$array_permisos = explode(",", $_SESSION['PERMISOS']);
?>
<script src="../ajax/valoresRef.js" type="text/javascript"></script>
<style>
    .modalContainer {
			display: none; 
			position: fixed; 
			z-index: 1;
			padding-top: 100px;
			left: 0;
			top: 0;
			width: 100%;
			height: 100%; 
			overflow: auto; 
			background-color: rgb(0,0,0);
			background-color: rgba(0,0,0,0.4);
		}

		.modalContainer .modal-content {
			background-color: #fefefe;
			margin: auto;
			padding: 20px;
			border: 1px solid lightgray;
			border-top: 10px solid #214761;
			width: 70%;
            display: flex;
            justify-content: center;
            flex-direction: column;
            overflow: auto;
		}

		.modalContainer .close {
			color: #000000;
			float: right;
			font-size: 35px;
			font-weight: bold;
		}

		.modalContainer .close:hover,
		.modalContainer .close:focus {
			color: #000;
			text-decoration: none;
			cursor: pointer;
		}

        .tablaModal {
            display: flex;
            justify-content: center;
            font-size: 15px;
            padding: 20px;
            transform: scale(0.8);
        }

        .tituloTabla{
            display: flex;
            justify-content: center;
            margin: 50px;
        }
              
        .tablaModal > tr > td {
            font-weight: 50;
            font-size: 14px;
            /* position: relative !important; */
        }

        input[type="text"] {
            margin: 7px;
        }

        .botonEspecial {
            margin-top: 10px;
            position: absolute;    
            bottom: 2%;
            left: 45%;
        }

        @media screen and (max-width: 800px){
            .modalContainer .modal-content {
                width: 95% !important;                              
            }  

            .tablaModal {
                transform: scale(0.7);
                width: 100%;                                
            }
        }

        @media screen and (max-width: 460px){
            .modalContainer {
                padding: 70px 0px;
            }

            .modalContainer .modal-content {
                width: 100% !important;                              
            }
            
            .modal-content {                 
                margin: 0;
            }

            .tituloTabla{                
                margin: 0;
            }

            .tablaModal {
                margin-left: 14%;
                margin-right: 0;
                padding: 0;
                transform: scale(0.7);
                width: 100%;
                border: #010101;                
            }

            input[type="text"] {
                max-width: 60%;
                margin-left: 0;
                margin-right: 0;
                margin-bottom: 20px;
                padding: 0;
                border: 1px doted #004040;
            }
        }
</style>
<body>
    <div class="main-menu-area mg-tb-40">
        <div class="container" style="height:auto;">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <ol class="breadcrumb">
                        <li><a href="administrador.php" title="Volver atras"><img src="images/atras.png"></a></li>
                        <li class="active">Valores de referencia</li>
                    </ol>

                    <div class="row pad-top" style="background-color: white;">

                        <div id="clientes" style="padding: 20px;">
                            <div class="row">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h3 class="panel-title"> 
                                            <img src="images/lista.png" alt=""/> 
                                            <b> Lista de valores de referencia</b></h3>
                                    </div>
                                    <div class="panel-body">

                                        <p style="font-size: 11pt;">
                                            <img src="images/info.png" alt="">
                                            En esta opcion podras consultar y crear los valores de referencia.
                                        </p>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <br>
                                                <button class="btn btn-primary" id="btnModal" style="width: 40%; margin-right: 40px; ">Crear valor de referencia</button>
                                                <button data-toggle="modal" data-target="#myModalPerfiles" class="btn btn-danger" id="btnModificarValorRef">Modificar valor de referencia </button>
                                            </div>
                                        </div>

                                        <br>

                                        <div id="tabla_valor_referencia" class="table-responsive">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> 


                    </div>

                </div>
            </div>
        </div>
    </div>

    
	<div id="tvesModal" class="modalContainer">
		<div class="modal-content">
			<span class="close">×</span>
			<h2 class="tituloTabla card-title">Ingresa un nuevo valor de referencia</h2>
			<table class="tablaModal">
                <tr>
                    <td>
                        <label for="">Codigo de Examen</label>                        
                    </td>
                    <td>
                        <input type="text">
                    </td>
                    <td>
                        <label for="">Nombre del examen</label>                        
                    </td>
                    <td>
                        <input type="text">
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="">Medida</label>                        
                    </td>
                    <td>
                        <input type="text">
                    </td>
                    <td>
                        <label for="">Unidad</label>                        
                    </td>
                    <td>
                        <input type="text">
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="">Valor Critico Inferior</label>
                    </td>
                    <td>
                        <input type="text">
                    </td>
                    <td>
                        <label for="">Valor Critico Superior</label>
                    </td> 
                    <td>    
                        <input type="text">
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="">Anormal Disminuido Minimo</label>                        
                    </td>
                    <td>
                        <input type="text">
                    </td>
                    <td>
                        <label for="">Anormal Disminuido Maximo</label>                        
                    </td>
                    <td>
                        <input type="text">
                    </td>                
                </tr>
                <tr>
                    <td>
                        <label for="">Rango Normal Minimo</label>                        
                    </td>
                    <td>
                        <input type="text">
                    </td>
                    <td>
                        <label for="">Rango Normal Maximo</label>                        
                    </td>  
                    <td>
                        <input type="text">
                    </td>              
                </tr>
                <tr>
                    <td>
                        <label for="">Anormal Incrementado Minimo</label>                        
                    </td>
                    <td>
                        <input type="text">
                    </td>
                    <td>
                        <label for="">Anormal Incrementado Maximo</label>                        
                    </td>
                    <td>
                        <input type="text">
                    </td>                
                </tr>
                <tr>
                    <td>
                        <label for="">Edad Minima</label>                        
                    </td>
                    <td>
                        <input type="text">
                    </td>
                    <td>
                        <label for="">Edad Maxima</label>                        
                    </td>
                    <td>
                        <input type="text">
                    </td>                
                </tr>
                <tr>
                    <td>
                        <label for="">Sexo</label>                        
                    </td>
                    <td>
                        <input type="text">
                    </td>
                    <td>
                        <label for="">Otros</label>                        
                    </td>
                    <td>
                        <input type="text">
                    </td>                
                </tr>
                <tr>
                    <td>
                        <label for="">Unidad Edad</label>                        
                    </td>
                    <td>
                        <input type="text">
                    </td>               
                </tr>
                <button class="btn btn-success botonEspecial">Enviar Datos</button>
            </table>
		</div>
	</div>

    <script>
        
    //Llamamos la Funcion que nos trae todos los valores de referencia a mostrar.
    verValoresReferencia();
        
    
    //Creacion de Ventana Modal
        if(document.getElementById("btnModal")){
			var modal = document.getElementById("tvesModal");
			var btn = document.getElementById("btnModal");
			var span = document.getElementsByClassName("close")[0];
			var body = document.getElementsByTagName("body")[0];

			btn.onclick = function() {
				modal.style.display = "block";

				body.style.position = "static";
				body.style.height = "100%";
				body.style.overflow = "hidden";
			}

			span.onclick = function() {
				modal.style.display = "none";

				body.style.position = "inherit";
				body.style.height = "auto";
				body.style.overflow = "visible";
			}

			window.onclick = function(event) {
				if (event.target == modal) {
					modal.style.display = "none";

					body.style.position = "inherit";
					body.style.height = "auto";
					body.style.overflow = "visible";
				}
			}
		}
    </script>
    <?php require_once '../include/footer.php'; ?>
</body>
