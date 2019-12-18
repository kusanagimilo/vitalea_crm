
function imprimir_factura(id_factura,cliente_id){
            VentanaCentrada('ver_factura.php?id_factura='+id_factura+'&cliente_id='+cliente_id,'Factura','','1024','768','true');
        }

function VentanaCentrada(theURL,winName,features, myWidth, myHeight, isCenter) { //v3.0
  if(window.screen)if(isCenter)if(isCenter=="true"){
    var myLeft = (screen.width-myWidth)/2;
    var myTop = (screen.height-myHeight)/2;
    features+=(features!='')?',':'';
    features+=',left='+myLeft+',top='+myTop;
  }
  window.open(theURL,winName,features+((features!='')?',':'')+'width='+myWidth+',height='+myHeight);
}        

function ventanaSecundaria (URL){ 
         window.open(URL,"ventana1","width=800,height=500,Top=150,Left=50%") 
}
function deshabilitaRetroceso(){
    window.location.hash="no-back-button";
    window.location.hash="Again-No-back-button" //chrome
    window.onhashchange=function(){window.location.hash="no-back-button";}
}

function valida(val){

  var campo = $("#email").val();
 
    if(campo != null){
        if(campo != val){ 
            alertify.alert("Email no coincide");
            campo = null;
            return false; 
       }else{ 
        $("#coincide_email").val(1);
        return true; 
      }
    }else{
        campo = val;
        return;
    }
}
