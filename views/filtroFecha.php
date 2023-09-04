<?php
session_start();

if (isset($_SESSION['rol']) && $_SESSION['rol'] != 1 && $_SESSION['rol'] != 2) {
  header(("location: dashboard.php"));
}

if ($_SESSION['rol'] == 3) {
  header(("location: crearOrden.php"));
}

if ($_SESSION['rol'] == 4) {
  header(("location: agendaFusionador.php"));
}

include_once '../conexion.php';


$fecha_de = '';
$fecha_a = '';
$where = ''; // Inicializar $where


if (isset($_REQUEST['fecha_ingreso']) || isset($_REQUEST['fecha_Fin'])) {
  if ($_REQUEST['fecha_ingreso'] == '' || $_REQUEST['fecha_Fin'] == '') {
    header("location: dashboard.php");
  }
}

if (!empty($_REQUEST['fecha_ingreso']) && !empty($_REQUEST['fecha_Fin'])) {

  $fecha_de = $_REQUEST['fecha_ingreso'];
  $fecha_a = $_REQUEST['fecha_Fin'];

  $buscar = '';

  if ($fecha_de > $fecha_a) {
    header("location: dashboard.php");
  } else if ($fecha_de == $fecha_a) {
    $where = "fecha_registro LIKE '$fecha_de%'";
    $buscar = "fecha_ingreso='$fecha_de&fecha_Fin=$fecha_a'";
  } else {
    $f_de = $fecha_de . '00:00:00';
    $f_a = $fecha_a . '23:59:59';
    $where = "fecha BETWEEN '$f_de' and '$f_a'";
    $buscar = "fecha_ingreso=$fecha_de&fecha_Fin=$fecha_a";
  }
}


?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Dashboard | Agenda</title>

  <!-- Estilos CSS -->
  <!-- Estilos CSS -->
  <?php include "../views/styles.php" ?>
  <link rel="stylesheet" href="../style/dashboard/datosDahsboard.css">
  <link rel="stylesheet" href="../style/global.css">

</head>

<body>
  <!--Inicio barra de gavegación-->
  <?php include "header.php"; ?>
  <!--Fin barra de gavegación-->
  <main>
    <section class="container sectionTable pt-4 pb-4">
      <div class="container my-5">
        <h1 class="mb-4">Tabla de solicitudes</h1>
        <div class="col-md-12 text-center mt-5">
          <form action="filtroFecha.php" accept-charset="utf-8">
            <div class="row">
              <div class="col">
                <input type="date" name="fecha_ingreso" class="form-control" placeholder="Fecha de Inicio" value="<?php echo $fecha_de; ?>" required>
              </div>
              <div class="col">
                <input type="date" name="fecha_Fin" class="form-control" placeholder="Fecha Final" value="<?php echo $fecha_a; ?>" required>
              </div>
           

              <div class="col">
                <button type="submit" class="btn btn-dark mb-2" id="filtro">Filtrar</button>
              </div>
              <?php
              $por_pagina = isset($_GET['por_pagina']) ? $_GET['por_pagina'] : 10;
              ?>
              <div class="col">
              <form action="" method="get" class="formCont">
                        <label for="por_pagina">Mostrar:</label>
                        <select name="por_pagina" id="por_pagina" class="formCont-select">
                            <option value="10" <?php if ($por_pagina == 10) echo 'selected'; ?>>10 Registros</option>
                            <option value="20" <?php if ($por_pagina == 20) echo 'selected'; ?>>20 Registros</option>
                            <option value="50" <?php if ($por_pagina == 50) echo 'selected'; ?>>50 Registros</option>
                            <option value="80" <?php if ($por_pagina == 80) echo 'selected'; ?>>80 Registros</option>
                            <option value="100" <?php if ($por_pagina == 100) echo 'selected'; ?>>100 Registros</option>
                            <option value="150" <?php if ($por_pagina == 150) echo 'selected'; ?>>150 Registros</option>
                            <option value="200" <?php if ($por_pagina == 200) echo 'selected'; ?>>200 Registros</option>
                        </select>
                        <button type="submit" class="formCont-btn">Aplicar</button>
                    </form>
              </div>
            </div>
          </form>
        </div>
      </div>
      <!--Inicio tabla de solicitudes-->
      <div class="container">
        <div class="contform">
          <a href="dashboard.php" class="btn btn-success">¿Buscar por Orden o Zona?..</a>
        </div>
        <div class="table-responsive mt-5">
          <div class="col-md-4 mb-3 mt-3 d-flex justify-content-start">
            <button type="button" class="btn btn-success w-50" onclick="exportTable()">
              Exportar a Excel
            </button>
          </div>
          <div class="col-md-12 text-center mt-5">
            <span id="loaderFiltro"> </span>
          </div>
          <!-- Agrega el select para la cantidad de registros por página -->
          </form>
          <div class="resultadoFiltro">
            <table class="table table-striped table-hover" id="tabla">
              <thead>
                <tr>
                  <th>No. orden</th>
                  <th>Cableador</th>
                  <th>Fusionador</th>
                  <th>Dirección</th>
                  <th>Zona</th>
                  <th>Descripción</th>
                  <th>Hora de solicitud</th>
                  <th>Tiempo traslado</th>
                  <th>Tiempo de tarea</th>
                </tr>
              </thead>
              <tbody>
                <?php
                //Se inicia el Paginador
                $sql_register = mysqli_query($conexion, "SELECT COUNT(*) as total_registros FROM ordenes WHERE $where");
                $result_register = mysqli_fetch_array($sql_register);
                $total_registro = $result_register['total_registros'];

                /* Este código implementa la paginación para la lista de usuarios mostrada en la página. */
                $por_pagina = isset($_GET['por_pagina']) ? $_GET['por_pagina'] : 10;

                if (empty($_GET['pagina'])) {
                  $pagina = 1;
                } else {
                  $pagina = $_GET['pagina'];
                }

                $desde = ($pagina - 1) * $por_pagina;
                $total_paginas = ceil($total_registro / $por_pagina);

                $query = "SELECT ord.N_orden, u1.nombre AS nombre_cableador, u2.nombre AS nombre_fusionador, ord.direccion, z.nombre_zona, ord.descripcion, ord.fecha_registro, tt.tiempo_tarea, trd.tiempo
                                            FROM ordenes ord
                                            INNER JOIN usuarios u1 ON u1.id_usuario = ord.id_usuario_cableador
                                            INNER JOIN usuarios u2 ON u2.id_usuario = ord.id_usuario_fusionador 
                                            INNER JOIN zonas z ON z.id_zona = ord.id_zona
                                            INNER JOIN tiempos_tarea tt ON tt.id_orden = ord.id_orden
                                            INNER JOIN tiempos_traslado trd ON trd.id_orden = ord.id_orden
                                            WHERE $where
                                            GROUP BY ord.N_orden
                                            ORDER BY ord.fecha_registro DESC LIMIT $desde, $por_pagina";

                $result = mysqli_query($conexion, $query);

                if ($result && mysqli_num_rows($result) > 0) {
                  while ($data = mysqli_fetch_array($result)) {
                ?>
                    <tr>
                      <td><?php echo $data['N_orden']; ?></td>
                      <td><?php echo $data['nombre_cableador']; ?></td>
                      <td><?php echo $data['nombre_fusionador']; ?></td>
                      <td><?php echo $data['direccion']; ?></td>
                      <td><?php echo $data['nombre_zona']; ?></td>
                      <td><?php echo $data['descripcion']; ?></td>
                      <td><?php echo $data['fecha_registro']; ?></td>
                      <td><?php echo $data['tiempo_tarea']; ?></td>
                      <td><?php echo $data['tiempo']; ?></td>
                    </tr>
                  <?php
                  }
                } else {
                  ?>
                  <tr>
                    <td colspan="9" class="text-center">No se encontraron registros.</td>
                  </tr>
                <?php
                }
                ?>
              </tbody>

            </table>
          </div>
        </div>
      </div>
      <!--===============Páginador==============-->
      <div class="pagination-container">
        <ul class="pagination">
          <li class="pagination-item <?php if ($pagina <= 1) {
                                        echo 'disabled';
                                      } ?>">
            <a href="<?php if ($pagina <= 1) {
                        echo '#';
                      } else {
                        echo '?pagina=' . ($pagina - 1);
                      } ?>">Anterior</a>
          </li>
          <?php for ($i = 1; $i <= $total_paginas; $i++) { ?>
            <li class="pagination-item <?php if ($pagina == $i) {
                                          echo 'active';
                                        } ?>">
              <a href="<?php echo '?pagina=' . $i; ?>"><?php echo $i; ?></a>
            </li>
          <?php } ?>
          <li class="pagination-item <?php if ($pagina >= $total_paginas) {
                                        echo 'disabled';
                                      } ?>">
            <a href="<?php if ($pagina >= $total_paginas) {
                        echo '#';
                      } else {
                        echo '?pagina=' . ($pagina + 1);
                      } ?>">Siguiente</a>
          </li>
        </ul>
      </div>
      </div>
    </section>
    <!--fin tabla de solicitudes-->
  </main>

  <!-- Option 1: Bootstrap Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>

  <script src="../script/dashboard/exportarTabla.js"></script>

</body>

</html>