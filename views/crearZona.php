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
    <title>Crear | Zona</title>

    <!-- Estilos CSS -->
    <?php include "../views/styles.php" ?>
    
</head>

<body>
    <!--Inicio barra de gavegación-->
    <?php include "header.php" ?>
    <!--Fin barra de gavegación-->
    <main>
        <h1>Formulario de Zonas</h1>
        <form>
            <label for="zona">Nombre de la zona:</label>
            <input type="text" id="zona" name="zona">
            <button type="submit">Crear</button>
        </form>
    </main>
    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
        crossorigin="anonymous"></script>
</body>

</html>