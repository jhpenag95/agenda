// Esperar hasta que el documento esté listo antes de ejecutar el código
$(document).ready(function() {

  // Iterar a través de cada elemento con la clase "cronometro"
  $(".cronometro").each(function() {
    // Obtener el ID de orden almacenado en el atributo de datos "orden"
    var ordenId = $(this).data("orden");
    
  
    // Obtener el tiempo de inicio almacenado en el almacenamiento local o usar la hora actual si no existe
    var startTime = localStorage.getItem(ordenId) || new Date().getTime();

    // Definir una función para actualizar el tiempo en el servidor
    function updateServerTime() {
      // Obtener el tiempo actual en milisegundos
      var currentTime = new Date().getTime();
      // Calcular el tiempo transcurrido en segundos desde el inicio
      var elapsedTimeInSeconds = Math.floor((currentTime - startTime) / 1000);

      // Crear un objeto con los datos de orden y tiempo para enviar al servidor
      var data = {
        orden_id: ordenId,
        tiempo: elapsedTimeInSeconds,
      };

      // Realizar una solicitud AJAX para actualizar el tiempo en el servidor
      $.ajax({
        url: "../views/tiempoProcess.php",  // URL del script PHP que procesará la solicitud
        type: "POST",                       // Método de la solicitud
        data: data,                         // Datos a enviar al servidor
        success: function(response) {       // Función a ejecutar en caso de éxito
          // Analizar la respuesta JSON del servidor
          var responseData = JSON.parse(response);
          // Verificar si la respuesta indica éxito
          if (responseData.status === "success") {
            console.log("Tiempo actualizado en el servidor para orden " + ordenId + ".");
          }
        },
        error: function(error) {            // Función a ejecutar en caso de error
          console.log("Error al actualizar el tiempo en el servidor para orden " + ordenId + ".", error);
        },
      });
    }

    // Ejecutar la función de actualización del servidor cada segundo (1000 milisegundos)
    setInterval(function() {
      updateServerTime();
    }, 1000);

    
    // Guardar el tiempo de inicio en el almacenamiento local para futuras referencias
    localStorage.setItem(ordenId, startTime);


  });
});
