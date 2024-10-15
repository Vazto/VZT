<?php
include ("bd.php");

$id_sorteo = $_POST['id'];

$consulta = mysqli_query($bd,"SELECT COUNT(*) AS Ganadores FROM ganador WHERE ID_SORTEO = $id_sorteo");
$fila = mysqli_fetch_assoc($consulta);
$ganadores = $fila['Ganadores'];

if ($ganadores == 0) {
    mysqli_query($bd, "DELETE FROM sorteo WHERE ID_SORTEO = $id_sorteo");
} else {
    mysqli_query($bd, "UPDATE sorteo SET Activo = 0 WHERE ID_SORTEO = $id_sorteo");
}
?>
