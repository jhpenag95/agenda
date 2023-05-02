<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer/Exception.php';
require '../PHPMailer/PHPMailer.php';
require '../PHPMailer/SMTP.php';

require_once('../conexion.php');

$email = $_POST['email'];

$query = "SELECT * FROM usuarios WHERE correo = '$email' AND estado = 1";
$result = $conexion->query($query);
$row = $result->fetch_assoc();


if ($result->num_rows > 0) {
    $mail = new PHPMailer(true);

    try { 
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp-mail.outlook.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'helver248@hotmail.es';                     //SMTP username
        $mail->Password   = 'NAcho199502$&';                               //SMTP password
        $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom('helver248@hotmail.es', 'correo prueba1');
        $mail->addAddress('johanpg14@hotmail.com', 'correo prueba 2');     //Add a recipient

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'Recuperación contraseña';
        $mail->Body    = 'Hola, este es uncorreo para recuper la contraseña, por favor, visita la página <a href="localhost/cableadores/agenda/views/actualizarContrasena.php?id='.$row['id_usuario'].'">Recuperar contraseña</a>';
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        $mail->send();
        echo 'Message has been sent';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
} else {
    header('location: ../index.php');
}
