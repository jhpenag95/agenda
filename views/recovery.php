
<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer/Exception.php';
require '../PHPMailer/PHPMailer.php';
require '../PHPMailer/SMTP.php';

require_once('../conexion.php');

$email = $_POST['email'];

// Verificar que el correo electrónico es válido
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header("location: ../restablecer.php?message=invalidemail");
    exit;
}

$query = "SELECT * FROM usuarios WHERE correo = '$email' AND estado = 1";
$result = $conexion->query($query);

// Verificar que la consulta SQL fue exitosa
if (!$result) {
    header("location: ../restablecer.php?message=error");
    exit;
}

$row = $result->fetch_assoc();

if ($result->num_rows > 0) {

    $idUsuario = $row['id_usuario'];
    $encryptedId = base64_encode($idUsuario);


    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = '';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = '';                     //SMTP username
        $mail->Password   = '';                               //SMTP password
        $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom('', 'Se te olvido la contrasea?');
        $mail->addAddress($email);     //Add a recipient

        //Content
        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';                                //Set email format to HTML
        $mail->Subject = 'Recuperación contraseña';
        $mail->Body = '
        <!DOCTYPE html>
            <html>
            <head>
                <meta charset="utf-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Restablecimiento de contraseña</title>
                <style>
                * {
                    box-sizing: border-box;
                    margin: 0;
                    padding: 0;
                }
                
                body {
                    font-family: Arial, sans-serif;
                    background-color: #f8f8f8;
                }
                
                .container {
                    width: 80%;
                    max-width: 600px;
                    margin: 20px auto;
                    background-color: #fff;
                    border: 1px solid #ddd;
                    border-radius: 10px;
                    padding: 20px;
                    text-align: center;
                }
                
                h1 {
                    font-size: 36px;
                    margin-bottom: 20px;
                    color: #333;
                }
                
                img {
                    max-width: 100%;
                    height: auto;
                    margin-bottom: 20px;
                }
                
                p {
                    font-size: 18px;
                    line-height: 1.5;
                    margin-bottom: 20px;
                    color: #555;
                }
                
                .button {
                    display: inline-block;
                    font-size: 20px;
                    padding: 10px 20px;
                    background-color: #007bff;
                    color: #fff;
                    text-decoration: none;
                    border-radius: 5px;
                    transition: background-color 0.2s ease-in-out;
                }
                
                .button:hover {
                    background-color: #0056b3;
                }
                </style>
            </head>
            <body>
                <div class="container">
                <h1>Restablecimiento de contraseña</h1>
                <img src="https://illlustrations.co/static/74898b728451a18443001cffcfaf7834/ee604/119-working.png" alt="imagen de recuperar contraseña" width="400px">
                <p>
                    Hemos recibido una solicitud para restablecer la contraseña de tu cuenta. Para continuar, haz clic en el siguiente botón:
                </p>
                <p>
                     <a href="http://127.0.0.1/agenda/views/actualizarContrasena.php?id=' . $encryptedId . '" class="button">Restablecer contraseña</a>
                </p>
                <p>
                    Si no has solicitado un restablecimiento de contraseña, puedes ignorar este mensaje.
                </p>
                </div>
            </body>
            </html>
            ';
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        $mail->send();
        header("location: ../restablecer.php?message=ok");
    } catch (Exception $e) {
        header("location: ../restablecer.php?message=error");
    }
} else {
    header("location: ../restablecer.php?message=invalidemail");
}
