

function mostrar(id) {
        $(document).ready(function () {
      
            $("#result").hide("slow");
            $("#cargar_reporte").show("slow");
            $("#editar_resul").load("actualizar_cliente.php?cliente_id=" + id, " ", function () {
                $("#editar_resul").show("slow");
                $("#cargar_reporte").hide("slow");
            });
        });
    }

function listar_macro_proceso(){
     $.ajax({
            url: '../controladores/Cliente.php',
            data:
                    {
                        tipo: 5
                    },
            type: 'post',
            dataType: 'json',
            success: function (data)
            {
          
            $.each(data, function(i,cliente){
                var newRow ="<option value='"+cliente.id+"'>"+cliente.nombre+"</option>";
                $(newRow).appendTo("#macro_proceso");
            });
           

            }
        });
}

function listar_tipificaciones(){
    
    var macro_proceso = $("#macro_proceso").val();
    var permiso = $("#permiso").val();

    console.log(macro_proceso+" permiso: "+permiso);
    
     $.ajax({
            url: '../controladores/Cliente.php',
            data:
                    {
                        tipo: 6,
                        macro_proceso:macro_proceso,
                        permiso:permiso
                    },
            type: 'post',
            success: function (data)
            {
                
            $("#tipificaciones").html(data);
            
            }
        });
}

function medios_comunicacion(){
    
     $.ajax({
            url: '../controladores/Gestion.php',
            data:
                    {
                        tipo: 3
                    },
            type: 'post',
            dataType: 'json',
            success: function (data)
            {
                $.each(data, function(i,cliente){
                var newRow ="<option value='"+cliente.id+"'>"+cliente.nombre+"</option>";
               
                    $(newRow).appendTo("#medios_comunicacion");
                });
            
            }
        });
}

function div_medio_comunicacion(){
     var medio_comunicacion_id = $("#medios_comunicacion").val();

     if(medio_comunicacion_id < 8) {
        $.ajax({
            url: '../controladores/Gestion.php',
            data:
                    {
                        tipo: 12,
                        medio_comunicacion_id:medio_comunicacion_id

                    },
            type: 'post',
            dataType: 'json',
            success: function (data)
            {
                 $("#imagen_medio_comunicacion").empty();
                 $("#texto_comunicacion").empty();

                $.each(data, function(i,cliente){
                var texto = "<b>"+cliente.texto+"</b>";    
                var imagen = "<img src='"+cliente.imagen+"'>" ; 
                     $(imagen).appendTo("#imagen_medio_comunicacion");
                     $(texto).appendTo("#texto_comunicacion");
                });  
            
            }
        });
        $("#medio_chat").css("display","block");
    }else{
        $("#medio_chat").css("display","none");
        $("#imagen_medio_comunicacion").css("display","none");
        $("#texto_comunicacion").css("display","none");
    }       
       

}

function informacion_cliente(){
    
    var id_cliente = $("#id_cliente").val();
    console.log(id_cliente);
    
    $.ajax({
            url: '../controladores/Gestion.php',
            data:
                    {
                        tipo: 4,
                        id_cliente:id_cliente
                    },
            type: 'post',
            dataType: 'json',
            success: function (data)
            {
                $.each(data, function(i,cliente){
                    var newRow ="<table class='tinfo table table-striped' id='info' style='width:100%;'>";
                        newRow +="<tr><th style='color:#0C4F5A;text-align: right;'>Tipo de documento</th>";
                        newRow +="<td data-label='Tipo de documento'>"+cliente.tipo_documento+"</td>";
                       newRow +="<th style='color:#0C4F5A;text-align: right;'>N° Documento</th>";
                        newRow +="<td data-label='N° Documento'>"+cliente.documento+"</td></tr>";

                        newRow +="<tr><th data-label='t_nombre' style='color:#0C4F5A;text-align: right;'>Nombres</th>";
                        newRow +="<td data-label='Nombre'>"+cliente.nombre_cliente+"</td>";
                        newRow +="<th data-label='t_nombre' style='color:#0C4F5A;text-align: right;'>Apellidos</th>";
                        newRow +="<td data-label='Apellidos'>"+cliente.apellido_cliente+"</td></tr>";


                        newRow +="<tr><th data-label='t_fecha' style='color:#0C4F5A;text-align: right;'>Fecha de Nacimiento</th>";
                        newRow +="<td data-label='Fecha de Nacimiento'>"+cliente.fecha_nacimiento+"</td>";
                        newRow +="<th data-label='email' style='color:#0C4F5A;text-align: right;'>Email</th>";
                        newRow +="<td data-label='Email'>"+cliente.email+"</td></tr>";

                        newRow +="<tr><th data-label='t_telefono_1' style='color:#0C4F5A;text-align: right;'>Telefono 1</th>";
                        newRow +="<td data-label='Telefono 1'>"+cliente.telefono_1+"</td>";
                        newRow +="<th data-label='t_telefono_1' style='color:#0C4F5A;text-align: right;'>Telefono 2</th>";
                        newRow +="<td data-label='Telefono 2'>"+cliente.telefono_2+"</td></tr>";


                        newRow +="<tr><th data-label='t_departamento' style='color:#0C4F5A;text-align: right;'>Departamento</td>";
                        newRow +="<td data-label='Departamento'>"+cliente.departamento+"</td>";
                        newRow +="<th data-label='t_departamento' style='color:#0C4F5A;text-align: right;'>Ciudad</td>";
                        newRow +="<td data-label='Ciudad'>"+cliente.ciudad+"</td></tr>";

                        
                        newRow +="<tr><th data-label='t_barrio' style='color:#0C4F5A;text-align: right;'>Direccion</th>";
                        newRow +="<td data-label='Direccion'>"+cliente.direccion+"</td>";
                        newRow +="<th data-label='t_barrio' style='color:#0C4F5A;text-align: right;'>Barrio</th>";
                        newRow +="<td data-label='Barrio'>"+cliente.barrio+"</td></tr>";

                        newRow +="<tr><th data-label='t_estadocivil' style='color:#0C4F5A;text-align: right;'>Estado civil</th>";
                        newRow +="<td data-label='Estado Civil'>"+cliente.estado_civil+"</td>";
                        newRow +="<th data-label='t_estadocivil' style='color:#0C4F5A;text-align: right;'>Sexo</th>";
                        newRow +="<td data-label='Sexo'>"+cliente.sexo+"</td></tr>";

                        newRow +="<tr><th data-label='t_estrato' style='color:#0C4F5A;text-align: right;'>Estrato</th>";
                        newRow +="<td data-label='Estrato'>"+cliente.estrato+"</td>";
                        newRow +="<th data-label='t_estrato' style='color:#0C4F5A;text-align: right;'>Estado</th>";
                        newRow +="<td data-label='Estado'>"+cliente.estado+"</td></tr>";

                        newRow +="<tr><th data-label='t_tipo_cliente' style='color:#0C4F5A;text-align: right;'>Tipo Cliente</th>";
                        newRow +="<td data-label='Tipo Cliente'>"+cliente.tipo_cliente+"</td><th style='color:#0C4F5A;text-align: right;'>Clasificación</th><td data-label='Clasificación'>"+cliente.clasificacion+"</td></tr>";
                        newRow +="</table>";
                    $(newRow).appendTo("#tabla_informacion_cliente");
                    var nombre_cliente ="<b>"+cliente.nombre_cliente+" "+cliente.apellido_cliente+"</b>";
                     $(nombre_cliente).appendTo("#nombre_cliente");
                });
            
            }
        });
}


function addCommas(nStr)
{
    nStr += '';
    x = nStr.split('.');
    x1 = x[0];
    x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    return x1 + x2;
}

