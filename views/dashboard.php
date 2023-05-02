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
    <title>Dashboard | Agenda</title>

  

    <!-- Estilos CSS -->
    <?php include "../views/styles.php" ?>
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
                    <form>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="fechaInicio" class="form-label">Fecha de inicio:</label>
                                <input type="date" class="form-control" id="fechaInicio" />
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="fechaFin" class="form-label">Fecha de fin:</label>
                                <input type="date" class="form-control" id="fechaFin" />
                            </div>
                            <div class="col-md-2 mb-1 d-flex flex-column justify-content-end align-items-center">
                                <button type="submit" class="btn btn-primary mb-2 w-100">
                                    <i class="bi bi-search"></i>
                                </button>
                            </div>
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Buscar orden..." />
                                <button class="btn btn-primary" type="button">
                                    Buscar
                                </button>
                            </div>
                        </div>
                    </form>
                    <div class="col-md-4 mb-3 d-flex justify-content-start">
                        <button type="button" class="btn btn-success w-50">
                            Exportar a Excel
                        </button>
                    </div>
                </div>
                <!--Inicio tabla de solicitudes-->
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>No. orden</th>
                                <th>Cableador</th>
                                <th>Fusionador</th>
                                <th>Dirección</th>
                                <th>Zona</th>
                                <th>Dirección zona</th>
                                <th>Hora de solicitud</th>
                                <th>Tiempo traslado</th>
                                <th>Tiempo de tarea</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>MDS-123466</td>
                                <td>Jose Antonio Andujar</td>
                                <td>Aleix Chen</td>
                                <td>Calle 12 # 24 34</td>
                                <td>Fontibón</td>
                                <td>Calle 12 # 24 34</td>
                                <td>10/04/2023 12:09</td>
                                <td>27/03/2023 8:56 am</td>
                                <td>27/03/2023 8:56 am</td>
                            </tr>
                            <tr>
                                <td>MDS-123466</td>
                                <td>Jose Antonio Andujar</td>
                                <td>Aleix Chen</td>
                                <td>Calle 12 # 24 34</td>
                                <td>Fontibón</td>
                                <td>Calle 12 # 24 34</td>
                                <td>10/04/2023 12:09</td>
                                <td>27/03/2023 8:56 am</td>
                                <td>27/03/2023 8:56 am</td>
                            </tr>
                            <tr>
                                <td>MDS-123466</td>
                                <td>Jose Antonio Andujar</td>
                                <td>Aleix Chen</td>
                                <td>Calle 12 # 24 34</td>
                                <td>Fontibón</td>
                                <td>Calle 12 # 24 34</td>
                                <td>10/04/2023 12:09</td>
                                <td>27/03/2023 8:56 am</td>
                                <td>27/03/2023 8:56 am</td>
                            </tr>
                            <tr>
                                <td>MDS-123466</td>
                                <td>Jose Antonio Andujar</td>
                                <td>Aleix Chen</td>
                                <td>Calle 12 # 24 34</td>
                                <td>Fontibón</td>
                                <td>Calle 12 # 24 34</td>
                                <td>10/04/2023 12:09</td>
                                <td>27/03/2023 8:56 am</td>
                                <td>27/03/2023 8:56 am</td>
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

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</body>

</html>