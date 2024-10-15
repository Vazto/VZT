<?php
require_once '../funciones.php';
require_once '../conexion.php';

$fecha_inicial = $_GET['fecha_inicial'] ?? date('Y-m-d', strtotime('-30 days'));
$fecha_final = $_GET['fecha_final'] ?? date('Y-m-d');

$datosVentas = obtenerDatosVentas($conexion, $fecha_inicial, $fecha_final);
$datosProductos = obtenerDatosProductosVendidos($conexion, $fecha_inicial, $fecha_final);

echo json_encode([
    'ventas' => $datosVentas,
    'productos' => $datosProductos
]);
?>