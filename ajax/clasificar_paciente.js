
function clasificar_paciente(value,pregunta){

    var clasificacion = $("#clasificacion").val();

   if(pregunta == "pregunta_2"){
        if(value == "Si"){
            $("#p3").show();
            $("#p5").hide();

        }
        else if(value=="No"){
            $("#p3").hide();
            $("#p5").show();
        }
   }

   if(pregunta == "pregunta_3"){
        if(value == "Si"){
            $("#p4").show();
            $("#p5").hide();

        }
        else if(value=="No"){
            $("#p4").hide();
            $("#p5").show();
        }
   }

    if(pregunta == "pregunta_4"){
      
        if(value == "Si"){
            //cronico
            $("#clasificacion").val(4);
            $("#resultado_clasificacion").show();
            $("#resultado").html("<b>Crónico</b>");
        }
        else {
            $("#p5").show();
            $("#clasificacion").val(1);
            $("#resultado_clasificacion").hide();
        }
                  
   }

   if(pregunta == "pregunta_5"){
        if(value == "Si"){
            $("#p6").show();
            $("#p8").hide();

        }
        else if(value=="No"){
            $("#p6").hide();
            $("#p8").show();
        }
   }

   if(pregunta == "pregunta_6"){
        if(value == "Si"){
            $("#p7").show();
            $("#p8").hide();

        }
        else if(value=="No"){
            $("#p7").hide();
            $("#p8").show();
        }
   }

    if(pregunta == "pregunta_7"){
      
        if(value == "Si"){
        //fitness
            $("#clasificacion").val(2);
            $("#resultado_clasificacion").show();
            $("#resultado").html("<b>Fitness</b>");
          
        }else{
            $("#p8").show(); 
            $("#clasificacion").val(1);
            $("#resultado_clasificacion").hide(); 
        }
               
   }

   if(pregunta == "pregunta_8"){
        if(value == "Si"){
            $("#p9").show();
            $("#p11").hide();

        }
        else if(value=="No"){
            $("#p9").hide();
            $("#p11").show();
        }
   }

   if(pregunta == "pregunta_9"){
        if(value == "Si"){
            $("#p10").show();
            $("#p11").hide();

        }
        else if(value=="No"){
            $("#p10").hide();
            $("#p11").show();
        }
   }

   if(pregunta == "pregunta_10"){
      
        if(value == "Si"){
         //nutricion
            $("#clasificacion").val(3);
            $("#resultado_clasificacion").show();
            $("#resultado").html("<b>Nutrición</b>");
         
        }else{
          $("#p11").show();  
          $("#clasificacion").val(1);
          $("#resultado_clasificacion").hide();    
        }
             
   }

   if(pregunta == "pregunta_11"){
        if(value == "Si"){
            $("#p12").show();
            $("#p13").hide();

        }
        else if(value=="No"){
            $("#p12").hide();
            $("#p13").show();
        }
   }

   if(pregunta == "pregunta_12"){
      
        if(value == "Si"){
         //wellness y autoconocimiento

            $("#clasificacion").val(7);
            $("#resultado_clasificacion").show();
            $("#resultado").html("<b>Wellness y Autoconocimiento</b>");
        }else{
          $("#p13").show(); 
          $("#clasificacion").val(1);
          $("#resultado_clasificacion").hide();
        }
                  
   }

   if(pregunta == "pregunta_13"){
        if(value == "Si"){
            $("#p14").show();
            $("#p15").hide();

        }
        else if(value=="No"){
            $("#p14").hide();
            $("#p15").show();
        }
   }

   if(pregunta == "pregunta_14"){
      
        if(value == "Si"){
         //genetico
          $("#clasificacion").val(6);
          $("#resultado_clasificacion").show();
          $("#resultado").html("<b>Genético</b>");
       
        }else{
          $("#p15").show(); 
          $("#clasificacion").val(1);
          $("#resultado_clasificacion").hide();  
        }
                
   }


   if(pregunta == "pregunta_15"){
        if(value == "Si"){
            $("#p16").show();
            $("#p18").hide();

        }
        else if(value=="No"){
            $("#p16").hide();
            $("#p18").show();
        }
   }

   if(pregunta == "pregunta_16"){
        if(value == "Si"){
            $("#p17").show();
            $("#p18").hide();

        }
        else if(value=="No"){
            $("#p17").hide();
            $("#p18").show();
        }
   }

    if(pregunta == "pregunta_17"){
      
        if(value == "Si"){
        // Salud Reproductiva
          $("#clasificacion").val(8);
          $("#resultado_clasificacion").show();
          $("#resultado").html("<b>Salud Reproductiva</b>");
        }else{
          $("#p18").show();
          $("#clasificacion").val(1);
          $("#resultado_clasificacion").hide();
        }
                   
   }

   if(pregunta == "pregunta_18"){
        if(value == "Si"){
            $("#p19").show();
            $("#p20").hide();

        }
        else if(value=="No"){
            $("#p19").hide();
            $("#p20").show();
        }
   }

   if(pregunta == "pregunta_19"){
      
        if(value == "Si"){
         //viajero
          $("#clasificacion").val(9);
          $("#resultado_clasificacion").show();
          $("#resultado").html("<b>Viajero</b>"); 
        }else{
          $("#p20").show(); 
          $("#clasificacion").val(1);
          $("#resultado_clasificacion").hide(); 
        }
                 
   }

   if(pregunta == "pregunta_20"){
        if(value == "Si"){
            $("#p21").show();

        }
        else if(value=="No"){
            $("#p21").show();
        }
   }

   if(pregunta == "pregunta_21"){
      
        if(value == "Si"){
         
            $("#clasificacion").val(5);
            $("#resultado_clasificacion").show();
            $("#resultado").html("<b>Salud Sexual</b>"); 
        }else{
           $("#clasificacion").val(1);
            $("#resultado_clasificacion").show();
            $("#resultado").html("<b>General</b>"); 
        }
             
   }
         
}


