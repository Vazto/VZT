<?php
require_once '../funciones.php';
require_once '../conexion.php';

$totalVentas = getCantidadVentas($conexion);

echo json_encode(['totalVentas' => $totalVentas]);
?>