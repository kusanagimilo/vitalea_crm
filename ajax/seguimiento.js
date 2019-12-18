
function filtro_seguimiento(){

    var tipificaciones = $("#tipificaciones").val();
    var fecha_inicial = $("#fecha_inicial").val();
    var fecha_final = $("#fecha_final").val();

    if(tipificaciones == ""){
        tipificaciones = 0;
    }

    
    if( $('#prospectos').is(':checked') ) {
        prospectos = 1;
    }
    else{
        prospectos = 0;
    }

    $.ajax({
        url: '../controladores/Seguimiento.php',
        data:
                {
                    tipo: 1,
                    tipificaciones:tipificaciones,
                    fecha_inicial:fecha_inicial,
                    fecha_final:fecha_final,
                    prospectos:prospectos

                },
        type: 'post',
        success: function (data)
        {
                $("#resultados").html(data);
                $("#div_usuarios").css("display","block");
            
        }
    });
}


function asignacion(){

    var chkArray = [];
    $(".asignacion:checked").each(function() {
        chkArray.push($(this).val());
    });
    
    var selected;
    selected = chkArray.join(',') ;
   
    var usuario_asignacion = $("#usuario_asignacion").val();


    $.ajax({
        url: '../controladores/Seguimiento.php',
        data:
                {
                    tipo: 2,
                    usuario_asignacion:usuario_asignacion,
                    selected:selected


                },
        type: 'post',
        success: function (data)
        {
              alertify.alert("Seguimiento asignados", function(){
                            location.reload();
                });

        }
    });

}

function envioMasivo(){

var formData = new FormData($(".formulario")[0]);
var file = $("#archivo")[0].files[0];
$.ajax(
        {
            url: '../controladores/envioMasivo.php',
            data: formData,
            type: 'post',
            cache: false,
            contentType: false,
            processData: false,
            success: function (data)
            {
              alertify.alert("Correo enviado"); 
            }
        })

}



