$(document).ready(function() {
    var ordenId = $(".cronometro").data("orden");
    var startTime = localStorage.getItem("startTime_" + ordenId) || new Date().getTime();
  
    function updateServerTime() {
      var currentTime = new Date().getTime();
      var elapsedTimeInSeconds = Math.floor((currentTime - startTime) / 1000);
  
      var data = {
        orden_id: ordenId,
        tiempo: elapsedTimeInSeconds,
      };
  
      $.ajax({
        url: "../views/tiempoProcess.php",
        type: "POST",
        data: data,
        success: function(response) {
          var responseData = JSON.parse(response);
          if (responseData.status === "success") {
            console.log("Tiempo actualizado en el servidor.");
          }
        },
        error: function(error) {
          console.log("Error al actualizar el tiempo en el servidor.", error);
        },
      });
    }
  
    setInterval(function() {
      updateServerTime();
    }, 1000);
  
    // Guardar el tiempo de inicio en el almacenamiento local
    localStorage.setItem("startTime_" + ordenId, startTime);
  });
  