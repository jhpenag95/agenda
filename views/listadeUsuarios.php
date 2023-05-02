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
    <title>Lista | usuarios</title>
    <!-- Estilos CSS -->
    <?php include "../views/styles.php" ?>

</head>

<body>
    <!--Inicio barra de gavegación-->
    <?php include "header.php" ?>
    <!--Fin barra de gavegación-->
    <main>
        <!--Inicio tabla de solicitudes-->
        <section>
            <div class="container my-5">
                <h1 class="mb-4">Listado de usuarios</h1>

                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Usuario</th>
                                <th>Rol</th>
                                <th>Teléfono</th>
                                <th>Zona</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Jose Antonio Andujar</td>
                                <td>Cableador</td>
                                <td>1234512345</td>
                                <td>Fontibón</td>
                                <td>Disponible</td>
                                <td>
                                    <button class="btn btn-success"><i class="bi bi-pencil-square"></i></button>
                                    <button class="btn btn-danger"><i class="bi bi-trash-fill"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td>Jose Antonio Andujar</td>
                                <td>Cableador</td>
                                <td>1234512345</td>
                                <td>Fontibón</td>
                                <td>ocupado</td>
                                <td>
                                    <button class="btn btn-success"><i class="bi bi-pencil-square"></i></button>
                                    <button class="btn btn-danger"><i class="bi bi-trash-fill"></i></button>
                                </td>
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