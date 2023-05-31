$(document).ready(function() {
    $("#filtro").on("click", function(e) {
      e.preventDefault();
  
      var f_ingreso = $('input[name=fecha_ingreso]').val();
      var f_fin = $('input[name=fechaFin]').val();
      console.log(f_ingreso + ' ' + f_fin);
  
      if (f_ingreso != "" && f_fin != "") {
        $.post("../controller/dashboard/filtroFecha.php", { f_ingreso, f_fin }, function(data) {
          $(".resultadoFiltro").html(data);
        });
      } else {
        $(".resultadoFiltro").empty(); // Vaciar la tabla si las fechas están vacías
      }
    });
  });
  