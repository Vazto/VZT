<?php
$bd = mysqli_connect("localhost","funcionario","funcionario2024") or die ("error al conectar con base de datos");
mysqli_select_db($bd, "mana")or die ("error al seleccionar la base de datos");
?>