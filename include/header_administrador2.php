<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>CRM - Call Center</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

  <meta http-equiv="Expires" content="0">
  <meta http-equiv="Last-Modified" content="0">
  <meta http-equiv="Cache-Control" content="no-cache, mustrevalidate">
  <meta http-equiv="Pragma" content="no-cache">
<link rel="icon" href="../../images/cions.png" type="image/png">
<!-- menu nuevo -->
<nav class="navbar navbar-default"  style=" background-color: #214761; ">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" style="background: transparent;">
        
         <img src="../../images/vitalea_logo3.png"  />
   
      </a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      
     
      <ul class="nav navbar-nav navbar-right" >
        
        <li class="dropdown" >
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" style="color:#00c292"><?php echo  $_SESSION['NOMBRE_USUARIO']; ?>  <span class="caret"></span></a>
          <ul class="dropdown-menu" style="background-color: #214761;">
            <?php if( $_SESSION['PERMISOS']== 1 || $_SESSION['PERMISOS']==2 || $_SESSION['PERMISOS']==6 ) {?>
            <li><a href="#" id="almuerzo" style="color:white; font-style: bold" ><img src="../../web/images/almuerzo_1.png" alt="Almuerzo" title="Almuerzo" /><button type="button" class="btn btn-default" id="almuerzo" style="background: transparent;border: none;color:#00c292">Almuerzo</button>
                     </a></li>
            <li><a href="#" id="break" style="color:white; font-style: bold"><img src="../../web/images/cafe.png" alt="Break" title="Break"/> <button type="button" class="btn btn-default" id="break" style="background: transparent;border: none;color:#00c292">Break</button></a></li>
            <li><a href="#" style="color:white; font-style: bold"><img src="../../web/images/usuarios_existentes.png" alt="Capacitacion" title="Capacitacion"/><button type="button" class="btn btn-default" id="capacitacion" style="background: transparent;border: none;color:#00c292"> Capacitacion</button></a></li>
            <li><a href="#" style="color:white; font-style: bold"><img src="../../web/images/finalizar_dos.png" alt="Calidad" title="Calidad"/><button type="button" class="btn btn-default" id="calidad" style="background: transparent;border: none;color:#00c292"> Calidad</button></a></li>
            <li><a href="#" style="color:white; font-style: bold"><img src="../../web/images/call_center.png" alt="Gestion OutBound" title="Gestion OutBound"/><button type="button" class="btn btn-default" id="outbound" style="background: transparent;border: none;color:#00c292"> Gestión OutBound</button></a></li>
            <li><a href="#" style="color:white; font-style: bold"><img src="../../web/images/presencial.png" alt="Gestion Administrativa" title="Gestion Administrativa"/><button type="button" class="btn btn-default" id="administrativa" style="background: transparent;border: none;color:#00c292"> Gestión Administrativa</button></a></li>
            <?php if ($_SESSION['PERMISOS']!=6) {
            ?>
            <li><a href="lectura_qr_dos.php" style="color:white; font-style: bold"><img src="../../web/images/codigo-qr.png" alt="Lectura Codigo QR" title="Lectura Codigo QR"/><button type="button" class="btn btn-default" style="background: transparent;border: none;color:#00c292">Lectura Codigo QR</button></a></li>
          <?php } }?>
          <li><a href="../../web/cerrar_sesion.php" style="color:white; font-style: bold"><img src="../../web/images/boton-de-encendido.png" alt="" alt="Cerrar sesion" title="Cerrar session"/><button type="button" class="btn btn-default"  style="background: transparent;border: none;color:#00c292"> Cerrar Sesión</button></a></li>
          </ul>
        </li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
<!-- fin menu nuevo -->



<input type="hidden" name="usuario_id" id="usuario_id" value="<?php echo $_SESSION['ID_USUARIO'] ?>">
<style type="text/css">
  
.dropdown-menu > li > a:hover, .dropdown-menu > li > a:focus {
    color: black;
    text-decoration: none;
    background-color: #ddd;
}
</style>
<script src="https://malsup.github.io/jquery.blockUI.js"></script>
<script type="text/javascript">
  $(document).ready(function ()
  {

    var tiempo = {
        hora_almuerzo: 0,
        minuto_almuerzo: 0,
        segundo_almuerzo: 0,
        hora_break: 0,
        minuto_break: 0,
        segundo_break: 0,
        hora_capacitacion: 0,
        minuto_capacitacion: 0,
        segundo_capacitacion: 0,
        hora_calidad: 0,
        minuto_calidad: 0,
        segundo_calidad: 0,
        hora_outbound: 0,
        minuto_outbound: 0,
        segundo_outbound: 0,
        hora_administrativa: 0,
        minuto_administrativa: 0,
        segundo_administrativa: 0,

    };

    var tiempo_corriendo_almuerzo = "";
    var tiempo_corriendo_break = "";
    var tiempo_corriendo_capacitacion = "";
    var tiempo_corriendo_calidad = "";
    var tiempo_corriendo_outbound = "";
    var tiempo_corriendo_administrativa = "";

  

 $("#almuerzo").click(function(){
    $.blockUI({ message: $('#myModalAlmuerzo') });
  });

 $("#break").click(function(){
    $.blockUI({ message: $('#myModalBreak') });
  });

 $("#capacitacion").click(function(){
    $.blockUI({ message: $('#myModalCapacitacion') });
  });

 $("#calidad").click(function(){
    $.blockUI({ message: $('#myModalCalidad') });
  });

 $("#outbound").click(function(){
    $.blockUI({ message: $('#myModalOutbound') });
  });

 $("#administrativa").click(function(){
    $.blockUI({ message: $('#myModalAdministrativa') });
  });

/* funciones almuerzo  */
    $("#btn_comenzar_almuerzo").click(function(){
    var d = new Date();
    var mes = "";
    var dia = "";
    var hora = "";
    var minuto = "";
    var segundo = "";


    if(d.getMonth()==0){
      mes = "01";
    }
    else if(d.getMonth()==1){
      mes = "02";
    }
    else if(d.getMonth()==2){
      mes = "03";
    }
    else if(d.getMonth()==3){
      mes = "04";
    }
    else if(d.getMonth()==4){
      mes = "05";
    }
    else if(d.getMonth()==5){
      mes = "06";
    }
    else if(d.getMonth()==6){
      mes = "07";
    }
    else if(d.getMonth()==7){
      mes = "08";
    }
    else if(d.getMonth()==8){
      mes = "09";
    }
    else if(d.getMonth()==9){
      mes = "10";
    }
    else if(d.getMonth()==10){
      mes = "11";
    }
    else if(d.getMonth()==11){
      mes = "12";
    }

    if(d.getDate() < 10){
      dia = "0"+d.getDate();
    }
    else{
      dia = d.getDate();
    }

    if(d.getHours() < 10){
      hora = "0"+d.getHours();
    }
    else{
      hora = d.getHours();
    }

    if(d.getMinutes() < 10){
      minuto = "0"+d.getMinutes();
    }
    else{
      minuto = d.getMinutes();
    }

    if(d.getSeconds() < 10){
      segundo = "0"+d.getSeconds();
    }
    else{
      segundo = d.getSeconds();
    }
      fecha_inicio_almuerzo =d.getFullYear()+'-'+mes+"-"+dia+" "+hora+":"+minuto+":"+segundo;
         tiempo_corriendo_almuerzo = setInterval(function(){
          
                // Segundos
                tiempo.segundo_almuerzo++;
                if(tiempo.segundo_almuerzo >= 60)
                {
                    tiempo.segundo_almuerzo = 0;
                    tiempo.minuto_almuerzo++;
                }      

                // Minutos
                if(tiempo.minuto_almuerzo >= 60)
                {
                    tiempo.minuto_almuerzo = 0;
                    tiempo.hora_almuerzo++;
                }

                $("#hour").text(tiempo.hora_almuerzo < 10 ? '0' + tiempo.hora_almuerzo : tiempo.hora_almuerzo);
                $("#minute").text(tiempo.minuto_almuerzo < 10 ? '0' + tiempo.minuto_almuerzo : tiempo.minuto_almuerzo);
                $("#second").text(tiempo.segundo_almuerzo < 10 ? '0' + tiempo.segundo_almuerzo : tiempo.segundo_almuerzo);
            }, 1000);

        $("#btn_comenzar_almuerzo").css("display","none");
        $("#btn_cerrar_almuerzo").css("display","none");
        $("#btn_detener_almuerzo").css("display","block");

        var usuario_id = $("#usuario_id").val();

        $.ajax({
            url: '../../controladores/Log.php',
            data:
                    {
                      tipo: 3,
                      fecha_inicio_almuerzo:fecha_inicio_almuerzo,
                      usuario_id:usuario_id,
                      proceso:2
                    },
            type: 'post',
            success: function (data)
            {

            }
        });
    });

    $("#btn_detener_almuerzo").click(function(){
        var d = new Date();
        var mes = "";
        var dia = "";
        var hora = "";
        var minuto = "";
        var segundo = "";


        if(d.getMonth()==0){
          mes = "01";
        }
        else if(d.getMonth()==1){
          mes = "02";
        }
        else if(d.getMonth()==2){
          mes = "03";
        }
        else if(d.getMonth()==3){
          mes = "04";
        }
        else if(d.getMonth()==4){
          mes = "05";
        }
        else if(d.getMonth()==5){
          mes = "06";
        }
        else if(d.getMonth()==6){
          mes = "07";
        }
        else if(d.getMonth()==7){
          mes = "08";
        }
        else if(d.getMonth()==8){
          mes = "09";
        }
        else if(d.getMonth()==9){
          mes = "10";
        }
        else if(d.getMonth()==10){
          mes = "11";
        }
        else if(d.getMonth()==11){
          mes = "12";
        }

        if(d.getDate() < 10){
          dia = "0"+d.getDate();
        }
        else{
          dia = d.getDate();
        }

        if(d.getHours() < 10){
          hora = "0"+d.getHours();
        }
        else{
          hora = d.getHours();
        }

        if(d.getMinutes() < 10){
          minuto = "0"+d.getMinutes();
        }
        else{
          minuto = d.getMinutes();
        }

        if(d.getSeconds() < 10){
          segundo = "0"+d.getSeconds();
        }
        else{
          segundo = d.getSeconds();
        }

        fecha_fin_almuerzo = d.getFullYear()+'-'+mes+"-"+dia+" "+hora+":"+minuto+":"+segundo;
        clearInterval(tiempo_corriendo_almuerzo);

        var usuario_id = $("#usuario_id").val();
      
        $.ajax({
            url: '../../controladores/Log.php',
            data:
                    {
                      tipo: 1,
                      fecha_inicio_almuerzo:fecha_inicio_almuerzo,
                      fecha_fin_almuerzo:fecha_fin_almuerzo,
                      usuario_id:usuario_id,
                      tiempo_corriendo:tiempo_corriendo_almuerzo,
                      proceso:2
                    },
            type: 'post',
            success: function (data)
            {

              tiempo_corriendo_almuerzo = "";
              $("#hour").text("00");
              $("#minute").text("00");
              $("#second").text("00");
              tiempo.hora_almuerzo =0;
              tiempo.minuto_almuerzo = 0;
              tiempo.segundo_almuerzo = 0;

              $("#btn_comenzar_almuerzo").css("display","block");
              $("#btn_cerrar_almuerzo").css("display","block");
              $("#btn_detener_almuerzo").css("display","none");
              alertify.success("Tiempo de almuerzo <b>Finalizado</b>");
               $('#myModalAlmuerzo').modal('hide');
                $.unblockUI();
            }
        });
    });

/* fin funciones almuerzo*/

/* funciones Break*/
 $("#btn_comenzar_break").click(function(){
    var d = new Date();
    var mes = "";
    var dia = "";
    var hora = "";
    var minuto = "";
    var segundo = "";


    if(d.getMonth()==0){
      mes = "01";
    }
    else if(d.getMonth()==1){
      mes = "02";
    }
    else if(d.getMonth()==2){
      mes = "03";
    }
    else if(d.getMonth()==3){
      mes = "04";
    }
    else if(d.getMonth()==4){
      mes = "05";
    }
    else if(d.getMonth()==5){
      mes = "06";
    }
    else if(d.getMonth()==6){
      mes = "07";
    }
    else if(d.getMonth()==7){
      mes = "08";
    }
    else if(d.getMonth()==8){
      mes = "09";
    }
    else if(d.getMonth()==9){
      mes = "10";
    }
    else if(d.getMonth()==10){
      mes = "11";
    }
    else if(d.getMonth()==11){
      mes = "12";
    }

    if(d.getDate() < 10){
      dia = "0"+d.getDate();
    }
    else{
      dia = d.getDate();
    }

    if(d.getHours() < 10){
      hora = "0"+d.getHours();
    }
    else{
      hora = d.getHours();
    }

    if(d.getMinutes() < 10){
      minuto = "0"+d.getMinutes();
    }
    else{
      minuto = d.getMinutes();
    }

    if(d.getSeconds() < 10){
      segundo = "0"+d.getSeconds();
    }
    else{
      segundo = d.getSeconds();
    }

      fecha_inicio_almuerzo =d.getFullYear()+'-'+mes+"-"+dia+" "+hora+":"+minuto+":"+segundo;
         tiempo_corriendo_break = setInterval(function(){
          
                // Segundos
                tiempo.segundo_break++;
                if(tiempo.segundo_break >= 60)
                {
                    tiempo.segundo_break = 0;
                    tiempo.minuto_break++;
                }      

                // Minutos
                if(tiempo.minuto_break >= 60)
                {
                    tiempo.minuto_break = 0;
                    tiempo.hora_break++;
                }

                $("#hour_break").text(tiempo.hora_break < 10 ? '0' + tiempo.hora_break : tiempo.hora_break);
                $("#minute_break").text(tiempo.minuto_break < 10 ? '0' + tiempo.minuto_break : tiempo.minuto_break);
                $("#second_break").text(tiempo.segundo_break < 10 ? '0' + tiempo.segundo_break : tiempo.segundo_break);
            }, 1000);

        $("#btn_comenzar_break").css("display","none");
        $("#btn_cerrar_break").css("display","none");
        $("#btn_detener_break").css("display","block");
    });

    $("#btn_detener_break").click(function(){
        var d = new Date();
        var mes = "";
        var dia = "";
        var hora = "";
        var minuto = "";
        var segundo = "";


        if(d.getMonth()==0){
          mes = "01";
        }
        else if(d.getMonth()==1){
          mes = "02";
        }
        else if(d.getMonth()==2){
          mes = "03";
        }
        else if(d.getMonth()==3){
          mes = "04";
        }
        else if(d.getMonth()==4){
          mes = "05";
        }
        else if(d.getMonth()==5){
          mes = "06";
        }
        else if(d.getMonth()==6){
          mes = "07";
        }
        else if(d.getMonth()==7){
          mes = "08";
        }
        else if(d.getMonth()==8){
          mes = "09";
        }
        else if(d.getMonth()==9){
          mes = "10";
        }
        else if(d.getMonth()==10){
          mes = "11";
        }
        else if(d.getMonth()==11){
          mes = "12";
        }

        if(d.getDate() < 10){
          dia = "0"+d.getDate();
        }
        else{
          dia = d.getDate();
        }

        if(d.getHours() < 10){
          hora = "0"+d.getHours();
        }
        else{
          hora = d.getHours();
        }

        if(d.getMinutes() < 10){
          minuto = "0"+d.getMinutes();
        }
        else{
          minuto = d.getMinutes();
        }

        if(d.getSeconds() < 10){
          segundo = "0"+d.getSeconds();
        }
        else{
          segundo = d.getSeconds();
        }

        fecha_fin_almuerzo = d.getFullYear()+'-'+mes+"-"+dia+" "+hora+":"+minuto+":"+segundo;
        clearInterval(tiempo_corriendo_break);

        var usuario_id = $("#usuario_id").val();
      
        $.ajax({
            url: '../../controladores/Log.php',
            data:
                    {
                      tipo: 1,
                      fecha_inicio_almuerzo:fecha_inicio_almuerzo,
                      fecha_fin_almuerzo:fecha_fin_almuerzo,
                      usuario_id:usuario_id,
                      tiempo_corriendo:tiempo_corriendo_break,
                      proceso: 3
                    },
            type: 'post',
            success: function (data)
            {

              tiempo_corriendo_break = "";
              $("#hour_break").text("00");
              $("#minute_break").text("00");
              $("#second_break").text("00");
              tiempo.hora_break =0;
              tiempo.minuto_break = 0;
              tiempo.segundo_break = 0;

              $("#btn_comenzar_break").css("display","block");
              $("#btn_cerrar_break").css("display","block");
              $("#btn_detener_break").css("display","none");
              alertify.success("Tiempo de Break <b> Finalizado</b>");
               $('#myModalBreak').modal('hide');
                $.unblockUI();
            }
        });
    });

/* fin funciones almuerzo*/

/* funciones capacitacion*/
$("#btn_comenzar_capacitacion").click(function(){
    var d = new Date();
    var mes = "";
    var dia = "";
    var hora = "";
    var minuto = "";
    var segundo = "";


    if(d.getMonth()==0){
      mes = "01";
    }
    else if(d.getMonth()==1){
      mes = "02";
    }
    else if(d.getMonth()==2){
      mes = "03";
    }
    else if(d.getMonth()==3){
      mes = "04";
    }
    else if(d.getMonth()==4){
      mes = "05";
    }
    else if(d.getMonth()==5){
      mes = "06";
    }
    else if(d.getMonth()==6){
      mes = "07";
    }
    else if(d.getMonth()==7){
      mes = "08";
    }
    else if(d.getMonth()==8){
      mes = "09";
    }
    else if(d.getMonth()==9){
      mes = "10";
    }
    else if(d.getMonth()==10){
      mes = "11";
    }
    else if(d.getMonth()==11){
      mes = "12";
    }

    if(d.getDate() < 10){
      dia = "0"+d.getDate();
    }
    else{
      dia = d.getDate();
    }

    if(d.getHours() < 10){
      hora = "0"+d.getHours();
    }
    else{
      hora = d.getHours();
    }

    if(d.getMinutes() < 10){
      minuto = "0"+d.getMinutes();
    }
    else{
      minuto = d.getMinutes();
    }

    if(d.getSeconds() < 10){
      segundo = "0"+d.getSeconds();
    }
    else{
      segundo = d.getSeconds();
    }

      fecha_inicio_almuerzo =d.getFullYear()+'-'+mes+"-"+dia+" "+hora+":"+minuto+":"+segundo;
         tiempo_corriendo_capacitacion = setInterval(function(){
          
                // Segundos
                tiempo.segundo_capacitacion++;
                if(tiempo.segundo_capacitacion >= 60)
                {
                    tiempo.segundo_capacitacion = 0;
                    tiempo.minuto_capacitacion++;
                }      

                // Minutos
                if(tiempo.minuto_capacitacion >= 60)
                {
                    tiempo.minuto_capacitacion = 0;
                    tiempo.hora_capacitacion++;
                }

                $("#hour_capacitacion").text(tiempo.hora_capacitacion < 10 ? '0' + tiempo.hora_capacitacion : tiempo.hora_capacitacion);
                $("#minute_capacitacion").text(tiempo.minuto_capacitacion < 10 ? '0' + tiempo.minuto_capacitacion : tiempo.minuto_capacitacion);
                $("#second_capacitacion").text(tiempo.segundo_capacitacion < 10 ? '0' + tiempo.segundo_capacitacion : tiempo.segundo_capacitacion);
            }, 1000);

        $("#btn_comenzar_capacitacion").css("display","none");
        $("#btn_cerrar_capacitacion").css("display","none");
        $("#btn_detener_capacitacion").css("display","block");
    });

    $("#btn_detener_capacitacion").click(function(){
        var d = new Date();
        var mes = "";
        var dia = "";
        var hora = "";
        var minuto = "";
        var segundo = "";


        if(d.getMonth()==0){
          mes = "01";
        }
        else if(d.getMonth()==1){
          mes = "02";
        }
        else if(d.getMonth()==2){
          mes = "03";
        }
        else if(d.getMonth()==3){
          mes = "04";
        }
        else if(d.getMonth()==4){
          mes = "05";
        }
        else if(d.getMonth()==5){
          mes = "06";
        }
        else if(d.getMonth()==6){
          mes = "07";
        }
        else if(d.getMonth()==7){
          mes = "08";
        }
        else if(d.getMonth()==8){
          mes = "09";
        }
        else if(d.getMonth()==9){
          mes = "10";
        }
        else if(d.getMonth()==10){
          mes = "11";
        }
        else if(d.getMonth()==11){
          mes = "12";
        }

        if(d.getDate() < 10){
          dia = "0"+d.getDate();
        }
        else{
          dia = d.getDate();
        }

        if(d.getHours() < 10){
          hora = "0"+d.getHours();
        }
        else{
          hora = d.getHours();
        }

        if(d.getMinutes() < 10){
          minuto = "0"+d.getMinutes();
        }
        else{
          minuto = d.getMinutes();
        }

        if(d.getSeconds() < 10){
          segundo = "0"+d.getSeconds();
        }
        else{
          segundo = d.getSeconds();
        }

        fecha_fin_almuerzo = d.getFullYear()+'-'+mes+"-"+dia+" "+hora+":"+minuto+":"+segundo;
        clearInterval(tiempo_corriendo_capacitacion);

        var usuario_id = $("#usuario_id").val();
      
        $.ajax({
            url: '../../controladores/Log.php',
            data:
                    {
                      tipo: 1,
                      fecha_inicio_almuerzo:fecha_inicio_almuerzo,
                      fecha_fin_almuerzo:fecha_fin_almuerzo,
                      usuario_id:usuario_id,
                      tiempo_corriendo:tiempo_corriendo_capacitacion,
                      proceso: 4
                    },
            type: 'post',
            success: function (data)
            {
               tiempo_corriendo_capacitacion = "";
              $("#hour_capacitacion").text("00");
              $("#minute_capacitacion").text("00");
              $("#second_capacitacion").text("00");
              tiempo.hora_capacitacion =0;
              tiempo.minuto_capacitacion = 0;
              tiempo.segundo_capacitacion = 0;

              $("#btn_comenzar_capacitacion").css("display","block");
              $("#btn_cerrar_capacitacion").css("display","block");
              $("#btn_detener_capacitacion").css("display","none");

              alertify.success("Tiempo de Capacitación <b> Finalizado</b>");
               $('#myModalCapacitacion').modal('hide');
                $.unblockUI();
            }
        });
    });

/* fin funciones capacitacion*/

/* funciones calidad*/
$("#btn_comenzar_calidad").click(function(){
    var d = new Date();
    var mes = "";
    var dia = "";
    var hora = "";
    var minuto = "";
    var segundo = "";


    if(d.getMonth()==0){
      mes = "01";
    }
    else if(d.getMonth()==1){
      mes = "02";
    }
    else if(d.getMonth()==2){
      mes = "03";
    }
    else if(d.getMonth()==3){
      mes = "04";
    }
    else if(d.getMonth()==4){
      mes = "05";
    }
    else if(d.getMonth()==5){
      mes = "06";
    }
    else if(d.getMonth()==6){
      mes = "07";
    }
    else if(d.getMonth()==7){
      mes = "08";
    }
    else if(d.getMonth()==8){
      mes = "09";
    }
    else if(d.getMonth()==9){
      mes = "10";
    }
    else if(d.getMonth()==10){
      mes = "11";
    }
    else if(d.getMonth()==11){
      mes = "12";
    }

    if(d.getDate() < 10){
      dia = "0"+d.getDate();
    }
    else{
      dia = d.getDate();
    }

    if(d.getHours() < 10){
      hora = "0"+d.getHours();
    }
    else{
      hora = d.getHours();
    }

    if(d.getMinutes() < 10){
      minuto = "0"+d.getMinutes();
    }
    else{
      minuto = d.getMinutes();
    }

    if(d.getSeconds() < 10){
      segundo = "0"+d.getSeconds();
    }
    else{
      segundo = d.getSeconds();
    }

      fecha_inicio_almuerzo =d.getFullYear()+'-'+mes+"-"+dia+" "+hora+":"+minuto+":"+segundo;
         tiempo_corriendo_calidad = setInterval(function(){
          
                // Segundos
                tiempo.segundo_calidad++;
                if(tiempo.segundo_calidad >= 60)
                {
                    tiempo.segundo_calidad = 0;
                    tiempo.minuto_calidad++;
                }      

                // Minutos
                if(tiempo.minuto_calidad >= 60)
                {
                    tiempo.minuto_calidad = 0;
                    tiempo.hora_calidad++;
                }

                $("#hour_calidad").text(tiempo.hora_calidad < 10 ? '0' + tiempo.hora_calidad : tiempo.hora_calidad);
                $("#minute_calidad").text(tiempo.minuto_calidad < 10 ? '0' + tiempo.minuto_calidad : tiempo.minuto_calidad);
                $("#second_calidad").text(tiempo.segundo_calidad < 10 ? '0' + tiempo.segundo_calidad : tiempo.segundo_calidad);
            }, 1000);

        $("#btn_comenzar_calidad").css("display","none");
        $("#btn_cerrar_calidad").css("display","none");
        $("#btn_detener_calidad").css("display","block");
    });

    $("#btn_detener_calidad").click(function(){
        var d = new Date();
        var mes = "";
        var dia = "";
        var hora = "";
        var minuto = "";
        var segundo = "";


        if(d.getMonth()==0){
          mes = "01";
        }
        else if(d.getMonth()==1){
          mes = "02";
        }
        else if(d.getMonth()==2){
          mes = "03";
        }
        else if(d.getMonth()==3){
          mes = "04";
        }
        else if(d.getMonth()==4){
          mes = "05";
        }
        else if(d.getMonth()==5){
          mes = "06";
        }
        else if(d.getMonth()==6){
          mes = "07";
        }
        else if(d.getMonth()==7){
          mes = "08";
        }
        else if(d.getMonth()==8){
          mes = "09";
        }
        else if(d.getMonth()==9){
          mes = "10";
        }
        else if(d.getMonth()==10){
          mes = "11";
        }
        else if(d.getMonth()==11){
          mes = "12";
        }

        if(d.getDate() < 10){
          dia = "0"+d.getDate();
        }
        else{
          dia = d.getDate();
        }

        if(d.getHours() < 10){
          hora = "0"+d.getHours();
        }
        else{
          hora = d.getHours();
        }

        if(d.getMinutes() < 10){
          minuto = "0"+d.getMinutes();
        }
        else{
          minuto = d.getMinutes();
        }

        if(d.getSeconds() < 10){
          segundo = "0"+d.getSeconds();
        }
        else{
          segundo = d.getSeconds();
        }

        fecha_fin_almuerzo = d.getFullYear()+'-'+mes+"-"+dia+" "+hora+":"+minuto+":"+segundo;
        clearInterval(tiempo_corriendo_calidad);

        var usuario_id = $("#usuario_id").val();
      
        $.ajax({
            url: '../../controladores/Log.php',
            data:
                    {
                      tipo: 1,
                      fecha_inicio_almuerzo:fecha_inicio_almuerzo,
                      fecha_fin_almuerzo:fecha_fin_almuerzo,
                      usuario_id:usuario_id,
                      tiempo_corriendo:tiempo_corriendo_calidad,
                      proceso: 5
                    },
            type: 'post',
            success: function (data)
            {
              tiempo_corriendo_calidad = "";
              $("#hour_calidad").text("00");
              $("#minute_calidad").text("00");
              $("#second_calidad").text("00");
              tiempo.hora_calidad =0;
              tiempo.minuto_calidad = 0;
              tiempo.segundo_calidad = 0;

              $("#btn_comenzar_calidad").css("display","block");
              $("#btn_cerrar_calidad").css("display","block");
              $("#btn_detener_calidad").css("display","none");

              alertify.success("Tiempo de Calidad <b> Finalizado</b>");
               $('#myModalCalidad').modal('hide');
                $.unblockUI();
            }
        });
    });

/*fin funciones calidad*/

/* funcion gestion outbound*/
$("#btn_comenzar_outbound").click(function(){
    var d = new Date();
    var mes = "";
    var dia = "";
    var hora = "";
    var minuto = "";
    var segundo = "";


    if(d.getMonth()==0){
      mes = "01";
    }
    else if(d.getMonth()==1){
      mes = "02";
    }
    else if(d.getMonth()==2){
      mes = "03";
    }
    else if(d.getMonth()==3){
      mes = "04";
    }
    else if(d.getMonth()==4){
      mes = "05";
    }
    else if(d.getMonth()==5){
      mes = "06";
    }
    else if(d.getMonth()==6){
      mes = "07";
    }
    else if(d.getMonth()==7){
      mes = "08";
    }
    else if(d.getMonth()==8){
      mes = "09";
    }
    else if(d.getMonth()==9){
      mes = "10";
    }
    else if(d.getMonth()==10){
      mes = "11";
    }
    else if(d.getMonth()==11){
      mes = "12";
    }

    if(d.getDate() < 10){
      dia = "0"+d.getDate();
    }
    else{
      dia = d.getDate();
    }

    if(d.getHours() < 10){
      hora = "0"+d.getHours();
    }
    else{
      hora = d.getHours();
    }

    if(d.getMinutes() < 10){
      minuto = "0"+d.getMinutes();
    }
    else{
      minuto = d.getMinutes();
    }

    if(d.getSeconds() < 10){
      segundo = "0"+d.getSeconds();
    }
    else{
      segundo = d.getSeconds();
    }

      fecha_inicio_almuerzo =d.getFullYear()+'-'+mes+"-"+dia+" "+hora+":"+minuto+":"+segundo;
         tiempo_corriendo_outbound= setInterval(function(){
          
                // Segundos
                tiempo.segundo_outbound++;
                if(tiempo.segundo_outbound >= 60)
                {
                    tiempo.segundo_outbound = 0;
                    tiempo.minuto_outbound++;
                }      

                // Minutos
                if(tiempo.minuto_outbound >= 60)
                {
                    tiempo.minuto_outbound = 0;
                    tiempo.hora_outbound++;
                }

                $("#hour_outbound").text(tiempo.hora_outbound < 10 ? '0' + tiempo.hora_outbound : tiempo.hora_outbound);
                $("#minute_outbound").text(tiempo.minuto_outbound < 10 ? '0' + tiempo.minuto_outbound : tiempo.minuto_outbound);
                $("#second_outbound").text(tiempo.segundo_outbound < 10 ? '0' + tiempo.segundo_outbound : tiempo.segundo_outbound);
            }, 1000);

        $("#btn_comenzar_outbound").css("display","none");
        $("#btn_cerrar_outbound").css("display","none");
        $("#btn_detener_outbound").css("display","block");
    });

    $("#btn_detener_outbound").click(function(){
        var d = new Date();
        var mes = "";
        var dia = "";
        var hora = "";
        var minuto = "";
        var segundo = "";


        if(d.getMonth()==0){
          mes = "01";
        }
        else if(d.getMonth()==1){
          mes = "02";
        }
        else if(d.getMonth()==2){
          mes = "03";
        }
        else if(d.getMonth()==3){
          mes = "04";
        }
        else if(d.getMonth()==4){
          mes = "05";
        }
        else if(d.getMonth()==5){
          mes = "06";
        }
        else if(d.getMonth()==6){
          mes = "07";
        }
        else if(d.getMonth()==7){
          mes = "08";
        }
        else if(d.getMonth()==8){
          mes = "09";
        }
        else if(d.getMonth()==9){
          mes = "10";
        }
        else if(d.getMonth()==10){
          mes = "11";
        }
        else if(d.getMonth()==11){
          mes = "12";
        }

        if(d.getDate() < 10){
          dia = "0"+d.getDate();
        }
        else{
          dia = d.getDate();
        }

        if(d.getHours() < 10){
          hora = "0"+d.getHours();
        }
        else{
          hora = d.getHours();
        }

        if(d.getMinutes() < 10){
          minuto = "0"+d.getMinutes();
        }
        else{
          minuto = d.getMinutes();
        }

        if(d.getSeconds() < 10){
          segundo = "0"+d.getSeconds();
        }
        else{
          segundo = d.getSeconds();
        }

        fecha_fin_almuerzo = d.getFullYear()+'-'+mes+"-"+dia+" "+hora+":"+minuto+":"+segundo;
        clearInterval(tiempo_corriendo_outbound);

        var usuario_id = $("#usuario_id").val();
      
        $.ajax({
            url: '../../controladores/Log.php',
            data:
                    {
                      tipo: 1,
                      fecha_inicio_almuerzo:fecha_inicio_almuerzo,
                      fecha_fin_almuerzo:fecha_fin_almuerzo,
                      usuario_id:usuario_id,
                      tiempo_corriendo:tiempo_corriendo_outbound,
                      proceso: 6
                    },
            type: 'post',
            success: function (data)
            {
              tiempo_corriendo_outbound = "";
              $("#hour_outbound").text("00");
              $("#minute_outbound").text("00");
              $("#second_outbound").text("00");
              tiempo.hora_outbound =0;
              tiempo.minuto_outbound = 0;
              tiempo.segundo_outbound = 0;

              $("#btn_comenzar_outbound").css("display","block");
              $("#btn_cerrar_outbound").css("display","block");
              $("#btn_detener_outbound").css("display","none");

              alertify.success("Tiempo de Gestion Outbound <b> Finalizado</b>");
               $('#myModalOutbound').modal('hide');
                $.unblockUI();
            }
        });
    });

/*fin funcion gestion outbound*/

/* funcion gestion Administrativa*/
$("#btn_comenzar_administrativa").click(function(){
    var d = new Date();
    var mes = "";
    var dia = "";
    var hora = "";
    var minuto = "";
    var segundo = "";


    if(d.getMonth()==0){
      mes = "01";
    }
    else if(d.getMonth()==1){
      mes = "02";
    }
    else if(d.getMonth()==2){
      mes = "03";
    }
    else if(d.getMonth()==3){
      mes = "04";
    }
    else if(d.getMonth()==4){
      mes = "05";
    }
    else if(d.getMonth()==5){
      mes = "06";
    }
    else if(d.getMonth()==6){
      mes = "07";
    }
    else if(d.getMonth()==7){
      mes = "08";
    }
    else if(d.getMonth()==8){
      mes = "09";
    }
    else if(d.getMonth()==9){
      mes = "10";
    }
    else if(d.getMonth()==10){
      mes = "11";
    }
    else if(d.getMonth()==11){
      mes = "12";
    }

    if(d.getDate() < 10){
      dia = "0"+d.getDate();
    }
    else{
      dia = d.getDate();
    }

    if(d.getHours() < 10){
      hora = "0"+d.getHours();
    }
    else{
      hora = d.getHours();
    }

    if(d.getMinutes() < 10){
      minuto = "0"+d.getMinutes();
    }
    else{
      minuto = d.getMinutes();
    }

    if(d.getSeconds() < 10){
      segundo = "0"+d.getSeconds();
    }
    else{
      segundo = d.getSeconds();
    }

      fecha_inicio_almuerzo =d.getFullYear()+'-'+mes+"-"+dia+" "+hora+":"+minuto+":"+segundo;
         tiempo_corriendo_administrativa= setInterval(function(){
          
                // Segundos
                tiempo.segundo_administrativa++;
                if(tiempo.segundo_administrativa >= 60)
                {
                    tiempo.segundo_administrativa = 0;
                    tiempo.minuto_administrativa++;
                }      

                // Minutos
                if(tiempo.minuto_administrativa >= 60)
                {
                    tiempo.minuto_administrativa = 0;
                    tiempo.hora_administrativa++;
                }

                $("#hour_administrativa").text(tiempo.hora_administrativa< 10 ? '0' + tiempo.hora_administrativa : tiempo.hora_administrativa);
                $("#minute_administrativa").text(tiempo.minuto_administrativa < 10 ? '0' + tiempo.minuto_administrativa : tiempo.minuto_administrativa);
                $("#second_administrativa").text(tiempo.segundo_administrativa < 10 ? '0' + tiempo.segundo_administrativa : tiempo.segundo_administrativa);
            }, 1000);

        $("#btn_comenzar_administrativa").css("display","none");
        $("#btn_cerrar_administrativa").css("display","none");
        $("#btn_detener_administrativa").css("display","block");
    });

    $("#btn_detener_administrativa").click(function(){
        var d = new Date();
        var mes = "";
        var dia = "";
        var hora = "";
        var minuto = "";
        var segundo = "";


        if(d.getMonth()==0){
          mes = "01";
        }
        else if(d.getMonth()==1){
          mes = "02";
        }
        else if(d.getMonth()==2){
          mes = "03";
        }
        else if(d.getMonth()==3){
          mes = "04";
        }
        else if(d.getMonth()==4){
          mes = "05";
        }
        else if(d.getMonth()==5){
          mes = "06";
        }
        else if(d.getMonth()==6){
          mes = "07";
        }
        else if(d.getMonth()==7){
          mes = "08";
        }
        else if(d.getMonth()==8){
          mes = "09";
        }
        else if(d.getMonth()==9){
          mes = "10";
        }
        else if(d.getMonth()==10){
          mes = "11";
        }
        else if(d.getMonth()==11){
          mes = "12";
        }

        if(d.getDate() < 10){
          dia = "0"+d.getDate();
        }
        else{
          dia = d.getDate();
        }

        if(d.getHours() < 10){
          hora = "0"+d.getHours();
        }
        else{
          hora = d.getHours();
        }

        if(d.getMinutes() < 10){
          minuto = "0"+d.getMinutes();
        }
        else{
          minuto = d.getMinutes();
        }

        if(d.getSeconds() < 10){
          segundo = "0"+d.getSeconds();
        }
        else{
          segundo = d.getSeconds();
        }

        fecha_fin_almuerzo = d.getFullYear()+'-'+mes+"-"+dia+" "+hora+":"+minuto+":"+segundo;
        clearInterval(tiempo_corriendo_administrativa);

        var usuario_id = $("#usuario_id").val();
      
        $.ajax({
            url: '../../controladores/Log.php',
            data:
                    {
                      tipo: 1,
                      fecha_inicio_almuerzo:fecha_inicio_almuerzo,
                      fecha_fin_almuerzo:fecha_fin_almuerzo,
                      usuario_id:usuario_id,
                      tiempo_corriendo:tiempo_corriendo_administrativa,
                      proceso: 7
                    },
            type: 'post',
            success: function (data)
            {
              tiempo_corriendo_administrativa= "";
              $("#hour_administrativa").text("00");
              $("#minute_administrativa").text("00");
              $("#second_administrativa").text("00");
              tiempo.hora_administrativa =0;
              tiempo.minuto_administrativa = 0;
              tiempo.segundo_administrativa = 0;

              $("#btn_comenzar_administrativa").css("display","block");
              $("#btn_cerrar_administrativa").css("display","block");
              $("#btn_detener_administrativa").css("display","none");

              alertify.success("Tiempo de Gestion Administrativa <b> Finalizado</b>");
               $('#myModalAdministrativa').modal('hide');
                $.unblockUI();
            }
        });
    });

/*fin funcion gestion outbound*/

/*funcion cerrar*/

  $("#btn_cerrar_almuerzo").click(function(){
      $('#myModalAlmuerzo').modal('hide');
      $.unblockUI();
  });

  $("#btn_cerrar_break").click(function(){
      $('#myModalBreak').modal('hide');
      $.unblockUI();
  });

  $("#btn_cerrar_capacitacion").click(function(){
        $('#myModalCapacitacion').modal('hide');
      $.unblockUI();
  });

  $("#btn_cerrar_calidad").click(function(){
      $('#myModalCalidad').modal('hide');
      $.unblockUI();
  });

  $("#btn_cerrar_outbound").click(function(){
      $('#myModalOutbound').modal('hide');
      $.unblockUI();
  });

  $("#btn_cerrar_administrativa").click(function(){
      $('#myModalAdministrativa').modal('hide');
      $.unblockUI();
  });


 });


</script>

<!-- Modal Almuerzo-->

<div class="modal" id="myModalAlmuerzo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" >
    <div class="modal-dialog" style="width: 30%;">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #214761; color: white" >
                   
                    <h4 class="modal-title">
                        <img src="images/examen_venta.png" alt=""/>
                      Almuerzo</h4>
            </div>
            <div class="modal-body col-md-12" style="height: auto">
                 <p style="font-size: 12pt;color:#00c292"> 
                  <img src="images/info.png" alt=""/>
              ¿Desea iniciar el tiempo de Almuerzo?</p>
                <div id="timer" style="text-align: center; ">
                      <center> 
                    <div class="container"  style="width: 40%">
                     <div id="hour" style="float: left;border:1px solid #BECEDD;padding:3px;font-weight: bold;">00</div>
                        <div class="divider" style="float: left;padding:2px;">:</div>
                        <div id="minute" style="float: left;border:1px solid #BECEDD;padding:3px;font-weight: bold;">00</div>
                        <div class="divider" style="float: left;padding:2px;">:</div>
                        <div id="second" style="float: left;border:1px solid #BECEDD;padding:3px; font-weight: bold;">00</div>
                    </div>
                    </center>
                
                </div>
            </div>          
            <div class="modal-footer">
              <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4"> 
                <button type="button" id="btn_comenzar_almuerzo" class="btn btn-primary btn-comenzar" style="font-size: 11pt;">  <img src="images/anadir_dos.png">Iniciar</button>
              </div>
              <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                <button type="button" id="btn_detener_almuerzo" class="btn btn-primary btn-detener" style="font-size: 11pt; display: none">  <img src="images/anadir_dos.png">Detener</button>

                <button type="button" id="btn_cerrar_almuerzo" class="btn btn-default" data-dismiss="modal" style="font-size: 11pt;"><img src="images/cerrar_dos.png"> Cerrar</button>
              </div>  
            </div>
        </div>                            
    </div>
</div>

<!-- Fin Modal Almuerzo-->

<!--Modal Break-->
<div class="modal" id="myModalBreak" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" >
    <div class="modal-dialog" style="width: 30%;">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #214761; color: white" >
                    
                    <h4 class="modal-title">
                        <img src="images/examen_venta.png" alt=""/>
                      Break</h4>
            </div>
           <div class="modal-body col-md-12" style="height: auto">
                 <p style="font-size: 12pt;color:#00c292"> 
                  <img src="images/info.png" alt=""/>
              ¿Desea iniciar el tiempo?</p>
                <div id="timer" style="text-align: center; ">
                      <center> 
                    <div class="container"  style="width: 40%">
                     <div id="hour_break" style="float: left;border:1px solid #BECEDD;padding:3px;font-weight: bold;">00</div>
                        <div class="divider" style="float: left;padding:2px;">:</div>
                        <div id="minute_break" style="float: left;border:1px solid #BECEDD;padding:3px;font-weight: bold;">00</div>
                        <div class="divider" style="float: left;padding:2px;">:</div>
                        <div id="second_break" style="float: left;border:1px solid #BECEDD;padding:3px; font-weight: bold;">00</div>
                    </div>
                    </center>
                
                </div>
            </div>          
            <div class="modal-footer">
              <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4"> 
                <button type="button" id="btn_comenzar_break" class="btn btn-primary btn-comenzar" style="font-size: 11pt;">  <img src="images/anadir_dos.png">Iniciar</button>
              </div>
              <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                <button type="button" id="btn_detener_break" class="btn btn-primary btn-detener" style="font-size: 11pt; display: none">  <img src="images/anadir_dos.png">Detener</button>

                <button type="button" id="btn_cerrar_break" class="btn btn-default" data-dismiss="modal" style="font-size: 11pt;"><img src="images/cerrar_dos.png"> Cerrar</button>
              </div>  
            </div>
        </div>                            
    </div>
</div>

<!-- Modal Break --->

<!-- Modal Capacitacion -->
<div class="modal" id="myModalCapacitacion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" >
    <div class="modal-dialog" style="width: 30%;">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #214761; color: white" >
                    
                    <h4 class="modal-title">
                        <img src="images/usuarios_existentes.png" alt=""/>
                      Capacitacion</h4>
            </div>
            <div class="modal-body col-md-12" style="height: auto">
                 <p style="font-size: 12pt;color:#00c292"> 
                  <img src="images/info.png" alt=""/>
              ¿Desea iniciar el tiempo de Capacitación?</p>
                <div id="timer" style="text-align: center; ">
                      <center> 
                    <div class="container"  style="width: 40%">
                     <div id="hour_capacitacion" style="float: left;border:1px solid #BECEDD;padding:3px;font-weight: bold;">00</div>
                        <div class="divider" style="float: left;padding:2px;">:</div>
                        <div id="minute_capacitacion" style="float: left;border:1px solid #BECEDD;padding:3px;font-weight: bold;">00</div>
                        <div class="divider" style="float: left;padding:2px;">:</div>
                        <div id="second_capacitacion" style="float: left;border:1px solid #BECEDD;padding:3px; font-weight: bold;">00</div>
                    </div>
                    </center>
                
                </div>
            </div>          
            <div class="modal-footer">
              <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4"> 
                <button type="button" id="btn_comenzar_capacitacion" class="btn btn-primary btn-comenzar" style="font-size: 11pt;">  <img src="images/anadir_dos.png">Iniciar</button>
              </div>
              <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                <button type="button" id="btn_detener_capacitacion" class="btn btn-primary btn-detener" style="font-size: 11pt; display: none">  <img src="images/anadir_dos.png">Detener</button>

                <button type="button" id="btn_cerrar_capacitacion" class="btn btn-default" data-dismiss="modal" style="font-size: 11pt;"><img src="images/cerrar_dos.png"> Cerrar</button>
              </div>  
            </div>
        </div>                            
    </div>
</div>
<!-- fin Modal capacitacion -->


<!-- Modal Calidad -->
<div class="modal" id="myModalCalidad" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" >
    <div class="modal-dialog" style="width: 30%;">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #214761; color: white" >
                    
                    <h4 class="modal-title">
                        <img src="images/finalizar_dos.png" alt=""/>
                      Calidad</h4>
            </div>
            <div class="modal-body col-md-12" style="height: auto">
                 <p style="font-size: 12pt;color:#00c292"> 
                  <img src="images/info.png" alt=""/>
              ¿Desea iniciar el tiempo de Calidad?</p>
                <div id="timer" style="text-align: center; ">
                      <center> 
                    <div class="container"  style="width: 40%">
                     <div id="hour_calidad" style="float: left;border:1px solid #BECEDD;padding:3px;font-weight: bold;">00</div>
                        <div class="divider" style="float: left;padding:2px;">:</div>
                        <div id="minute_calidad" style="float: left;border:1px solid #BECEDD;padding:3px;font-weight: bold;">00</div>
                        <div class="divider" style="float: left;padding:2px;">:</div>
                        <div id="second_calidad" style="float: left;border:1px solid #BECEDD;padding:3px; font-weight: bold;">00</div>
                    </div>
                    </center>
                
                </div>
            </div>          
            <div class="modal-footer">
              <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4"> 
                <button type="button" id="btn_comenzar_calidad" class="btn btn-primary btn-comenzar" style="font-size: 11pt;">  <img src="images/anadir_dos.png">Iniciar</button>
              </div>
              <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                <button type="button" id="btn_detener_calidad" class="btn btn-primary btn-detener" style="font-size: 11pt; display: none">  <img src="images/anadir_dos.png">Detener</button>

                <button type="button" id="btn_cerrar_calidad" class="btn btn-default" data-dismiss="modal" style="font-size: 11pt;"><img src="images/cerrar_dos.png"> Cerrar</button>
              </div>  
            </div>
        </div>                            
    </div>
</div>
<!-- fin Modal calidada -->

<!-- Modal Outbound -->
<div class="modal" id="myModalOutbound" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" >
    <div class="modal-dialog" style="width: 30%;">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #214761; color: white" >
                    
                    <h4 class="modal-title">
                        <img src="images/call_center.png" alt=""/>
                      Gestion Outbound</h4>
            </div>
            <div class="modal-body col-md-12" style="height: auto">
                 <p style="font-size: 12pt;color:#00c292"> 
                  <img src="images/info.png" alt=""/>
              ¿Desea iniciar el tiempo de Gestion Outbound?</p>
                <div id="timer" style="text-align: center; ">
                      <center> 
                    <div class="container"  style="width: 40%">
                     <div id="hour_outbound" style="float: left;border:1px solid #BECEDD;padding:3px;font-weight: bold;">00</div>
                        <div class="divider" style="float: left;padding:2px;">:</div>
                        <div id="minute_outbound" style="float: left;border:1px solid #BECEDD;padding:3px;font-weight: bold;">00</div>
                        <div class="divider" style="float: left;padding:2px;">:</div>
                        <div id="second_outbound" style="float: left;border:1px solid #BECEDD;padding:3px; font-weight: bold;">00</div>
                    </div>
                    </center>
                
                </div>
            </div>          
            <div class="modal-footer">
              <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4"> 
                <button type="button" id="btn_comenzar_outbound" class="btn btn-primary btn-comenzar" style="font-size: 11pt;">  <img src="images/anadir_dos.png">Iniciar</button>
              </div>
              <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                <button type="button" id="btn_detener_outbound" class="btn btn-primary btn-detener" style="font-size: 11pt; display: none">  <img src="images/anadir_dos.png">Detener</button>

                <button type="button" id="btn_cerrar_outbound" class="btn btn-default" data-dismiss="modal" style="font-size: 11pt;"><img src="images/cerrar_dos.png"> Cerrar</button>
              </div>  
            </div>
        </div>                            
    </div>
</div>
<!-- fin Modal outbound -->
<!-- Modal administrativa -->
<div class="modal" id="myModalAdministrativa" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" >
    <div class="modal-dialog" style="width: 30%;">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #214761; color: white" >
                    
                    <h4 class="modal-title">
                        <img src="images/presencial.png" alt=""/>
                      Gestion Administrativa</h4>
            </div>
            <div class="modal-body col-md-12" style="height: auto">
                 <p style="font-size: 12pt;color:#00c292"> 
                  <img src="images/info.png" alt=""/>
              ¿Desea iniciar el tiempo de Gestion Administrativa?</p>
                <div id="timer" style="text-align: center; ">
                      <center> 
                    <div class="container"  style="width: 40%">
                     <div id="hour_administrativa" style="float: left;border:1px solid #BECEDD;padding:3px;font-weight: bold;">00</div>
                        <div class="divider" style="float: left;padding:2px;">:</div>
                        <div id="minute_administrativa" style="float: left;border:1px solid #BECEDD;padding:3px;font-weight: bold;">00</div>
                        <div class="divider" style="float: left;padding:2px;">:</div>
                        <div id="second_administrativa" style="float: left;border:1px solid #BECEDD;padding:3px; font-weight: bold;">00</div>
                    </div>
                    </center>
                
                </div>
            </div>          
            <div class="modal-footer">
              <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4"> 
                <button type="button" id="btn_comenzar_administrativa" class="btn btn-primary btn-comenzar" style="font-size: 11pt;">  <img src="images/anadir_dos.png">Iniciar</button>
              </div>
              <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                <button type="button" id="btn_detener_administrativa" class="btn btn-primary btn-detener" style="font-size: 11pt; display: none">  <img src="images/anadir_dos.png">Detener</button>

                <button type="button" id="btn_cerrar_administrativa" class="btn btn-default" data-dismiss="modal" style="font-size: 11pt;"><img src="images/cerrar_dos.png"> Cerrar</button>
              </div>  
            </div>
        </div>                            
    </div>
</div>
<!-- fin Modal administrativa -->



