
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar contraseña</title>
    <link rel="stylesheet" href="../style/recuperar_contraseña/recuperaVista2.css">
    <link rel="stylesheet" href="../style/global.css">
    <link rel="shortcut icon" href="../assets/iconos/logo.ico" />

    <!-- Estilos CSS -->
    <?php include "../views/styles.php" ?>
</head>

<body>
    <main>
        <form method="post" action="recuperar_contrasena.php" class="form" onsubmit="return validateForm()">
            <h2 class="form-title">Recuperar contraseña</h2>
            <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
            <div class="form-group">
                <label for="new_password" class="form-label">Nueva contraseña:</label>
                <input type="password" name="new_password" id="new_password" class="form-input" required>
                <div class="invalid-feedback" id="newPassError"></div>
            </div>
            <div class="form-group">
                <label for="confirm-password" class="form-label">Confirmar nueva contraseña:</label>
                <input type="password" name="confirm-password" id="confirm-password" class="form-input" required>
                <div class="invalid-feedback" id="confirmPassError"></div>
            </div>
            <button type="submit" class="form-button">Recuperar contraseña</button>
            <a href="../index.php">Iniciar sesión</a>
        </form>

    </main>

    <script>
        function validateForm() {
            var newPass = document.getElementById("new_password").value;
            var confirmPass = document.getElementById("confirm-password").value;

            // Verificar que las contraseñas coincidan
            if (newPass !== confirmPass) {
                document.getElementById("newPassError").innerText = "Las contraseñas no son iguales, por favor revise.";
                document.getElementById("confirmPassError").innerText = "Las contraseñas no son iguales, por favor revise.";
                return false;
            }
        }
    </script>
</body>

</html>