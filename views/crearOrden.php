<?php
//crea o reanuda una sesión existente, lo que permite al servidor almacenar información específica del usuario en la sesión
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orden</title>

    <!-- Estilos CSS -->
    <?php include "../views/styles.php" ?>

</head>

<body>
    <!--Inicio barra de gavegación-->
    <?php include "header.php" ?>
    <!--Fin barra de gavegación-->

    <main>
        <section>
            <h1>Crear Orden</h1>
            <form>
                <label for="orden">No. de Orden:</label>
                <input type="text" id="orden" name="orden" placeholder="Ingrese el número de orden">
                <label for="direccion">Dirección:</label>
                <input type="text" id="direccion" name="direccion" placeholder="Ingrese la dirección">
                <div class="contenedor-usuario">
                    <div class="contenedor-zona">
                        <label for="zona" class="label-zona">Zona:</label>
                        <div class="opciones-zona">
                            <select name="zona" id="zona" class="select-zona">
                                <option value="" disabled selected>Selecciona una zona</option>
                                <option value="zona1">Zona 1</option>
                                <option value="zona2">Zona 2</option>
                                <option value="zona3">Zona 3</option>
                            </select>
                        </div>
                    </div>
                </div>
                <button class="button" type="submit">crear</button>
            </form>
        </section>
        <!--Inicio tabla de solicitudes-->
        <section>
            <div class="container my-5">
                <h1 class="mb-4">Listado de ordenes</h1>

                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>No. orden</th>
                                <th>Cableador</th>
                                <th>Dirección</th>
                                <th>Zona</th>
                                <th>Fusionador</th>
                                <th>Dirección zona</th>
                                <th>Hora de solicitud</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>MDS-123466</td>
                                <td>Jose Antonio Andujar</td>
                                <td>Calle 12 # 24 34</td>
                                <td>Fontibón</td>
                                <td>Aleix Chen</td>
                                <td>Calle 12 # 24 34</td>
                                <td>10/04/2023 12:09</td>
                                <td>Anular</td>
                            </tr>
                            <tr>
                                <td>MDS-123466</td>
                                <td>Jose Antonio Andujar</td>
                                <td>Calle 12 # 24 34</td>
                                <td>Fontibón</td>
                                <td>Aleix Chen</td>
                                <td>Calle 12 # 24 34</td>
                                <td>10/04/2023 12:09</td>
                                <td>Anular</td>
                            </tr>
                            <tr>
                                <td>MDS-123466</td>
                                <td>Jose Antonio Andujar</td>
                                <td>Calle 12 # 24 34</td>
                                <td>Fontibón</td>
                                <td>Aleix Chen</td>
                                <td>Calle 12 # 24 34</td>
                                <td>10/04/2023 12:09</td>
                                <td>Anular</td>
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