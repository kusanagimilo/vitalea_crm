$(document).ready(function ()
{
    jQuery("#btn_inicio_sesion").on("click", function(){
       alertify.set({labels: 
                            {
                                ok: "Entendido",
                                cancel: "Consultar anteriores"
                            }
                        });
	
        var usuario_acceso = $("#usuario_acceso").val();
        var clave = $("#clave").val();
        
        if(usuario_acceso.length === 0 || clave.length === 0 ){
            alertify.alert("Digite usuario y contraseña");
        }
        else{
            jQuery.ajax({
            url: 'controlador/Sesion.php',
            data:
                    {
                        usuario_acceso:usuario_acceso,
                        clave:clave
                    },
            type: 'post',
            }).done(function(data){	
                console.log(data);
                if(data==1){
                    alertify.alert('Usuario no registrado', function(){ alertify.success('Verifica e intenta nuevamente'); }); 
                }
                else if(data==2){
                    alertify.alert('Usuario Inactivo', function(){ alertify.success('Comuniquese con el Administrador'); }); 
                }
                else {
                 window.location.href="web/inicio.php"; 
                }
             
                
           
        });
    }
    });
});




