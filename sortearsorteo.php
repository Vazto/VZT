<?php
include("bd.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id_sorteo = $_POST['id'];

    // Get sorteo details
    $query_sorteo = mysqli_query($bd, "SELECT Cantidad_Ganadores FROM sorteo WHERE ID_SORTEO = $id_sorteo");
    $sorteo = mysqli_fetch_assoc($query_sorteo);
    $cantidad_ganadores = $sorteo['Cantidad_Ganadores'];

    // Get eligible clients (those with tickets)
    $query_clientes = mysqli_query($bd, "SELECT ID_CLIENTE FROM cliente WHERE Tickets_de_Sorteo > 0");
    $clientes_elegibles = [];
    while ($cliente = mysqli_fetch_assoc($query_clientes)) {
        $clientes_elegibles[] = $cliente['ID_CLIENTE'];
    }

    // Shuffle the array of eligible clients
    shuffle($clientes_elegibles);

    // Select winners
    $ganadores = array_slice($clientes_elegibles, 0, $cantidad_ganadores);

    // Begin transaction
    mysqli_begin_transaction($bd);

    try {
        // Update sorteo date
        mysqli_query($bd, "UPDATE sorteo SET Fecha_realización = CURDATE() WHERE ID_SORTEO = $id_sorteo");

        // Insert winners
        foreach ($ganadores as $orden => $id_cliente) {
            $orden_ganador = $orden + 1;
            mysqli_query($bd, "INSERT INTO ganador (ID_CLIENTE, ID_SORTEO, Orden) VALUES ($id_cliente, $id_sorteo, $orden_ganador)");
        }

        // Reset tickets for all clients
        mysqli_query($bd, "UPDATE cliente SET Tickets_de_Sorteo = 0");

        // Commit transaction
        mysqli_commit($bd);
        echo json_encode(["success" => true, "message" => "Sorteo realizado con éxito"]);
    } catch (Exception $e) {
        // Rollback transaction on error
        mysqli_rollback($bd);
        echo json_encode(["success" => false, "message" => "Error al realizar el sorteo: " . $e->getMessage()]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Solicitud inválida"]);
}
?>