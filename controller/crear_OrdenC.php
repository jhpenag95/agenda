<?php
session_start();

require_once '../models/crear_ordenM.php';

// Comprobamos si se ha enviado el formulario
if (isset($_POST['id_usuario']) && isset($_POST['orden']) && isset($_POST['direccion']) && isset($_POST['zona'])) {

    // Obtenemos los datos del formulario
    $idUser = $_POST['id_usuario'];
    $nOrden = $_POST['orden'];
    $direccion = $_POST['direccion'];
    $descrip = $_POST['descrip'];
    $zona = $_POST['zona'];

    date_default_timezone_set('America/Bogota');
    $fechaactual = date('Y-m-d h:i:s');

    // Validamos si la orden ya se encuentra creada
    $ordenModel = new ordenMolde();
    if ($ordenModel->ordenExists($nOrden)) {
        // Ha ocurrido un error al crear la orden
        $_SESSION['error'] = "El número de orden ya se encuentra creada";
        header("Location: ../views/crearOrden.php");
        exit();
    }

    // Creamos la orden
    $ordenCreada = $ordenModel->createOrden($idUser, $nOrden, $direccion, $descrip, $zona, $fechaactual);

    if ($ordenCreada) {
        // La orden se ha creado correctamente
        $_SESSION['success'] = "La orden se ha creado correctamente.";
        header("Location: ../views/crearOrden.php");
        exit();
    } else {
        // Ha ocurrido un error al crear la orden
        $_SESSION['error'] = "Ha ocurrido un error al crear la orden.";
        header("Location: ../views/crearOrden.php");
        exit();
    }
} else {
    // Si no se ha enviado el formulario, redirigimos a la página de crear orden
    header("Location: ../views/crearOrden.php");
    exit();
}
?>
