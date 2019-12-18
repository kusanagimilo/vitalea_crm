function lista_tiempo_real_gestion(){
    
    $.ajax({
            url: '../controladores/Log.php',
            data:
                    {
                        tipo: 4
                    },
            type: 'post',
            dataType: 'json',
            success: function (data)
            {
            
                $.each(data, function(i,tiempos){

                    var f=new Date();
                    t1 = new Date(),
                    t2 = new Date();

                    t2.setHours(tiempos.hora, tiempos.minuto, tiempos.segundo);
                    t1.setHours(f.getHours(), f.getMinutes(),f.getSeconds());

                    t1.setHours(t1.getHours() - t2.getHours(), t1.getMinutes() - t2.getMinutes(), t1.getSeconds() - t2.getSeconds());
                
                setInterval( function(){
                    var f=new Date();
                    t1 = new Date(),
                    t2 = new Date();

                    t2.setHours(tiempos.hora, tiempos.minuto, tiempos.segundo);
                    t1.setHours(f.getHours(), f.getMinutes(),f.getSeconds());
                    t1.setHours(t1.getHours() - t2.getHours(), t1.getMinutes() - t2.getMinutes(), t1.getSeconds() - t2.getSeconds());
                 $(".fecha_transcurrida").html(((t1.getHours() ? t1.getHours() + (t1.getHours() > 1 ? " <b>horas</b>" : "<b>hora</b>") : "") + (t1.getMinutes() ? " - " + t1.getMinutes() + (t1.getMinutes() > 1 ? "<b>minutos</b>" : "<b>minuto</b>") : "") + (t1.getSeconds() ? (t1.getHours() || t1.getMinutes() ? " - " : "") + t1.getSeconds() + (t1.getSeconds() > 1 ? " <b>segundos</b>" : "<b>segundo</b>") : "")));
                }, 1000);

                    var newRow ="<tr><td>"+tiempos.perfil+"</td>";
                        newRow +="<td>"+tiempos.usuario_id+"</td>";
                        newRow +="<td>"+tiempos.nombre+"</td>";
                        newRow +="<td>"+tiempos.proceso+"</td>";
                        newRow +="<td>"+tiempos.fecha_inicial+"</td>";
                        newRow +="<td><span class='fecha_transcurrida'></span></td></tr>";
                       
                    $(newRow).appendTo("#tabla_resultado");
                });
            
            }
        });
}

function fecha(hora_actual,hora_inicio){

}
