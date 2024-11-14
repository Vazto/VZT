<?php
$bd = mysqli_connect("localhost", "root", "") or die ("Error al conectar con la base de datos");
mysqli_select_db($bd, "u413739130_manabd") or die ("Error al seleccionar la base de datos");
?>