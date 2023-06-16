<?php
//crea o reanuda una sesión existente, lo que permite al servidor almacenar información específica del usuario en la sesión
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


require_once  '../conexion.php';

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../assets/iconos/logo.ico" />
    
    <title>Lista | zonas</title>
    <!-- Estilos CSS -->
    <?php include "../views/styles.php"; ?>
    <link rel="stylesheet" href="../style/lista_zonas/listaZonas.css">
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
                <h1 class="mb-5">Listado de zonas</h1>
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre zona</th>
                                <th>Acciones</th>
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
                            $query = "SELECT z.id_zona, z.nombre_zona FROM zonas z
                                                    WHERE z.estado = 1 ORDER BY z.nombre_zona ASC LIMIT $desde,$por_pagina";

                            $result = mysqli_query($conexion, $query);
                            if ($result && mysqli_num_rows($result) > 0) {
                                while ($data = mysqli_fetch_array($result)) {
                            ?>
                                    <tr>
                                        <td><?php echo $data['id_zona']; ?></td>
                                        <td><?php echo $data['nombre_zona']; ?></td>
                                        <td>
                                            <a href="editar_zona?id=<?php echo base64_encode($data['id_zona']); ?>" class="btn btn-success btn-editar"><i class="bi bi-pencil-square"></i></a>

                                            <?php
                                            if (isset($_SESSION['rol']) && $_SESSION['rol'] == 1) {
                                            ?>
                                                <a href="#" class="btn btn-danger" onclick="setUsuarioID('<?php echo $data['id_zona']; ?>', '<?php echo $data['nombre_zona']; ?>')" id="eliminarUsuarioLink" data-bs-toggle="modal" data-bs-target="#eliminarUsuarioModal"><i class="bi bi-trash-fill"></i></a>

                                            <?php
                                            }
                                            ?>
                                        </td>
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
        <!--=====================fin tabla de solicitudes=====================-->

        <!--=====================Modal - Eliminar usuario=====================-->
        <div class="modal fade" id="eliminarUsuarioModal" tabindex="-1" aria-labelledby="eliminarUsuarioModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="eliminarUsuarioModalLabel">Eliminar Usuario</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>¿Estás seguro de que deseas eliminar este usuario?</p>
                        <input type="hidden" id="idUsuario" />
                        <p>Nombre usuario: <span id="nombreUsuario"></span></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-danger" onclick="eliminarUsuario()">Eliminar</button>
                    </div>
                </div>
            </div>
        </div>


        <!--=============================== 
                Alertas
        =============================== -->

        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
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

                    <?php if (isset($_SESSION['falta'])) : ?>
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <strong>¡Disculpa!</strong> <?php echo $_SESSION['falta']; ?>
                        </div>
                        <?php unset($_SESSION['falta']); ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>

    </main>

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <script src="../script/eliminar_zona/eliminarZona.js"></script>
</body>

</html>