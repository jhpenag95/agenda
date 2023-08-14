// Supongamos que tienes un evento click en el botón para cambiar su estado
$('.btn-desplazamiento').click(function () {

  var textoDelBoton = this.textContent;
  console.log("Texto del botón:", textoDelBoton);
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
