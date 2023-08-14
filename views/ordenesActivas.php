<?php
session_start();

include '../conexion.php';


if (isset($_SESSION['rol']) && $_SESSION['rol'] != 1 && $_SESSION['rol'] != 2) {
    header("Location: agendaFusionador.php");
    exit();
}

if ($_SESSION['rol'] == 3) {
    header("Location: crearOrden.php");
    exit();
}

if ($_SESSION['rol'] == 4) {
    header("Location: agendaFusionador.php");
    exit();
}

?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../assets/iconos/logo.ico" />

    <title>Ordenes activas</title>

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
        <!--fin contenedores datos informativos-->
        <section class="container sectionTable pt-4 pb-4">
            <!--Inicio tabla de solicitudes-->
            <div class="container">

                <div class="table-responsive mt-5">
                    <div class="col-md-4 mb-3 mt-3 d-flex justify-content-start">
                        <button type="button" class="btn btn-success w-50" onclick="exportTable()">
                            Exportar a Excel
                        </button>
                    </div>
                    <div class="col-md-12 text-center mt-5">
                        <span id="loaderFiltro"> </span>
                    </div>
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
                                    <th>Tiempo en proceso</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                //Se inicia el Paginador
                                $sql_register = mysqli_query($conexion, "SELECT COUNT(*) as total_registros 
                                                                            FROM ordenes");

                                $result_register = mysqli_fetch_array($sql_register);
                                $total_registro = $result_register['total_registros'];
                                mysqli_free_result($sql_register);


                                /* Este código implementa la paginación para la lista de usuarios mostrada en la página.*/
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
                                            <td><span class="cronometro" data-inicio="<?php echo $data['fecha_registro']; ?>"></span></td>
                                        </tr>
                                <?php
                                    }
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
        </section>
        <!--fin tabla de solicitudes-->
    </main>

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>

    <script src="../script/dashboard/exportarTabla.js"></script>
    <script src="../script/dashboard/validacionFormCambiarPass.js"></script>

    <script>
        $(document).ready(function() {
            function actualizarCronometros() {
                $('.cronometro').each(function() {
                    const inicio = new Date($(this).data('inicio')).getTime();
                    const ahora = new Date().getTime();
                    const diferencia = ahora - inicio;

                    const segundos = Math.floor((diferencia % (1000 * 60)) / 1000);
                    const minutos = Math.floor((diferencia % (1000 * 60 * 60)) / (1000 * 60));
                    const horas = Math.floor(diferencia / (1000 * 60 * 60));

                    const tiempoFormateado = horas + ':' + minutos + ':' + segundos;

                    $(this).text(tiempoFormateado);
                });
            }

            setInterval(actualizarCronometros, 1000); // Actualiza cada segundo
        });
    </script>


</body>

</html>