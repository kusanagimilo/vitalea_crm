
function busqueda_por_usuario(){
  var usuario = $("#lista_usuarios").val();

  $.ajax({
        url: '../controladores/Log.php',
        data:
                {
                    tipo: 2,
                    busqueda:1,
                    usuario:usuario
                },
        type: 'post',
        success: function (data)
        {
                $("#tabla_resultado").html(data);
                $("#tabla_inicial").css("display","none");
            
        }
    });    
}

function busqueda_por_gestion(){
  var tiempos_gestion = $("#tiempos_gestion").val();

  $.ajax({
        url: '../controladores/Log.php',
        data:
                {
                    tipo: 2,
                    busqueda:2,
                    tiempos_gestion:tiempos_gestion
                },
        type: 'post',
        success: function (data)
        {
                $("#tabla_resultado").html(data);
                $("#tabla_inicial").css("display","none");
            
        }
    }); 
}

function busqueda_por_fecha(){
   var fecha_inicio = $("#fecha_inicio").val();

  $.ajax({
        url: '../controladores/Log.php',
        data:
                {
                    tipo: 2,
                    busqueda:3,
                    fecha_inicio:fecha_inicio
                },
        type: 'post',
        success: function (data)
        {
                $("#tabla_resultado").html(data);
                $("#tabla_inicial").css("display","none");
            
        }
    }); 
}

function busqueda_por_usuario_fecha(){
  var usuario = $("#lista_usuarios").val();
  var fecha_inicio = $("#fecha_inicio").val();

  $.ajax({
        url: '../controladores/Log.php',
        data:
                {
                    tipo: 2,
                    busqueda:4,
                    usuario:usuario,
                    fecha_inicio:fecha_inicio
                },
        type: 'post',
        success: function (data)
        {
                $("#tabla_resultado").html(data);
                $("#tabla_inicial").css("display","none");
            
        }
    }); 
}

function busqueda_por_usuario_fecha_proceso(){
  var usuario = $("#lista_usuarios").val();
  var fecha_inicio = $("#fecha_inicio").val();
  var tiempos_gestion = $("#tiempos_gestion").val();

  $.ajax({
        url: '../controladores/Log.php',
        data:
                {
                    tipo: 2,
                    busqueda:5,
                    usuario:usuario,
                    fecha_inicio:fecha_inicio,
                    tiempos_gestion:tiempos_gestion
                },
        type: 'post',
        success: function (data)
        {
                $("#tabla_resultado").html(data);
                $("#tabla_inicial").css("display","none");
            
        }
    }); 

}

function busqueda_por_usuario_proceso(){
  var usuario = $("#lista_usuarios").val();
  var tiempos_gestion = $("#tiempos_gestion").val();


  $.ajax({
        url: '../controladores/Log.php',
        data:
                {
                    tipo: 2,
                    busqueda:6,
                    usuario:usuario,
                    tiempos_gestion:tiempos_gestion
                },
        type: 'post',
        success: function (data)
        {
                $("#tabla_resultado").html(data);
                $("#tabla_inicial").css("display","none");
            
        }
    }); 
}


