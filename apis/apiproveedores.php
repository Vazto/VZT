<?php
include("../bd.php");

$buscar = '';

if (isset($_GET['buscar'])) {
    $buscar = $_GET['buscar'];
}

if ($buscar != '') {
    $consulta = mysqli_query($bd, "SELECT * FROM proveedor WHERE Activo = 1 AND (ID_PROVEEDOR LIKE '%$buscar%' OR Contacto LIKE '%$buscar%' OR Razón_Social LIKE '%$buscar%' OR RUT LIKE '%$buscar%')");
} else {
    $consulta = mysqli_query($bd, "SELECT * FROM proveedor WHERE Activo = 1");
}

$proveedores = [];

while ($fila = $consulta->fetch_assoc()) {
    $proveedores[] = $fila;
}

header('Content-Type: application/json');
echo json_encode($proveedores);
?>
