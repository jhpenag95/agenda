<?php
include '../../conexion.php';

// Obtén las fechas filtradas del $_POST
$fechaInit = date("Y-m-d", strtotime($_POST['fecha_ingreso']));
$fechaFin = date("Y-m-d", strtotime($_POST['fechaFin']));


// Realiza la consulta SQL con las fechas filtradas
$sql = "SELECT ord.N_orden, u1.nombre AS nombre_cableador, u2.nombre AS nombre_fusionador, ord.direccion, z.nombre_zona, ord.descripcion, ord.fecha_registro, tt.tiempo_tarea, trd.tiempo
        FROM ordenes ord
        INNER JOIN usuarios u1 ON u1.id_usuario = ord.id_usuario_cableador
        INNER JOIN usuarios u2 ON u2.id_usuario = ord.id_usuario_fusionador 
        INNER JOIN zonas z ON z.id_zona = ord.id_zona
        INNER JOIN tiempos_tarea tt ON tt.id_orden = ord.id_orden
        INNER JOIN tiempos_traslado trd ON trd.id_orden = ord.id_orden
        WHERE DATE(fecha_registro) BETWEEN '$fechaInit' AND '$fechaFin'
        GROUP BY ord.N_orden
        ORDER BY ord.N_orden ASC";


$query = mysqli_query($conexion, $sql);

// Genera el HTML de la tabla con los resultados filtrados
if ($query && mysqli_num_rows($query) > 0) {
  echo '<table class="table table-striped table-hover" id="tabla">';
  echo '<thead>';
  echo '<tr>';
  echo '<th>No. orden</th>';
  echo '<th>Cableador</th>';
  echo '<th>Fusionador</th>';
  echo '<th>Dirección</th>';
  echo '<th>Zona</th>';
  echo '<th>Descripción</th>';
  echo '<th>Hora de solicitud</th>';
  echo '<th>Tiempo traslado</th>';
  echo '<th>Tiempo de tarea</th>';
  echo '</tr>';
  echo '</thead>';
  echo '<tbody>';
  
  while ($data = mysqli_fetch_array($query)) {
    echo '<tr>';
    echo '<td>'.$data['N_orden'].'</td>';
    echo '<td>'.$data['nombre_cableador'].'</td>';
    echo '<td>'.$data['nombre_fusionador'].'</td>';
    echo '<td>'.$data['direccion'].'</td>';
    echo '<td>'.$data['nombre_zona'].'</td>';
    echo '<td>'.$data['descripcion'].'</td>';
    echo '<td>'.$data['fecha_registro'].'</td>';
    echo '<td>'.$data['tiempo_tarea'].'</td>';
    echo '<td>'.$data['tiempo'].'</td>';
    echo '</tr>';
  }

  echo '</tbody>';
  echo '</table>';
} else {
  echo '<p>No se encontraron resultados</p>';
}

// ...
?>
