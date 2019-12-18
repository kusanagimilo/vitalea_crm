<?PHP
//require_once '../include/script.php';
require_once '../include/script.php';
require_once '../include/header_administrador.php';
?>
<script type="text/javascript" src="js/llqrcode.js"></script>
<script type="text/javascript" src="https://apis.google.com/js/plusone.js"></script>
<script type="text/javascript" src="js/webqr.js"></script>
<script type="text/javascript" src="../ajax/DgTurno.js"></script>



<body style="background-color: #F6F8FA">
 <input type="button" value="ajustar camara" onclick="setwebcam2()" />  
    <input type="hidden" id="usuario_id" value="<?php echo $_SESSION['ID_USUARIO'] ?>">
    <div class="main-menu-area mg-tb-40">
        <div class="container" style="height:auto;">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <ol class="breadcrumb">
                        <li><a href="inicio_digiturno_generar_turno.php" title="Volver atras"><img src="images/atras.png"></a></li>
                        <li><a href="inicio_digiturno_generar_turno.php" title="Inicio">Inicio</a></li>
                        <li class="active">Lectura Codigo QR</li>
                    </ol>
                    <div class="panel panel-default">
                        <div class="panel-heading " style="height: 50px;">
                            <h3 class="panel-title"> 
                                <b  style="float: left"><img src="images/codigo-qr.png" alt=""/> Lectura Codigo QR</b> </h3> 
                        </div>
                        <div class="panel-body" >
                            <div id="examenes" style="padding: 20px;" >
                                <div id="mainbody">
                                    <img class="selector" id="webcamimg" onClick="setwebcam()" align="left" />
                                    <img class="selector" id="qrimg" onClick="setimg()" align="right"/>

                                    <div class="col-md-12">
                                        <div id="outdiv" class="col-md-8">

                                        </div>
                                        <div class="col-md-4" id="result">

                                        </div>

                                    </div>
                                    <br>
                                    <div style="display: none;">
                                        <p style="font-size: 12pt;color:#00c292">   
                                        <center>
                                            <canvas id="qr-canvas"style="width: 100%;border: 1px solid;">
                                            </canvas>
                                        </center>
                                    </div>
                                    <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                                    <!-- webqr_2016 -->
                                    <ins class="adsbygoogle"
                                         style="display:block"
                                         data-ad-client="ca-pub-8418802408648518"
                                         data-ad-slot="2527990541"
                                         data-ad-format="auto">
                                    </ins>
                                    <script>
                                        (adsbygoogle = window.adsbygoogle || []).push({});
                                    </script>

                                </div>
                                 
                                <script type="text/javascript">load();</script>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
<script type="text/javascript">
    var _gaq = _gaq || [];
    _gaq.push(['_setAccount', 'UA-24451557-1']);
    _gaq.push(['_trackPageview']);

    (function () {
        var ga = document.createElement('script');
        ga.type = 'text/javascript';
        ga.async = true;
        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
        var s = document.getElementsByTagName('script')[0];
        s.parentNode.insertBefore(ga, s);
    })();

</script> 

<?php require_once '../include/footer.php'; ?>
</html>