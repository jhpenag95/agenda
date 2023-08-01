<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar contraseña</title>

    <link rel="stylesheet" href="../style/recuperar_contrasena/recuperaVista2.css">
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
            </div>
            <div class="form-group">
                <label for="confirm-password" class="form-label">Confirmar nueva contraseña:</label>
                <input type="password" name="confirm-password" id="confirm-password" class="form-input" required>
            </div>
            <div class="alertas" id="confirmPassError"></div>
            <button type="submit" class="form-button">Recuperar contraseña</button>
            <a href="../index.php">Iniciar sesión</a>
        </form>
    </main>

    <script>
        function validateForm() {
            var newPass = document.getElementById("new_password").value;
            var confirmPass = document.getElementById("confirm-password").value;
            var confirmPassError = document.getElementById("confirmPassError");

            // Verificar que los campos no estén vacíos
            if (newPass.trim() === "" || confirmPass.trim() === "") {
                confirmPassError.innerText = "Por favor, complete todos los campos.";
                confirmPassError.style.display = "block";
                return false;
            }

            // Verificar que las contraseñas coincidan
            if (newPass !== confirmPass) {
                confirmPassError.innerText = "Las contraseñas no son iguales, por favor revise.";
                confirmPassError.style.display = "block";
                return false;
            }

            // Verificar longitud y caracteres de la contraseña
            if (newPass.length < 8 || !isValidPassword(newPass)) {
                confirmPassError.innerText = "La contraseña debe tener al menos 8 caracteres y contener mayúsculas, minúsculas y caracteres especiales.";
                confirmPassError.style.display = "block";
                return false;
            }
        }

        function isValidPassword(password) {
            // Expresión regular para verificar la contraseña
            var regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/;
            return regex.test(password);
        }
    </script>

</body>

</html>