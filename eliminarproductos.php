<?php
include ("bd.php");

$id_producto = $_POST['id'];

$consulta = mysqli_query($bd, "UPDATE producto SET Activo = 0 WHERE ID_PRODUCTO = $id_producto");

?>
