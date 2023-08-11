$(document).ready(function () {
  // Verificar si se debe ocultar los elementos al cargar la pgina
  var shouldHideElements = localStorage.getItem('shouldHideElements');
  if (shouldHideElements === 'true') {
    $('.btn-desplazamiento').css("display", "none");
    $('.time').css("display", "none");
    $('.guardar2').css("display", "none");
  }

  $('.guardar2').click(function (e) {
    e.preventDefault();

    // Obtener los datos del localStorage
    var idUsuario2 = localStorage.getItem('idUsuario2');
    var startTime2 = localStorage.getItem('startTime2');
    var nombreDeLaClave2 = localStorage.getItem("id_orden");

    // Obtener el tiempo actual
    //var currentTime = Date.now();
    var currentTime = localStorage.getItem('lastTime2');

    // Calcular el tiempo transcurrido en milisegundos
    var elapsedTime2 = currentTime - parseInt(startTime2);

    // Convertir el tiempo transcurrido a formato HH:MM:SS
    var tiempoFormatted2 = new Date(elapsedTime2).toISOString().substr(11, 8);

    // Crear un objeto de datos para enviar al servidor
    var data = {
      idUsuario2: idUsuario2,
      lastTime2: tiempoFormatted2,
      nombreDeLaClave2: nombreDeLaClave2
    };

    // Enviar la solicitud AJAX al servidor
    $.ajax({
      url: '../controller/capturar_tiempoTarea.php', // Ruta a tu archivo PHP que manejará la solicitud
      type: 'POST',
      data: data,
      success: function (response) {
        // Mostrar el mensaje de éxito con SweetAlert2
        if (response) {
          //console.log("Datos guardados");
          Swal.fire({
            title: "Tiempo guardado correctamente",
            icon: "success",
            confirmButtonText: "Aceptar"
          });
          //Borrar los datos del localStorage después de 2 segundos
          //Borrar los datos del localStorage despus de 1 segundos
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
        }
      },
      error: function (xhr, status, error) {
        // Manejar el error si ocurre alguno
        console.log(error);
      }
    });
  });
});
