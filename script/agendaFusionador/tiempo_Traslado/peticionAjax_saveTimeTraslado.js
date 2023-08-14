$(document).ready(function () {
  // Verificar si se debe ocultar los elementos al cargar la página
  var shouldHideElements = localStorage.getItem('shouldHideElements');
  if (shouldHideElements === 'true') {
    $('.btn-desplazamiento').css("display", "none");
    $('.time').css("display", "none");
    $('.guardar').css("display", "none");
  }

  $('.guardar').click(function (e) {
    e.preventDefault();

    // Obtener los datos del localStorage
    var idUsuario1 = localStorage.getItem('idUsuario');
    var startTime1 = localStorage.getItem('startTime');
    var nombreDeLaClave1 = localStorage.getItem("id_orden");

    // Obtener el tiempo actual
    //var currentTime = Date.now();
    var currentTime = localStorage.getItem('lastTime4');

    // Calcular el tiempo transcurrido en milisegundos
    var elapsedTime1 = currentTime - parseInt(startTime1);

    // Convertir el tiempo transcurrido a formato HH:MM:SS
    var tiempoFormatted1 = new Date(elapsedTime1).toISOString().substr(11, 8);

    // Crear un objeto de datos para enviar al servidor
    var data = {
      idUsuario1: idUsuario1,
      lastTime1: tiempoFormatted1,
      nombreDeLaClave1: nombreDeLaClave1
    };

    // Enviar la solicitud AJAX al servidor
    $.ajax({
      url: '../controller/capturar_tiempoTraslado.php', // Ruta a tu archivo PHP que manejará la solicitud
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
          setTimeout(function () {
            localStorage.removeItem('idUsuario');
            localStorage.removeItem('lastTime4');
            localStorage.removeItem('startTime');
            localStorage.removeItem('id_orden');
          }, 2000);

          // Almacenar el indicador para ocultar los elementos en el localStorage
          localStorage.setItem('shouldHideElements', 'true');

          // Ocultar los elementos inmediatamente
          $('.btn-desplazamiento').css("display", "none");
          $('.time').css("display", "none");
          $('.guardar').css("display", "none");
        } 
      },
      error: function (xhr, status, error) {
        // Manejar el error si ocurre alguno
        console.log(error);
      }
    });
  });
});
