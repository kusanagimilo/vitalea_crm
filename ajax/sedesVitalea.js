function verSedesVitalea() {
     /*En la siguiente funcion generamos la funcionalidad de visualizacion de sedes realizando, la lectura desde el metodo ajax
     con la cual se hacer el 'inner' de la cabecera de la tabla y porteriormente el 'inner' de los datos obtenidos del objeto
     JSON del Ajax, en la ultima parte de nuestra funcion se llama el metodo 'Datatable', correspondiente a la libreria para creacion 
     automatica de tablas*/
    $("#listaDevaloresTablaSedes").html("");

    var tabla = '<table id="listaTablaSedes" class="table table-bordered">' +
            '<thead>' +
            '<tr style="background-color: #214761;">' +
            '<th style="color:white">Nombre Sede</th>' +
            '<th style="color:white">Ciudad</th>' +
            '<th style="color:white">Dirección</th>' +
            '<th style="color:white">Barrio</th>' +
            '<th style="color:white">Telefono</th>' +
            '<th style="color:white; text-align: center;">Acciones</th>' +
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
    /*En la siguiente funcion generamos la funcionalidad de ingreso de nuevas sedes realizando la identificacion de cada uno de los 
    inputs en la vista, generando un ajax con el dato eliminar y por ultimo generando un intervalo para recarga de la Url que se 
    realiza de inmediato con el evento click del boton*/
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
    /*En la siguiente funcion generamos la funcionalidad de eliminacion de sedes leyendo el identificador del boton ubicado en la vista
    generando un ajax con el dato eliminar y por ultimo generando un intervalo para recarga de la Url*/
    const lecturaValorABorrar = document.getElementsByName("btnEliminacionDatos");

    let eliminarRegistro = (e)=>{
        let eliminarR = e.target.parentNode.parentNode.firstChild.textContent;
        $.ajax({
            type: "POST",
            url: "../controladores/sedesVitaleaController.php",
            async: false,
            dataType: 'json',
            data: {
                tipo: 3,
                eliminar: eliminarR,
            },
            success: function () {                
            }
        });
        setTimeout(() => {
            location.reload();
        }, 150);
    }
    for (let i = 0; i < lecturaValorABorrar.length; i++) {
        lecturaValorABorrar[i].addEventListener("click", eliminarRegistro);        
    }    
};

