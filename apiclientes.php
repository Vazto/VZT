<?php
include("bd.php");

$buscar = '';

if (isset($_GET['buscar'])) {
    $buscar = $_GET['buscar'];
}

if ($buscar != '') {
    $consulta = mysqli_query($bd, "SELECT * FROM cliente WHERE Activo = 1 AND (ID_CLIENTE LIKE '%$buscar%' OR Cédula LIKE '%$buscar%' OR Nombre LIKE '%$buscar%' OR Deuda LIKE '%$buscar%' OR Contacto LIKE '%$buscar%' OR RUT LIKE '%$buscar%')");
} else {
    $consulta = mysqli_query($bd, "SELECT * FROM cliente WHERE Activo = 1");
}

$clientes = [];

while ($fila = $consulta->fetch_assoc()) {
    $clientes[] = $fila;
}

header('Content-Type: application/json');
echo json_encode($clientes);
?>