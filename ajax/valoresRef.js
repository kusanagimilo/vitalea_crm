(()=>{
    const filasCuerpo = document.querySelector("filasCuerpoTabla");
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            console.log("conexion ajax exitosa a archivo de eliminacion de registros");
        }
    };
    xmlhttp.open("POST", "./php/eliminarRegistros.php", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send(envio);
    
})()