<?php
include ("bd.php");

$id_cliente = $_POST['id'];

$consulta = mysqli_query($bd, "UPDATE cliente SET Activo = 0 WHERE ID_CLIENTE = $id_cliente");

?>
