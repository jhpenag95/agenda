<?php
//crea o reanuda una sesión existente, lo que permite al servidor almacenar información específica del usuario en la sesión
session_start();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agenda | Fusionador</title>



</head>

<body>
    <!--Inicio barra de gavegación-->
    <?php include "header.php" ?>
    <!--Fin barra de gavegación-->

    <main>
        <!--Inicio tabla de solicitudes-->
        <section>
            <div class="container my-5">
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
                                <th>Tiempo traslado</th>
                                <th>Tiempo tarea</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>MDS-123466</td>
                                <td>Jose Antonio Andujar</td>
                                <td>Aleix Chen</td>
                                <td>Calle 12 # 24 34</td>
                                <td>10/04/2023 12:09</td>
                                <td>
                                    <div class="contBtnTiempos">
                                        <button class="btn-desplazamiento">iniciar desplazamiento</button>
                                        <button class="btn-traslado">Iniciar Traslado</button>
                                    </div>
                                </td>
                                <td>10/04/2023 12:09</td>
                                <td>10/04/2023 12:09</td>
                            </tr>
                            <tr>
                                <td>MDS-123466</td>
                                <td>Jose Antonio Andujar</td>
                                <td>Aleix Chen</td>
                                <td>Calle 12 # 24 34</td>
                                <td>10/04/2023 12:09</td>
                                <td>
                                    <div class="contBtnTiempos">
                                        <button class="btn-desplazamiento">iniciar desplazamiento</button>
                                        <button class="btn-traslado">Iniciar Traslado</button>
                                    </div>
                                </td>
                                <td>10/04/2023 12:09</td>
                                <td>10/04/2023 12:09</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="my-4">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <nav aria-label="Paginación">
                                <ul class="pagination justify-content-end">
                                    <li class="page-item disabled">
                                        <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Anterior</a>
                                    </li>
                                    <li class="page-item active" aria-current="page">
                                        <a class="page-link" href="#">1</a>
                                    </li>
                                    <li class="page-item">
                                        <a class="page-link" href="#">2</a>
                                    </li>
                                    <li class="page-item">
                                        <a class="page-link" href="#">3</a>
                                    </li>
                                    <li class="page-item">
                                        <a class="page-link" href="#">Siguiente</a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--fin tabla de solicitudes-->
    </main>




</body>

</html>