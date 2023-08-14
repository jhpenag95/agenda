// Objeto para almacenar los intervalos de tiempo
var intervalos2 = {};

// Función que se ejecuta al hacer clic en el botón
function BbotonOn(btn2) {
  // Verificar si el texto del botón es "Iniciar Tarea"
  if ($(btn2).text() == "Iniciar Tarea") {
    // Cambiar el texto del botón a "En Tarea" y aplicar estilos
    $(btn2).text("En Tarea").css("background-color", "#138D75");

    // Obtener el tiempo de inicio
    var startTime2 = Date.now();

    // Verificar si el texto del botón es "En Tarea"
    if ($(btn2).text() == "En Tarea") {
      // Obtener el ID del usuario desde el atributo "data-id" del botón
      var idUsuario2 = $(btn2).closest('.btn-tarea').data("id");

      // Iniciar un intervalo de tiempo que se ejecuta cada segundo
      intervalos2[idUsuario2] = setInterval(function () {
        // Calcular el tiempo transcurrido desde el inicio
        var tiempo2 = new Date(Date.now() - startTime2)
          .toISOString()
          .substr(11, 8);

        // Obtener el elemento del cronómetro correspondiente al ID del usuario
        var cronometro2 = document.querySelector('span[name="timeTarea"][data-id="' + idUsuario2 + '"]');

        // Verificar si se encontró el cronómetro
        if (cronometro2) {
          // Actualizar el texto del cronómetro con el tiempo transcurrido
          cronometro2.textContent = tiempo2;

          // Cambiar el color del cronómetro a rojo si supera los 10 minutos
          cronometro2.style.color = tiempo2 >= "00:30:00" ? "red" : "";
        }

        // Guardar el estado en el LocalStorage
        localStorage.setItem("buttonState2", $(btn2).text());
        localStorage.setItem("startTime2", startTime2.toString());
        localStorage.setItem("idUsuario2", idUsuario2.toString());


        // Obtener el elemento input hidden
        var idOrdenInput = document.getElementById('id_orden');

        // Obtener el valor del campo id_orden
        var idOrden = idOrdenInput.value;

        // Guardar el valor en el localStorage
        localStorage.setItem('id_orden', idOrden);



      }, 1000); // Intervalo de 1 segundo
    }
  } else if ($(btn2).text() == "En Tarea") {
    // Mostrar un mensaje de confirmación antes de detener el tiempo
    Swal.fire({
      title: '¿Seguro quieres detener el tiempo?',
      text: "Si lo detienes debes guardar inmediatamete y no se podrás reiniciar el tiempo.",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Sí, detener tiempo'
    }).then((result) => {
      if (result.isConfirmed) {
        // Cambiar el texto del botón a "Se detuvo" y aplicar estilos
        $(btn2).text("Se detuvo").css("background-color", "#B71C1C");

        // Obtener el ID del usuario desde el atributo "data-id" del botón
        var idUsuario2 = $(btn2).data("id");

        // Detener el intervalo de tiempo correspondiente al ID del usuario
        clearInterval(intervalos2[idUsuario2]);

        // Eliminar el ID de intervalo para el ID de usuario especificado
        delete intervalos2[idUsuario2];

        // Guardar el estado y el último tiempo en el LocalStorage
        localStorage.setItem("buttonState2", $(btn2).text());
        localStorage.setItem("idUsuario2", idUsuario2.toString());
        localStorage.setItem("lastTime2", Date.now().toString());

        // Mostrar el siguiente botón
        $('.guardar2').css("display", "block");

        // Mostrar un mensaje de éxito
        Swal.fire(
          'Tiempo detenido',
          'El tiempo ha sido detenido guarda por favor.',
          'success'
        );
      }
    });
  }
}

// Función que se ejecuta cuando se carga la página
window.onload = function () {
  // Recuperar los datos del LocalStorage
  var buttonState2 = localStorage.getItem("buttonState2");
  var startTime2 = localStorage.getItem("startTime2");
  var idUsuario2 = localStorage.getItem("idUsuario2");
  var lastTime2 = localStorage.getItem("lastTime2");
  var nombreDeLaClave = localStorage.getItem("id_orden");

  // Verificar si se encontraron los datos en el LocalStorage
  if (buttonState2 && startTime2 && idUsuario2 && nombreDeLaClave) {
    // Obtener el botón correspondiente al ID del usuario
    var btn2 = document.querySelector('button.btn-tarea[data-id="' + idUsuario2 + '"]');

    // Obtener el elemento del cronómetro correspondiente al ID del usuario
    var cronometro2 = document.querySelector('span[name="timeTarea"][data-id="' + idUsuario2 + '"]');

    // Verificar el estado del botón En Tarea
    if (buttonState2 == "En Tarea") {
      // Restaurar el texto y los estilos originales del botón
      $(btn2).text("En Tarea").css("background-color", "#138D75");

      // Obtener el tiempo actual
      var currentTime2 = Date.now();

      // Calcular el tiempo transcurrido desde el inicio
      var elapsedTime2 = currentTime2 - parseInt(startTime2);

      // Calcular el tiempo en formato hh:mm:ss
      var tiempo2 = new Date(elapsedTime2).toISOString().substr(11, 8);

      // Verificar si se encontró el cronómetro
      if (cronometro2) {
        // Actualizar el texto del cronómetro con el tiempo transcurrido
        cronometro2.textContent = tiempo2;

        // Cambiar el color del cronómetro a rojo si supera los 10 minutos
        cronometro2.style.color = tiempo2 >= "00:30:00" ? "red" : "";
      }

      // Volver a iniciar el intervalo
      intervalos2[idUsuario2] = setInterval(function () {
        // Calcular el tiempo transcurrido desde el inicio teniendo en cuenta el tiempo actual y el tiempo acumulado
        var tiempo2 = new Date(Date.now() - currentTime2 + elapsedTime2)
          .toISOString()
          .substr(11, 8);

        // Verificar si se encontró el cronómetro
        if (cronometro2) {
          // Actualizar el texto del cronómetro con el tiempo transcurrido
          cronometro2.textContent = tiempo2;

          // Cambiar el color del cronómetro a rojo si supera los 10 minutos
          cronometro2.style.color = tiempo2 >= "00:30:00" ? "red" : "";
        }
      }, 1000); // Intervalo de 1 segundo
    } else if (buttonState2 == "Se detuvo") {
      // Restaurar el texto y los estilos originales del botón
      $(btn2).text("Se detuvo").css("background-color", "#B71C1C");

      // Detener el intervalo
      clearInterval(intervalos2[idUsuario2]);

      // Mostrar el último tiempo guardado en el cronómetro
      if (lastTime2) {
        var elapsedTime = Date.now() - parseInt(lastTime2);
        var tiempoFormatted = new Date(elapsedTime).toISOString().substr(11, 8);
        cronometro2.textContent = tiempoFormatted;

        // Mostrar el siguiente botón
        $('.guardar2').css("display", "block");
      }
    }
  }
};
