// Función para calcular el lapso de tiempo
function calcularLapso(horaInicio, horaActual) {
  const inicio = horaInicio.split(":");
  const actual = horaActual.split(":");

  const inicioHoras = parseInt(inicio[0]);
  const inicioMinutos = parseInt(inicio[1]);
  const inicioSegundos = parseInt(inicio[2]);

  const actualHoras = parseInt(actual[0]);
  const actualMinutos = parseInt(actual[1]);
  const actualSegundos = parseInt(actual[2]);

  let horas = actualHoras - inicioHoras;
  let minutos = actualMinutos - inicioMinutos;
  let segundos = actualSegundos - inicioSegundos;

  if (segundos < 0) {
      segundos += 60;
      minutos--;
  }

  if (minutos < 0) {
      minutos += 60;
      horas--;
  }

  if (horas < 0) {
      horas += 24; // Se asume que el lapso no será mayor a 24 horas
  }

  return `${horas.toString().padStart(2, '0')}:${minutos.toString().padStart(2, '0')}:${segundos.toString().padStart(2, '0')}`;
}

// Función para actualizar el cronómetro
function actualizarCronometro() {
  const cronometros = document.querySelectorAll(".cronometro");
  cronometros.forEach(cronometro => {
      const horaInicio = cronometro.getAttribute("data-inicio");
      const horaActual = new Date().toLocaleTimeString('en-US', { hour12: false });

      const lapso = calcularLapso(horaInicio, horaActual);

      cronometro.textContent = lapso;
  });
}

// Actualiza el cronómetro cada segundo
setInterval(actualizarCronometro, 1000);
