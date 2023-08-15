$(document).ready(function() {
    function updateTiempo(ordenId) {
      $.ajax({
        url: "../views/obtenerTiempo.php",
        type: "GET",
        data: { orden_id: ordenId },
        success: function(response) {
          var tiempoData = JSON.parse(response);
          if (tiempoData.tiempo !== undefined) {
            // Formatear el tiempo obtenido en formato HH:MM:SS
            var tiempoFormateado = formatTiempo(tiempoData.tiempo);
  
            // Actualizar el contenido del elemento HTML
            $(".cronometro[data-orden='" + ordenId + "']").text(tiempoFormateado);
          }
        },
        error: function(error) {
          console.log("Error al obtener el tiempo.", error);
        },
      });
    }
  
    function formatTiempo(tiempoInSeconds) {
      var hours = Math.floor(tiempoInSeconds / 3600);
      var minutes = Math.floor((tiempoInSeconds % 3600) / 60);
      var seconds = tiempoInSeconds % 60;
      
      return (
        (hours < 10 ? "0" : "") + hours + ":" +
        (minutes < 10 ? "0" : "") + minutes + ":" +
        (seconds < 10 ? "0" : "") + seconds
      );
    }
  
    // Actualizar el tiempo en tiempo real cada segundo
    setInterval(function() {
      $(".cronometro").each(function() {
        var ordenId = $(this).data("orden");
        updateTiempo(ordenId);
      });
    }, 1000);
  });
  