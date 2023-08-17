$(document).ready(function () {
  // Obtener todos los elementos con la clase "elemento"
  var elementos = document.querySelectorAll(".cronometro");

  // Iterar a través de los elementos y obtener los valores de data-orden
  elementos.forEach(function (elemento) {
    var valorDataOrden = elemento.getAttribute("data-orden");
    // Verificar si la clave existe en localStorage
    var valorLocalStorage = localStorage.getItem(valorDataOrden);

    if (valorLocalStorage !== null) {
      console.log("La clave existe en localStorage:", valorDataOrden);
      if (valorDataOrden === valorLocalStorage) {
        console.log("La clave existe en tabla:", valorDataOrden);
      } else {
        console.log("La clave "+valorDataOrden+" no coincide con valor en localStorage "+valorLocalStorage+".");
      }
    } else {
      console.log("La clave NO existe en localStorage:", valorDataOrden);
    }
  });
});
