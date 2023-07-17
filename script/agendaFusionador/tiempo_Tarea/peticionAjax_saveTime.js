$(document).ready(function () {
  $('.guardar2').click(function (e) {
    e.preventDefault();

    // Obtener los datos del localStorage
    var idUsuario = localStorage.getItem('idUsuario2');
    var startTime = localStorage.getItem('startTime2');
    var nombreDeLaClave = localStorage.getItem("id_orden");

    // Obtener el tiempo actual
    var currentTime = Date.now();

    // Calcular el tiempo transcurrido en milisegundos
    var elapsedTime = currentTime - parseInt(startTime);

    // Convertir el tiempo transcurrido a formato HH:MM:SS
    var tiempoFormatted = new Date(elapsedTime).toISOString().substr(11, 8);
    console.log(tiempoFormatted);

    // Crear un objeto de datos para enviar al servidor
    var data = {
      idUsuario2: idUsuario,
      lastTime2: tiempoFormatted,
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
          // Swal.fire({
          //   position: 'top-end',
          //   icon: 'success',
          //   title: 'Tiempo guardado correctamente',
          //   showConfirmButton: false,
          //   timer: 1500
          // });

          Swal.fire({
            title: "Tiempo guardado correctamente",
            text: response,
            icon: "success",
            confirmButtonText: "Aceptar"
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
