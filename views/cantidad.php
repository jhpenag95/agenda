<?php
include '../conexion.php';

// Llamar al procedimiento almacenado
$query = "CALL obtener_estadisticas()";
mysqli_multi_query($conexion, $query);

// Obtener resultados de la primera consulta (usuarios por rol)
if (mysqli_more_results($conexion) && mysqli_next_result($conexion)) {
    $result = mysqli_store_result($conexion);
    $row = mysqli_fetch_assoc($result);
    $total_usuarios = $row['total_usuarios'];
    mysqli_free_result($result);
}

// Obtener resultados de la segunda consulta (órdenes finalizadas)
if (mysqli_more_results($conexion) && mysqli_next_result($conexion)) {
    $result = mysqli_store_result($conexion);
    $row = mysqli_fetch_assoc($result);
    $total_ordenes_finalizadas = $row['total_ordenes_finalizadas'];
    mysqli_free_result($result);
}

// Obtener resultados de la tercera consulta (órdenes en tarea)
if (mysqli_more_results($conexion) && mysqli_next_result($conexion)) {
    $result = mysqli_store_result($conexion);
    $row = mysqli_fetch_assoc($result);
    $total_ordenes_en_tarea = $row['total_ordenes_en_tarea'];
    mysqli_free_result($result);
}


?>

<section class="info">
    <div class="info-cont">
        <p class="info-cont__title">Técnicos</p>
        <span class="info-cont__cont"><?php echo $total_usuarios; ?></span>
    </div>
    <div class="info-cont">
        <p class="info-cont__title">Fusionadores</p>
        <span class="info-cont__cont"><?php echo $total_usuarios; ?></span>
    </div>
    <div class="info-cont">
        <p class="info-cont__title">Órdenes finalizadas</p>
        <span class="info-cont__cont"><?php echo $total_ordenes_finalizadas; ?></span>
    </div>
    <div class="info-cont">
        <p class="info-cont__title">Órdenes en tarea</p>
        <span class="info-cont__cont"><?php echo $total_ordenes_en_tarea; ?></span>
    </div>
</section>