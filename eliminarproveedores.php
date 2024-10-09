<?php
include ("bd.php");

$id_proveedor = $_POST['id'];

$consulta = mysqli_query($bd, "UPDATE proveedor SET Activo = 0 WHERE ID_PROVEEDOR = $id_proveedor");

?>
