$(document).ready(function () {
  $('.guardar2').click(function (e) {
    e.preventDefault();

    // Obtener los datos del localStorage
    var idUsuario = localStorage.getItem('idUsuario2');
    var startTime = parseInt(localStorage.getItem('startTime2'));
    var lastTime = parseInt(localStorage.getItem('lastTime2'));
    var nombreDeLaClave = localStorage.getItem("id_orden");

    // Obtener el tiempo actual
    //var currentTime = Date.now();

    // Calcular el tiempo transcurrido en milisegundos
    var elapsedTime = lastTime - startTime;

    // Calcular el número de horas completas
    var hours = Math.floor(elapsedTime / (1000 * 60 * 60));

    // Calcular el número de minutos completos restantes después de restar las horas
    var minutes = Math.floor((elapsedTime - (hours * 1000 * 60 * 60)) / (1000 * 60));

    // Calcular el número de segundos completos restantes después de restar las horas y los minutos
    var seconds = Math.floor((elapsedTime - (hours * 1000 * 60 * 60) - (minutes * 1000 * 60)) / 1000);

    // Formatear el tiempo transcurrido como una cadena de texto en formato HH:MM:SS
    var tiempoFormatted = hours.toString().padStart(2, '0') + ':' + minutes.toString().padStart(2, '0') + ':' + seconds.toString().padStart(2, '0');
    

    // Crear un objeto de datos para enviar al servidor
    var data = {
      idUsuario2: idUsuario,
      tiempoFormatted2: tiempoFormatted,
      nombreDeLaClave2: nombreDeLaClave
    };

    // Enviar la solicitud AJAX al servidor
    $.ajax({
      url: '../controller/capturar_tiempoTarea.php', // Ruta a tu archivo PHP que manejará la solicitud
      type: 'POST',
      data: data,
      success: function (response) {
        // Mostrar el mensaje de éxito con SweetAlert2
        if (response == true) {
          Swal.fire({
            position: 'top-end',
            icon: 'success',
            title: 'Tiempo guardado correctamente',
            showConfirmButton: false,
            timer: 1500
          });
        }

        //Borrar los datos del localStorage después de 1 segundos
        setTimeout(function () {
          localStorage.removeItem('idUsuario2');
          localStorage.removeItem('lastTime3');
          localStorage.removeItem('startTime2');
          localStorage.removeItem('id_orden');

          //localstorage de Tiempo traslado
          localStorage.removeItem('buttonState');
          localStorage.removeItem('shouldHideElements');
          localStorage.removeItem('buttonState2');
          localStorage.removeItem('lastTime2');

          location.reload();
        }, 1000);
      },
      error: function (xhr, status, error) {
        // Manejar el error si ocurre alguno
        console.log(error);
      }
    });
  });
});
