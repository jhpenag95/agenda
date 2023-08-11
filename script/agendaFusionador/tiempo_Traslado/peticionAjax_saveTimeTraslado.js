$(document).ready(function () {
  // Verificar si se deben ocultar los elementos al cargar la página
  const shouldHideElements = localStorage.getItem('shouldHideElements');
  if (shouldHideElements === 'true') {
    $('.btn-desplazamiento, .time, .guardar').css("display", "none");
  }
});

$('.guardar').click(function (e) {
  e.preventDefault();

  const idUsuario1 = localStorage.getItem('idUsuario');
  const startTime1 = localStorage.getItem('startTime');
  const nombreDeLaClave1 = localStorage.getItem("id_orden");
  const currentTime = localStorage.getItem('lastTime4');
  const elapsedTime1 = currentTime - parseInt(startTime1);
  const tiempoFormatted1 = new Date(elapsedTime1).toISOString().substr(11, 8);

  const data = {
    idUsuario1: idUsuario1,
    lastTime1: tiempoFormatted1,
    nombreDeLaClave1: nombreDeLaClave1
  };

  $.ajax({
    url: '../controller/capturar_tiempoTraslado.php',
    type: 'POST',
    data: data,
    success: function (response) {
      if (response) {
        Swal.fire({
          title: "Tiempo guardado correctamente",
          icon: "success",
          confirmButtonText: "Aceptar"
        });
        setTimeout(function () {
          localStorage.removeItem('idUsuario');
          localStorage.removeItem('lastTime4');
          localStorage.removeItem('startTime');
          localStorage.removeItem('id_orden');
        }, 2000);

        localStorage.setItem('shouldHideElements', 'true');
        $('.btn-desplazamiento, .time, .guardar').css("display", "none");
      }
    },
    error: function (xhr, status, error) {
      console.log("Error en la solicitud AJAX:", error);
    }
  });
});
