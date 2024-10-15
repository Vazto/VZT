<?php
require_once '../funciones.php';
require_once '../conexion.php';

$ventasRecientes = getVentasRecientes($conexion);
$resultado = [];

while ($fila = mysqli_fetch_assoc($ventasRecientes)) {
    $resultado[] = $fila;
}

echo json_encode($resultado);
?>