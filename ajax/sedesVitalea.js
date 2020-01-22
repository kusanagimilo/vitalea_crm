function verSedesVitalea() {
    $("#listaDevaloresTablaSedes").html("");

    var tabla = '<table id="listaTablaSedes" class="table table-bordered">' +
            '<thead>' +
            '<tr style="background-color: #214761;">' +
            '<th style="color:white">Nombre Sede</th>' +
            '<th style="color:white">Ciudad</th>' +
            '<th style="color:white">Direccion</th>' +
            '<th style="color:white">Barrio</th>' +
            '<th style="color:white">Telefono</th>' +
            '</tr>' +
            '</thead>' +
            '<tbody id="listaDevaloresTablaSedes">' +
            '</tbody>' +
            '</table>';

    $("#tabla_listado_sedes").html(tabla);

    var data;
    
    $.ajax({
        type: "POST",
        url: "../controladores/sedesVitaleaController.php",
        async: false,
        dataType: 'json',
        data: {
            tipo: 1
        },
        success: function (retu) {
            $.each(retu, function (i, nValorRef) {


                var newRow = "<tr>";
                newRow += "<td>" + nValorRef.nombre_sede + "</td>";
                newRow += "<td>" + nValorRef.ciudad + "</td>";
                newRow += "<td>" + nValorRef.direccion + "</td>";
                newRow += "<td>" + nValorRef.barrio + "</td>";
                newRow += "<td>" + nValorRef.telefono + "</td>";    
                newRow += "</tr>";

                $(newRow).appendTo("#listaDevaloresTablaSedes");
            });
        }
    });



    var tabla = $('#listaTablaSedes').DataTable({
        responsive: true
    });

}

function ingresarSedesVitalea() {
    const botonEnvio = document.querySelector("#btnEnvioDatos");    
    botonEnvio.addEventListener("click", ()=>{
    nombre = $("#nombreInput").val();
    ciudad = $("#ciudadInput").val();
    direccion = $("#direccionInput").val();
    barrio = $("#barrioInput").val();
    telefono = $("#telefonoInput").val();
    let confirmacion = confirm("Por favor asegurese de que todos los campos estan correctamente diligenciados, si es asi oprima en Aceptar.")
    
    if (confirmacion) {
        $.ajax({
            type: "POST",
            url: "../controladores/sedesVitaleaController.php",
            async: false,
            dataType: 'json',
            data: {
                tipo: 2,
                nombre: nombre,
                ciudad: ciudad,
                direccion: direccion,
                barrio: barrio,
                telefono: telefono
            },
            success: function () {
            }
        });
                
        location.reload();
    }       
    })
}