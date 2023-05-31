<?php
//crea o reanuda una sesión existente, lo que permite al servidor almacenar información específica del usuario en la sesión
session_start();

require_once  '../conexion.php';
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agenda | Fusionador</title>

    <link rel="stylesheet" href="../style/agendaFusionador/agendaFusionador.css">
    <link rel="stylesheet" href="../style/global.css">


</head>

<body>
    <!--Inicio barra de gavegación-->
    <?php include "header.php" ?>
    <!--Fin barra de gavegación-->

    <main>
        <!--Inicio tabla de solicitudes-->
        <section>
            <div class="container my-5 cont-table">
                <h1 class="mb-4">Ordenes asignadas</h1>

                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>No. Orden</th>
                                <th>Cableador</th>
                                <th>Fusionador</th>
                                <th>Dirección</th>
                                <th>Hora de solicitud</th>
                                <th>Acciones</th>
                                <th>Acciones</th>
                                <th>Tiempo traslado</th>
                                <th>Tiempo tarea</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php

                            //Se inicia el Paginador
                            $sql_register = mysqli_query($conexion, "SELECT COUNT(*) as total_registros FROM zonas WHERE estado = 1");
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


                            //consultar usuario
                            if ($_SESSION['idUser'] == 1) {
                                // Consulta para usuarios fusionadores
                                $query = "SELECT ord.id_orden, ord.N_orden,u2.id_usuario AS id_fusionador, u1.nombre AS nombre_cableador, u2.nombre AS nombre_fusionador, ord.descripcion, ord.fecha_registro, z.nombre_zona
                                          FROM ordenes ord
                                          INNER JOIN usuarios u1 ON u1.id_usuario = ord.id_usuario_cableador
                                          INNER JOIN usuarios u2 ON u2.id_usuario = ord.id_usuario_fusionador
                                          INNER JOIN zonas z ON z.id_zona = ord.id_zona
                                          WHERE ord.estado_orden = 1
                                          ORDER BY ord.id_orden ASC LIMIT $desde,$por_pagina";
                            } elseif ($_SESSION['idUser'] != 1) {
                                // Mostrar solo las órdenes asignadas al usuario fusionador
                                $query = "SELECT ord.id_orden, ord.N_orden, u1.nombre AS nombre_cableador, u2.nombre AS nombre_fusionador, ord.descripcion, ord.fecha_registro, z.nombre_zona
                                          FROM ordenes ord
                                          INNER JOIN usuarios u1 ON u1.id_usuario = ord.id_usuario_cableador
                                          INNER JOIN usuarios u2 ON u2.id_usuario = ord.id_usuario_fusionador
                                          INNER JOIN zonas z ON z.id_zona = ord.id_zona
                                          WHERE ord.estado_orden = 1 AND u2.id_usuario = " . $_SESSION['idUser'] . "
                                          ORDER BY ord.id_orden ASC
                                          LIMIT $desde, $por_pagina";
                            }


                            $result = mysqli_query($conexion, $query);
                            if ($result && mysqli_num_rows($result) > 0) {
                                while ($data = mysqli_fetch_array($result)) {
                            ?>

                                    <tr>
                                        <input type="hidden" id="id_orden" value="<?php echo $data['id_orden']; ?>">
                                        <td><?php echo $data['N_orden']; ?></td>
                                        <td><?php echo $data['nombre_cableador']; ?></td>
                                        <td><?php echo $data['nombre_fusionador']; ?></td>
                                        <td class="descripcion-column"><?php echo  ucfirst(strtolower($data['descripcion'])); ?></td>
                                        <td><?php echo $data['fecha_registro']; ?></td>
                                        <td>
                                            <div class="contBtnTiempos">
                                                <button type="button" class="btn-desplazamiento" onclick="FbotonOn(this)" data-id="<?= $_SESSION['idUser']; ?>">Iniciar desplazamiento</button>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="contBtnTiempos">
                                                <button type="button" class="btn-tarea" onclick="BbotonOn(this)" data-id="<?= $_SESSION['idUser']; ?>">Iniciar Tarea</button>
                                            </div>
                                        </td>
                                        <td>
                                            <form action="#" method="post" class="form-btn">
                                                <span name="time" class="time" data-id="<?= $_SESSION['idUser']; ?>" id="iniciarCronometro_<?= $_SESSION['idUser']; ?>"></span>
                                                <button type="submit" class="guardar" data-id="<?= $_SESSION['idUser']; ?>" id="iniciarCronometro_<?= $_SESSION['idUser']; ?>">Guardar</button>
                                            </form>
                                        </td>
                                        <td id="tarea">
                                            <form action="#" class="form-btn" id="formTarea" method="post">
                                                <span name="timeTarea" class="timeTarea" data-id="<?= $_SESSION['idUser']; ?>" id="cronometroIniciar_<?= $_SESSION['idUser']; ?>"></span>
                                                <button type="submit" class="guardar2" data-id="<?= $_SESSION['idUser']; ?>" id="cronometroIniciar_<?= $_SESSION['idUser']; ?>">Guardar</button>
                                            </form>
                                        </td>
                                    </tr>
                            <?php
                                }
                            }
                            ?>

                        </tbody>
                    </table>
                    <!-- Alertas -->
                    <?php if (isset($_SESSION['success'])) : ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>¡Éxito!</strong> <?php echo $_SESSION['success']; ?>
                        </div>
                        <?php unset($_SESSION['success']); ?>
                    <?php endif; ?>

                    <?php if (isset($_SESSION['error'])) : ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>¡Error!</strong> <?php echo $_SESSION['error']; ?>
                        </div>
                        <?php unset($_SESSION['error']); ?>
                    <?php endif; ?>
                </div>


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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>


    <script src="../script/agendaFusionador/tiempo_Tarea/cronometro.js"></script>
    <script src="../script/agendaFusionador/tiempo_Tarea/peticionAjax_saveTime.js"></script>
    
    <script src="../script/agendaFusionador/tiempo_Traslado/cronometro.js"></script>
    <script src="../script/agendaFusionador/tiempo_Traslado/peticionAjax_saveTimeTraslado.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>





</body>

</html>