<?php
session_start();

include '../conexion.php';


?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | Agenda</title>

    <!-- Estilos CSS -->
    <?php include "../views/styles.php" ?>
    <link rel="stylesheet" href="../style/dashboard/datosDahsboard.css">
    <link rel="stylesheet" href="../style/global.css">

</head>

<body>
    <!--Inicio barra de gavegación-->
    <?php include "header.php" ?>
    <!--Fin barra de gavegación-->
    <main>
        <!--Inicio contenedores datos informativos-->
        <section class="info">

            <div class="info-cont">
                <p class="info-cont__title">Técnicos</p>
                <span class="info-cont__cont">100</span>
            </div>
            <div class="info-cont">
                <p class="info-cont__title">Fusionadores</p>
                <span class="info-cont__cont">100</span>
            </div>
            <div class="info-cont">
                <p class="info-cont__title">Ordenes</p>
                <span class="info-cont__cont">100</span>
            </div>
        </section>
        <!--fin contenedores datos informativos-->


        <section>
            <div class="container my-5">
                <h1 class="mb-4">Tabla de solicitudes</h1>
                <div class="mb-4">
                    <!--Fromulario de busquedas-->
                    <form action="buscar_orden.php">
                        <div class="row">
                            <div class="col-md-5 mb-3">
                                <label for="fechaInicio" class="form-label">Fecha de inicio:</label>
                                <input type="date" class="form-control" name="fechaInicio" id="fechaInicio" />
                            </div>
                            <div class="col-md-5 mb-3">
                                <label for="fechaFin" class="form-label">Fecha de fin:</label>
                                <input type="date" class="form-control" name="fechaFin" id="fechaFin" />
                            </div>
                            <div class="col-md-2 mb-1 d-flex align-items-end">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="bi bi-search"></i>
                                </button>
                            </div>
                            <div class="col-md-12 mb-1 d-flex align-items-end">
                                <form action="buscar_orden.php" method="get">
                                    <div class="input-group">
                                        <input type="text" class="input-orden" name="busqueda" id="busqueda" placeholder="Buscar orden..." />
                                        <button class="btn btn-primary" type="button">
                                            Buscar
                                        </button>
                                    </div>
                                </form>
                            </div>
                    </form>
                </div>
                <!--Inicio tabla de solicitudes-->
                <div class="table-responsive mt-5">
                    <div class="col-md-4 mb-3 mt-3 d-flex justify-content-start">
                        <button type="button" class="btn btn-success w-50">
                            Exportar a Excel
                        </button>
                    </div>
                    <table class="table table-striped table-hover">
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
                            $sql_register = mysqli_query($conexion, "SELECT COUNT(*) as total_registros FROM ordenes");
                            $result_register = mysqli_fetch_array($sql_register);
                            $total_registro = $result_register['total_registros'];

                            /* Este código implementa la paginación para la lista de usuarios mostrada en la página. */
                            $por_pagina = 5;

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
                                        GROUP BY ord.N_orden
                                        ORDER BY ord.N_orden ASC
                                    LIMIT $desde, $por_pagina";

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
                            }
                            ?>
                        </tbody>

                    </table>
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

</body>

</html>