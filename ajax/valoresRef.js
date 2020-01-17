function verValoresReferencia() {
    $("#lista_valor_referencia_cot_body").html("");

    var tabla = '<table id="lista_valor_referencia_cot" class="table table-bordered">' +
            '<thead>' +
            '<tr style="background-color: #214761;">' +
            '<th style="color:white">Codigo Examen</th>' +
            '<th style="color:white">Nombre Examen</th>' +
            '<th style="color:white">medida</th>' +
            '<th style="color:white">unidad</th>' +
            '<th style="color:white">valor_critico_inferior</th>' +
            '<th style="color:white">valor_critico_superior</th>' +
            '<th style="color:white">anormal_disminuido_minimo</th>' +
            '<th style="color:white">anormal_disminuido_maximo</th>' +
            '<th style="color:white">rango_normal_minimo</th>' +
            '<th style="color:white">rango_normal_maximo</th>' +
            '<th style="color:white">anormal_incrementado_minimo</th>' +
            '<th style="color:white">anormal_incrementado_maximo</th>' +
            '<th style="color:white">edad_minima</th>' +
            '<th style="color:white">edad_maxima</th>' +
            '<th style="color:white">sexo</th>' +
            '<th style="color:white">otros</th>' +
            '<th style="color:white">unidad_edad</th>' +
            '</tr>' +
            '</thead>' +
            '<tbody id="lista_valor_referencia_cot_body">' +
            '</tbody>' +
            '</table>';

    $("#tabla_valor_referencia").html(tabla);

    var data;
    
//    $.ajax({
//        type: "POST",
//        url: "../pddofo.php",
//        async: false,
//        dataType: 'json',
//        data:{
//            hola: 2,
//            example: 4
//        },
//        success: function (data, textStatus, jqXHR) {
//            
//        }
//    })
//    
    $.ajax({
        type: "POST",
        url: "../controladores/valoresRefController.php",
        async: false,
        dataType: 'json',
        data: {
            tipo: 1
        },
        success: function (retu) {
            $.each(retu, function (i, nValorRef) {


                var newRow = "<tr>";
                newRow += "<td>" + nValorRef.codigo + "</td>";
                newRow += "<td>" + nValorRef.nombre + "</td>";
                newRow += "<td>" + nValorRef.medida + "</td>";
                newRow += "<td>" + nValorRef.unidad + "</td>";
                newRow += "<td>" + nValorRef.valor_critico_inferior + "</td>";
                newRow += "<td>" + nValorRef.valor_critico_superior + "</td>";
                newRow += "<td>" + nValorRef.anormal_disminuido_minimo + "</td>";
                newRow += "<td>" + nValorRef.anormal_disminuido_maximo + "</td>";
                newRow += "<td>" + nValorRef.rango_normal_minimo + "</td>";
                newRow += "<td>" + nValorRef.rango_normal_maximo + "</td>";
                newRow += "<td>" + nValorRef.anormal_incrementado_minimo + "</td>";
                newRow += "<td>" + nValorRef.anormal_incrementado_maximo + "</td>";
                newRow += "<td>" + nValorRef.edad_minima + "</td>";
                newRow += "<td>" + nValorRef.edad_maxima + "</td>";
                newRow += "<td>" + nValorRef.sexo + "</td>";
                newRow += "<td>" + nValorRef.otros + "</td>";
                newRow += "<td>" + nValorRef.unidad_edad + "</td>";
                newRow += "</tr>";

                $(newRow).appendTo("#lista_valor_referencia_cot_body");
            });
        }
    });



    var tabla = $('#lista_valor_referencia_cot').DataTable({
        responsive: true
    });

}