<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recueperar | contraseña</title>

    <link rel="stylesheet" href="../style/recuperar_contraseña/recuperaVista2.css">
</head>

<body>
    <main>
        <form method="post" action="recuperar_contrasena.php" class="form">
            <h2 class="form-title">Recuperar contraseña</h2>
            <div class="form-group">
                <label for="password" class="form-label">Nueva contraseña:</label>
                <input type="text" name="id" value="<?php echo $_GET['id'];?>">
                <input type="password" name="new_password" id="password" class="form-input" required>
            </div>
            <div class="form-group">
                <label for="confirm-password" class="form-label">Confirmar nueva contraseña:</label>
                <input type="password" name="confirm-password" id="confirm-password" class="form-input" required>
            </div>
            <button type="submit" class="form-button">Recuperar contraseña</button>
            <a href="index.php">Iniciar sesión</a>
        </form>
    </main>

</body>

</html>