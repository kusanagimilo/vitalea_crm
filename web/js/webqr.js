// QRCODE reader Copyright 2011 Lazar Laszlo
// http://www.webqr.com

var gCtx = null;
var gCanvas = null;
var c = 0;
var stype = 0;
var gUM = false;
var webkit = false;
var moz = false;
var v = null;

var imghtml = '<div id="qrfile"><canvas id="out-canvas" class="col-lg-12 col-md-12 col-sm-12 col-xs-12" > </canvas>' +
        '<div id="imghelp">drag and drop a QRCode here' +
        '<br>or select a file' +
        '<input type="file" value="aqui estoy file" onchange="handleFiles(this.files)"/>' +
        '</div>' +
        '</div>';

var vidhtml = '<video id="v" autoplay  class="col-md-12"></video>';

function dragenter(e) {
    e.stopPropagation();
    e.preventDefault();
}

function dragover(e) {
    e.stopPropagation();
    e.preventDefault();
}
function drop(e) {
    e.stopPropagation();
    e.preventDefault();

    var dt = e.dataTransfer;
    var files = dt.files;
    if (files.length > 0)
    {
        handleFiles(files);
    } else
    if (dt.getData('URL'))
    {
        qrcode.decode(dt.getData('URL'));
    }
}

function handleFiles(f)
{
    var o = [];

    for (var i = 0; i < f.length; i++)
    {
        var reader = new FileReader();
        reader.onload = (function (theFile) {
            return function (e) {
                gCtx.clearRect(0, 0, gCanvas.width, gCanvas.height);

                qrcode.decode(e.target.result);
            };
        })(f[i]);
        reader.readAsDataURL(f[i]);
    }
}

function initCanvas(w, h)
{
    gCanvas = document.getElementById("qr-canvas");
    gCanvas.style.width = w + "px";
    gCanvas.style.height = h + "px";
    gCanvas.width = w;
    gCanvas.height = h;
    gCtx = gCanvas.getContext("2d");
    gCtx.clearRect(0, 0, w, h);
}


function captureToCanvas() {
    if (stype != 1)
        return;
    if (gUM)
    {
        try {
            gCtx.drawImage(v, 0, 0);
            try {
                qrcode.decode();
            } catch (e) {
                console.log(e);
                setTimeout(captureToCanvas, 500);
            }
            ;
        } catch (e) {
            console.log(e);
            setTimeout(captureToCanvas, 500);
        }
        ;
    }
}

function htmlEntities(str) {
    return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
}

function read(a)
{


    var id_venta = $.trim(a);


    var data;
    $.ajax({
        type: "POST",
        url: "../controladores/FacturacionController.php",
        async: false,
        dataType: 'json',
        data: {
            tipo: 3,
            id: id_venta

        },
        success: function (retu) {
            data = retu;
        }
    });


    if (data == "no_existe") {
        alert("Codigo QR no valido");
    } else {


        $.each(data, function (i, venta) {

            var tipo_turno;
            var tipo_turno_on;

            if (venta.estado == 1) {
                tipo_turno = 'PAGO';
                tipo_turno_on = '"PAGO"';
            } else if (venta.estado == 2) {
                tipo_turno = 'TOMA_MUESTRA';
                tipo_turno_on = '"TOMA_MUESTRA"';
            }

            var datos_turno = DatosTurno(venta.id_venta, tipo_turno);

            var html = "";

            if (datos_turno == 'sin_turno' || datos_turno[0].estado == "CANCELADO" || datos_turno[0].estado == "") {

                if (tipo_turno == "PAGO") {

                    html = "<table class='table table-bordered'>" +
                            "<tr><td colspan='2'><b>TURNO</b></td></tr>" +
                            "<tr>" +
                            "<td>Cliente</td><td>" + venta.cliente + "</td>" +
                            "</tr>" +
                            "<tr>" +
                            "<td>Documento</td><td>" + venta.documento + ", " + venta.tipo_doc + "</td>" +
                            "</tr>" +
                            "<tr>" +
                            "<td>Tipo turno</td><td>" + tipo_turno + "</td>" +
                            "</tr>" +
                            "<tr>" +
                            "<td>Codigo solicitud</td><td>" + venta.codigo_venta + "</td>" +
                            "</tr>" +
                            "<tr>" +
                            "<td colspan='2'>" +
                            "<center>" +
                            "<button  onclick='SolicitarTurno(" + tipo_turno_on + "," + venta.id_cliente + "," + venta.id_venta + ")'type='button' class='btn btn-primary btn-lg btn-block'>SOLICITAR TURNO</button><br>" +
                            "<button  onclick='LeerOtroQr()'type='button' class='btn btn-warning btn-lg btn-block'>LEER OTRO QR</button>" +
                            "</center></td>" +
                            "</tr>" +
                            "</table>";



                } else if (tipo_turno == "TOMA_MUESTRA") {

                    html = "<table class='table table-bordered'>" +
                            "<tr><td colspan='2'><b>TURNO</b></td></tr>" +
                            "<tr>" +
                            "<td>Cliente</td><td>" + venta.cliente + "</td>" +
                            "</tr>" +
                            "<tr>" +
                            "<td>Documento</td><td>" + venta.documento + ", " + venta.tipo_doc + "</td>" +
                            "</tr>" +
                            "<tr>" +
                            "<td>Tipo turno</td><td>" + tipo_turno + "</td>" +
                            "</tr>" +
                            "<tr>" +
                            "<td>Codigo solicitud</td><td>" + venta.codigo_venta + "</td>" +
                            "</tr>" +
                            "<tr>" +
                            "<td colspan='2'>" +
                            "<center>" +
                            "<button  onclick='SolicitarTurno(" + tipo_turno_on + "," + venta.id_cliente + "," + venta.id_venta + ")'type='button' class='btn btn-primary btn-lg btn-block'>SOLICITAR TURNO</button><br>" +
                            "<button  onclick='LeerOtroQr()'type='button' class='btn btn-warning btn-lg btn-block'>LEER OTRO QR</button>" +
                            "</center></td>" +
                            "</tr>" +
                            "</table>";

                }

            } else if (datos_turno[0].estado == "TERMINADO" || datos_turno[0].estado == "INICIADO" || datos_turno[0].estado == "ACEPTADO") {
                html = "<table class='table table-bordered'>" +
                        "<tr><td colspan='2'><b>TURNO</b></td></tr>" +
                        "<tr><td>TURNO</td><td>" + datos_turno[0].turno + "</td></tr>" +
                        "<tr><td>ESTADO</td><td>" + datos_turno[0].estado + "</td></tr>" +
                        "<tr>" +
                        "<td colspan='2'>" +
                        "<center>" +
                        "<button  onclick='LeerOtroQr()'type='button' class='btn btn-warning btn-lg btn-block'>LEER OTRO QR</button>" +
                        "</center></td>" +
                        "</tr>" +
                        "</table>";
            }

            $("#result").html(html);
            $("#img_cargando").remove();

            
        });



    }
    //$("").html();

    //document.getElementById("result").innerHTML = html;
}

function isCanvasSupported() {
    var elem = document.createElement('canvas');
    return !!(elem.getContext && elem.getContext('2d'));
}
function success(stream)
{

    v.srcObject = stream;
    v.play();

    gUM = true;
    setTimeout(captureToCanvas, 500);
}

function error(error)
{
    gUM = false;
    return;
}

function load()
{
    if (isCanvasSupported() && window.File && window.FileReader)
    {
        initCanvas(800, 600);
        qrcode.callback = read;
        document.getElementById("mainbody").style.display = "inline";
        setwebcam();
    } else
    {
        document.getElementById("mainbody").style.display = "inline";
        document.getElementById("mainbody").innerHTML = '<p id="mp1">QR code scanner for HTML5 capable browsers</p><br>' +
                '<br><p id="mp2">sorry your browser is not supported</p><br><br>' +
                '<p id="mp1">try <a href="http://www.mozilla.com/firefox"><img src="firefox.png"/></a> or <a href="http://chrome.google.com"><img src="chrome_logo.gif"/></a> or <a href="http://www.opera.com"><img src="Opera-logo.png"/></a></p>';
    }
}

function setwebcam()
{

    var options = true;
    if (navigator.mediaDevices && navigator.mediaDevices.enumerateDevices)
    {
        try {
            navigator.mediaDevices.enumerateDevices()
                    .then(function (devices) {
                        devices.forEach(function (device) {
                            if (device.kind === 'videoinput') {
                                if (device.label.toLowerCase().search("back") > -1)
                                    options = {'deviceId': {'exact': device.deviceId}, 'facingMode': 'environment'};
                            }
                            console.log(device.kind + ": " + device.label + " id = " + device.deviceId);
                        });
                        setwebcam2(options);
                    });
        } catch (e)
        {
            console.log(e);
        }
    } else {
        console.log("no navigator.mediaDevices.enumerateDevices");
        setwebcam2(options);
    }

}

function setwebcam2(options)
{
    console.log(options);
    document.getElementById("result").innerHTML = "Por favor acerque el código QR que fue entregado por correo electrónico para proseguir con el proceso de generación de turno";
    if (stype == 1)
    {
        setTimeout(captureToCanvas, 500);
        return;
    }
    var n = navigator;
    document.getElementById("outdiv").innerHTML = vidhtml;
    v = document.getElementById("v");


    if (n.mediaDevices.getUserMedia)
    {
        n.mediaDevices.getUserMedia({video: options, audio: false}).
                then(function (stream) {
                    success(stream);
                }).catch(function (error) {
            error(error)
            //alert(error);
        });
    } else
    if (n.getUserMedia)
    {
        webkit = true;
        n.getUserMedia({video: options, audio: false}, success, error);
    } else
    if (n.webkitGetUserMedia)
    {
        webkit = true;
        n.webkitGetUserMedia({video: options, audio: false}, success, error);
    }

    document.getElementById("qrimg").style.opacity = 0.2;
    document.getElementById("webcamimg").style.opacity = 1.0;

    stype = 1;
    setTimeout(captureToCanvas, 500);
}

function setimg()
{
    document.getElementById("result").innerHTML = "0000000";
    if (stype == 2)
        return;
    document.getElementById("outdiv").innerHTML = imghtml;
    //document.getElementById("qrimg").src="qrimg.png";
    //document.getElementById("webcamimg").src="webcam2.png";
    document.getElementById("qrimg").style.opacity = 1.0;
    document.getElementById("webcamimg").style.opacity = 0.2;
    var qrfile = document.getElementById("qrfile");
    qrfile.addEventListener("dragenter", dragenter, false);
    qrfile.addEventListener("dragover", dragover, false);
    qrfile.addEventListener("drop", drop, false);
    stype = 2;
}