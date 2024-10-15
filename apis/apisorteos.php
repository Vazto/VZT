<?php
include("../bd.php");

$buscar = '';

if (isset($_GET['buscar'])) {
    $buscar = $_GET['buscar'];
}

if ($buscar != '') {
    $consulta = mysqli_query($bd, "SELECT s.*, GROUP_CONCAT(DISTINCT IF(g.ID_CLIENTE IS NOT NULL, c.Nombre, '') ORDER BY g.Orden SEPARATOR ', ') AS Nombres_Ganadores, COALESCE(s.Fecha_realización, '') AS Fecha_realización FROM sorteo s LEFT JOIN ganador g ON s.ID_SORTEO = g.ID_SORTEO LEFT JOIN cliente c ON g.ID_CLIENTE = c.ID_CLIENTE WHERE Activo = 1 AND (s.ID_SORTEO LIKE '%$buscar%' OR s.Premio LIKE '%$buscar%' OR s.Cantidad_Ganadores LIKE '%$buscar%' OR s.Fecha_realización LIKE '%$buscar%' OR c.Nombre LIKE '%$buscar%') GROUP BY s.ID_SORTEO");
} else {
    $consulta = mysqli_query($bd, "SELECT s.*, GROUP_CONCAT(DISTINCT IF(g.ID_CLIENTE IS NOT NULL, c.Nombre, '') ORDER BY g.Orden SEPARATOR ', ') AS Nombres_Ganadores, COALESCE(s.Fecha_realización, '') AS Fecha_realización FROM sorteo s LEFT JOIN ganador g ON s.ID_SORTEO = g.ID_SORTEO LEFT JOIN cliente c ON g.ID_CLIENTE = c.ID_CLIENTE  WHERE Activo = 1");
}

$sorteos = [];

while ($fila = $consulta->fetch_assoc()) {
    $sorteos[] = $fila;
}

header('Content-Type: application/json');
echo json_encode($sorteos);
?>