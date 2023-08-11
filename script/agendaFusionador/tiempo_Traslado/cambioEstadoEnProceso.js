// Supongamos que tienes un evento click en el botón para cambiar su estado
$('.btn-desplazamiento').click(function () {
  // Cambiar el estado del botón
  this.textContent = 'En desplazamiento';

  // Obtener el texto del botón
  var textoDelBoton = this.textContent;

  if (textoDelBoton == 'En desplazamiento') {
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
  }
});
