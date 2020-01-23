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
            '<th style="color:white">Acciones</th>' +
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
                newRow += "<td>" + '<button class="btn btn-danger" name="btnEliminacionDatos" style="width: 100%">Eliminar Registro</button>' + "</td>";    
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
    

    if (nombre == "" || ciudad == "" || direccion == "" || barrio == "") {
        alert("Uno o varios campos no estan correctamente diligenciados, verifique por favor.")
    } else if (true) {
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

function eliminarSedesVitalea() {
    const lecturaValorABorrar = document.getElementsByName("btnEliminacionDatos");

    let eliminarRegistro = (e)=>{
        let contenedorPadre = e.target.parentNode.parentNode.firstChild.textContent;
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
    }
    for (let i = 0; i < lecturaValorABorrar.length; i++) {
        lecturaValorABorrar[i].addEventListener("click", eliminarRegistro);        
    }    
};

