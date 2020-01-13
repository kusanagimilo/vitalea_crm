/*Todo el codigo quedara en una funcion autoinvocada de tipo flecha en la cual tendremos contenido todo el codigo a ejecutar en el archivo*/
(()=>{
    //Creamos nuestra solicitud AJAX, con conexion al controlador 'valoresRef.php'
    const filasCuerpo = document.querySelector("#filasCuerpoTabla");
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            const jsonParseado = JSON.parse(this.responseText); //Este es nuestro objeto JSON traido desde nuestro controlador de php.

            //Creamos nuestra clase constructora para implementar un objeto para la creacion de filas.
            class FilasTabla {
                constructor (id, idExamen, tipoMedida, unidad, valorCriticoInferior, valorCriticoSuperior, anormalDisminuidoMinimo, anormalDisminuidoMaximo,
                    rangoNormalMinimo, rangoNormalMaximo, anormalIncrementadoMinimo, anormalIncrementadoMaximo, edadMinima, edadMaxima, sexo, otros) {
                        this.id = id,
                        this.idExamen = idExamen,
                        this.tipoMedida =tipoMedida,
                        this.unidad = unidad,
                        this.valorCriticoInferior = valorCriticoInferior,
                        this.valorCriticoSuperior = valorCriticoSuperior,
                        this.anormalDisminuidoMinimo = anormalDisminuidoMinimo,
                        this.anormalDisminuidoMaximo = anormalDisminuidoMaximo,
                        this.rangoNormalMinimo = rangoNormalMinimo,
                        this.rangoNormalMaximo = rangoNormalMaximo,
                        this.anormalIncrementadoMinimo = anormalIncrementadoMinimo,
                        this.anormalIncrementadoMaximo = anormalIncrementadoMaximo,
                        this.edadMinima = edadMinima,
                        this.edadMaxima = edadMaxima,
                        this.sexo = sexo,
                        this.otros = otros                      
                    }
            }
            
            for (let i = 0; i < jsonParseado.length; i++) {
                var crearReg = new FilasTabla (jsonParseado[i].id_valor_referencia, jsonParseado[i].id_examen, jsonParseado[i].medida, jsonParseado[i].unidad, 
                    jsonParseado[i].valor_critico_inferior, jsonParseado[i].valor_critico_superior, jsonParseado[i].anormal_disminuido_minimo, 
                    jsonParseado[i].anormal_disminuido_minimo, jsonParseado[i].anormal_disminuido_maximo, jsonParseado[i].rango_normal_minimo,
                    jsonParseado[i].rango_normal_maximo, jsonParseado[i].anormal_incrementado_minimo, jsonParseado[i].anormal_incrementado_maximo, jsonParseado[i].edad_minima,
                    jsonParseado[i].edad_maxima, jsonParseado[i].sexo, jsonParseado[i].otros, jsonParseado[i].unidad_edad);
                    
                filasCuerpo.innerHTML += "<tr>"+"<td>"+crearReg.id+"</td>"+"<td>"+crearReg.idExamen+"</td>"+"<td class='celdas1'>"+crearReg.tipoMedida+"</td>"+
                "<td>"+crearReg.unidad+"</td>"+"<td>"+crearReg.valorCriticoInferior+"</td>"+"<td>"+crearReg.valorCriticoSuperior+"</td>"+
                "<td>"+crearReg.anormalDisminuidoMinimo+"</td>"+"<td>"+crearReg.anormalDisminuidoMaximo+"</td>"+"<td>"+crearReg.rangoNormalMinimo+"</td>"+
                "<td>"+crearReg.rangoNormalMaximo+"</td>"+"<td>"+crearReg.anormalIncrementadoMinimo+"</td>"+"<td>"+crearReg.anormalIncrementadoMaximo+"</td>"+
                "<td>"+crearReg.edadMinima+"</td>"+"<td>"+crearReg.edadMaxima+"</td>"+"<td>"+crearReg.sexo+"</td>"+"<td>"+crearReg.otros+"</td>"+"</tr>";            
            }
        
        }
    };
    xmlhttp.open("POST", "../controlador/valoresRef.php", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send();   
})()

