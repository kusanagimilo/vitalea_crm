document.addEventListener("DOMContentLoaded", function (event) {
    agregarPais();
    agregarEstado();
    agregarCiudad();
    agregarBarrio();
    lecturaDataPais();
});

let lecturaDataPais = () => {
    $.ajax({
        type: "POST",
        url: "../controladores/administracionGeograficaController.php",
        async: false,
        dataType: "json",
        data: {
            tipo: 1
        },
        success: function (retu) {
            $.each(retu, function (i, paises) {
                let newRow = "<option>" + paises.nombre_pais + "</option>";
                $(newRow).appendTo("#muestraPais");
                $(newRow).appendTo("#muestraPais2");
                $(newRow).appendTo("#muestraPais3");
            });
        }
    });
};

let lecturaDataEstado = (origen, flag) => {
    let bandera = flag;
    $.ajax({
        type: "POST",
        url: "../controladores/administracionGeograficaController.php",
        async: false,
        dataType: "json",
        data: {
            tipo: 3,
            muestraPais: origen
        },
        success: function (retu) {
            var tipo = 5;
            var idpais = retu[0].id;
            principalLecturaAjax(tipo, idpais, bandera);
        }
    });
};

function principalLecturaAjax(tipo, idPais, bandera) {
    let flag = bandera;
    $.ajax({
        type: "POST",
        url: "../controladores/administracionGeograficaController.php",
        async: false,
        dataType: "json",
        data: {
            tipo: tipo,
            idPais: idPais
        },
        success: function (retu) {
            if (flag == 1) {
                $("#muestraEstado2").html("");
                $.each(retu, function (i, estados) {
                    let newRow = "<option>" + estados.estado + "</option>";
                    $(newRow).appendTo("#muestraEstado2");
                });
            } else if (flag == 2) {
                $("#muestraEstado3").html("");
                $.each(retu, function (i, estados) {
                    let newRow = "<option>" + estados.estado + "</option>";
                    $(newRow).appendTo("#muestraEstado3");
                });
            }
        }
    });
}

function insercionData(e) {
    let inputPais = document.querySelector("#addCounrty").value;
    let inputEstado = document.querySelector("#addState").value;
    let inputCiudad = document.querySelector("#addCity").value;
    let inputBarrio = document.querySelector("#addZone").value;
    let origen = e.target.id;
    let tipo;
    let agregarDato;
    if (origen == "envioDatosPais") {
        tipo = 2;
        agregarDato = inputPais;
        principalAjax(tipo, agregarDato);
    } else if (origen == "envioDatosEstado") {
        agregarDato = inputEstado;
        var muestraPais = document.querySelector("#muestraPais").value;
        consultaPais(agregarDato, muestraPais, origen);
    } else if (origen == "envioDatosCiudad") {
        agregarDato = inputCiudad;
        var muestraPais = document.querySelector("#muestraPais2").value;
        consultaPais(agregarDato, muestraPais, origen);
    } else if (origen == "envioDatosBarrio") {
        agregarDato = inputBarrio;
    }

    function consultaPais() {
        $.ajax({
            type: "POST",
            url: "../controladores/administracionGeograficaController.php",
            async: false,
            dataType: "json",
            data: {
                tipo: 3,
                pais: agregarDato,
                muestraPais: muestraPais
            },
            success: function (retu) {
                if (origen == "envioDatosEstado") {
                    var idPais = retu[0].id;
                    tipo = 4;
                    principalAjax(tipo, agregarDato, idPais);
                } else if (origen == "envioDatosCiudad") {
                    var idPais = retu[0].id;
                    tipo = 5;
                    principalAjax(tipo, agregarDato, idPais);
                } else {
                    var idPais = retu[0].id;
                    tipo = 6;
                    principalAjax(tipo, agregarDato, idPais);
                }
            }
        });
    }
    function principalAjax(tipo, agregarDato, idPais) {
        $.ajax({
            type: "POST",
            url: "../controladores/administracionGeograficaController.php",
            async: false,
            dataType: "json",
            data: {
                tipo: tipo,
                pais: agregarDato,
                idPais: idPais
            },
            success: function (retu) {
                $.each(retu, function (i, estados) {
                    let newRow = "<option>" + estados.estado + "</option>";
                    $(newRow).appendTo("#muestraEstado2");
                    // $(newRow).appendTo("#muestraEstado3");
                });
            }
        });
    }
}

function agregarPais() {
    const botonPais = document.querySelector("#envioDatosPais");
    botonPais.addEventListener("click", insercionData);
    botonPais.addEventListener("touchstart", insercionData);
}

function agregarEstado() {
    var muestraPaiSelect2 = document.querySelector("#muestraPais2");
    muestraPaiSelect2.addEventListener("change", e => {
        let origen = e.target.value;
        let flag = 1;
        lecturaDataEstado(origen, flag);
    });
    // const botonEstado = document.querySelector("#envioDatosEstado");
    // botonEstado.addEventListener("click", insercionData);
    // botonEstado.addEventListener("touchstart", insercionData);
}

function agregarCiudad() {
    var muestraPaiSelect3 = document.querySelector("#muestraPais3");
    muestraPaiSelect3.addEventListener("change", e => {
        let origen = e.target.value;
        let flag = 2;
        lecturaDataEstado(origen, flag);
    });

    // const botonCiudad = document.querySelector("#envioDatosCiudad");
    // botonCiudad.addEventListener("click", insercionData);
    // botonCiudad.addEventListener("touchstart", insercionData);
}

function agregarBarrio() {
    const botonBarrio = document.querySelector("#envioDatosBarrio");
    botonBarrio.addEventListener("click", insercionData);
    botonBarrio.addEventListener("touchstart", insercionData);
}
