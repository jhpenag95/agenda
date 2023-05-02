<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurar | Contraseña</title>

    <!-- Estilos CSS -->
    <link rel="stylesheet" href="style/recuperar_contraseña/recuperarContrasena.css">

</head>

<body>
    <main>
        <form method="post" action="./views/recovery.php" class="form">
            <h2 class="form-title">Recuperar contraseña</h2>
            <div class="form-group">
                <label for="email" class="form-label">Ingresa tu dirección de correo electrónico:</label>
                <input type="email" name="email" id="email" class="form-input" required>
            </div>
            <button type="submit" class="form-button">Recuperar contraseña</button>
            <a href="index.php">Iniciar sesión</a>
        </form>
    </main>
</body>

</html>