<?php
include("bd.php");

$buscar = '';

if (isset($_GET['buscar'])) {
    $buscar = $_GET['buscar'];
}

if ($buscar != '') {
    $consulta = mysqli_query($bd, "SELECT * FROM producto WHERE Activo = 1 AND (ID_PRODUCTO LIKE '%$buscar%' OR Nombre LIKE '%$buscar%' OR Precio_Neto LIKE '%$buscar%' OR Código_de_Barras LIKE '%$buscar%' OR Descripción LIKE '%$buscar%' OR Marca LIKE '%$buscar%')");
} else {
    $consulta = mysqli_query($bd, "SELECT * FROM producto WHERE Activo = 1");
}

$productos = [];

while ($fila = $consulta->fetch_assoc()) {
    $productos[] = $fila;
}

header('Content-Type: application/json');
echo json_encode($productos);
?>