function limpiarLocalStorage() {
    // Limpia el localStorage
    localStorage.clear();
    console.log("LocalStorage limpiado a la hora indicada");
  }
  
  function programarLimpieza() {
    const ahora = new Date();
    const horaLimpieza = new Date(ahora.getFullYear(), ahora.getMonth(), ahora.getDate(), 18, 28, 0); // Cambia la hora y los minutos según tus necesidades (ejemplo: 18:00)
  
    // Calcula el tiempo hasta la próxima hora de limpieza
    let tiempoRestante = horaLimpieza - ahora;
  
    if (tiempoRestante < 0) {
      // Si ya ha pasado la hora de limpieza para hoy, ajusta el tiempo para el próximo día
      horaLimpieza.setDate(horaLimpieza.getDate() + 1);
      tiempoRestante = horaLimpieza - ahora;
    }
  
    // Configura el temporizador para la limpieza
    setTimeout(function () {
      limpiarLocalStorage();
      // Programa la siguiente limpieza para el próximo día
      programarLimpieza();
    }, tiempoRestante);
  }
  
  // Llama a la función para programar la primera limpieza cuando la página se carga
  programarLimpieza();
  