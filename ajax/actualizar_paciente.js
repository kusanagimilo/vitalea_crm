
function actualizar_paciente(){
       var tipo_cliente = $('.i-checks:checked').val();

        var usuario_id =  $("#usuario_id").val();
        var cliente_id =  $("#cliente_id").val();

    if(tipo_cliente == "Tercero"){
        var cantidad_tercero = $("#cantidad_tercero").val();

        if(cantidad_tercero == 0 || typeof cantidad_tercero === 'undefined'){
            alertify.alert("Ingrese al menos un registro de Tercero");
            return false;
        }
    }

    var tipo_documento = $("#tipo_documento").val();
    var nombre = $("#nombre").val();
    var apellido = $("#apellido").val();
    var numero_documento = $("#numero_documento").val();
    var telefono_uno = $("#telefono_uno").val();
    var telefono_dos = $("#telefono_dos").val();
    var email = $("#email").val();
    var sexo = $("#sexo").val();
    var fecha_nacimiento = $("#fecha_nacimiento").val();
    var estado_civil = $("#estado_civil").val();
    var departamento = $("#departamento").val();
    var ciudad = $("#ciudad").val();
    var barrio = $("#barrio").val();
    var estrato = $("#estrato").val();
    var direccion_actual = $("#direccion_actual").val();
    var direccion = $("#direccion").val();


    var direccion_actualizar = "";

    if(direccion.length == 0){
        direccion_actualizar =  direccion_actual;
    }
    else{
        direccion_actualizar = direccion;
    }

    $.ajax({
        url: '../controladores/Cliente.php',
        data:
                {
                    tipo: 9,
                    tipo_documento:tipo_documento,
                    nombre:nombre,
                    apellido:apellido,
                    numero_documento:numero_documento,
                    telefono_uno:telefono_uno,
                    telefono_dos:telefono_dos,
                    email:email,
                    sexo:sexo,
                    fecha_nacimiento:fecha_nacimiento,
                    estado_civil:estado_civil,
                    departamento:departamento,
                    ciudad:ciudad,
                    barrio:barrio,
                    estrato:estrato,
                    direccion_actualizar:direccion_actualizar,
                    usuario_id:usuario_id,
                    cliente_id:cliente_id,
                    tipo_cliente:tipo_cliente

                },
        type: 'post',
        success: function (data)
        {

            alertify.alert("Actualizacion de datos realizada", function(){
                            window.close();
                });

        }
    });
}



function actualizar_tercero(){
   
        var usuario_id =  $("#usuario_id").val();
        var tercero_id =  $("#tercero_id").val();


         var tipo_documento_tercero = $("#tipo_documento_tercero").val();
         var numero_documento_tercero = $("#numero_documento_tercero").val();
         var nombre_tercero = $("#nombre_tercero").val();
         var apellido_tercero = $("#apellido_tercero").val();
         var fecha_nacimiento_tercero = $("#fecha_nacimiento_tercero").val();
         var sexo_tercero = $("#sexo_tercero").val();
         var parentesco = $("#parentesco").val();


         
            if(tipo_documento_tercero.length == 0){
                alertify.alert("Seleccione un <b>Tipo de documento</b> del Tercero");
                return false;
            }
            else if(numero_documento_tercero.length == 0){
                alertify.alert("Ingrese el <b>Numero de Documento</b> del Tercero");
                return false;
            }
            else if(nombre_tercero.length == 0){
                alertify.alert("Ingrese <b>Nombre</b> del Tercero");
                return false;
            }
            else if(apellido_tercero.length == 0){
                 alertify.alert("Ingrese <b>Apellido</b> del Tercero");
                return false;
            }
            else if(fecha_nacimiento_tercero.length == 0){
                 alertify.alert("Seleeccion <b>Fecha de Nacimiento</b> del Tercero");
                return false;
            }
             else if(sexo_tercero.length == 0){
                 alertify.alert("Seleccione <b>Genero</b> del Tercero");
                return false;
            }
             else if(parentesco.length == 0){
                 alertify.alert("Seleccione <b>Parentesco</b>");
                return false;
            }
    
    $.ajax({
        url: '../controladores/Cliente.php',
        data:
                {
                    tipo: 10,
                    tipo_documento_tercero:tipo_documento_tercero,
                    numero_documento_tercero:numero_documento_tercero,
                    nombre_tercero:nombre_tercero,
                    apellido_tercero:apellido_tercero,
                    fecha_nacimiento_tercero:fecha_nacimiento_tercero,
                    sexo_tercero:sexo_tercero,
                    parentesco:parentesco,
                    usuario_id:usuario_id,
                    tercero_id:tercero_id

                },
        type: 'post',
        success: function (data)
        {

            alertify.alert("Actualizacion de datos realizada", function(){
                            window.close();
                });

        }
    });
}


function cargar_tercero(){

    var cliente_id = $("#cliente_id").val();

     $.ajax({
        url: '../controladores/Gestion.php',
        data:
                {
                    tipo: 26,                   
                    cliente_id:cliente_id
                },
        type: 'post',
        success: function (data)
        {
            if(data == 1){
              
                
            }else{
                $("#div_informacion_terceros").html(data);
               
            }
        }
     });
}



