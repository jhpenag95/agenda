<?php
session_start();

require_once '../models/crear_Zona.M.php';

if (isset($_POST['zona'])) {
    $zona = $_POST['zona'];

    $zonaMoldel = new createZona();
    if ($zonaMoldel->zonaExists($zona)) {
        // Ha ocurrido un error al crear el usuario
        $_SESSION['error'] = "La zona ya se encuentra creado";
        header("Location: ../views/crearZona.php");
        exit();
    }

    // Creamos el usuario
    $zona_id = createZona::crearZona($zona);

    if ($zona_id) {
        // El usuario se ha creado correctamente
        $_SESSION['success'] = "Zona creada correctamente";
        header("Location: ../views/crearZona.php");
    } else {
        // Ha ocurrido un error al crear el usuario
        $_SESSION['error'] = "Ha ocurrido un error al crear la zona";
        header("Location: ../views/crearZona.php");
        exit();
    }
} else {
    // Si no se ha enviado el formulario, redirigimos a la página de crear usuario
    header("Location: ../views/crearZona.php");
}
