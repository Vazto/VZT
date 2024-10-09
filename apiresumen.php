<?php
include("bd.php");
include("funciones.php");

$fechainicial = isset($_GET['fechainicial']) ? $_GET['fechainicial'] : date('Y-m-d', strtotime('-30 days'));
$fechafinal = isset($_GET['fechafinal']) ? $_GET['fechafinal'] : date('Y-m-d');

$datosVentas = obtenerDatosVentas($bd, $fechainicial, $fechafinal);
$datosProductos = obtenerDatosProductosVendidos($bd, $fechainicial, $fechafinal);

$response = [
    'etiquetasVentas' => $datosVentas['etiquetas'],
    'datosVentas' => $datosVentas['datos'],
    'nombresProductos' => $datosProductos['nombres'],
    'totalesProductos' => $datosProductos['totales']
];

echo json_encode($response);
?>
