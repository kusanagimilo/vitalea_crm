
<!DOCTYPE html>
<html lang="en">
  <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="description" content="">
      <meta name="author" content="Our Code World">

      <title>Vitalea</title>

      <!-- Don't forget to add artyom to your document in the head tag-->

      <script src="artyom.min.js"></script>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  </head>

  <body>
    <div>
      <h4> </h4><img src="../images/vitalea_logo2.png">
    
      <div id="commands-list">

      </div>
      <textarea id="text-content"></textarea>
      <input id="talk-lang" type="button" value="Escuchar"/>
      <select id="select-voice">

      </select>
      <input id="load-voices" type="button" value="Load voices"/>
      <div id="voices-item"></div>
    </div>
    <script>
    $("#talk-lang").click(function(){
        artyom.say($("#text-content").val());
    });

    $("#select-voice").change(function(){
        var lang = $(this).val();

        artyom.initialize({lang:lang});
    });

    document.getElementById("load-voices").addEventListener("click", function(){
        var voices = artyom.getVoices();
        var html = "";

        voices.forEach(function(voice){
            html += "Voz name : " + voice.name + " con lang : " + voice.lang + "<br>";
        });

        document.getElementById("voices-item").innerHTML = html;
    }, false);
      // Now we add the most important point of the plugin, the commands
      // This library is very flexible and now we will see why :
      // Every command is a literal object
     


      // Redirect the recognized text
      artyom.redirectRecognizedTextOutput(function(text,isFinal){
        var span = document.getElementById('output');

        if(isFinal){
          span.innerHTML = '';
        }else {
          span.innerHTML = text;
        }
      });

      function startArtyom(){
        artyom.initialize({
          lang:"es-ES",// More languages are documented in the library
          continuous:false,//if you have https connection, you can activate continuous mode
          debug:true,//Show everything in the console
          listen:true // Start listening when this function is triggered
        });
      }

      function stopArtyom(){
        artyom.fatality();
      }

      window.onload = function(){
          var tab = document.getElementById("commands-list");
          var commands =  artyom.getAvailableCommands();
          var html = '';

          for(var i = 0;i < commands.length;i++){
              var command = commands[i];
              html += command.description + " : <span style='color:blue;'>"+command.indexes.toString()+"</span><br>";
          }

          tab.innerHTML = html;

          artyom.initialize({lang:"es-ES"});

        var vocesitas = [
            {lang:"es-ES",description: "Espanol"},
            {lang:"de-DE",description: "Deutsch"},
            {lang:"pt-PT",description: "Portugues"},
            {lang:"it-IT",description: "Italiano"}
        ];

        vocesitas.forEach(function(voice){
            $('#select-voice').append($('<option>', {value:voice.lang, text:voice.description}));
        });
      };
    </script>
  </body>

</html>
