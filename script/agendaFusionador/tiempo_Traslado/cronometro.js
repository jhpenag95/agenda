// Objeto para almacenar los intervalos de tiempo
var intervalos = {};

// Función que se ejecuta al hacer clic en el botón
function FbotonOn(btn) {
  // Verificar si el texto del botón es "Iniciar desplazamiento"
  if ($(btn).text() == "Iniciar desplazamiento") {
    $(btn).text("En desplazamiento").css("background-color", "#138D75");

    var startTime = Date.now();

    if ($(btn).text() == "En desplazamiento") {
      var idUsuario = $(btn).closest('.btn-desplazamiento').data("id");

      intervalos[idUsuario] = setInterval(function () {
        var tiempo = new Date(Date.now() - startTime)
          .toISOString()
          .substr(11, 8);
        var cronometro = document.querySelector('span[name="time"][data-id="' + idUsuario + '"]');
        if (cronometro) {
          cronometro.textContent = tiempo;
          cronometro.style.color = tiempo >= "00:30:00" ? "red" : "";
        }

        // Guardar el estado en el LocalStorage
        localStorage.setItem("buttonState", $(btn).text());
        localStorage.setItem("startTime", startTime.toString());
        localStorage.setItem("idUsuario", idUsuario.toString());

        // Obtener el elemento input hidden
        var idOrdenInput = document.getElementById('id_orden');

        // Obtener el valor del campo id_orden
        var idOrden = idOrdenInput.value;

        // Guardar el valor en el localStorage
        localStorage.setItem('id_orden', idOrden);
        location.reload();
      }, 1000);

    }
  } else if ($(btn).text() == "En desplazamiento") {
    $(btn).text("Se detuvo").css("background-color", "#B71C1C");
    var idUsuario = $(btn).data("id");
    clearInterval(intervalos[idUsuario]);

    delete intervalos[idUsuario]; // Eliminar el ID de intervalo para el ID de usuario especificado

    // Guardar el estado en el LocalStorage
    localStorage.setItem("buttonState", $(btn).text());
    localStorage.setItem("idUsuario", idUsuario.toString());
    localStorage.setItem("lastTime4", Date.now().toString());


    // Mostrar el siguiente botón
    $('.guardar').css("display", "block");

  }
}


document.addEventListener("DOMContentLoaded", function () {
  // Cuando la ventana se ha cargado completamente, se ejecuta esta función

  // Recuperar los datos del LocalStorage
  var buttonState = localStorage.getItem("buttonState");
  var startTime = localStorage.getItem("startTime");
  var idUsuario = localStorage.getItem("idUsuario");
  var nombreDeLaClave1 = localStorage.getItem("id_orden");

  const id_orden = localStorage.getItem("id_orden");
  const data = {
    id_orden: id_orden
  };

  $.ajax({
    url: '../controller/actualizar_estado_orden.php',
    type: 'POST',
    data: data,
    success: function (response) {
      console.log(response);
    },
    error: function (xhr, status, error) {
      console.log("Error en la solicitud AJAX:", error);
    }
  });

  // Verificar si los datos existen en el LocalStorage
  if (buttonState && startTime && idUsuario && nombreDeLaClave1) {
    // Obtener el botón y el cronmetro correspondientes al usuario
    var btn = document.querySelector('button[data-id="' + idUsuario + '"]');
    var cronometro = document.querySelector('span[name="time"][data-id="' + idUsuario + '"]');

    // Verificar el estado del botón
    if (buttonState == "En desplazamiento") {
      // Configurar el botón y calcular el tiempo transcurrido
      $(btn).text("En desplazamiento").css("background-color", "#138D75");
      var currentTime = Date.now();
      var elapsedTime = currentTime - parseInt(startTime);
      var tiempo = new Date(elapsedTime).toISOString().substr(11, 8);

      // Mostrar el tiempo en el cronómetro y cambiar el color si es mayor o igual a 10 minutos
      if (cronometro) {
        cronometro.textContent = tiempo;
        cronometro.style.color = tiempo >= "00:30:00" ? "red" : "";
      }

      // Volver a iniciar el intervalo para actualizar el cronómetro cada segundo
      intervalos[idUsuario] = setInterval(function () {
        var tiempo = new Date(Date.now() - currentTime + elapsedTime)
          .toISOString()
          .substr(11, 8);

        if (cronometro) {
          cronometro.textContent = tiempo;
          cronometro.style.color = tiempo >= "00:30:00" ? "red" : "";
        }
      }, 1000);
    } else if (buttonState == "Se detuvo") {
      // Configurar el botón si está detenido
      $(btn).text("Se detuvo").css("background-color", "#B71C1C");

      // Mostrar el último tiempo guardado en el cronómetro
      var lastTime = localStorage.getItem("lastTime4");
      if (lastTime) {
        var elapsedTime = Date.now() - parseInt(lastTime);
        var tiempoFormatted = new Date(elapsedTime).toISOString().substr(11, 8);
        var spanElement = document.querySelector('.time');
        spanElement.textContent = tiempoFormatted;

        // Mostrar el siguiente botón
        $('.guardar').css("display", "block");
      }
    }
  }
});
